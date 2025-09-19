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
$comments = 			$this->getVar("comments");
$tags = 				$this->getVar("tags_array");
$comments_enabled = 	$this->getVar("commentsEnabled");
$share_enabled = 	$this->getVar("shareEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$audio_recorder_enabled = $this->getVar("audio_recorder_enabled");
$id =				$t_object->get('ca_objects.object_id');
$access_values = $this->getVar("access_values");
$options = $this->getVar('config_options');
$rep_ids = $t_object->get('ca_object_representations.representation_id', array('filterNonPrimaryRepresentations' => false, 'checkAccess' => $access_values, 'returnAsArray' => true));
$audio_recorder_attributes = $audio_recorder_enabled ? ($options["audio_recorder"]["attributes"] ?? []) : [];
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
			<div class='col-sm-6 col-md-6 col-lg-6'>

<?php if ($this->request->isLoggedIn() && $this->request->user->canDoAction('can_add_audio_commentary') && $this->getVar("audio_recorder_enabled")): ?>
				<div class="audio-recorder" id="audio-recorder">
					<div class="text-center">
						<h4>Record Audio</h4>
					</div>
					<p class="">Click record to contribute audio commentary for this record.</p>
					<div class="text-center">						
						<div class="control-bar btn-group">
							<button id="startBtn" class="btn">
								<span class="glyphicon glyphicon-play" aria-hidden="true"></span> Record
							</button>
							<button id="pauseBtn" class="btn" disabled>
								<span class="glyphicon glyphicon-pause" aria-hidden="true"></span> Pause
							</button>
							<button id="stopBtn" class="btn" disabled>
								<span class="glyphicon glyphicon-stop" aria-hidden="true"></span> Finish
							</button>
							<button id="downloadBtn" class="btn hidden">
								<span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download
							</button>
						</div>

						<canvas id="visualizer" width="300" height="50" class="center-block hidden"></canvas><br>
						
						<div id="postRecordingContainer" class="hidden">
							<div id="audioPreviewContainer" class="form-group">
								<label for="audioPlayback">
									<span class="glyphicon glyphicon-headphones" aria-hidden="true"></span> Audio Preview
								</label>
								<audio id="audioPlayback" controls></audio>
							</div>

							<form id="audioRecorder">
								<div id="termsError" class="alert alert-danger" style="display:none;">Please accept the consent for use</div>
								<div class="form-group">
									<label for="audioTitle" class="text-left">Title:</label>
									<input type="text" id="audioTitle" name="title" class="form-control" placeholder="Enter a title for the recording">
								</div>
<?php
							if(is_array($audio_recorder_attributes) && sizeof($audio_recorder_attributes)){
								foreach($audio_recorder_attributes as $audio_recorder_attribute => $attribute_info){
?>
									<div class="form-group">
										<label for="audio<?= $audio_recorder_attribute; ?>" class="text-left"><?= $attribute_info["label"]; ?>:</label>
<?php
										switch($attribute_info["type"]){
											# -------------------------------
											case "textarea":
												print "<textarea id='{$audio_recorder_attribute}' name='{$audio_recorder_attribute}' class='form-control' rows='3' placeholder='{$attribute_info['description']}'></textarea>";
												break;
											# -------------------------------
											default:
												print "<input type='text' id='{$audio_recorder_attribute}' name='{$audio_recorder_attribute}' class='form-control' placeholder='{$attribute_info['description']}'>";
												break;
											# -------------------------------
										}
?>										
									</div>
<?php									
								}
							}
							if($options["audio_recorder"]["require_consent"]){
?>
								<div class="form-group">
									<input type="checkbox" id="consent" name="consent" value="1"> I consent to my contribution being used on the Chesapeake Heartland website.
								</div>
								<div id="consentError" class="alert alert-danger" style="display:none;">Please consent to the terms of use</div>
								<script type='text/javascript'>
									$(document).ready(function() {
										$('#audioRecorder').submit(function(e) {
											if ($('#audioRecorder').find('input[name="consent"]')[0].checked === false) {
												e.preventDefault();
												$('#consentError').fadeIn(800);
												return false;
											}
										});
									});
								</script>
<?php
							}
?>								
								<div id="actionButtons" class="form-group text-center">
									<button id="cancelBtn" type="button" class="btn">
										<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel
									</button>
									<button id="saveBtn" type="button" class="btn">
										<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Save
									</button>
								</div>
							</form>
						</div>

						<div id="successMessage" class="alert alert-success hidden" role="alert">
							<strong>Success!</strong> Your recording has been submitted.
						</div>
						<div id="errorMessage" class="alert alert-danger hidden" role="alert">
							<strong>Error!</strong> Your recording has not been submitted.
						</div>
					</div>
				</div><br><br>
<?php endif; ?>


				{{{representationViewer}}}
				
<?php
				if((strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))) == "sound") && (is_array($rep_ids)) && (sizeof($rep_ids) > 2)){
					print "<div class='unit'><label>Play List</label>";
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array_merge($options, array("returnAs" => "list", "linkTo" => "carousel", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)));
					print "</div>";
				}else{
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array_merge($options, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)));
				}
