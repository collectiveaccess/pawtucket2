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
	
?>
<div class="parallax">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3">
				
				<div class="heroSearch">
					<H2>Welcome To</H2>
					<H1>Vancouver<br/>Maritime<br/>Museum’s<br/>Open<br/>Collections</H1>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="Search" name="search" autocomplete="off" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search"></span></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container hpIntro">
	<div class="row">
		<div class="col-sm-12 col-md-6 col-md-offset-3">

			<H1>The Vancouver Maritime Museum’s<br/><b>Open Collections</b><br/>is an online catalogue of<br/><i>Artifacts</i> and <i>Archival Material</i><br/>held at the museum.</H1>

			<p>Search both our Artifact and Archival collections using key words, dates, or places.</p>

			<p>Browse the holdings using the <?php print caNavLink($this->request, "Artifacts", "", "", "Browse", "artifacts"); ?>, <?php print caNavLink($this->request, "Archives", "", "", "Collections", "index"); ?>, and <?php print caNavLink($this->request, "Vessels", "", "", "Browse", "vessels"); ?> portals below.</p>
		</div>
	</div>
</div>


<div class="container">

	<div class="row">
		<div class="col-sm-12 text-center">
			<div class="row tileLinks">				
				<div class="col-sm-4">
		<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'divers_helmet.jpg'), "", "", "Browse", "artifacts");
					print "<div class='sectionLink'>".caNavLink($this->request, "Artifacts", "", "", "Browse", "artifacts")."</div>";
		?>
				</div> <!--end col-sm-4-->
				<div class="col-sm-4">
		<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'titanic_corkletter.jpg'), "", "", "Collections", "index");
					print "<div class='sectionLink'>".caNavLink($this->request, "Archives", "", "", "Collections", "index")."</div>";
		?>
				</div><!--end col-sm-4-->
				<div class="col-sm-4">
		<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'bone_ship.jpg'), "", "", "Browse", "vessels");
					print "<div class='sectionLink'>".caNavLink($this->request, "Vessels", "", "", "Browse", "vessels")."</div>";
		?>			
				</div> <!--end col-sm-4-->
			</div><!-- end row -->	
		</div>
	</div>
</div><!-- end container -->
	

<?php	
	$o_config = caGetGalleryConfig();
	
	# --- which type of set is configured for display in gallery section
 	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconExtralarge", "checkAccess" => $va_access_values));
		
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_config->get('omit_front_page_set_from_gallery');
		$va_sets_processed = array();
		$i = 0;
		foreach($va_sets as $vn_set_id => $va_set) {
			if ($vb_omit_front_page_set && $va_set['set_code'] != $vs_front_page_set) { 
				$t_set->load($vn_set_id);
				$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
				$va_sets_processed[] = array("set_id" => $vn_set_id, "name" => ($vs_tmp = $t_set->get("short_set_title")) ? $vs_tmp : $va_set["name"], "image" => $va_first_item["representation_tag"]);
				$i++;
			}
			if($i == 5){
				break;
			}
		}
	}


	if(is_array($va_sets_processed) && sizeof($va_sets_processed)){
?>

<div class="container">
	<div class="row hpGalleries">
		<div class="col-sm-10 col-sm-offset-1 text-center"> 
			<H1>Highlights</H1>
			<div class="row">
				<div class="col-sm-6 galleryTile">
	<?php
					if($va_sets_processed[0] && is_array($va_sets_processed[0])){
						print caNavLink($this->request, $va_sets_processed[0]["image"], "", "", "Gallery", $va_sets_processed[0]["set_id"]);
						print caNavLink($this->request, $va_sets_processed[0]["name"], "hpGalleryTitle", "", "Gallery", $va_sets_processed[0]["set_id"]);
					}
	?>				
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-6 galleryTile">
	<?php
							if($va_sets_processed[1] && is_array($va_sets_processed[1])){
								print caNavLink($this->request, $va_sets_processed[1]["image"], "", "", "Gallery", $va_sets_processed[1]["set_id"]);
								print caNavLink($this->request, $va_sets_processed[1]["name"], "hpGalleryTitle", "", "Gallery", $va_sets_processed[1]["set_id"]);
							}
	?>
						</div>
						<div class="col-sm-6 galleryTile">
	<?php
							if($va_sets_processed[2] && is_array($va_sets_processed[2])){
								print caNavLink($this->request, $va_sets_processed[2]["image"], "", "", "Gallery", $va_sets_processed[2]["set_id"]);
								print caNavLink($this->request, $va_sets_processed[2]["name"], "hpGalleryTitle", "", "Gallery", $va_sets_processed[2]["set_id"]);
							}
	?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 galleryTile">
	<?php
							if($va_sets_processed[3] && is_array($va_sets_processed[3])){
								print caNavLink($this->request, $va_sets_processed[3]["image"], "", "", "Gallery", $va_sets_processed[3]["set_id"]);
								print caNavLink($this->request, $va_sets_processed[3]["name"], "hpGalleryTitle", "", "Gallery", $va_sets_processed[3]["set_id"]);
							}
	?>
			
						</div>
						<div class="col-sm-6 galleryTile">
	<?php
							if($va_sets_processed[4] && is_array($va_sets_processed[4])){
								print caNavLink($this->request, $va_sets_processed[4]["image"], "", "", "Gallery", $va_sets_processed[4]["set_id"]);
								print caNavLink($this->request, $va_sets_processed[4]["name"], "hpGalleryTitle", "", "Gallery", $va_sets_processed[4]["set_id"]);
							}
	?>
			
						</div>
					</div>

				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<?php print caNavLink($this->request, _t("View All"), "btn btn-default", "", "Gallery", "Index"); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	}
?>