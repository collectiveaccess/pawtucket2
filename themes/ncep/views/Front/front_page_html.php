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
$t_list = new ca_lists();
$va_themes = $t_list->getItemsForList("themes", array("labelsOnly" => true));

$va_access_values = $this->getVar("access_values");
$qr_most_recent = $this->getVar('featured_set_items_as_search_result');

$t_object = new ca_objects();
#$t_ApplicationChangeLog = new ApplicationChangeLog();
#$va_recent_items = $t_ApplicationChangeLog->getRecentChangesAsRawData($t_object->tableNum(), 20000000, 10);
#print "<pre>";
#print_r($va_recent_items);
#print "</pre>";

// $o_db = new Db();
// $q_recent = $o_db->query("
// 			SELECT DISTINCT o.object_id, o.parent_id
// 			FROM ca_change_log cl
// 			INNER JOIN ca_objects AS o ON o.object_id = cl.logged_row_id
// 			WHERE cl.logged_table_num = ? AND o.access IN (".join(", ", $va_access_values).") AND o.deleted = 0
// 			ORDER BY cl.log_datetime DESC limit 50
// 		", $t_object->tableNum());
// $va_recently_updated = array();
// if($q_recent->numRows()){
// 	while($q_recent->nextRow()){
// 		if($q_recent->get("parent_id")){
// 			$va_recently_updated[$q_recent->get("parent_id")] = $q_recent->get("parent_id");
// 		}else{
// 			$va_recently_updated[$q_recent->get("object_id")] = $q_recent->get("object_id");
// 		}
// 		if(sizeof($va_recently_updated) == 5){
// 			break;
// 		}
// 	}
// }
?>
	<div class="row">
		<div class="col-sm-12">
			<H1>Resources for conservation educators and practitioners to:</H1>
			<div class="hp_icons">
				<?php print caGetThemeGraphic($this->request, 'hp_icons2.png'); ?>
				<div class="learnSlice"></div>
				<div class="exploreSlice"></div>
				<div class="practiceSlice"></div>
				<div class="teachSlice"></div>
				<div class="connectSlice"></div>
			</div>
		</div><!--end col-sm-12-->
	</div><!-- end row -->
<script>
	$(document).ready(function() {
		$('.learnSlice').mouseenter(function(e) {  
		  $('#hpSectionText').html('<b>Learn</b><br/>Relevant, in-depth background resources that synthesize<br/>key issues and perspectives on a conservation topic.');
		});
		$('.exploreSlice').mouseenter(function(e) {  
		  $('#hpSectionText').html('<b>Explore</b><br/>Real world case studies and scenarios that foster interdisciplinary,<br/>problem-based learning.');
		});
		$('.practiceSlice').mouseenter(function(e) {  
		  $('#hpSectionText').html('<b>Practice</b><br/>Practical exercises in biodiversity conservation that apply<br/>fundamental concepts and develop critical skills.');
		});
		$('.teachSlice').mouseenter(function(e) {  
		  $('#hpSectionText').html('<b>Teach</b><br/>Relevant visuals, teaching notes, exercise solutions,<br/>and student learning assessments to enhance teaching.');
		});
		$('.connectSlice').mouseenter(function(e) {  
		  $('#hpSectionText').html('<b>Connect</b><br/>Insights, tips, and reviews from the NCEP teaching and<br/>learning community.');
		});
		$('.hp_icons').mouseleave(function(e) {  
		  $('#hpSectionText').html('Our open access teaching modules improve access to high quality, up-to-date educational resources for conservation teachers and professional trainers around the world, particularly in regions with high biodiversity, significant threats, and limited opportunities.');
		});
	});
</script>
	<div class="row">
		<div class="col-sm-8">	
			<H2 id="hpSectionText">
				Our open access teaching modules improve access to high quality, up-to-date educational resources for conservation teachers and professional trainers around the world, particularly in regions with high biodiversity, significant threats, and limited opportunities.
			</H2>
		</div>
		<div class="col-sm-4">
			<H2><a href="http://visitor.r20.constantcontact.com/manage/optin?v=001D3J3cQufeW5yfs_ZOekOv19XNQ6s8D-UXCuUuFaJ45UPep-qp4-nmPPja3MMJ24FidjcE-3LDto6ZPwbwdA303S6T7XJVZuiUYG0VRjDpsk%3D" class="btn-default btn-blue" target="_blank">Sign up for updates<?php print caGetThemeGraphic($this->request, 'envelope.jpg'); ?></a></H2>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
<?php
			print caNavLink($this->request, _t("Browse all modules")."<i class='fa fa-arrow-circle-right'></i>", "btn-default btn-orange", "", "Browse", "objects");			
?>
		</div>
		<div class="col-sm-8">
			<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
				<div class="formOutline">
					<div class="frontFormGroup">
						<button type="submit" class="btn-search"><i class='fa fa-arrow-circle-right'></i></button>
						<input type="text" class="form-control" placeholder="Search the module collection" name="search">
						
					</div>
				</div>
			</form>		
		</div>
	</div>
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<div class="tabContainer">
					<div class="tab">Browse By Theme</div>
					<div class="tabBody">
						<ul class="noMarker">
<?php
						foreach($va_themes as $vn_item_id => $vs_theme){
							print "<li>".caNavLink($this->request, $vs_theme, "", "", "Browse", "objects", array("facet" => "theme", "id" => $vn_item_id))."</li>";
						}
?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div class="tabContainer">
					<div class="tab">Network Picks</div>
					<div class="tabBody">
						<ul>
<?php
			$o_gallery_config = caGetGalleryConfig();
			$t_list = new ca_lists();
			$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type')); 			
			if($vn_gallery_set_type_id){
				$t_set = new ca_sets();
				$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
			
				$vn_limit = 6;
				if(sizeof($va_sets)){
					$vn_c = 0;
					foreach($va_sets as $vn_set_id => $va_set){
						print "<li>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</li>";
						$vn_c++;
						if ($vn_c >= $vn_limit) { break; }
					}
				}
			}
?>
						</ul>
						<?php print caNavLink($this->request, "Explore all module sets <i class='fa fa-arrow-circle-right'></i>", "", "", "Gallery", "Index"); ?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div class="tabContainer">
					<div class="tab">What's New</div>
					<div class="tabBody">
						<ul>
<?php
						// if(sizeof($va_recently_updated)){
// 							$qr_most_recent = caMakeSearchResult("ca_objects", $va_recently_updated);
// 							if($qr_most_recent->numHits()){
// 								while($qr_most_recent->nextHit()){
// 									print "<li>".$qr_most_recent->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>")."</li>";
// 								}
// 							}
// 						}
						if($qr_most_recent && $qr_most_recent->numHits()){
							while($qr_most_recent->nextHit()){
								if($qr_most_recent->get("type_id", array("convertCodesToDisplayText" => true)) == "Module"){
									print "<li>".$qr_most_recent->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>")."</li>";
								}
							}
						}						
?>
						</ul>
					</div>
				</div>
			</div>
	</div>
		