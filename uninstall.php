<?php
// Updated - 10/20/2012
global $iire_db_version;

// INSTALL/CREATE TABLES
function iire_social_uninstall() {
	global $wpdb;
	delete_option("iire_social_version");	
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";
    $wpdb->query("DROP table IF EXISTS $table_name"); 
}
?>