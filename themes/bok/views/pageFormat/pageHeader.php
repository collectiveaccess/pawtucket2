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
	# --- session vars for persistent browse filters
	$pn_user_category = $this->request->getParameter('user_category', pInteger);
	if($pn_user_category && ($pn_user_category != $this->request->session->getVar("bokUserCategory"))){
		$this->request->session->setVar("bokUserCategory", $pn_user_category);
		require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
		$t_occurrence = new ca_occurrences();
		$t_occurrence->load($pn_user_category);
		$this->request->session->setVar("bokUserCategoryLabel", strtolower($t_occurrence->get("ca_occurrences.preferred_labels.name")));
		$this->request->session->setVar("bokUserCategoryIdno", strtolower($t_occurrence->get("ca_occurrences.idno")));
	}
	$pn_user_category = $this->request->session->getVar("bokUserCategory");
	$ps_user_category = $this->request->session->getVar("bokUserCategoryLabel");
	$ps_user_category_idno = $this->request->session->getVar("bokUserCategoryIdno");
	
	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$vs_user_links = "";
	if($this->request->isLoggedIn()){
		$vs_user_links .= '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$vs_user_links .= '<li class="divider nav-divider"></li>';
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Lightbox'), '', '', 'Lightbox', 'Index', array())."</li>";
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		$vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
		$vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";
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
</head>
<body>
	<div class="container"><div class="pageBorder">
		<div class="row"><div class="col-sm-12">
				<nav class="navbar navbar-default" role="navigation">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-top">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
<?php
					print "<span class='iucnLogo'>".caGetThemeGraphic($this->request, 'iucn_logo.png')."</span>";
?>
					</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-top">
						<ul class="nav navbar-nav navbar-right navbar-top">
							<li <?php print ($this->request->getController() == "Front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Tools<br/>Overview"), "", "", "", ""); ?></li>
							<li <?php print ($this->request->getController() == "CompetenceStandards") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Competence<br/>Standards"), "", "", "CompetenceStandards", "About"); ?></li>
							<li <?php print (in_array(mb_strtolower($this->request->getController()), array("search", "browse", "detail", "lightbox", "gallery", "contribute", "bodyofknowledge"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Body of<br/>Knowledge"), "", "", "BodyOfKnowledge", "About"); ?></li>
							<li <?php print ($this->request->getController() == "AssessmentCertification") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Performance Assessment <br/>& Certification Guidelines"), "", "", "AssessmentCertification", "About"); ?></li>
							<li <?php print ($this->request->getController() == "SupportingInitiatives") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Supporting<br/>Initiatives"), "", "", "SupportingInitiatives", "About"); ?></li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</nav>
		</div><!-- end col --></div><!-- end row -->
		<div class="row">
   			<div class="col-sm-12">
<?php
				$vn_show_header_hr = false;
				$vn_show_blue_hr = false;
				$vn_show_bok_subnav = false;
				$vs_subtitle = _t("Capacity Development Tools");
				switch($this->request->getController()){
					case "CompetenceStandards":
						$vs_subtitle = _t("Competence Standards");
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'header_cs.jpg'), "", "", "","");
					break;
					# ----------------------------------------------------
					case "AssessmentCertification":
						$vs_subtitle = _t("Performance Assessment & Certification Guidelines");
						$vs_subtitleClass = "title2Small";
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'header_pa.jpg'), "", "", "","");
					break;
					# ----------------------------------------------------
					case "SupportingInitiatives":
						$vn_show_blue_hr = true;
						$vs_subtitle = _t("Supporting Initiatives");
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'header_si.jpg'), "", "", "","");
					break;
					# ----------------------------------------------------
					case "Front":
					case "About":
						$vn_show_header_hr = true;
						$vs_subtitle = _t("Capacity Development Tools");
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'header_home.jpg'), "", "", "","");
					break;
					# ----------------------------------------------------
					default:
						if(in_array($this->request->getAction(), array("About")) || in_array($this->request->getController(), array("Detail"))){
							$vn_show_blue_hr = true;
						}
						if(in_array($this->request->getAction(), array("Content")) || in_array($this->request->getController(), array("Search", "Browse"))){
							$vn_show_bok_subnav = true;
						}
						$vs_subtitle = _t("Body of Knowledge");
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'header_bok.jpg'), "", "", "","");
					break;
					# ----------------------------------------------------
				}