?>
				<div id="detailAnnotations"></div>
				{{{<ifcount code="ca_objects.related" min="1"><div class="unit"><label>Related Object<ifcount code="ca_objects.related" min="2">s</ifcount></label><unit relativeTo="ca_objects.related" delimiter="<br/>"><div class="row"><div class="col-xs-2 col-sm-2"><l>^ca_object_representations.media.iconlarge</l></div><div class="col-xs-10 col-sm-10"><l>^ca_objects.preferred_labels</l></div></div></unit></div></ifcount>}}}
<?php
				# Comment and Share Tools
				if ($comments_enabled | $share_enabled | $pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?= _t("Comments and tags"); ?>"></span>Comments and Tags (<?= sizeof($comments) + sizeof($tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?= $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Inquire About This Item", "", "", "Contact", "Form", array("contactType" => "inquire", "table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Request Takedown", "", "", "Contact", "Form", array("contactType" => "takedown", "table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
					
					if ($share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR></HR>

				{{{<ifdef code="ca_objects.idno"><label>Identifier</label>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.object_category"><label>Category</label>^ca_objects.object_category<br/></ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Creator"><div class="unit"><label>Creator<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="Creator">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="Creator" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.description">
						<label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="partnering_organization"><div class="unit"><label>Partnering Organization<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="partnering_organization">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="partnering_organization" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.date_created"><label>Date Created</label>^ca_objects.date_created<br/></ifdef>}}}
				
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Source"><div class="unit"><label>Source<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="Source">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="Source" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="partnering_organization,Source,Creator,Subject"><div class="unit"><label>Contributor<ifcount code="ca_entities" min="2" excludeRelationshipTypes="partnering_organization,Source,Subject">s</ifcount></label><unit relativeTo="ca_entities" excludeRelationshipTypes="partnering_organization,Source,Subject" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.idno|ca_objects.object_category|ca_objects.language|ca_objects.date_digitized"><hr></hr></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><label>Language</label>^ca_objects.language%delimiter=,_<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.aat"><label>Original Object Format</label>^ca_objects.aat%delimiter=,_<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.keywords"><label>Keywords</label>^ca_objects.keywords%delimiter=,_<br/></ifdef>}}}
<?php
				$LcshSubjects = $t_object->get("ca_objects.lcsh_terms", array("returnAsArray" => true));
				$LcshSubjects_processed = array();
				if(is_array($LcshSubjects) && sizeof($LcshSubjects)){
					foreach($LcshSubjects as $LcshSubjects){
						if($LcshSubjects && (strpos($LcshSubjects, " [") !== false)){
							$LcshSubjects = mb_substr($LcshSubjects, 0, strpos($LcshSubjects, " ["));
						}
						$LcshSubjects_processed[] = $LcshSubjects;
			
					}
					print "<label>Library of Congress Subject Headings</label>".join(", ", $LcshSubjects_processed);
				}
				
				$LcshNames = $t_object->get("ca_objects.lc_names", array("returnAsArray" => true));
				$LcshNames_processed = array();
				if(is_array($LcshNames) && sizeof($LcshNames)){
					foreach($LcshNames as $LcshNames){
						if($LcshNames && (strpos($LcshNames, " [") !== false)){
							$LcshNames = mb_substr($LcshNames, 0, strpos($LcshNames, " ["));
						}
						$LcshNames_processed[] = $LcshNames;
			
					}
					print "<label>Library of Congress Name Authority File</label>".join(", ", $LcshNames_processed);
				}
?>
				{{{<ifdef code="ca_objects.tgn"><label>Location</label>^ca_objects.tgn%delimiter=,_<br/></ifdef>}}}

<?php
				if($map = trim($this->getVar("map"))){
					print "<br/><div class='unit'>".$map."</div>";
				}
?>

				{{{<ifdef code="ca_objects.rights"><HR></HR><div class="unit">
					<ifdef code="ca_objects.rights.rightsText"><label>Rights</label>^ca_objects.rights.rightsText</ifdef>
					<ifdef code="ca_objects.rights.rightsHolder"><label>Rights Holder</label>^ca_objects.rights.rightsHolder<br/></ifdef>
				</div></ifdef>}}}
				
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->

	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->

</div><!-- end row -->

<script type='text/javascript'>
	caUI.initAudioRecorder({
		containerId: 'audio-recorder',	// wrapper around recorder
		itemId: <?= json_encode($id); ?>, // object id
		saveUrl: <?= json_encode(caNavUrl($this->request, '*', '*', '*', ['recorder' => 1])); ?>,  // endpoint
		uiAttributes: <?= json_encode($audio_recorder_attributes); ?>
	});
</script>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 125
		});
		if ($('.video-js')[0]){
			$(window).resize(function() {
				w = jQuery('.repViewerCont').width();
				h = Math.ceil(w * .7);
				jQuery('.video-js').attr('width', w).attr('height', h);
				jQuery('.video-js').width(w);
				jQuery('.video-js').height(h);
			});
		}
	});
</script>
