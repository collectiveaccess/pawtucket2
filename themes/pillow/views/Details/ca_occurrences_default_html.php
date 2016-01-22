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
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.notes"><H6>Description</H6>^ca_occurrences.description<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.premiere"><H6>Premiere</H6>^ca_occurrences.premiere<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.venue"><H6>Venue</H6>^ca_occurrences.venue<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.productionDate"><H6>Dates</H6>^ca_occurrences.productionDate<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.creationDate"><H6>Creation Date</H6>^ca_occurrences.creationDate<br/></ifdef>}}}
				
					{{{<ifdef code="ca_occurrences.description"><H6>Description</H6>^ca_occurrences.description<br/></ifdef>}}}  
	
					{{{<ifdef code="ca_occurrences.perfTiming"><H6>Duration</H6>^ca_occurrences.perfTiming<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.country_origin"><H6>Country of Origin</H6>^ca_occurrences.country_origin<br/></ifdef>}}}
					
					{{{<ifdef code="ca_occurrences.music"><H6>Music</H6>^ca_occurrences.music<br/></ifdef>}}}
					{{{<ifcount code="ca_occurrences.related.preferred_labels" restrictToTypes="work" min="1"><h6>Works Performed</h6><unit relativeTo="ca_occurrences.related" restrictToTypes="work" delimiter=', '><l>^ca_occurrences.preferred_labels</l></unit></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related.preferred_labels" restrictToTypes="production" min="1"><h6>Related Productions</h6><unit relativeTo="ca_occurrences.related" restrictToTypes="production" delimiter='<br/>'><l>^ca_occurrences.preferred_labels</l><ifdef code="ca_occurrences.productionDate">, ^ca_occurrences.productionDate</ifdef></unit></ifcount>}}}
					
					{{{<ifcount code="ca_entities.preferred_labels" restrictToRelationshipTypes="company" min="1"><h6>Related Company</h6><unit restrictToRelationshipTypes="company" relativeTo="ca_entities" delimiter='<br/>'><l>^ca_entities.preferred_labels</l></unit></ifcount>}}}
					{{{<ifcount code="ca_entities.preferred_labels" restrictToRelationshipTypes="dancer|musician|performer|speaker|participant" min="1"><h6>Related Performers</h6><unit relativeTo="ca_entities_x_occurrences" restrictToRelationshipTypes="dancer|musician|performer|speaker|participant" delimiter='<br/>'><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit></ifcount>}}}
					{{{<ifcount code="ca_entities.preferred_labels" excludeRelationshipTypes="company|dancer|musician|performer|principal_artist|writer|speaker|attendant|scholar|creator" min="1"><h6>Production Credits</h6><unit relativeTo="ca_entities_x_occurrences" excludeRelationshipTypes="company|dancer|musician|performer|principal_artist|writer|speaker|attendant|scholar|creator" delimiter='<br/>'><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit></ifcount>}}}
					
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					

					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}					
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