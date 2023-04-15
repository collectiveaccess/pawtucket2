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
 require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 $va_access_values = $this->getVar("access_values");
 $vs_hero = $this->request->getParameter("hero", pString);
 if(!$vs_hero){
 	$vs_hero = rand(1, 1);
 }
?>

<div class="parallax hero<?php print $vs_hero; ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				
				<div class="heroSearch">
					<H1>
						<div class="line1">Welkom bij</div>
						<div class="line2">De Zuidrand</div>
						<div class="line3">{{{hp_search_intro}}}</div>
					</H1>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="Zoeken" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form>
					<div class="heroAdvancedSearchLink"><?php print caNavLink($this->request, "Geavanceerd zoeken", "", "", "Search", "advanced/objects"); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container hpIntro">
	<div class="row">
		<div class="col-md-12 col-lg-8 col-lg-offset-2">
			<div class="callout">
<?php
			if($vs_tmp = $this->getVar("hometext_title")){
				print "<div class='calloutTitle'>".$vs_tmp."</div>";
			}
?>
				<p>{{{hometext}}}</p>
			</div>
		</div>
	</div>
</div>
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
</div></div>
<div class="row"><div class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2 frontPlaces">
	
<?php
	if($vs_place_set_code = $this->request->config->get("front_page_places_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_place_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
			$r_places = caMakeSearchResult('ca_places', $va_featured_ids);
		
			$i = 0;
			if($r_places->numHits()){
?>
			<h2>Bladeren per stad of gemeente</h2>
<?php
				while($r_places->nextHit()){
					if($i == 0){
						print "<div class='row'>";
					}
					$vs_img = "";
					#if($r_places->get("ca_object_representations.media.iconlarge")){
						$vs_img = $r_places->getWithTemplate("^ca_object_representations.media.iconlarge");	
						if(!$vs_img){
							$vs_img = $r_places->getWithTemplate("<unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.iconlarge</unit>");
						}
						if($vs_img){
							$vs_img = caNavLink($this->request, $vs_img, "", "", "Browse", "objects", array("facet" => "place_facet", "id" => $r_places->get("ca_places.place_id")))."<br/>";
						}
					#}
					print "<div class='col-sm-12 col-md-3 text-center'>".$vs_img.caNavLink($this->request, $r_places->get("ca_places.preferred_labels.name"), "frontPlaceLink", "", "Browse", "objects", array("facet" => "place_facet", "id" => $r_places->get("ca_places.place_id")))."</div>";
					$i++;
					if($i == 4){
						print "</div><!-- end row -->";
						$i = 0;
					}
				}
			}
			if($i > 0){
				print "</div><!-- end row -->";
			}				
		}
	}
	
?>
</div></div>
<?php
		print $this->render("Front/gallery_slideshow_html.php");
?>
<div class="row" id="hpScrollBar"><div class="col-sm-12"><i class="fa fa-chevron-down" aria-hidden="true" title="Scroll down for more"></i></div></div>
		<script type="text/javascript">
			$(document).ready(function(){
				$(window).scroll(function(){
					$("#hpScrollBar").fadeOut();
				});
			});
		</script>