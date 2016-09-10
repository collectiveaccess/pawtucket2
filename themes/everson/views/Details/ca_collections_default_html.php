<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php
			if ($vb_show_hierarchy_viewer) {	
?>
				<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
				<script>
					$(document).ready(function(){
						$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
					})
				</script>
<?php				
			}									
?>				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_creator = $t_item->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToRelationshipTypes' => array('creator'), 'delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Creator</h6>".$va_creator."</div>";
					}
					if ($va_scope = $t_item->get('ca_collections.physical_content.scope_content')) {
						print "<div class='unit'><h6>Scope & Content</h6>".$va_scope."</div>";
					}
					if ($va_dates = $t_item->get('ca_collections.archive_dates.archive_display')) {
						print "<div class='unit'><h6>Dates</h6>".$va_dates."</div>";
					}
					if ($va_extent = $t_item->get('ca_collections.extent')) {
						print "<div class='unit'><h6>Physical Extent</h6>".$va_extent."</div>";
					}
					if ($va_language = $t_item->get('ca_collections.language', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
						print "<div class='unit'><h6>Language</h6>".$va_language."</div>";
					}
					if ($va_arrangement = $t_item->get('ca_collections.arrangement')) {
						print "<div class='unit'><h6>Arrangement</h6>".$va_arrangement."</div>";
					}	
					if ($va_terms = $t_item->getWithTemplate('<unit><b>Reproduction</b> ^ca_collections.reproRestrictions.reproduction <br/><b>Access</b> ^ca_collections.reproRestrictions.access_restrictions</unit>')) {
						print "<div class='unit'><h6>Terms of Use</h6>".$va_terms."</div>";
					}
					if ($va_finding = $t_item->get('ca_collections.finding_aid')) {
						print "<div class='unit'><h6>Finding Aid</h6>".$va_finding."</div>";
					}																								
?>
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_collections = $t_item->get('ca_collections.related', array('returnWithStructure' => true))) {
						print "<div class='unit'><h6>Related Collections</h6>";
						foreach ($va_collections as $va_id => $va_collection) {
							print "<div>".caNavLink($this->request, $va_collection['label'], '', 'Detail', 'collections', $va_collection['collection_id'])." (".$va_collection['relationship_typename'].")</div>";
						}
						print "</div>";
					}
?>
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related entity</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related entities</H6></ifcount>}}}
					{{{<div class='trimText'><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div>}}}
					
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related exhibition</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related exhibitions</H6></ifcount>}}}
					{{{<div class='trimText'><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<div class='trimText'><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit></div>}}}					
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
