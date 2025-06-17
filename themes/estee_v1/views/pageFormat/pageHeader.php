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
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
    <meta name="pinterest" content="nopin" />
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

</head>
<body>
<?php
	if(strtoLower($this->request->getController()) == "front"){
		print "<div class='heroFixed'><div class='container'><div class='row'><div class='col-sm-12'>".caGetThemeGraphic($this->request, 'hero_5.jpg')."</div></div></div></div>";
	}
?>
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<?php print "<div class='pull-left hamburger'>".caGetThemeGraphic($this->request, 'hamburger.png')."</div>"; ?>
				<button type="button" class="navSearchToggle" onClick="showHideSearch();"><span class="glyphicon glyphicon-search"></span><span class="glyphicon glyphicon-remove"></span></button>
				<script type="text/javascript">
					function showHideSearch(){
						jQuery('.navSearchContainer').toggle(1, function(){
							if($('.menuItems').hasClass('show')){
								$('.menuItems').removeClass("show");
							}else{
								$('.menuItems').addClass("show");
							}
							jQuery('.navSearchBar').slideToggle(300, function(){
								jQuery('.navSearchDimOverlay').height($( window ).height() - $('.navSearchDimOverlay').scrollTop());
							});
							jQuery('.navSearchToggle .glyphicon').toggle();							
							if($(".navbar").hasClass("opaque")){
								$(".navbar").removeClass("opaque");
							}else{
								$(".navbar").addClass("opaque");
							}
						}); 
					}
				</script>
					<?php print "<div class='hamburgerCollapseMenu pull-left' data-toggle='collapse' data-target='#bs-main-navbar-collapse-1'>".caGetThemeGraphic($this->request, 'hamburger.png')."</div>"; ?>
				 
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'estee_lauder-logo-white-thick-660.png'), "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($x && $vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<ul class="nav navbar-nav menuItems">
					<li <?php print (strToLower($this->request->getController()) == "about") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", ""); ?></li>
					<li <?php print (strToLower($this->request->getController()) == "gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Galleries"), "", "", "Gallery", "Index"); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") || (strToLower($this->request->getController()) == "explore")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Explore", "Brands"); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "collections") || ((strToLower($this->request->getController()) == "detail") && (strToLower($this->request->getAction()) == "collections"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Guides"), "", "", "Collections", "Index"); ?></li>
					<li <?php print (strToLower($this->request->getController()) == "faq") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("FAQ"), "", "", "Faq", ""); ?></li>
<?php
	$ps_contactType = $this->request->getParameter("contactType", pString);
?>
					<li <?php print ((strToLower($this->request->getController()) == "contact") && $ps_contactType == "transfer") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Transfer"), "", "", "Contact", "Form", array("contactType" => "transfer")); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "contact") && !$ps_contactType) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
<?php
					if($this->request->isLoggedIn()){
						if(caDisplayLightbox($this->request)){
							print "<li ".((strToLower($this->request->getController()) == "lightbox") ? 'class="active"' : '').">".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
						}		
					}
?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
		</nav>
		<div class="navSearchContainer">
			<div class="navSearch">
				<div class="navSearchBar">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">				
									<div class="form-group">
										<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search"></span></button>
										<input type="text" class="form-control" id="headerSearchInput" placeholder="Search All" name="search">
									</div>
						
								</form>
								<script type="text/javascript">
									$(document).ready(function(){
										$('#headerSearchButton').prop('disabled',true);
										$('#headerSearchInput').keyup(function(){
											$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
										})
									});
								</script>
							</div>
						</div>
					</div>
				</div>
				<div class="navSearchDimOverlay">
					<div class="container">
						<div class="row">
							<div class="col-sm-12"><div class="quickSearchHelp">End product code searches with an asterisk (*)</div></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
