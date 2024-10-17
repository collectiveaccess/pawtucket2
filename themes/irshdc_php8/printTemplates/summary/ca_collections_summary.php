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
 * @tables ca_collections
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
	$o_collections_config = caGetCollectionsConfig();
	
	
	$vs_desc_template = $o_collections_config->get("description_template_archival");
	$vs_desc_template_file = $o_collections_config->get("description_template_archival_file");
	$vn_collection_id = $t_item->get("ca_collections.collection_id");





	
	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	




	$vs_source = $t_item->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="source" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>', array("checkAccess" => $va_access_values));						
	$vs_source_link = $t_item->get("ca_collections.link");
	if($vs_source_link){
		$vs_source_link = '<div class="unit"><H6>'.(($vs_source) ? $vs_source : 'Source Record').'</H6>'.$vs_source_link.'</div>';
	}						

	$vs_title_hover = $t_item->getWithTemplate("<ifdef code='ca_collections.ISADG_titleNote'>^ca_collections.ISADG_titleNote%delimiter=;_</ifdef>");
	$vs_title = $t_item->get("ca_collections.preferred_labels.name");
?>
	<div class="title">
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
	</div>
	{{{<ifdef code="ca_collections.ISADG_titleNote"><div class="unit"><H6>Title Note</H6>^ca_collections.ISADG_titleNote%delimiter=;_</div></ifdef>}}}
	<?php print $vs_source_link; ?>
	<div class="unit">
		<div class="uppercase">{{{^ca_collections.type_id}}}</div>
	</div>
	{{{<ifdef code="ca_collections.displayDate">
		<div class="unit"><H6>Date</H6>^ca_collections.displayDate</div>
		<ifdef code="ca_collections.ISADG_dateNote">
			<div class="unit"><H6>Date Note</H6>^ca_collections.ISADG_dateNote</div>
		</ifdef>
	</ifdef>}}}
	
	{{{<ifdef code="ca_collections.resource_type"><if rule='^ca_collections.resource_type !~ /-/'><div class="unit"><H6>Resource Type</H6><ifdef code="ca_collections.resource_type">^ca_collections.resource_type%useSingular=1<ifdef code="ca_collections.genre"> > </ifdef></ifdef><ifdef code="ca_collections.genre">^ca_collections.genre%delimiter=,_</unit></ifdef></div></if></ifdef>}}}
	{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
<?php
	$vs_creators_entities = $t_item->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="contributor,creator" delimiter="; ">^ca_entities.preferred_labels.displayname</unit>', array("checkAccess" => $va_access_values));
	$vs_creators_text = $t_item->get('ca_collections.creator_contributor');
	if($vs_creators_entities || $vs_creators_text){
		print '<div class="unit"><H6>Creators and Contributors</H6><div class="trimTextShort">'.$vs_creators_entities.(($vs_creators_entities && $vs_creators_text) ? "; " : "").$vs_creators_text.'</div></div>';
	}
?>	
	
	
	
	
	{{{<ifdef code="ca_collections.RAD_admin_hist">
		<div class="unit"><h6>Administrative/Biographical History</h6>
			<div>^ca_collections.RAD_admin_hist</div>
		</div>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.scope_new.scope_new_text">
		<div class="unit"><h6>Description</h6>
			^ca_collections.scope_new.scope_new_text
		</div>
		<ifdef code="ca_collections.scope_new.scope_new_source">
			<div class="unit"><h6>Description Source</h6>
				^ca_collections.scope_new.scope_new_source
			</div>
		</ifdef>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.curators_comments.comments">
		<div class="unit"><h6>Curatorial Comment</h6>
			^ca_collections.curators_comments.comments
		</div>
		<ifdef code="ca_collections.curators_comments.comment_reference">
			<div class="unit"><H6>Curatorial Comment Source</H6>
				^ca_collections.curators_comments.comment_reference
			</div>
		</ifdef>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.content_notice.content_notice_value">
		<div class='unit'><h6>Content Notice</h6>
			^ca_collections.content_notice.content_notice_value
		</div>
		<ifdef code="ca_collections.content_notice.content_notice_source">
			<div class="unit"><H6></H6>
				^ca_collections.content_notice.content_notice_source
			</div>
		</ifdef>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.about_school_photographs.about_school_photos_text">
		<div class='unit'><h6>About Residential School Photographs</h6>
			^ca_collections.about_school_photographs.about_school_photos_text
		</div>
		<ifdef code="ca_collections.about_school_photographs.about_school_photos_source">
			<div class="unit"><H6>About Residential School Photographs Source</H6>
				^ca_collections.about_school_photographs.about_school_photos_source
			</div>
		</ifdef>	
	</ifdef>}}}
	{{{<ifdef code="ca_collections.community_input_objects.comments_objects">
		<div class='unit'><h6>Dialogue</h6>
			^ca_collections.community_input_objects.comments_objects
		</div>
		<ifdef code="ca_collections.community_input_objects.comment_reference_objects">
			<div class="unit"><H6>Dialogue Source</H6>
				^ca_collections.community_input_objects.comment_reference_objects
			</div>
		</ifdef>							
	</ifdef>}}}
	{{{<ifdef code="ca_collections.language">
		<div class="unit"><h6>Language</h6>^ca_collections.language%delimiter=,_</div>
		<ifdef code="ca_collections.language_note">
			<div class="unit"><H6>Language Note</H6>
				^ca_collections.language_note%delimiter=;_
			</div>
		</ifdef>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.RAD_generalNote">
		<div class='unit'><h6>Notes</h6><unit relativeTo="ca_collections.RAD_generalNote" delimiter="<br/>">^ca_collections.RAD_generalNote</unit></div>
	</ifdef>}}}	
	
	<div class="unit">
		<h3>More Information <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></H3>
		{{{
			<ifdef code="ca_collections.nonpreferred_labels"><div class="unit"><H6>Alternate Title(s)</H6><unit relativeTo="ca_collections.nonpreferred_labels" delimiter="<br/>">^ca_collection_labels.name</unit></div></ifdef>
			<ifcount code="ca_entities" restrictToRelationshipTypes="repository" min="1"><div class="unit"><h6>Holding Repository</h6><unit relativeTo="ca_entities" restrictToRelationshipTypes="repository" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>
			<ifdef code="ca_collections.source_identifer"><div class='unit'><h6>Holding Repository Identifier</h6>^ca_collections.source_identifer</div></ifdef>
			<ifdef code="ca_collections.citation"><div class='unit'><h6>Cite this Record</h6>^ca_collections.citation</div></ifdef>
			<ifdef code="ca_collections.RAD_extent"><div class="unit"><H6>Extent and Medium</H6><unit relativeTo="ca_collections.RAD_extent" delimiter="<br/>">^ca_collections.RAD_extent</unit></div></ifdef>
			<ifdef code="ca_collections.RAD_custodial"><div class="unit"><h6>Archival History</h6>^ca_collections.RAD_custodial</div></ifdef>
			<ifdef code="ca_collections.ISADG_archNote"><div class='unit'><h6>Archivist Notes</h6>^ca_collections.ISADG_archNote</div></ifdef>
			<ifdef code="ca_collections.govAccess"><div class='unit'><h6>Conditions Governing Access</h6>^ca_collections.govAccess</div></ifdef>
			<ifdef code="ca_collections.RAD_usePub"><div class='unit'><h6>Terms Governing Reproduction</h6>^ca_collections.RAD_usePub</div></ifdef>
			<ifdef code="ca_collections.RAD_local_rights"><div class='unit'><h6>Notes: Rights and Access</h6>^ca_collections.RAD_local_rights</div></ifdef>
			<ifdef code="ca_collections.RAD_arrangement"><div class="unit"><h6>System of Arrangement</h6>^ca_collections.RAD_arrangement</div></ifdef>
			<ifdef code="ca_collections.ISADG_rules"><div class='unit'><h6>Rules or Conventions</h6>^ca_collections.ISADG_rules</div></ifdef>
			<ifdef code="ca_collections.RAD_accruals"><div class="unit"><h6>Accruals</h6>^ca_collections.RAD_accruals</div></ifdef>
		}}}
<?php
		print "<div class='unit'><H6>Permalink</H6>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'collections/'.$t_item->get("collection_id"))."</div>";					
?>			
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		#if ($t_item->get('ca_collections.collection_id')) {
		#	print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		#}
		print printLevelArchivalCollectionExport($this->request, array($t_item->get('ca_collections.collection_id')), $o_collections_config, 1);

	}
	print $this->render("pdfEnd.php");








?>