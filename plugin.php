<?php

    /*
                      _  _____
            /\       | ||  __ \
           /  \    __| || |__) |__ _   __ _   ___
          / /\ \  / _` ||  ___// _` | / _` | / _ \
         / ____ \| (_| || |   | (_| || (_| ||  __/
        /_/    \_\\__,_||_|    \__,_| \__, | \___|
                                       __/ |
        Create great landingpages!    |___/

        
        Plugin Name: AdPage Connect
        Plugin URI: https://adpage.io/
        Description: Show your awesome AdPage campaigns in your WordPress-website
        Version: 2.0.0
        Author: Team AdPage
        Author URI: https://github.com/jordivantuil
        
    */

    if (!defined('ABSPATH')) exit;
    
    define('ADPGC_CONFIG', [
        'API_ENDPOINT' => 'https://api.adpage.io',
        'CAMPAIGN_ENDPOINT' => 'https://{HASH}.campaign.direct',
        'KEY_PARAM' => 'adpage_key',
        'TABLE_NAME' => 'adpage',
        'LOGO' => 'https://campaign-static.com/content/images/logo/svg/light.svg',
        'ASSET_PATH' => plugins_url('assets/images', __FILE__),
        'CACHE_DIR' => __DIR__ . '/cache',
        'DATE_TIME_FORMAT' => get_option('date_format') . ' ' . get_option('time_format')
    ]);
    
    include 'adpage.class.php';

    add_action('parse_request', 'adpgc_endpoint', 0);
    add_action('admin_menu', 'adpgc_admin_pages');
    add_action('admin_enqueue_scripts', 'adpgc_admin_sources');
    
    register_activation_hook(__FILE__, 'adpgc_enable');
    register_deactivation_hook(__FILE__, 'adpgc_disable');
    
    function adpgc_enable() {

        global $wpdb;

        add_option(ADPGC_CONFIG['KEY_PARAM'], '');
        
        $database = str_replace(
            [
                '[TABLE_NAME]', '[TABLE_CHARSET]'
            ],
            [
                $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'],
                $wpdb->get_charset_collate()
            ],
            file_get_contents(__DIR__ . '/database.sql')
        );
        
        $wpdb->query($database);
        
    }
    
    function adpgc_disable() {
        
        global $wpdb;

        delete_option(ADPGC_CONFIG['KEY_PARAM']);
        
        $wpdb->query('DROP TABLE ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME']);
        
    }
    
    function adpgc_admin_pages() {

        add_menu_page('AdPage Settings', 'AdPage', 'manage_options', 'adpage', 'adpgc_admin', plugins_url('assets/images/icon.svg', __FILE__), 4);
        
    }
    
    function adpgc_admin() {
        
        $subpage = (isset($_GET['subpage']) ? $_GET['subpage'] : null);
        
        $ap_key = get_option(ADPGC_CONFIG['KEY_PARAM']);
        
        switch ($subpage) {
            
            case 'campaigns':
            
                $page_content = 'pages/campaigns.page.php';
                break;
                
            default:
            
                $page_content = 'pages/home.page.php';
            
                if ((strlen($ap_key) == 0) || (!isset($ap_key))) {
                    
                    $page_content = 'pages/key.page.php';
                    
                    if (isset($_POST['api_key'])) {
                        
                        update_option(ADPGC_CONFIG['KEY_PARAM'], $_POST['api_key']);
                        
                        if (AdPage::campaigns() !== false) {
                        
                            $page_content = 'pages/key_ready.page.php';
                            
                        }
                        else {
                            
                            update_option(ADPGC_CONFIG['KEY_PARAM'], '');
                            
                            $page_content = 'pages/key.page.php';
                            
                        }
                        
                    }
                    
                }
                
                break;
            
        }
        
        include $page_content;
        
    }
    
    function adpgc_endpoint() {
        
        global $wp;
        global $wpdb;
        
        switch ($wp->request) {
            
            case 'adpgc-connect':
            
                include 'endpoint/connect.php';
                break;
                
            case 'adpgc-disconnect':
            
                include 'endpoint/disconnect.php';
                break;
            
            default:
            
                include 'endpoint/default.php';
            
        }        
        
    }
    
    function adpgc_admin_sources() {
        
        if ((isset($_GET['page']) ? $_GET['page'] : null) == 'adpage') {
        
            wp_enqueue_style('custom_wp_admin_css', plugins_url('assets/style.css', __FILE__));
            wp_enqueue_script('custom_wp_admin_js', plugins_url('assets/scripts.js', __FILE__));
            
        }
        
    }
    
    function adpgc_json_response($data) {
        
        header('Content-Type: application/json');
        
        $response = json_encode($data);
        
        echo $response;
        
        exit;
        
    }
    
?>