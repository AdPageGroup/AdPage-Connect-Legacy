<?php

    /*
        Plugin Name: AdPage Bridge
        Plugin URI: https://adpage.io/
        Description: Show your awesome AdPage campaigns in your WordPress-website
        Version: 1.0.0
        Author: AdPage Team
        Author URI: https://adpage.io/
    */
    
    if (!defined('ABSPATH')) exit;
    
    define('API_URL', 'https://api.adpage.io');

    add_action('parse_request', 'adpb_endpoint', 0);
    add_action('admin_menu', 'adpb_admin_pages');
    add_action('admin_enqueue_scripts', 'adpb_admin_sources');
    register_activation_hook(__FILE__, 'adpb_enable');
    register_deactivation_hook(__FILE__, 'adpb_disable');

    function adpb_admin_pages() {
    
        add_menu_page('AdPage Settings', 'AdPage', 'manage_options', 'adpage', 'adpb_admin', 'dashicons-book');
        
    }

    function adpb_enable() {

        // Create options in the database
        add_option('adpage_apikey', '');
        add_option('adpage_campaigns', '[]');
        
    }

    function adpb_disable() {
        
        // Remove options in the database
        delete_option('adpage_apikey');
        delete_option('adpage_campaigns');
        
    }
    
    function adpb_admin_sources() {
        
        // Attach the stylesheet
        wp_enqueue_style('custom_wp_admin_css', plugins_url('assets/style.css', __FILE__));
        
        // Attach the scripts
        wp_enqueue_script('custom_wp_admin_js', plugins_url('assets/scripts.js', __FILE__));
        
    }


    function adpb_admin() {

        // Set the action parameter, if any
        $action = (isset($_GET['action']) ? $_GET['action'] : '');

        // You often start without an error
        $errors = array();
        
        // Set the AdPage API-key
        if ($action == 'set_key') {

            // Validate the API-key
            if (adpb_validate_key($_POST['api-key'])->ok == true) {
                
                // Save the key if its valid
                update_option('adpage_apikey', $_POST['api-key']);
                
            }
            else {
                
                // Create an error
                $errors[] = 'This API-key is not valid!'; 
                
            }
        
        }
        
        if ($action == 'clear_cache') {

            // Count total cleared cache files
            $i = 0;

            // Get cache files from directory
            $cache_dir = glob(dirname(__FILE__) . '/cache/*');
            
            // Loop through each cache file
            foreach ($cache_dir as $cache) {
                
                // Update the counter
                $i++;
                
                // Make sure it is a file
                if (is_file($cache)) {
                    
                    // Delete the cache file
                    unlink($cache);
                
                }
                
            }
            
            // Show a message to the user
            if ($i > 0) {
                
                adpb_show_admin_message('success', 'Cache for <b>'.$i.' campaign(s)</b> has been cleared.');
                
            }
            else {
                
                adpb_show_admin_message('warning', 'There wasn\'t any cache to clear.');
                
            }

        }
        
        $api_key = get_option('adpage_apikey');

        $campaigns = get_option('adpage_campaigns');
        
        // Connect a new campaign
        if ($action == 'connect') {
            
            // Get the posted content
            $hash = $_POST['hash'];
            $path = $_POST['path'];
            
            // Path needs to be alphanumerical
            if ((ctype_alnum($path)) AND (isset($path))) {
                
                // Path needs at least 5 characters
                if (strlen($path) >= 5) {
                
                    // Retrieve all users campaigns
                    $api_request = adpb_api_request('key');
                    
                    $campaigns = json_decode($campaigns, true);
                    
                    // Loop through all campaigns
                    foreach ($api_request->campaigns as $api_campaign) {
                        
                        // Add the new campaign
                        if ($hash == $api_campaign->hash) {
                            
                            $campaigns[$hash] = array(
                                'hash' => $api_campaign->hash,
                                'title' => $api_campaign->name,
                                'path' => $api_campaign->link,
                                'slug' => $path
                            );
                            
                        }
                        
                    }
                    
                    // Update database entities
                    update_option('adpage_campaigns', json_encode($campaigns));
                    
                    // Show a messaga to the user
                    adpb_show_admin_message('success', 'Campaign has been connected successfully!');
                
                }
                else {
                    
                    // Show an error
                    adpb_show_admin_message('warning', 'Could not connect campaign, path must contain at least 5 characters.');
                    
                }
                
            }
            else {
                
                // Show an error
                adpb_show_admin_message('warning', 'Could not connect campaign, path is not alphanumerical.');
                
            }
            
        }
        
        // Disconnect a campaign
        if ($action == 'disconnect') {
            
            // The hash of the campaign to delete
            $hash = $_GET['hash'];
            
            $campaigns = json_decode($campaigns, true);
            
            $campaigns_new = array();
            
            // Loop through all results
            foreach ($campaigns as $storage_campaign) {
                
                // Remove the entity in case
                if ($hash != $storage_campaign['hash']) {
                    
                    $campaigns_new[$storage_campaign['hash']] = array(
                        'hash' => $storage_campaign['hash'],
                        'title' => $storage_campaign['title'],
                        'path' => $storage_campaign['path'],
                        'slug' => $storage_campaign['slug']
                    );
                    
                }
                
            }
            
            // Update the entities in the database
            update_option('adpage_campaigns', json_encode($campaigns_new));
            
            // Show a messaga to the user
            adpb_show_admin_message('success', 'Campaign has been disconnected successfully!');
            
        }
        
        // Get campaigns from the database
        $campaigns = get_option('adpage_campaigns');

        if (strlen($api_key) == 0) {

            // Welcome page if there isnt a API-key
            include dirname(__FILE__) . '/pages/api_key.php';
            
        }
        else {
            
            // Check if the key is valid
            $api_request = adpb_api_request('key');
            
            if ($api_request->ok == true) {
                  
                // Show the settings page
                include dirname(__FILE__) . '/pages/settings.php';
                
            }
            else {
                
                // Create and display an error
                $errors['title'] = 'The API key is no longer valid!';
                $errors['description'] = 'It seems like the provided API-key is no longer valid or access has been revoked. Create a new API-key on the AdPage dashboard.';
                
                include dirname(__FILE__) . '/pages/error.php';
                
            }
            
        }

        
    }
    
    function adpb_show_admin_message($type, $text) {
        
        // Show a messaga to the user
        echo '<div class="notice notice-'.$type.'" style="padding: 10px 15px;">'.$text.'</div>';
        
    }

    function adpb_endpoint() {
        
        global $wp;

        // Get the campaigns from the database
        $get_campaigns = json_decode(get_option('adpage_campaigns'), true);
        
        $campaign = false;
        
        // Loop through all campaigns
        foreach($get_campaigns as $value) {
            
            // If a campaign-slug matched the request-URL
            if ($value['slug'] == $wp->request) {
                
                $campaign = $value;
                
            }
            
        }
        
        // We've got a campaign to display
        if ($campaign != false) {

            // Set the HTTP-header
            header('Content-Type: text/html');
            
            // Campaign parameters from database
            $campaign_path = $campaign['path'];
            $campaign_title = $campaign['title'];
            
            // Get the campaign content
            $fetch_campaign = adpb_get_campaign($campaign_path);
            
            if ($fetch_campaign != false) {
                
                // Replace the default title
                $campaign = str_replace('<title>Live</title>', '<title>'.$campaign_title.'</title>', $fetch_campaign);
                
                // Output the campaign
                echo $campaign;
                
                exit;
                
            }
            
        }
    
    }
    
    function adpb_validate_key($key) {
        
        // Call the AdPage API
        $result = adpb_api_request($key);
        
        // Check if we've got content
        if ($result) {
            
            return $result;
            
        }
        else {
            
            return false;
            
        }
        
    }
    
    function adpb_api_request($request_key) {
        
        // Define the API-key
        if ($request_key != 'key') {
            
            $key = $request_key;
            
        }
        else {
            
            $key = get_option('adpage_apikey');
            
        }

        // Get all campaigns from AdPage
        $request = wp_remote_get(API_URL . '/info', array(
            'body'    => $data,
            'headers' => array(
                'Token' => $key,
            ),
        ));
        
        // Decode returned JSON from API
        $result = json_decode($request['body']);
        
        return $result;
        
    }
    
    function adpb_get_campaign($path) {
        
        // Create a hash from the path name
        $hash = md5($path);
        
        // Get the cache path
        $cache = dirname(__FILE__) . '/cache/'.$hash.'.html';

        // Check if the cache exist
        if (file_exists($cache)) {
            
            // Return campaign from cache
            return file_get_contents($cache);
            
        }
        else {
            
            // Download campaign from AdPage
            $campaign = ap_download_campaign($path);
            
            // Create cache dir if it doesnt exist
            if (!file_exists(dirname(__FILE__) . '/cache')) {
                
                mkdir(dirname(__FILE__) . '/cache');
                
            }
            
            // Cache the campaign locally
            file_put_contents($cache, $campaign);
            
            return $campaign;
            
        }
        
    }
    
    function adpb_download_campaign($path) {
        
        // Retrieve campaign from AdPage
        $request = wp_remote_get($path);
        
        // Get the status code
        $status_code = wp_remote_retrieve_response_code($request);
        
        // Status code tells if the campaign exists
        if (in_array($status_code, array(200, 202))) {
            
            // Return the content body
            $body = $request['body'];
            
            return $body;
            
        }
        else {
            
            return false;
            
        }
        
    }
    
?>