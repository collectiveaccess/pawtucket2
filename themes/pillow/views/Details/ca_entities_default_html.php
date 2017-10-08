<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>

				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">	 		
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<H6>{{{^ca_entities.type_id}}}</H6>
					{{{<ifcount min="1" code="ca_entities.nonpreferred_labels"><h6>Alternate Names: </h6><unit>^ca_entities.nonpreferred_labels.displayname</unit></ifcount>}}}
					{{{<ifcount min="1" code="ca_entities.entity_date"><ifdef code="ca_entities.entity_date.ent_date_value"><h6>Dates</h6><unit delimiter="<br/>">^ca_entities.entity_date.ent_date_value ^ca_entities.entity_date.ent_dates_types</unit></ifdef></ifcount>}}}
					
					{{{<ifdef code="ca_entities.biography"><H6>Biography</H6>^ca_entities.biography<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.biography_source"><H6>Source of Biography</H6>^ca_entities.biography_source<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.pillow_significance"><H6>Pillow Significance</H6>^ca_entities.pillow_significance<br/></ifdef>}}}
					
					<!-- {{{<ifcount code="ca_objects" min="1" max="1"><H6>Related object</H6><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}-->
					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="production">
						<H6>Related Productions</H6>
						<div class='trimText'>
							<unit relativeTo="ca_occurrences" restrictToTypes="production" delimiter="<br/>" sort="ca_occurrences.preferred_labels.name_sort">
								<l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)
							</unit>
						</div>
					</ifcount>}}}
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
<?php
					if ($va_related_entity = $t_item->get('ca_entities.related.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit'><h6>Related Entities</h6>".$va_related_entity."</div>";
					}
?>

					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="work">
						<H6>Related Works</H6>
						<div class='trimText'>
							<unit relativeTo="ca_occurrences" restrictToTypes="work" delimiter="<br/>" sort="ca_occurrences.preferred_labels.name_sort">
								<l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)
							</unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="event">
						<H6>Related Events</H6>
						<div class='trimText'>
							<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter="<br/>" sort="ca_occurrences.preferred_labels.name_sort">
								<l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)
							</unit>
						</div>
					</ifcount>}}}										
					
			
				</div><!-- end col --> 
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
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
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					$('.trimText').readmore({
					  speed: 75,
					  maxHeight: 120
					});
				});
			</script>	
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->