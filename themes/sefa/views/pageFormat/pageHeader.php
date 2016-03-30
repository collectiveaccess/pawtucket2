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
		$vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
		$vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";
	}
	# --- check if there is a current exhibition
	$o_occ_search = caGetSearchInstance("ca_occurrences");
	$va_access_values = caGetUserAccessValues($this->request);
	$qr_res = $o_occ_search->search("current_exh:yes", array("checkAccess" => $va_access_values, "sort" => "ca_occurrences.opening_closing", "sortDirection" => "desc"));
	$vn_current_exhibition = null;
	if($qr_res->numHits()){
		$qr_res->nextHit();
		$vn_current_exhibition = $qr_res->get("ca_occurrences.occurrence_id");
		$this->request->session->setVar("current_exhibition_id", $vn_current_exhibition);
	}else{
		$this->request->session->setVar("current_exhibition_id", "");
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	<meta name="description" content="The official site for Susan Eley Fine Art, a salon-style gallery showcasing contemporary artists, located in a Landmarked Upper West Side townhouse in Manhattan.">
	<meta name="keywords" content="Gallery, Art, Contemporary, New York, Salon, Paintings, Photographs">

	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
</head>
<body>
	<div class="container">	
		<nav class="navbar navbar-default" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'SusanEleyFineArt.png'), "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li <?php print (in_array(mb_strtolower($this->request->getAction()), array("exhibitions", "past_exhibitions", "upcoming_exhibitions"))) ? 'class="active"' : ''; ?>><?php print ($vn_current_exhibition) ? caDetailLink($this->request, _t("Exhibitions"), '', 'ca_occurrences', $vn_current_exhibition, null, null, array("action" => "exhibitions")) : caNavLink($this->request, _t("Exhibitions"), "", "", "Listing", "past_exhibitions"); ?></li>
					<li <?php print (mb_strtolower($this->request->getAction()) == "artists") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artists"), "", "", "Listing", "Artists"); ?></li>
					<li><a href="/news/?m=<?php print date("Y"); ?>">Blog</a></li>
					<li <?php print (mb_strtolower($this->request->getAction()) == "fairs") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Art Fairs"), "", "", "Listing", "Fairs"); ?></li>
					<li <?php print (mb_strtolower($this->request->getAction()) == "publications") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Publications"), "", "", "Listing", "Publications"); ?></li>
					<li <?php print ((mb_strtolower($this->request->getController()) == "about") && (mb_strtolower($this->request->getAction()) != "mailinglist")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Gallery"); ?></li>
					<li <?php print (mb_strtolower($this->request->getController()) == "contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div><!-- end container -->
	<div class="container">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
