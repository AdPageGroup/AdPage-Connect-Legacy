<?php
    
     $data = $api_request;
     
     $campaigns = json_decode($campaigns, true);
     
?>

<script type="text/javascript">
    
    var siteDomain = '<?php echo get_site_url(); ?>';
    
</script>

<div class="adpage-header">
    <img src="<?php echo plugins_url('assets/images/adpage-logo.png', dirname(__FILE__)); ?>" />
</div>

<div class="wrap" style="position: relative;">
    
    <div class="connect-set" style="display: none;">
        <div class="connect-set-base">
            
            <img src="<?php echo plugins_url('assets/images/connect.svg', dirname(__FILE__)); ?>" />
            
            <h1>Connect your campaign</h1>
            
            <p>We need a path to display your campaign on, enter a path that you like.</p>
            
            <p><i class="connect-domain"></i></p>
            
            <form method="post" action="admin.php?page=adpage&action=connect">
                
                <input type="hidden" name="hash" value="" />
                
                <input type="text" name="path" />
                
                <input type="submit" class="button button-primary" value="Connect" />
                
            </form>
            
        </div>
    </div>
    
    <h1 class="wp-heading-inline">Campaigns - <small>(<?php echo sizeof($data->campaigns); ?>)</small></h1>
    
    <a href="https://adpage.io/support" target="_blank" class="page-title-action">Need help?</a>
                    
    <hr class="wp-header-end">
    
    <?php
      
        if (!empty($data->campaigns)) {
        
    ?>
    
        <br />
    
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <?php include dirname(__FILE__) . '/includes/campaigns.php'; ?>
                    <?php include dirname(__FILE__) . '/includes/sidebar.php'; ?>
                </div>
            </div>
        
        <?php
            
            }
            
            else {
                
        ?>
        
            <div class="no-campaigns">
                
                <img src="<?php echo plugins_url('assets/images/frown.svg', dirname(__FILE__)); ?>" />
                
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

</div>