<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-md-6 col-lg-6'>
				{{{representationViewer}}}
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->		
				
			</div><!-- end col -->
			<div class='col-md-6 col-lg-6 metadata'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<!--<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>-->
				<HR>
<?php				
?>				
			{{{<unit><ifdef code="ca_objects.idno"><div><span class='metaTitle'>Identifer</span><span class='meta'>^ca_objects.idno</span></div></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.workType"><div><span class='metaTitle'>Type: </span><span class='meta'><unit delimiter='; '>^ca_occurrences.workType</unit></span></div></ifdef></unit>}}}

<?php
	if (is_array($va_occurrence_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true))) && sizeof($va_occurrence_ids)) {
		$qr_occ = caMakeSearchResult('ca_occurrences', $va_occurrence_ids);
		
		$vs_date = '';
		while($qr_occ->nextHit()) {
			$va_dates = $qr_occ->get('ca_occurrences.workDate', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
			
			foreach($va_dates as $vn_attr_id => $va_date) {
				if (!$va_date['dates_value']) { continue(2); }
				$vs_date .= $va_date['dates_value']." (".$va_date['work_dates_types'].")<br/>";
			}
		}
		
		if ($vs_date) {
?>
		<div>
			<span class='metaTitle'>Date:</span> 
<?php
			print $vs_date;
?>
		</div>
<?php
		}
	}
?>
			
			{{{<ifcount code="ca_occurrences.description" min="1"><span class='metaTitle'>Description</span><span class='meta'><unit>^ca_occurrences.description</unit></span></ifcount>}}}
			{{{<ifcount relativeTo="ca_occurrences" code="ca_occurrences.locationText" min="1"><span class='metaTitle'>Location</span><span class='meta'><unit relativeTo="ca_occurrences">^ca_occurrences.locationText</unit></span></ifcount>}}}
			{{{<ifcount relativeTo="ca_occurrences" code="ca_occurrences.legacyLocation" min="1"><span class='metaTitle'>Location (legacy text)</span><span class='meta'><unit relativeTo="ca_occurrences">^ca_occurrences.legacyLocation</unit></span></ifcount>}}}
<?php
			if ($va_rel_works = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true))) {
				print "<span class='metaTitle'>Related places</span>";
				print "<div class='meta'>";
				foreach ($va_rel_works as $va_key => $va_occurrence_id) {
					$t_occurrence = new ca_occurrences($va_occurrence_id);
					print $t_occurrence->get('ca_places.preferred_labels');
				}
				print "</div>";
			}

			if (is_array($va_occurrence_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true)))) {
				$qr_occ = caMakeSearchResult('ca_occurrences', $va_occurrence_ids);
			
				while($qr_occ->nextHit()) {
					if (is_array($va_contributors = $qr_occ->get('ca_entities', array('restrictToRelationshipTypes' => array('subject', 'interviewee'), 'returnAsArray' => true, 'checkAccess' => caGetUserAccessValues($this->request)))) && sizeof($va_contributors)) {
						print "<div><span class='metaTitle'>Subjects</span><div class='meta'>";
						foreach ($va_contributors as $cont_key => $va_contributor) {
							print "<div>".caNavLink($this->request, $va_contributor['displayname']." (".$va_contributor['relationship_typename'].")", '' , 'Detail', 'entities', $va_contributor['entity_id'])."</div>";
						}
						print "</div></div>";
					}
				}
			}
