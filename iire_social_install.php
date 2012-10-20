<?php
// Social Icons Installation - 10-20-2012

global $iire_social_version;
$iire_social_version = "0.20";

// INSTALL/CREATE TABLES
function iire_social_install() {
	global $wpdb;
	global $iire_social_version;

	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";

	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
	option_id INT(11) NOT NULL AUTO_INCREMENT,
	option_name VARCHAR(255) NOT NULL,
	option_value VARCHAR(4096) NOT NULL,
	PRIMARY KEY  (option_id)	
	);";
	
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');		
	dbDelta($sql);	
	
	$wpdb->print_error();		

	add_option("iire_social_version", $iire_social_version);


   //Check for update
   $installed_ver = get_option( "iire_social_version" );
   if( $installed_ver != $iire_social_version ) {
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		option_id INT(11) NOT NULL AUTO_INCREMENT,
		option_name VARCHAR(255) NOT NULL,
		option_value VARCHAR(4096) NOT NULL,/
		PRIMARY KEY  (option_id)
		);";

		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');		
		dbDelta($sql);
		update_option( "iire_social_version", $iire_social_version ); // Updates WP Options table
	}   
}

function iire_update_social_check() {
    global $wpdb;
	global $iire_social_version;
	global $current_blog;
		
    if (get_site_option('iire_social_version') != $iire_social_version) {
        iire_social_install();
    }
	
	$table = $wpdb->prefix."iire_social";

	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('1', 'registration_email', '')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('2', 'registration_key', '')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('3', 'registration_activated', '')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('4', 'registration_expired', '')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('5', 'registration_version', 'FE01CE2A')");	
	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('6', 'email_recipient', 'you@yoursite.com')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('7', 'email_sender', 'webmaster@yoursite.com')");		
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('8', 'email_cc', '')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('9', 'email_bcc', '')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('10', 'email_subject', 'Contact Information')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('11', 'email_message', 'Add your message here...')");			

	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('12', 'clone_widget_settings', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('13', 'addthis', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('14', 'addthis_key', '')");						
	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('18', 'link_target', '_blank')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('19', 'link_title', '1')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('20', 'link_nofollow', '1')");
	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('21', 'css_cache', '0')");		

	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('23', 'themes', 'default;iphone;chrome_panels;circle_cutouts;eco_green;gold_bars;light_bulbs;post_it_notes;punch_thru;red_alert;stickers;symbols_black;symbols_gray;symbols_white;wood_crates;custom1;custom2;custom3;custom4;custom5')");
	
	// WIDGET	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('24', 'widget_icon_theme', 'default')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('25', 'widget_icon_size', '64')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('26', 'widget_icon_spacing', '10')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('27', 'widget_icon_opacity', '100')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('28', 'widget_icon_bgcolor', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('29', 'widget_icon_bgcolor_up', 'AAFF00')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('30', 'widget_icon_bgcolor_hover', '00AAFF')");			
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('31', 'widget_dropshadow', '1')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('32', 'widget_dropshadow_color', 'AAAAAA')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('33', 'widget_dropshadow_horizontal_offset', '3')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('34', 'widget_dropshadow_vertical_offset', '3')");		
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('35', 'widget_dropshadow_blur', '8')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('36', 'widget_roundedcorners', '1')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('37', 'widget_roundedcorners_topleft', '4')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('38', 'widget_roundedcorners_topright', '4')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('39', 'widget_roundedcorners_bottomleft', '4')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('40', 'widget_roundedcorners_bottomright', '4')");					
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('41', 'widget_orientation', 'horizontal')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('42', 'widget_align', 'left')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('43', 'widget_width', '225')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('44', 'widget_height', '350')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('45', 'widget_pad_top', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('46', 'widget_pad_left', '0')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('47', 'widget_pad_bottom', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('48', 'widget_pad_right', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('49', 'widget_margin_top', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('50', 'widget_margin_left', '0')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('51', 'widget_margin_bottom', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('52', 'widget_margin_right', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('53', 'widget_background', '0')");					
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('54', 'widget_bg_color', 'FFFFFF')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('55', 'widget_border_color', 'DDDDDD')");		
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('56', 'widget_border_size', '0')");		
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('57', 'widget_css', '')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('58', 'widget_addclasses', 'default horizontal sp10 dropshadow roundedcorners opacity icon64')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('59', 'widget_icons', '')");				
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('60', 'widget_output', '')");
	
	// SHORTCODE
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('63', 'sc_icon_theme', 'default')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('64', 'sc_icon_size', '64')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('65', 'sc_icon_spacing', '10')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('66', 'sc_icon_opacity', '100')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('67', 'sc_icon_bgcolor', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('68', 'sc_icon_bgcolor_up', 'AAFF00')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('69', 'sc_icon_bgcolor_hover', '00AAFF')");			
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('70', 'sc_dropshadow', '1')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('71', 'sc_dropshadow_color', 'AAAAAA')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('72', 'sc_dropshadow_horizontal_offset', '3')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('73', 'sc_dropshadow_vertical_offset', '3')");		
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('74', 'sc_dropshadow_blur', '8')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('75', 'sc_roundedcorners', '1')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('76', 'sc_roundedcorners_topleft', '4')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('77', 'sc_roundedcorners_topright', '4')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('78', 'sc_roundedcorners_bottomleft', '4')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('79', 'sc_roundedcorners_bottomright', '4')");					
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('80', 'sc_orientation', 'horizontal')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('81', 'sc_align', 'left')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('82', 'sc_width', '600')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('83', 'sc_height', '70')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('84', 'sc_pad_top', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('85', 'sc_pad_left', '0')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('86', 'sc_pad_bottom', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('87', 'sc_pad_right', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('88', 'sc_margin_top', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('89', 'sc_margin_left', '0')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('90', 'sc_margin_bottom', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('91', 'sc_margin_right', '0')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('92', 'sc_background', '0')");					
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('93', 'sc_bg_color', 'FFFFFF')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('94', 'sc_border_color', 'DDDDDD')");		
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('95', 'sc_border_size', '0')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('96', 'sc_css', '')");
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('97', 'sc_addclasses', 'default horizontal sp10 dropshadow roundedcorners opacity icon64')");	
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('98', 'sc_icons', '')");				
	$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('99', 'sc_output', '')");
			
}
add_action('plugins_loaded', 'iire_update_social_check');
?>