<?php
	$t_item = $this->getVar("item");
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12'>
			<div class="row">
				<div class='col-sm-10'>
					<H1>
					<?php print caNavLink($this->request, "<i class='fa fa-arrow-left'></i> View all Flatfile Artists", "", "", "Listing", "flatfileArtists"); ?>
					<br/><span class="ltgrayText">Flatfile Artist</span>
					<br/>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					{{{<ifdef code="ca_entities.url"><H5><a href="^ca_entities.url" target="_blank">^ca_entities.url</a> <i class="fa fa-external-link"></i></H5></ifdef>}}}
				</div><!-- end col -->
				<div class='navLeftRight col-sm-2'>
					<div class="detailNavBgRight">
						{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
					</div><!-- end detailNavBgLeft -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1" max="1"><div class='col-sm-12'><H6>Related exhibition</H6></div></ifcount>}}}
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="2"><div class='col-sm-12'><H6>Related exhibitions</H6></div></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter=" "><div class='col-sm-6 col-md-4'><l>^ca_occurrences.preferred_labels.name<br/>^ca_occurrences.exhibition_dates</l><br/><br/></div></unit>}}}
			</div>
			<div class="row">				
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1" max="1"><div class='col-sm-12'><H6>Related event</H6></div></ifcount>}}}
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="2"><div class='col-sm-12'><H6>Related events</H6></div></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter=" "><div class='col-sm-6 col-md-4'><l>^ca_occurrences.preferred_labels.name<br/>^ca_occurrences.exhibition_dates</l><br/><br/></div></unit>}}}							
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
					<div id="detailTools">
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
				</div>
			</div>
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailembed' => 1, 'search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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