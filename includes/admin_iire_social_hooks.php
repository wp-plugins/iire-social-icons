<?php
// Admin Social Hooks - 11-01-2012

function iire_social_admin_pages() {
	add_menu_page('iiRe Social Icons', 'iiRe Social Icons', 'administrator', 'iire_admin_social_home', 'iire_admin_social_home');
	add_submenu_page('iire_admin_social_home', 'Widget Settings', 'Widget Settings', 10, 'iire_admin_social_widget', 'iire_admin_social_widget');
	add_submenu_page('iire_admin_social_home', 'Shortcode Settings', 'Shortcode Settings', 10, 'iire_admin_social_shortcode', 'iire_admin_social_shortcode');			
}
add_action('admin_menu', 'iire_social_admin_pages');


function iire_social_admin_enable_js() {
    if (is_admin() && (($_GET['page'] == 'iire_admin_social_widget') || ($_GET['page'] == 'iire_admin_social_shortcode'))  ){
		wp_enqueue_script( 'color-picker', IIRE_SOCIAL_URL.'includes/admin_colorpicker.js');
		wp_enqueue_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js');
    }
	
	 if (is_admin() && ($_GET['page'] == 'iire_admin_social_widget')){
		wp_enqueue_script( 'social-widget', IIRE_SOCIAL_URL.'includes/admin_iire_social_widget.js');
	}

	 if (is_admin() && ($_GET['page'] == 'iire_admin_social_shortcode')){
		wp_enqueue_script( 'social-widget', IIRE_SOCIAL_URL.'includes/admin_iire_social_shortcode.js');
	}		
}
add_action('admin_print_scripts', 'iire_social_admin_enable_js');


function iire_social_admin_enable_styles() {
    if ( is_admin() && (($_GET['page'] == 'iire_admin_social_widget') || ($_GET['page'] == 'iire_admin_social_shortcode')) ){
		wp_enqueue_style( 'jquery-ui_css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css');
    }
}
add_action( 'admin_print_styles', 'iire_social_admin_enable_styles' );


function iire_social_admin_register_head() {
    if (is_admin() && (($_GET['page'] == 'iire_admin_social_widget') || ($_GET['page'] == 'iire_admin_social_shortcode') || ($_GET['page'] == 'iire_admin_social_home'))){
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_URL.'includes/admin_iire_social_styles.css" />';
	}

    if (is_admin() && (($_GET['page'] == 'iire_admin_social_widget') || ($_GET['page'] == 'iire_admin_social_shortcode'))){
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_URL.'includes/iire_social_icons16.css" />';
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_URL.'includes/iire_social_icons24.css" />';
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_URL.'includes/iire_social_icons32.css" />';
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_URL.'includes/iire_social_icons48.css" />';
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_URL.'includes/iire_social_icons64.css" />';
    }			
}
add_action('admin_head', 'iire_social_admin_register_head');
?>