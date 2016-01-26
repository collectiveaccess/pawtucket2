<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
					<H6>{{{^ca_occurrences.event_type}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
<?php
					if ($t_item->get('ca_occurrences.event_date')) {
						print "<div class='unit'><H6>Event Date</h6>".$t_item->get('ca_occurrences.event_date')."</div>";
					}
					if ($t_item->get('ca_occurrences.event_length')) {
						print "<div class='unit'><H6>Length of event</h6>".$t_item->get('ca_occurrences.event_length')."</div>";
					}
					if ($t_item->get('ca_occurrences.attendees')) {
						print "<div class='unit'><H6>Number of attendees</h6>".$t_item->get('ca_occurrences.attendees')."</div>";
					}
					if ($t_item->get('ca_occurrences.theme_topic')) {
						print "<div class='unit'><H6>Theme or topic of event</h6>".$t_item->get('ca_occurrences.theme_topic')."</div>";
					}
					if ($t_item->get('ca_occurrences.description')) {
						print "<div class='unit'><H6>Description</h6>".$t_item->get('ca_occurrences.description')."</div>";
					}
					if($t_item->get('ca_entities')){
						if ($va_participants = $t_item->get('ca_entities', array('template' => ' <unit relativeTo="ca_entities_x_occurrences"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>', 'delimiter' => '<br/>'))) {
							print "<div class='unit'><H6>Participants</h6>".$va_participants."</div>";
						}
					}
					if ($t_item->get('ca_occurrences.event_format')) {
						print "<div class='unit'><H6>Event Format</h6>".$t_item->get('ca_occurrences.event_format')."</div>";
					}																																			
?>	
					{{{map}}}	
<?php
					if ($t_item->get('ca_occurrences.coverageSpatial')) {
						print "<div class='unit'><H6>Location of Event</h6>".$t_item->get('ca_occurrences.coverageSpatial')."</div>";
					}
					$va_subjects_list = array();
					if ($va_subject_terms = $t_item->get('ca_collections.lcsh_terms', array('returnAsArray' => true))) {
						foreach ($va_subject_terms as $va_term => $va_subject_term) {
							$va_subject_term_list = explode('[', $va_subject_term);
							$va_subjects_list[] = ucfirst($va_subject_term_list[0]);
						}
					}
					if ($va_subject_terms_text = $t_item->get('ca_collections.lcsh_terms_text', array('returnAsArray' => true))) {
						foreach ($va_subject_terms_text as $va_text => $va_subject_term_text) {
							$va_subjects_list[] = ucfirst($va_subject_term_text);
						}
					}
					if ($va_subject_genres = $t_item->get('ca_collections.lcsh_genres', array('returnAsArray' => true))) {
						foreach ($va_subject_genres as $va_text => $va_subject_genre) {
							$va_subjects_list[] = ucfirst($va_subject_genre);
						}
					}											
					asort($va_subjects_list);
					if ($va_subjects_list) {
						print "<div class='unit'><h6>Subject - keywords and LC headings</h6>".join("<br/>", $va_subjects_list)."</div>";
					}					
?>							
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
<?php
					if ($va_related_entities = $t_item->getWithTemplate('<unit relativeTo="ca_occurrences_x_entities" delimiter="<br/>" ><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h6>Related Entities</h6>".$va_related_entities."</div>";
					}
?>
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->