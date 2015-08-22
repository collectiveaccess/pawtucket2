<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
 	$va_object_browse_info = caGetInfoForBrowseType("objects");
 	$va_views = $va_object_browse_info["views"];
 	$o_config = caGetBrowseConfig();
 	$va_view_icons = $o_config->getAssoc("views")
?>
<div class="row">
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">			
					
				<div class='col-md-6 col-lg-6'>
<?php
					$va_related_objects = $t_item->get('ca_objects.object_id', array('returnAsArray' => true));
					$vn_related_id = $va_related_objects[0];
					$t_object = new ca_objects($vn_related_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('small'), null, array('return_with_access' => $va_access_values));
					if ($va_reps['tags']['small']) {
						print "<div class='detailImage'>".$va_reps['tags']['small']."</div>";
					} else {
						print "<div class='detailPlaceholder'></div>";
					}

?>						
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					<H6>{{{^ca_entities.type_id}}}</H6>				
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
<?php			
					if ($va_bio = $t_item->get('ca_entities.biography',array('convertLineBreaks' => true))) {	
						print "<h6>Biographical Note</h6>";
						print"<p>".$va_bio."</p>";
					}
					if ($t_item->get('ca_entities.external_link.url_entry')) {
						if (($t_item->get('ca_entities.external_link.url_entry')) && ($t_item->get('ca_entities.external_link.url_source'))) {
							print "<div class='unit'><h6>Website</h6><p><a href='".$t_item->get('ca_entities.external_link.url_entry')."' target='_blank'>".$t_item->get('ca_entities.external_link.url_source')."</a></p></div>";
						} else {
							print "<div class='unit'><h6>Website</h6><p><a href='".$t_item->get('ca_entities.external_link.url_entry')."' target='_blank'>".$t_item->get('ca_entities.external_link.url_entry')."</a></p></div>";
						}
					}
					if ($t_item->get('ca_occurrences.occurrence_id')) {
					
					}
?>
					{{{<ifcount code="ca_objects" min="1" max="1"><H6>Related object</H6><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}
				
					{{{<ifcount code="ca_collections" restrictToTypes="collection" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" restrictToTypes="collection" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" restrictToTypes="collection" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities.related" restrictToTypes="department" min="1" max="1"><H6>Related department</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" restrictToTypes="department" min="2"><H6>Related departments</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToTypes="department" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}

					{{{<ifcount code="ca_occurrences" restrictToTypes="exhibitions" min="1" ><H6>Related Exhibitions</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" restrictToTypes="exhibitions" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" restrictToTypes="events" min="1" ><H6>Related Events</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" restrictToTypes="events" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit>}}}
										

					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="bViewButtons">
<?php
					if(is_array($va_views) && (sizeof($va_views) > 1)){
						foreach($va_views as $vs_view => $va_view_info) {
?>
							<a href="#" onClick="loadResults('<?php print $vs_view; ?>'); return false;"><span class="glyphicon <?php print $va_view_icons[$vs_view]['icon']; ?>"></span></a>
<?php
						}
					}
?>
				</div>
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

<script type="text/javascript">
		
		function loadResults(view) {
			jQuery("#browseResultsContainer").data('jscroll', null);
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:{{{^ca_entities.entity_id}}}'), array('dontURLEncodeParameters' => true)); ?>/view/" + view, function() {
				jQuery("#browseResultsContainer").jscroll({
					autoTrigger: true,
					loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
					padding: 20,
					nextSelector: "a.jscroll-next"
				});
			});
		}
</script>