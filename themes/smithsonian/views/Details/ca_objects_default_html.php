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
			</div><!-- end col -->
			<div class='col-md-6 col-lg-6 metadata'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<!--<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>-->
				<HR>
<?php
				//if ($t_object->get('ca_objects.generation_video', array('excludeValues' => array('not_specified'))) != "") {
				//	print "<div><span class='metaTitle'>Generation</span><span class='meta'>".$t_object->get('ca_objects.generation_video', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				//}	
				//if ($t_object->get('ca_objects.generation_supporting', array('excludeValues' => array('not_specified'))) != "") {
				//	print "<div><span class='metaTitle'>Generation</span><span class='meta'>".$t_object->get('ca_objects.generation_supporting', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				//}					
?>				
				<!--{{{<unit><ifdef code="ca_objects.supporting_type"><div><span class='metaTitle'>Type</span><span class='meta'>^ca_objects.supporting_type</span></ifdef></div></unit>}}}-->
				{{{<unit><ifdef code="ca_objects.idno"><div><span class='metaTitle'>Identifer</span><span class='meta'>^ca_objects.idno</span></div></ifdef></unit>}}}

<?php
			if ($t_object->get('ca_occurrences.workType', array('excludeValues' => array('null'))) != "") {
				print " <div><span class='metaTitle'>Type:</span> ".$t_object->get('ca_occurrences.workType', array('convertCodesToDisplayText' => true, 'excludeValues' => array('null')))."</div>";
			}	
