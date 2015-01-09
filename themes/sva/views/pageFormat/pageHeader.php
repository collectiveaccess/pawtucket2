<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$vs_user_links = "";
	if($this->request->isLoggedIn()){
		$vs_user_links .= '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$vs_user_links .= '<li class="divider nav-divider"></li>';
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Lightbox'), '', '', 'Sets', 'Index', array())."</li>";
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
	<title>Milton Glaser Design Study Center And Archives</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link href="http://www.glaserarchives.org/style.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="http://www.glaserarchives.org/favicon.png" />
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
<?php
	//
	// Pull in JS and CSS for debug bar
	// 
	if(Debug::isEnabled()) {
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
		<style type="text/css" id="mti_stylesheet_08d66479-d029-4b18-b2e5-1459df4ebe21">h1{font-family:'Bodoni W01 Roman';}</style>
		<script type="text/javascript" src="http://fast.fonts.com/jsapi/08d66479-d029-4b18-b2e5-1459df4ebe21.js"></script>
		<style type="text/css" id="mti_fontface_08d66479-d029-4b18-b2e5-1459df4ebe21">@font-face{
		font-family:"Bodoni W01 Roman";
		src:url("http://fast.fonts.net/dv2/3/cd77f8b9-e937-4ea5-a635-19a0db457df1.woff?d44f19a684109620e484157ca690e818629213b3c1b3910625d8216115a5a5131ffbf0feeffd5f43fd8aa743fe1afe927e55a2988a6f60ba8228d62b654775b4bd4e0c8352362cb34d52a3662b7fb75a170967e150703065ad24520f8ac5b711f9123633e58205a66d235ba2d0c2de3c20093c45abc2c3824cf72f531131a1728e77ca9ccac5e952719baf1bb472710aa685be871b840b&projectId=08d66479-d029-4b18-b2e5-1459df4ebe21") format('woff');}
		</style>
		<link id="MonoTypeFontApiFontTracker" type="text/css" rel="stylesheet" href="http://fast.fonts.net/t/1.css?apiType=js&amp;projectid=08d66479-d029-4b18-b2e5-1459df4ebe21">		
</head>
<body style='background-image: url("http://www.glaserarchives.org/bg/0.jpg");'>

<div id="container">

	<div id="tabs"><img src="http://www.glaserarchives.org/images/design-tab.png"><a href="http://www.svaarchives.org/"><img src="http://www.glaserarchives.org/images/sva-tab.png"></a><a href="http://containerlist.glaserarchives.org/"><img src="http://www.glaserarchives.org/images/blog-tab.png"></a></div>
	<div id="header">
		<div id="home">
			<a href="http://www.glaserarchives.org/index.html"><img src="http://www.glaserarchives.org/mast.gif" alt="Milton Glaser Design Archive and Study Center"></a>
			<div class='clearfix'></div>
		</div>
	</div>
	
	<div id="main" <?php print caGetPageCSSClasses(); ?>>

		<div id="navigation">
			<ul>
				<li style="border: 0"><a href="http://www.glaserarchives.org/">ABOUT</a></li>
				<li><a href="http://www.glaserarchives.org/holdings.html">COLLECTIONS</a></li>
				<li class="active"><?php print caNavLink($this->request, 'DIGITAL ARCHIVE', '', '', '', '');?></a></li>
			</ul>
		</div>
<?php		
		if (($this->request->getController() != "Front") && ($this->request->getController() != "AdvancedSearch")) {
?>		
		<div id="search"><form class="svasearch" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
			<div class="">
				<div class="">
					<input type="text" class="svaform" placeholder="" name="search">
				</div>
				<button type="submit" class="btn-search"><!--<span class="glyphicon glyphicon-search"></span>--></button>
			</div>
		</form></div>
<?php
		}
?>		

