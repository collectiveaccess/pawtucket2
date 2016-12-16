<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div id="page-name">
	<h1 id="archives" class="title">Bibliography</h1>
</div>
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
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($vs_exhibition_type = $t_item->get('ca_occurrences.exhibition_category', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Exhibition Type</h6>".$vs_exhibition_type."</div>";
					}
					if ($vs_date = $t_item->get('ca_occurrences.date.display_date')) {
						print "<div class='unit'><h6>Exhibition Dates</h6>".$vs_date."</div>";
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
					if ($va_bibliography = $t_item->get('ca_occurrences.related.preferred_labels', array('restrictToTypes' => array('bibliography'), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
						print "<div class='unit'><h6>Related Bibliography</h6>".$va_bibliography."</div>";
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