<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_collections_summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Collection Finding Aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_entities
 * @restrictToTypes school
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");
	$va_access_values = 	$this->getVar("access_values");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

	$vs_featured_image = $t_item->getWithTemplate("<unit relativeTo='ca_objects' length='1' restrictToRelationshipTypes='featured'><ifdef code='ca_object_representations.media.medium'>^ca_object_representations.media.medium<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-center'>^ca_object_representations.preferred_labels.name</div></if><br/><br/></ifdef></unit>", array("checkAccess" => $va_access_values, "limit" => 1));
	$vs_entity_image = $t_item->getWithTemplate("<ifdef code='ca_object_representations.media.medium'>^ca_object_representations.media.medium<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-center'>^ca_object_representations.preferred_labels.name</div></if><br/><br/></ifdef>", array("checkAccess" => $va_access_values, "limit" => 1));

?>
	<div class="title">
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
		{{{<ifdef code="ca_entities.school_name_source"><div class="source">Source: ^ca_entities.school_name_source</div></ifdef>}}}
		{{{<ifdef code="ca_entities.entity_website"><div class="source"><a href="^ca_entities.entity_website" target="_blank">^ca_entities.entity_website</a></div></ifdef>}}}
	</div>

	<div class="representationList">		
<?php
		if($vs_featured_image){
			print $vs_featured_image;
		}else{
			print $vs_entity_image;
		}
