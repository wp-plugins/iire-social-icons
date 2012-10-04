// IIRE SOCIAL  - 9/30/2012 - 9:00 PM

jQuery(document).ready(function() {

	// SEND EMAIL
	jQuery('div#email').bind('click', function(e) {
		e.preventDefault();	

		jQuery("#emaildialog").dialog( "destroy" );
		jQuery("#emaildialog").dialog({
			resizable: false,
			draggable: true,			
			width: 320,									
			height: 320,
			modal: true,
			buttons: {
				"Send Message": function() {
					var en = jQuery("input#email_name").val();
					if (en == '- Your Name -') {
						jQuery("p.email_message").text("Please enter your name!").addClass('error');						
						return;
					}
					
					var es = jQuery("input#email_sender").val();
					if (es == '- Your Email -') {
						jQuery("p.email_message").text("Please enter your email address!").addClass('error');						
						return;
					}					

					var em = jQuery("textarea#email_message").val();
					if (em == 'Add your message here...') {
						jQuery("p.email_message").text("Please enter a message!").addClass('error');						
						return;
					}						

					var recipient = jQuery("input#email_recipient").val();
					var cc = jQuery("input#email_cc").val();
					var bcc = jQuery("input#email_bcc").val();
					var subject = jQuery("input#email_subject").val();
					var pluginurl = jQuery("input#plugin_url").val();
					var dataString = "fnln="+en+"&sender="+es+"&recipient="+recipient+"&cc="+cc+"&bcc="+bcc+"&subject="+subject+"&message="+em;

					jQuery.ajax({
						type: "POST",
						url: ""+ pluginurl+"/includes/iire_send_email.php",
   			 			data: dataString,				
						success: function(msg){
							alert(msg);
						}
					});
					jQuery(this).dialog("close");
				},
				Cancel: function() {
					jQuery("p.email_message").text("Enter your name, email address and a message.").removeClass('error');	
					jQuery( this ).dialog( "close" );
				}			
			}			
		});		

	});
	
	
	// ADD TO FAVORITES
	jQuery('div#favorite').bind('click', function(e) {
		e.preventDefault();	
		if (document.all && window.external) {
 			window.external.AddFavorite (sURL,sTitle);
 		} else if (window.sidebar) { 
   			window.sidebar.addPanel(sTitle,sURL,'');
 		} else {
  			alert ('Please press Ctrl+D to bookmark this page.');
 		}

	});	


	// ICON OPACITY ON MOUSE ENTER
	jQuery('div.opacity').live('mouseenter', function() {
		jQuery(this).css("opacity", "1.00");			
	});	

	// ICON OPACITY ON MOUSE OUT
	var opac = jQuery('div.opacity').css("opacity");
	jQuery('div.opacity').live('mouseout', function() {
		jQuery(this).css("opacity", opac);			
	});


}); // End Document Ready