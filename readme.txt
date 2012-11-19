=== Plugin Name ===
Contributors: iiRe Productions
Donate link: http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-icons/
Tags: Social Media, Icons, Facebook, Google, Instagram, Linked In, Pinterest, Skype, Twitter, YouTube  
Requires at least: 3.1
Tested up to: 3.42
Stable tag: 0.30 
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add social media icons and links to your site with a customizable user interface. Majority of social networks are supported!

== Description ==

Easily choose an from a library of social media icons, customize their appearance, and add them to a wordpress website as a widget or shortcode. Use one the default icon themes or use the symbols and background colors with CSS styling.

See our <a href="http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-icons/">iiRe Social Icons page</a> for more information.


**Features**

* Create an independent social media icons widget and shortcode
* Majority of social networks supported
* Over 60 different icons!
* 5 different icon sizes (16x16px, 24x24px, 32x32px, 48x48px, 64x64px)!
* Additional free icon themes available
* Real-time editing! Change icon theme, size. spacing, etc. dynamically
* Drag and drop icon reordering!
* Drag and drop delete!
* Add custom titles to each icon
* Add custom links to each icon (samples provided)
* Add CSS rounded corners! Customize the radius of each corner
* Add CSS drop shadows! Customize the color, hortizonal and vertical offset and blur
* Add background colors!
* Add background hover colors!
* Add CSS opacity!
* Links in new or same window/tab (link target)
* Show or Hide the title (alt/title tag)
* Hide links from search engines (no follow)
* Stack icons horizontally or vertically!
* Align icons left or right
* Customize the width and height of the icons container
* Customize the CSS padding and margins of the icon container 
* Customize the container border size and color
* Customize the container background color
* Add This social media support
* Built-in email contact form w/ recipient settings
* Built-in print function
* A "Reset" button!
* Works in most modern browsers, including IE9!
* Accordian-style options panel
* Options panel is collapsible!
* Add up to five custom themes


**Supported Networks**

500px, Add This, Amazon, Aim, AOL, Apple, Android, Beboo, Badoo, Blink List, Blogger, Buzznet, Cafe Mom, Delicious, Design Float, Deviant Art, Digg, Dribble, Ebay, Esty, Evernote, Feedburner, Facebook, Flickr, Friendfeed, Friendster, Foursquare, Geocaching, Google, Google Plus, Gmail, Hi5, Instagram, Last FM, Linked In, Live Journal, Meetup, Microsoft, Mixx, Myspace, Newsvine, Ning, Orkut, Paypal, Pinterest, Picasa, Pure VOlume, Reddit, Reverbnation, RSS, Share This, Skype, Slash Dot, Slideshare, Smug Mug, Sound Cloud, Spotify, Stumbleupon, Tagged, Twitter, Vimeo, Wordpress, Yahoo, Yelp, You Tube

There are additional icons for email, custom links, alternate website, add to favorites, more information, chat, print and a contact us page.


**Quick Start**

1. Go to 'Wordpress Admin', 'Appearance', 'Widgets'.
2. Add the 'iiRe Social Media Icons' to a sidebar widget area and 'Save'.
3. Go to 'Wordpress Admin', 'iiRe Social Icons', 'Widget Settings'.
4. Click 'Icon Theme' in the side panel, choose a theme in 'Icon Theme'or use the default.
5. In the Icons section, click an icon to add it to the Widget Designer.
6. Repeat the previous step to add additional icons.
7. Double-click each icon in the Widget Designer to edit the link and title.
8. Click 'Save Changes'.
9. View the section of your website/blog wher you place the widget to view the output!


== Installation ==

For an automatic installation through WordPress:

1. Go to the 'Add New' plugins screen in your WordPress admin area.
2. Search for 'iiRe Social.'
3. Click 'Install Now' button.
4. Activate the plugin to finish the installation.

For a manual installation via FTP:

1. Upload the iire-social-icons folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' screen in your WordPress admin area.

To upload the plugin through WordPress, instead of FTP:

1. Upload the downloaded zip file on the 'Add New' plugins screen in your WordPress admin area.
2. Activate the plugin through the 'Plugins' screen in your WordPress admin area.


