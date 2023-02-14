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
					<div class='row'>
						<div class='col-md-6'>

							{{{<ifdef code="ca_occurrences.descriptionWithSource.prodesc_text"><div class='unit trimText'><label>Description</label>^ca_occurrences.descriptionWithSource.prodesc_text</div></ifdef>}}}
					
							{{{<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><div class='unit'><label>Venue<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="2">s</ifcount></label><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter=", "><l>^ca_occurrences.preferred_labels.name</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="presented_by" min="1"><div class='unit trimText'><label>Presenter<ifcount code="ca_entities" restrictToRelationshipTypes="presented_by" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="presented_by" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="choreographer" min="1"><div class='unit trimText'><label>Choreographer<ifcount code="ca_entities" restrictToRelationshipTypes="choreographer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="choreographer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="director" min="1"><div class='unit trimText'><label>Director<ifcount code="ca_entities" restrictToRelationshipTypes="director" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="director" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="artistic_director" min="1"><div class='unit trimText'><label>Artistic Director<ifcount code="ca_entities" restrictToRelationshipTypes="artistic_director" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="artistic_director" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="composer" min="1"><div class='unit trimText'><label>Composer<ifcount code="ca_entities" restrictToRelationshipTypes="composer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="composer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="editor" min="1"><div class='unit trimText'><label>Editor<ifcount code="ca_entities" restrictToRelationshipTypes="editor" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="editor" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="conductor" min="1"><div class='unit trimText'><label>Conductor<ifcount code="ca_entities" restrictToRelationshipTypes="conductor" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="conductor" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="costume_designer" min="1"><div class='unit trimText'><label>Costume Designer<ifcount code="ca_entities" restrictToRelationshipTypes="costume_designer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="costume_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="costume_realization" min="1"><div class='unit trimText'><label>Costume Realization</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="costume_realization" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="lighting_designer" min="1"><div class='unit trimText'><label>Lighting Designer<ifcount code="ca_entities" restrictToRelationshipTypes="lighting_designer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="lighting_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="set_designer" min="1"><div class='unit trimText'><label>Set Designer<ifcount code="ca_entities" restrictToRelationshipTypes="set_designer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="set_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="set_and_prop_realization" min="1"><div class='unit trimText'><label>Set and Prop Realization</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="set_and_prop_realization" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="scenic_designer" min="1"><div class='unit trimText'><label>Scenic Designer<ifcount code="ca_entities" restrictToRelationshipTypes="scenic_designer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="scenic_designer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
						</div>
						<div class='col-md-6'>
<?php
							$va_musician_roles = array("Cello" => "cello", "Double Bass" => "double_bass", "Guitar" => "guitar", "Harmonium" => "harmonium", "Harpsichord" => "harpsichord", "Keyboard" => "keyboard", "Oboe" => "oboe", "Percussion" => "percussion", "Piano" => "piano", "Soprano Saxophone" => "soprano_saxophone", "Theremin" => "theremin", "Trombone" => "trombone", "Viola" => "viola", "Violin" => "violin");
							foreach($va_musician_roles as $vs_role_label => $vs_role){
								print $t_item->getWithTemplate('<ifcount code="ca_entities" restrictToRelationshipTypes="'.$vs_role.'" min="1"><div class="unit trimText"><label>'.$vs_role_label.'</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="'.$vs_role.'" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>');
							}
?>
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="musician" min="1"><div class='unit trimText'><label>Musician<ifcount code="ca_entities" restrictToRelationshipTypes="musician" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="musician" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="ensemble" min="1"><div class='unit trimText'><label>Ensemble</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="ensemble" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="singer" min="1"><div class='unit trimText'><label>Vocalist<ifcount code="ca_entities" restrictToRelationshipTypes="singer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="singer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="lead_vocals" min="1"><div class='unit trimText'><label>Lead Vocals</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="lead_vocals" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="background_vocals" min="1"><div class='unit trimText'><label>Background Vocals</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="background_vocals" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="orchestra" min="1"><div class='unit trimText'><label>Orchestra<ifcount code="ca_entities" restrictToRelationshipTypes="orchestra" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="orchestra" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="chorus" min="1"><div class='unit trimText'><label>Chorus</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="chorus" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="choir" min="1"><div class='unit trimText'><label>Choir<ifcount code="ca_entities" restrictToRelationshipTypes="choir" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="choir" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="soprano" min="1"><div class='unit trimText'><label>Soprano<ifcount code="ca_entities" restrictToRelationshipTypes="soprano" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="soprano" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="alto" min="1"><div class='unit trimText'><label>Alto<ifcount code="ca_entities" restrictToRelationshipTypes="alto" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="alto" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="mezzo_soprano" min="1"><div class='unit trimText'><label>Mezzo-Soprano<ifcount code="ca_entities" restrictToRelationshipTypes="mezzo_soprano" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="mezzo_soprano" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="baritone" min="1"><div class='unit trimText'><label>Baritone<ifcount code="ca_entities" restrictToRelationshipTypes="baritone" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="baritone" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="tenor" min="1"><div class='unit trimText'><label>Tenor<ifcount code="ca_entities" restrictToRelationshipTypes="tenor" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="tenor" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="countertenor" min="1"><div class='unit trimText'><label>Countertenor<ifcount code="ca_entities" restrictToRelationshipTypes="countertenor" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="countertenor" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="reciter" min="1"><div class='unit trimText'><label>Reciter<ifcount code="ca_entities" restrictToRelationshipTypes="reciter" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="reciter" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="company" min="1"><div class='unit trimText'><label><ifcount code="ca_entities" restrictToRelationshipTypes="company" min="1" max="1">Company</ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="company" min="2">Companies</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="company" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="dancer" min="1"><div class='unit trimText'><label>Dancer<ifcount code="ca_entities" restrictToRelationshipTypes="dancer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="dancer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="performer" min="1"><div class='unit trimText'><label>Performer<ifcount code="ca_entities" restrictToRelationshipTypes="performer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="performer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="rehearsal_director" min="1"><div class='unit trimText'><label>Rehearsal Director<ifcount code="ca_entities" restrictToRelationshipTypes="rehearsal_director" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="rehearsal_director" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="rehearsal_assistant" min="1"><div class='unit trimText'><label>Rehearsal Assistant<ifcount code="ca_entities" restrictToRelationshipTypes="rehearsal_assistant" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="rehearsal_assistant" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="assistant_to_mr_morris" min="1"><div class='unit trimText'><label>Assistant<ifcount code="ca_entities" restrictToRelationshipTypes="assistant_to_mr_morris" min="2">s</ifcount> to Mr. Morris</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="assistant_to_mr_morris" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="stager" min="1"><div class='unit trimText'><label>Stager<ifcount code="ca_entities" restrictToRelationshipTypes="stager" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="stager" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}					
							
						
						
						</div>
					</div>
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.premiereDate', 'restrictToTypes' => array('work'), 'restrictToRelationshipTypes' => array('premiered'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Works Premiered</H3><div class='unit detailLinksGrid'>";
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Works Performed", "btn btn-default", "", "Browse", "works", array("facet" => "event_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
						}
					}
					
					if ($va_works = $t_item->get('ca_occurrences.related', array('sort' => 'ca_occurrences.premiereDate', 'restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
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
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Works Performed", "btn btn-default", "", "Browse", "works", array("facet" => "event_general_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
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
					<?php print caNavLink($this->request, "View All Media", "btn btn-default", "", "Browse", "objects", array("facet" => "event_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
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