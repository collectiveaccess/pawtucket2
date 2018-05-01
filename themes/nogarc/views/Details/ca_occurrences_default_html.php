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
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
					<h6>{{{^ca_occurrences.type_id}}}</h6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($vs_bib_citation = $t_item->get('ca_occurrences.bib_full_citation')) {
						print "<div class='unit'><h6>Full Citation</h6>".$vs_bib_citation."</div>";
					}
					if ($vs_citation_format = $t_item->get('ca_occurrences.citation_format', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Citation Format</h6>".$vs_citation_format."</div>";
					}
					if ($vs_bib_subtitle = $t_item->get('ca_occurrences.bib_subtitle')) {
						print "<div class='unit'><h6>Bib Subtitle</h6>".$vs_bib_subtitle."</div>";
					}
					if ($vs_bib_series = $t_item->get('ca_occurrences.bib_series')) {
						print "<div class='unit'><h6>Bib Series</h6>".$vs_bib_series."</div>";
					}
					if ($vs_bib_journal = $t_item->get('ca_occurrences.bib_journal')) {
						print "<div class='unit'><h6>Bib Journal</h6>".$vs_bib_journal."</div>";
					}
					if ($vs_edition = $t_item->get('ca_occurrences.edition')) {
						print "<div class='unit'><h6>Edition</h6>".$vs_edition."</div>";
					}
					if ($vs_bib_volume = $t_item->get('ca_occurrences.bib_volume')) {
						print "<div class='unit'><h6>Volume</h6>".$vs_bib_volume."</div>";
					}
					if ($vs_bib_language = $t_item->get('ca_occurrences.bib_language', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Language</h6>".$vs_bib_language."</div>";
					}
					if ($vs_pages = $t_item->get('ca_occurrences.bib_number_of_pages')) {
						print "<div class='unit'><h6>Number of Pages</h6>".$vs_pages."</div>";
					}
					if ($vs_place = $t_item->get('ca_occurrences.bib_place_published')) {
						print "<div class='unit'><h6>Place Published</h6>".$vs_place."</div>";
					}
					if ($vs_year = $t_item->get('ca_occurrences.bib_year_published')) {
						print "<div class='unit'><h6>Year Published</h6>".$vs_year."</div>";
					}																																													
					if ($vs_exhibition_type = $t_item->get('ca_occurrences.exhibition_category', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Exhibition Type</h6>".$vs_exhibition_type."</div>";
					}
					if ($t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true)) == "Exhibition") {
						if ($vs_date = $t_item->get('ca_occurrences.date.display_date')) {
							print "<div class='unit'><h6>Exhibition Dates</h6>".$vs_date."</div>";
						}
					}
					if ($va_curator = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('curator'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Curator</h6>".$va_curator."</div>";
					}					
					if ($vs_venues = $t_item->get('ca_occurrences.travel_venues')) {
						print "<div class='unit'><h6>Travel Venues</h6>".$vs_venues."</div>";
					}
					if ($va_prim_venues = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('primary_venue'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Primary Venue</h6>".$va_prim_venues."</div>";
					}					
					if ($va_venues = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('travel_venue'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Travel Venues</h6>".$va_venues."</div>";
					}
																				
?>		
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_bib_media = $t_item->get('ca_objects.object_id', array('restrictToRelationshipTypes' => array('depicts'), 'checkAccess' => $va_access_values, 'returnAsArray' => true))) {
						foreach ($va_bib_media as $va_key => $va_bib_media_id) {
							$t_bib = new ca_objects($va_bib_media_id);
							print "<div>".caDetailLink($this->request, $t_bib->get('ca_object_representations.media.medium'), '', 'ca_objects', $t_bib->get('ca_objects.object_id'))."</div>";
							print "<p>".caDetailLink($this->request, $t_bib->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_bib->get('ca_objects.object_id'))."</p>";
						}
					}
					if ($vs_bib_notes = $t_item->get('ca_occurrences.bib_notes')) {
						print "<div class='unit'><h6>Bibliographic Notes</h6>".$vs_bib_notes."</div>";
					}
					if ($va_bibliography = $t_item->get('ca_occurrences.related.preferred_labels', array('restrictToTypes' => array('bibliography'), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
						print "<div class='unit'><h6>Related Bibliography</h6>".$va_bibliography."</div>";
					}
					$va_entities_array = array();
					if ($va_entities = $t_item->get('ca_entities', array('returnWithStructure' => true))) {
						foreach ($va_entities as $va_key => $va_entity) {
							$va_entities_array[$va_entity['relationship_typename']][] = caNavLink($this->request, $va_entity['displayname'], '', '', 'Detail', 'entities/'.$va_entity['entity_id']);
						}
					}
					foreach ($va_entities_array as $va_typename => $va_entity_list) {
						print "<h6>".ucfirst($va_typename)."</h6>";
						foreach ($va_entity_list as $va_key => $va_entity_link) {
							print "<p>".$va_entity_link."</p>";
						}
					}
					if ($vs_published = $t_item->get('ca_occurrences.published_on')) {
						print "<div class='unit'><h6>Published On</h6>".$vs_published."</div>";
					}
					if ($vs_updated = $t_item->get('ca_occurrences.last_updated_on')) {
						print "<div class='unit'><h6>Last Updated</h6>".$vs_updated."</div>";
					}					
?>				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1" restrictToRelationshipTypes="describes,part,reference">
				<hr>
				<h6>Associated Works</h6>			
			<div class="row">

				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'allworks', array('search' => 'ca_occurrences.occurrence_id|describes,part,reference:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() { 
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