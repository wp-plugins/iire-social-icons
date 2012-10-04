<?php
// Admin Page for Social Icons Widget - 09-30-2012

function iire_admin_social_widget() {
	global $wpdb;
	global $blog_id;
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";

	// UPDATE OPTIONS
	if (isset($_POST['widget_icon_theme'])){
		foreach($_POST as $k=>$v){
			if ($k != 'tab' && $k != 'submit') {
				$field .= $k."='".mysql_escape_string(trim($v))."', ";
				$value = mysql_escape_string(trim($v));		
				$wpdb->query("UPDATE ".$table_name." SET option_value = '$value' WHERE option_name = '$k'");
				//echo $k.'<br/>';
				
				if ($_POST['clone_widget_settings'] == '1' && substr($k, 0, 6) == 'widget') {	
					$scfield = substr_replace($k, 'sc', 0,6);	
					//echo $scfield.' '.$value.'<br/>';
					$wpdb->query("UPDATE ".$table_name." SET option_value = '$value' WHERE option_name = '$scfield'");								
				}
			}	
		}	
	}		
	
	// GET SETTINGS
	$settings = array();		
	$rs = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($rs as $row) {
		$settings[$row->option_name] = $row->option_value;
	}		

	// Get Admin Email
	$email = get_option('admin_email');	
	if ($email == '' || $email == $settings['email_recipient']) {
		$email = $settings['email_recipient'];
	}


	// Widget Theme
	if ($settings['widget_icon_theme'] == '') {
		$th = 'default';
	} else {
		$th = $settings['widget_icon_theme'];
	}		

	// Widget Container Orientation
	if ($settings['widget_orientation'] == 'horizontal') { $ot = 'horizontal';	} else { $ot = 'vertical'; }	

	// Widget Icon Size
	if ($settings['widget_icon_size'] == '') {
		$iconsize = 'icon48';
		$sz = '48';
	} else {
		$iconsize = 'icon'.$settings['widget_icon_size'];
		$sz = $settings['widget_icon_size'];						
	}		

	// Widget Icon Spacing	
	for ( $x = 0; $x <= 25; $x++ ) {
		if ($settings['widget_icon_spacing'] == $x) { $sp = 'sp'.$x; }
	}		

	// Widget Icon Dropshadow	
	if ($settings['widget_dropshadow'] == '1') { 
		$ds = ' dropshadow';
	} else {
		$ds = '';
	}		
	$dshz = $settings['widget_dropshadow_horizontal_offset']; 		
	$dsvt = $settings['widget_dropshadow_vertical_offset']; 
	$dsblur = $settings['widget_dropshadow_blur']; 						
	$dscolor = $settings['widget_dropshadow_color']; 

	// Widget Icon Rounded Corners		
	if ($settings['widget_roundedcorners'] == '1') {
		$rc = ' roundedcorners';
		$rctl = $settings['widget_roundedcorners_topleft'];
		$rctr = $settings['widget_roundedcorners_topright']; 
		$rcbl = $settings['widget_roundedcorners_bottomleft']; 
		$rcbr = $settings['widget_roundedcorners_bottomright']; 		
	} else {
		$rc = '';	
	}

	// Widget Icon Opacity
	$opacity = $settings['widget_icon_opacity'];	
	if ($opacity >= 10 && $opacity < 100) { 
		$op = ' opacity';
		$opval = $opacity/100;
	} else {
		$op = '';
		$opval = "100";		
	}	
	
	// Widget Icon Background Colors
	if ($settings['widget_icon_bgcolor'] == '1') {	
		$bg = ' bgcolor';
		$bup = '#'.$settings['widget_icon_bgcolor_up'];
		$bov = '#'.$settings['widget_icon_bgcolor_hover']; 
	} else {
		$bg = '';
		$bup = 'none';
		$bov = 'none'; 			
	}		
		
	//Add Classes											
	$addclasses = $iconsize.' '.$th.' '.$ot.' '.$sp.$ds.$rc.$op.$bg;
?>	

<style>
	div#viewport { width:auto; min-width:680px; min-height:360px; height:auto; padding:10px; background-color:#EDEDED; position:relative; top:0px; left:0px; background-image: url('<?php echo IIRE_SOCIAL_URL ?>/includes/images/preview_widget.png'); background-repeat:no-repeat; background-position: top right;}
	<?php echo $settings['css']; ?>	
	
	.opacity { opacity:<?php echo $opval; ?>; }

	.roundedcorners { 
		border-top-left-radius:<?php echo $rctl; ?>px;
		border-top-right-radius:<?php echo $rctr; ?>px;
		border-bottom-left-radius:<?php echo $rcbl; ?>px;		
		border-bottom-right-radius:<?php echo $rcbr; ?>px;
		-moz-border-radius-topleft:<?php echo $rctl; ?>px;
		-moz-border-radius-topright:<?php echo $rctr; ?>px;
		-moz-border-radius-bottomleft:<?php echo $rcbl; ?>px;
		-moz-border-radius-bottomright:<?php echo $rcbr; ?>px;						
		-webkit-border-top-left-radius:<?php echo $rctl; ?>px;
		-webkit-border-top-right-radius:<?php echo $rctr; ?>px; 
		-webkit-border-bottom-left-radius:<?php echo $rcbl; ?>px; 
		-webkit-border-bottom-right-radius:<?php echo $rcbr; ?>px;						 
	}

	.dropshadow { -moz-box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; -webkit-box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; }	


	/* 16 x 16 Icons */
	.icon16.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/16_sprite.png); }
	.icon16.iphone{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/16_sprite.png); }
	.icon16.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/16_sprite.png); }
	.icon16.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/16_sprite.png); }
	.icon16.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/16_sprite.png); }	
	.icon16.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/16_sprite.png); }
	.icon16.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/16_sprite.png); }	
	.icon16.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/16_sprite.png); }	
	.icon16.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/16_sprite.png); }
	.icon16.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/16_sprite.png); }	
	.icon16.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/16_sprite.png); }								
	.icon16.symbols_black{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/16_sprite.png); }
	.icon16.symbols_gray{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/16_sprite.png); }
	.icon16.symbols_white{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/16_sprite.png); }
	.icon16.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/16_sprite.png); }							
	.icon16.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/16_sprite.png); }
	.icon16.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/16_sprite.png); }
	.icon16.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/16_sprite.png); }
	.icon16.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/16_sprite.png); }
	.icon16.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/16_sprite.png); }				


	/* 24 x 24 Icons */
	.icon24.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/24_sprite.png); }
	.icon24.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/24_sprite.png); }
	.icon24.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/24_sprite.png); }
	.icon24.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/24_sprite.png); }
	.icon24.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/24_sprite.png); }	
	.icon24.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/24_sprite.png); }
	.icon24.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/24_sprite.png); }		
	.icon24.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/24_sprite.png); }	
	.icon24.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/24_sprite.png); }
	.icon24.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/24_sprite.png); }	
	.icon24.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/24_sprite.png); }								
	.icon24.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/24_sprite.png); }
	.icon24.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/24_sprite.png); }
	.icon24.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/24_sprite.png); }
	.icon24.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/24_sprite.png); }
	.icon24.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/24_sprite.png); }
	.icon24.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/24_sprite.png); }
	.icon24.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/24_sprite.png); }
	.icon24.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/24_sprite.png); }
	.icon24.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/24_sprite.png); }					


	/* 32 x 32 Icons */
	.icon32.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/32_sprite.png); }
	.icon32.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/32_sprite.png); }
	.icon32.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/32_sprite.png); }
	.icon32.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/32_sprite.png); }
	.icon32.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/32_sprite.png); }	
	.icon32.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/32_sprite.png); }
	.icon32.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/32_sprite.png); }		
	.icon32.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/32_sprite.png); }	
	.icon32.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/32_sprite.png); }
	.icon32.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/32_sprite.png); }	
	.icon32.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/32_sprite.png); }							
	.icon32.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/32_sprite.png); }
	.icon32.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/32_sprite.png); }
	.icon32.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/32_sprite.png); }
	.icon32.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/32_sprite.png); }
	.icon32.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/32_sprite.png); }
	.icon32.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/32_sprite.png); }
	.icon32.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/32_sprite.png); }
	.icon32.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/32_sprite.png); }
	.icon32.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/32_sprite.png); }					


	/* 48 x 48 Icons */
	.icon48.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/48_sprite.png); }
	.icon48.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/48_sprite.png); }
	.icon48.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/48_sprite.png); }
	.icon48.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/48_sprite.png); }
	.icon48.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/48_sprite.png); }	
	.icon48.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/48_sprite.png); }
	.icon48.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/48_sprite.png); }		
	.icon48.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/48_sprite.png); }	
	.icon48.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/48_sprite.png); }
	.icon48.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/48_sprite.png); }	
	.icon48.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/48_sprite.png); }								
	.icon48.symbols_black{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/48_sprite.png); }
	.icon48.symbols_gray{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/48_sprite.png); }
	.icon48.symbols_white{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/48_sprite.png); }
	.icon48.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/48_sprite.png); }
	.icon48.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/48_sprite.png); }
	.icon48.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/48_sprite.png); }
	.icon48.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/48_sprite.png); }
	.icon48.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/48_sprite.png); }
	.icon48.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/48_sprite.png); }					


	/* 64 x 64 Icons */
	.icon64.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/64_sprite.png); }
	.icon64.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/64_sprite.png); }
	.icon64.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/64_sprite.png); }
	.icon64.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/64_sprite.png); }		
	.icon64.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/64_sprite.png); }
	.icon64.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/64_sprite.png); }
	.icon64.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/64_sprite.png); }		
	.icon64.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/64_sprite.png); }	
	.icon64.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/64_sprite.png); }
	.icon64.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/64_sprite.png); }		
	.icon64.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/64_sprite.png); }		
	.icon64.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/64_sprite.png); }				
	.icon64.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/64_sprite.png); }
	.icon64.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/64_sprite.png); }
	.icon64.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/64_sprite.png); }
	.icon64.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/64_sprite.png); }
	.icon64.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/64_sprite.png); }
	.icon64.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/64_sprite.png); }
	.icon64.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/64_sprite.png); }
	.icon64.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/64_sprite.png); }					
		

	/* Icon Hover Colors */	
	.icon<?php echo $sz; ?>.default:hover, .icon<?php echo $sz; ?>.iphone:hover, .icon<?php echo $sz; ?>.circular_cutouts:hover, .icon<?php echo $sz; ?>.chrome_panels:hover, .icon<?php echo $sz; ?>.eco_green:hover, .icon<?php echo $sz; ?>.gold_bars:hover, .icon<?php echo $sz; ?>.post_it_notes:hover, .icon<?php echo $sz; ?>.punch_thru:hover, .icon<?php echo $sz; ?>.red_alert:hover, .icon<?php echo $sz; ?>.wood_crates:hover, .icon<?php echo $sz; ?>.stickers:hover, .icon<?php echo $sz; ?>.symbols_black, .icon<?php echo $sz; ?>.symbols_gray, .icon<?php echo $sz; ?>.symbols_white, .icon<?php echo $sz; ?>.custom1:hover, .icon<?php echo $sz; ?>.custom2:hover, .icon<?php echo $sz; ?>.custom3:hover, .icon<?php echo $sz; ?>.custom4:hover, .icon<?php echo $sz; ?>.custom5:hover { background-color: <?php echo $bov; ?>; }

	/* CHOOSE ICONS */
	li.choose { width:24px; height:24px; margin:0px; padding:0px; display: inline-table; cursor:pointer; }		
	li.choose.default { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/24_sprite.png); }	
	li.choose.iphone { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/24_sprite.png); }
	li.choose.circular_cutouts { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/24_sprite.png); }
	li.choose.chrome_panels { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/24_sprite.png); }
	li.choose.eco_green { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/24_sprite.png); }			
	li.choose.gold_bars { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/24_sprite.png); }
	li.choose.light_bulbs { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/24_sprite.png); }	
	li.choose.post_it_notes { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/24_sprite.png); }	
	li.choose.punch_thru { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/24_sprite.png); }
	li.choose.red_alert { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/24_sprite.png); }	
	li.choose.stickers { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/24_sprite.png); }						
	li.choose.symbols_black { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/24_sprite.png); }
	li.choose.symbols_gray { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/24_sprite.png); }
	li.choose.symbols_white { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/24_sprite.png); }
	li.choose.wood_crates { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/24_sprite.png); }
	li.choose.custom1 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/24_sprite.png); }
	li.choose.custom2 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/24_sprite.png); }	
	li.choose.custom3 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/24_sprite.png); }	
	li.choose.custom4 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/24_sprite.png); }	
	li.choose.custom5 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/24_sprite.png); }																	
	
	div#iire_social_widget div.move:hover { background-color: <?php echo $bov; ?>; }
