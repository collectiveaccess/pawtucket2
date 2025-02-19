<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_entities_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2025 Whirl-i-Gig
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
$qr_results 		= $this->getVar('result');
$block_info 		= $this->getVar('blockInfo');
$block 				= $this->getVar('block');
$num_items_to_show 	= (int)$this->getVar('numItemsToShow');
$has_more 			= (bool)$this->getVar('hasMore');
$search 			= (string)$this->getVar('search');
$o_config 			= $this->getVar("config");
$o_browse_config 	= caGetBrowseConfig();
$browse_types 		= array_keys($o_browse_config->get("browseTypes"));
$caption_template 	= $this->getVar('resultCaption');
$access_values 		= caGetUserAccessValues($this->request);
$table 				= $this->getVar('table');
$pk					= $this->getVar('primaryKey');
$options 			= $block_info["options"] ?? [];

$o_icons_conf 		= caGetIconsConfig();
$object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
if(!($default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
	$default_placeholder = "<div class='display-1 text-center d-flex bg-light ca-placeholder'><i class='bi bi-card-image align-self-center w-100' aria-label='media placeholder'></i></div>";
}

$image_format = $this->getVar('imageFormat');
$image_class = ($image_format == "contain") ? "card-img-top object-fit-contain px-3 pt-3 rounded-0" : "card-img-top object-fit-cover rounded-0";
	

if ($qr_results->numHits() > 0) {
	$c = 0;
?>
	<div class='row'>
		<div class='col-12 mt-3 mb-2 text-capitalize fw-semibold'>
			<?= $qr_results->numHits()." ".(($qr_results->numHits() == 1) ? $block_info["labelSingular"] : $block_info["labelPlural"]); ?>
		</div>
	</div>
	<div class='row'>
<?php
	if ($table != 'ca_objects') {
		$ids = array();
		while($qr_results->nextHit() && ($c < $num_items_to_show)) {
			$ids[] = $qr_results->get($pk);
			$c++;
		}
		$images = caGetDisplayImagesForAuthorityItems($table, $ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $options, null), 'checkAccess' => $access_values));
	
		$c = 0;	
		$qr_results->seek(1);
	}
	
	$t_list_item = new ca_list_items();
	while($qr_results->nextHit()) {
		$id = $qr_results->get("{$table}.{$pk}");
		
		$caption 	= $qr_results->getWithTemplate($caption_template, array("checkAccess" => $access_values));
		$thumbnail = "";
		$type_placeholder = "";
		$typecode = "";
		
		if ($table == 'ca_objects') {
			if(!($thumbnail = $qr_results->get('ca_object_representations.media.medium', array("checkAccess" => $access_values, "class" => $image_class)))){
				$t_list_item->load($qr_results->get("type_id"));
				$typecode = $t_list_item->get("idno");
				if($type_placeholder = caGetPlaceholder($typecode, "placeholder_media_icon")){
					$thumbnail = $type_placeholder;
				}else{
					$thumbnail = $default_placeholder;
				}
			}
			$rep_detail_link 	= caDetailLink($this->request, $thumbnail, '', $table, $id);				
		} else {
			if($images[$id]){
				$thumbnail = $images[$id];
			}else{
				$thumbnail = $default_placeholder;
			}
			$rep_detail_link 	= caDetailLink($this->request, $thumbnail, '', $table, $id);			
		}
		$detail_button_link = caDetailLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'link-dark mx-1', $table, $id, null, array("title" => _t("View Record"), "aria-label" => _t("View Record")));
		print "
	<div class='col-md-4 col-lg-3 d-flex'>
		<div id='row{$id}' class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>
		  {$rep_detail_link}
			<div class='card-body'>
				{$caption}
			</div>
			<div class='card-footer text-end bg-transparent'>
				{$detail_button_link}
			</div>
		 </div>	
	</div><!-- end col -->";				
		$c++;
		if($c == $num_items_to_show){
			if($qr_results->numHits() > $num_items_to_show){
?>
				<div class='row justify-content-center'>
					<div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center'>
						<?= caNavLink($this->request, _t("Full Results")."  <i class='ps-2 bi bi-box-arrow-up-right' aria-label='link out'></i>", "pt-3 pb-4 px-2 d-flex align-items-center justify-content-center bg-dark h-100 w-100 text-white", "", "Search", $block, ["search" => $search]); ?>
					</div>
				</div>
<?php
			}
			break;
		}
	}
	print "</div>";
}
