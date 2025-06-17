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


?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link href='http://fonts.googleapis.com/css?family=Muli:300,400,300italic,400italic|Raleway:400,700,600,500,800,900,300,200,100|Crimson+Text:400,700italic,700,600italic,600,400italic' rel='stylesheet' type='text/css' />

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

</head>
<body>
	<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
		<div id="header">
			<div class="logo"><a href="http://www.archives.nysed.gov"><?php print caGetThemeGraphic($this->request, 'NYSA_Logo.jpg', array('alt' => 'New York State Archives'));?></a></div>			
			<div id="logotext"><a href="http://www.archives.nysed.gov"><?php print caGetThemeGraphic($this->request, 'NYSA_HeaderType.png', array('alt' => 'New York State Archives'));?></a></div>	
				
			<div class="right-box">
			<div class="social">
				<ul>
					<li>
						<a href="https://www.facebook.com/nysarchives"><?php print caGetThemeGraphic($this->request, 'Facebook_icon.png', array ('width' => '27px', 'height' => '27px'));?></a>
					</li>
					<li>
						<a href="https://twitter.com/nysarchives"><?php print caGetThemeGraphic($this->request, 'twitter_icon.png', array ('width' => '27px', 'height' => '27px'));?></a>
					</li>
					<li>
						<a href="https://www.youtube.com/user/nysarchives"><?php print caGetThemeGraphic($this->request, 'YouTubeIcon.png', array ('width' => '27px', 'height' => '27px'));?></a>
					</li>
				</ul>
			</div>
			<div class="search-box">
				<form method="get" action="http://srv52.nysed.gov/search">
					<input type="text" id="search" name="q" value="">
					<input class="submit" type="submit" name="btnG" value=""> 
					<input type="hidden" name="site" value="Drupal_CA_XTF">
					<input type="hidden" name="client" value="drupal_ca_xtf">
					<input type="hidden" name="proxystylesheet" value="drupal_ca_xtf">
					<input type="hidden" name="output" value="xml_no_dtd">
				</form>
			</div>
		</div>
	</div>
	<nav class="navbar nysa navbar-default yamm" role="navigation">
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">

				<ul class="nav navbar-nav navbar-right menuItems">
					<li class="list-item-one"><?php print caNavLink($this->request, 'Digital Collections', '', '', '', '');?></a></li>	
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><a href="http://www.archives.nysed.gov/education/index.shtml">Education</a>
						<ul class="dropdown-menu">
							<li><a href='http://www.archives.nysed.gov/education/index.shtml'>Overview</a></li>
							<li><?php print caNavLink($this->request, 'Documents and Learning Activities', '', '', 'Browse', 'occurrences');?></a></li>
							<li><a href='http://www.archives.nysed.gov/education/video'>Instructional Videos</a></li>
							<li><a href='http://www.archives.nysed.gov/education/publications'>Publications</a></li>
							<li><a href='https://www.nysarchivestrust.org/education/student-research-awards'>Student Research Award</a></li>
						</ul>
					</li>
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><a href="http://www.archives.nysed.gov/grants">Grants & Awards</a>
						<ul class="dropdown-menu" style='width:432px;'>
							<li><a href='http://www.archives.nysed.gov/grants'>Overview</a></li>
							<li><a href='http://www.archives.nysed.gov/grants/grants_dhp.shtml'>Documentary Heritage Program</a></li>							
							<li><a href='http://www.archives.nysed.gov/research/hackman-research-residency'>Larry J. Hackman Research Residency</a></li>
							<li><a href='http://www.archives.nysed.gov/grants/grants_lgrmif.shtml'>Local Government Records Management Improvement Fund</a></li>
							<li><a href='https://www.nysarchivestrust.org/education/student-research-awards'>Student Research Award</a></li>
						</ul>
					</li>					
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><a href="http://www.archives.nysed.gov/records/index.shtml">Managing Records</a>
						<ul class="dropdown-menu" style='width:432px;'>
							<li><a href='http://www.archives.nysed.gov/records/managing-records-overview'>Overview</a></li>
							<li><a href='http://www.archives.nysed.gov/records/our-services'>Our Services</a></li>							
							<li><a href='http://www.archives.nysed.gov/records/retention-scheduling-and-appraisal'>Retention and Disposition Schedules</a></li>
							<li><a href='http://www.archives.nysed.gov/records/disaster-assistance'>Disaster Assistance</a></li>
							<li><a href='http://www.archives.nysed.gov/records/ny-state-records-center-2'>State Records Center</a></li>
							<li><a href='http://www.archives.nysed.gov/publications?field_topics_value=Managing%20Records'>Publications</a></li>
							<li><a href='http://www.archives.nysed.gov/records/records-management-topics'>Featured Topics</a></li>
							<li><a href='http://www.archives.nysed.gov/records/laws-and-regulations'>Laws and Regulations</a></li>
							<li><a href='http://www.archives.nysed.gov/records/dhpsny'>DHPSNY</a></li>
						</ul>
					</li>										
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><a href="http://www.archives.nysed.gov/research/index.shtml">Research</a>
						<ul class="dropdown-menu" style='width:432px;'>
							<li><a href='http://www.archives.nysed.gov/research/researcher-services-overview'>Overview</a></li>
							<li><a href='http://www.archives.nysed.gov/research/about-our-records'>About our Records</a></li>							
							<li><a href='http://www.archives.nysed.gov/research/researcher-services'>Researcher Services</a></li>
							<li><a href='http://www.archives.nysed.gov/research/search-for-records'>Search for Records</a></li>
							<li><?php print caNavLink($this->request, 'Digital Collections', '', '', '', '');?></li>
							<li><a href='http://www.archives.nysed.gov/research/featured-topics'>Research Topics</a></li>
							<li><a href='http://www.archives.nysed.gov/research/visit-the-archives'>Visit the Archives</a></li>
							<li><a href='http://www.archives.nysed.gov/research/hackman-research-residency'>Research Residency</a></li>
							<li><a href='http://www.archives.nysed.gov/research/research-assistance'>FAQs</a></li>
							<li><a href='http://www.archives.nysed.gov/research/research-contact-us'>Contact Us</a></li>
						</ul>
					</li>					
					<li><a href="http://www.archives.nysed.gov/workshops">Workshops</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div id="TopicBar" class="archive <?php print (($this->request->getAction() == "education") ? "green" : "" );?>">