?>		
				
				<div class="mainTitleBg">
					<div id="loginLinks">
<?php
						if($this->request->isLoggedIn()){
							print caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array());
						}else{
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a>";
							print " | <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a>";
						}
?>
					</div>
					<span class="title1"><?php print caNavLink($this->request, _t("IUCN WCPA PROTECTED AREA"), "", "", "",""); ?></span>
					<span class="title2 <?php print $vs_subtitleClass; ?>"><?php print caNavLink($this->request, $vs_subtitle, "", "", "",""); ?></span>
				</div><!-- end mainTitleBg -->
			</div>
		</div>
<?php
	if($vn_show_header_hr){
		print '<HR class="hrFrontPage"/>';
	}
	if($vn_show_blue_hr){
		print '<HR class="hrBlue"/>';
	}
	if($vn_show_bok_subnav){
		# --- do a occurrece search to get all the competences
		$o_search = caGetSearchInstance("ca_occurrences");
		$t_lists = new ca_lists();
		$vn_category_type_id = $t_lists->getItemIDFromList("occurrence_types", "category");
		$qr_res = $o_search->search('type_id:'.$vn_category_type_id, $va_options['sort'] = "ca_occurrences.preferred_labels.name");
		$va_all_competences = array();
		$va_competences_by_area = array();
		if($qr_res->numHits()){
			while($qr_res->nextHit()){
				$va_all_competences[$qr_res->get("ca_occurrences.occurrence_id")] = array("idno" => $qr_res->get("ca_occurrences.idno"), "label" => strtolower($qr_res->get("ca_occurrences.preferred_labels.name")));
				$va_competences_by_area[strtolower($qr_res->get("ca_occurrences.area", array("convertCodesToDisplayText" => true)))][$qr_res->get("ca_occurrences.occurrence_id")] = array("idno" => $qr_res->get("ca_occurrences.idno"), "label" => strtolower($qr_res->get("ca_occurrences.preferred_labels.name")));
			}
		}
		if(sizeof($va_all_competences)){
?>
		<div class="row">
			<div class="col-sm-12">
				<nav class="navbar navbar-default navbar-bok" role="navigation">
<?php
				#if($this->request->getController() != "BodyOfKnowledge"){
?>
					<ul class="nav navbar-nav navbar-right">
						<li <?php print (($this->request->getController() != "BodyOfKnowledge") && ($this->request->getAction() == "Content")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Content"), "", "", "Browse", "Content", array("facet" => "category_facet", "id" => $pn_user_category)); ?></li>
						<li <?php print ($this->request->getAction() == "Practice") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Practice"), "", "", "Browse", "Practice", array("facet" => "category_facet", "id" => $pn_user_category)); ?></li>
						<li <?php print ($this->request->getAction() == "Community") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Community"), "", "", "Browse", "Community", array("facet" => "category_facet", "id" => $pn_user_category)); ?></li>
						<li <?php print ($this->request->getAction() == "Courses") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Courses &amp; Curricula"), "", "", "Browse", "Courses", array("facet" => "category_facet", "id" => $pn_user_category)); ?></li>
					</ul>
<?php
				#}
?>
					<ul class="nav navbar-nav">
						<li class="dropdown">
<?php
							print '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sort-asc"></i><span class="comp_code">'.$ps_user_category_idno.'</span><span class="comp_title">'.$ps_user_category.'</span></a>';
?>
							<ul class="dropdown-menu">
<?php
							foreach($va_all_competences as $vn_category_id => $va_category){
?>
							<li>
<?php
								print caNavLink($this->request, "<span class='comp_code'>".$va_category["idno"]."</span><span class='comp_title'>".$va_category["label"]."</span>", "", "", "BodyOfKnowledge", "Content", array("user_category" => $vn_category_id));
?>	
							</li>
<?php
							}
?>
							</ul>
						</li>
					</ul>
				</nav>
			</div><!-- end col-->
		</div><!-- end row-->
<?php			
		}
	}
?>
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
