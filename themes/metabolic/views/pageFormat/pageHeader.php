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
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
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
<?php
	if(Debug::isEnabled()) {		
		//
		// Pull in JS and CSS for debug bar
		// 
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
</head>
<body>
<div id='bodyDiv'>
	<div id="header">
	  <div class="logo">
		
<?php
		print caNavLink($this->request, caGetThemeGraphic($this->request, 'metabolic_logo.png'), "", "", "", "");
?>
		
	
	  </div>
	  <div class="portal">

		<div id="search">
			<form name="header_search" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" method="get">
			
				<!-- <div id="searchButton"><input style='width:47px' type="submit" value="Search" /></div> -->
				<div id="searchElement">
					<input type="text" placeholder="Search" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="30"/>

					<div class='advancedSearch'><?php print caNavLink($this->request, _t("advanced search"), "", "Search", "advanced", "optics");?></div>
				</div>
				
			</form>
			
		</div><!-- end search -->
		
	  </div><!-- end portal -->
	  <div id="nav">
		
<?php				

			print "<div style='float:left; text-transform:uppercase;'>";
			#join(" ", $this->getVar('nav')->getHTMLMenuBarAsLinkArray());
			print caNavLink($this->request, _t("About"), "", "", "About", "Index");
			print caNavLink($this->request, _t("Browse"), "", "", "About", "browse");
			print caNavLink($this->request, _t("My Sets"), "", "", "Lightbox", "Index");
			#print caNavLink($this->request, _t("Chronology"), "", "MetabolicChronology", "Show", "Index");
			print caNavLink($this->request, _t("Collection"), "", "", "Gallery", "Index");
			print caNavLink($this->request, _t("Contribute"), "", "", "Contribute", "archive");
			if($this->request->isLoggedIn()){
				print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "Logout");
			}else{
				print caNavLink($this->request, _t("Login"), "", "", "LoginReg", "LoginForm");
			}
			print "</div>";


	

?>		
		</div><!-- end nav -->
	</div><!-- end header -->
<?php
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>	
	<div class="container" style="clear:both;"><div class="row"><div class="col-xs-12" style="padding:0px;">
<?php	
	$vs_controller = $this->request->getController();
	if (in_array($vs_controller, array('Detail', 'Form', 'Share', 'Contribute'))) {
		print "<div id='detailPageAreaBorder'><div id='detailPageArea'>";
	} else {
		print "<div id='pageArea' ".caGetPageCSSClasses().">";
	}	
?>			
						
