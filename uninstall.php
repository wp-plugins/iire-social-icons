<?php
// Social Icons Installation  (Demo Version) - 06-12-2013

// UNINSTALL
function iire_social_uninstall() {
	global $iire_db_version;
	global $wpdb;
	global $blog_id;
		
	delete_option("iire_social_version");
	delete_option("iire_social_data");			
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";
	$SQL = "DROP TABLE ".$table_name;		
	mysql_query($SQL) or die("An unexpected error occured.".mysql_error());	
}
?>