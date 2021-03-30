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
				<div class='col-sm-12'>
					{{{<ifdef code="ca_occurrences.descriptionWithSource.prodesc_text"><div class='unit trimText'><label>Description</label>^ca_occurrences.descriptionWithSource.prodesc_text</div></ifdef>}}}
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><div class='unit'><label>Venue<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="2">s</ifcount></label><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter=", "><l>^ca_occurrences.preferred_labels.name</l></div></ifcount>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="musician" min="1"><div class='unit trimText'><label>Musician<ifcount code="ca_entities" restrictToRelationshipTypes="musician" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="musician" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="singer" min="1"><div class='unit trimText'><label>Singer<ifcount code="ca_entities" restrictToRelationshipTypes="singer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="singer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="dancer" min="1"><div class='unit trimText'><label>Dancer<ifcount code="ca_entities" restrictToRelationshipTypes="dancer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="dancer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="director" min="1"><div class='unit trimText'><label>Director<ifcount code="ca_entities" restrictToRelationshipTypes="director" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="director" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="performer" min="1"><div class='unit trimText'><label>Performer<ifcount code="ca_entities" restrictToRelationshipTypes="performer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="performer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="related" restrictToTypes="organization" min="1"><div class='unit trimText'><label>Presenter<ifcount code="ca_entities" restrictToRelationshipTypes="related" restrictToTypes="organization" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="related" restrictToTypes="organization" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					
				</div>
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
						print "<div class='unit'><H3>Works Performed</H3>";
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Works Performed", "btn btn-default", "", "Browse", "works", array("facet" => "event_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
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
					<?php print caNavLink($this->request, "View All Objects", "btn btn-default", "", "Browse", "objects", array("facet" => "event_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
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