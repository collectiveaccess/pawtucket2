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
				
				<div id="detailAnnotations"></div>
				
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->		

			{{{<unit><ifdef code="ca_objects.idno"><div><span class='metaTitle'>Identifier</span><span class='meta'>^ca_objects.idno</span></div></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.workType"><div><span class='metaTitle'>Type: </span><span class='meta'><unit delimiter='; '>^ca_occurrences.workType</unit></span></div></ifdef></unit>}}}

		    {{{<ifdef code="ca_objects.essenceTrack.essenceTrackFrameRate|ca_objects.essenceTrack.recorder_model|ca_objects.essenceTrack.essenceTrackFrameSize|ca_objects.essenceTrack.ScanType|ca_objects.essenceTrack.essenceTrackAspectRatio|ca_objects.essenceTrack.essenceTrackDuration|ca_objects.technicalNotes|ca_objects.notes">
		    	<div>
		    		<span class='metaTitle'>Technical Specs</span>
		    		<div class='meta'>
		    			<unit>
		    				<p><ifdef code="ca_objects.essenceTrack.essenceTrackFrameRate">Frame Rate: ^ca_objects.essenceTrack.essenceTrackFrameRate</ifdef></p>
		    				<p><ifdef code="ca_objects.essenceTrack.essenceTrackFrameSize">Frame Size: ^ca_objects.essenceTrack.essenceTrackFrameSize</ifdef></p>
		    				<p><ifdef code="ca_objects.essenceTrack.ScanType">Scan Type: ^ca_objects.essenceTrack.ScanType</ifdef></p>
		    				<p><ifdef code="ca_objects.essenceTrack.essenceTrackAspectRatio">Aspect Ratio: ^ca_objects.essenceTrack.essenceTrackAspectRatio</ifdef></p>
		    				<p><ifdef code="ca_objects.essenceTrack.essenceTrackDuration">Duration: ^ca_objects.essenceTrack.essenceTrackDuration</ifdef></p>
		    				<p><ifdef code="ca_objects.recorder_model">Recorder Model: ^ca_objects.recorder_model</ifdef></p> 
							<p><ifdef code="ca_objects.technicalNotes">Technical Notes: ^ca_objects.technicalNotes</ifdef></p>
							<p><ifdef code="ca_objects.technicalNotes">Technical Notes: ^ca_objects.notes</ifdef></p>
		    			</unit> 
		    		</div>
		    	</div> 
		    </ifdef>}}}
<?php

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
			if (($vs_val = trim($t_object->get('ca_objects.item_format_digital', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
				print "<div><span class='metaTitle'>Master Format</span><span class='meta'>{$vs_val}</span></div>";
			}							
?>

				{{{<unit><ifdef code="ca_objects.color"><div><span class='metaTitle'>Color: </span><span class='meta'><unit delimiter='; '>^ca_objects.color</unit></span></div></ifdef></unit>}}}

					
			</div><!-- end col -->
			<div class='col-md-6 col-lg-6 metadata'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<!--<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>-->
				<HR>
				
			

<?php
	if (is_array($va_occurrence_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $this->getVar('access_values')))) && sizeof($va_occurrence_ids)) {
		$qr_occ = caMakeSearchResult('ca_occurrences', $va_occurrence_ids);
		$vs_date = '';
		while($qr_occ->nextHit()) {
			$va_dates = $qr_occ->get('ca_occurrences.workDate', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true));
			
			foreach($va_dates as $vn_attr_id => $va_date_t) {
				foreach ($va_date_t as $vn_att => $va_date) {
					if (!$va_date['dates_value']) { continue; }
					$vs_date .= $va_date['dates_value']." (".$va_date['work_dates_types'].")<br/>";
				}
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
			{{{<ifdef relativeTo="ca_occurrences" code="ca_occurrences.locationText" ><span class='metaTitle'>Location</span><span class='meta'><unit relativeTo="ca_occurrences">^ca_occurrences.locationText</unit></span></ifdef>}}}
			{{{<ifdef relativeTo="ca_occurrences" code="ca_occurrences.legacyLocation" ><span class='metaTitle'>Location</span><span class='meta'><unit relativeTo="ca_occurrences">^ca_occurrences.legacyLocation</unit></span></ifdef>}}}
<?php
			if ($va_rel_works = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true))) {
				$va_places = array();
				foreach ($va_rel_works as $va_key => $va_occurrence_id) {
					$t_occurrence = new ca_occurrences($va_occurrence_id);
					if ($vs_places = $t_occurrence->get('ca_places.preferred_labels')) {
						$va_places[] = $vs_places;
					}
				}
				
				if(sizeof($va_places)) {
					print "<span class='metaTitle'>SI Locations</span>";
					print "<div class='meta'>";
					print join("; ", $va_places);
					print "</div>";
				}
			}
				
			if ($qr_occ) {
				$qr_occ->seek(0);
				while($qr_occ->nextHit()) {
					if (is_array($va_contributors = $qr_occ->get('ca_entities', array('returnWithStructure' => true, 'restrictToRelationshipTypes' => array('subject', 'interviewee'), 'checkAccess' => caGetUserAccessValues($this->request)))) && sizeof($va_contributors)) {
						print "<div><span class='metaTitle'>Subjects</span><div class='meta'>";
						foreach ($va_contributors as $cont_key => $va_contributor) {
							print "<div>".caNavLink($this->request, $va_contributor['displayname']." (".$va_contributor['relationship_typename'].")", '' , 'Detail', 'entities', $va_contributor['entity_id'])."</div>";
						}
						print "</div></div>";
					}
				}
			}

?>	
			{{{<ifdef  code="ca_occurrences.restrictions|ca_occurrences.rights|ca_occurrences.sniDepiction|ca_entities.preferred_labels"><hr><h5>Rights & Permissions</h5></ifdef>}}}
			{{{<unit><ifdef code="ca_occurrences.restrictions"><div><span class='metaTitle'>Restrictions</span><span class='meta'>^ca_occurrences.restrictions</span></div></ifdef></unit>}}}
			{{{<ifdef code="ca_occurrences.rights"><div><span class='metaTitle'>Rights Note</span><span class='meta'><unit>^ca_occurrences.rights</unit></span></div></ifdef>}}}
<?php

			if ($qr_occ) {
				$qr_occ->seek(0);
				while($qr_occ->nextHit()) {
					if (is_array($va_contributors = $qr_occ->get('ca_entities', array('excludeRelationshipTypes' => array('subject', 'interviewee'), 'returnWithStructure' => true, 'checkAccess' => caGetUserAccessValues($this->request)))) && sizeof($va_contributors)) {
						print "<div><span class='metaTitle'>Contributors</span><div class='meta'>";
						foreach ($va_contributors as $cont_key => $va_contributor) {
							print "<div>".caNavLink($this->request, $va_contributor['displayname']." (".$va_contributor['relationship_typename'].")", '' , 'Detail', 'entities', $va_contributor['entity_id'])."</div>";
						}
						print "</div></div>";
					}	
					if (is_array($va_proposers = $qr_occ->get('ca_entities', array('restrictToRelationshipTypes' => array('proposed'), 'returnWithStructure' => true, 'checkAccess' => caGetUserAccessValues($this->request)))) && sizeof($va_proposers)) {
						print "<div><span class='metaTitle'>Proposed by</span><div class='meta'>";
						foreach ($va_proposers as $cont_key => $va_proposer) {
							print "<div>".caNavLink($this->request, $va_proposer['displayname'], '' , 'Detail', 'entities', $va_proposer['entity_id'])."</div>";
						}
						print "</div></div>";
					}	
				}
			}
			
?>
			{{{<ifdef code="ca_occurrences.genre|ca_occurrences.productionTypes|ca_occurrences.mission.missionCritical|ca_occurrences.awards.award_event|ca_occurrences.distribution_status.distribution_date" ><hr><h5>Program Info</h5></ifdef>}}}

			{{{<ifdef code="ca_occurrences.distribution_status.distribution_date" min="1"><span class='metaTitle'>Distribution Status</span></ifdef>}}}
			{{{<ifdef code="ca_occurrences.distribution_status.distribution_date" ><span class='meta'><unit delimiter="<br/>"><div>^ca_occurrences.distribution_status.distribution_list, Expires ^ca_occurrences.distribution_status.distribution_date</div></unit></span></ifdef>}}}									

<?php
			if ((strlen($vs_prod_type = $t_object->get('ca_occurrences.productionTypes', array('convertCodesToDisplayText' => true)))) > 1) {
				print "<div><span class='metaTitle'>Production type</span><div class='meta'>{$vs_prod_type}</div></div>"; 
			}
			if ((strlen($vs_genre = $t_object->get('ca_occurrences.genre', array('convertCodesToDisplayText' => true)))) > 1) {
				print "<div><span class='metaTitle'>Genre</span><div class='meta'>{$vs_genre}</div></div>";
			}	

			if (($vs_mission_crit = $t_object->get('ca_occurrences.mission.missionCritical', array('convertCodesToDisplayText' => true))) == "Yes") {
				print "<div><span class='metaTitle'>Mission critical</span><span class='meta'><div>Mission Critical: {$vs_mission_crit}</div>";
				print "<div>Year: ".$t_object->get('ca_occurrences.mission.missionYear')." (".$t_object->get('ca_occurrences.mission.mission_dates_types').")</div>";
				print "</span></div>";
			}
			
	
			if ($qr_occ) {
				while($qr_occ->nextHit()) {
					$va_awards = $qr_occ->get('ca_occurrences.awards', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true, 'showHierarchy' => true));
					if (sizeof($va_awards) > 0) {
						print "<div><span class='metaTitle'>Awards</span><span class='meta'>";
						foreach ($va_awards as $award => $va_award_t) {
							foreach ($va_award_t as $va_award_key => $va_award) {
								if ($va_award['award_event']) {
									#array_shift($va_award['award_event']);
									$va_award_name = explode('➔', $va_award['award_event']);
									print "<div>".$va_award_name[0]."</div>";
								}									
								print "<div style='height:10px;'></div>";
							}
						}
						print "</span></div>";
					}
				}
			}
			
						
?>				


<?php
			if ($va_lcsh_names = $t_object->get('ca_objects.lcsh_names', array('returnWithStructure' => true))) {
				print "<span class='metaTitle'>LCSH Names</span>";
				print "<div class='meta'>";
				foreach ($va_lcsh_names as $va_key => $va_lcsh_name) {
					$va_name = explode('[', $va_lcsh_name['lcsh_names']);
					print $va_name[0]."<br/>";
				}
				print "</div>";
			}
			if ($va_lcsh_subjects = $t_object->get('ca_objects.lcsh_subjects', array('returnWithStructure' => true))) {
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