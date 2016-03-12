<?php

// Register sidebar menu
add_action('admin_menu', 'ct_settings_menu');

function ct_settings_menu() {
    // Add main page
    add_menu_page(
            'Click Tracker', 'Click Tracker', 'manage_options', 'click-tracker', 'ct_menu_callback', 'dashicons-chart-line'
    );
}

function ct_menu_callback() {
    
    (!empty($_POST['users']))?  $id = $_POST['users']: $id = '1';
    
    global $wpdb;
    $fivesdrafts = $wpdb->get_results( 
	"
	SELECT *
	FROM ".CT_TABLE_NAME."
	WHERE userid = $id 
	"
);
var_dump($_POST['users']);
    echo "<div class='row'>";
    echo "<h2>Statistics of clicks";
    echo "</div>";
    echo '<form method="post"><label for="users"><select name="users" class="user-dropdown">
  <option value="2">Pippo</option>
  <option value="1">Admin</option>
  <option value="3">Pluto</option>
  <option value="4">Federico Rossi</option>
</select></form>
<script>
jQuery(".user-dropdown").change(function() {
    jQuery(this).closest("form").submit();
});
</script>
';
    
foreach ( $fivesdrafts as $fivesdraft ) 
{
	echo $fivesdraft->data;
}
}
