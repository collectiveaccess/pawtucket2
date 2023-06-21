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

	<div class="row">
		<div class="col-sm-12">
			<h1>Explore the Collection</h1>
			<div class="frontIntro">
				{{{hp_intro}}}
			</div>
		</div>
	</div>
<?php
	$t_lists = new ca_lists();
	$vn_event_id = $t_lists->getItemIDFromList("occurrence_types", "event");
	$vn_exhibition_id = $t_lists->getItemIDFromList("occurrence_types", "exhibitions");
	$va_frontPageSets = array("frontPageCollections" => array("title" => "Collection Highlights", "table" => "ca_objects", "browse_text" => "objects", "browse" => "objects", "captionTemplate" => "^ca_objects.preferred_labels.name"),
								"frontPagePeople" => array("title" => "People", "table" => "ca_entities", "browse_text" => "people", "browse" => "people", "captionTemplate" => "^ca_entities.preferred_labels"),
								"frontPageExhibitions" => array("title" => "Exhibitions", "table" => "ca_occurrences", "browse_text" => "exhibitions", "browse" => "programs", "captionTemplate" => "^ca_occurrences.preferred_labels.name", "filter" => "type_facet", "filter_id" => $vn_exhibition_id),
								"frontPageEvents" => array("title" => "Events", "table" => "ca_occurrences", "browse_text" => "events", "browse" => "programs", "captionTemplate" => "^ca_occurrences.preferred_labels.name", "filter" => "type_facet", "filter_id" => $vn_event_id)
								);

	foreach($va_frontPageSets as $vs_set_code => $va_frontPageSetInfo){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
			if(is_array($va_featured_ids) && sizeof($va_featured_ids)){
				$qr_set_items = caMakeSearchResult($va_frontPageSetInfo["table"], $va_featured_ids);
				$va_params = array();
				if($va_frontPageSetInfo["filter"] && $va_frontPageSetInfo["filter_id"]){
					$va_params = array("facet" => $va_frontPageSetInfo["filter"], "id" => $va_frontPageSetInfo["filter_id"]);
				}
?>
				<div class="row">
					<div class="col-sm-12">
						<div class="frontBrowseAll">
							<?php print caNavLink($this->request, "Browse ".$va_frontPageSetInfo["browse_text"]." >", "frontBrowseAll", "", "Browse", $va_frontPageSetInfo["browse"], $va_params); ?>
						</div>
						<div class="sectionTitle"><?php print $va_frontPageSetInfo["title"]; ?></div>
						<hr/>
					</div>
				</div>
				<div class="frontGrid">
					<div class="row">					
<?php
					$i = 0;
					while($qr_set_items->nextHit()){
						print $qr_set_items->getWithTemplate("<l><div class='col-sm-3'><ifdef code='ca_object_representations.media.widepreview'>^ca_object_representations.media.widepreview</ifdef><ifnotdef code='ca_object_representations.media.widepreview'><ifcount code='ca_objects' min='1'><unit relativeTo='ca_objects' limit='1'>^ca_object_representations.media.widepreview</unit></ifcount></ifnotdef><div class='frontGridCaption'>".$va_frontPageSetInfo["captionTemplate"]."</div></div></l>");
						$i++;
						if($i == 4){
							break;
						}
					}
					
?>					
					</div>
				</div>
<?php					
			}
		}
	}
	
	$hp_video_1 = $this->getVar("hp_video_1");
	$hp_video_2 = $this->getVar("hp_video_2");
	$hp_video_3 = $this->getVar("hp_video_3");
	$hp_video_4 = $this->getVar("hp_video_4");
	if($hp_video_1 || $hp_video_2 || $hp_video_3 || $hp_video_4){
?>
	<div class="frontFeaturedVideos">
		<div class="row">
<?php
			if($hp_video_1){
				print "<div class='col-sm-6 videoCol'>".$hp_video_1."</div>";
			}
			if($hp_video_2){
				print "<div class='col-sm-6 videoCol'>".$hp_video_2."</div>";
			}
			if($hp_video_3){
				print "<div class='col-sm-6 videoCol'>".$hp_video_3."</div>";
			}
			if($hp_video_4){
				print "<div class='col-sm-6 videoCol'>".$hp_video_4."</div>";
			}
?>
		</div>				
	</div>
<?php
	}
?>
