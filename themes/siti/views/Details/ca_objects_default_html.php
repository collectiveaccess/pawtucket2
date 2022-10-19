<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_rep_viewer = trim($this->getVar("representationViewer"));		
				
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
					<H1>{{{^ca_objects.type_id}}}</H1>
					<H2>{{{^ca_objects.preferred_labels.name}}}</H2>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					
					<?php print $vs_rep_viewer; ?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="interviewer"><div class='unit trimText'><label>Interviewer</label><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="interviewer"><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="interviewee"><div class='unit trimText'><label>Interviewee</label><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="interviewee"><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="photographer"><div class='unit trimText'><label>Photographer</label><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="photographer"><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="videographer"><div class='unit trimText'><label>Videographer</label><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="videographer"><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator"><div class='unit trimText'><label>Creator</label><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
					{{{<ifdef code="ca_objects.date"><div class='unit'><label>Date</label>^ca_objects.date%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.photograph_format"><div class='unit'><label>Format</label>^ca_objects.photograph_format%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.format_type"><div class='unit'><label>Format</label>^ca_objects.format_type%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.format_type_press"><div class='unit'><label>Format</label>^ca_objects.format_type_press%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_objects.dimensions"><div class='unit'><label>Dimensions</label>^ca_objects.dimensions%delimiter=,_</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="interviewer,interviewee,photographer,videographer,creator"><div class='unit trimText'><label>Related People & Organizations</label><unit relativeTo="ca_entities.related" excludeRelationshipTypes="interviewer,interviewee,photographer,videographer,creator"><l>^ca_entities.preferred_labels.displayname (^relationship_typename)</l></div></ifcount>}}}					
					
					{{{<ifdef code="ca_objects.TapeRuntime"><div class='unit'><label>Runtime</label>^ca_objects.TapeRuntime%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.descriptionWithSource.prodesc_text"><div class='unit trimText'><label>Description</label>^ca_objects.descriptionWithSource.prodesc_text</div></ifdef>}}}
					{{{<ifdef code="ca_objects.rightsStatement|ca_objects.rights"><div class='unit trimText'><label>Rights Information</label><ifdef code="ca_objects.rightsStatement.rightsStatement_text">^ca_objects.rightsStatement.rightsStatement_text </ifdef><a href="#" onClick="$('.rights').toggle(); return false;">Rights Summary</a><div class="unit rights" style="display:none;">^ca_objects.rights</div></div></ifdef>}}}
					{{{<ifdef code="ca_objects.orderingInfo"><div class='unit trimText'><label>Ordering Information</label><unit relativeTo="ca_objects.orderingInfo" delimiter="<br/><br/>">^ca_objects.orderingInfo</unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.idno"><div class='unit'><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
					
					
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_object->get('ca_occurrences', array('restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values, 'limit' => 20))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Works</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_works) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_works as $va_work) {
							if($i == 0){
								print "<div class='row'>";
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Related Works", "btn btn-default", "", "Browse", "works", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
						}
					}
					
					$va_productions = $t_object->get('ca_occurrences', array('restrictToTypes' => array('production'), 'sort' => 'ca_occurrences.date', 'sortDirection' => 'asc', 'returnWithStructure' => true, 'checkAccess' => $va_access_values, 'limit' => 20));
					if (sizeof($va_productions)) {
						$va_related_list = array();
						foreach ($va_productions as $va_production) {
							$t_occ = new ca_occurrences($va_production['occurrence_id']);
							$vs_date = $t_occ->get("ca_occurrences.date", array("delimiter" => ", "));
							$vs_venue = $t_occ->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter="<br/>">^ca_occurrences.preferred_labels.name</unit></ifcount>');
							$va_related_list[] = caDetailLink($this->request, $va_production['name'].(($vs_date) ? "<div class='small'>".$vs_date."</div>" : "").(($vs_venue) ? "<div class='small'>".$vs_venue."</div>" : ""), '', 'ca_occurrences', $va_production['occurrence_id']);
						}
						print "<div class='unit'><H3>Productions</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
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
						
					}
					if(sizeof($va_productions) > 18){
						print "<div class='unit text-center'>".caNavLink($this->request, "View All Productions", "btn btn-default", "", "Browse", "productions", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					}
					$va_trainings = $t_object->get('ca_occurrences', array('restrictToTypes' => array('training'), 'sort' => 'ca_occurrences.training_date', 'sortDirection' => 'asc', 'returnWithStructure' => true, 'checkAccess' => $va_access_values, 'limit' => 20));
					if (sizeof($va_trainings)) {
						$va_related_list = array();
						foreach ($va_trainings as $va_training) {
							$t_occ = new ca_occurrences($va_training['occurrence_id']);
							$vs_date = $t_occ->get("ca_occurrences.training_date", array("delimiter" => ", "));
							$va_related_list[] = caDetailLink($this->request, $va_training['name'].(($vs_date) ? "<div class='small'>".$vs_date."</div>" : ""), '', 'ca_occurrences', $va_event['occurrence_id']);
						}
						print "<div class='unit'><H3>Trainings</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
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
						
					}
					if(sizeof($va_trainings) > 18){
						print "<div class='unit text-center'>".caNavLink($this->request, "View All Trainings", "btn btn-default", "", "Browse", "trainings", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					}
					$va_events = $t_object->get('ca_occurrences', array('restrictToTypes' => array('special_event'), 'sort' => 'ca_occurrences.eventDate', 'sortDirection' => 'asc', 'returnWithStructure' => true, 'checkAccess' => $va_access_values, 'limit' => 20));
					if (sizeof($va_events)) {
						$va_related_list = array();
						foreach ($va_events as $va_event) {
							$t_occ = new ca_occurrences($va_event['occurrence_id']);
							$vs_date = $t_occ->get("ca_occurrences.eventDate", array("delimiter" => ", "));
							$va_related_list[] = caDetailLink($this->request, $va_event['name'].(($vs_date) ? "<div class='small'>".$vs_date."</div>" : ""), '', 'ca_occurrences', $va_event['occurrence_id']);
						}
						print "<div class='unit'><H3>Special Events</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
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
						
					}
					if(sizeof($va_events) > 18){
						print "<div class='unit text-center'>".caNavLink($this->request, "View All Special Events", "btn btn-default", "", "Browse", "events", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects.related" min="1">
			<div class="unit"><H3>Media</H3>
				<div id="browseResultsContainer">
					<unit relativeTo="ca_objects.related" length="21" delimiter=" " aggregateUnique="1">
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