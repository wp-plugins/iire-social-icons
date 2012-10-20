// IIRE SOCIAL SHORTCODE  - 10/20/2012 - 9:00 PM

jQuery(document).ready(function() {
	var plugin_path =jQuery("input#plugin_path").val(); 
	var pu = getCookie("Plugin Path");
	if (pu =='' || pu == undefined) {
		setCookie("Plugin Path", plugin_path);
	}

	var validKey = '118390C1AL';
	var ww = jQuery("input#ww").val();
	var wh = jQuery("input#wh").val();
	
	var iconsize = jQuery("div.move").height();

	var pad_top = jQuery("input#sc_pad_top").val();
	var pad_left = jQuery("input#sc_pad_left").val();
	var pad_bottom = jQuery("input#sc_pad_bottom").val();
	var pad_right = jQuery("input#sc_pad_right").val();

	function viewPort()	{
		var e = window, a = 'inner';
		if ( !( 'innerWidth' in window ) ) {
			a = 'client';
			e = document.documentElement || document.body;
		}
		return { width : e[ a+'Width' ] , height : e[ a+'Height' ] }
	}

	
	// WINDOW SIZE - INITIAL
	var minwidth = 680;
	var wd = jQuery(window).width();
	var wdvp = viewPort().width;
	var scrollbar =  viewPort().width - jQuery(window).width();
	
	var wide = wd-scrollbar-450;
	if (wide < minwidth) {
		jQuery("div.wrap").width(minwidth+'px');
	} else {	
		jQuery("div.wrap").width(wd-scrollbar-450+'px');
	}
	var expanded = wd-scrollbar-200; //165 - 250	
	
	
	// WINDOW SIZE - ON CHANGE
	window.onresize = function() {
		var minwidth = 680;
		var wd = jQuery(window).width();
		var wdvp = viewPort().width;
		var scrollbar =  viewPort().width - jQuery(window).width();
	
		var wide = wd-scrollbar-450;
		if (wide < minwidth) {
			jQuery("div.wrap").width(minwidth+'px');
		} else {	
			jQuery("div.wrap").width(wd-scrollbar-450+'px');
		}
		var expanded = wd-scrollbar-200; //165 - 250	
	};	



	// COLLAPSE/EXPAND RIGHT PANEL
	jQuery('#iire_social_panel_tab').bind('click', function() {
		if (jQuery("#iire_social_panel_right").hasClass('closed')) {														
			jQuery("#iire_social_panel_right").animate({"right": "+=260px"}, "slow").removeClass('closed');
			jQuery(this).animate({"right": "+=260px"}, "slow");
			jQuery("#iire_social_panel_tab span").empty().html('&raquo;');

			jQuery("div.wrap").animate({"width": ""+wide+"px"}, "slow");			
		} else {
			jQuery("#iire_social_panel_right").animate({"right": "-=260px"}, "slow").addClass('closed'); //Open
			jQuery(this).animate({"right": "-=260px"}, "slow");
			jQuery("#iire_social_panel_tab span").empty().html('&laquo;');

			jQuery("div.wrap").animate({"width": ""+expanded+"px"}, "slow");			
		}
	});	
	



	// UPDATE TEXT AREAS
	function updateTextAreas() {
		jQuery("div.move").removeAttr("style");
		var currenticons = jQuery('div#iire_social_shortcode').html()		
		jQuery('textarea#sc_icons').val(currenticons);
		var codepreview = jQuery('div#codepreview').html();
		jQuery('textarea#sc_output').val(codepreview);	
		return;
	}



	// VIEWPORT ICON - SINGLE CLICK
	jQuery('div.move').live('click', function(e) {
		var id = jQuery(this).attr('id');  					// facebook
		var url = jQuery(this).attr('href');				// http://facebook.com  
		var title = jQuery(this).attr('title');				// Facebook
		jQuery("input.choose_url").val(url);
		jQuery("input.choose_title").val(title);
		jQuery("input.choose_id").val(id);			
	});

	// CHANGE URL
	jQuery('input.choose_url').live('change', function(e) {
		e.preventDefault();		
		var id = jQuery('input.choose_id').val();  			
		var url = jQuery('input.choose_url').val();			
 		jQuery("div#"+id+"").attr('href', url);
 		jQuery("a."+id+"").attr('href', url);
		updateTextAreas();		
	});


	// CHANGE TITLE
	jQuery('input.choose_title').live('change', function(e) {
		e.preventDefault();		
		var id = jQuery('input.choose_id').val();  			
		var title = jQuery('input.choose_title').val();			
 		jQuery("div#"+id+"").attr('title', title);
 		jQuery("a."+id+"").attr('title', title);
		updateTextAreas();		
	});


	// CHOOSE ICON - EDIT - DOUBLE CLICK
	jQuery('div.move').live('dblclick', function() {
		var id = jQuery(this).attr('id'); 
		var url = jQuery(this).attr('href');  
		var title = jQuery(this).attr('title');
		jQuery("input.choose_url").val(url);
		jQuery("input.choose_title").val(title);
		jQuery("input.choose_id").val(id);

		if (id == 'email') {
			jQuery("h3#email").trigger('click');
			alert("Fill out the email details in the sidebar.");
			return;
		}

		if (id == 'favorite') {
			alert("No settings needed for Add To Favorites!");			
			return;
		}

		jQuery("#editdialog").dialog( "destroy" );
		jQuery("#editdialog").dialog({
			resizable: false,
			draggable: true,
			width: 320,
			height: 200,
			modal: true,
    		buttons: {}			
		});
	});
	
	jQuery('a#edit_close').live('click', function() {
		jQuery("#editdialog").dialog( "close" );
	});		
	
	// CHOOSE ICON - UPDATE FIELDS ON MOUSE ENTER
	jQuery('div.move').live('mouseenter', function() {
		var id = jQuery(this).attr('id'); 
		var url = jQuery(this).attr('href');  
		var title = jQuery(this).attr('title');
		jQuery("input.choose_url").val(url);
		jQuery("input.choose_title").val(title);
		jQuery("input.choose_id").val(id);
	});	


	// ICON OPACITY ON MOUSE ENTER
	jQuery('div.opacity').live('mouseenter', function() {
		jQuery(this).css("opacity", "1.00");			
	});	

	// ICON OPACITY ON MOUSE OUT
	jQuery('div.opacity').live('mouseout', function() {
		var op = jQuery("input#op").val();
		jQuery(this).css("opacity", op/100);			
	});	


	// CHOOSE ICON - ADD TO VIEWPORT
	jQuery('li.choose').bind('click', function(e) {
		e.preventDefault();
		
		var regEmail = jQuery('input#registration_email').val();
		var regValue = jQuery('input#registration_key').val();
		var regKey = unrotate13(rotate13(regValue));	
		var trial = jQuery(this).hasClass('trial');
		if (trial == true) {
			if ((regKey != validKey) || (regEmail == '') ) {
				jQuery("h3#registration").trigger('click');			
				jQuery("#unlockdialog").dialog( "destroy" );
				jQuery("#unlockdialog").dialog({
					resizable: false,
					draggable: true,
					width: 320,
					height: 200,
					modal: true,
    				buttons: {}			
				});			
				return;	
			}	
		}	
		
		var id = jQuery(this).attr('id');  						// facebook
		var url = jQuery(this).attr('alt');						// http://facebook.com  
		var title = jQuery(this).attr('title');					// Facebook
		var instructions = jQuery(this).attr('lang');			// Type your Facebook URL here	
		var ac = jQuery('input#sc_addclasses').val();			// Current CSS selection
		var sz = jQuery('select#sc_icon_size').val();			// Size for the output icons
		var tar = jQuery('select#link_target').val();			// Link Target - Yes = New Window
		var showtitle = jQuery('select#link_title').val();		// Link Title - Yes = Show The Link Title
		
		var nf = jQuery('select#link_nofollow').val();			// Link Rel - 1 = No Follow
		if (nf == '1') {
			var rel= ' rel="nofollow" ';	
		} else {
			var rel= '';			
		}
		
		jQuery("input.choose_url").val(url);
		jQuery("input.choose_title").val(title);
		jQuery("input.choose_id").val(id);		
		jQuery('span#instructions').text(instructions);		

		var currenticons = jQuery('div#iire_social_shortcode').html();
		var addicon = '<div id="'+id+'" class="move '+id+sz+' '+ac+'" title="'+title+'" href="'+url+'"></div>';

		jQuery('div#iire_social_shortcode').empty();
		jQuery('div#iire_social_shortcode').append(currenticons+addicon);
		jQuery('textarea#sc_icons').val(currenticons+addicon);			
		
		var outputcode =jQuery('div#codepreview').html();
		
		switch(id) {
			case 'email':	
				var outputicon = '<div id="'+id+'" class="'+ac+' '+id+sz+' sendemail" title="'+title+'" rel="nofollow"></div>';
				break;	
			case 'favorite':	
				var outputicon = '<div id="'+id+'" class="'+ac+' '+id+sz+'" title="'+title+'" rel="nofollow"></div>';
				break;		
			case 'addthis':	
				var outputicon = '<a id="'+id+'" href="http://www.addthis.com/bookmark.php?v=250" class="'+id+' addthis_button '+ac+' '+id+sz+'" title="'+title+'" rel="nofollow">&nbsp;</a>';
				break;				
			default:
				var outputicon = '<a href="'+url+'" target="_blank"'+rel+'class="'+id+'"><div id="'+id+'" class="'+ac+' '+id+sz+'" title="'+title+'"></div></a>';		
		} // End Switch		
	
		jQuery('div#codepreview').html(outputcode+outputicon);
		jQuery('textarea#sc_output').val(outputcode+outputicon);		
	});
		   

	// ACTIVATE REGISTRATION
	jQuery('input#activate').bind('click', function(e) {
		var regEmail = jQuery('input#registration_email').val();
		var regValue = jQuery('input#registration_key').val();
		if (regValue == '' || regEmail == '') {
			e.preventDefault();				
			alert('Please enter your activation key and email address!');
			return;
		}
		var regKey = unrotate13(rotate13(regValue));	
		if (regKey != validKey) {
			e.preventDefault();		
			alert('This does not appear to be a valid activation key!');		
			return;	
		}
		var regActDate = jQuery('input#registration_activated').val();
		if (regActDate == '') {
			var today = jQuery.now();	
			jQuery('input#registration_activated').val(today);
		}		
		alert('Activation successful!');		
	});	

	jQuery('a#unlock_close').live('click', function() {
		jQuery("#unlockdialog").dialog( "close" );
	});	




	// Accordian
 	jQuery("#right_panel").accordion({ 
		autoHeight: false
	});

	var actab = getCookie("Accordian Tab");
	if (actab !='' && actab != undefined) {
		jQuery("h3#"+actab+"").trigger('click');
		jQuery('#right_panel h3.ui-state-active').addClass("panel_active");	
		jQuery('#right_panel h3.ui-state-active a').addClass("panel_active");		
	}

	// Accordian Header
	jQuery('#right_panel h3').bind('click', function(e) {
		var id = jQuery(this).attr('id');
		setCookie("Accordian Tab", id);
		jQuery('h3').removeClass("panel_active");
		jQuery(this).addClass("panel_active");
	});		

	// Sliding Option Panel
	jQuery('a.toggle_iire_social_panel').bind('click', function() {
		jQuery('#iire_social_panel').slideToggle("slow");
		jQuery(this).toggleClass("active");
	});	


	function reorderIcons(currenticons) {
		var tar = jQuery('select#link_target').val();			// Link Target - Yes = New Window
		var showtitle = jQuery('select#link_title').val();		// Link Title - Yes = Show The Link Title
		
		var nf = jQuery('select#link_nofollow').val();			// Link Rel - 1 = No Follow
		if (nf == '1') {
			var rel= ' rel="nofollow" ';	
		} else {
			var rel= '';			
		}		

		var outputicons = '';
		
		jQuery('textarea#widget_output').val('');		
		jQuery('div#codepreview').empty();		
		
		jQuery('div.move').each(function(){
			jQuery(this).removeAttr("style");
			var id = jQuery(this).attr('id'); 		
		   	var title = jQuery(this).attr('title');										 
		   	var url = jQuery(this).attr('href');							 
			var icon = jQuery(this)[0].outerHTML;
		
			switch(id) {
				case 'email':	
					outputicons = outputicons+icon;
					break;
				case 'favorite':	
					outputicons = outputicons+icon;
					break;					
				case 'addthis':	
					outputicons = outputicons+'<a id="'+id+'" href="http://www.addthis.com/bookmark.php?v=250" class="'+id+' addthis_button '+jQuery('input#widget_addclasses').val()+' '+id+jQuery('select#widget_icon_size').val()+'" title="'+title+'" rel="nofollow">&nbsp;</a>';
					break;				
				default:
					outputicons = outputicons+'<a href="'+url+'" target="'+tar+'"'+rel+'class="'+id+'">'+icon+'</a>';		
			}	
		});			

		jQuery('div#codepreview').append(outputicons);
		jQuery('textarea#widget_output').val(outputicons);				
		return;
	}



	// Sortable icons
	jQuery(function() {
		jQuery( "#iire_social_shortcode" ).sortable( {
			tolerence: 'pointer',
			dropOnEmpty: true,
			opacity: 0.6,
			cursor: 'move',
    		update: function() {
				var currenticons = jQuery('div#iire_social_shortcode').html();
				jQuery('textarea#sc_icons').val(currenticons);
				reorderIcons(currenticons);				
			}
		});
		jQuery("#iire_social_shortcode").sortable("option", "containment", "#viewport");		
		
		jQuery("#trash").droppable({
			tolerence: 'touch',						 
    		drop: function() {
				var id = jQuery("input.choose_id").val();
				jQuery("div#iire_social_shortcode div#"+id+"").remove();
				jQuery("div#codepreview a."+id+"").remove()
				jQuery("div#codepreview div#"+id+"").remove();

				updateTextAreas();

				jQuery("input.choose_url").val('');
				jQuery("input.choose_title").val('');
				jQuery("input.choose_id").val('');					
			}			
		});
		
	});
	


	// ICONS - CHANGE THEME
	jQuery('select#sc_icon_theme').bind('change', function() {
		var theme = jQuery(this).val();
		var allthemes = "default iphone circular_cutouts chrome_panels eco_green gold_bars light_bulbs post_it_notes punch_thru red_alert stickers symbols_black symbols_gray symbols_white wood_crates";
		var imgsrc = plugin_path+'themes/'+theme+'/screenshot.png';
		jQuery("img.icon_theme").attr("src", imgsrc );

		adjustRoundedCornersSize(wis);			

		jQuery("div.move").removeClass(allthemes);
		jQuery("div.move").addClass(theme);
		
		jQuery("li.choose").removeClass(allthemes);
		jQuery("li.choose").addClass(theme);	
		
		if (theme == 'punch_thru' || theme == 'post_it_notes' || theme == 'stickers' || theme == 'eco_green') {
			jQuery(".ds").addClass("hidden");
			jQuery("select#sc_dropshadow").val("0");
			jQuery(".rc").addClass("hidden");			
			jQuery("select#sc_roundedcorners").val("0");			
		}			
		
		jQuery('div.move').each(function(){
		   	var id = jQuery(this).attr('id');							 
			jQuery(this).removeClass(allthemes);
			jQuery(this).addClass(theme);
			jQuery("div#codepreview div#"+id).removeClass(allthemes);
			jQuery("div#codepreview div#"+id).addClass(theme);
			
			if (theme == 'punch_thru' || theme == 'post_it_notes' || theme == 'stickers' || theme == 'eco_green') {
				jQuery(this).removeClass('dropshadow').removeClass('roundedcorners');
				jQuery("div#codepreview div#"+id).removeClass('dropshadow').removeClass('roundedcorners');
			}	
		});	

		updateTextAreas();			
	});		
		



	// ICONS - CHANGE SIZE
	jQuery('select#sc_icon_size').bind('change', function() {
		var wis = jQuery(this).val();
		jQuery("div.move").removeClass("icon16 icon24 icon32 icon48 icon64");
		jQuery("div.move").addClass("icon"+wis+"");
		jQuery('div.move').each(function(){
		   	var id = jQuery(this).attr('id');							 
			var ids = id+"16 "+id+"24 "+id+"32 "+id+"48 "+id+"64 ";  
			jQuery(this).removeClass(ids);
			jQuery(this).addClass(""+id+wis+"");
			
			jQuery("div#codepreview div#"+id).removeClass(ids);
			jQuery("div#codepreview div#"+id).removeClass("icon16 icon24 icon32 icon48 icon64");				
			jQuery("div#codepreview div#"+id).addClass(""+id+wis+"");
			jQuery("div#codepreview div#"+id).addClass("icon"+wis+"");	
		});

		adjustRoundedCornersSize(wis);
		updateTextAreas();				
	});		


	// Icons Slider - Change Size
	var wis = jQuery("select#sc_icon_size").val();
	if (wis == 16) { var sStep = 0; }
	if (wis == 24) { var sStep = 1; }
	if (wis == 32) { var sStep = 2; }
	if (wis == 48) { var sStep = 3; }	
	if (wis == 64) { var sStep = 4; }
	
	var sliderValue = [16, 24, 32, 48, 64];	
	jQuery("#sc_size").slider({
		min: 0,
		max:4,
		value: sStep,
		step: 1,	
	   	slide: function(event, ui) {
        	jQuery("select#sc_icon_size").val(sliderValue[ui.value]);
    	},
     	change: function (event, ui) {
			jQuery("div.move").removeClass("icon16 icon24 icon32 icon48 icon64");
			jQuery("div.move").addClass("icon"+sliderValue[ui.value]+"");
			jQuery('div.move').each(function(){
			   	var id = jQuery(this).attr('id');							 
				var ids = id+"16 "+id+"24 "+id+"32 "+id+"48 "+id+"64 ";  
				jQuery(this).removeClass(ids);
				jQuery(this).addClass(""+id+sliderValue[ui.value]+"");
			
				jQuery("div#codepreview div#"+id).removeClass(ids);
				jQuery("div#codepreview div#"+id).removeClass("icon16 icon24 icon32 icon48 icon64");				
				jQuery("div#codepreview div#"+id).addClass(""+id+sliderValue[ui.value]+"");
				jQuery("div#codepreview div#"+id).addClass("icon"+sliderValue[ui.value]+"");	
			});

			adjustRoundedCornersSize(sliderValue[ui.value]);
			updateTextAreas();			
     	}			
	});


	function adjustRoundedCornersSize(wis) {
		if (wis == 16) {
			var rs = 1;				
			var tr = 64;
		}	
		if (wis == 24) {
			var rs = 2;
			var tr = 64;			
		}	
		if (wis == 32) {
			var rs = 3;				
			var tr = 64;	
		}	
		if (wis == 48) {
			var rs = 5;	
			var tr = 64;			
		}	
		if (wis == 64) {
			var rs = 6;
			var tr = 64;			
		}	

		jQuery("div.move").removeClass("roundedcorners");	

		var theme = jQuery('select#sc_icon_theme').val();
		if (theme == 'circular_cutouts' || theme == 'red_alert') {
			var rs = wis/2;
		}		
		
		jQuery("input#sc_roundedcorners_topleft").val(rs);
		jQuery("input#sc_roundedcorners_topright").val(rs);
		jQuery("input#sc_roundedcorners_bottomleft").val(rs);
		jQuery("input#sc_roundedcorners_bottomright").val(rs);
	
		var rounded = "-webkit-border-top-left-radius: "+rs+"px; -webkit-border-top-right-radius: "+rs+"px; -webkit-border-bottom-left-radius: "+rs+"px; -webkit-border-bottom-right-radius: "+rs+"px; border-top-left-radius: "+rs+"px; border-top-right-radius: "+rs+"px; border-bottom-left-radius: "+rs+"px; border-bottom-right-radius: "+rs+"px; -moz-border-radius-topleft: "+rs+"px; -moz-border-radius-topright: "+rs+"px; -moz-border-radius-bottomleft: "+rs+"px; -moz-border-radius-bottomright: "+rs+"px;";  

		jQuery("<style type='text/css'> div.move{ "+rounded+" } </style>").appendTo("head");
		
		jQuery("div.move").addClass("roundedcorners");			

		jQuery("#trash").css("height",  ""+tr+"px").css("width", ""+tr+"px");	
		return;
	}	



	
	// ICONS - CHANGE SPACING
	jQuery('select#sc_icon_spacing').bind('change', function() {
		var tsp = jQuery(this).val();
		jQuery("div.move").removeClass("sp0 sp1 sp2 sp3 sp4 sp5 sp6 sp7 sp8 sp9 sp10 sp11 sp12 sp13 sp14 sp15 sp16 sp17 sp18 sp19 sp20 sp21 sp22 sp23 sp24 sp25");
		jQuery("div.move").addClass("sp"+tsp+"");
		jQuery('div.move').each(function(){
			var id = jQuery(this).attr('id');							 
			jQuery("div#codepreview div#"+id).removeClass("sp0 sp1 sp2 sp3 sp4 sp5 sp6 sp7 sp8 sp9 sp10 sp11 sp12 sp13 sp14 sp15 sp16 sp17 sp18 sp19 sp20 sp21 sp22 sp23 sp24 sp25");
			jQuery("div#codepreview div#"+id).addClass("sp"+tsp+"");
		});	
		updateTextAreas();		
	});
		
	// Icons Slider - Change Spacing
	var wsp = jQuery("select#sc_icon_spacing").val();	
	jQuery("#sc_spacing").slider({
		range: "min",
		min: 0,
		max: 25,
		value: wsp,	
	   	slide: function(event, ui) {
        	jQuery("select#sc_icon_spacing").val(ui.value);
    	},
     	change: function (event, ui) {
			jQuery("div.move").removeClass("sp0 sp1 sp2 sp3 sp4 sp5 sp6 sp7 sp8 sp9 sp10 sp11 sp12 sp13 sp14 sp15 sp16 sp17 sp18 sp19 sp20 sp21 sp22 sp23 sp24 sp25");
			jQuery("div.move").addClass("sp"+ui.value+"");
			
			jQuery('div.move').each(function(){
		   		var id = jQuery(this).attr('id');							 
				jQuery("div#codepreview div#"+id).removeClass("sp0 sp1 sp2 sp3 sp4 sp5 sp6 sp7 sp8 sp9 sp10 sp11 sp12 sp13 sp14 sp15 sp16 sp17 sp18 sp19 sp20 sp21 sp22 sp23 sp24 sp25");
				jQuery("div#codepreview div#"+id).addClass("sp"+ui.value+"");
			});	
			
			updateTextAreas();				
     	}		
	});




	// ICONS - DROP SHADOW
	jQuery('select#sc_dropshadow').bind('change', function() {
		var ds = jQuery(this).val();
		if (ds == '0') {
			jQuery("div.move").removeClass("dropshadow");
			jQuery(".ds").addClass("hidden");
			jQuery('div.move').each(function(){
		   		var id = jQuery(this).attr('id');							 
				jQuery("div#codepreview div#"+id).removeClass("dropshadow");
			});				
		} else {
			jQuery("div.move").addClass("dropshadow");
			jQuery(".ds").removeClass("hidden");
			jQuery('div.move').each(function(){
		   		var id = jQuery(this).attr('id');							 
				jQuery("div#codepreview div#"+id).addClass("dropshadow");
			});				
		}
		updateTextAreas();		
	});
	
	function setDropShadowParms() {
		var hz =  jQuery("select#sc_dropshadow_horizontal_offset").val();
		var vt =  jQuery("select#sc_dropshadow_vertical_offset").val();
		var bl =  jQuery("select#sc_dropshadow_blur").val();
		var dsc = jQuery('input#sc_dropshadow_color').val();
		jQuery("div.move").css("box-shadow", ""+hz+"px "+vt+"px "+bl+"px #"+dsc+"");
		jQuery("div.move").css("-webkit-box-shadow", ""+hz+"px "+vt+"px "+bl+"px #"+dsc+"");
		jQuery("div.move").css("-moz-box-shadow", ""+hz+"px "+vt+"px "+bl+"px #"+dsc+"");		
		return;
	}
	
	jQuery('select.ds, input#sc_dropshadow_color').bind('change', function() {
		setDropShadowParms();
	});




	// ICONS - ROUNDED CORNERS
	jQuery('select#sc_roundedcorners').bind('change', function() {
		var rc = jQuery(this).val();
		if (rc == '0') {
			jQuery("div.move").removeClass("roundedcorners");
			jQuery("select.rc").addClass("hidden");
			jQuery("p.rc").addClass("hidden");
			jQuery('div.move').each(function(){
		   		var id = jQuery(this).attr('id');							 
				jQuery("div#codepreview div#"+id).removeClass("roundedcorners");
			});	
		} else {
			jQuery("div.move").addClass("roundedcorners");
			jQuery("select.rc").removeClass("hidden");
			jQuery("p.rc").removeClass("hidden");
			jQuery('div.move').each(function(){
		   		var id = jQuery(this).attr('id');							 
				jQuery("div#codepreview div#"+id).addClass("roundedcorners");
			});				
		}
		updateTextAreas();		
	});	

	jQuery('select.rc').bind('change', function() {
		setRoundedCornersParms();
	});

	function setRoundedCornersParms() {
		var tl =  jQuery("input#sc_roundedcorners_topleft").val();
		var tr =  jQuery("input#sc_roundedcorners_topright").val();
		var bl =  jQuery("input#sc_roundedcorners_bottomleft").val();
		var br =  jQuery("input#sc_roundedcorners_bottomright").val();
	
		jQuery("div.move").css("border-top-left-radius", ""+tl+"px");
		jQuery("div.move").css("-webkit-border-top-left-radius", ""+tl+"px");
		jQuery("div.move").css("-moz-border-radius-topleft", ""+tl+"px");
		jQuery("div.move").css("border-top-right-radius", ""+tr+"px");
		jQuery("div.move").css("-webkit-border-top-right-radius", ""+tr+"px");
		jQuery("div.move").css("-moz-border-radius-topright", ""+tr+"px");
		jQuery("div.move").css("border-bottom-left-radius", ""+bl+"px");
		jQuery("div.move").css("-webkit-border-bottom-left-radius", ""+bl+"px");
		jQuery("div.move").css("-moz-border-radius-bottomleft", ""+bl+"px");
		jQuery("div.move").css("border-bottom-right-radius", ""+br+"px");
		jQuery("div.move").css("-webkit-border-bottom-right-radius", ""+br+"px");
		jQuery("div.move").css("-moz-border-radius-bottomright", ""+br+"px");		
		return;
	}		
	





	// ICONS - BACKGROUND COLOR / HOVER
	jQuery('select#sc_icon_bgcolor').bind('change', function() {
				 
		var bg = jQuery(this).val();
		if (bg == '0') {
			jQuery("div.move").removeClass("bgcolor").removeAttr("style");
			jQuery(".bg").addClass("hidden");
			jQuery('div.move').each(function(){
		   		var id = jQuery(this).attr('id');							 
				jQuery("div#codepreview div#"+id).removeClass("bgcolor").removeAttr("style");
			});					
		} else {
			jQuery("div.move").addClass("bgcolor");
			jQuery(".bg").removeClass("hidden");
		
			jQuery('div.move').each(function(){
		   		var id = jQuery(this).attr('id');							 
				jQuery("div#codepreview div#"+id).addClass("bgcolor");
			});				
		}
	
		updateTextAreas();

		if (bg == '0') {
			jQuery("input#submit").trigger('click');
		}
	});
	

	// ICONS - BACKGROUND COLOR / HOVER
	jQuery('input#sc_icon_bgcolor_up').bind('change', function() {
		var bgc =  jQuery(this).val();
		jQuery("div.move").css("background-color", "#"+bgc+"");
	});																 

	// ICONS - BACKGROUND UP
	jQuery('div.move').bind('mouseout', function() {
		var usebg =  jQuery('sc_icon_bgcolor').val();
		if (usebg == '1') {												 
			var bgu =  jQuery('input#sc_icon_bgcolor_up').val();
			jQuery("div.move").css("background-color", "#"+bgu+"");
		}
	});		

	// ICONS - BACKGROUND HOVER
	jQuery('div.move').bind('mouseover', function() {
		var usebg =  jQuery('sc_icon_bgcolor').val();
		if (usebg == '1') {														  
			var bgo =  jQuery('input#sc_icon_bgcolor_hover').val();
			jQuery("div.move").css("background-color", "#"+bgo+"");
		}
	});																 

	

	// ICONS - OPACITY
	var op = jQuery("input#op").val();		
	jQuery("#sc_opacity").slider({
		range: "min",
		min: 10,
		max: 100,
		value: op,	
	   	slide: function(event, ui) {
        	jQuery("input#op").val(ui.value);
    	},								   
     	change: function (event, ui) {
			jQuery("div.move").css("opacity", ui.value/100);
     	}
	});
	
	// Icon Opacity	
	jQuery('input#op').bind('change', function(e) {
		var p = jQuery(this).val();
		jQuery("div.move").css("opacity", p/100);	
	});	
	


	// Shortcode Container Width
	jQuery("#sc_width").slider({
		range: "min",
		min: 20,
		max: 920,
		value: ww,	
	   	slide: function(event, ui) {
        	jQuery("input#ww").val(ui.value);
    	},								   
     	change: function (event, ui) {
			jQuery("#iire_social_shortcode").css("width", ui.value + "px");
			jQuery("#iire_social_shortcode").css("height", "250px");			
     	}
	});

	// Shortcode Container Width
	jQuery('input#ww').bind('change', function(e) {
		var w = jQuery(this).val();
		jQuery("#iire_social_shortcode").css("width", w + "px");
		jQuery("#iire_social_shortcode").css("height", "250px");				
	});		
	

	// Shortcode Container Height
	jQuery("#sc_height").slider({
		range: "min",
		min: 20,
		max: 750,
		value: wh,									
    	slide: function(event, ui) {
        	jQuery("input#wh").val(ui.value);
    	},								   
     	change: function (event, ui) {
			jQuery("#iire_social_shortcode").css("height", ui.value + "px");
     	}
	});
	
	// Shortcode Container Height	
	jQuery('input#wh').bind('change', function(e) {
		var h = jQuery(this).val();
		jQuery("#iire_social_shortcode").css("height", h + "px");	
	});	
	





	// Shortcode Alignment - OK
	jQuery('select#sc_align').bind('change', function(e) {
		var align = jQuery(this).val();
		jQuery(".move").removeClass("alignleft").removeClass("alignright");
		jQuery(".move").addClass("align"+align+"")		
	});		


	// Shortcode Orientation - 
	jQuery('select#sc_orientation').bind('change', function(e) {
		var ot = jQuery(this).val();
		if (ot == 'vertical') {
			jQuery("div.move").removeClass("horizontal");
			jQuery("div.move").addClass("vertical");
			adjustWidgetContainer(); 			
		} else {
			jQuery("div.move").removeClass("vertical");
			jQuery("div.move").addClass("horizontal");
			adjustWidgetContainer();			
		}
	});	



	function adjustWidgetContainer() {
		var iconspace =  jQuery("select#sc_icon_spacing").val();	
		var iconcount = jQuery("div.move").size();
		var ot = jQuery("select#sc_orientation").val();
		if (ot == 'vertical') {
			var newheight = (iconcount * iconsize) + (iconcount * iconspace) - iconspace;
			jQuery("#iire_social_shortcode").css("height", newheight + "px");			
			jQuery("#iire_social_shortcode").css("width", iconsize + "px");
		} else {
			jQuery("#iire_social_shortcode").css("height", wh + "px");			
			jQuery("#iire_social_shortcode").css("width", ww + "px");					
		}
		
		var addthis = jQuery("select#addthis").val();
		if ( addthis == '0') {
			jQuery("li#addthis").hide();			
		} else {
			jQuery("li#addthis").show();				
		}
		
		var wb= jQuery("select#sc_background").val();
		if (wb == '0') {
			jQuery("div.iire_social_shortcode").css("border", "#AAAAAA 1px dashed");
		}
		
		return;
	}



	// SHORTCODE BACKGROUND COLOR?
	jQuery('select#sc_background').bind('change', function() {
		var wb= jQuery(this).val();
		if (wb == '0') {
			jQuery(".addbg").addClass("hidden");
			jQuery("div.iire_social_shortcode").css("background", "none");
			jQuery("div.iire_social_shortcode").css("border", "#AAAAAA 1px dashed");			
			jQuery("select#sc_border_size").val(0);			
		} else {
			jQuery(".addbg").removeClass("hidden");
			var bgcolor = jQuery("input#sc_bg_color").val();
			jQuery("div.iire_social_shortcode").css("background-color", "#"+bgcolor+"");
			var wbs = jQuery("select#sc_border_size").val();
			jQuery("div.iire_social_shortcode").css("border-width", ""+wbs+"px solid");	
			if (wbs == '0') {
				jQuery(".wbs").addClass("hidden");
			} else {
				jQuery(".wbs").removeClass("hidden");
			}					
		}															   
	});
	
	// SHORTCODE BACKGROUND COLOR INPUT
	jQuery('input#sc_bg_color').bind('change', function() {
		var bgcolor = jQuery(this).val();
		jQuery("div.iire_social_shortcode").css("background-color", "#"+bgcolor+"");				
	});	



	// SHORTCODE BORDER SIZE
	jQuery('select#sc_border_size').bind('change', function() {
		var wbs = jQuery(this).val();
		jQuery("div.iire_social_shortcode").css("border-width", ""+wbs+"px solid");			
		if (wbs == '0') {
			jQuery(".wbs").addClass("hidden");
		} else {
			jQuery(".wbs").removeClass("hidden");
		}					
	});	

	// SHORTCODE BORDER COLOR
	jQuery('input#sc_border_color').bind('change', function() {
		var bc = jQuery(this).val();
		jQuery("div.iire_social_shortcode").css("border-color", "#"+bc+"");				
	});	


	jQuery(window).load(function(){	 
		adjustWidgetContainer();
	});
	
	

	// ADD THIS
	jQuery('select#addthis').bind('change', function() {
		var addthis = jQuery(this).val();
		if ( addthis == '0') {
			jQuery(".addthis").addClass("hidden");
			jQuery(".addthis2").removeClass("hidden");
			jQuery("li#addthis").hide();			
		} else {
			jQuery(".addthis").removeClass("hidden");
			jQuery(".addthis2").addClass("hidden");
			jQuery("li#addthis").show();				
		}															   
	});


	// RESET
	jQuery('a.reset').bind('click', function() {
		if (confirm("Are you sure you want to clear your setting and start over?")) { 
			jQuery("div#iire_social_shortcode").empty();
			jQuery("div#codepreview").empty();	
			jQuery('textarea#sc_icons').val('');
			jQuery('textarea#sc_output').val('');
			
			jQuery('select#sc_icon_theme').val('default');
			
			jQuery('select#sc_icon_size').val('64');
			
			jQuery('select#sc_icon_spacing').val('10');	
			
			jQuery('select#sc_dropshadow').val('1');
			jQuery('select#sc_dropshadow_horizontal_offset').val('3');
			jQuery('select#sc_dropshadow_vertical_offset').val('3');
			jQuery('select#sc_dropshadow_blur').val('8');				
			jQuery('input#sc_dropshadow_color').val('AAAAAA');

			jQuery('select#sc_roundedcorners').val('1');
			jQuery('select#sc_roundedcorners_topleft').val('4');
			jQuery('select#sc_roundedcorners_topright').val('4');			
			jQuery('select#sc_roundedcorners_bottomleft').val('4');
			jQuery('select#sc_roundedcorners_bottomright').val('4');	
		
			jQuery('select#sc_icon_bgcolor').val('0');
			jQuery('select#sc_icon_bgcolor_up').val('0');			
		
			jQuery('input#op').val('100');

			jQuery('select#sc_orientation').val('horizontal');	
			jQuery('select#sc_align').val('left');	
			jQuery('input#ww').val('600');			
			jQuery('input#wh').val('70');	
			
			jQuery('input#sc_pad_top').val('0');
			jQuery('input#sc_pad_bottom').val('0');	
			jQuery('input#sc_pad_left').val('0');
			jQuery('input#sc_pad_right').val('0');
			
			jQuery('input#sc_margin_top').val('0');
			jQuery('input#sc_margin_bottom').val('0');	
			jQuery('input#sc_margin_left').val('0');
			jQuery('input#sc_margin_right').val('0');

			jQuery('select#sc_background').val('0');	
			
			jQuery("input#submit").trigger('click');					
		}										 
	});
	
	// SAVE PREVIEW
	jQuery('a.preview').bind('click', function() {
		jQuery("input#submit").trigger('click');			
	});	
	

}); // end Document Ready


function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++){
  		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  		x=x.replace(/^\s+|\s+$/g,"");
  		if (x==c_name) {
    		return unescape(y);
    	}
  	}
}

function rotate13(s) {
	var b = [],c,i = s.length,a = 'a'.charCodeAt(),z = a + 26,A = 'A'.charCodeAt(),Z = A + 26;
    while (i--) {
    	c = s.charCodeAt(i);
        if (c >= a && c < z) { b[i] = String.fromCharCode(((c - a + 13) % (26)) + a); }
        else if (c >= A && c < Z) { b[i] = String.fromCharCode(((c - A + 13) % (26)) + A); }
        else { b[i] = s.charAt(i); }
     }
     return b.join('');
};

function unrotate13(s) {
	var b = [],c,i = s.length,a = 'a'.charCodeAt(),z = a + 26,A = 'A'.charCodeAt(),Z = A + 26;
    while (i--) {
    	c = s.charCodeAt(i);
        if (c >= a && c < z) { b[i] = String.fromCharCode(((c - a - 13) % (26)) + a); }
        else if (c >= A && c < Z) { b[i] = String.fromCharCode(((c - A - 13) % (26)) + A); }
        else { b[i] = s.charAt(i); }
     }
     return b.join('');
};