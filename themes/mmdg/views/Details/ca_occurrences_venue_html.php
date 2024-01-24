<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
				
				
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
			<div class="row">
				<div class='col-md-12 col-lg-12 text-center'>
					<H1>{{{^ca_occurrences.type_id}}}</H1>
					<H2>{{{^ca_occurrences.preferred_labels.name}}}</H2>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
					{{{<ifdef code="ca_occurrences.descriptionWithSource.prodesc_text"><div class='unit trimText'><label>Description</label>^ca_occurrences.descriptionWithSource.prodesc_text</div></ifdef>}}}
					{{{<ifcount code="ca_places" min="1"><div class='unit trimText'><label>Location<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter=", ">^ca_places.preferred_labels.displayname</div></ifcount>}}}
					
<?php					
					if ($va_works = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.premiereDate', 'restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Premiere Works</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_works) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_works as $va_work) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_work['name'], '', 'ca_occurrences', $va_work['occurrence_id'])."</div></div>";
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Works", "btn btn-default", "", "Browse", "works", array("facet" => "venue_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					
					if ($va_events = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.eventDate', 'restrictToTypes' => array('event'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Performances & Events</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_events) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_events as $va_event) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_event['name'], '', 'ca_occurrences', $va_event['occurrence_id'])."</div></div>";
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Performances & Events", "btn btn-default", "", "Browse", "events", array("facet" => "venue_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					
					if ($va_entities = $t_item->get('ca_entities', array('sort' => 'ca_entities.surname', 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Presenter".((sizeof($va_entities) > 1) ? "s" : "")."</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_entities) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_entities as $va_entity) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_entity['displayname'], '', 'ca_entities', $va_entity['entity_id'])."</div></div>";
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All People & Organizations", "btn btn-default", "", "Browse", "entities", array("facet" => "venue_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}

?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
			<div class="unit"><H3>Media</H3>
				<div id="browseResultsContainer">
					<unit relativeTo="ca_objects" length="21" delimiter=" " aggregateUnique="1" sort="ca_objects.eventDate" sortDirection="desc">
						<div class="bResultItemCol col-xs-12 col-sm-4">
							<div class="bResultItem" id="row^ca_objects.object_id">
								<div class="bResultItemContent"><div class="text-center bResultItemImg"><case><ifcount code="ca_object_representations.media.medium" min="1"><l>^ca_object_representations.media.medium</l></ifcount><ifcount code="ca_object_representations" min="0" max="0"><l><?php print "<div class='bResultItemImgPlaceholderLogo'>".caGetThemeGraphic($this->request, 'mmdg_lines.png', array("alt" => "media not available for this item"))."</div>"; ?></l></ifcount></case></div>
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
					<?php print caNavLink($this->request, "View All Media", "btn btn-default", "", "Browse", "objects", array("facet" => "venue_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 400
		});
	});
</script>