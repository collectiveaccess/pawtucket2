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
	
	
	require_once(__CA_THEMES_DIR__."/stolaf/lib/elevatorAPI.php");
	
	$media_url = null;
	if(($elevator_url = $t_object->get('ca_objects.url')) && preg_match("!viewAsset/([a-z0-9]{24})[/]?$!", $elevator_url, $m)) {
		$elevator_id = $m[1];
		$e = new elevatorAPI("https://digital.stolaf.edu/archives/api/v1/", __ELEVATOR_KEY__, __ELEVATOR_SECRET__);
		$children = $e->getAssetChildren($elevator_id);
		if(is_array($children) && is_array($children['matches'])  && is_array($children['matches'][0])) {
			$media_url = $children['matches'][0]['primaryHandlerThumbnail2x'];
		}
	}
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
						
					// if($media_url) {
// 						print "<p><a href='{$elevator_url}' target='_elevator'><img src='{$media_url}' style='max-width: 435px;'/></a></p>";
// 					}
					print '<div id="detailTools">';
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
?>
					<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel("<?= caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array('object_id' => $vn_id)); ?>"); return false;' title='Add to lightbox'><span class='fa fa-suitcase'></span><?= _t('Add to favorites'); ?></a></div>
<?php
					print '</div><!-- end detailTools -->';
				}				

?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
<?php
				print "<div class='inquireButton'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
