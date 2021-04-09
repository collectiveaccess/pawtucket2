<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_rep_viewer = trim($this->getVar("representationViewer"));
				
				
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
<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					
					<?php print $vs_rep_viewer; ?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					{{{<ifdef code="ca_occurrences.descriptionWithSource.prodesc_text"><div class='unit trimText'><label>Description</label>^ca_occurrences.descriptionWithSource.prodesc_text</div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="choreographer" min="1"><div class='unit trimText'><label>Choreographer<ifcount code="ca_entities" restrictToRelationshipTypes="choreographer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="choreographer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="composer" min="1"><div class='unit trimText'><label>Composer<ifcount code="ca_entities" restrictToRelationshipTypes="composer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="composer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="director" min="1"><div class='unit trimText'><label>Director<ifcount code="ca_entities" restrictToRelationshipTypes="director" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="director" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="performer" min="1"><div class='unit trimText'><label>Performer<ifcount code="ca_entities" restrictToRelationshipTypes="performer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="performer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					
					{{{<ifdef code="ca_occurrences.music.music"><div class='unit trimText'><label>Music</label>^ca_occurrences.music.music</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.music.instruments"><div class='unit trimText'><label>Instrumentation</label>^ca_occurrences.music.instruments</div></ifdef>}}}
					
					{{{<ifdef code="ca_occurrences.dancerNumber"><div class='unit trimText'><label>Number of Dancers</label>^ca_occurrences.dancerNumber</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.runtime"><div class='unit trimText'><label>Running Time</label>^ca_occurrences.runtime</div></ifdef>}}}
<?php
					$va_premieres = $t_item->get("ca_occurrences.premiereDateField", array("returnWithStructure" => 1));
					if(is_array($va_premieres) && sizeof($va_premieres)){
						$va_premieres = array_pop($va_premieres);
						$va_tmp = array();
						foreach($va_premieres as $va_premiere){
							if($va_premiere["premiereDate"] || $va_premiere["premiereDateCompany"]){
								$t_entity = new ca_entities($va_premiere["premiereDateCompany"]);
								$va_tmp[] = $va_premiere["premiereDate"].",  ".$t_entity->getWithTemplate("<l>^ca_entities.preferred_labels.displayname</l>");
							}
						}
						if(sizeof($va_tmp)){
							print "<div class='unit trimText'><label>Premiere Date & Company</label>".join("<br/>", $va_tmp)."</div>";
						}
					}
?>					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="lighting_designer" min="1"><div class='unit trimText'><label>Lighting Designer<ifcount code="ca_entities" restrictToRelationshipTypes="lighting_designer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="lighting_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="costume_designer" min="1"><div class='unit trimText'><label>Costume Designer<ifcount code="ca_entities" restrictToRelationshipTypes="costume_designer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="costume_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="set_designer" min="1"><div class='unit trimText'><label>Set Designer<ifcount code="ca_entities" restrictToRelationshipTypes="set_designer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="set_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="premiere_cast" min="1"><div class='unit trimText'><label>Premiere Cast</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="premiere_cast" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					
				
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_item->get('ca_occurrences.related', array('restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_works as $va_work) {
							$va_related_list[$va_work['relationship_typename']][] = caDetailLink($this->request, $va_work['name'], '', 'ca_occurrences', $va_work['occurrence_id']);
						}
						print "<div class='unit'><H3>Related Works</H3>";
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Related Works", "btn btn-default", "", "Browse", "works", array("facet" => "work_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					
					$va_premiere_events = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.eventDate', 'restrictToTypes' => array('event'), 'restrictToRelationshipTypes' => array('premiered'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values));
					$va_non_premiere_events = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.eventDate', 'restrictToTypes' => array('event'), 'excludeRelationshipTypes' => array('premiered'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values));
					if (sizeof($va_premiere_events) || sizeof($va_non_premiere_events)) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_premiere_events as $va_premiere_event) {
							$va_related_list[$va_premiere_event['relationship_typename']][] = caDetailLink($this->request, $va_premiere_event['name'], '', 'ca_occurrences', $va_premiere_event['occurrence_id']);
						}
						foreach ($va_non_premiere_events as $va_non_premiere_event) {
							$va_related_list[$va_non_premiere_event['relationship_typename']][] = caDetailLink($this->request, $va_non_premiere_event['name'], '', 'ca_occurrences', $va_non_premiere_event['occurrence_id']);
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Performances & Events", "btn btn-default", "", "Browse", "events", array("facet" => "work_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="unit"><H3>Related Object<ifcount code="ca_objects" min="2">s</ifcount></H3>
				<div id="browseResultsContainer">
					<unit relativeTo="ca_objects" length="12" delimiter=" ">
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
			<ifcount code="ca_objects" min="12">
				<div class="unit text-center">
					<?php print caNavLink($this->request, "View All Objects", "btn btn-default", "", "Browse", "objects", array("facet" => "work_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
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