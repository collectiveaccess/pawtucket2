<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
				<div class='col-md-6 col-lg-6'>
					<div class='map'>{{{map}}}</div>
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					<H4>{{{^ca_places.preferred_labels.name}}}</H4>
					<H5>{{{^ca_places.type_id}}}</H5>	
<?php
					if ($va_description = $t_item->get('ca_places.description')) {
						print "<div class='unit'><h8>Description</h8>".$va_description."</div>";
					}
					if ($va_tgn = $t_item->get('ca_places.tgn', array('delimiter' => ', '))) {
						print "<div class='unit'><h8>Getty Thesaurus of Geographic Names</h8>".$va_tgn."</div>";
					}
					if ($va_entities = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Entities</h8>".$va_entities."</div>";
					}
					if ($va_collections = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Collections</h8>".$va_collections."</div>";
					}
					if ($va_events = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><h8>Related Events</h8>".$va_events."</div>";
					}										
?>													
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print "Loading..."; ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'place_id:^ca_places.place_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print "Loading..."; ?>',
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