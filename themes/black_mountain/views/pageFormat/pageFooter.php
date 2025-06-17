<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2018 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
?>
		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
<footer id="main-footer">
				
<div class="container">
	<div id="footer-widgets" class="clearfix">
		<div class="footer-widget"><div id="text-10" class="fwidget et_pb_widget widget_text"><h4 class="title">About Us</h4>			<div class="textwidget"><p style="text-align: left;">BMCM+AC is dedicated to preserving the history and exploring the legacy of Black Mountain College. <a style="color: #191919; text-decoration: underline;" href="https://www.blackmountaincollege.org/about/">read more</a></p></div>
		</div></div><div class="footer-widget"><div id="text-5" class="fwidget et_pb_widget widget_text"><h4 class="title">Hours + Locations</h4>			<div class="textwidget"><p>Open 11am – 5pm Monday through Saturday</p>
<p><a href="https://www.google.com/maps/search/?api=1&amp;query=Black+Mountain+College+Museum+Arts+Center" onclick="javascript:window.open('https://www.google.com/maps/search/?api=1&amp;query=Black+Mountain+College+Museum+Arts+Center', '_blank', 'noopener'); return false;">120 College Street</a><br>
<a href="https://www.google.com/maps/search/?api=1&amp;query=Black+Mountain+College+Museum+Arts+Center" onclick="javascript:window.open('https://www.google.com/maps/search/?api=1&amp;query=Black+Mountain+College+Museum+Arts+Center', '_blank', 'noopener'); return false;">Asheville, NC 28801</a></p>
</div>
		</div></div><div class="footer-widget"><div id="text-8" class="fwidget et_pb_widget widget_text"><h4 class="title">Contact Us</h4>			<div class="textwidget"><p>Have questions?<br>
Give us a call at:&nbsp;<a href="tel:8283508484">828-350-8484</a><br>
Or email us at: <a href="mailto:info@blackmountaincollege.org">info@blackmountaincollege.org</a></p>
</div>
		</div></div><div class="footer-widget"></div>	</div>
</div>


		
				<div id="footer-bottom">
					<div class="container clearfix">
				<ul class="et-social-icons">

	<li class="et-social-icon et-social-facebook">
		<a href="https://www.facebook.com/pages/Black-Mountain-College-Museum-Arts-Center/59577265158" class="icon" onclick="javascript:window.open('https://www.facebook.com/pages/Black-Mountain-College-Museum-Arts-Center/59577265158', '_blank', 'noopener'); return false;">
			<span>Facebook</span>
		</a>
	</li>
	<li class="et-social-icon et-social-twitter">
		<a href="https://twitter.com/bmcmuseum" class="icon" onclick="javascript:window.open('https://twitter.com/bmcmuseum', '_blank', 'noopener'); return false;">
			<span>Twitter</span>
		</a>
	</li>
	<li class="et-social-icon et-social-rss">
		<a href="https://instagram.com/bmcmuseum/" class="icon" onclick="javascript:window.open('https://instagram.com/bmcmuseum/', '_blank', 'noopener'); return false;">
			<span>RSS</span>
		</a>
	</li>

