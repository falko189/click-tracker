<?php

register_activation_hook(CT_FILE, 'ct_install');

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