?>
			
			{{{<ifcount min="1" code="ca_occurrences.restrictions|ca_occurrences.rights|ca_occurrences.sniDepiction|ca_entities.preferred_labels"><hr><h5>Rights & Permissions</h5></ifcount>}}}
			{{{<unit><ifdef code="ca_occurrences.restrictions"><div><span class='metaTitle'>Restrictions</span><span class='meta'>^ca_occurrences.restrictions</span></div></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.rights"><div><span class='metaTitle'>Rights</span><span class='meta'>^ca_occurrences.rights</span></div></ifdef></unit>}}}

<?php
			if (is_array($va_occurrence_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true)))) {
				$qr_occ = caMakeSearchResult('ca_occurrences', $va_occurrence_ids);
				
				while($qr_occ->nextHit()) {
					if (is_array($va_contributors = $qr_occ->get('ca_entities', array('excludeRelationshipTypes' => array('subject', 'interviewee'), 'returnAsArray' => true, 'checkAccess' => caGetUserAccessValues($this->request)))) && sizeof($va_contributors)) {
						print "<div><span class='metaTitle'>Contributors</span><div class='meta'>";
						foreach ($va_contributors as $cont_key => $va_contributor) {
							print "<div>".caNavLink($this->request, $va_contributor['displayname']." (".$va_contributor['relationship_typename'].")", '' , 'Detail', 'entities', $va_contributor['entity_id'])."</div>";
						}
						print "</div></div>";
					}	
					if (is_array($va_proposers = $qr_occ->get('ca_entities', array('restrictToRelationshipTypes' => array('proposed'), 'returnAsArray' => true, 'checkAccess' => caGetUserAccessValues($this->request)))) && sizeof($va_proposers)) {
						print "<div><span class='metaTitle'>Proposed by</span><div class='meta'>";
						foreach ($va_proposers as $cont_key => $va_proposer) {
							print "<div>".caNavLink($this->request, $va_proposer['displayname'], '' , 'Detail', 'entities', $va_proposer['entity_id'])."</div>";
						}
						print "</div></div>";
					}	
				}
			}
?>
			{{{<ifcount code="ca_occurrences.workDate.dates_value|ca_occurrences.genre|ca_occurrences.productionTypes|ca_occurrences.mission.missionCritical|ca_occurrences.awards.award_event|ca_occurrences.distribution_status.distribution_date" min="1"><hr><h5>Program Info</h5></ifcount>}}}

			{{{<ifcount code="ca_occurrences.distribution_status.distribution_date" min="1"><span class='metaTitle'>Distribution Status</span></ifcount>}}}
			{{{<ifcount code="ca_occurrences.distribution_status.distribution_date" min="1"><span class='meta'><unit delimiter="<br/>"><div>^ca_occurrences.distribution_status.distribution_list, Expires ^ca_occurrences.distribution_status.distribution_date</div></unit></span></ifcount>}}}									

<?php
			if (($vs_genre = $t_object->get('ca_occurrences.genre', array('convertCodesToDisplayText' => true))) != "") {
				print "<div><span class='metaTitle'>Genre</span><div class='meta'>{$vs_genre}</div></div>";
			}	
			if (($vs_prod_type = $t_object->get('ca_occurrences.productionTypes', array('convertCodesToDisplayText' => true))) != "") {
				print "<div><span class='metaTitle'>Production type</span><div class='meta'>{$vs_prod_type}</div></div>";
			}
			if (($vs_mission_crit = $t_object->get('ca_occurrences.mission.missionCritical', array('convertCodesToDisplayText' => true))) == "Yes") {
				print "<div><span class='metaTitle'>Mission critical</span><span class='meta'><div>Mission Critical: {$vs_mission_crit}</div>";
				print "<div>Year: ".$t_object->get('ca_occurrences.mission.missionYear')." (".$t_object->get('ca_occurrences.mission.mission_dates_types').")</div>";
				print "</span></div>";
			}
			
			$va_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true));
	
			if (sizeof($va_ids) > 0) {
				$qr_res = caMakeSearchResult('ca_occurrences', $va_ids);
			
				$va_awards = $qr_res->get('ca_occurrences.awards', array('returnAsArray' => true, 'convertCodesToDisplayText' => true, 'showHierarchy' => true));
				if (sizeof($va_awards) > 0) {
					print "<div><span class='metaTitle'>Awards</span><span class='meta'>";
					foreach ($va_awards as $award => $va_award) {
						if ($va_award['award_event']) {
							array_shift($va_award['award_event']);
							print "<div>Award: ".join(' > ', $va_award['award_event'])."</div>";
						}
						if ($va_award['award_year']) {
							print "<div>Award Year: ".$va_award['award_year']."</div>";
						}
						if ($va_award['award_types'][0] != "Root node for award_types") {
							print "<div>Award Type: ".$va_award['award_types'][0]."</div>";
						}
						if ($va_award['award_notes']) {
							print "<div>Award Notes: ".$va_award['award_notes']."</div>";
						}										
						print "<div style='height:10px;'></div>";
					}
					print "</span></div>";
				}
			}
			
			if (($vs_val = trim($t_object->get('ca_objects.video_physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
				print "<div><span class='metaTitle'>Master Format</span><span class='meta'>{$vs_val}</span></div>";
			}
			if (($vs_val = trim($t_object->get('ca_objects.physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
				print "<div><span class='metaTitle'>Master Format</span><span class='meta'>{$vs_val}</span></div>";
			}
			if (($vs_val = trim($t_object->get('ca_objects.digital_moving_image', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
				print "<div><span class='metaTitle'>Master Format</span><span class='meta'>{$vs_val}</span></div>";
			}
			if (($vs_val = trim($t_object->get('ca_objects.digital_supporting', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
				print "<div><span class='metaTitle'>Master Format</span><span class='meta'>{$vs_val}</span></div>";
			}				
?>				
	
				{{{<ifcount code='ca_objects.essenceTrack' min='1'><div><span class='metaTitle'>Technical Specs</span><div class='meta'><unit><p>Type: ^ca_objects.essenceTrack.essenceTrackType</p><p>Frame Rate: ^ca_objects.essenceTrack.essenceTrackFrameRate</p><p>Frame Size: ^ca_objects.essenceTrack.essenceTrackFrameSize</p><p>Scan Type: ^ca_objects.essenceTrack.ScanType</p><p>Standard: ^ca_objects.essenceTrack.essenceTrackStandard</p><p>Aspect Ratio: ^ca_objects.essenceTrack.essenceTrackAspectRatio</p><p>Duration: ^ca_objects.essenceTrack.essenceTrackDuration</p></unit></div></div></ifcount>}}}
				{{{<unit><ifdef code="ca_objects.recorder_model"><div><span class='metaTitle'>Recorder Model: </span><span class='meta'><unit delimiter='; '>^ca_objects.recorder_model</unit></span></div></ifdef></unit>}}}

<?php
			if ($va_lcsh_names = $t_object->get('ca_objects.lcsh_names', array('returnAsArray' => true))) {
				print "<span class='metaTitle'>LCSH Names</span>";
				print "<div class='meta'>";
				foreach ($va_lcsh_names as $va_key => $va_lcsh_name) {
					$va_name = explode('[', $va_lcsh_name['lcsh_names']);
					print $va_name[0]."<br/>";
				}
				print "</div>";
			}
			if ($va_lcsh_subjects = $t_object->get('ca_objects.lcsh_subjects', array('returnAsArray' => true))) {
				print "<span class='metaTitle'>LCSH Subjects</span>";
				print "<div class='meta'>";
				foreach ($va_lcsh_subjects as $va_key => $va_lcsh_subject) {
					$va_lcsh = explode('[', $va_lcsh_subject['lcsh_subjects']);
					print $va_lcsh[0]."<br/>";
				}
				print "</div>";
			}
?>	

			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->