<div class="wrap">
    
    <div class="adpage-wrap">
        
        <div class="card">
        
            <img class="logo" src="https://sfp-static.com/content/images/header-logo-light.png" />
            
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper" fill="#ffffff">
                                <path d="M25.3 20c-1.65-4.66-6.08-8-11.3-8-6.63 0-12 5.37-12 12s5.37 12 12 12c5.22 0 9.65-3.34 11.3-8H34v8h8v-8h4v-8H25.3zM14 28c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"></path>
                            </g>
                        </svg>
                    </div>
                
                    <label>Enter your API-key:</label>
                    <input name="api-key" type="text" id="api-key" value="" placeholder="V1.xxx.xxx.xxx.xxxxx" class="regular-text">
                
                    <input type="submit" value="Validate key" />
                
                </div>
            
            </form>
        
        </div>
        
    </div>
    
</div>