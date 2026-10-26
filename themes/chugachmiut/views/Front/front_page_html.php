<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$va_access_values = $this->getVar("access_values");
	$vs_hero = $this->request->getParameter("hero", pString);
	if(!$vs_hero){
 		$vs_hero = rand(1, 1);
	}
?>

<div class="parallax hero<?php print $vs_hero; ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2">
				
				<div class="heroSearch">
					<H1>
						<div class="line2">Chugachmiut Heritage<br/>Library & Archive</div>
						<div class="line3">{{{hp_search_text}}}</div>
					</H1>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="<?php print _t("Search"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
						<div class='heroAdvanced'><?php print caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row frontBrowseButton">
		<div class="col-sm-9 col-sm-offset-3 col-md-4 col-md-offset-4 text-center">
<?php
					print caNavLink($this->request, "Browse All Heritage Items <i class='fa fa-arrow-right'></i>", "btn btn-default", "", "Browse", "objects");
?>
		</div>
	</div>
<?php
	$vs_hp_intro_title = $this->getVar("hp_intro_title");
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro_title || $vs_hp_intro){
?>
	<div class="container hpIntro">
		<div class="row">
			<div class="col-md-12 col-lg-8 col-lg-offset-2">
				<div class="callout">
	<?php
				if($vs_hp_intro_title){
					print "<div class='calloutTitle'>".$vs_hp_intro_title."</div>";
				}
				if($vs_hp_intro){
					print "<p>".$vs_hp_intro."</p>";
				}
	?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	# --- display slideshow of featured set
	print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row hpExplore bgTurq">
		<div class="col-md-12 col-lg-6 col-lg-offset-3">
		<H2 class="frontSubHeading text-center">Explore The Archive</H2>

			<div class="row">
				<div class="col-md-6">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImageCommunities'></div>", "", "", "Communities", "Index"); ?>
						<div class="hpExploreBoxDetails">
							<div class="hpExploreBoxTitle"><?php print caNavLink($this->request, "Communities", "", "", "Communities", "Index"); ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImagePeople'></div>", "", "", "People", "Index"); ?>
						<div class="hpExploreBoxDetails">
							<div class="hpExploreBoxTitle"><?php print caNavLink($this->request, "People", "", "", "People", "Index"); ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImageCollections'></div>", "", "", "Collections", "Index"); ?>
						<div class="hpExploreBoxDetails">
							<div class="hpExploreBoxTitle"><?php print caNavLink($this->request, "Collections", "", "", "Collections", "Index"); ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="hpExploreBox">
						<?php print caNavLink($this->request, "<div class='hpExploreBoxImage hpExploreBoxImageSubjects'></div>", "", "", "Subjects", "Index"); ?>
						<div class="hpExploreBoxDetails">
							<div class="hpExploreBoxTitle"><?php print caNavLink($this->request, "Subjects", "", "", "Subjects", "Index"); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
	# --- display slideshow of random images
	#print $this->render("Front/featured_set_slideshow_html.php");

	# --- display galleries as a grid?
	#print $this->render("Front/gallery_grid_html.php");
	# --- display galleries as a slideshow?
	#print $this->render("Front/gallery_slideshow_html.php");
?>

<div id="hpScrollBar"><div class="row"><div class="col-sm-12"><i class="fa fa-chevron-down" aria-hidden="true" title="Scroll down for more"></i></div></div></div>

		<script type="text/javascript">
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
			});
		</script>