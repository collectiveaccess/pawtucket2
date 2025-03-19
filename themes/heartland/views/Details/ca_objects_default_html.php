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
$audio_recorder_enabled = $this->getVar("audio_recorder_enabled");
$vn_id =				$t_object->get('ca_objects.object_id');
$va_access_values = $this->getVar("access_values");
$va_options = $this->getVar('config_options');
$va_rep_ids = $t_object->get('ca_object_representations.representation_id', array('filterNonPrimaryRepresentations' => false, 'checkAccess' => $va_access_values, 'returnAsArray' => true));
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
				<div class="audio-recorder">
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

							<form class="form-horizontal">
								<div class="form-group">
									<label for="audioName" class="text-left">Name:</label>
									<input type="text" id="audioName" class="form-control" placeholder="Enter name">
								</div>

								<div class="form-group">
									<label for="audioNotes" class="text-left">Notes:</label>
									<textarea id="audioNotes" class="form-control" rows="3" placeholder="Enter notes"></textarea>
								</div>

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
				if((strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))) == "sound") && (is_array($va_rep_ids)) && (sizeof($va_rep_ids) > 2)){
					print "<div class='unit'><label>Play List</label>";
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array_merge($va_options, array("returnAs" => "list", "linkTo" => "carousel", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)));
					print "</div>";
				}else{
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array_merge($va_options, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)));
				}
?>
				<div id="detailAnnotations"></div>
				{{{<ifcount code="ca_objects.related" min="1"><div class="unit"><label>Related Object<ifcount code="ca_objects.related" min="2">s</ifcount></label><unit relativeTo="ca_objects.related" delimiter="<br/>"><div class="row"><div class="col-xs-2 col-sm-2"><l>^ca_object_representations.media.iconlarge</l></div><div class="col-xs-10 col-sm-10"><l>^ca_objects.preferred_labels</l></div></div></unit></div></ifcount>}}}
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
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Inquire About This Item", "", "", "Contact", "Form", array("contactType" => "inquire", "table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Request Takedown", "", "", "Contact", "Form", array("contactType" => "takedown", "table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
					
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
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
				$va_LcshSubjects = $t_object->get("ca_objects.lcsh_terms", array("returnAsArray" => true));
				$va_LcshSubjects_processed = array();
				if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
					foreach($va_LcshSubjects as $vs_LcshSubjects){
						if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
							$vs_LcshSubjects = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
						}
						$va_LcshSubjects_processed[] = $vs_LcshSubjects;
			
					}
					print "<label>Library of Congress Subject Headings</label>".join(", ", $va_LcshSubjects_processed);
				}
				
				$va_LcshNames = $t_object->get("ca_objects.lc_names", array("returnAsArray" => true));
				$va_LcshNames_processed = array();
				if(is_array($va_LcshNames) && sizeof($va_LcshNames)){
					foreach($va_LcshNames as $vs_LcshNames){
						if($vs_LcshNames && (strpos($vs_LcshNames, " [") !== false)){
							$vs_LcshNames = mb_substr($vs_LcshNames, 0, strpos($vs_LcshNames, " ["));
						}
						$va_LcshNames_processed[] = $vs_LcshNames;
			
					}
					print "<label>Library of Congress Name Authority File</label>".join(", ", $va_LcshNames_processed);
				}
?>
				{{{<ifdef code="ca_objects.tgn"><label>Location</label>^ca_objects.tgn%delimiter=,_<br/></ifdef>}}}

<?php
				if($vs_map = trim($this->getVar("map"))){
					print "<br/><div class='unit'>".$vs_map."</div>";
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
		vnId: <?php echo json_encode($vn_id); ?>, // object id
		saveUrl: <?= json_encode(caNavUrl($this->request, '*', '*', '*', ['recorder' => 1])); ?> // endpoint
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