</style>



<div class="wrap" style="min-width:680px;">

<div id="icon_iire"><br></div>
<h2>iiRe Social Icons - Widget Settings</h2>
<input type="hidden" id="plugin_path" name="plugin_path" value="<?php echo IIRE_SOCIAL_URL; ?>" class="w400">

<form id="settings" method="POST">

<div id="iire_social_panel_tab"><span>&raquo;</span></div>	<!-- RIGHT PANEL TAB-->

<div id="iire_social_panel_right">	<!-- START RIGHT PANEL -->

	<p id="btnholder" style="text-align:center; padding:0px; margin:20px 0px 20px 0px;"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"> <a class="reset button-secondary">Reset</a> <a href="<?php echo get_option('siteurl'); ?>" target="_blank" class="preview button-secondary" title="Preview will launch in new tab/window!">Preview</a></p>

	<div id="right_panel">	<!-- Start Right Panel Container -->
	
		<!-- Start Theme-->
		<h3 id="icon_theme"><a href="#">Icon Theme</a></h3>
		<div>
			<p><select id="widget_icon_theme" name="widget_icon_theme" class="w185">
				<?php
				$d = "../wp-content/plugins/iire-social-icons/themes/";
				$subd = glob($d . "*");
				foreach($subd as $f) {
					if(is_dir($f)) {
						$theme = str_replace($d,'',$f);
						$theme_name = ucwords(str_replace('_',' ',$theme));
						echo '<option value="'.$theme.'" ';
						if ($settings['widget_icon_theme'] == $theme ) { echo 'selected'; } 
						echo '>'.$theme_name.'</option>';
 					}
				}
				?>																
			</select></p>
			
			<p><img class="icon_theme" src="<?php echo IIRE_SOCIAL_URL; ?>themes/<?php echo $settings['widget_icon_theme']; ?>/screenshot.png" width="185" border="0" /></p>
		</div>
	
		
		<!-- Start Icon Sizes -->
		<h3 id="icon_size"><a href="#">Icon Size &amp; Spacing</a></h3>
		<div>

 			<!-- Size -->
			<p><label>Icon Size:</label>			
			<select id="widget_icon_size" name="widget_icon_size" class="w50">
				<option value="16" <?php if ($settings['widget_icon_size'] =='16') { echo 'selected'; } ?>>16</option>
				<option value="24" <?php if ($settings['widget_icon_size'] =='24') { echo 'selected'; } ?>>24</option>
				<option value="32" <?php if ($settings['widget_icon_size'] =='32') { echo 'selected'; } ?>>32</option>
				<option value="48" <?php if ($settings['widget_icon_size'] =='48') { echo 'selected'; } ?>>48</option>
				<option value="64" <?php if ($settings['widget_icon_size'] =='64') { echo 'selected'; } ?>>64</option>				
			</select> px
			</p>
			<div id="widget_size" class="slider"></div>
			
			<p>&nbsp;</p>
 			
			<!-- Spacing -->
			<p><label>Icon Spacing:</label>			
			<select id="widget_icon_spacing" name="widget_icon_spacing" class="w50">
				<?php
				for ( $x = 0; $x <= 25; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['widget_icon_spacing'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			<div id="widget_spacing" class="slider"></div>
			
		</div>
 		<!-- End Icon Sizing -->


		<!-- Start Icon Styling -->
		<h3 id="icon_styling"><a href="#">Icon Styling</a></h3>
		<div>

 			<!-- Dropshadow -->
			<p><label>Drop Shadow?</label>		
			<select id="widget_dropshadow" name="widget_dropshadow" class="w70">
				<option value="0" <?php if ($settings['widget_dropshadow'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['widget_dropshadow'] =='1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p class="ds <?php if ($settings['widget_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Shadow Color:</label>	
			<input type="text" id="widget_dropshadow_color" name="widget_dropshadow_color" value="<?php echo $settings['widget_dropshadow_color']; ?>" class="w70 color ds <?php if ($settings['widget_dropshadow'] =='0') { echo 'hidden'; } ?>">
			</p>

			<p class="ds <?php if ($settings['widget_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Horizontal Offset:</label>
			<input type="text" id="widget_dropshadow_horizontal_offset" name="widget_dropshadow_horizontal_offset" value="<?php echo $settings['widget_dropshadow_horizontal_offset']; ?>" class="w50"> px</p>			
			</p>

			<p class="ds <?php if ($settings['widget_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Vertical Offset:</label>
			<input type="text" id="widget_dropshadow_vertical_offset" name="widget_dropshadow_vertical_offset" value="<?php echo $settings['widget_dropshadow_vertical_offset']; ?>" class="w50"> px</p>				
			</p>
			
			<p class="ds <?php if ($settings['widget_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Blur:</label>
			<input type="text" id="widget_dropshadow_blur" name="widget_dropshadow_blur" value="<?php echo $settings['widget_dropshadow_blur']; ?>" class="w50"> px</p>				
			</p>							

			<p class="ds <?php if ($settings['widget_dropshadow'] == '0') { echo 'hidden'; } ?>"><br /><br /></p>
			<p>&nbsp;</p>			

	
 			<!-- Rounded Corners -->
			<p><label>Rounded Corners?</label>			
			<select id="widget_roundedcorners" name="widget_roundedcorners" class="w70">
				<option value="0" <?php if ($settings['widget_roundedcorners'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['widget_roundedcorners'] == '1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p class="rc <?php if ($settings['widget_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Top Left:</label>
			<input type="text" id="widget_roundedcorners_topleft" name="widget_roundedcorners_topleft" value="<?php echo $settings['widget_roundedcorners_topleft']; ?>" class="w50"> px</p>				
			</p>				

			<p class="rc <?php if ($settings['widget_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Top Right:</label>
			<input type="text" id="widget_roundedcorners_topright" name="widget_roundedcorners_topright" value="<?php echo $settings['widget_roundedcorners_topright']; ?>" class="w50"> px</p>			
			</p>
			
			<p class="rc <?php if ($settings['widget_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Bottom Left:</label>
			<input type="text" id="widget_roundedcorners_bottomleft" name="widget_roundedcorners_bottomleft" value="<?php echo $settings['widget_roundedcorners_bottomleft']; ?>" class="w50"> px</p>			
			</p>
			
			<p class="rc <?php if ($settings['widget_roundedcorners'] == '0') { echo 'hidden'; } ?>"><label>Bottom Right:</label>
			<input type="text" id="widget_roundedcorners_bottomright" name="widget_roundedcorners_bottomright" value="<?php echo $settings['widget_roundedcorners_bottomright']; ?>" class="w50"> px</p>
			</p>
			
			<p class="rc <?php if ($settings['widget_roundedcorners'] == '0') { echo 'hidden'; } ?>"><br /><br /></p>			
			<p>&nbsp;</p>
			
			<p><label>Background Color?</label>			
			<select id="widget_icon_bgcolor" name="widget_icon_bgcolor" class="w70">
				<option value="0" <?php if ($settings['widget_icon_bgcolor'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['widget_icon_bgcolor'] == '1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
	
 			<!-- Background Color -->
			<p class="bg <?php if ($settings['widget_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"><label>Up State:</label>	
			<input type="text" id="widget_icon_bgcolor_up" name="widget_icon_bgcolor_up" value="<?php echo $settings['widget_icon_bgcolor_up']; ?>" class="w70 bg color <?php if ($settings['widget_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"></p>

			<p class="bg <?php if ($settings['widget_icon_bgcolor'] =='0') { echo 'hidden'; } ?>"><label>Hover State:</label>	
			<input type="text" id="widget_icon_bgcolor_hover" name="widget_icon_bgcolor_hover" value="<?php echo $settings['widget_icon_bgcolor_hover']; ?>" class="w70 bg color <?php if ($settings['widget_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"></p>
			
			<p class="bg <?php if ($settings['widget_icon_bgcolor'] =='0') { echo 'hidden'; } ?>"><br />Background colors are best used with the "Symbol" themes.</p>		

			<p>&nbsp;</p>

 			<!-- Opacity -->				
			<p><label>Icon Opacity:</label>	
			<input type="text" id="op" name="widget_icon_opacity" value="<?php echo $settings['widget_icon_opacity']; ?>" class="w50"> %</p>
			<div id="widget_opacity" class="slider"></div>					
			
							
		</div> 
		<!-- End Icons Styling -->
	

		 <!-- Start Icon Links -->
		<h3 id="icon_links"><a href="#">Icon Links</a></h3>
		<div>
 			<!-- Show Title? -->
			<p><label>Show Alt/Title?</label>			
			<select id="link_title" name="link_title" class="w70">
				<option value="0" <?php if ($settings['link_title'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['link_title'] =='1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>

			<p>&nbsp;</p>
			
 			<!-- New Window? -->
			<p><label>Open in New Window?</label>			
			<select id="link_target" name="link_target" class="w70">
				<option value="_self" <?php if ($settings['link_target'] =='_self') { echo 'selected'; } ?>>No</option>
				<option value="_blank" <?php if ($settings['link_target'] =='_blank') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p>&nbsp;</p>
			
 			<!-- No Follow? -->
			<p><label>No Follow?</label>			
			<select id="link_nofollow" name="link_nofollow" class="w70">
				<option value="0" <?php if ($settings['link_nofollow'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['link_nofollow'] =='1') { echo 'selected'; } ?>>Yes</option>			
			</select>
			</p>			
		</div> 
		<!-- End Icon Links -->
	
		
		<!-- Start Icon Container -->	
		<h3 id="widget_container"><a href="#">Widget Container</a></h3>
		<div>
			<p><label class="w80">Type:</label>
			<select id="widget_orientation" name="widget_orientation" class="w100">
				<option value="horizontal" <?php if ($settings['widget_orientation'] =='horizontal') { echo 'selected'; } ?>>Horizontal</option>
				<option value="vertical" <?php if ($settings['widget_orientation'] =='vertical') { echo 'selected'; } ?>>Vertical</option>				
			</select>
			</p>
			
			<p>&nbsp;</p>
			
			<p><label>Alignment:</label>
			<select id="widget_align" name="widget_align" class="w70">
				<option value="left" <?php if ($settings['widget_align'] =='left') { echo 'selected'; } ?>>Left</option>
				<option value="right" <?php if ($settings['widget_align'] =='right') { echo 'selected'; } ?>>Right</option>	
			</select>
			</p>

			<p>&nbsp;</p>
									
			<p><label>Width:</label>
			<input type="text" id="ww" name="widget_width" value="<?php echo $settings['widget_width']; ?>" class="w50"> px</p>			
			<div id="widget_width" class="slider"></div>
			
			<p>&nbsp;</p>

			<p><label>Height:</label>
			<input type="text" id="wh" name="widget_height" value="<?php echo $settings['widget_height']; ?>" class="w50"> px</p>			
			<div id="widget_height" class="slider"></div>
			
			<p>&nbsp;</p>				
			
			<p><label>Padding Top:</label><input type="text" id="widget_pad_top" name="widget_pad_top" value="<?php echo $settings['widget_pad_top']; ?>" class="w35 inline"> px</p>
			<p><label>Padding Left:</label><input type="text" id="widget_pad_left" name="widget_pad_left" value="<?php echo $settings['widget_pad_left']; ?>" class="w35 inline"> px</p>
			<p><label>Padding Bottom:</label><input type="text" id="widget_pad_bottom" name="widget_pad_bottom" value="<?php echo $settings['widget_pad_bottom']; ?>" class="w35 inline"> px</p>		
			<p><label>Padding Right:</label><input type="text" id="widget_pad_right" name="widget_pad_right" value="<?php echo $settings['widget_pad_right']; ?>" class="w35 inline"> px</p>

			<p>&nbsp;</p>
			
			<p><label>Margin Top:</label><input type="text" id="widget_margin_top" name="widget_margin_top" value="<?php echo $settings['widget_margin_top']; ?>" class="w35 inline"> px</p>
			<p><label>Margin Left:</label><input type="text" id="widget_margin_left" name="widget_margin_left" value="<?php echo $settings['widget_margin_left']; ?>" class="w35 inline"> px</p>
			<p><label>Margin Bottom:</label><input type="text" id="widget_margin_bottom" name="widget_margin_bottom" value="<?php echo $settings['widget_margin_bottom']; ?>" class="w35 inline"> px</p>			
			<p><label>Margin Right:</label><input type="text" id="widget_margin_right" name="widget_margin_right" value="<?php echo $settings['widget_margin_right']; ?>" class="w35 inline"> px</p>
		</div>
		<!-- End Icon Container -->



		<!-- Start Widget Container -->
		<h3 id="widget_styling"><a href="#">Widget Container Styling</a></h3>
		<div>
			<!-- Add Background Color -->
			<p><label>Add Background?</label>
			<select id="widget_background" name="widget_background" class="w70">
				<option value="0" <?php if ($settings['widget_background'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['widget_background'] == '1') { echo 'selected'; } ?>>Yes</option>			
			</select>
			</p>

			<p class="addbg <?php if ($settings['widget_background'] == '0') { echo 'hidden'; } ?>">&nbsp;</p>
		
		
			<p class="addbg <?php if ($settings['widget_background'] == '0') { echo 'hidden'; } ?>"><label>Background Color:</label>	
			<input type="text" id="widget_bg_color" name="widget_bg_color" value="<?php echo $settings['widget_bg_color']; ?>" class="w70 color"></p>

			<p class="addbg <?php if ($settings['widget_background'] == '0') { echo 'hidden'; } ?>">&nbsp;</p>

			<p class="addbg <?php if ($settings['widget_background'] == '0') { echo 'hidden'; } ?>"><label>Border Size:</label>
			<select id="widget_border_size" name="widget_border_size" class="w50">
				<option value="0" <?php if ($settings['widget_border_size'] == '0') { echo 'selected'; } ?>>0</option>
				<option value="1" <?php if ($settings['widget_border_size'] == '1') { echo 'selected'; } ?>>1</option>
				<option value="2" <?php if ($settings['widget_border_size'] == '2') { echo 'selected'; } ?>>2</option>
				<option value="3" <?php if ($settings['widget_border_size'] == '3') { echo 'selected'; } ?>>3</option>
				<option value="4" <?php if ($settings['widget_border_size'] == '4') { echo 'selected'; } ?>>4</option>	
				<option value="5" <?php if ($settings['widget_border_size'] == '5') { echo 'selected'; } ?>>5</option>
				<option value="6" <?php if ($settings['widget_border_size'] == '6') { echo 'selected'; } ?>>6</option>
				<option value="7" <?php if ($settings['widget_border_size'] == '7') { echo 'selected'; } ?>>7</option>
				<option value="8" <?php if ($settings['widget_border_size'] == '8') { echo 'selected'; } ?>>8</option>
				<option value="9" <?php if ($settings['widget_border_size'] == '9') { echo 'selected'; } ?>>9</option>
				<option value="10" <?php if ($settings['widget_border_size'] == '10') { echo 'selected'; } ?>>10</option>																																																
			</select> px
			</p>			

			<p class="addbg wbs <?php if ($settings['widget_background'] == '0' || $settings['widget_border_size'] == '0' ) { echo 'hidden'; } ?>"><label>Border Color:</label>	
			<input type="text" id="widget_border_color" name="widget_border_color" value="<?php echo $settings['widget_border_color']; ?>" class="w70 color"></p>


			<p>&nbsp;</p>
			
			<p>Custom CSS:</p>				
			<textarea id="widget_css" name="widget_css" cols="20" rows="3" class="w100p h120"><?php echo $settings['widget_css']; ?></textarea>	
		</div>
		<!-- End Widget Container -->		


 		<!-- Start Email -->		
		<h3 id="email"><a href="#">Email Settings</a></h3>
		<div>
			<!-- Recipient -->
			<p><label>Recipient Email:</label>
			<input type="text" id="email_recipient" name="email_recipient" value="<?php echo $email; ?>" class="w100p">
			</p>
						
 			<!-- CC -->
			<p><label>CC:</label>			
			<input type="text" id="email_cc" name="email_cc" value="<?php echo $settings['email_cc']; ?>" class="w100p">
			</p>
			
 			<!-- BCC -->
			<p><label>BCC:</label>			
			<input type="text" id="email_bcc" name="email_bcc" value="<?php echo $settings['email_bcc']; ?>" class="w100p">
			</p>

 			<!-- Subject -->
			<p><label>Subject:</label>			
			<input type="text" id="email_subject" name="email_subject" value="<?php echo $settings['email_subject']; ?>" class="w100p">
			</p>
			
 			<!-- Message -->
			<p><label>Message:</label>	
			<textarea id="email_message" name="email_message" cols="20" rows="3" class="w100p h120"><?php echo $settings['email_message']; ?></textarea>						
			</p>			
		</div>	
		<!-- End Email -->
		
		
 		<!-- Start General -->		
		<h3 id="general"><a href="#">General Settings</a></h3>
		<div>
			<!-- Recipient -->
			<p><label>Clone Widget?</label>
			<select id="clone_widget_settings" name="clone_widget_settings" class="w70">
				<option value="0" <?php if ($settings['clone_widget_settings'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['clone_widget_settings'] =='1') { echo 'selected'; } ?>>Yes</option>			
			</select>
			<br /><br />Use the current widget settings for the shortcode?							
			</p>

			<p>&nbsp;</p>


			<!-- Add This Sharing -->
			<p><label>Add This?</label>
			<select id="addthis" name="addthis" class="w70">
				<option value="0" <?php if ($settings['addthis'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['addthis'] =='1') { echo 'selected'; } ?>>Yes</option>		
			</select></p>
			<p class="addthis2 <?php if ($settings['addthis'] == '1') { echo 'hidden'; } ?>"><br />Included the Add This sharing code with your widget?</p>
							
			<p class="addthis <?php if ($settings['addthis'] == '0') { echo 'hidden'; } ?>"><label>Analytics Key:</label>
			<input type="text" id="addthis_key" name="addthis_key" value="<?php echo $settings['addthis_key']; ?>" class="w100p">
			<br />For more information, please visit <a href="http://addthis.com" target="_blank">http://addthis.com</a></p>										
		</div>	
		<!-- End General -->
		
 		<!-- Start Registration -->		
		<h3 id="registration"><a href="#">Registration</a></h3>
		<div>
			<p><label>Your Email:</label>			
			<input id="registration_email" name="registration_email" type="text" value="<?php echo $settings['registration_email'] ?>" class="registration">
			</p>
			<p><label>Activation Key:</label>				
			<input id="registration_key" name="registration_key" type="text" value="<?php echo $settings['registration_key'] ?>" class="registration">
			</p>
			<p>&nbsp;</p>			
			<p><input type="submit" name="submit" id="activate" class="button-secondary" value="Activate Registration"></p>				
		</div>	
		<!-- End Registration -->			
			
			

	</div><!-- End Right Panel Container -->

</div>	<!-- END RIGHT PANEL -->




	<h3>Widget Designer <span class="instructions">(Double-click icon to edit link and title... Drag icon to change position... Drag to Trash to remove.)</span></h3>

	<div id="viewport">
		<?php
		$wid = 'width:'.$settings['widget_width'].'px; '; 
		$hgt = 'height:'.$settings['widget_height'].'px; ';
		
		if ($settings['widget_pad_top'] != '0' || $settings['widget_pad_right'] != '0' || $settings['widget_pad_bottom'] != '0' || $settings['widget_pad_left'] != '0') {		
			$pad = 'padding: '.$settings['widget_pad_top'].'px '.$settings['widget_pad_right'].'px '.$settings['widget_pad_bottom'].'px '.$settings['widget_pad_left'].'px; ';
		} else {
			$pad = '';			
		}	
		
		if ($settings['widget_margin_top'] != '0' || $settings['widget_margin_right'] != '0' || $settings['widget_margin_bottom'] != '0' || $settings['widget_margin_left'] != '0') {			
			$mar = 'margin: '.$settings['widget_margin_top'].'px '.$settings['widget_margin_right'].'px '.$settings['widget_margin_bottom'].'px '.$settings['widget_margin_left'].'px; ';
		} else {
			$mar = '';			
		}	
		
		if ($settings['widget_background'] == '0') {		
			$bdg = 'background: none; ';
		} else {
			$bdg = 'background-color:#'.$settings['widget_bg_color'].'; ';			
		}	
		
		if ( $settings['widget_border_size'] != '0') {
			$bor = 'border:#'.$settings['widget_border_color'].' '.$settings['widget_border_size'].'px solid;';
		} else {
			$bor = '';			
		}						
		
		echo '<div id="iire_social_widget" class="iire_social_widget" style="'.$wid.$hgt.$pad.$mar.$bdg.$bor.'">'; 
		echo stripslashes($settings['widget_icons']);		
		echo '</div>';		
		?>
		<div id="trash" title="Drop Icon to Remove"></div>
	</div> <!-- End Viewport -->

	<h3>Icons <span class="instructions">(Click an icon below to add it to the Widget Designer)</span></h3>

	<div id="chooseicons">
		<ul id="chooseicons">
			<li class="choose <?php echo $th; ?>" id="facebook" alt="https://facebook.com/stephen.russell.904" title="Facebook" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="twitter" alt="http://twitter.com/srussell13/" title="Twitter" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="linkedin" alt="http://linkedin.com/pub/stephen-russell/1/223/b82" title="Linked In" lang=""></li>		
			<li class="choose <?php echo $th; ?>" id="youtube" alt="http://youtube.com/user/iirepr2" title="You Tube" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="pinterest" alt="http://pinterest.com" title="Pinterst" lang=""></li>						
			<li class="choose <?php echo $th; ?>" id="email" alt="srussell@iireproductions.com" title="Email Me!" lang="Use the email settings for this information!"></li>
			<li class="choose <?php echo $th; ?>" id="rss" alt="<?php echo get_option('siteurl'); ?>/feed.rss" title="RSS Feed" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="favorite" alt="" title="Add to Favorites" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="link" alt="http://" title="Custom Link" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="website" alt="http://" title="Alternate Website" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="info1" alt="http://" title="More Information" lang=""></li>			
			<li class="choose <?php echo $th; ?>" id="info2" alt="http://" title="More Information" lang=""></li>	
			<li class="choose <?php echo $th; ?>" id="chat" alt="http://" title="Chat" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="contact" alt="http://" title="Contact Page" lang=""></li>			
			
			<li class="choose trial <?php echo $th; ?>" id="activerain" alt="http://activerain.com/srussell13" title="Active Rain" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="aim" alt="http://aim.com" title="AIM" lang=""></li>				
			<li class="choose trial <?php echo $th; ?>" id="amazon" alt="http://amazon.com" title="Amazon" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="android" alt="http://android.com" title="Android" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="aol" alt="http://aol.com" title="AOL" lang=""></li>	
			<li class="choose trial <?php echo $th; ?>" id="apple" alt="http://apple.com" title="Apple" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="badoo" alt="http://badoo.com" title="Badoo" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="bebo" alt="http://bebo.com" title="Bebo" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="blinklist" alt="http://blinklist.com" title="Blinklist" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="blogger" alt="http://blogger.com" title="Blogger" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="cafemom" alt="http://cafemom.com" title="Cafe Mom" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="delicious" alt="http://delicious.com" title="Delicious" lang=""></li>							
			<li class="choose trial <?php echo $th; ?>" id="deviantart" alt="http://deviantart.com" title="Deviant Art" lang=""></li>															
			<li class="choose trial <?php echo $th; ?>" id="digg" alt="http://digg.com" title="Digg" lang=""></li>		
			<li class="choose trial <?php echo $th; ?>" id="dribbble" alt="http://dribbble.com" title="Dribbble" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="feedburner" alt="http://feedburner.com" title="Feed Burner" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="flickr" alt="http://flickr.com" title="Flickr" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="friendfeed" alt="http://friendfeed.com" title="Friend Feed" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="friendster" alt="http://friendster.com" title="Friendster" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="foursquare" alt="http://foursquare.com" title="Foursquare" lang=""></li>										
			<li class="choose trial <?php echo $th; ?>" id="google" alt="http//google.com/" title="Google" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="googleplus" alt="https://plus.google.com/u/0/110362418117155780512/posts" title="Google +" lang=""></li>							
			<li class="choose trial <?php echo $th; ?>" id="gmail" alt="http//mail.google.com/" title="Gmail" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="hi5" alt="http://hi5.com" title="Hi 5" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="instagram" alt="http://instagram.com" title="Instagram" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="lastfm" alt="http://lastfm.com" title="Last FM" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="livejournal" alt="http://livejournal.com" title="Live Journal" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="microsoft" alt="http://microsoft.com" title="Microsoft" lang=""></li>	
			<li class="choose trial <?php echo $th; ?>" id="meetup" alt="http://meetup.com" title="Meet Up" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="mylife" alt="http://mylife.com" title="My Life" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="myspace" alt="http://myspace.com" title="My Space" lang=""></li>				
			<li class="choose trial <?php echo $th; ?>" id="ning" alt="http://ning.com" title="Ning" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="newsvine" alt="http://newsvine.com" title="News Vine" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="orkut" alt="http://orkut.com" title="Orkut" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="picasa" alt="http://picasa.com" title="Picasa" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="reddit" alt="http://reddit.com" title="Reddit" lang=""></li>						
			<li class="choose trial <?php echo $th; ?>" id="sharethis" alt="http://sharethis.com" title="Share This" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="skype" alt="srussell.iireproductions" title="Skype" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="slashdot" alt="http://slashdot.com" title="Slash Dot" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="slideshare" alt="http://slideshare.net" title="Slide Share" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="soundcloud" alt="http://soundcloud.com" title="Sound Cloud" lang=""></li>								
			<li class="choose trial <?php echo $th; ?>" id="spotify" alt="http://spotify.com" title="Spotify" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="stumbleupon" alt="http://stumbleupon.com" title="Stumble Upon" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="tagged" alt="http://taqged.com" title="Tagged" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="technorati" alt="http://technorati.com" title="Technorati" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="tumblr" alt="http://tumblr.com" title="Tumblr" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="vimeo" alt="http://vimeo.com" title="Vimeo" lang=""></li>	
			<li class="choose trial <?php echo $th; ?>" id="wordpress" alt="http://wordpress.com" title="Wordpress" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="xing" alt="http://xing.com" title="Xing" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="yahoo" alt="http://yahoo.com" title="Yahoo" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="yelp" alt="http://yelp.com" title="Yelp"></li>
			
			<li class="choose hidden <?php echo $th; ?>" id="addthis" alt="http://www.addthis.com/bookmark.php?v=250" title="Add This" lang=""></li>																																			
		</ul>

		<input type="hidden" id="widget_addclasses" name="widget_addclasses" value="<?php echo $addclasses; ?>" class="w400">
	</div>

<p class="submit" align="left"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes">&nbsp;&nbsp;&nbsp;<a class="reset button-secondary">Reset</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo get_option('siteurl'); ?>" target="_blank" class="preview button-secondary" title="Preview will launch in new tab/window!">Preview</a></p>

<h3>Quick Start</h3>
<ul>
<li>1. Go to "Appearance", "Widgets".</li>
<li>2. Add the "iiRe Social Media Icons" to a sidebar widget area and "Save".</li>
<li>3. Go to "iiRe Social Icons", "Widget Settings".</li>
<li>4. In the Icons section, click an icon to add it to the Widget Designer.</li>
<li>5. Repeat the previous step to add additional icons.</li>
<li>6. Double-click each icon in the Widget Designer to edit the link and title.</li>
<li>7. Click "Icon Theme" in the side panel, choose a theme i.e. "Circular Cutouts" or use the "Default" theme.</li>
<li>8. Click "Save Changes".</li>
<li>9. Click "Preview" to view the output in the section where you placed the widget!</li>
<li>To quickly reset all the settings, click "Start Over". This will reload all the default values.</li>
</ul>

<p>&nbsp;</p>


<h3>Additional Free Themes</h3>
<p>You can find <a href="http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-icons/plugins-iire-social-icons-free-themes/" target="_blank">additional free themes</a> on our website!</p>


<p>To install additional themes via FTP:<p>
<ul>
<li>1. Download the desired icon theme to your hardrive and unzip. (The name of the zip file is the name of the theme folder)</li>
<li>2. Upload the icon theme folder to the /wp-content/plugins/iire-social-icons/themes/ directory.</li>
</ul>

<p>&nbsp;</p>

<h3>Notes</h3>
<p>To use the identical settings for the shortcode generated in the Widget Designer, go to "General Settings", set "Clone Widget Settings" to "Yes" and save your changes.</p>
<p>The Widget Designer works independently!!  You can create vastly different settings for the widget (which is best used as a sidebar widget) and the shortcode (which is best used is a page or post).</p>

<textarea id="widget_icons" name="widget_icons" cols="20" rows="3" class="h150" style="width:100%; visibility: hidden;"><?php echo stripslashes($settings['widget_icons']); ?></textarea>
<textarea id="widget_output" name="widget_output" cols="20" rows="3" class="h150" style="width:100%;  visibility: hidden;"><?php echo stripslashes($settings['widget_output']); ?></textarea>
	

<!-- EDIT ICON SETTINGS -->
<div id="editdialog" title="Edit Icon Settings" style="display:none;">
	<p>Enter your site link and a title.</p>
	<p align="left">Link:&nbsp;&nbsp;<input type="text" id="choose_url" value="" class="choose_url" style="display:inline; width:250px"></p>
	<p align="left">Title: <input type="text" id="choose_title" value="" class="choose_title" style="display:inline; width:250px"></p>
	<p align="left"><span id="instructions"></span></p>
	<input type="hidden" value="" class="choose_id">
	<p align="right"><a id="edit_close" class="button-secondary">Close</a></p>			
</div>


<!-- UNLOCK DIALOG -->
<div id="unlockdialog" title="Unlock Features" style="display:none;">
	<p align="center">Please consider making a donation<br/>or upgrading to the full version<br/>to unlock this feature.</p>
	<p align="center">Visit <a href="http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-media-icons/" target="_blank">iiRe Productions</a> for more information.</p>
	<p align="right"><a id="unlock_close" class="button-secondary">Close</a></p>			
</div>

<input id="registration_version" name="registration_version" type="hidden" value="<?php echo $settings['registration_version'] ?>" class="registration">
<input id="registration_activated" name="registration_activated" type="hidden" value="<?php echo $settings['registration_activated'] ?>" class="registration">
<input id="registration_expired" name="registration_expired" type="hidden" value="<?php echo $settings['registration_expired'] ?>" class="registration">

</form>

<div id="codepreview" style="visibility: hidden;"><?php echo stripslashes($settings['widget_output']); ?></div>

</div><!-- End Settings -->

</div> <!-- End Wrap -->

<?php
}
?>