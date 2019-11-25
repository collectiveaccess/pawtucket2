<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
	$va_access_values = caGetUserAccessValues();
	$o_front_config = caGetFrontConfig();
	
?>
	<div class="row">
		<div class="col-sm-12 pt-3 pb-3">
			<p class="tagline">{{{hometagline}}}</p>
		</div><!--end col -->	
	</div><!-- end row -->

	
<?php

	$o_gallery_config = caGetGalleryConfig();
	if(!$vs_section_name = $o_gallery_config->get('gallery_section_name')){
		$vs_section_name = _t("Featured Galleries");
	}
	$t_list = new ca_lists();
	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type'));
	if($vn_gallery_set_type_id){
		$t_set = new ca_sets();
		$va_un_sorted_sets = caExtractValuesByUserLocale($t_set->getSets(array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
		if(is_array($va_un_sorted_sets) && sizeof($va_un_sorted_sets)){
			shuffle($va_un_sorted_sets);
			$va_sets = array();
			foreach($va_un_sorted_sets as $va_set){
				if($va_set["set_code"] != $o_front_config->get("front_page_set_code")){
					$va_sets[$va_set["set_id"]] = $va_set;
				}
			}
			$va_sets = array_slice($va_sets,0,8,true);
			$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
		}
	}	
	if(is_array($va_sets) && sizeof($va_sets)){		
?>
	<div class="row mt-5">
		<div class="col-md-6 mt-5">
			<H1><?php print $vs_section_name; ?></H1>
		</div>
		<div class="col-md-6 mt-5 text-right">
<?php
			print caNavLink(_t("View All"), "btn btn-sm btn-primary", "", "Gallery", "Index");
?>
		</div>
	</div>
	<div class="row mb-5">
		<div class="col-lg-12">
			<div class="row">
<?php
		foreach($va_sets as $vn_set_id => $va_set){
			print "<div class='col-sm-6 col-md-3 pb-4 mb-4'>";
			$va_first_item = "";
			if($va_set_first_items[$vn_set_id]){
				$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
			}
			print caNavLink($va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
			print "<div class='pt-2'>".$va_set["name"]."</div><div>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</div>";
			print "</div>";
		}
?>
			</div>
		</div>
	</div>
<?php
	}
if($o_front_config->get("front_page_set_code")){
?>
<script type="text/javascript">	
	pawtucketUIApps['slickcarousel'] = {
        'selector': '#frontSlider',
        'data': {
            'images': <?php print ca_sets::setContentsAsJSON($o_front_config->get("front_page_set_code"), ['template' => ($vs_tmp = $o_front_config->get("front_page_set_item_caption_template")) ? $vs_tmp : '<l>^ca_objects.preferred_labels.name (^ca_objects.idno)</l>']); ?>,
            'showThumbnails': false,
            'infiniteLoop': true,
            'dots': true,
            'infinite': true,
            'speed': 500,
            'slidesToShow': 1,
            'slidesToScroll': 1,
            'variableWidth':true,
            'returnImgAsLink':1
        }
    };
</script>
<?php
}
	$va_featured_sets = array();
	if($va_set_codes = $o_front_config->get("front_page_set_codes")){
		foreach($va_set_codes as $vs_set_code){
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			$vn_shuffle = 0;
			if($o_front_config->get("front_page_set_random")){
				$vn_shuffle = 1;
			}
			
			# Enforce access control on set
			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
				$va_set_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
				$vs_set_table = Datamodel::getTableName($t_set->get("table_num"));
				$r_set_items = caMakeSearchResult($vs_set_table, $va_set_item_ids);
				if($r_set_items->numHits()){
					$va_tmp = array();
					while($r_set_items->nextHit()){
						$vs_image = $r_set_items->getWithTemplate("<unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.large</unit>");
						$vs_image_link = $r_set_items->getWithTemplate("<l><unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.large</unit></l>");
						if($vs_image){
							$va_tmp[] = array("image" => $vs_image_link, "label" => $vs_label);
						}
					}
					$va_featured_sets[$t_set->get("ca_sets.set_id")] = $va_tmp;
				}
			
			}			
		}			
		if(is_array($va_featured_sets) && sizeof($va_featured_sets)){
?>
			<div class='row'>
<?php
			foreach($va_featured_sets as $vn_set_id => $va_featured_set){
?>
				<div class='col-md-4'>
					<div class='carousel slide' id='hpSlideshow<?php print $vn_set_id; ?>' data-interval='false'>
						<div class='carousel-inner'>
<?php

				$i = 1;
				foreach($va_featured_set as $va_featured_set_items){
					print "<div class='carousel-item".(($i == 1) ? " active" : "")."'>";
					print $va_featured_set_items["image"]."<br/>".$va_featured_set_items["label"];
					print "</div>";
					$i++;
				}
?>
							<a class="carousel-control-prev" href="#hpSlideshow<?php print $vn_set_id; ?>" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#hpSlideshow<?php print $vn_set_id; ?>" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div><!-- end carousel-inner -->
					</div><!-- end carousel slide -->
				</div><!-- end col -->
<?php
			}
?>
			</div><!-- end row -->
<?php
		}
	}
?>

