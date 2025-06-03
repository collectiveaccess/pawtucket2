<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
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
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$va_classroomDisplayName = caGetClassroomDisplayName();
	$vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	
	# Collect the user links: they are output twice, once for toggle menu and once for nav
	$va_user_links = array();
	if($this->request->isLoggedIn()){
		$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$va_user_links[] = '<li class="divider nav-divider"></li>';
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		if(caDisplayClassroom($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		
		if ($this->request->config->get('use_submission_interface')) {
			$va_user_links[] = "<li>".caNavLink($this->request, _t('Submit content'), '', '', 'Contribute', 'List', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

<script>
window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/13.1.0\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/13.1.0\/svg\/","svgExt":".svg","source":{"concatemoji":"http:\/\/collection.oldfilm.org\/wp-includes\/js\/wp-emoji-release.min.js?ver=5.9.2"}};
/*! This file is auto-generated */
!function(e,a,t){var n,r,o,i=a.createElement("canvas"),p=i.getContext&&i.getContext("2d");function s(e,t){var a=String.fromCharCode;p.clearRect(0,0,i.width,i.height),p.fillText(a.apply(this,e),0,0);e=i.toDataURL();return p.clearRect(0,0,i.width,i.height),p.fillText(a.apply(this,t),0,0),e===i.toDataURL()}function c(e){var t=a.createElement("script");t.src=e,t.defer=t.type="text/javascript",a.getElementsByTagName("head")[0].appendChild(t)}for(o=Array("flag","emoji"),t.supports={everything:!0,everythingExceptFlag:!0},r=0;r<o.length;r++)t.supports[o[r]]=function(e){if(!p||!p.fillText)return!1;switch(p.textBaseline="top",p.font="600 32px Arial",e){case"flag":return s([127987,65039,8205,9895,65039],[127987,65039,8203,9895,65039])?!1:!s([55356,56826,55356,56819],[55356,56826,8203,55356,56819])&&!s([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]);case"emoji":return!s([10084,65039,8205,55357,56613],[10084,65039,8203,55357,56613])}return!1}(o[r]),t.supports.everything=t.supports.everything&&t.supports[o[r]],"flag"!==o[r]&&(t.supports.everythingExceptFlag=t.supports.everythingExceptFlag&&t.supports[o[r]]);t.supports.everythingExceptFlag=t.supports.everythingExceptFlag&&!t.supports.flag,t.DOMReady=!1,t.readyCallback=function(){t.DOMReady=!0},t.supports.everything||(n=function(){t.readyCallback()},a.addEventListener?(a.addEventListener("DOMContentLoaded",n,!1),e.addEventListener("load",n,!1)):(e.attachEvent("onload",n),a.attachEvent("onreadystatechange",function(){"complete"===a.readyState&&t.readyCallback()})),(n=t.source||{}).concatemoji?c(n.concatemoji):n.wpemoji&&n.twemoji&&(c(n.twemoji),c(n.wpemoji)))}(window,document,window._wpemojiSettings);
</script>
<style>
img.wp-smiley,
img.emoji {
	display: inline !important;
	border: none !important;
	box-shadow: none !important;
	height: 1em !important;
	width: 1em !important;
	margin: 0 0.07em !important;
	vertical-align: -0.1em !important;
	background: none !important;
	padding: 0 !important;
}
</style>
	<link rel='stylesheet' id='wp-block-library-css'  href='/wp-includes/css/dist/block-library/style.min.css?ver=5.9.2' media='all' />
<style id='global-styles-inline-css'>
body{--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--color--contrast: var(--contrast);--wp--preset--color--contrast-2: var(--contrast-2);--wp--preset--color--contrast-3: var(--contrast-3);--wp--preset--color--base: var(--base);--wp--preset--color--base-2: var(--base-2);--wp--preset--color--base-3: var(--base-3);--wp--preset--color--accent: var(--accent);--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--duotone--dark-grayscale: url('#wp-duotone-dark-grayscale');--wp--preset--duotone--grayscale: url('#wp-duotone-grayscale');--wp--preset--duotone--purple-yellow: url('#wp-duotone-purple-yellow');--wp--preset--duotone--blue-red: url('#wp-duotone-blue-red');--wp--preset--duotone--midnight: url('#wp-duotone-midnight');--wp--preset--duotone--magenta-yellow: url('#wp-duotone-magenta-yellow');--wp--preset--duotone--purple-green: url('#wp-duotone-purple-green');--wp--preset--duotone--blue-orange: url('#wp-duotone-blue-orange');--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
</style>
<link rel='stylesheet' id='generate-widget-areas-css'  href='/wp-content/themes/generatepress/assets/css/components/widget-areas.min.css?ver=3.1.3' media='all' />
<link rel='stylesheet' id='generate-style-css'  href='/wp-content/themes/generatepress/assets/css/main.min.css?ver=3.1.3' media='all' />
<style id='generate-style-inline-css'>
body{background-color:var(--base-3);color:#222222;}a{color:#1e73be;}a:hover, a:focus{text-decoration:underline;}.entry-title a, .site-branding a, a.button, .wp-block-button__link, .main-navigation a{text-decoration:none;}a:hover, a:focus, a:active{color:#000000;}.wp-block-group__inner-container{max-width:1200px;margin-left:auto;margin-right:auto;}.site-header .header-image{width:126px;}.navigation-search{position:absolute;left:-99999px;pointer-events:none;visibility:hidden;z-index:20;width:100%;top:0;transition:opacity 100ms ease-in-out;opacity:0;}.navigation-search.nav-search-active{left:0;right:0;pointer-events:auto;visibility:visible;opacity:1;}.navigation-search input[type="search"]{outline:0;border:0;vertical-align:bottom;line-height:1;opacity:0.9;width:100%;z-index:20;border-radius:0;-webkit-appearance:none;height:60px;}.navigation-search input::-ms-clear{display:none;width:0;height:0;}.navigation-search input::-ms-reveal{display:none;width:0;height:0;}.navigation-search input::-webkit-search-decoration, .navigation-search input::-webkit-search-cancel-button, .navigation-search input::-webkit-search-results-button, .navigation-search input::-webkit-search-results-decoration{display:none;}.gen-sidebar-nav .navigation-search{top:auto;bottom:0;}:root{--contrast:#333333;--contrast-2:#5e5350;--contrast-3:#b2b2be;--base:#f0f0f0;--base-2:#f7f8f9;--base-3:#ffffff;--accent:#5e5350;}.has-contrast-color{color:#333333;}.has-contrast-background-color{background-color:#333333;}.has-contrast-2-color{color:#5e5350;}.has-contrast-2-background-color{background-color:#5e5350;}.has-contrast-3-color{color:#b2b2be;}.has-contrast-3-background-color{background-color:#b2b2be;}.has-base-color{color:#f0f0f0;}.has-base-background-color{background-color:#f0f0f0;}.has-base-2-color{color:#f7f8f9;}.has-base-2-background-color{background-color:#f7f8f9;}.has-base-3-color{color:#ffffff;}.has-base-3-background-color{background-color:#ffffff;}.has-accent-color{color:#5e5350;}.has-accent-background-color{background-color:#5e5350;}.top-bar{font-family:Montserrat, sans-serif;font-weight:500;text-transform:uppercase;}html{font-family:Montserrat, sans-serif;}body, button, input, select, textarea{font-family:Montserrat, sans-serif;}p{margin-bottom:1em;}.main-navigation a, .main-navigation .menu-toggle, .main-navigation .menu-bar-items{font-family:inherit;font-weight:500;text-transform:uppercase;font-size:16px;}.top-bar{background-color:#242424;color:#ffffff;}.top-bar a{color:#ffffff;}.top-bar a:hover{color:#303030;}.site-header{background-color:#ffffff;}.main-title a,.main-title a:hover{color:#222222;}.site-description{color:#757575;}.main-navigation,.main-navigation ul ul{background-color:rgba(255,255,255,0);}.main-navigation .main-nav ul li a, .main-navigation .menu-toggle, .main-navigation .menu-bar-items{color:var(--base-3);}.main-navigation .main-nav ul li:not([class*="current-menu-"]):hover > a, .main-navigation .main-nav ul li:not([class*="current-menu-"]):focus > a, .main-navigation .main-nav ul li.sfHover:not([class*="current-menu-"]) > a, .main-navigation .menu-bar-item:hover > a, .main-navigation .menu-bar-item.sfHover > a{color:var(--base);background-color:rgba(0,0,0,0);}button.menu-toggle:hover,button.menu-toggle:focus{color:var(--base-3);}.main-navigation .main-nav ul li[class*="current-menu-"] > a{color:var(--base-3);background-color:rgba(0,0,0,0);}.navigation-search input[type="search"],.navigation-search input[type="search"]:active, .navigation-search input[type="search"]:focus, .main-navigation .main-nav ul li.search-item.active > a, .main-navigation .menu-bar-items .search-item.active > a{color:var(--contrast);background-color:#ffffff;opacity:1;}.main-navigation ul ul{background-color:#eaeaea;}.main-navigation .main-nav ul ul li a{color:#515151;}.main-navigation .main-nav ul ul li:not([class*="current-menu-"]):hover > a,.main-navigation .main-nav ul ul li:not([class*="current-menu-"]):focus > a, .main-navigation .main-nav ul ul li.sfHover:not([class*="current-menu-"]) > a{color:#7a8896;background-color:#eaeaea;}.main-navigation .main-nav ul ul li[class*="current-menu-"] > a{color:#7a8896;background-color:#eaeaea;}.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .one-container .container, .separate-containers .paging-navigation, .inside-page-header{background-color:#ffffff;}.entry-title a{color:#222222;}.entry-title a:hover{color:#55555e;}.entry-meta{color:#595959;}.sidebar .widget{background-color:#ffffff;}.footer-widgets{background-color:#ffffff;}.footer-widgets .widget-title{color:#000000;}.site-info{color:#ffffff;background-color:#55555e;}.site-info a{color:#ffffff;}.site-info a:hover{color:#d3d3d3;}.footer-bar .widget_nav_menu .current-menu-item a{color:#d3d3d3;}input[type="text"],input[type="email"],input[type="url"],input[type="password"],input[type="search"],input[type="tel"],input[type="number"],textarea,select{color:#666666;background-color:#fafafa;border-color:#cccccc;}input[type="text"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="password"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="number"]:focus,textarea:focus,select:focus{color:#666666;background-color:#ffffff;border-color:#bfbfbf;}button,html input[type="button"],input[type="reset"],input[type="submit"],a.button,a.wp-block-button__link:not(.has-background){color:#ffffff;background-color:#55555e;}button:hover,html input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,a.button:hover,button:focus,html input[type="button"]:focus,input[type="reset"]:focus,input[type="submit"]:focus,a.button:focus,a.wp-block-button__link:not(.has-background):active,a.wp-block-button__link:not(.has-background):focus,a.wp-block-button__link:not(.has-background):hover{color:#ffffff;background-color:#3f4047;}a.generate-back-to-top{background-color:rgba( 0,0,0,0.4 );color:#ffffff;}a.generate-back-to-top:hover,a.generate-back-to-top:focus{background-color:rgba( 0,0,0,0.6 );color:#ffffff;}@media (max-width: 1024px){.main-navigation .menu-bar-item:hover > a, .main-navigation .menu-bar-item.sfHover > a{background:none;color:var(--base-3);}}.inside-top-bar{padding:0px 40px 0px 40px;}.nav-below-header .main-navigation .inside-navigation.grid-container, .nav-above-header .main-navigation .inside-navigation.grid-container{padding:0px 20px 0px 20px;}.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .separate-containers .paging-navigation, .one-container .site-content, .inside-page-header{padding:30px;}.site-main .wp-block-group__inner-container{padding:30px;}.separate-containers .paging-navigation{padding-top:20px;padding-bottom:20px;}.entry-content .alignwide, body:not(.no-sidebar) .entry-content .alignfull{margin-left:-30px;width:calc(100% + 60px);max-width:calc(100% + 60px);}.one-container.right-sidebar .site-main,.one-container.both-right .site-main{margin-right:30px;}.one-container.left-sidebar .site-main,.one-container.both-left .site-main{margin-left:30px;}.one-container.both-sidebars .site-main{margin:0px 30px 0px 30px;}.one-container.archive .post:not(:last-child), .one-container.blog .post:not(:last-child){padding-bottom:30px;}.main-navigation .main-nav ul li a,.menu-toggle,.main-navigation .menu-bar-item > a{line-height:40px;}.navigation-search input[type="search"]{height:40px;}.rtl .menu-item-has-children .dropdown-menu-toggle{padding-left:20px;}.rtl .main-navigation .main-nav ul li.menu-item-has-children > a{padding-right:20px;}@media (max-width:768px){.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .separate-containers .paging-navigation, .one-container .site-content, .inside-page-header{padding:20px;}.site-main .wp-block-group__inner-container{padding:20px;}.inside-top-bar{padding-right:30px;padding-left:30px;}.inside-header{padding-right:30px;padding-left:30px;}.widget-area .widget{padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px;}.footer-widgets-container{padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px;}.inside-site-info{padding-right:30px;padding-left:30px;}.entry-content .alignwide, body:not(.no-sidebar) .entry-content .alignfull{margin-left:-20px;width:calc(100% + 40px);max-width:calc(100% + 40px);}.one-container .site-main .paging-navigation{margin-bottom:20px;}}/* End cached CSS */.is-right-sidebar{width:30%;}.is-left-sidebar{width:30%;}.site-content .content-area{width:100%;}@media (max-width: 1024px){.main-navigation .menu-toggle,.sidebar-nav-mobile:not(#sticky-placeholder){display:block;}.main-navigation ul,.gen-sidebar-nav,.main-navigation:not(.slideout-navigation):not(.toggled) .main-nav > ul,.has-inline-mobile-toggle #site-navigation .inside-navigation > *:not(.navigation-search):not(.main-nav){display:none;}.nav-align-right .inside-navigation,.nav-align-center .inside-navigation{justify-content:space-between;}.has-inline-mobile-toggle .mobile-menu-control-wrapper{display:flex;flex-wrap:wrap;}.has-inline-mobile-toggle .inside-header{flex-direction:row;text-align:left;flex-wrap:wrap;}.has-inline-mobile-toggle .header-widget,.has-inline-mobile-toggle #site-navigation{flex-basis:100%;}.nav-float-left .has-inline-mobile-toggle #site-navigation{order:10;}}
.elementor-template-full-width .site-content{display:block;}
.dynamic-author-image-rounded{border-radius:100%;}.dynamic-featured-image, .dynamic-author-image{vertical-align:middle;}.one-container.blog .dynamic-content-template:not(:last-child), .one-container.archive .dynamic-content-template:not(:last-child){padding-bottom:0px;}.dynamic-entry-excerpt > p:last-child{margin-bottom:0px;}
.page-hero .inside-page-hero.grid-container{max-width:calc(1200px - 0px - 0px);}.inside-page-hero > *:last-child{margin-bottom:0px;}.header-wrap{
	position:absolute;
	left:0px;
	right:0px;
	z-index:10;
}.header-wrap .site-header{background:transparent;}.elementor-editor-active .header-wrap{pointer-events:none;}
.post-image:not(:first-child), .page-content:not(:first-child), .entry-content:not(:first-child), .entry-summary:not(:first-child), footer.entry-meta{margin-top:0em;}.post-image-above-header .inside-article div.featured-image, .post-image-above-header .inside-article div.post-image{margin-bottom:0em;}
</style>
<link rel='stylesheet' id='generate-child-css'  href='/wp-content/themes/oldfilm/style.css?ver=1649432422' media='all' />
<link rel='stylesheet' id='generate-google-fonts-css'  href='https://fonts.googleapis.com/css?family=Montserrat%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;display=swap&#038;ver=3.1.3' media='all' />
<link rel='stylesheet' id='elementor-icons-css'  href='/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css?ver=5.15.0' media='all' />
<link rel='stylesheet' id='elementor-frontend-css'  href='/wp-content/plugins/elementor/assets/css/frontend-lite.min.css?ver=3.6.2' media='all' />
<link rel='stylesheet' id='elementor-post-6-css'  href='/wp-content/uploads/elementor/css/post-6.css?ver=1649109077' media='all' />
<link rel='stylesheet' id='elementor-pro-css'  href='/wp-content/plugins/elementor-pro/assets/css/frontend-lite.min.css?ver=3.6.4' media='all' />
<link rel='stylesheet' id='elementor-global-css'  href='/wp-content/uploads/elementor/css/global.css?ver=1649109077' media='all' />
<link rel='stylesheet' id='elementor-post-43-css'  href='/wp-content/uploads/elementor/css/post-43.css?ver=1649162018' media='all' />
<link rel='stylesheet' id='elementor-post-249-css'  href='/wp-content/uploads/elementor/css/post-249.css?ver=1649109078' media='all' />
<link rel='stylesheet' id='generate-offside-css'  href='/wp-content/plugins/gp-premium/menu-plus/functions/css/offside.min.css?ver=2.1.2' media='all' />
<style id='generate-offside-inline-css'>
.slideout-navigation.main-navigation{background-color:rgba(10,10,10,0.95);}.slideout-navigation.main-navigation .main-nav ul li a{color:#ffffff;}.slideout-navigation.main-navigation ul ul{background-color:rgba(0,0,0,0);}.slideout-navigation.main-navigation .main-nav ul ul li a{color:#ffffff;}.slideout-navigation.main-navigation .main-nav ul li:not([class*="current-menu-"]):hover > a, .slideout-navigation.main-navigation .main-nav ul li:not([class*="current-menu-"]):focus > a, .slideout-navigation.main-navigation .main-nav ul li.sfHover:not([class*="current-menu-"]) > a{background-color:rgba(0,0,0,0);}.slideout-navigation.main-navigation .main-nav ul ul li:not([class*="current-menu-"]):hover > a, .slideout-navigation.main-navigation .main-nav ul ul li:not([class*="current-menu-"]):focus > a, .slideout-navigation.main-navigation .main-nav ul ul li.sfHover:not([class*="current-menu-"]) > a{background-color:rgba(0,0,0,0);}.slideout-navigation.main-navigation .main-nav ul li[class*="current-menu-"] > a{background-color:rgba(0,0,0,0);}.slideout-navigation.main-navigation .main-nav ul ul li[class*="current-menu-"] > a{background-color:rgba(0,0,0,0);}.slideout-navigation, .slideout-navigation a{color:#ffffff;}.slideout-navigation button.slideout-exit{color:#ffffff;padding-left:20px;padding-right:20px;}.slide-opened nav.toggled .menu-toggle:before{display:none;}@media (max-width: 1024px){.menu-bar-item.slideout-toggle{display:none;}}
</style>
<link rel='stylesheet' id='google-fonts-1-css'  href='https://fonts.googleapis.com/css?family=Montserrat%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;display=auto&#038;ver=5.9.2' media='all' />
<link rel='stylesheet' id='elementor-icons-shared-0-css'  href='/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.3' media='all' />
<link rel='stylesheet' id='elementor-icons-fa-solid-css'  href='/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css?ver=5.15.3' media='all' />

</head>
<body class="page-template-default page page-id-43 page-child parent-pageid-16 wp-custom-logo wp-embed-responsive post-image-aligned-center slideout-enabled slideout-mobile sticky-menu-fade no-sidebar nav-float-right one-container nav-search-enabled header-aligned-left dropdown-hover elementor-default elementor-kit-6 elementor-page elementor-page-43" itemtype="https://schema.org/WebPage" itemscope>
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-dark-grayscale"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 0.49803921568627" /><feFuncG type="table" tableValues="0 0.49803921568627" /><feFuncB type="table" tableValues="0 0.49803921568627" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-grayscale"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 1" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0 1" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-purple-yellow"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.54901960784314 0.98823529411765" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0.71764705882353 0.25490196078431" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-blue-red"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 1" /><feFuncG type="table" tableValues="0 0.27843137254902" /><feFuncB type="table" tableValues="0.5921568627451 0.27843137254902" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-midnight"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 0" /><feFuncG type="table" tableValues="0 0.64705882352941" /><feFuncB type="table" tableValues="0 1" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-magenta-yellow"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.78039215686275 1" /><feFuncG type="table" tableValues="0 0.94901960784314" /><feFuncB type="table" tableValues="0.35294117647059 0.47058823529412" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-purple-green"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.65098039215686 0.40392156862745" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0.44705882352941 0.4" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-blue-orange"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.098039215686275 1" /><feFuncG type="table" tableValues="0 0.66274509803922" /><feFuncB type="table" tableValues="0.84705882352941 0.41960784313725" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg>
	<div class="header-wrap"><a class="screen-reader-text skip-link" href="#content" title="Skip to content">Skip to content</a>		<div class="top-bar top-bar-align-right">
			<div class="inside-top-bar grid-container">
				<aside id="nav_menu-2" class="widget inner-padding widget_nav_menu"><div class="menu-top-bar-container"><ul id="menu-top-bar" class="menu"><li id="menu-item-126" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-126"><a target="_blank" rel="noopener" href="https://shop-oldfilm.myshopify.com/">Shop</a></li>
<li id="menu-item-39" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-39"><a href="/contact-us/">Contact Us</a></li>
</ul></div></aside><aside id="block-7" class="widget inner-padding widget_block">
<ul class="wp-container-62505766cfb2c wp-block-social-links has-icon-color is-style-logos-only"><li style="color: var(--base); " class="wp-social-link wp-social-link-facebook wp-block-social-link"><a href="https://www.facebook.com/northeasthistoricfilm" aria-label="Facebook: https://www.facebook.com/northeasthistoricfilm" rel="noopener nofollow" target="_blank" class="wp-block-social-link-anchor"> <svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg></a></li>

<li style="color: var(--base); " class="wp-social-link wp-social-link-twitter wp-block-social-link"><a href="https://twitter.com/oldfilmarchives" aria-label="Twitter: https://twitter.com/oldfilmarchives" rel="noopener nofollow" target="_blank" class="wp-block-social-link-anchor"> <svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><path d="M22.23,5.924c-0.736,0.326-1.527,0.547-2.357,0.646c0.847-0.508,1.498-1.312,1.804-2.27 c-0.793,0.47-1.671,0.812-2.606,0.996C18.324,4.498,17.257,4,16.077,4c-2.266,0-4.103,1.837-4.103,4.103 c0,0.322,0.036,0.635,0.106,0.935C8.67,8.867,5.647,7.234,3.623,4.751C3.27,5.357,3.067,6.062,3.067,6.814 c0,1.424,0.724,2.679,1.825,3.415c-0.673-0.021-1.305-0.206-1.859-0.513c0,0.017,0,0.034,0,0.052c0,1.988,1.414,3.647,3.292,4.023 c-0.344,0.094-0.707,0.144-1.081,0.144c-0.264,0-0.521-0.026-0.772-0.074c0.522,1.63,2.038,2.816,3.833,2.85 c-1.404,1.1-3.174,1.756-5.096,1.756c-0.331,0-0.658-0.019-0.979-0.057c1.816,1.164,3.973,1.843,6.29,1.843 c7.547,0,11.675-6.252,11.675-11.675c0-0.178-0.004-0.355-0.012-0.531C20.985,7.47,21.68,6.747,22.23,5.924z"></path></svg></a></li>

<li style="color: var(--base); " class="wp-social-link wp-social-link-instagram wp-block-social-link"><a href="https://www.instagram.com/northeasthistoricfilm/?hl=en" aria-label="Instagram: https://www.instagram.com/northeasthistoricfilm/?hl=en" rel="noopener nofollow" target="_blank" class="wp-block-social-link-anchor"> <svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><path d="M12,4.622c2.403,0,2.688,0.009,3.637,0.052c0.877,0.04,1.354,0.187,1.671,0.31c0.42,0.163,0.72,0.358,1.035,0.673 c0.315,0.315,0.51,0.615,0.673,1.035c0.123,0.317,0.27,0.794,0.31,1.671c0.043,0.949,0.052,1.234,0.052,3.637 s-0.009,2.688-0.052,3.637c-0.04,0.877-0.187,1.354-0.31,1.671c-0.163,0.42-0.358,0.72-0.673,1.035 c-0.315,0.315-0.615,0.51-1.035,0.673c-0.317,0.123-0.794,0.27-1.671,0.31c-0.949,0.043-1.233,0.052-3.637,0.052 s-2.688-0.009-3.637-0.052c-0.877-0.04-1.354-0.187-1.671-0.31c-0.42-0.163-0.72-0.358-1.035-0.673 c-0.315-0.315-0.51-0.615-0.673-1.035c-0.123-0.317-0.27-0.794-0.31-1.671C4.631,14.688,4.622,14.403,4.622,12 s0.009-2.688,0.052-3.637c0.04-0.877,0.187-1.354,0.31-1.671c0.163-0.42,0.358-0.72,0.673-1.035 c0.315-0.315,0.615-0.51,1.035-0.673c0.317-0.123,0.794-0.27,1.671-0.31C9.312,4.631,9.597,4.622,12,4.622 M12,3 C9.556,3,9.249,3.01,8.289,3.054C7.331,3.098,6.677,3.25,6.105,3.472C5.513,3.702,5.011,4.01,4.511,4.511 c-0.5,0.5-0.808,1.002-1.038,1.594C3.25,6.677,3.098,7.331,3.054,8.289C3.01,9.249,3,9.556,3,12c0,2.444,0.01,2.751,0.054,3.711 c0.044,0.958,0.196,1.612,0.418,2.185c0.23,0.592,0.538,1.094,1.038,1.594c0.5,0.5,1.002,0.808,1.594,1.038 c0.572,0.222,1.227,0.375,2.185,0.418C9.249,20.99,9.556,21,12,21s2.751-0.01,3.711-0.054c0.958-0.044,1.612-0.196,2.185-0.418 c0.592-0.23,1.094-0.538,1.594-1.038c0.5-0.5,0.808-1.002,1.038-1.594c0.222-0.572,0.375-1.227,0.418-2.185 C20.99,14.751,21,14.444,21,12s-0.01-2.751-0.054-3.711c-0.044-0.958-0.196-1.612-0.418-2.185c-0.23-0.592-0.538-1.094-1.038-1.594 c-0.5-0.5-1.002-0.808-1.594-1.038c-0.572-0.222-1.227-0.375-2.185-0.418C14.751,3.01,14.444,3,12,3L12,3z M12,7.378 c-2.552,0-4.622,2.069-4.622,4.622S9.448,16.622,12,16.622s4.622-2.069,4.622-4.622S14.552,7.378,12,7.378z M12,15 c-1.657,0-3-1.343-3-3s1.343-3,3-3s3,1.343,3,3S13.657,15,12,15z M16.804,6.116c-0.596,0-1.08,0.484-1.08,1.08 s0.484,1.08,1.08,1.08c0.596,0,1.08-0.484,1.08-1.08S17.401,6.116,16.804,6.116z"></path></svg></a></li></ul>
</aside>			</div>
		</div>
				

	<!-- -------------------------------------------HEADER SOURCE-CODE---------------------------------------------------------- -->


	<header class="site-header has-inline-mobile-toggle" aria-label="Site" itemtype="https://schema.org/WPHeader" itemscope="" id="main" >
		<div class="inside-header grid-container">
			<div class="site-logo">
				<a href="/" title="Northeast Historic Film" rel="home">
					<img class="header-image is-logo-image" alt="Northeast Historic Film" src="/wp-content/uploads/2022/03/logo.png" title="Northeast Historic Film" width="111" height="126">
				</a>
			</div>	
				<nav class="main-navigation mobile-menu-control-wrapper" id="mobile-menu-control-wrapper" aria-label="Mobile Toggle">
					<div class="menu-bar-items">
						<span class="menu-bar-item search-item">
							<a aria-label="Open Search Bar" href="#">
								<span class="gp-icon icon-search">
									<svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path fill-rule="evenodd" clip-rule="evenodd" d="M208 48c-88.366 0-160 71.634-160 160s71.634 160 160 160 160-71.634 160-160S296.366 48 208 48zM0 208C0 93.125 93.125 0 208 0s208 93.125 208 208c0 48.741-16.765 93.566-44.843 129.024l133.826 134.018c9.366 9.379 9.355 24.575-.025 33.941-9.379 9.366-24.575 9.355-33.941-.025L337.238 370.987C301.747 399.167 256.839 416 208 416 93.125 416 0 322.875 0 208z"></path></svg><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z"></path></svg>
								</span>
							</a>
						</span>
					</div>		
					<button data-nav="site-navigation" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="gp-icon icon-menu-bars"><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M0 96c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24z"></path></svg><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z"></path></svg></span><span class="screen-reader-text">Menu</span>		
					</button>
				</nav>

			<nav class="main-navigation has-menu-bar-items sub-menu-right" id="site-navigation" aria-label="Primary" itemtype="https://schema.org/SiteNavigationElement" itemscope="">

				<div class="inside-navigation grid-container">

						<form method="get" class="search-form navigation-search" action="/">
							<input type="search" placeholder="Enter Your Search..." class="search-field" value="" name="s" title="Search">
						</form>	

						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span class="gp-icon icon-menu-bars">
								<svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em">
									<path d="M0 96c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24z">
									</path>
								</svg>
								<svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em">
									<path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z">
									</path>
								</svg>
							</span>
							<span class="screen-reader-text">Menu</span>				
						</button>

						<div id="primary-menu" class="main-nav">
							<ul id="menu-primary" class=" menu sf-menu">

								<li id="menu-item-415" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-8 current_page_item menu-item-415">
									<a href="https://oldfilm.org" aria-current="page">Home</a>
								</li>

								<li id="menu-item-23" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-23">
									<a href="https://oldfilm.org/give/">Give<span role="presentation" class="dropdown-menu-toggle"><span class="gp-icon icon-arrow"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span></a>

									<ul class="sub-menu">
										<li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38"><a href="https://oldfilm.org/give/membership/">Membership</a></li>
										<li id="menu-item-96" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-96"><a href="https://oldfilm.org/give/donate/">Donate</a></li>
										<li id="menu-item-98" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-98"><a href="https://oldfilm.org/give/volunteering-internships/">Volunteering &amp; Internships</a></li>
										<li id="menu-item-99" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-99"><a href="https://oldfilm.org/give/william-s-ofarrell-fellowship/">William S. O’Farrell Fellowship</a></li>
										<li id="menu-item-102" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-102"><a href="https://oldfilm.org/give/donate-film-equipment/">Donate Film &amp; Equipment</a></li>
										<li id="menu-item-100" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-100"><a href="https://oldfilm.org/give/collecting-policy/">Collecting Policy</a></li>
									</ul>
								</li>

								<li id="menu-item-33" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-33"><a href="https://oldfilm.org/explore/">Explore<span role="presentation" class="dropdown-menu-toggle"><span class="gp-icon icon-arrow"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span></a>
									<ul class="sub-menu">
										<!-- <li id="menu-item-101" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-101"><a href="https://oldfilm.org/explore/collections/">Collections</a></li> -->
										<li id="menu-item-101" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-101"><a href="https://oldfilm.org/explore">Collections</a></li>
										<li id="menu-item-103" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-103"><a href="https://oldfilm.org/explore/exhibits/">Exhibits</a></li>
									</ul>
								</li>

								<li id="menu-item-35" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-35"><a href="https://oldfilm.org/services/">Services<span role="presentation" class="dropdown-menu-toggle"><span class="gp-icon icon-arrow"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span></a>
									<ul class="sub-menu">
										<li id="menu-item-109" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-109"><a href="https://oldfilm.org/services/moving-image-transfers/">Moving Image Transfers</a></li>
										<li id="menu-item-112" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-112"><a href="https://oldfilm.org/services/storage/">Storage</a></li>
										<li id="menu-item-111" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-111"><a href="https://oldfilm.org/services/stock-footage-licensing/">Stock Footage Licensing</a></li>
										<li id="menu-item-104" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-104"><a href="https://oldfilm.org/explore/request-footage-research/">Request Footage &amp; Research</a></li>
									</ul>
								</li>

								<li id="menu-item-36" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-36"><a href="https://oldfilm.org/alamo-theatre/">Alamo Theatre<span role="presentation" class="dropdown-menu-toggle"><span class="gp-icon icon-arrow"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span></a>
									<ul class="sub-menu">
										<li id="menu-item-115" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-115"><a href="https://oldfilm.org/alamo-theatre/history-purpose/">History</a></li>
										<li id="menu-item-116" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-116"><a href="https://oldfilm.org/alamo-theatre/renting-the-venue/">Renting The Venue</a></li>
										<li id="menu-item-107" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107"><a href="https://oldfilm.org/alamo-theatre/archived-events/">Archived Events</a></li>
										<li id="menu-item-107" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107"><a href="https://oldfilm.org/alamo-theatre/sponsor-a-movie/">Sponsor a Movie</a></li>
									</ul>
								</li>

								<li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-29"><a href="https://oldfilm.org/about-us/">About<span role="presentation" class="dropdown-menu-toggle"><span class="gp-icon icon-arrow"><svg viewBox="0 0 330 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.913 197.085c0 2.266-1.133 4.815-2.833 6.514L171.087 335.593c-1.7 1.7-4.249 2.832-6.515 2.832s-4.815-1.133-6.515-2.832L26.064 203.599c-1.7-1.7-2.832-4.248-2.832-6.514s1.132-4.816 2.832-6.515l14.162-14.163c1.7-1.699 3.966-2.832 6.515-2.832 2.266 0 4.815 1.133 6.515 2.832l111.316 111.317 111.316-111.317c1.7-1.699 4.249-2.832 6.515-2.832s4.815 1.133 6.515 2.832l14.162 14.163c1.7 1.7 2.833 4.249 2.833 6.515z"></path></svg></span></span></a>
									<ul class="sub-menu" style="z-index: 30000;">
										<li id="menu-item-117" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-117"><a href="https://oldfilm.org/about-us/about-film-preservation/">About Film Preservation</a></li>
										<li id="menu-item-121" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-121"><a href="https://oldfilm.org/about-us/history/">History</a></li>
										<li id="menu-item-122" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-122"><a href="https://oldfilm.org/about-us/news/">News</a></li>
										<li id="menu-item-123" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-123"><a href="https://oldfilm.org/about-us/partners/">Partners</a></li>
										<li id="menu-item-125" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-125"><a href="https://oldfilm.org/about-us/staff-board-advisors/">Staff, Board &amp; Advisors</a></li>
										<li id="menu-item-119" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-119"><a href="https://oldfilm.org/about-us/employment/">Employment</a></li>
										<li id="menu-item-124" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-124"><a href="https://oldfilm.org/about-us/projects/">Projects</a></li>
										<li id="menu-item-118" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-118"><a href="https://oldfilm.org/about-us/core-documents/">Core Documents</a></li>
										<li id="menu-item-120" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-120"><a href="https://oldfilm.org/about-us/faqs/">FAQs</a></li>
										<li id="menu-item-105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="https://oldfilm.org/about-us/moving-image-review/">Moving Image Review</a></li>
										<li id="menu-item-105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="https://oldfilm.org/about-us/projects-using-our-footage/">Publications</a></li>
										<li id="menu-item-105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="https://oldfilm.org/about-us/collecting-policy/">Collecting Policy</a></li>
									</ul>
								</li>

								<li id="menu-item-31" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31"><a href="https://oldfilm.org/contact-us/">Contact</a></li>
							</ul>
						</div>

					<div class="menu-bar-items">
						<span class="menu-bar-item search-item"><a aria-label="Open Search Bar" href="#"><span class="gp-icon icon-search"><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path fill-rule="evenodd" clip-rule="evenodd" d="M208 48c-88.366 0-160 71.634-160 160s71.634 160 160 160 160-71.634 160-160S296.366 48 208 48zM0 208C0 93.125 93.125 0 208 0s208 93.125 208 208c0 48.741-16.765 93.566-44.843 129.024l133.826 134.018c9.366 9.379 9.355 24.575-.025 33.941-9.379 9.366-24.575 9.355-33.941-.025L337.238 370.987C301.747 399.167 256.839 416 208 416 93.125 416 0 322.875 0 208z"></path></svg><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z"></path></svg></span></a></span>
					</div>			
				</div>
			</nav>
		</div>

	</header>
</div><!-- .header-wrap -->

<div class="entry-content" itemprop="text" style="padding-top: 30px;"> 
	<!-- style="position:absolute" -->
	<div data-elementor-type="wp-page" data-elementor-id="43" class="elementor elementor-43" >
		<section class="elementor-section elementor-top-section elementor-element elementor-element-a8baf76 elementor-section-height-min-height elementor-section-items-bottom elementor-section-stretched page-banner elementor-section-boxed elementor-section-height-default" data-id="a8baf76" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}" style="width: 1188px; left: -30px; margin-bottom: 10px;">
			<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-ecf214f" data-id="ecf214f" data-element_type="column">
					<div class="elementor-widget-wrap elementor-element-populated">
						<div class="elementor-element elementor-element-9a74ffb elementor-widget elementor-widget-heading" data-id="9a74ffb" data-element_type="widget" data-widget_type="heading.default">
							<div class="elementor-widget-container">
								<style>/*! elementor - v3.6.2 - 04-04-2022 */
									.elementor-heading-title{padding:0;margin:0;line-height:1}.elementor-widget-heading .elementor-heading-title[class*=elementor-size-]>a{color:inherit;font-size:inherit;line-height:inherit}.elementor-widget-heading .elementor-heading-title.elementor-size-small{font-size:15px}.elementor-widget-heading .elementor-heading-title.elementor-size-medium{font-size:19px}.elementor-widget-heading .elementor-heading-title.elementor-size-large{font-size:29px}.elementor-widget-heading .elementor-heading-title.elementor-size-xl{font-size:39px}.elementor-widget-heading .elementor-heading-title.elementor-size-xxl{font-size:59px}
								</style>
								<h2 class="elementor-heading-title elementor-size-default">Collections</h2>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>



<div class="container collection-nav-container"><div style="display:inline-block;">

			
			<nav class="collection-nav" aria-label="Primary" itemtype="https://schema.org/SiteNavigationElement" itemscope="">
				<ul class="collection-menu">

					<li class="coll-menu-item">
						<a href="https://oldfilm.org/explore">Overview</a>
					</li>

					<li class="coll-menu-item">
						<?php print caNavLink($this->request, 'Browse Collections', '', '', 'Browse', 'collections', ''); ?>
					</li>
					

					<li class="coll-menu-item">
						<?php print caNavLink($this->request, 'Browse Works', '', '', 'Browse', 'works', ''); ?>
					</li>

				</ul>
			</nav>
			<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'Works'); ?>" aria-label="<?php print _t("Search"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search Works" name="search" autocomplete="off" aria-label="<?php print _t("Search works"); ?>" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>
					</div>
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
			
		<!-- </div> -->
	</div></div>        

	<script type="text/javascript">
		$(document).ready(function(){
			$('#headerSearchButton').prop('disabled',true);
			$('#headerSearchInput').on('keyup', function(){
				$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
			})
		});
	</script>

	<div class="container" style="max-width: 1140px;">
		<div class="row">
		<div class="col-xs-12">
			<div role="main" id="main">
				<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
