<?php
  
    $request = explode('/', $wp->request);
        
    $request_name = $request[0];
    $request_page = (isset($request[1]) ? $request[1] : 'index');
    
    $campaign_request = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' WHERE slug = "' . $request_name . '" AND page = "' . $request_page . '"');
    
    if (!empty($campaign_request)) {
        
        $campaign = $campaign_request[0];
        
        $wpdb->query('UPDATE ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' SET hits = hits + 1 WHERE id = ' . $campaign->id);
        
        echo AdPage::campaign(
            $campaign->hash,
            $request_page
        );
        
        exit;
        
    }
    
?>