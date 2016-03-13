<?php

add_action('admin_menu', 'ct_settings_menu');

/**
 * Create menu item in backend
 */
function ct_settings_menu() {
    // Add main page
    add_menu_page(
            'Click Tracker', 'Click Tracker', 'manage_options', 'click-tracker', 'ct_menu_callback', 'dashicons-chart-line'
    );
}

/**
 * Admin menu callback
 * @global type $wpdb
 */
function ct_menu_callback() {

    (!empty($_POST['users'])) ? $id = $_POST['users'] : $id = '1';

    global $wpdb;
    $wpdb2 = clone $wpdb;
    $impressions = $wpdb->get_results(
            '
	SELECT *
	FROM ' . CT_TABLE_NAME . '
	WHERE userid = ' . $id
    );
    $users = $wpdb2->get_results(
            '
	SELECT ID, user_nicename
	FROM ' . USERS_TABLE_NAME . '
	'
    );
    echo '<div class="row">';
    echo '<h2>Statistics of clicks';
    echo '</div>';
    echo '<form method="post"><label for="users">' . __('Users', 'ClickTracker') . '</label><select name="users" class="user-dropdown">';
    foreach ($users as $user) {
        $selected = '';
        if ($id == $user->ID) {
            $selected = 'selected="selected"';
        }
        echo '<option value="' . $user->ID . '" ' . $selected . '>' . $user->user_nicename . '</option>';
    }
    echo '</select></form>
          <script>jQuery(".user-dropdown").change(function() {
                    jQuery(this).closest("form").submit();
          });</script>
          ';
    if (!empty($impressions)) {

        echo '<table><thead><td>' . __('Date Impression', 'ClickTracker') . '</td><td>' . __('Link Clicked', 'ClickTracker') . '</td></thead>';
        foreach ($impressions as $impression) {
            echo '<tr><td>' . $impression->time . '</td><td>' . $impression->data . '</td></tr>';
        }
        echo '</table>';
    } else {
        echo 'No impressions';
    }
}