To install additional icon themes via FTP:

1. Download the desired icon theme to your hardrive and unzip. (The name of the zip file is the name of the theme folder)
2. Upload the icon theme folder to the /wp-content/plugins/iire-social-icons/themes/ directory.



== Frequently Asked Questions ==

Q. What are the plugin requirements?
A. The admin section requires Jquery and Jquery UI to be enabled. These libraries will be loaded from the Google CDN if not present, then initialized on the widget and shortcode admin pages.

Q. Why two different admin panels for the widget and the shortcode?
A. All settings for the widget and the shortcode are stored independently. The widget(best used in the sidebar) and the shortcode(best used on a page or post) can be designed differently, with different themes, size, icon order, etc.

Q. Can I add my own icons?
A. Yes, you can create a "custom1" (up to 5 respectively) folder under the plugin themes directory. Each icon theme is designed as a set of individual image sprites (All the icons are arranged in a grid as a single image), so your "icon grid" must match the layout on one of the other themes. Icons are not available as individual files.

Q. How were the icons created?
A. All icons were designed in-house at iiRe Productions using high-resolution vector images. This method helps us to produce the highest quality images.

Q. How do I access all the icons?
A. The free version of this plugin has limited access to certain social networks. Facebook, Twitter, Pinterest, Linked In, You Tube, Email, RSS, Favorites, Print, External Links, Website, Contact Us, More Info and Chat work immediately on installation without activation. If you would like to receive a registration code to unlock the additional networks, please consider making a donation.

Q. Are there additional icon themes?
A. Yes, there are additional free theme available as downloadable zip file on http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-icons/

Q. How do I change the default links for each icon?
A. In the Widget or Shortcode Designer, just double-click the desired icon to display the title/link icon and enter the appropriate values.   


== Screenshots ==

1. Widget Designer Admin Panel
2. Shortcode Designer Admin Panel


== Changelog ==


= 0.30 Make sure to deactivate and delete all prior versions! =
* Added the following networks: Esty, Buzznet, Paypal, Reverbnation, Ebay, Mixx, Pure Volume, Design Float, 500px, Smugmug, GoeCaching, Evernote
* Added support for up to 5 custom folders using the grid layout
* Added a Print icon and function
* Changed the default icon size on reset to 64x64 for the widget
* Changed the default icon size on reset to 32x32 for the shortcode
* Added additional detection of jQuery UI
* Included the jQuery UI base javascript, CSS and image files
* Fixed issue when using plugin on a site that uses a SSL certificate.
* Updated the Widget/Shortcode Designer screenshots
* Updated readme.txt file


= 0.21 =
* Fix an issue where themes were not properly detected when plugin was installed into a different location other that the default folder
* Rewrote the javascript for the "Add to Favorites" Works in FireFox and IE, a prompt is displayed for Chrome,Safari and Opera  
* Adjusted the default minimum height of the Widget/Shortcode Designer preview area
* Added javascript to hide Wordpress nag messages when editing in the Widget/Shortcode Designer
* Added a "blank" icon - Designers can graphically modify a theme to add an icon logo that may not be available in the network.
* Updated the uninstaller to properly delete the database table upon deactivation.  
* Additional support for future upgrades.
* Updated readme.txt file

= 0.20 =
* Fixed an issue with icon opacity in the Widget/ShortCode Designers
* Fixed an issue remembering the active theme in Shortcode Designer
* Added a prefix to each icon ID to allow additional compatiblilty with 3rd party themes that also include social media icons 
* Modified all stylesheets to use the new icon prefix
* Updated readme.txt file

= 0.12 =
* Number of available themes included was reduced to limit the size of the plugin
* Additional theme files posted on website
* Select box for theme code modified to detect new sub-folders in the plugin theme directory
* Updated readme.txt file

= 0.11 =
* Limited number of meta tags in readme.txt file

= 0.10 =
* Initial beta release
== Upgrade Notice ==
** Make sure to deactivate and delete all prior versions! **

See our <a href="http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-icons/">iiRe Social Icons page</a> for more information.