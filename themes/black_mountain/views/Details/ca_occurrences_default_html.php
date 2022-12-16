<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = 	caGetUserAccessValues($this->request);
	$vs_represenation_viewer = trim($this->getVar("representationViewer"));
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
			<div class="row">
<?php
			if($vs_represenation_viewer){
?>
				<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				
?>
				{{{<ifdef code="ca_occurrences.accessibility_description"><div class="unit"><label>Accessibility Description</label>^ca_occurrences.accessibility_description</div></ifdef>}}}
				
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6'>
<?php
			}else{
?>
				<div class='col-md-12 col-lg-12'>
<?php
			}
?>
					<H2>{{{^ca_occurrences.type_id<ifdef code="ca_occurrences.idno">: ^ca_occurrences.idno</ifdef>}}}</H2>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					{{{<ifdef code="ca_occurrences.display_date">
						<div class='unit'>^ca_occurrences.display_date</div>
					</ifdef>}}}	
					{{{<ifnotdef code="ca_occurrences.display_date"><ifdef code="ca_occurrences.index_date">
						<div class='unit'>^ca_occurrences.index_date</div>
					</ifdef></ifnotdef>}}}
					
					<HR/>
					{{{<ifdef code="ca_occurrences.description"><div class="unit"><span class="trimText">^ca_occurrences.description</span></div></ifdef>}}}

<?php
$va_event_types = $t_item->get("ca_occurrences.event_type", array("returnAsArray" => true));
if(is_array($va_event_types) && sizeof($va_event_types)){
?>
	<div class='unit'><label>Event Type</label>
<?php
		$va_tmp = array();
		$t_list_item = new ca_list_items();
		foreach($va_event_types as $vn_event_type_id){
			$t_list_item->load($vn_event_type_id);
			$va_tmp[] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "Programs", array("facet" => "event_type_facet", "id" => $vn_event_type_id));
		}
		print join(", ", $va_tmp);
?>
	</div>
<?php	
}
?>
					{{{<ifdef code="ca_occurrences.event_format">
						<div class='unit'><label>Event Format</label>^ca_occurrences.event_format</div>
					</ifdef>}}}
<?php
					$va_programs = $t_item->get("ca_occurrences.related", array("restrictToTypes" => array("event", "exhibitions", "performance", "series"), "restrictToRelationshipTypes" => array("part_of"), "returnWithStructure" => 1, "checkAccess" => $va_access_values));
					if(is_array($va_programs) && sizeof($va_programs)){
						$va_programs_by_type = array();
						foreach($va_programs as $va_program_info){
							$va_programs_by_type[$va_program_info["relationship_typename"]][] = caDetailLink($this->request, $va_program_info["name"], "", "ca_occurrences", $va_program_info["occurrence_id"]);
						}
						# --- part of
						if($va_part_of = $va_programs_by_type["Is Part of"]){
							print "<div class='unit'><label>This ".$t_item->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true))." Is Part Of</label>".join("<br/>", $va_part_of)."</div>";
						}
						# --- contains
						if($va_contains = $va_programs_by_type["Contains"]){
							print "<div class='unit'><label>In this ".$t_item->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true))."</label>".join("<br/>", $va_contains)."</div>";
						}
					}
?>

					{{{<ifcount code="ca_places" restrictToRelationshipTypes="occurred_at" min="1"><div class="unit"><label>Location</label>
						<unit relativeTo="ca_places" restrictToRelationshipTypes="occurred_at" delimiter="<br/>">^ca_places.preferred_labels</unit></div></ifcount>}}}
					{{{<ifcount code="ca_places" restrictToRelationshipTypes="has_subject" min="1"><div class="unit"><label>Subject</label>
						<unit relativeTo="ca_places" restrictToRelationshipTypes="has_subject" delimiter="<br/>">^ca_places.preferred_labels</unit></div></ifcount>}}}
					
					
					
					{{{<ifdef code="ca_occurrences.creditLine">
						<div class='unit'><label>Credit</label>^ca_occurrences.creditLine</div>
					</ifdef>}}}
					{{{<ifdef code="ca_occurrences.external_link.url_entry"><div class="unit"><label>External Link</label><unit relativeTo="ca_occurrences.external_link" delimiter="<br/>"><a href="^ca_occurrences.external_link.url_entry" target="_blank"><ifdef code="ca_occurrences.external_link.url_source">^ca_occurrences.external_link.url_source</ifdef><ifnotdef code="ca_occurrences.external_link.url_source">^ca_occurrences.external_link.url_entry</ifnotdef></a></unit></div></ifdef>}}}

					
<?php
				$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><label>".$vs_type."</label>".join("<br/>", $va_entity_links)."</div>";
					}
				}

?>				
				
				{{{<ifcount code="ca_occurrences.related" restrictToTypes="historical_events" min="1"><div class="unit"><label>Related Historical Events</label>
					<unit relativeTo="ca_occurrences.related" restrictToTypes="historical_events" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></div></ifcount>}}}

				{{{<ifcount code="ca_occurrences.related" restrictToRelationshipTypes="in_conjunction_with" min="1"><div class="unit"><label>In Conjunction With</label>
						<span class="trimText"><unit relativeTo="ca_occurrences.related" restrictToRelationshipTypes="in_conjunction_with" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></span></div></ifcount>}}}
					
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1" restrictToTypes="artwork, oral_history, archival_object, publication">
			<div class="row">
				<div class="col-sm-12"><div class="unit"><label>Related Objects</label></div><HR/></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'occ_all_facet', 'id' => '^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 128
		});
	});
</script>
