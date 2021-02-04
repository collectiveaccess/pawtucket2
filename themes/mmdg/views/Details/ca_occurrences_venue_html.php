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
					
<?php					
					if ($va_works = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.premiereDate', 'restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_works as $va_work) {
							$va_related_list[$va_work['relationship_typename']][] = caDetailLink($this->request, $va_work['name'], '', 'ca_occurrences', $va_work['occurrence_id']);
						}
						print "<div class='unit'><H3>Works</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							$c = 0;
							if(sizeof($va_links) > 12){
								$vb_show_view_all = true;
							}
							foreach($va_links as $vs_link){
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
								if($c == 12){
									break;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Works", "btn btn-default", "", "Browse", "works", array("facet" => "venue_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					
					if ($va_events = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.eventDate', 'restrictToTypes' => array('event'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_events as $va_event) {
							$va_related_list[$va_event['relationship_typename']][] = caDetailLink($this->request, $va_event['name'], '', 'ca_occurrences', $va_event['occurrence_id']);
						}
						print "<div class='unit'><H3>Performances & Events</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							$c = 0;
							if(sizeof($va_links) > 12){
								$vb_show_view_all = true;
							}
							foreach($va_links as $vs_link){
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
								if($c == 12){
									break;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Performances & Events", "btn btn-default", "", "Browse", "events", array("facet" => "venue_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					
					if ($va_entities = $t_item->get('ca_entities', array('sort' => 'ca_occurrences.surname', 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_entities as $va_entity) {
							$va_related_list[$va_entity['relationship_typename']][] = caDetailLink($this->request, $va_entity['displayname'], '', 'ca_occurrences', $va_entity['occurrence_id']);
						}
						print "<div class='unit'><H3>People & Organizations</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							$c = 0;
							if(sizeof($va_links) > 12){
								$vb_show_view_all = true;
							}
							foreach($va_links as $vs_link){
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
								if($c == 12){
									break;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All People & Organizations", "btn btn-default", "", "Browse", "entities", array("facet" => "venue_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
			<div class="unit"><H3>Object<ifcount code="ca_objects" min="2">s</ifcount></H3>
				<div id="browseResultsContainer">
					<unit relativeTo="ca_objects" length="12" delimiter=" ">
						<div class="bResultItemCol col-xs-12 col-sm-4">
							<div class="bResultItem" id="row^ca_objects.object_id">
								<div class="bResultItemContent"><div class="text-center bResultItemImg"><ifcount code="ca_object_representations" min="1"><l>^ca_object_representations.media.medium</l></ifcount><ifcount code="ca_object_representations" max="0"><l><?php print "<div class='bResultItemImgPlaceholderLogo'>".caGetThemeGraphic($this->request, 'mmdg_lines.png', array("alt" => "media not available for this item"))."</div>"; ?></l></ifcount></div>
									<div class="bResultItemText">
										<l>^ca_objects.preferred_labels.name</l>
									</div><!-- end bResultItemText -->
								</div><!-- end bResultItemContent -->
							</div><!-- end bResultItem -->
						</div><!-- end col -->
					</unit>
				</div><!-- end browseResultsContainer -->
			</div><!-- end unit -->
			<ifcount code="ca_objects" min="12">
				<div class="unit text-center">
					<?php print caNavLink($this->request, "View All Objects", "btn btn-default", "", "Browse", "objects", array("facet" => "venue_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
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