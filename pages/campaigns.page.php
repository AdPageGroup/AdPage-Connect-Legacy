<?php
  
    $campaigns = [];
    
    foreach (AdPage::campaigns() as $campaign) {
        
        if ($campaign->isPublished !== 0) {
            
            $campaigns[] = $campaign;
            
        }
        
    }
    
?>
<div class="adpage-connect">
    
    <header>
        
        <div class="container">
            
            <img src="<?= ADPGC_CONFIG['LOGO']; ?>" class="logo" />
            
            <div class="title">
                
                <h2>
                    <span class="dashicons dashicons-admin-home"></span>&nbsp; Connect new campaign
                </h2>
                
            </div>
            
        </div>
        
    </header>
    
    <div class="content">
        
        <div class="container">
            
            <h1>Campaigns <small>(<i><?= sizeof($campaigns); ?></i>)</small></h1>

            <p>
                This list contains live, published campaigns. In order to connect campaigns, you must publish them in your AdPage dashboard. Please note that you need a eligible membership to do that.
            </p>
            
            <br />
            
            <form id="posts-filter" method="get">
    
                <table class="adpage-table wp-list-table widefat fixed striped pages">
                    <thead>
                        <tr>
                            <th scope="col" id="title" class="manage-column column-title column-primary">Title</th>
                            <th scope="col" id="published" class="manage-column column-published" style="width: 150px;">Pages</th>
                            <th scope="col" id="connected" class="manage-column column-connected" style="width: 250px;">Cache time</th>
                            <th scope="col" id="date" class="manage-column column-date"></th>
                        </tr>
                    </thead>
        
                    <tbody id="the-list">
        
                        <?php foreach($campaigns as $campaign) { ?>
        
                            <tr id="post-2" class="iedit author-self level-0 post-2 type-page status-publish hentry">
                                
                                <td class="title column-title has-row-actions column-primary page-title" data-colname="Titel">
                                    <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                                    <strong>
                                        <a class="row-title" href="#">
                                            <?= $campaign->name; ?>
                                        </a>
                                    </strong>
                                    
                                    <div class="row-actions">
                                        <span class="edit">
                                            <a href="https://app.adpage.io/main/editor/2.0/<?= $campaign->hash; ?>?ref=adpage-connect" aria-label="Edit in AdPage" target="_blank">Edit in AdPage</a>
                                            |
                                            <a href="<?= $campaign->domains[0]->domain; ?>" aria-label="View campaign" target="_blank">View campaign</a>
                                        </span>
                                    </div>
                                </td>
                                <td class="author column-published" data-colname="Published">
                                    
                                    <?php foreach($campaign->slugs as $slug) { ?>
                                        
                                        <?php if ($slug->slug == '/') { ?>
                                        
                                            <span class="dashicons dashicons-admin-home"></span> Homepage
                                        
                                        <?php } else { ?>
                                        
                                            <span class="dashicons dashicons-media-document"></span> <?= $slug->slug; ?>
                                        
                                        <?php } ?>
                                        
                                        <br />
                                        
                                    <?php } ?>
                                    
                                </td>
                                <td class="date column-date" data-colname="Datum">
                                    <?= date(ADPGC_CONFIG['DATE_TIME_FORMAT'], $campaign->cacheTime); ?>
                                </td>
                                <td class="author column-connected" data-colname="Connected">
                                    <a href="admin.php?page=adpage&subpage=connect&campaign-hash=<?= $campaign->hash; ?>" class="button button-primary button-connect-campaign" data-hash="<?= $campaign->hash; ?>">Connect</a>
                                </td>
                            </tr>    
                                    
                        <?php } ?>
        
                    </tbody>
                    
                </table>
                
            </form>
            
        </div>
        
    </div>
    
    <div class="modals" style="display: none;">
    
        <div class="modal">
            
            <h3>Connect campaign</h3>
            <p>
                You can connect this campaign (and all pages) to a slug you want. 
                But you can only link to a slug if there isn't anything else there yet.
                A valid slug only contains letters (a-Z), numbers (0-9) and hyphens "-".
            </p>
            
            <form method="post" novalidate="novalidate">
                
                <input type="hidden" name="hash" value="" />
                
                <label for="slug">Slug</label>
                
                <p class="slug">
                    <span><?= get_site_url(); ?>/</span>
                    <input type="text" name="slug" id="slug" placeholder="my-slug" />
                </p>
                
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Connect now!">
                </p>
                
            </form>
            
            <span class="notification notification-busy" style="display: none;">
                <img src="<?= ADPGC_CONFIG['ASSET_PATH']; ?>/spinner.gif" />
                Hold on and sit tight...
            </span>
            
            <span class="notification notification-error" style="display: none;">
                <strong>Whoops!</strong> 
                <i></i>
            </span>
            
            <span class="notification notification-success" style="display: none;">
                <strong>Awesome!</strong> 
                Your campaign has been connected successfully.
            </span>
            
        </div>
        
    </div>
    
</div>