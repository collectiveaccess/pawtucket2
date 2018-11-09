<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
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
<?php
				if($vs_rep = trim($this->getVar("representationViewer"))){
					print "<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>";
					print $vs_rep;
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
					print "</div>";
					print "<div class='col-sm-6 col-md-6 col-lg-5'>";
					
				}else{
					print "<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>";
				}
?>
					<H4>{{{<ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><i>^ca_occurrences.preferred_labels.name</i> ^ca_occurrences.vessuffix}}}</H4>
					
					{{{<ifdef code="ca_occurrences.othername"><div class="unit"><H6>Other Names</H6>
							<unit relativeTo="ca_occurrences.othername" delimiter=" "><if rule="^ca_occurrences.othername.othernametype =~ /ex/"><b>ex</b>: ^ca_occurrences.othername.othernametitle; </if></unit>
							<unit relativeTo="ca_occurrences.othername" delimiter=" "><if rule="^ca_occurrences.othername.othernametype =~ /later/"><b>later</b>: ^ca_occurrences.othername.othernametitle; </if></unit>
							<unit relativeTo="ca_occurrences.othername" delimiter=" "><ifnotdef code="ca_occurrences.othername.othernametype">^ca_occurrences.othername.othernametitle; </ifnotdef></unit>
						</div></ifdef>}}}
					{{{<ifcount code="ca_list_items" min="1"><div class="unit"><H6>Vessel Type</H6><unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.hierarchy.preferred_labels%delimiter=_»_</unit></div></ifcount>}}}
					{{{<ifdef code="ca_occurrences.con_vesseltype"><div class="unit"><H6>Converted From</H6><unit relativeTo="ca_occurrences.con_vesseltype" delimiter="<br/>">^ca_list_items.hierarchy.preferred_labels%delimiter=_»_</unit></div></ifdeft>}}}
					{{{<ifdef code="ca_occurrences.ship_date.ship_dates_value"><div class="unit"><H6>Ship Date<ifcount code="ca_occurrences.ship_date" min="2">s</ifcount></H6><unit relativeTo="ca_occurrences.ship_date" delimiter="<br/>"><ifdef code="ca_occurrences.ship_date.vessel_date_types"><b>^ca_occurrences.ship_date.vessel_date_types</b>: </ifdef>^ca_occurrences.ship_date.ship_dates_value</unit></div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="created" min="1"><div class="unit"><H6>Builder</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="created"><l>^ca_entities.preferred_labels</l></unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.vessel_description"><div class="unit"><H6>Vessel Description</H6>^ca_occurrences.vessel_description</div></ifdef>}}}
					{{{<ifcount min="1" code="ca_collections"><div class="unit"><H6>Related Collections</H6><unit relativeTo="ca_collections"><b>^ca_collections.type_id</b>: <l>^ca_collections.hierarchy.preferred_labels%delimiter=_»_</l></unit></div></ifcount>}}}
				
					{{{<ifcount code="ca_objects" restrictToTypes="collection_object" min="1"><div class="unit"><H6>Related Artefact<ifcount code="ca_objects" restrictToTypes="collection_object" min="2">s</ifcount></H6><unit relativeTo="ca_objects" restrictToTypes="collection_object" sort="ca_objects.preferred_labels" sortDirection="ASC" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l> (^ca_objects.idno)</unit></div></ifcount>}}}
					{{{<ifcount code="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" min="1"><div class="unit"><H6>Related Archival Item<ifcount code="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" min="2">s</ifcount></H6><unit relativeTo="ca_objects" restrictToTypes="archival_object, charts, maps, ship_plans" sort="ca_objects.GMD" sortDirection="ASC" delimiter="<br/>"><ifdef code="ca_objects.GMD"><b>^ca_objects.GMD</b>: </ifdef><l>^ca_objects.preferred_labels.name</l> (^ca_objects.idno)</unit></div></ifcount>}}}
				
<?php
				# Comment and Share Tools
				if (!$vs_rep && ($vn_comments_enabled | $vn_share_enabled)) {
						
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
				</div>
			</div>
			
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