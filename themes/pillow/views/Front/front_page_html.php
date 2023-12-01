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
 		include_once(__CA_LIB_DIR__."/Search/SetSearch.php");
		print $this->render("Front/featured_set_slideshow_html.php");
		
		$va_featured_ids = array();
		if($vs_set_code = $this->request->config->get("featured_items_set_code")){
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			$vn_shuffle = 0;
			# Enforce access control on set
			if(is_array($va_access_values) && ((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values)))){
				$vn_set_id = $t_set->get("set_id");
				$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
				$qr_res = caMakeSearchResult('ca_objects', $va_featured_ids);
			}
		}		
		
?>
<div class="container hpContainer">
	<div class="row" style='margin-top:25px; margin-bottom:35px;'>
		<div class="col-sm-3 col-sm-offset-1">
			<h4><span>Jacob's</span> <br/><span style='padding-left:60px;'>Pillow</span> <br/><span>Archives</span></h4>
		</div><!--end col-sm-4-->
		<div class="col-sm-7">
			<p style='padding-top:18px;'>
				Discover the rich history of Jacob’s Pillow through an extensive online collection of photographs and festival programs. Search our entire collection of moving images, books, correspondence and other materials to learn more about past performances and artists, including Ted Shawn, Ted Shawn's Men Dancers, and the Denishawn Company.
			</p>
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12">
<?php
#			if ($t_set->get('ca_sets.preferred_labels')) {
#				print $t_set->get('ca_sets.preferred_labels');
#			}
?>		
		</div>
	</div>
	<div class="row">
	<div class='col-sm-12'>
	<div class='container'>
<?php
	$o_set_search = new SetSearch();
	$qr_res = $o_set_search->search("ca_sets.show_homepage:yes", array('sort' => 'ca_sets.rank', 'sort_direction' => 'asc', "checkAccess" => $va_access_values));

		if ($qr_res && $qr_res->numHits()) {
			$vn_i = 0;
			while($qr_res->nextHit()){ 
				$t_set = new ca_sets($qr_res->get('ca_sets.set_id'));
				$va_set_name = $qr_res->get('ca_sets.preferred_labels');
				$va_set_description = $qr_res->get('ca_sets.set_description');
				$va_set_items = $t_set->getItems();
				foreach ($va_set_items as $va_key => $va_set_item) {
					foreach ($va_set_item as $va_key => $va_set_item_id) {
						$t_set_item = new ca_set_items($va_set_item_id['item_id']); 
						if ($t_set_item->get('ca_set_items.set_item_is_primary', array('convertCodesToDisplayText' => true)) == "Is primary"){
							$t_object = $t_set_item->getItemInstance();
							$vs_object_name = "<p>".$t_object->get('ca_objects.preferred_labels')."</p>";
							$vs_icon_large = "<div class='largeHome'>".$t_object->get('ca_object_representations.media.widepreviewlarge')."</div>";
							$vs_icon_iconlarge = "<p>".$t_object->get('ca_object_representations.media.widepreviewlarge')."</p>";
							$vs_item_name = "<p>".$t_set_item->get('ca_set_items.preferred_labels')."</p>";
						}	
					}
				}
				$vs_see_more_link =  "<p class='seeMore'>".caNavLink($this->request, "See More", '', '', 'Gallery', $qr_res->get('ca_sets.set_id'))."</p>";				
				if ($vn_i == 0) {
					print "<div class='row firstFeatured'>";
					print "<div class='col-sm-8' style='margin-right:-15px;margin-left:-15px;'>";
					print $vs_icon_large;
					print "<div class='homeCaption'>".$vs_object_name."</div>";
					print "</div>";
					print "<div class='col-sm-4 featuredSidebar'>";     
					print "<h4 class='white'>Featured Image</h4>";
					print "<h5>".$va_set_name."</h5>";
					print $vs_item_name;
					print "<p>".$va_set_description."</p>";
					print $vs_see_more_link;
					print "</div>";					
					print "</div>";
				} else {
					if ($vn_i == 1) {
						print "<div class='row'>";
					}
					print "<div class='col-sm-4'>";
					print "<div class='smallFeatured'>";				
					print "<div>".caNavLink($this->request, $vs_icon_iconlarge, '', '', 'Gallery', $qr_res->get('ca_sets.set_id'))."</div>";
					print "<div class='smallCaption'><div class='thumbTitle'>".$va_set_name."</div>";
					print $vs_item_name;
					print "</div></div>";
					print "</div>";
					
				}
				$vn_i++;
			}
			if ($vn_i >= 2) {
				print "</div><!-- end row -->";
			}
		}
?>
	</div><!--end container-->
	</div><!--end col-->		
	</div><!--end row-->
</div> <!--end container-->