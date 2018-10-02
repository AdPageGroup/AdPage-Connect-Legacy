<?php
                        
    global $wpdb;

    $campaigns = $wpdb->get_results('SELECT *, COUNT(*) AS pages FROM ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' GROUP BY hash');

?>
<div class="adpage-connect">
    
    <header>
        
        <div class="container">
            
            <img src="<?= ADPGC_CONFIG['LOGO']; ?>" class="logo" />
            
            <div class="title">
                
                <h2>
                    <span class="dashicons dashicons-index-card"></span>&nbsp; Campaigns
                </h2>
                
            </div>
            
        </div>
        
    </header>
    
    <div class="content">
        
        <div class="container">
            
            <p>
                Here are your campaigns that are currently connected to AdPage. You can connect as much campaigns as you like, there's no limit!<br />
                Your campaigns are cached to your own webserver once connected. When you make changes, don't forget to clear the cache.
            </p>
            
            <br />
            
            <div class="theme-browser rendered">
                
                <div class="themes wp-clearfix">
    
                    <?php foreach ($campaigns as $campaign) { ?>
                    
                        <div class="theme active" tabindex="0" data-campaign-hash="<?= $campaign->hash; ?>">
                
                            <div class="theme-screenshot">
                                <!-- <img src="<?= ADPGC_CONFIG['ASSET_PATH']; ?>/no-thumb.png" alt=""> -->
                                <img src="https://api.miniature.io/?url=<?= $campaign->hash; ?>.campaign.direct" alt="">
                            </div>
                
                            <span class="more-details">
                                <a href="https://<?= $campaign->hash; ?>.campaign.direct" target="_blank" style="text-decoration: none; color: #fff;">View campaign</a>
                            </span>
                
                            <div class="theme-id-container">
                
                                <h2 class="theme-name">
                                    <?= (strlen($campaign->name) > 20 ? substr($campaign->name, 0, 20).'...' : $campaign->name) ?>
                                </h2>
                
                                <div class="theme-actions">
                                    <a class="button button-delete" href="<?= get_site_url(); ?>/adpgc-disconnect" data-hash="<?= $campaign->hash; ?>">Disconnect</a>
                                    <a class="button button-primary" href="<?= get_site_url(); ?>/<?= $campaign->slug; ?>" target="_blank">View</a>
                                </div>
                                
                            </div>
                        </div>
                        
                    <?php } ?>
                    
                    <div class="theme add-new-theme">
                        <a href="admin.php?page=adpage&subpage=campaigns">
                            <div class="theme-screenshot"><span></span></div>
                            <h2 class="theme-name">Connect new campaign</h2>
                        </a>
                    </div>
                
                </div>
            
            </div>
            
        </div>
        
    </div>
    
</div>