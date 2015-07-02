<?php
	$t_occurrence = $this->getVar("item");

	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row"><div class='col-md-12 col-lg-12'>
			<H4>{{{^ca_occurrences.preferred_labels}}}</H4>
			{{{<unit><ifdef code="ca_occurrences.nonpreferred_labels"><p>^ca_occurrences.nonpreferred_labels.displayname</p></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.idno"><p>ID: ^ca_occurrences.idno</p></ifdef></unit>}}}
<?php
			if ($t_occurrence->get('ca_occurrences.workType', array('excludeValues' => array('null'))) != "") {
				print "<p>Type: ".$t_occurrence->get('ca_occurrences.workType', array('convertCodesToDisplayText' => true, 'excludeValues' => array('null')))."</p>";
			}	
?>	
			{{{<ifcount min="1" code="ca_occurrences.workDate.dates_value" ><p>Date: <unit delimiter=", ">^ca_occurrences.workDate.dates_value <ifcount min="1" code="ca_occurrences.workDate.work_dates_types">(^ca_occurrences.workDate.work_dates_types)</ifdef></unit></p></ifcount>}}}
			
			
			{{{<ifcount min="1" code="ca_occurrences.restrictions|ca_occurrences.rights|ca_occurrences.sniDepiction|ca_entities.preferred_labels"><hr><h5>Rights & Permissions</h5></ifcount>}}}
			{{{<unit><ifdef code="ca_occurrences.restrictions"><div><span class='metaTitle'>Restrictions</span><span class='meta'>^ca_occurrences.restrictions</span></div></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.rights"><div><span class='metaTitle'>Rights</span><span class='meta'>^ca_occurrences.rights</span></div></ifdef></unit>}}}
<?php
			if ($t_occurrence->get('ca_occurrences.sniDepiction', array('excludeValues' => array('not_specified'))) != "") {
				print "<div><span class='metaTitle'>Depicts SI</span><span class='meta'>".$t_occurrence->get('ca_occurrences.sniDepiction', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
			}	
			if ($va_contributors = $t_occurrence->get('ca_entities', array('excludeRelationshipTypes' => array('subject, interviewee'), 'returnWithStructure' => true))) {
				print "<div><span class='metaTitle'>Contributors</span><div class='meta'>";
				foreach ($va_contributors as $cont_key => $va_contributor) {
					print "<div>".caNavLink($this->request, $va_contributor['displayname']." (".$va_contributor['relationship_typename'].")", '' , 'Detail', 'entities', $va_contributor['entity_id'])."</div>";
				}
				print "</div></div>";
			}	
?>
			
			{{{<ifcount min="1" code="ca_occurrences.description|ca_places.preferred_labels|ca_entities.preferred_labels|ca_occurrences.lcsh_names|ca_occurrences.lcsh_subjects"><hr><h5>Content</h5></ifcount>}}}
			
			{{{<ifcount code="ca_occurrences.description" min="1"><span class='metaTitle'>Description</span><span class='meta'>^ca_occurrences.description</span></ifcount>}}}
			
			{{{<ifcount code="ca_places" min="1" max="1"><span class='metaTitle'>Related Place</span></ifcount>}}}
			{{{<ifcount code="ca_places" min="2"><span class='metaTitle'>Related Places</span></ifcount>}}}
			{{{<ifcount code="ca_places.preferred_labels" min="1"><unit relativeTo="ca_places" delimiter="<br/>"><l><div class='meta'>^ca_places.preferred_labels</div></l></unit></ifcount>}}}

			{{{<ifcount code="ca_entities" min="1" max="1"><span class='metaTitle'>Related Entity</span></ifcount>}}}
			{{{<ifcount code="ca_entities" min="2"><span class='metaTitle'>Related Entities</span></ifcount>}}}

			{{{<ifcount code="ca_entities.related" min="1"><div class='meta'><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></ifcount></div>}}}
			
			
<?php
			if ($va_lcsh_names = $t_occurrence->get('ca_occurrences.lcsh_names', array('returnWithStructure' => true))) {
				print "<span class='metaTitle'>LCSH Names</span>";
				print "<div class='meta'>";
				foreach ($va_lcsh_names as $va_key => $va_lcsh_name) {
					$va_name = explode('[', $va_lcsh_name['lcsh_names']);
					print $va_name[0]."<br/>";
				}
				print "</div>";
			}
			if ($va_lcsh_subjects = $t_occurrence->get('ca_occurrences.lcsh_subjects', array('returnWithStructure' => true))) {
				print "<span class='metaTitle'>LCSH Subjects</span>";
				print "<div class='meta'>";
				foreach ($va_lcsh_subjects as $va_key => $va_lcsh_subject) {
					$va_lcsh = explode('[', $va_lcsh_subject['lcsh_subjects']);
					print $va_lcsh[0]."<br/>";
				}
				print "</div>";
			}
?>			

			
			{{{<ifcount code="ca_occurrences.workDate.dates_value|ca_occurrences.genre|ca_occurrences.productionTypes|ca_occurrences.mission.missionCritical|ca_occurrences.awards.award_event|ca_occurrences.distribution_status.distribution_date" min="1"><hr><h5>Program Info</h5></ifcount>}}}
<?php
			if ($t_occurrence->get('ca_occurrences.workDate.work_dates_types') == "First air date") {
				print "<div><span class='metaTitle'>Air Date</span><span class='meta'>".$t_occurrence->get('ca_occurrences.workDate.dates_value')."</span></div>";
			}
			if ($t_occurrence->get('ca_occurrences.genre') != "") {
				print "<div><span class='metaTitle'>Genre</span><span class='meta'>".$t_occurrence->get('ca_occurrences.genre', array('convertCodesToDisplayText' => true))."</span></div>";
			}	
			if ($t_occurrence->get('ca_occurrences.productionTypes') != "") {
				print "<div><span class='metaTitle'>Production type</span><span class='meta'>".$t_occurrence->get('ca_occurrences.productionTypes', array('convertCodesToDisplayText' => true))."</span></div>";
			}
			if ($t_occurrence->get('ca_occurrences.mission.missionCritical') == "Yes") {
				print "<div><span class='metaTitle'>Mission critical</span><span class='meta'><div>Mission Critical: ".$t_occurrence->get('ca_occurrences.mission.missionCritical')."</div>";
				print "<div>Year: ".$t_occurrence->get('ca_occurrences.mission.missionYear')." (".$t_occurrence->get('ca_occurrences.mission.mission_dates_types').")</div>";
				print "</span></div>";
			}
			$va_awards = $t_occurrence->get('ca_occurrences.awards', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true, 'showHierarchy' => true));
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
													
?>	
			<div id="detailTools">
				<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
				<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
				<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
			</div><!-- end detailTools -->		
		
		{{{<ifcount code="ca_occurrences.distribution_status.distribution_date" min="1"><span class='metaTitle'>Distribution Status</span></ifcount>}}}
			{{{<ifcount code="ca_occurrences.distribution_status.distribution_date" min="1"><span class='meta'><unit delimiter="<br/>"><div>^ca_occurrences.distribution_status.distribution_list, Expires ^ca_occurrences.distribution_status.distribution_date</div></unit></span></ifcount>}}}									
		
<?php
			$va_object_ids = $t_occurrence->get('ca_objects.object_id', array('returnAsArray' => true));
			
			if (sizeof($va_object_ids) > 0){
			
			$t_object = new ca_objects();
			$vo_result = $t_object->makeSearchResult("ca_objects", $va_object_ids);
?>
			<hr>
			<div id="detailRelatedObjects">
				<H6>Related Objects</H6>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNext"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarousel">
						<ul>
<?php
					while ($vo_result->nextHit()) {
?>						
							<li><div class='detailObjectsResult'>
<?php						
						print "<p>".$vo_result->get('ca_objects.preferred_labels', array('returnAsLink' => true))."</p>";
						if ($vo_result->get('ca_objects.generation_video', array('excludeValues' => array('not_specified'))) != "") {
							print "<div><span class='metaTitle'>Generation</span><span class='meta'>".$vo_result->get('ca_objects.generation_video', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
						}	
						if ($vo_result->get('ca_objects.generation_supporting', array('excludeValues' => array('not_specified'))) != "") {
							print "<div><span class='metaTitle'>Generation</span><span class='meta'>".$vo_result->get('ca_objects.generation_supporting', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
						}	
						if ($vo_result->get('ca_objects.supporting_type')) {
							print "<div><span class='metaTitle'>Type</span><span class='meta'>".$vo_result->get('ca_objects.supporting_type', array('convertCodesToDisplayText' => true))."</span></div>";
						}	
						if ($vo_result->get('ca_objects.idno')) {
							print "<div><span class='metaTitle'>Identifier</span><span class='meta'>".$vo_result->get('ca_objects.idno')."</span></div>";
						}	
						if ($vo_result->get('ca_storage_locations.preferred_labels')) {
							print "<div><span class='metaTitle'>Storage Location</span><span class='meta'>".$vo_result->get('ca_storage_locations.preferred_labels', array('delimiter' => ', '))."</span></div>";
						}											
						if ($vo_result->get('ca_objects.video_physical', array('excludeValues' => array('not_specified'))) != "") {
							print "<div><span class='metaTitle'>Format</span><span class='meta'>".$vo_result->get('ca_objects.video_physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
						}
						if ($vo_result->get('ca_objects.physical', array('excludeValues' => array('not_specified'))) != "") {
							print "<div><span class='metaTitle'>Format</span><span class='meta'>".$vo_result->get('ca_objects.physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
						}
						if ($vo_result->get('ca_objects.digital_moving_image', array('excludeValues' => array('not_specified'))) != "") {
							print "<div><span class='metaTitle'>Format</span><span class='meta'>".$vo_result->get('ca_objects.digital_moving_image', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
						}
						if ($vo_result->get('ca_objects.digital_supporting', array('excludeValues' => array('not_specified'))) != "") {
							print "<div><span class='metaTitle'>Format</span><span class='meta'>".$vo_result->get('ca_objects.digital_supporting', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
						}
						if ($vo_result->get('ca_objects.carrier', array('excludeValues' => array('not_specified'))) != "") {
							print "<div><span class='metaTitle'>Carrier</span><span class='meta'>".$vo_result->get('ca_objects.carrier', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
						}	
						if ($vo_result->get('ca_objects.date')) {
							print "<div><span class='metaTitle'>Date</span><span class='meta'>".$vo_result->get('ca_objects.date', array('delimiter' => ', '))."</span></div>";
						}
						if ($vo_result->get('ca_objects.description')) {
							print "<div><span class='metaTitle'>Description</span><span class='meta'>".$vo_result->get('ca_objects.description', array('delimiter' => ', '))."</span></div>";
						}	
						if ($vo_result->get('ca_objects.notes')) {
							print "<div><span class='metaTitle'>Notes</span><span class='meta'>".$vo_result->get('ca_objects.notes', array('delimiter' => ', '))."</span></div>";
						}
						if ($vo_result->get('ca_objects.technicalNotes')) {
							print "<div><span class='metaTitle'>Technical Notes</span><span class='meta'>".$vo_result->get('ca_objects.technicalNotes', array('delimiter' => ', '))."</span></div>";
						}	
						if ($vo_result->get('ca_objects.rights')) {
							print "<div><span class='metaTitle'>Rights</span><span class='meta'>".$vo_result->get('ca_objects.rights', array('delimiter' => ', '))."</span></div>";
						}
						if ($vo_result->get('ca_objects.alt_modes')) {
							print "<div><span class='metaTitle'>Alternate Modes</span><span class='meta'>".$vo_result->get('ca_objects.alt_modes', array('delimiter' => ', '))."</span></div>";
						}	
						if ($vo_result->get('ca_objects.color')) {
							print "<div><span class='metaTitle'>Color</span><span class='meta'>".$vo_result->get('ca_objects.color', array('delimiter' => ', '))."</span></div>";
						}					
?>						
							</div></li>
<?php
					}
?>							
						</ul>
					</div><!-- end jcarousel -->
					
				</div><!-- end jcarousel-wrapper -->
			</div><!-- end detailRelatedObjects -->
<?php			
				}	
?>			
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarousel')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPrevious')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#detailScrollButtonNext')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
				});
			</script>
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->