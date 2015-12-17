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
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H6>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifcount min="1" code="ca_entities.nonpreferred_labels"><h6>Alternate Names: </h6><unit>^ca_entities.nonpreferred_labels.displayname</unit></ifcount>}}}
					{{{<ifcount min="1" code="ca_entities.entity_date"><ifdef code="ca_entities.entity_date.ent_date_value"><h6>Dates</h6><unit delimiter="<br/>">^ca_entities.entity_date.ent_date_value ^ca_entities.entity_date.ent_dates_types</unit></ifdef></ifcount>}}}
					
					{{{<ifdef code="ca_entities.biography"><H6>Biography</H6>^ca_entities.biography<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.biography_source"><H6>Source of Biography</H6>^ca_entities.biography_source<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.pillow_significance"><H6>Pillow Significance</H6>^ca_entities.pillow_significance<br/></ifdef>}}}
					
					{{{<ifcount code="ca_objects" min="1" max="1"><H6>Related object</H6><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}
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
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="production"><H6>Related Productions</H6><div class='trimText'><unit relativeTo="ca_occurrences" sort="ca_occurrence_labels.name" restrictToTypes="production" delimiter="<br/>"><unit relativeTo="ca_entities_x_occurrences"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></unit></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="work"><H6>Related Works</H6><div class='trimText'><unit relativeTo="ca_occurrences" restrictToTypes="work" sort="ca_occurrence_labels.name" delimiter="<br/>"><unit relativeTo="ca_entities_x_occurrences"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></unit></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="event"><H6>Related Events</H6><div class='trimText'><unit relativeTo="ca_occurrences" restrictToTypes="event" sort="ca_occurrence_labels.name" delimiter="<br/>"><unit relativeTo="ca_entities_x_occurrences"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></unit></div></ifcount>}}}
					
			
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