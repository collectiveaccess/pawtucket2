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
 
  	$t_set = new ca_sets();
 	$t_set->load(array('set_code' => 'frontMember'));
 	$va_featured_members = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle));
	
  	$t_item_set = new ca_sets();
 	$t_item_set->load(array('set_code' => 'frontItems'));
 	$va_featured_items = $t_item_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle));
 	
 	$va_access_values = caGetUserAccessValues($this->request);
		
	print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row blue">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<div class='tagLine'>{{{homepage_leader}}}</div>
		</div><!--end col-sm-8-->
		<div class="col-sm-2"></div>
	</div><!-- end row -->
<?php 
		include_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");
		$t_list = new ca_lists();
		$vn_member_institution_type = $t_list->getItemIDFromList("entity_types", "member_inst");
		
		$qr_members = ca_entities::find(['type_id' => 'member_inst'], ['returnAs' => 'searchResult', 'sort' => 'ca_entity_labels.name_sort', 'sort_direction' => 'asc', "checkAccess" => $va_access_values]);
		
		$vn_i = 0;
		print "<div class='row'>
			<h1 class='blue' style='text-align:center;margin-bottom:10px;'>Heritage Sites</h1><p class='subHead'>Explore the Artifact Collections of each Provincial Heritage Property</p>";
		while ($qr_members->nextHit()) {
			$vs_style = null;
			if ($qr_members->get('ca_entities.inst_images.medium.height') > $qr_members->get('ca_entities.inst_images.medium.width')) {
				$vs_style = "tall";
			} else {
				$vs_style = "wide";
			}
			print "<div class='col-sm-2'><div class='institution {$vs_style}'>".caNavLink($this->request, $qr_members->get('ca_entities.inst_images', array('version' => 'medium')), '', '', 'Detail', 'entities/'.$qr_members->get('ca_entities.entity_id'))."</div></div>";
			$vn_i++;
			if ($vn_i == 6) {
				print "</div><div class='row'><div class='col-sm-1'></div>";
				$vn_i = 0;
			}
		}
		print "<div class='col-sm-1'></div></div><!-- end row -->";   
?>	

	<div class="row blue" style='margin-top:50px;padding-top:15px;'>
		<div class="col-sm-1"></div>
<?php
		foreach ($va_featured_members as $va_member_id => $va_member) {
			$t_entity = new ca_entities($va_member_id);
			print '<div class="col-sm-5 featuredMember"><h1>Featured Collection</h1>';
			print "<div class='featuredTitle'>".caNavLink($this->request, $t_entity->get('ca_entities.preferred_labels'), '', '', 'Detail', 'entities/'.$va_member_id)."</div>";
			print $t_entity->get('ca_entities.biography');			
			print '</div>';
			print '<div class="col-sm-5 featuredMember" style="padding-top:25px;">'.caNavLink($this->request, $t_entity->get('ca_object_representations.media.large'), '', '', 'Detail', 'entities/'.$va_member_id).'</div>';
			break;
		}
?>			
		<div class="col-sm-1"></div>
	</div><!-- end row -->
	<div class="row blue" style="padding-top:25px;padding-bottom:45px;">
		<div class="col-sm-1"></div>
<?php
		foreach ($va_featured_items as $va_item_id => $va_item) {
			$t_object = new ca_objects($va_item_id);
			print '<div class="col-sm-5 featuredMember" style="padding-top:25px;border-top:1px solid #fff;">'.caNavLink($this->request, $t_object->get('ca_object_representations.media.medium'), '', '', 'Detail', 'objects/'.$va_item_id).'</div>';			
			print '<div class="col-sm-5 featuredMember" style="border-top:1px solid #fff;"><h1>Featured Artifact</h1>';
			print "<div class='featuredTitle'>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_item_id)."</div>";
			print $t_object->get('ca_objects.description');			
			print '</div>';
			break;
		}
?>
		<div class="col-sm-1"></div>
	</div><!-- end row -->	
	<div class="row cats">
		<h1 class='blue' style='margin-bottom:10px;'>Browse Collections</h1><p class="subHead" style='margin-bottom:50px;'>Browse the Collections of all of the Heritage Properties by Category</p>
		<div class="col-sm-1"></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'architecture.jpg')."<br/>Architecture", '', '', 'Browse', 'objects/facet/topic_facet/id/542'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'art.jpg')."<br/>Art", '', '', 'Browse', 'objects/facet/topic_facet/id/543'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'communication.jpg')."<br/>Communications and Technology", '', '', 'Browse', 'objects/facet/topic_facet/id/544'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'agriculture.jpg')."<br/>Agriculture and Fishing", '', '', 'Browse', 'objects/facet/topic_facet/id/545'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'clothing.jpg')."<br/>Clothing and Accessories", '', '', 'Browse', 'objects/facet/topic_facet/id/546'); ?></div>		
		<div class="col-sm-1"></div>
	</div><!-- end row -->
	<div class="row cats" style="margin-bottom:80px;">
		<div class="col-sm-1"></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'household.jpg')."<br/>Household Life", '', '', 'Browse', 'objects/facet/topic_facet/id/547'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'industry.jpg')."<br/>Industry and Manufacturing", '', '', 'Browse', 'objects/facet/topic_facet/id/548'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'military.jpg')."<br/>Military", '', '', 'Browse', 'objects/facet/topic_facet/id/549'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'recreation.jpg')."<br/>Recreation", '', '', 'Browse', 'objects/facet/topic_facet/id/550'); ?></div>
		<div class="col-sm-2"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'transportation.jpg')."<br/>Transportation", '', '', 'Browse', 'objects/facet/topic_facet/id/551'); ?></div>
		<div class="col-sm-1"></div>
	</div><!-- end row -->	
</div> <!--end container-->