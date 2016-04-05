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
# --- recently added items
$t_object = new ca_objects();
$va_recently_added_items = $t_object->getRecentlyAddedItems(3, array("hasRepresentations" => true, "checkAccess" => $va_access_values));
$o_config = $this->getVar("config");
?>
	<div class="row introText">
		<div class="col-sm-12">
			<H1>Digital Collection</H1>
			<p>
				Browse material from throughout the Centro Archive showcasing the history and culture of Puerto Ricans in the diaspora.
			</p>
		</div>
	</div>
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row">
		<div class="col-sm-4">
			<div class="frontBox">
<?php
			$o_gallery_config = caGetGalleryConfig();
			$t_list = new ca_lists();
			$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type')); 			
			if($vn_gallery_set_type_id){
				$t_set = new ca_sets();
				$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
			
				$vn_limit = 4;
				if(sizeof($va_sets)){
					# --- get first items from set
					$va_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("checkAccess" => $va_access_values, "version" => "iconlarge"));
					print "<H2 class='rokkit-reg'>Featured Galleries</H2>\n";
					$vn_c = 0;
					print "<div class='frontBoxScroll'>";
					foreach($va_sets as $vn_set_id => $va_set){
						$vs_image = "";
						print "<div class='row frontFeaturedRow'>";
						$va_first_item = array_pop($va_first_items[$vn_set_id]);
						if(is_array($va_first_item) && sizeof($va_first_item)){
							$vs_image = $va_first_item["representation_tag"];
						}
						print "<div class='col-sm-3'>".$vs_image."</div><div class='col-sm-9'>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</div>";
						$vn_c++;
						print "</div>";
						if ($vn_c >= $vn_limit) { break; }
					}
					print "</div>";
				}
			}
?>
			</div>
		</div><!--end col-sm-4-->
		<div class="col-sm-4">
			<div class="frontBox">
				<H2 class="rokkit-reg">Recently Added</H2>
<?php
				if(is_array($va_recently_added_items) && sizeof($va_recently_added_items)){
					$q_recent_items = caMakeSearchResult('ca_objects', array_keys($va_recently_added_items));
					while($q_recent_items->nextHit()){
						print "<div class='row frontFeaturedRow'>";
							print "<div class='col-sm-3'>".$q_recent_items->getWithTemplate('<l>^ca_object_representations.media.iconlarge</l>', array("checkAccess" => $va_access_values))."</div><div class='col-sm-9'>".$q_recent_items->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>")."</div>";
						print "</div>";
					}					
				}
?>
			</div>
		</div><!--end col-sm-4-->
		<div class="col-sm-4">
			<div class="frontBox">
<?php
			if($vs_set_code = $o_config->get("front_page_collection_set_code")){
 				$t_set = new ca_sets();
 				$t_set->load(array('set_code' => $vs_set_code));
				# Enforce access control on set
				if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
					if($t_set->get("set_id")){
						$va_featured_collection_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
						$va_featured_collection_ids = array_slice($va_featured_collection_ids, 0, 6);
						if(is_array($va_featured_collection_ids) && sizeof($va_featured_collection_ids)){
							$q_featured_collections = caMakeSearchResult('ca_collections', $va_featured_collection_ids);
							print '<H2 class="rokkit-reg">Featured Collections</H2>';
							print "<div class='frontBoxScroll'>";
							while($q_featured_collections->nextHit()){
								print "<div class='row frontFeaturedRow'><div class='col-sm-12'>".$q_featured_collections->getWithTemplate('<l>^ca_collections.preferred_labels.name</l>')."</div></div>";
							}
							print "</div>";
						}
					}
				}
 			}
?>
				
			</div>
		</div><!--end col-sm-4-->	
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12">
			<br/><div class="frontBox">
				<H2 class="rokkit-reg">About Centro Archive's Digital Collections</H2>
				<p>
					Welcome to the Centro Archives Digital Collections, a growing resource of material digitized from collections throughout the Archive's holdings. This site provides access to photographs, documents, artifacts, art, maps, oral histories, moving image and audio clips, and other material pertaining to the Puerto Rican diaspora. Highlights include material from the Pura Belpre Papers, Justo A. Marti Photograph Collection, and interviews from Centro's Oral History Project. The Gallery section contains curated content on a variety of topics and people.
				</p>
				<p>
					We also invite you to register as user by clicking the person icon next to the search bar. By registering, you can help us improve access and understanding of items in our collections by contributing tags and comments. The collective additional information will help improve discovery for all users and create undiscovered connections between items. We also welcome the opportunity for you to share your memories and stories in the comments.
				</p>
			</div>
		</div>
	</div>