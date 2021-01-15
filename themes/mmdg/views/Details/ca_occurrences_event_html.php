<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_rep_viewer = trim($this->getVar("representationViewer"));
				
				
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
			<div class="row">
				<div class='col-md-12 col-lg-12 text-center'>
					<H1>{{{^ca_occurrences.type_id}}}</H1>
					<H2>{{{^ca_occurrences.preferred_labels.name}}}</H2>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-12'>
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><div class='unit'><label>Venue<ifcount code="ca_occurrences.related" restrictToTypes="venue" min="2">s</ifcount></label><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter=", "><l>^ca_occurrences.preferred_labels.name</l></div></ifcount>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="musician" min="1"><div class='unit trimText'><label>Musician<ifcount code="ca_entities" restrictToRelationshipTypes="musician" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="musician" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="singer" min="1"><div class='unit trimText'><label>Singer<ifcount code="ca_entities" restrictToRelationshipTypes="singer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="singer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="dancer" min="1"><div class='unit trimText'><label>Dancer<ifcount code="ca_entities" restrictToRelationshipTypes="dancer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="dancer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_item->get('ca_occurrences.related', array('restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						foreach ($va_works as $va_work) {
							$va_related_list[$va_work['relationship_typename']][] = caDetailLink($this->request, $va_work['name'], '', 'ca_occurrences', $va_work['occurrence_id']);
						}
						print "<div class='unit'><H3>Works Performed</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							foreach($va_links as $vs_link){
								if($i == 0){
									print "<div class='row'>";
								}
								print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".$vs_link."</div></div>";
								$i++;
								if($i == 3){
									print "</div>";
									$i = 0;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<H3>Object<ifcount code="ca_objects" min="2">s</ifcount></H3>
				</div>
			</div>
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
</ifcount>}}}
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
		  maxHeight: 400
		});
	});
</script>