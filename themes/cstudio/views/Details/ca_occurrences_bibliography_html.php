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
				<div class='col-md-12'>
					<H1>{{{<ifdef code='ca_occurrences.lit_citation'>^ca_occurrences.lit_citation</ifdef><ifnotdef code='ca_occurrences.lit_citation'>^ca_occurrences.preferred_labels.name</ifnotdef>}}}</H1>
				</div>
			</div>
			<div class="row">
				<div class='col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.pubType"><div class="unit"><label>Type</label>^ca_occurrences.pubType%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.idno"><div class="unit"><label>Identifier</label>^ca_occurrences.idno</div></ifdef>}}}
					
				</div>
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="author,editor">
						<ifcount code="ca_entities" min="1" max="1" excludeRelationshipTypes="author,editor"><label>Related person</label></ifcount>
						<ifcount code="ca_entities" min="2" excludeRelationshipTypes="author,editor"><label>Related people</label></ifcount>
						<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="author,editor"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
					</ifcount>}}}
					{{{<ifcount code="ca_places" min="1"><div class="unit"><label>Related place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br/>">^ca_places.preferred_labels.name (^relationship_typename)</unit></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="bibliography"><div class="unit"><label>Bibliography</label><unit relativeTo="ca_occurrences.related" restrictToTypes="bibliography" delimiter="<br/><br/>"><l><ifdef code='ca_occurrences.lit_citation'>^ca_occurrences.lit_citation</ifdef><ifnotdef code='ca_occurrences.lit_citation'>^ca_occurrences.preferred_labels.name</ifnotdef></l></unit></div></ifcount>}}}
				
					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="exhibition_project"><div class="unit"><label>Exhibitions/Projects/Events</label><unit relativeTo="ca_occurrences.related" restrictToTypes="exhibition_project" delimiter="<br/><br/>"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.date">, ^ca_occurrences.date</ifdef></l></unit></div></ifcount>}}}
				
				</div>
			</div>
			<div class="row">
				<div class='col-md-12'>	
					
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1" restrictToTypes="artwork">
			<div class="row">
				<div class="col-sm-12">
					<H2>Artwork</H2>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artwork', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>