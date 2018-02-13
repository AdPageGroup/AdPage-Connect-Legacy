<div id="post-body-content">
    
    <?php if ($data->payment->active != true) { ?>
        
        <div class="notification">
            
            <img src="<?php echo plugins_url('../assets/images/error.svg', dirname(__FILE__)); ?>" />
            
            <span>
                <b>Whoops!</b> Your current AdPage-subscription isn't premium. Without a premium subscription, you can't publish campaigns.
            </span>
            
        </div>
            
    <?php } ?>
    
    <?php 
        
        foreach ($notices as $notice) {
            
            ?>
            
            <div class="notification">
            
                <img src="<?php echo plugins_url('../assets/images/error.svg', dirname(__FILE__)); ?>" />
                
                <span>
                    <b>Notice!</b> <?php echo $notice; ?>
                </span>
                
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
    
</div>