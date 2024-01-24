<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_rep_viewer = trim($this->getVar("representationViewer"));
	if(!$vs_rep_viewer){
		$vs_rep_viewer = $t_item->getWithTemplate("<ifcount code='ca_objects' min='1' restrictToRelationshipTypes='feature'><unit relativeTo='ca_objects' restrictToRelationshipTypes='feature'><div class='repViewerCont'><l>^ca_object_representations.media.large</l><div class='small text-center'>^ca_objects.preferred_labels</div></div></unit></ifcount>", array("checkAccess" => $va_access_values));
	}		
				
?>
<div class="container">
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
				<div class='col-md-12 col-lg-12 text-center'>
					<H1>{{{^ca_occurrences.type_id}}}</H1>
					<H2>{{{^ca_occurrences.preferred_labels.name}}}</H2>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-4 col-md-4 col-lg-4'>
					
					<?php print $vs_rep_viewer; ?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
					
				</div><!-- end col -->
				<div class='col-sm-8 col-md-8 col-lg-8'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					<div class='row'>
						<div class='col-md-6'>
							{{{<ifdef code="ca_occurrences.date"><div class='unit trimText'><label>Date</label>^ca_occurrences.date</div></ifdef>}}}
							{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="director"><div class='unit trimText'><label>Director</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="director" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></div></unit></ifcount>}}}					
							{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="actor"><div class='unit trimText'><label>Actors</label><unit relativeTo="ca_entities_x_occurrences" restrictToRelationshipTypes="actor" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> <ifdef code="ca_entities_x_occurrences.production_role">(^ca_entities_x_occurrences.production_role.role_test<if rule="^ca_entities_x_occurrences.production_role.understudy_test =~ /Yes/">, Understudy</if>)</ifdef></unit></div></ifcount>}}}					
							{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="presented_by,premiere"><div class='unit trimText'><label>Presented By</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="presented_by,premiere" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></div></unit></ifcount>}}}					
							{{{<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><div class='unit trimText'><label>Venue</label><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></div></ifcount>}}}					
							{{{<ifdef code="ca_occurrences.language"><div class='unit trimText'><label>Language</label>^ca_occurrences.language%delimiter=,_</div></ifdef>}}}
							{{{<ifdef code="ca_occurrences.runtime"><div class='unit trimText'><label>Running Time</label>^ca_occurrences.runtime</div></ifdef>}}}						
						</div>
						<div class='col-md-6'>
							{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="director,actor,presented_by"><div class='unit trimText'><label>Production Credits</label><unit relativeTo="ca_entities" excludeRelationshipTypes="director,actor" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</div></ifcount>}}}					
						</div>
					</div>
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
												
					{{{<ifdef code="ca_occurrences.program_note_container.program_note"><div class='unit trimText'><label>Program Note</label><unit relativeTo="ca_occurrences.program_note_container" delimiter="<br/><br/>">^ca_occurrences.program_note_container.program_note</unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.director_note_container.director_note"><div class='unit trimText'><label>Director's Note</label><unit relativeTo="ca_occurrences.director_note_container" delimiter="<br/><br/>">^ca_occurrences.director_note_container.director_note</unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.blurb_container.blurb"><div class='unit trimText'><label>Blurb</label><unit relativeTo="ca_occurrences.blurb_container" delimiter="<br/><br/>">^ca_occurrences.blurb_container.blurb</unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.process_note_container.process_note"><div class='unit trimText'><label>Notes on Process</label><unit relativeTo="ca_occurrences.process_note_container" delimiter="<br/><br/>">^ca_occurrences.process_note_container.process_note</unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.quotes"><div class='unit trimText'><label>Quotes</label><unit relativeTo="ca_occurrences.quotes" delimiter="<br/><br/>">^ca_occurrences.quotes</unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.idno"><div class='unit'><label>Identifer</label>^ca_occurrences.idno</div></ifdef>}}}

				</div>
			</div>
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_item->get('ca_occurrences.related', array('restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values, 'limit' => 20))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Works Performed</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_works) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_works as $va_work) {
							if($i == 0){
								print "<div class='row'>";
							}
							$vs_premiere = "";
							if($va_work['relationship_typename'] == 'premiere'){
								$vs_premiere = " (Premiere)";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_work['name'].$vs_premiere, '', 'ca_occurrences', $va_work['occurrence_id'])."</div></div>";
							$i++;
							$c++;
							if($i == 3){
								print "</div><!-- end row -->";
								$i = 0;
							}
							if($c == 18){
								break;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Related Works", "btn btn-default", "", "Browse", "works", array("facet" => "production_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					
					
					
					$va_trainings = $t_item->get('ca_occurrences.related', array('restrictToTypes' => array('training'), 'sort' => 'ca_occurrences.training_date', 'sortDirection' => 'asc', 'returnWithStructure' => true, 'checkAccess' => $va_access_values, 'limit' => 20));
					if (sizeof($va_trainings)) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_trainings as $va_training) {
							$t_occ = new ca_occurrences($va_training['occurrence_id']);
							$vs_date = $t_occ->get("ca_occurrences.training_date", array("delimiter" => ", "));
							$va_related_list[] = caDetailLink($this->request, $va_training['name'].(($vs_date) ? "<div class='small'>".$vs_date."</div>" : ""), '', 'ca_occurrences', $va_training['occurrence_id']);
						}
						print "<div class='unit'><H3>Trainings</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_related_list) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_related_list as $vs_link) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".$vs_link."</div></div>";
							$i++;
							$c++;
							if($i == 3){
								print "</div>";
								$i = 0;
							}
							if($c == 18){
								break;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Trainings", "btn btn-default", "", "Browse", "trainings", array("facet" => "production_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					$va_events = $t_item->get('ca_occurrences.related', array('restrictToTypes' => array('special_event'), 'sort' => 'ca_occurrences.eventDate', 'sortDirection' => 'asc', 'returnWithStructure' => true, 'checkAccess' => $va_access_values, 'limit' => 20));
					if (sizeof($va_events)) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_events as $va_event) {
							$t_occ = new ca_occurrences($va_event['occurrence_id']);
							$vs_date = $t_occ->get("ca_occurrences.eventDate", array("delimiter" => ", "));
							$va_related_list[] = caDetailLink($this->request, $va_event['name'].(($vs_date) ? "<div class='small'>".$vs_date."</div>" : ""), '', 'ca_occurrences', $va_event['occurrence_id']);
						}
						print "<div class='unit'><H3>Special Events</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_related_list) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_related_list as $vs_link) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".$vs_link."</div></div>";
							$i++;
							$c++;
							if($i == 3){
								print "</div>";
								$i = 0;
							}
							if($c == 18){
								break;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Special Events", "btn btn-default", "", "Browse", "events", array("facet" => "production_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="unit"><H3>Media</H3>
				<div id="browseResultsContainer">
					<unit relativeTo="ca_objects" length="21" delimiter=" " aggregateUnique="1">
						<div class="bResultItemCol col-xs-12 col-sm-4">
							<div class="bResultItem" id="row^ca_objects.object_id">
								<div class="bResultItemContent"><div class="text-center bResultItemImg"><case><ifcount code="ca_object_representations.media.medium" min="1"><l>^ca_object_representations.media.medium</l></ifcount><ifcount code="ca_object_representations" min="0" max="0"><l><?php print "<div class='bResultItemImgPlaceholderLogo'><i class='fa fa-picture-o fa-2x' aria-label='media placeholder'></i></div>"; ?></l></ifcount></case></div>
									<div class="bResultItemText">
										<small>^ca_objects.type_id</small><br/>
										<l>^ca_objects.preferred_labels.name</l>
									</div><!-- end bResultItemText -->
								</div><!-- end bResultItemContent -->
							</div><!-- end bResultItem -->
						</div><!-- end col -->
					</unit>
				</div><!-- end browseResultsContainer -->
			</div><!-- end unit -->
			<ifcount code="ca_objects" min="21">
				<div class="unit text-center">
					<?php print caNavLink($this->request, "View All Media", "btn btn-default", "", "Browse", "media", array("facet" => "production_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
				</div>
			</ifcount>
</ifcount>}}}
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 400
		});
	});
</script>