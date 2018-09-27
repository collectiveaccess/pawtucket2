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
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<HR/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
	$va_chron_entry = array_shift($t_item->get("ca_occurrences.chronology", array("returnWithStructure" => 1)));
	if(is_array($va_chron_entry)){
		$va_chron_text_grouped_by_date = array();
		foreach($va_chron_entry as $k => $va_chron_info){
			$va_chron_text_grouped_by_date[$va_chron_info["chronology_date_sort_"]][] = "<div class='unit'><H5>".$va_chron_info["chronology_date"]."</H5>".$va_chron_info["chronology_text"]."</div>";
			ksort($va_chron_text_grouped_by_date);
		}
		print "<H5>Events</H5>";
		foreach($va_chron_text_grouped_by_date as $vn_sort_date => $va_chron_text_by_date){
			print join("\n", $va_chron_text_by_date);
		}
	}
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
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_entities" min="1" max="1"><H5>Related person</H5></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H5>Related people</H5></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1" max="1" restrictToTypes="exhibition"><H5>Exhibition</H5></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2" restrictToTypes="exhibition"><H5>Exhibitions</H5></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" restrictToTypes="exhibition" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l><br/><ifdef code="ca_occurrences.common_date">^ca_occurrences.common_date</ifdef><ifcount code="ca_entities" min="1" restrictToRelationshipTypes="originator">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="originator" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></ifcount></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H5>Location</H5></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H5>Locations</H5></ifcount>}}}
					{{{<ifcount code="ca_places" min="1" restrictToRelationshipTypes="home"><div class="unit"><h6>Home</h6><unit relativeTo="ca_places" delimiter="<br/>" restrictToRelationshipTypes="home">^ca_places.preferred_labels.name</unit></div></ifcount>}}}
					{{{<ifcount code="ca_places" min="1" restrictToRelationshipTypes="studio"><div class="unit"><h6>Studio</h6><unit relativeTo="ca_places" delimiter="<br/>" restrictToRelationshipTypes="studio">^ca_places.preferred_labels.name</unit></div></ifcount>}}}					
					{{{<ifcount code="ca_places" min="1" restrictToRelationshipTypes="travel"><div class="unit"><h6>Travel</h6><unit relativeTo="ca_places" delimiter="<br/>" restrictToRelationshipTypes="travel">^ca_places.preferred_labels.name</unit></div></ifcount>}}}					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<br/><hr/><br/><H5>Related Items</H5>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'occurrence_facet', 'id' => '^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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