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
	$va_user_links[] = "<li>".caNavLink($this->request, _t('User profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
	$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
} else {
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
}
$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-VJDX8CGCLR"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-VJDX8CGCLR');
		</script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<script type="text/javascript">
			let pawtucketUIApps = {};
	</script>
	
	<script src="<?= $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
	<script src="<?= $this->request->getThemeUrlPath(); ?>/assets/main.js"></script>
	
<!-- code to set open graph tags (primarily for facebook sharing) -->
<meta property="og:url" content="<?= $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= $this->request->config->get("app_display_name"); ?>" />
<?php
# --- what should the image to share be?
# --- default to logo --- use image from detail page if on object page
$vs_og_image = $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'archives.png'); # --- replace this with logos for institutions
if((strToLower($this->request->getController()) == "detail") && (strToLower($this->request->getAction()) == "objects")){
	$ps_id = str_replace("~", "/", urldecode($this->request->getActionExtra()));
	$vs_use_alt_identifier_in_urls = caUseAltIdentifierInUrls("ca_objects");
	$t_subject = new ca_objects();
	if ((($vb_use_identifiers_in_urls = caUseIdentifiersInUrls()) || ($vs_use_alt_identifier_in_urls)) && (substr($ps_id, 0, 3) == "id:")) {
		$va_tmp = explode(":", $ps_id);
		$ps_id = (int)$va_tmp[1];
		$vb_use_identifiers_in_urls = $vs_use_alt_identifier_in_urls = false;
	}

	if($vs_use_alt_identifier_in_urls && $t_subject->hasElement($vs_use_alt_identifier_in_urls)) {
		$va_load_params = [$vs_use_alt_identifier_in_urls => $ps_id];
	} elseif ($vb_use_identifiers_in_urls && $t_subject->getProperty('ID_NUMBERING_ID_FIELD')) {
		$va_load_params = [$t_subject->getProperty('ID_NUMBERING_ID_FIELD') => $ps_id];
	} else {
		$va_load_params = [$t_subject->primaryKey() => (int)$ps_id];
	}

	if (!($t_subject = call_user_func_array($t_subject->tableName().'::find', array($va_load_params, ['returnAs' => 'firstModelInstance'])))) {
		// invalid id - throw error
		throw new ApplicationException("Invalid id");
	}else{
		if($vs_rep = $t_subject->get("ca_object_representations.media.large.url", array("checkAccess" => $va_access_values))){
			$vs_og_image = $vs_rep;
			// TG added 11/2022 (get height & width for large image to add to og:image tags & Photo title for description)
			$vs_og_image_h = $t_subject->get("ca_object_representations.media.large.height", array("checkAccess" => $va_access_values));
			$vs_og_image_w = $t_subject->get("ca_object_representations.media.large.width", array("checkAccess" => $va_access_values));
			$vs_og_description = $t_subject->get("ca_objects.description", array("checkAccess" => $va_access_values));
		}
	}
}
?>
<meta property="og:image" content="<?= $vs_og_image; ?>" />
<!-- TG added 11/2022 (add og:image:height and ...:width tages) -->
<meta property="og:image:height" content="<?= $vs_og_image_h; ?>" />
<meta property="og:image:width" content="<?= $vs_og_image_w; ?>" />
<meta property="og:image:alt" content="<?= $vs_og_description; ?>" />
<meta property="og:description" content="<?= $vs_og_description; ?>" />
	<?= MetaTagManager::getHTML(); ?>
	<?= AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?= (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>

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
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
<?php
	if ($vb_has_user_links) {
?>
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<span class="glyphicon glyphicon-user"></span>
				</button>
<?php
	}
?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'grpl_logo.png'), "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">
					<?= join("\n", $va_user_links); ?>
				</ul>
			</div>
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu" style="left:auto; right:0;"><?= join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?= caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search"></span></button>
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
				<ul class="nav navbar-nav navbar-right menuItems">
					<!--<li <?php #print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>-->
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Quick links</span></a>
						<ul class="dropdown-menu">
							<li <?= ($this->request->getController() == "Collection") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("View collections"), "", "", "Browse", "Collections"); ?></li>
							<li <?= ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("View exhibits"), "", "", "Gallery", "Index"); ?></li>
							<li><?= caNavLink($this->request, "<span>"._t("Browse images")."</span>", "", "", "Browse", "Objects", array("facet" => "type_facet", "id" => 33, "view" => "images")); ?></li>
							<li><?= caNavLink($this->request, "<span>"._t("View map")."</span>", "", "", "Browse", "Objects", array("facet" => "type_facet", "id" => 37, "view" => "map")); ?></li>
							<li <?= (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced/publications")) ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Search newspapers"), "", "", "Search", "advanced/publications"); ?></li>
							<li><?= caNavLink($this->request, "<span>"._t("Browse all items")."</span>", "", "", "Browse", "Objects"); ?></li>
						</ul>
					</li>

					<?php #print $this->render("pageFormat/browseMenu.php"); ?>
					<li <?php #print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php #print caNavLink($this->request, _t("Digital Exhibits"), "", "", "Gallery", "Index"); ?></li>
					<li <?= ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Digital collections"), "", "", "Browse", "Collections"); ?></li>
					<li <?= (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></li>
					<li <?php #print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php #print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container <?= join(' ', caGetPageCSSClasses(['asAttribute' => false]) ?? []); ?>"><div class="row"><div class="col-xs-12">
	<div id="pageArea" <?= caGetPageCSSClasses(); ?>>
