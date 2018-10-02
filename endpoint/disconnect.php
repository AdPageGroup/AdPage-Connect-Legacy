<?php
  
    $hash = $_GET['hash'];
    
    if (!is_user_logged_in()) {
        
        adpgc_json_response([
            'ok' => false,
            'error' => 'You must be logged-in to do that!'
        ]);
        
    }
    
    if (!current_user_can('administrator')) {
        
        adpgc_json_response([
            'ok' => false,
            'error' => 'You must be a admin to do that!'
        ]);
        
    }
    
    if ((!isset($hash)) || (!ctype_alnum($hash))) {
        
        adpgc_json_response([
            'ok' => false,
            'error' => 'Campaign hash seems invalid!'
        ]);
        
    }
    
    $campaign_request = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' WHERE hash = "' . $hash . '"');
    
    if (!empty($campaign_request)) {
        
        foreach ($campaign_request as $campaign) {
            
            $directory = ADPGC_CONFIG['CACHE_DIR'] . '/' . $campaign->hash;
            
            $cache = $directory . '/' . $campaign->page . '.cache.html';
            
            if (file_exists($cache)) {
                
                unlink($cache);
                
            }
            
        }
        
        rmdir($directory);
        
        $wpdb->get_results('DELETE FROM ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' WHERE hash = "' . $hash . '"');
        
        adpgc_json_response([
            'ok' => true,
            'error' => 'Disconnected campaign successfully!'
        ]);
        
    }
    
    adpgc_json_response([
        'ok' => false,
        'error' => 'Campaign hash does not exist!'
    ]);
    
?>