<div class="adpage-connect">
    
    <header>
        
        <div class="container">
            
            <img src="<?= ADPGC_CONFIG['LOGO']; ?>" class="logo" />
            
            <div class="title">
                
                <h2>
                    <span class="dashicons dashicons-admin-plugins"></span>&nbsp; Connect to your AdPage-account
                </h2>
                
            </div>
            
        </div>
        
    </header>
    
    <div class="content">
        
        <div class="container">

            <div class="box-wrapper">
                
                <div class="box">
                    
                    <img src="<?= ADPGC_CONFIG['ASSET_PATH']; ?>/icons/key.svg" class="icon" />
                    
                    <h3>Enter your API-key</h3>
                    
                    <p>We need to authenticate you to AdPage through the API-key. You can create a key <a href="https://app.adpage.io/main/settings/api" target="_blank">here</a>. Don't share the key with any other plugins/websites that you don't trust. A API-key can control your account.</p>
                    
                    <form method="post">
                        
                        <label for="api_key">API-key:</label>
                        <input type="text" name="api_key" value="" placeholder="V2-xxxxx-xxxxx" id="api_key" />
                        
                        <button>Continue</button>
                        
                    </form>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    
</div>