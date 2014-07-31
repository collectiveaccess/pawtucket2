<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$pn_representation_id = $this->getVar("representation_id");
	# --- media
	$va_audios = $t_object->representationsWithMimeType(array("audio/mpeg", "audio/x-aiff", "audio/x-wav", "audio/mp4"), array("checkAccess" => $this->getVar("access_values")));
	$t_rep = new ca_object_representations();
	$vn_audio_rep_id = "";
	$va_audio_rep = array();
	$va_audio_media_display_info = array();
	if(sizeof($va_audios)){
		# --- if a rep_id was passed use that instead of the primary rep
		if($pn_representation_id){
			$va_audio_rep = $va_audios[$pn_representation_id];
			unset($va_audios[$pn_representation_id]);
		}else{
			$va_audio_rep = array_shift($va_audios);
		}
		$vn_audio_rep_id = $va_audio_rep["representation_id"];
		$va_audio_media_display_info = caGetMediaDisplayInfo('detail', $va_audio_rep["mimetype"]);
	}
	$va_transcript = $t_object->representationsWithMimeType(array("application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation"), array("checkAccess" => $this->getVar("access_values")));
	# --- is there a transcript/ doc to show
	if(sizeof($va_transcript)){
		$va_transcript = array_shift($va_transcript);
		$vn_transcript_rep_id = $va_transcript["representation_id"];
		$va_doc_media_display_info = caGetMediaDisplayInfo('detail', $va_transcript["mimetype"]);
		$vs_transcript_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $vn_transcript_rep_id, 'overlay' => 1))."\"); return false;' title='"._t("Transcript")."'><span class='glyphicon glyphicon-file'></span></a>\n";
	}
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-6 col-lg-6'>
					<H1>{{{<unit relativeTo="ca_collections" delimiter="<br/>">^ca_collections.hierarchy.preferred_labels.name%returnAsLink=1%delimiter=_➔_</unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
					if($vn_audio_rep_id){
						$t_rep->load($vn_audio_rep_id);
						print $t_rep->getMediaTag("media", $va_audio_media_display_info["display_version"], $va_audio_media_display_info, array("id" => "caPlayer"));
					}
?>
					<div id="detailTools">						
						<div class="detailTool detailToolRight"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
						<div class="detailTool detailToolRight"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments' style="float:right; clear:right;">{{{itemComments}}}</div><!-- end itemComments -->
<?php
						print "<div class='detailTool'>";
						if(caObjectsDisplayDownloadLink($this->request) && ($vn_audio_rep_id)){
							# -- get version to download configured in media_display.conf
							$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
							$vs_download_version = $va_download_display_info['display_version'];
							print caNavLink($this->request, " <span class='glyphicon glyphicon-download-alt'></span>", '', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $t_object->get("object_id"), "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")))."&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						print $vs_transcript_link."</div>";
?>
					</div>
					<HR class="dark"/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12 col-md-6 col-lg-6'>
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="interviewer" delimiter=";"><H3>Interviewer:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="interviewee" delimiter=";"><H3>Interviewee:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<ifdef code="ca_objects.pbcoreDate.pbcoreDates_value"><H3>Date:</H3>^ca_objects.pbcoreDate.pbcoreDates_value<br/></ifdef>}}}
					{{{<ifcount code="ca_objects.LcshTopical" min="1" max="1"><H3>Subject Heading:</H3></ifcount>}}}
					{{{<ifcount code="ca_objects.LcshTopical" min="2"><H3>Subject Headings:</H3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_objects.LcshTopical</unit>}}}
					{{{<ifcount code="ca_objects.LcshNames" min="1" max="1"><H3>Term:</H3></ifcount>}}}
					{{{<ifcount code="ca_objects.LcshNames" min="2"><H3>Terms:</H3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}				
				</div><!-- end col -->
				<div class='col-sm-12 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_objects.pbcoreFormatLocation"><H3>Location:</H3>^ca_objects.pbcoreFormatLocation<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.idno"><H3>Identifier:</H3>^ca_objects.idno<br/></ifdef>}}}
					{{{<h3>MLA Citation:</h3><i>^ca_objects.preferred_labels.name</i>. <ifdef code="ca_objects.dateSet.setDisplayValue"><unit>^ca_objects.dateSet.setDisplayValue</unit>. </ifdef><ifcount code="ca_collections" min="1" max="1"><unit>^ca_collections.hierarchy.preferred_labels.name</unit>. </ifcount><i>New School Archives and Special Collections Digital Archive</i>. Web. ^DATE}}}
<?php
					if(sizeof($va_audios > 1)){
						foreach($va_audios as $va_audio){
							print "<H3>Additional Audio</H3>";
							print caDetailLink($this->request, '<span class="glyphicon glyphicon-volume-up"></span> '.$va_audio["label"], '', 'ca_objects', $t_object->get("object_id"), array("representation_id" => $va_audio["representation_id"]))."<br/>";
						}
					}
?>
				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
					{{{<ifdef code="ca_objects.pbcoreDescription.pBdescription_text"><HR class="dark"/><H3>Description</H3><br/>^ca_objects.pbcoreDescription.pBdescription_text<br/></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			
			
			
			
			
			
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
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