?>

				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
				{{{<ifdef code="ca_objects.abstract"><div class="unit"><label>Abstract</label><div class="trimText">^ca_objects.abstract%delimiter=,_</div></div></ifdef>}}}
					
				{{{<ifdef code="ca_objects.material_type"><div class="unit"><label>Material Type</label>^ca_objects.material_type%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.langmaterial"><div class="unit"><label>Languages and Scripts of Collection Materials</label>^ca_objects.langmaterial%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.unitdate.dacs_date_text"><div class="unit"><label>Date</label><unit relativeTo="ca_objects.unitdate" delimiter="<br/>"><ifdef code="ca_objects.unitdate.dacs_dates_labels">^ca_objects.unitdate.dacs_dates_labels: </ifdef>^ca_objects.unitdate.dacs_date_text <ifdef code="ca_objects.unitdate.dacs_dates_types">^ca_objects.unitdate.dacs_dates_types</ifdef></unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.extentDACS.extent_number|ca_objects.extentDACS.portion_label|ca_objects.extentDACS.extent_type|ca_objects.extentDACS.container_summary|ca_objects.extentDACS.physical_details">
					<div class="unit"><label>Extent</label>
						<unit relativeTo="ca_objects.extentDACS">
							<ifdef code="ca_objects.extentDACS.extent_number">^ca_objects.extentDACS.extent_number </ifdef>
							<ifdef code="ca_objects.extentDACS.extent_type">^ca_objects.extentDACS.extent_type</ifdef>
							<ifdef code="ca_objects.extentDACS.container_summary"><br/>^ca_objects.extentDACS.container_summary</ifdef>
							<ifdef code="ca_objects.extentDACS.physical_details"><br/>^ca_objects.extentDACS.physical_details</ifdef>
						</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.url"><div class="unit"><label>Url To External Media</label><a href="^ca_objects.url" target="_blank" class="url"><i class="fa fa-external-link" aria-hidden="true"></i> ^ca_objects.url</a></div></ifdef>}}}
				{{{<ifdef code="ca_objects.history_tracking_current_value%policy=current_location"><div class="unit"><label>Location</label>
					^ca_objects.history_tracking_current_value%policy=current_location
				</div></ifdef>}}}
				{{{<ifdef code="ca_objects.general_notes"><div class="unit"><label>Notes</label>^ca_objects.general_notes%delimiter=<br/></div></ifdef>}}}
				{{{<ifdef code="ca_objects.accessrestrict"><div class="unit"><label>Conditions Governing Access</label>^ca_objects.accessrestrict%delimiter=<br/></div></ifdef>}}}
				{{{<ifdef code="ca_objects.physaccessrestrict"><div class="unit"><label>Physical Access</label>^ca_objects.physaccessrestrict%delimiter=<br/></div></ifdef>}}}
				
				
				
				
				<hr></hr>
					
<?php

					# --- entity name should be the loc name when Entity Source is LCNAF
					print preg_replace('/\[[^)]+\]/', '', $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="ind"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="ind"><label>Related person</label></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="ind"><label>Related people</label></ifcount><unit relativeTo="ca_entities" restrictToTypes="ind" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					print preg_replace('/\[[^)]+\]/', '', $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="org"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="org"><label>Related organization</label></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="org"><label>Related organizations</label></ifcount><unit relativeTo="ca_entities" restrictToTypes="org" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					print preg_replace('/\[[^)]+\]/', '', $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="fam"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="fam"><label>Related family</label></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="fam"><label>Related families</label></ifcount><unit relativeTo="ca_entities" restrictToTypes="fam" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					
					$va_LcshSubjects = $t_object->get("ca_objects.LcshSubjects", array("returnAsArray" => true));
					$va_LcshSubjects_processed = array();
					if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
						foreach($va_LcshSubjects as $vs_LcshSubjects){
							if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
								$va_LcshSubjects_processed[] = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
							}else{
								$va_LcshSubjects_processed[] = $vs_LcshSubjects;
							}
						}
						$vs_LcshSubjects = join("<br/>", $va_LcshSubjects_processed);
					}
					if($vs_LcshSubjects){
						print "<div class='unit'><label>Subjects</label>".$vs_LcshSubjects."</div>";	
					}

					$va_LcshGenre = $t_object->get("ca_objects.LcshGenre", array("returnAsArray" => true));
					$va_LcshGenre_processed = array();
					if(is_array($va_LcshGenre) && sizeof($va_LcshGenre)){
						foreach($va_LcshGenre as $vs_LcshGenre){
							if($vs_LcshGenre && (strpos($vs_LcshGenre, " [") !== false)){
								$va_LcshGenre_processed[] = mb_substr($vs_LcshGenre, 0, strpos($vs_LcshGenre, " ["));
							}else{
								$va_LcshGenre_processed[] = $vs_LcshGenre;
							}
						}
						$vs_LcshGenre = join("<br/>", $va_LcshGenre_processed);
					}
					$va_aat = $t_object->get("ca_objects.aat", array("returnAsArray" => true));
					$va_aat_processed = array();
					if(is_array($va_aat) && sizeof($va_aat)){
						foreach($va_aat as $vs_aat){
							if($vs_aat && (strpos($vs_aat, " [") !== false)){
								$va_aat_processed[] = mb_substr($vs_aat, 0, strpos($vs_aat, " ["));
							}else{
								$va_aat_processed[] = $vs_aat;
							}
						}
						$vs_aat = join("<br/>", $va_aat_processed);
					}
					if($vs_LcshGenre || $vs_aat){
						print "<div class='unit'><label>Genres</label>";
						if($vs_LcshGenre){
							print $vs_LcshGenre;
						}
						if($vs_LcshGenre && $vs_aat){
							print "<br/>";
						}
						if($vs_aat){
							print $vs_aat;
						}
						print "</div>";	
					}
					$va_LcshNames = $t_object->get("ca_objects.LcshNames", array("returnAsArray" => true));
					$va_LcshNames_processed = array();
					if(is_array($va_LcshNames) && sizeof($va_LcshNames)){
						foreach($va_LcshNames as $vs_LcshNames){
							if($vs_LcshNames && (strpos($vs_LcshNames, " [") !== false)){
								$va_LcshNames_processed[] = mb_substr($vs_LcshNames, 0, strpos($vs_LcshNames, " ["));
							}else{
								$va_LcshNames_processed[] = $vs_LcshNames;
							}
						}
						$vs_LcshNames = join("<br/>", $va_LcshNames_processed);
					}
					if($vs_LcshNames){
						print "<div class='unit'><label>Library of Congress Names</label>".$vs_LcshNames."</div>";	
					}
?>				
				{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount><ifcount code="ca_places" min="2"><label>Related places</label></ifcount><unit relativeTo="ca_places" delimiter="<br/>"><unit relativeTo="ca_places.hierarchy" delimiter=" &gt; "><l>^ca_places.preferred_labels</l></unit></unit></div></ifcount>}}}
				
				<br/>{{{map}}}
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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
		  maxHeight: 200
		});
	});
</script>