<?php	
#	if((($this->request->getController() == "Browse") && ($this->request->getAction() == "occurrences")) | ($this->request->getAction() == "education")) {
#		print "<h1>Education</h1>";
#	} elseif (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")){
#		print "<h1>Research</h1>";
#	} else {
		print "<h1>Digital Collections</h1>";
#	}
?>
		<!--<div id="objectSearch">
			<div id="search">
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search Digital Collections" name="search" autocomplete="off" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"></button>
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
			</div>
		</div>-->
	</div>	<!-- end topic bar -->
<?php /*
	if (($this->request->getController() == "Browse") && ($this->request->getAction() == "occurrences")) {
	print '<div id="menuBar">';
		print caNavLink($this->request, _t("About"), "", "", "About", "education"); 
		print caNavLink($this->request, _t("Browse Documents/Lessions"), "", "", "Browse", "occurrences"); 
		print caNavLink($this->request, _t("Copyright"), "", "", "About", "copyright"); 
	print "</div>";
	} elseif ($this->request->getActionExtra() == "dutch"){
		print "";
	} else {	
	print '<div id="menuBar">';
		print caNavLink($this->request, _t("Browse The Collection"), "", "", "Browse", "objects"); 
		print caNavLink($this->request, _t("Copyright"), "", "", "About", "copyright"); 
		print caNavLink($this->request, _t("Learning Activities"), "", "", "Browse", "occurrences"); 
	print '</div>';
	} */
?>
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container caMenu">
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
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">
					<?php print join("\n", $va_user_links); ?>
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
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
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
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Topics"), "", "", "Collections", "index"); ?></li>										
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		
