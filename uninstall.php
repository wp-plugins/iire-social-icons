<?php
// Updated - 11/01/2012

// DELETE TABLES ON DEACTIVATION
function iire_social_deactivate() {
	global $wpdb;
	global $blog_id;
		
	delete_option("iire_social_version");	
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";
	$SQL = "DROP TABLE ".$table_name;		
	mysql_query($SQL) or die("An unexpected error occured.".mysql_error());	
}



// DELETE TABLES ON UNINSTALL
function iire_social_uninstall() {
	global $iire_db_version;
	global $wpdb;
	global $blog_id;
		
	delete_option("iire_social_version");	
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";
    //$wpdb->query("DROP table IF EXISTS $table_name"); 
	$SQL = "DROP TABLE ".$table_name;		
	mysql_query($SQL) or die("An unexpected error occured.".mysql_error());	

}
?>