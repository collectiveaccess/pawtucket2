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
	global $g_ui_locale;

 	if($this->request->isLoggedIn()){
		$va_user_links[] = '<li role="presentation" class="userName">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		#$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
	}
?>

		<div style="clear:both; height:1px;"><!-- empty --></div>
		</div><!-- end pageArea --></div><!-- end main --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
		<footer id="footer" class="text-center">
			<div class="footerBg"><div class="container">
				<ul class="list-inline social">
					<li><a href="https://www.facebook.com/arsenal.kino/" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
					<li><a href="https://twitter.com/kinoarsenal" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="https://www.youtube.com/channel/UC42FHy5wsH0KVZ51lkBzwWQ" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
				</ul>
				<div class="row">
					<div class="col-sm-7 text-left">
						<a href="https://www.arsenal-berlin.de" class="orgLink">Arsenal – Institut für Film und Videokunst e.V.</a>
						<div class="row">
							<div class="col-sm-5">
								Potsdamer Straße 2<br/>
								10785 Berlin<br/>
								Phone +49-30-26955-100<br/>
								<a href="mailto:mail@arsenal-berlin.de">mail@arsenal-berlin.de</a>
							</div>
							<div class="col-sm-7">
								Archive<br/>
								silent green Kulturquartier<br/>
								Gerichtstraße 35<br/>
								13347 Berlin
							</div>
						</div>
					</div>
					<div class="col-sm-5 text-right">
						<ul class="list-inline">
							<li><?php print caNavLink($this->request, _t("Cookies"), "", "", "Cookies", "manage"); ?></li>
							<li><a href="https://www.arsenal-berlin.de/en/datenschutz/"><?php print _t("Privacy Policy"); ?></a></li>
							<li><a href="https://www.arsenal-berlin.de/en/impressum/"><?php print _t("Imprint"); ?></a></li>
							<li><a href="https://www.arsenal-berlin.de/en/institute/contact/"><?php print _t("Contact"); ?></a></li>
						</ul>
						&copy; <?php print date("Y"); ?> Arsenal – Institut für Film und Videokunst e.V.
						<ul class="list-inline loginLinks">
							<?php print join("", $va_user_links); ?>
						</ul>
					</div>
				</div>
			</div></div>
			<div class="funder">
				<div class="container">
					<div class="row"><div class="col-sm-12">
<?php
					if($g_ui_locale == "de_DE"){
						print caGetThemeGraphic($this->request, 'BKM.svg');
					}else{
						print caGetThemeGraphic($this->request, 'BKM_en.svg');
					}
					print caGetThemeGraphic($this->request, 'Neustart_Kultur.svg');


?>
					</div>
				</div>
			</div>
		</footer><!-- end footer -->
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	
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
		</script>
<?php
	print $this->render("Cookies/banner_html.php");	
?>
	</body>
</html>
