<?php
	$va_access_values = caGetUserAccessValues($this->request);
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
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>

					{{{<ifdef code="ca_entities.entity_bio"><div class='unit'><H6>Biography / Administrative History</H6>^ca_entities.entity_bio</div></ifdef>}}}
					{{{<ifcount min="1" code="ca_collections"><div class="unit"><H6>Related Collections</H6><unit relativeTo="ca_collections" delimiter="<br/>"><b>^ca_collections.type_id</b>: <l>^ca_collections.hierarchy.preferred_labels%delimiter=_»_</l></unit></div></ifcount>}}}
					{{{<ifcount code="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" min="1"><div class="unit"><H6>Related Archival Item<ifcount code="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" min="2">s</ifcount></H6><unit relativeTo="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" sort="ca_objects.GMD" sortDirection="ASC" delimiter="<br/>"><ifdef code="ca_objects.GMD"><b>^ca_objects.GMD</b>: </ifdef><l>^ca_objects.preferred_labels.name</l> <ifdef code="ca_objects.idno">(^ca_objects.idno)</ifdef></unit></div></ifcount>}}}
					{{{<ifcount code="ca_objects" restrictToTypes="collection_object" min="1"><div class="unit"><H6>Related Artifact<ifcount code="ca_objects" restrictToTypes="collection_object" min="2">s</ifcount></H6><unit relativeTo="ca_objects" restrictToTypes="collection_object" sort="ca_objects.preferred_labels" sortDirection="ASC" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l> <ifdef code="ca_objects.idno">(^ca_objects.idno)</ifdef></unit></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" restrictToTypes="vessel" min="1">
					<div class="unit">
						<H6>Related vessels</H6><unit relativeTo="ca_occurrences" restrictToTypes="vessel" delimiter="<br/>"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><l><i>^ca_occurrences.preferred_labels</i></l> ^ca_occurrences.vessuffix</unit>
					</div></ifcount>}}}
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
				</div><!-- end col -->
			</div><!-- end row -->
			

		</div><!-- end container -->
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