?>
	</div>
	{{{<ifdef code="ca_entities.home_community.home_community_text"><div class='unit'><H6>Home Communities of Students</H6><unit delimiter="<br/>">^ca_entities.home_community.home_community_text<ifdef code="ca_entities.home_community.home_community_source"><div class="source">^ca_entities.home_community.home_community_source</div></ifdef></unit></div></ifdef>}}}					
	{{{<ifdef code="ca_entities.note_community_name"><div class='unit'><H6>Note on Home Communities</H6><div>^ca_entities.note_community_name</div></div></ifdef>}}}		

					{{{<ifdef code="ca_entities.school_dates.school_dates_value">
						<div class='unit'>
							<H6>Dates of Operation</H6>
							<unit delimiter=" ">
								<ifdef code="ca_entities.school_dates.school_dates_value">^ca_entities.school_dates.school_dates_value<br/></ifdef>
								<ifdef code="ca_entities.school_dates.date_narrative">^ca_entities.school_dates.date_narrative</ifdef>
								<ifdef code="ca_entities.school_dates.date_source"><div class="source">Source</div></ifdef>
							</unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_entities.IRSSA_Dates.IRSSA_Dates_date">
						<div class='unit'>
							<H6>Settlement Agreement Dates</H6>
							<unit delimiter="<br/><br/>" relativeTo="ca_entities.IRSSA_Dates">
								<ifdef code="ca_entities.IRSSA_Dates.IRSSA_Dates_date">^ca_entities.IRSSA_Dates.IRSSA_Dates_date</ifdef>
								<ifdef code="ca_entities.IRSSA_Dates.IRSSA_Dates_source"><div class="source">Source: ^ca_entities.IRSSA_Dates.IRSSA_Dates_source</div></ifdef>
							</unit>
						</div>
					</ifdef>}}}
					{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities_x_entities" restrictToTypes="school" delimiter=", "><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</unit></div></ifcount>}}}
					{{{<ifdef code="ca_entities.description_new.description_new_txt">
						<div class="unit">
							<h6>Description</h6>
							^ca_entities.description_new.description_new_txt
							<ifdef code="ca_entities.description_new.description_new_source"><div class="source">Source: ^ca_entities.description_new.description_new_source</div></ifdef>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_entities.additionalResources"><div class='unit'><H6>Additional Resources</H6>^ca_entities.additionalResources</div></ifdef>}}}		
					
					{{{<ifdef code="ca_entities.community_input_objects.comments_objects">
						<div class='unit'><h6>Dialogue</h6>
							^ca_entities.community_input_objects.comments_objects
							<ifdef code="ca_entities.community_input_objects.comment_reference_objects"><div class="source">Source: ^ca_entities.community_input_objects.comment_reference_objects</div></ifdef>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_entities.denomination"><div class='unit'><H6>Denomination</H6>^ca_entities.denomination%delimiter=,_</div></ifdef>}}}		
					
<?php
		# --- themes and narrative threads
		$va_attributes = array("narrative_thread" => "narrative_threads_facet", "themes" => "theme_facet");
		$vs_themes = "";
		$t_list = new ca_lists();
		$t_list_item = new ca_list_items();
		foreach($va_attributes as $vs_attribute => $vs_facet){
			if($va_themes = $t_item->get("ca_entities.".$vs_attribute, array("returnAsArray" => true, "checkAccess" => $va_access_values))){
				foreach($va_themes as $vn_theme_id){
					#$vs_theme_name = $t_list->getItemFromListForDisplayByItemID($vs_attribute, $vn_theme_id);
					$t_list_item->load($vn_theme_id);
					#$vs_theme_name = $t_list_item->get("ca_list_item_labels.name_singular");
					$va_theme_hier = $t_list_item->get("ca_list_item_labels.hierarchy", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
					$va_theme_breadcrumb = array();
					if(is_array($va_theme_hier)){
						foreach($va_theme_hier as $va_theme){
							foreach($va_theme as $vn_hier_theme_id => $va_theme_info){
								$va_theme_info = array_pop($va_theme_info);
								$va_theme_breadcrumb[] = caNavLink($this->request, $va_theme_info["name_singular"], "", "", "browse", "objects", array("facet" => $vs_facet, "id" => $vn_hier_theme_id));
							}
						}
						$vs_themes .= "<div>> ".join(" > ", $va_theme_breadcrumb)." <span>(".str_replace("_", " ", $vs_attribute).")</span></div>";
					}
				}
			}
		}
		
		if($vs_themes){
?>							
			<div class="unit">
				<h3>Themes</H3>
				<div class="blockContent trimTextSubjects">
<?php
						print $vs_themes; 
						
?>
				</div>
			</div>
<?php
		}

?>					{{{<ifdef code="ca_entities.alternate_text.alternate_desc_upload.url">
						<div class="unit">
							<h3>Research Guide <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></H3>
							<div>
								<div class='unit icon transcription'><unit relativeTo="ca_entities" delimiter="<br/>"><ifdef code="ca_entities.alternate_text.alternate_desc_upload"><a href="^ca_entities.alternate_text.alternate_desc_upload.url%version=original">View ^ca_entities.alternate_text.alternate_text_type</a></ifdef><ifdef code="ca_entities.alternate_text.alternate_desc_note">^ca_entities.alternate_text.alternate_desc_note</ifdef></unit></div>
							</div>
						</div>
					</ifdef>}}}
					<div class="unit">
						<h3>More Information <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></H3>
						<div>
							{{{<unit relativeTo="ca_entities" delimiter="<br/>">
								<div class="unit">
									<H6>Alternate Name(s)</H6>
									^ca_entities.nonpreferred_labels.displayname
									<ifdef code="ca_entities.alt_name_source"><div class="source">Source: ^ca_entities.alt_name_source</div></ifdef>
								<div>
							</unit>}}}
							{{{<ifdef code="ca_entities.public_notes"><div class='unit'><h6>Notes</h6>^ca_entities.public_notes%delimiter=<br/></div></ifdef>}}}
<?php
							$vs_permalink = $this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'entities/'.$t_item->get("entity_id"));
							print "<div class='unit'><H6>Permalink</H6><a href='".$vs_permalink."'>".$vs_permalink."</a></div>";					
?>
						</div>
					</div>
					{{{<ifdef code="ca_places.place_location|ca_places.location_credit|ca_places.place_location_source">
						<div class="unit">
							<h3>Location Information <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></H3>
							<div class="">
								<ifdef code="ca_places.place_location"><div class="unit"><H6>Location</H6><unit relativeTo="ca_places.place_location" delimiter="<br/>">^ca_places.place_location</unit></div></ifdef>
								<ifdef code="ca_places.location_credit"><div class="unit"><H6>Location Credit</H6><unit relativeTo="ca_places.location_credit" delimiter="<br/>">^ca_places.location_credit</unit></div></ifdef>
								<ifdef code="ca_places.place_location_source"><div class="unit"><H6>Location Source</H6><unit relativeTo="ca_places.place_location_source" delimiter="<br/>">^ca_places.place_location_source</unit></div></ifdef>
							
							</div>
						</div></ifdef>}}}
<?php
	print $this->render("entities_summary_related_records.php");
	print $this->render("pdfEnd.php");
?>