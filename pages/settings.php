<?php
    
     $data = $api_request;
     
     $campaigns = json_decode($campaigns, true);
     
?>

<script type="text/javascript">
    
    var siteDomain = '<?php echo get_site_url(); ?>';
    
</script>

<div class="wrap" style="position: relative;">
    
    <div class="connect-set" style="display: none;">
        
        <h1>Connect your campaign</h1>
        
        <p>We need a path to display your campaign on, enter a path that you like.</p>
        
        <p><i class="connect-domain"></i></p>
        
        <form method="post" action="admin.php?page=adpage&action=connect">
            
            <input type="hidden" name="hash" value="" />
            
            <input type="text" name="path" />
            
            <input type="submit" class="button button-primary" value="Connect" />
            
        </form>
        
    </div>
    
    <h1 class="wp-heading-inline">Campaigns - <small>(<?php echo sizeof($data->campaigns); ?>)</small></h1>
    
    <a href="https://adpage.io/support" target="_blank" class="page-title-action">Need help?</a>
                    
    <hr class="wp-header-end">
    
    <?php
      
        if (!empty($data->campaigns)) {
        
    ?>
    
        <br />
        
        <?php
            
            if ($data->payment->active != true) {
                
        ?>
        
            <div class="notice notice-warning" style="margin-bottom: 0;">
                <div style="overflow: hidden;padding:20px 10px">
                    <img class="alignleft" style="margin: 0 15px 10px 0; width: 100px;" src="https://sfp-static.com/content/wordpress/plugin/images/error.svg" />
                    <h2>You don't have a payment method set in AdPage!</h2>
                    <p>That's okay but you need the Premium plan to publish campaigns. It's required to have campaigns published to show them on your WordPress website.</p>
                    <p>
                        <a href="https://app.adpage.io/dashboard/subscription">Upgrade subscription »</a>
                    </p>
                </div>
            </div>
            
        <?php
            
            }
            
        ?>
    
        <form id="posts-filter" method="get">
                    
            <table class="adpage-table wp-list-table widefat fixed striped pages">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column">
                            
                        </td>
                        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Titel</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="published" class="manage-column column-published" style="width: 150px;"></th>
                        <th scope="col" id="connected" class="manage-column column-connected" style="width: 150px;">Connection</th>
                        <th scope="col" id="date" class="manage-column column-date sortable asc"><a href="#"><span>Date</span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </thead>
    
                <tbody id="the-list">
    
                    <?php
                        
                        foreach ($data->campaigns as $campaign) {
                
                            ?>
    
                                <tr id="post-2" class="iedit author-self level-0 post-2 type-page status-publish hentry">
                                    
                                    <th scope="row" class="check-column">
                                        <label class="screen-reader-text" for="cb-select-2">Select</label>
                                        <input id="cb-select-2" type="checkbox" name="post[]" value="2">
                                    </th>
                                    <td class="title column-title has-row-actions column-primary page-title" data-colname="Titel">
                                        <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                                        <strong>
                                            <a class="row-title" href="#">
                                                <?php echo $campaign->name; ?>
                                            </a>
                                        </strong>
                                        
                                        <div class="row-actions">
                                            <?php
                                                
                                                if (isset($campaigns[$campaign->hash])) {
                                                    
                                            ?>
                                                <span class="edit">
                                                    <a href="<?php echo get_site_url() . '/' . $campaigns[$campaign->hash]['slug']; ?>" aria-label="View campaign" target="_blank">View campaign</a>
                                                </span>
                                            <?php
                                                
                                                }
                                                
                                            ?>
                                        </div>
                                    </td>
                                    <td class="author column-published" data-colname="Published">
                                        <?php
                                          
                                          if ($campaign->published == true) {
                                              
                                              echo '<i>Published on AdPage</i>';
                                              
                                          }
                                            
                                        ?>
                                    </td>
                                    <td class="author column-connected" data-colname="Connected">
                                        <?php
                                          
                                          if (isset($campaigns[$campaign->hash])) {
                                              
                                              echo '<a href="admin.php?page=adpage&action=disconnect&hash='.$campaign->hash.'" class="button">Disconnect</a>';
                                              
                                          }
                                          else {
                                              
                                              if ($campaign->published == true) {
                                                
                                                echo '<a href="#" data-hash="'.$campaign->hash.'" class="button button-primary connect_campaign">Connect</a>';
                                              
                                              }
                                              else {
                                                  
                                                echo '<a href="#" onclick="alert(\'You cannot connect this campaign to WordPress yet! Go to your AdPage dashboard and publish the campaign in order to connect it.\');" class="button button-primary">Connect</a>';  
                                              
                                              }
                                              
                                          }
                                            
                                        ?>
                                    </td>
                                    <td class="date column-date" data-colname="Datum">
                                        Published
                                        <br>
                                        <abbr title="<?php echo $campaign->uploaded; ?>">
                                            <?php echo $campaign->uploaded; ?>
                                        </abbr>
                                    </td>
                                    
                                </tr>       
                                
                            <?php
                            
                        }
                    
                    ?>
            
                </tbody>
    
            </table>
        
            </form>
            
        <?php
            
            }
            
            else {
                
        ?>
        
            <div class="card">
                
                <h2 class="title">
                    You don't have any campaigns yet!
                </h2>
                <p>
                    All campaigns that you create on AdPage will appear here. Once they're published, you're able to connect them to your WordPress website.
                </p>
            
            </div>
        
        <?php
            
            }
            
        ?>
    
    <br class="clear">
    
    <a href="admin.php?page=adpage&action=clear_cache" class="page-title-action">Clear cache</a>
    
</div>