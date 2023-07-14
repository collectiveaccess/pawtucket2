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
	AssetLoadManager::register('timeline', null, 1);
	$va_access_values = $this->getVar("access_values");
	$this->config = caGetFrontConfig();
	$vs_hero = $this->request->getParameter("hero", pString);
	if(!$vs_hero){
		$vs_hero = rand(1, 6);
	}
 
 # --- timeline set - occurrences
	if($vs_timeline_set_code = $this->config->get("front_page_timeline_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_timeline_set_code));
		if(is_array($va_access_values) && sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values)){
			$vn_timeline_set_id = $t_set->get("set_id");
		}
	}

?>

<div class="parallax hero<?php print $vs_hero; ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				
				<div class="heroSearch">
					<H1>
						<div class="line1">Welcome to</div>
						<div class="line2">Ta X̱ay Sxwimálatncht</div>
						<div class="line3">{{{hp_search_text}}}</div>
					</H1>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="<?php print _t("Search"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form>
					<div class="heroSearchAdvancedSearch"><?php print caNavLink($this->request, "Advanced Search", "", "Search", "Advanced", "objects"); ?></div>
				</div>
			</div>
		</div>
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
?>
	<div class="row hpExplore bg_beige">
		<div class="col-sm-12">
			<div class="container containerExploreBoxGeo">
				<div class="row">
					<div class="col-md-4">
						<div class="hpExploreBoxGeo hpExploreBoxGeo1">
							<?php print caNavLink($this->request, "Archives &<br/>Oral History", "", "", "BrowseAll", "Archives"); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="hpExploreBoxGeo hpExploreBoxGeo2">
							<?php print caNavLink($this->request, "Cultural<br/>Collection", "", "", "Browse", "cultural"); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="hpExploreBoxGeo hpExploreBoxGeo3">
							<?php print caNavLink($this->request, "Reference<br/>Library", "", "", "Browse", "library"); ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="hpExploreBoxGeo hpExploreBoxGeo4">
							<?php print caNavLink($this->request, "External<br/>Resources", "", "", "Listing", "Resources"); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="hpExploreBoxGeo hpExploreBoxGeo5">
							<?php print caNavLink($this->request, "Curriculum &<br/>Teaching Materials", "", "", "Browse", "Curriculum"); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="hpExploreBoxGeo hpExploreBoxGeo6">
							<?php print caNavLink($this->request, "Academic<br/>Works", "", "", "Browse", "academic"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php

	if($vn_timeline_set_id){

?>
	<div class="row">
		<div class="col-sm-12">
			<div id="frontTimelineContainer" class="hpTimeline">
				<div id="timeline-embed"></div>
			</div>
	
			<script type="text/javascript">
				jQuery(document).ready(function() {
					createStoryJS({
						type:       'timeline',
						width:      '100%',
						height:     '100%',
						source:     '<?php print caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'timeline', 'set_id' => $vn_timeline_set_id)); ?>',
						embed_id:   'timeline-embed',
						initial_zoom: '5'
					});
				});
			</script>
		</div>
	</div>
<?php
	}

	# --- display galleries as a grid?
	print $this->render("Front/gallery_grid_html.php");
	
	# --- display slideshow of random images
	print $this->render("Front/featured_set_slideshow_html.php");

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