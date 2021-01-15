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
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="choreographer" min="1"><div class='unit trimText'><label>Choreography</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="choreographer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="composer" min="1"><div class='unit trimText'><label>Composer</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="composer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					
					{{{<ifdef code="ca_occurrences.music.music"><div class='unit trimText'><label>Music</label>^ca_occurrences.music.music</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.music.instruments"><div class='unit trimText'><label>Instrumentation</label>^ca_occurrences.instruments.music</div></ifdef>}}}
					
					{{{<ifdef code="ca_occurrences.dancerNumber"><div class='unit trimText'><label>Number of Dancers</label>^ca_occurrences.dancerNumber</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.runtime"><div class='unit trimText'><label>Running Time</label>^ca_occurrences.runtime</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.premiereDateField"><div class='unit trimText'><label>Premiere Date & Company</label><unit relativeTo="ca_occurrences.premiereDateField" delimiter="<br/>">^ca_occurrences.premiereDateField.premiereDate<ifdef code="ca_occurrences.premiereDateField.premiereDateCompany, ca_occurrences.premiereDateField.premiereDate">, </ifdef>^ca_occurrences.premiereDateField.premiereDateCompany</unit></div></ifdef>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="lighting_designer" min="1"><div class='unit trimText'><label>Lighting Design</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="lighting_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="costume_designer" min="1"><div class='unit trimText'><label>Costume Designer</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="costume_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="set_designer" min="1"><div class='unit trimText'><label>Set Designer</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="set_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="premiere_cast" min="1"><div class='unit trimText'><label>Premiere Cast</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="premiere_cast" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					
				
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_item->get('ca_occurrences.related', array('restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						foreach ($va_works as $va_work) {
							$va_related_list[$va_work['relationship_typename']][] = caDetailLink($this->request, $va_work['name'], '', 'ca_occurrences', $va_work['occurrence_id']);
						}
						print "<div class='unit'><H3>Works</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							foreach($va_links as $vs_link){
								if($i == 0){
									print "<div class='row'>";
								}
								print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".$vs_link."</div></div>";
								$i++;
								if($i == 3){
									print "</div>";
									$i = 0;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
					}
					
					if ($va_events = $t_item->get('ca_occurrences.related', array('restrictToTypes' => array('event'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						foreach ($va_events as $va_event) {
							$va_related_list[$va_event['relationship_typename']][] = caDetailLink($this->request, $va_event['name'], '', 'ca_occurrences', $va_event['occurrence_id']);
						}
						print "<div class='unit'><H3>Performances & Events</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							foreach($va_links as $vs_link){
								if($i == 0){
									print "<div class='row'>";
								}
								print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".$vs_link."</div></div>";
								$i++;
								if($i == 3){
									print "</div>";
									$i = 0;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
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