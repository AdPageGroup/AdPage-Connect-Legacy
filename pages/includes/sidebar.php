<div id="postbox-container-1" class="postbox-container">
    
    <div class="postbox">
        <h2 class="hndle">
            <span>Cache</span>
        </h2>
        <div class="inside">
            When a campaign is shown for the first time, the plugin will cache it locally to speed-up your campaigns.
            <br /><br />
            Once you modify your campaign at AdPage, you need to clear the cache so the new version will be shown.
        </div>
        <div id="major-publishing-actions">
            <a href="admin.php?page=adpage&action=clear_cache" class="button button-primary" style="float: right;">Clear cache</a>
            <div class="clear"></div>
        </div>
    </div>
   
    <div class="postbox">
        <h2 class="hndle">
            <span>My account</span>
        </h2>
        <div class="inside">
            <ul class="details account-details">
                <li>
                    <span class="dashicons dashicons-admin-users"></span> <?php echo $data->user->username; ?>
                </li>
                <li>
                    <span class="dashicons dashicons-email"></span> <?php echo $data->user->email; ?>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="postbox">
        <h2 class="hndle">
            <span>Payment settings</span>
        </h2>
        <div class="inside">
            <ul class="details account-details">
                <li>
                    <span class="dashicons dashicons-money"></span> <?php echo ($data->payment->active == true ? 'Active' : 'Inactive'); ?>
                </li>
                <li>
                    <span class="dashicons dashicons-controls-repeat"></span> Next payment: <?php echo $data->payment->next_payment; ?>
                </li>
            </ul>
        </div>
    </div>
    
</div>