<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values =		caGetUserAccessValues($this->request);
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
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H6>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-8 col-lg-8'>
					{{{<ifcount code="ca_collections" min="1" max="1"><h4>Related collection</h4></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><h4>Related collections</h4></ifcount>}}}
					{{{<div class='unit'><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div>}}}
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H4>Related person</H4></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H4>Related people</H4></ifcount>}}}
					{{{<div class='unit'><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit></div>}}}
					
<?php
					$va_occurrence_list = array();
					if ($va_occurrences = $t_item->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						foreach ($va_occurrences as $va_key => $va_occurrence) {
							$t_occurrence = new ca_occurrences($va_occurrence);
							$vs_type = $t_occurrence->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true));
							$va_occurrence_list[$vs_type][] = caNavLink($this->request, $t_occurrence->get('ca_occurrences.preferred_labels'), '', '', 'Detail', 'occurrences/'.$va_occurrence);
						}
					}
					foreach ($va_occurrence_list as $va_type => $va_occurrence_list_item) {
						print "<div class='unit'><h4>Related ".$va_type."</h4>";
						foreach ($va_occurrence_list_item as $va_key => $va_occurrence_list_item_link) {
							print $va_occurrence_list_item_link."<br/>";
						}
						print "</div>";
					}
?>				
				<!--
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div>
					<div id='detailComments'>{{{itemComments}}}</div>
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div>
				</div>
				-->
					
				</div><!-- end col -->
				<div class='col-md-4 col-lg-4'>
					{{{<ifdef code="ca_entities.biography"><H6>Biography</H6>^ca_entities.biography<br/></ifdef>}}}
	
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
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->