?>			
			{{{<ifcount min="1" code="ca_occurrences.workDate.dates_value" ><div><span class='metaTitle'>Date:</span> <unit delimiter=", ">^ca_occurrences.workDate.dates_value <ifcount min="1" code="ca_occurrences.workDate.work_dates_types">(^ca_occurrences.workDate.work_dates_types)</ifdef></unit></div></ifcount>}}}
			{{{<ifcount code="ca_occurrences.description" min="1"><span class='metaTitle'>Description</span><span class='meta'>^ca_occurrences.description</span></ifcount>}}}
			{{{<ifcount code="ca_occurrences.locationText" min="1"><span class='metaTitle'>Location</span><span class='meta'>^ca_occurrences.locationText</span></ifcount>}}}

			{{{<unit relativeTo="ca_occurrences"><ifcount code="ca_entities.related" min="1" max="1"><span class='metaTitle'>Related person</span></ifcount></unit>}}}
			{{{<unit relativeTo="ca_occurrences"><ifcount code="ca_entities.related" min="2"><span class="metaTitle">Related people</span></ifcount></unit>}}}
			{{{<unit relativeTo="ca_occurrences"><ifcount code="ca_entities.related" min="1"><div class='meta'><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit></div></ifcount></unit>}}}					
			
			
			{{{<ifcount min="1" code="ca_occurrences.restrictions|ca_occurrences.rights|ca_occurrences.sniDepiction|ca_entities.preferred_labels"><hr><h5>Rights & Permissions</h5></ifcount>}}}
			{{{<unit><ifdef code="ca_occurrences.restrictions"><div><span class='metaTitle'>Restrictions</span><span class='meta'>^ca_occurrences.restrictions</span></div></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.rights"><div><span class='metaTitle'>Rights</span><span class='meta'>^ca_occurrences.rights</span></div></ifdef></unit>}}}

<?php
			if (is_array($va_occurrence_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true)))) {
				$qr_occ = caMakeSearchResult('ca_occurrences', $va_occurrence_ids);
				
				while($qr_occ->nextHit()) {
					if ($va_contributors = $qr_occ->get('ca_entities', array('excludeRelationshipTypes' => array('subject, interviewee'), 'returnAsArray' => true))) {
						print "<div><span class='metaTitle'>Contributors</span><div class='meta'>";
						foreach ($va_contributors as $cont_key => $va_contributor) {
							print "<div>".caNavLink($this->request, $va_contributor['displayname']." (".$va_contributor['relationship_typename'].")", '' , 'Detail', 'entities', $va_contributor['entity_id'])."</div>";
						}
						print "</div></div>";
					}	
				}
			}
?>
			{{{<ifcount code="ca_occurrences.workDate.dates_value|ca_occurrences.genre|ca_occurrences.productionTypes|ca_occurrences.mission.missionCritical|ca_occurrences.awards.award_event|ca_occurrences.distribution_status.distribution_date" min="1"><hr><h5>Program Info</h5></ifcount>}}}

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
			
			$va_awards = $t_object->get('ca_occurrences.awards', array('convertCodesToDisplayText' => true, 'returnAsArray' => true));
			if (sizeof($va_awards) > 0) {
				print "<div><span class='metaTitle'>Awards</span><div class='meta'>";
				foreach ($va_awards as $award => $va_award) {
					print "<div>Award: ".$va_award['award_event']."</div>";
					print "<div>Year: ".$va_award['award_year']."</div>";
					print "<div>Type: ".$va_award['award_types']."</div>";
					print "<div>Notes: ".$va_award['award_notes']."</div>";
					print "<div style='height:10px;'></div>";
				}
				print "</div></div>";
			}
?>

		<!--	{{{<ifcount min="1" code="ca_storage_locations.preferred_labels"><div><span class='metaTitle'>Storage Location</span><span class='meta'><unit>^ca_storage_locations.preferred_labels<br/></unit></span></div></ifcount>}}}-->
<?php
				if (($vs_val = trim($t_object->get('ca_objects.video_physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
					print "<div class='meta'><span class='metaTitle'>Master Format</span><div class='meta'>{$vs_val}</div></div>";
				}
				if (($vs_val = trim($t_object->get('ca_objects.physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
					print "<div class='meta'><span class='metaTitle'>Master Format</span><div class='meta'>{$vs_val}</div></div>";
				}
				if (($vs_val = trim($t_object->get('ca_objects.digital_moving_image', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
					print "<div class='meta'><span class='metaTitle'>Master Format</span><div class='meta'>{$vs_val}</div></div>";
				}
				if (($vs_val = trim($t_object->get('ca_objects.digital_supporting', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified'))))) != "") {
					print "<div class='meta'><span class='metaTitle'>Master Format</span><div class='meta'>{$vs_val}</div></div>";
				}
				//if ($t_object->get('ca_objects.carrier', array('excludeValues' => array('not_specified'))) != "") {
				//	print "<div><span class='metaTitle'>Carrier</span><span class='meta'>".$t_object->get('ca_objects.carrier', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				//}								
?>				
				
			<!--	{{{<unit><ifdef code="ca_objects.date"><div><span class='metaTitle'>Date</span><span class='meta'>^ca_objects.date</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.description"><div><span class='metaTitle'>Description</span><span class='meta'>^ca_objects.description</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.notes"><div><span class='metaTitle'>Notes</span><span class='meta'>^ca_objects.notes</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.technicalNotes"><div><span class='metaTitle'>Technical Notes</span><span class='meta'>^ca_objects.technicalNotes</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.rights"><div><span class='metaTitle'>Rights</span><span class='meta'>^ca_objects.rights</span></div></ifdef></unit>}}}
			-->	{{{<ifdef code="ca_objects.essenceTrack"><div><span class='metaTitle'>Technical Specs</span><div class='meta'><unit>
						<p>Type: ^ca_objects.essenceTrack.essenceTrackType</p>
						<p>Frame Rate: ^ca_objects.essenceTrack.essenceTrackFrameRate</p>
						<p>Frame Size: ^ca_objects.essenceTrack.essenceTrackFrameSize</p>
						<p>Scan Type: ^ca_objects.essenceTrack.ScanType</p>
						<p>Standard: ^ca_objects.essenceTrack.essenceTrackStandard</p>
						<p>Aspect Ratio: ^ca_objects.essenceTrack.essenceTrackAspectRatio</p>
						<p>Duration: ^ca_objects.essenceTrack.essenceTrackDuration</p>
					</unit></div></div></ifdef>}}}
		<!--		{{{<unit><ifdef code="ca_objects.alt_modes"><div><span class='metaTitle'>Alternative Modes</span><span class='meta'>^ca_objects.alt_modes</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.color"><div><span class='metaTitle'>Color</span><span class='meta'>^ca_objects.color</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.object_log"><div><span class='metaTitle'>Log</span><span class='meta'>^ca_objects.object_log</span></div></ifdef></unit>}}}
-->
	
				{{{<ifcount code="ca_occurrences" min="1" max="1"><span class='metaTitle'>Related Work</span></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><span class="metaTitle">Related Works</span></ifcount>}}}
				{{{<div class='meta'><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.displayname</l></unit></div>}}}				
				
				{{{<ifcount code="ca_objects.related" min="1" max="1"><span class='metaTitle'>Related Object</span></ifcount>}}}
				{{{<ifcount code="ca_objects.related" min="2"><span class="metaTitle">Related Objects</span></ifcount>}}}
				{{{<div class='meta'><unit relativeTo="ca_objects" delimiter="<br/>"><l>^ca_objects.related.preferred_labels.displayname</l></unit></div>}}}					
				

				
				{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
				{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->