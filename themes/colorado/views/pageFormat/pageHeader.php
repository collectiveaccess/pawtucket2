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
$ps_subsite = $this->request->getParameter('subsite', pString);

switch($this->request->getController()){
	case "Front":
		switch($this->request->getAction()){
			case "FossilEggshellCollection":
				$ps_subsite = "eggshell";
			break;
			# ------------------
			case "FossilTracksCollection":
				$ps_subsite = "tracks";
			break;
			# ------------------
			case "FossilVertebrateCollection":
				$ps_subsite = "vertebrate";
			break;
			# ------------------
		}
	break;
	# -----------------------------------
	case "About":
		switch($this->request->getAction()){
			case "FossilEggshellCollection":
				$ps_subsite = "eggshell";
			break;
			# ------------------
			case "FossilTracksCollection":
				$ps_subsite = "tracks";
			break;
			# ------------------
		}
	break;
	# -----------------------------------
	case "Browse":
		switch($this->request->getAction()){
			case "eggshell":
				$ps_subsite = "eggshell";
			break;
			# ------------------
			case "tracks":
				$ps_subsite = "tracks";
			break;
			# ------------------
			case "vertebrate":
				$ps_subsite = "vertebrate";
			break;
			# ------------------
		}
	break;
	# -----------------------------------
	case "Search":
		switch($this->request->getAction()){
			case "eggshell":
				$ps_subsite = "eggshell";
			break;
			# ------------------
			case "tracks":
				$ps_subsite = "tracks";
			break;
			# ------------------
			case "vertebrate":
				$ps_subsite = "vertebrate";
			break;
			# ------------------
			case "advanced":
				switch($this->request->getActionExtra()){
					case "eggshell":
						$ps_subsite = "eggshell";
					break;
					# ------------------
					case "tracks":
						$ps_subsite = "tracks";
					break;
					# ------------------
					case "vertebrate":
						$ps_subsite = "vertebrate";
					break;
					# ------------------
				}
			break;
			# ------------------
		}
	break;
	# -----------------------------------
	case "Detail":
		$ps_subsite = $this->request->getParameter("subsite", pString);
	break;
	# -----------------------------------
}
if($ps_subsite && ($ps_subsite != $this->request->session->getVar("coloradoSubSite"))){
	$this->request->session->setVar("coloradoSubSite", $ps_subsite);
}
$ps_subsite = $this->request->session->getVar("coloradoSubSite");
if(!$ps_subsite){
	$ps_subsite = "eggshell";
}
?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print $this->request->config->get('html_page_title'); ?></title>
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
		<div id="topBar">
			<img src="<?php print $this->request->getThemeUrlPath(); ?>/assets/pawtucket/graphics/CUHeader.jpg" alt="header" border="0" usemap="#CUHeader" width="1120" height="26"/>
			<map name="CUHeader" id="CUHeader">
				<area shape="rect" coords="5,4,291,21" href="http://www.colorado.edu/" target="outlink" alt="University of Colorado at Boulder"/>
				<area shape="rect" coords="963,4,995,21" href="http://www.colorado.edu/" target="outlink" alt="CU-Home" />
				<area shape="rect" coords="1002,4,1041,21" href="http://www.colorado.edu/search/" target="outlink" alt="CU-Search" />
				<area shape="rect" coords="1050,4,1086,21" href="http://www.colorado.edu/atoz/" target="outlink" alt="CU-A to Z" />
				<area shape="rect" coords="1092,4,1115,21" href="http://www.colorado.edu/campusmap/" target="outlink" alt="Campus Map" />
			</map>
		</div><!-- end topbar -->
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
			<div id="nav">
				<div id="headerLogo">
<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'CU_MNH_small.png'), "", "", "", "");
?>
				</div>
<?php
				if(($this->request->getController() == "Front") && ($this->request->getAction() == "Index")){
					print "<p>Choose a collection:</p>";
					print caNavLink($this->request, _t("Fossil Eggshells"), "", "", "Front", "FossilEggshellCollection")."<div class='navDivide'></div>";
					print caNavLink($this->request, _t("Fossil Tracks"), "", "", "Front", "FossilTracksCollection")."<div class='navDivide'></div>";
					print caNavLink($this->request, _t("Fossil Vertebrates"), "", "", "Front", "FossilVertebrateCollection")."<div class='navDivide'></div>";
				}else{
?>
					<div id="header">
<?php
						switch($ps_subsite){
							case "eggshell":
								print _t("Fossil Eggshell Collection");
							break;
							# ---------------------------
							case "vertebrate":
								print _t("Fossil Vertebrate Collection");
							break;
							# ---------------------------
							case "tracks":
								print _t("Fossil Tracks Collection");
							break;
							# ---------------------------
						}
?>				
					</div><!-- end header -->
<?php
					// get last search ('basic_search' is the find type used by the SearchController)
					$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
					$vs_search = $o_result_context->getSearchExpression();
?>
					<div id="search">
						<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', $ps_subsite); ?>" method="get"><a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"> SEARCH </a>
							<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" size="100"/>
						</form>
					</div>	
<?php
					print caNavLink($this->request, _t("Home"), "", "", "Front", "Fossil".ucfirst($ps_subsite)."Collection")."<div class='navDivide'></div>";
					if($ps_subsite != "vertebrate"){
						print caNavLink($this->request, _t("About"), "", "", "About", "Fossil".ucfirst($ps_subsite)."Collection")."<div class='navDivide'></div>";
					}
					print caNavLink($this->request, _t("Advanced Search"), "", "", "Search/advanced", $ps_subsite)."<div class='navDivide'></div>";
					print caNavLink($this->request, _t("Browse"), "", "", "Browse", $ps_subsite)."<div class='navDivide'></div>";
					
					print "<p>More collections:</p>";
					if($ps_subsite != "eggshell"){
						print caNavLink($this->request, _t("Fossil Eggshells"), "", "", "Front", "FossilEggshellCollection")."<div class='navDivide'></div>";
					}
					if($ps_subsite != "tracks"){
						print caNavLink($this->request, _t("Fossil Tracks"), "", "", "Front", "FossilTracksCollection")."<div class='navDivide'></div>";
					}
					if($ps_subsite != "vertebrate"){
						print caNavLink($this->request, _t("Fossil Vertebrates"), "", "", "Front", "FossilVertebrateCollection")."<div class='navDivide'></div>";
					}
				}
?>
	
			</div><!-- end nav -->
			<div id="pageContentArea"><div id="pageContentAreaPadding">