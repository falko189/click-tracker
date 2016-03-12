<?php
/**
 * @package Click Tracker
 * Version:           0.1
 * Plugin Name: Click Tracker
 * Description:       The #1 Coming Soon Page, Under Construction & Maintenance Mode plugin for WordPress.
 * Author:            Wesolvegroup
 * Author URI:        http://www.wesolvegroup.it
 */


global $wpdb;
// Define the complete directory path
define('CT_DIR', dirname(__FILE__));
// Define the complete directory path
define('CT_TABLE_NAME', $wpdb->prefix . 'clicktracker');

add_action('wp_ajax_click_tracker', 'click_tracker_callback');
/**
 * 
 * @global type $current_user
 * @global type $wpdb
 * @return type int Id
 */
function click_tracker_callback() {
    global $current_user;
    global $wpdb;
    
    $r = $wpdb->insert(
            CT_TABLE_NAME, array(
        'userid' => $current_user->ID,
        'data' => $_POST['link-clicked'],
            )
    );
    if($r){
        
    }
    ($r)? "Sql error":"id : " . $wpdb->insert_id;
    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_footer', 'click_tracker_js'); // Write our JS below here wp_footer

function click_tracker_js() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            jQuery('.click-tracker').click(function(el) {
                //<![CDATA[
                var ajaxurl = '<?php /* TODO: this code sucks */ echo admin_url('admin-ajax.php'); ?>';
                //]]>
                var linkClicked = el.currentTarget.href;
                console.log(el);

                var data = {
                    'action': 'click_tracker',
                    'link-clicked': linkClicked
                };

                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function(response) {
                    // console.log('Got this from the server: ' + response);
                });
            });
        });
    </script> <?php
}

///////////// INSTALL PLUGIN /////////////
function ct_install() {
    global $wpdb;

    $table_name = CT_TABLE_NAME;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    userid tinytext NOT NULL,
    data varchar(255) DEFAULT '' NOT NULL,
    UNIQUE KEY id (id)
  ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

function ct_install_data() {
    
}

register_activation_hook(__FILE__, 'ct_install');
register_activation_hook(__FILE__, 'ct_install_data');
