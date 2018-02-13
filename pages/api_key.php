<div class="wrap">
    
    <div class="adpage-wrap">
        
        <div class="card">

            <img class="logo" src="<?php echo plugins_url('assets/images/adpage-logo.png', dirname(__FILE__)); ?>" />
            
            <h1>Get started in just a few clicks!</h1>
            <p class="info">
                In order to connect your WordPress-site to AdPage, we need you to enter your API-key, which can be found on your dashboard. Enter the key below, and we'll do the magic!
                <br /><br />
                You can create a key <a href="https://app.adpage.io/dashboard/settings?ref=wp-plugin" target="_blank">here</a> on the dashboard.
            </p>
            
            <?php
                
                if (!empty($errors)) {
                    
                    foreach ($errors as $error) {
                        
                        echo '<div class="adpage-error" style="width: 75%; margin: 25px auto 15px;">'.$error.'</div>';
                        
                    }
                    
                }
                
            ?>
            
            <form method="post" action="admin.php?page=adpage&action=set_key">
            
                <div class="connect">
                    
                    <div class="img">
                        <img src="<?php echo plugins_url('assets/images/api-key.svg', dirname(__FILE__)); ?>" />
                    </div>
                
                    <label>Enter your API-key:</label>
                    <input name="api-key" type="text" id="api-key" value="" placeholder="V1.xxx.xxx.xxx.xxxxx" class="regular-text">
                
                    <input type="submit" value="Validate key" />
                
                </div>
            
            </form>
        
        </div>
        
    </div>
    
</div>