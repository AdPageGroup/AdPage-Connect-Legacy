<?php
    
    if (!defined('ABSPATH')) exit;
    
    class AdPage {
        
        public static function campaigns() {
            
            $response = self::request('campaigns');

            if ($response->code === 200) {
                
                return $response->data;
                
            }
            
            return false;
            
        }
        
        public static function single($hash) {
            
            $response = self::request('campaign/' . $hash);

            if ($response->code === 200) {
                
                return $response->data;
                
            }
            
            return false;
            
        }
        
        public static function campaign($hash, $page = '/', $slug = false, $name = false) {
            
            $endpoint = str_replace('{HASH}', $hash, ADPGC_CONFIG['CAMPAIGN_ENDPOINT'] . '/' . $page);

            if (self::cacheExist($hash, $page)) {
                
                return self::cacheRead($hash, $page);
                
            }
            else {
                
                $campaign = file_get_contents($endpoint);
                
                $cache = self::cache($hash, $campaign, $page, $slug, $name);
                
                return $campaign;
                
            }
            
        }
        
        private static function request($endpoint, $data = [], $method = 'GET') {
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, ADPGC_CONFIG['API_ENDPOINT'] . '/' . $endpoint);
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'auth-token: ' . get_option(ADPGC_CONFIG['KEY_PARAM'])
            ]);
            
            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, []);
            }
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            
            $response = json_decode(curl_exec($ch));
            
            curl_close($ch);
            
            return $response;
                      
        }
        
        private static function cache($hash, $campaign, $page, $slug, $name) {
            
            global $wpdb;
            
            if ($page == '/') {
                $page = 'index';
            }
            
            $cache = ADPGC_CONFIG['CACHE_DIR'] . '/' . $hash . '/' . $page . '.cache.html';

            if ((!file_exists(ADPGC_CONFIG['CACHE_DIR'])) || (!is_dir(ADPGC_CONFIG['CACHE_DIR']))) {
                mkdir(ADPGC_CONFIG['CACHE_DIR']);
            }
            
            if (!file_exists(ADPGC_CONFIG['CACHE_DIR'] . '/' . $hash)) {
                mkdir(ADPGC_CONFIG['CACHE_DIR'] . '/' . $hash);
            }
            
            if (!file_exists($cache)) {
                
                $wpdb->query('INSERT INTO ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' (name, slug, hash, page, hits, timestamp) VALUES ("' . $name . '", "' . $slug . '", "' . $hash . '", "' . $page . '", "0", "' . time() . '")');
                
                file_put_contents($cache, $campaign);
            }

            return true;
            
        }
        
        private static function cacheExist($hash, $page) {
            
            if ($page == '/') {
                $page = 'index';
            }
            
            $cache = ADPGC_CONFIG['CACHE_DIR'] . '/' . $hash . '/' . $page . '.cache.html';
            
            if (file_exists($cache)) {
                
                return true;
                
            }
            
            return false;
            
        }
        
        private static function cacheRead($hash, $page) {
            
            if ($page == '/') {
                $page = 'index';
            }
            
            $cache = ADPGC_CONFIG['CACHE_DIR'] . '/' . $hash . '/' . $page . '.cache.html';
            
            return file_get_contents($cache);
            
        }
        
        public static function hash($value) {
            
            $result = str_replace('https://', '', $value);
            
            $result = str_replace('.campaign.direct', '', $result);
            
            return $result;
            
        }
        
        public static function slugAvailable($slug) {
            
            global $wpdb;
            
            if (!preg_match('/^[A-Za-z0-9-]+$/', $slug)) {
                
                return false;
                
            }
            
            if ((strlen($slug) < 4) || (strlen($slug) > 16)) {
                
                return false;
                
            }
            
            $forbidden = [
                'wp-admin',
                'wp-content',
                'wp-includes'
            ];
            
            if (in_array($slug, $forbidden)) {
                
                return false;
                
            }
            
            $data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' WHERE slug = "' . $slug . '"');
            
            if (sizeof($data) !== 0) {
                
                return false;
                
            }
            
            $response = wp_remote_get(get_site_url() . '/' . $slug);
            
            if (wp_remote_retrieve_response_code($response) !== 404) {
                
                return false;
                
            }
            
            return true;
            
        }
        
        public function hashExist($hash) {
            
            global $wpdb;
            
            $campaign_request = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . ADPGC_CONFIG['TABLE_NAME'] . ' WHERE slug = "' . $request_name . '" AND page = "' . $request_page . '"');
            
        }
        
    }
    
?>