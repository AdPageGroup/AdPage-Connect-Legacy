<?php
  
    $hash = $_POST['hash'];
    $slug = $_POST['slug'];
    
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
    
    if (AdPage::slugAvailable($slug) !== true) {
        
        adpgc_json_response([
            'ok' => false,
            'error' => 'Chosen slug is not available!'
        ]);
        
    }
    
    $campaign = AdPage::single($hash); 
    
    if (!$campaign) {
        
        adpgc_json_response([
            'ok' => false,
            'error' => 'Could not fetch campaign data!'
        ]);
        
    }            
        
    $domain = $campaign->domains[0]->domain;
        
    $hash = AdPage::hash($domain);

    $i = 0;

    foreach ($campaign->slugs as $slug_data) {
        
        if ($i == 0) {
            $page_slug = '/';
        }
        else {
            $page_slug = $slug_data->slug_striped;
        }
        
        AdPage::campaign(
            $hash,
            $page_slug,
            $slug,
            $campaign->name
        );
        
        $i++;
        
    }
    
    adpgc_json_response([
        'ok' => true
    ]);  
    
?>