</ul>					</div>
				</div>
			</footer>

	
		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel" role="complementary"> 
			<div id="caMediaPanelContentArea">
			
			</div>
		</div>
		<script type="text/javascript">
			/*
				Set up the "caMediaPanel" panel that will be triggered by links in object detail
				Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
			*/
			var caMediaPanel;
			jQuery(document).ready(function() {
				if (caUI.initPanel) {
					caMediaPanel = caUI.initPanel({ 
						panelID: 'caMediaPanel',										/* DOM ID of the <div> enclosing the panel */
						panelContentID: 'caMediaPanelContentArea',		/* DOM ID of the content area <div> in the panel */
						onCloseCallback: function(data) {
							if(data && data.url) {
								window.location = data.url;
							}
						},
						exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
		
//			$(document).ready(function() {
//				$(document).bind("contextmenu",function(e){
//				   return false;
//				 });
//			}); 
			document.addEventListener('contextmenu', event => event.preventDefault());
		</script>
<?php
	print $this->render("Cookies/banner_html.php");	
?>
	</body>
	
	
	
	
	
	
<script type='text/javascript' id='divi-custom-script-js-extra'>
/* <![CDATA[ */
var DIVI = {"item_count":"%d Item","items_count":"%d Items"};
var et_builder_utils_params = {"condition":{"diviTheme":true,"extraTheme":false},"scrollLocations":["app","top"],"builderScrollLocations":{"desktop":"app","tablet":"app","phone":"app"},"onloadScrollLocation":"app","builderType":"fe"};
var et_frontend_scripts = {"builderCssContainerPrefix":"#et-boc","builderCssLayoutPrefix":"#et-boc .et-l"};
var et_pb_custom = {"ajaxurl":"https:\/\/www.blackmountaincollege.org\/wp-admin\/admin-ajax.php","images_uri":"https:\/\/www.blackmountaincollege.org\/wp-content\/themes\/Divi\/images","builder_images_uri":"https:\/\/www.blackmountaincollege.org\/wp-content\/themes\/Divi\/includes\/builder\/images","et_frontend_nonce":"009bd18160","subscription_failed":"Please, check the fields below to make sure you entered the correct information.","et_ab_log_nonce":"933f038cfd","fill_message":"Please, fill in the following fields:","contact_error_message":"Please, fix the following errors:","invalid":"Invalid email","captcha":"Captcha","prev":"Prev","previous":"Previous","next":"Next","wrong_captcha":"You entered the wrong number in captcha.","wrong_checkbox":"Checkbox","ignore_waypoints":"no","is_divi_theme_used":"1","widget_search_selector":".widget_search","ab_tests":[],"is_ab_testing_active":"","page_id":"1353","unique_test_id":"","ab_bounce_rate":"5","is_cache_plugin_active":"yes","is_shortcode_tracking":"","tinymce_uri":"https:\/\/www.blackmountaincollege.org\/wp-content\/themes\/Divi\/includes\/builder\/frontend-builder\/assets\/vendors","waypoints_options":[]};
var et_pb_box_shadow_elements = [];
/* ]]> */
</script>	
<script type='text/javascript' src='https://www.blackmountaincollege.org/wp-content/themes/Divi/js/scripts.min.js?ver=4.17.4' id='divi-custom-script-js'></script>
<script type='text/javascript' src='https://www.blackmountaincollege.org/wp-content/themes/Divi/js/smoothscroll.js?ver=4.17.4' id='smoothscroll-js'></script>
<script type='text/javascript' src='https://www.blackmountaincollege.org/wp-content/themes/Divi/includes/builder/feature/dynamic-assets/assets/js/jquery.fitvids.js?ver=4.17.4' id='fitvids-js'></script>
<script type='text/javascript' src='https://www.blackmountaincollege.org/wp-content/themes/Divi/includes/builder/feature/dynamic-assets/assets/js/magnific-popup.js?ver=4.17.4' id='magnific-popup-js'></script>
<script type='text/javascript' src='https://www.blackmountaincollege.org/wp-content/themes/Divi/includes/builder/feature/dynamic-assets/assets/js/easypiechart.js?ver=4.17.4' id='easypiechart-js'></script>
<script type='text/javascript' src='https://www.blackmountaincollege.org/wp-content/themes/Divi/includes/builder/feature/dynamic-assets/assets/js/salvattore.js?ver=4.17.4' id='salvattore-js'></script>
<script type='text/javascript' src='https://www.blackmountaincollege.org/wp-content/themes/Divi/core/admin/js/common.js?ver=4.17.4' id='et-core-common-js'></script>
<style id="et-builder-module-design-deferred-1353-cached-inline-styles">.et_pb_text_2.et_pb_text,.et_pb_text_0.et_pb_text,.et_pb_text_1.et_pb_text{color:#000000!important}.et_pb_text_2,.et_pb_text_0,.et_pb_text_1{font-family:'Poppins',Helvetica,Arial,Lucida,sans-serif;font-weight:400}.et_pb_text_1 h6,.et_pb_text_0 h1,.et_pb_text_0 h2,.et_pb_text_2 h6,.et_pb_text_0 h6,.et_pb_text_2 h2,.et_pb_text_2 h1,.et_pb_text_1 h1,.et_pb_text_1 h2{font-family:'Poppins',Helvetica,Arial,Lucida,sans-serif;font-weight:200;color:#284265!important}.et_pb_text_2 h3,.et_pb_text_1 h3,.et_pb_text_0 h3{font-family:'Poppins',Helvetica,Arial,Lucida,sans-serif;font-weight:200;color:#db6233!important}.et_pb_divider_0:before,.et_pb_divider_2:before{border-top-color:#fe5000}.et_pb_blog_0 .et_pb_post .entry-title a,.et_pb_blog_0 .not-found-title,.et_pb_blog_1 .et_pb_post .entry-title a,.et_pb_blog_1 .not-found-title,.et_pb_blog_2 .et_pb_post .entry-title a,.et_pb_blog_2 .not-found-title{font-weight:300!important}.et_pb_blog_2 .et_pb_post .post-content,.et_pb_blog_2.et_pb_bg_layout_light .et_pb_post .post-content p,.et_pb_blog_2.et_pb_bg_layout_dark .et_pb_post .post-content p,.et_pb_blog_1 .et_pb_post .post-content,.et_pb_blog_1.et_pb_bg_layout_light .et_pb_post .post-content p,.et_pb_blog_1.et_pb_bg_layout_dark .et_pb_post .post-content p,.et_pb_blog_0 .et_pb_post .post-content,.et_pb_blog_0.et_pb_bg_layout_light .et_pb_post .post-content p,.et_pb_blog_0.et_pb_bg_layout_dark .et_pb_post .post-content p{font-weight:300;text-align:left}.et_pb_blog_1 .et_pb_post .post-meta,.et_pb_blog_1 .et_pb_post .post-meta a,#left-area .et_pb_blog_1 .et_pb_post .post-meta,#left-area .et_pb_blog_1 .et_pb_post .post-meta a,.et_pb_blog_2 .et_pb_post .post-meta,.et_pb_blog_2 .et_pb_post .post-meta a,#left-area .et_pb_blog_2 .et_pb_post .post-meta,#left-area .et_pb_blog_2 .et_pb_post .post-meta a,.et_pb_blog_0 .et_pb_post .post-meta,.et_pb_blog_0 .et_pb_post .post-meta a,#left-area .et_pb_blog_0 .et_pb_post .post-meta,#left-area .et_pb_blog_0 .et_pb_post .post-meta a{text-align:left}.et_pb_blog_2 .et_pb_blog_grid .et_pb_post,.et_pb_blog_1 .et_pb_blog_grid .et_pb_post,.et_pb_blog_0 .et_pb_blog_grid .et_pb_post{border-width:0px}.et_pb_blog_2 .entry-featured-image-url img,.et_pb_blog_1 .entry-featured-image-url img,.et_pb_blog_0 .entry-featured-image-url img{height:200px;width:300px;object-fit:cover}.et_pb_divider_1:before{border-top-color:#ff6600}</style></body>






</html>
