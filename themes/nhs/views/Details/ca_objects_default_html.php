<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					#print '<div class="detailTool"><span class="glyphicon glyphicon-book"></span>'.caNavLink($this->request, _t("Ask a Curator / Request an Image"), "", "", "Contact", "Form", array("object_id" => $t_object->get("object_id"), "contactType" => "askCurator")).'</div><!-- end detailTool -->';
					print "<div class='detailTool'><span class='glyphicon glyphicon-book'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavURL($this->request, '', 'Contact', 'Form', array('table' => 'ca_objects', 'id' => $t_object->get("object_id"), 'contactType' => 'askCurator'))."\"); return false;' title='"._t("Ask a Curator / Request an Image")."'>"._t("Ask a Curator / Request an Image")."</a></div><!-- end detailTool -->";
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				{{{<ifdef code="ca_objects.preferred_labels.name"><div class="unit"><H4>^ca_objects.preferred_labels.name</H4></div></ifdef>}}}
<?php
				$vs_idno = $t_object->get("ca_objects.idno");
				if(!$vs_idno || $vs_idno == "%"){
					$vs_idno = $t_object->get("ca_objects.other_number");
				}
				if($vs_idno){
					print '<div class="unit"><H6>Object number</H6>'.$vs_idno.'</div>';
				}
?>
				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><unit relativeTo="ca_objects" delimiter=" "><div class="unit"><H6><if rule='^ca_objects.nonpreferred_labels.type_id%convertCodesToDisplayText=1 =~ /alternate/'>Alternate </if>Title</H6>^ca_objects.nonpreferred_labels.name</div></unit></ifdef>}}}
				{{{<ifdef code="ca_objects.parent_id"><div class="unit"><H6>Part of</H6><unit relativeTo="ca_objects.parent" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></div></ifdef>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1"><div class="unit"><H6>Creator</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter="<br/>">^ca_entities.preferred_labels</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.date.dates_value"><div class="unit"><H6>Date</H6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.date.dates_value</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<div class="trimText">^ca_objects.description</div>
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.materials"><div class="unit"><H6>Materials</H6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.materials</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.signed.signed_name"><div class="unit"><H6>Inscription</H6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.signed.signed_name">^ca_objects.signed.signed_name</ifdef><ifdef code="ca_objects.signed.signed_location"> (^ca_objects.signed.signed_location)</ifdef></unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.credit_line"><div class="unit"><H6>Credit Line</H6><unit relativeTo="ca_objects.credit_line" delimiter="<br/>">^ca_objects.credit_line</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.doc_type"><div class="unit"><H6>Documentation Type</H6>^ca_objects.doc_type</div></ifdef>}}}
<?php				
				$va_types = $t_object->get("ca_objects.aat", array("returnAsArray" => true));
				$va_types_processed = array();
				if(is_array($va_types) && sizeof($va_types)){
					foreach($va_types as $vs_type){
						$vs_type = trim($vs_type);
						if($vs_type && ($vs_type != $t_object->get("ca_objects.preferred_labels.name"))){
							$va_types_processed[] = $vs_type;
						}
					}
					if(sizeof($va_types_processed)){
						print "<div class='unit'><H6>Object Type".((sizeof($va_types_processed) > 1) ? "s" : "")."</H6>";
						print join(", ", $va_types_processed);
						print "</div>";
					}
				}
				# --- lcsh_tgm and list_items from the search_terms list are grouped together
				$va_subjects = array();
				$va_lcsh_tgm = $t_object->get("ca_objects.lcsh_tgm", array("returnAsArray" => true));
				if(is_array($va_lcsh_tgm) && sizeof($va_lcsh_tgm)){
					foreach($va_lcsh_tgm as $vs_lcsh_tgm){
						$vn_pos = null;
						if($vn_pos = mb_strpos($vs_lcsh_tgm, "[")){
							$vs_lcsh_tgm = mb_substr($vs_lcsh_tgm, 0, $vn_pos);
						}
						$vs_lcsh_tgm = trim($vs_lcsh_tgm);
						if($vs_lcsh_tgm){
							$va_subjects[] = trim($vs_lcsh_tgm);
						}
					}
				}
				$va_search_terms = $t_object->get("ca_list_items", array("returnAsArray" => true, "restrictToLists" => array("search_terms")));
				$va_subjects = array_merge($va_subjects, $va_search_terms);
				asort($va_subjects);
				if(is_array($va_subjects) && sizeof($va_subjects)){
					print "<div class='unit'><H6>Subjects</H6>";
					print join("<br/>", $va_subjects);
					print "</div>";
				}

?>
				{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="artist,donor" excludeTypes="vessel,bipoc_ent"><div class="unit"><H6>Related People & Organizations</H6><unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="artist,donor" excludeTypes="vessel,bipoc_ent">^ca_entities.preferred_labels (^relationship_typename)</unit></div></unit>}}}
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><H6>Collection</H6><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
				
				{{{map}}}
						
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12'>
<?php
	$vs_tmp = $t_object->getWithTemplate("<ifcount code='ca_occurrences.related' min='1' restrictToTypes='event'><unit relativeTo='ca_occurrences' min='1' delimiter=';;;' restrictToTypes='event' sort='ca_occurrences.exhibit_date'><l><div class='bgLightBlue text-center'>^ca_occurrences.preferred_labels.name<ifdef code='ca_occurrences.exhibit_date'>, ^ca_occurrences.exhibit_date</ifdef></div></l>
										</unit></ifcount>", array("checkAccess" => $va_access_values, "sort" => "ca_occurrences.exhibit_date"));
	if($vs_tmp){
		$va_events = explode(";;;", $vs_tmp);
	
		if(is_array($va_events) && sizeof($va_events)){
			$va_rel_events = array();
			$i = 0;
?>
			<div class="row">
				<div class="col-sm-12">
					<H3>Events</H3>
<?php

					$i = 0;
					$col = 0;
					foreach($va_events as $vs_event_info){
						if($col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'>".$vs_event_info."</div>";
						$col++;
						if($col == 3){
							$col = 0;
							print "</div>";
						}
						$i++;
					}
					if($col > 0){
						print "</div>";
					}
?>			
			
				</div>
			</div>
<?php
		}
	}

	$vs_tmp = $t_object->getWithTemplate("<ifcount code='ca_entities' min='1' restrictToTypes='bipoc_ent'><unit relativeTo='ca_entities' min='1' delimiter=';;;' restrictToTypes='bipoc_ent'><l><div class='bgLightBlue text-center'>^ca_entities.preferred_labels.displayname</div></l>
										</unit></ifcount>", array("checkAccess" => $va_access_values));
	if($vs_tmp){
		$va_entities = explode(";;;", $vs_tmp);
	
		if(is_array($va_entities) && sizeof($va_entities)){
			$va_rel_entities = array();
			$i = 0;
?>
			<div class="row">
				<div class="col-sm-12">
					<H3>Related People & Organizations</H3>
<?php

					$i = 0;
					$col = 0;
					foreach($va_entities as $vs_entity_info){
						if($col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'>".$vs_entity_info."</div>";
						$col++;
						if($col == 3){
							$col = 0;
							print "</div>";
						}
						$i++;
					}
					if($col > 0){
						print "</div>";
					}
?>			
			
				</div>
			</div>
<?php
		}
	}

?>	

{{{<ifdef code="ca_objects.children.object_id">
			<div class="row">
				<div class="col-sm-12"><H3>Contains</H3></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_objects.parent_id:^ca_objects.object_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

	
			</div>
		</div></div><!-- end container -->
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
		  maxHeight: 120
		});
	});
</script>