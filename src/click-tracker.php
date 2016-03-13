<?php
/**
 * @package Click Tracker
 * Version:           0.1
 * Plugin Name: Click Tracker
 * Description:       With use of a shortcode or with a css class this plugin tracks the click in a table
 * Author:            Wesolvegroup
 * Author URI:        http://www.wesolvegroup.it
 */
global $wpdb;
// Define the complete directory path
define('CT_DIR', dirname(__FILE__));
define('CT_FILE', __FILE__);
// Define the complete directory path
define('CT_TABLE_NAME', $wpdb->prefix . 'clicktracker');
define('USERS_TABLE_NAME', $wpdb->prefix . 'users');

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
    echo 'test';
    wp_die();
    if(empty($current_user)){
        $userid = 'an';
    }else{
        $userid = $current_user->ID;
    }
    $r = $wpdb->insert(
            CT_TABLE_NAME, array(
        'userid' => $userid,
        'data' => $_POST['link-clicked'],
            )
    );
    print (!$r) ? 'Sql error' : 'id : ' . $wpdb->insert_id; //retunr like
    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_footer', 'click_tracker_js'); // Write our JS below here wp_footer

function click_tracker_js() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('.click-tracker').click(function(el) {
                //<![CDATA[
                var ajaxurl = '<?php /* TODO: this code sucks */ echo admin_url('admin-ajax.php'); ?>';
                //]]>
                var linkClicked = el.currentTarget.href;
                //console.log(el);

                var data = {
                    'action': 'click_tracker',
                    'link-clicked': linkClicked
                };

                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                $.post(ajaxurl, data, function(response) {
                    // console.log('Got this from the server: ' + response);
                }).fail(function() { console.log('err')});
            });
        });
    </script> <?php
}

if (is_admin()) {
    include_once 'install.inc.php';
    include_once 'admin.inc.php';
} else {
    include_once 'shortcodes.php';
}