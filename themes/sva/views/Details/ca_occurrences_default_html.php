<?php
	$t_occurrence = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	#$o_config = caGetBrowseConfig();
 	$va_object_browse_info = caGetInfoForBrowseType("objects");
 	$va_views = $va_object_browse_info["views"];
 	$o_config = caGetBrowseConfig();
 	$va_view_icons = $o_config->getAssoc("views")
?>
<div class="container">
	<div class="row">
		<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
			<div class='objTitle'>{{{^ca_occurrences.preferred_labels}}}</div>
	
<?php					
		if ($va_department = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('department'), 'checkAccess' => $va_access_values))) {
			print "<h1>Department</h1>";
			print "<p>".$va_department."</p>";
		}
		print "<div style='width:500px; clear:left;height:1px;'></div>";	
		if ($va_place = $t_occurrence->get('ca_places.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
			print "<h1>Location</h1>";
			print "<p>".$va_place."</p>";
		}
		print "<div style='width:500px; clear:left;height:1px;'></div>";	
		
		if ($va_dates = $t_occurrence->get('ca_occurrences.exhibition_dates.ex_dates_value')) {
			print "<h1>Dates</h1>";
			print "<p>".$t_occurrence->get('ca_occurrences.exhibition_dates', array('template' => '<span>^ex_dates_type</span><ifdef code="ex_dates_type">:</ifdef> ^ex_dates_value', 'convertCodesToDisplayText' => true,'delimiter' => '<br/>'))."</p>";
		} else if ($va_dates = $t_occurrence->get('ca_occurrences.date_as_text', array('delimiter' => '<br/>'))) {
			print "<h1>Dates</h1>";
			print "<p>".$va_dates."</p>";			
		} else {
			print "";
		}

		print "<div style='width:500px; clear:left;height:1px;'></div>";
		if ($va_curator = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('curator')))) {
			print "<h1>Curator</h1>";
			print "<p>".$va_curator."</p>";
		}

		print "<div style='width:500px; clear:left;height:1px;'></div>";	
		if ($va_instructor = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values, 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('instructor')))) {
			print "<h1>Instructors</h1>";
			print "<p>".$va_instructor."</p>";
		}
		print "<div style='width:500px; clear:left;height:1px;'></div>";
		if ($va_exhibitor = $t_occurrence->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('exhibitor')))) {
			print "<h1>Exhibitors</h1>";
			print "<p>".$va_exhibitor."</p>";
		}
		print "<div style='width:500px; clear:left;height:1px;'></div>";			
		if ($va_participants = $t_occurrence->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('participant'), 'delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
			print "<h1>Participants</h1>";
			print "<p>".$va_participants."</p>";
		}
		print "<div style='width:500px; clear:left;height:1px;'></div>";	

		if ($t_occurrence->get('ca_occurrences.description_public') != "") {
			print "<h1>Description</h1>";
			print "<p>".$t_occurrence->get('ca_occurrences.description_public', array('delimiter' => '<br/>'))."</p>";
		}
		print "<div style='width:500px; clear:left;height:1px;'></div>";	

		# --- entities
		$va_entities = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		$va_occurrences = $t_occurrence->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		$va_collections = $t_occurrence->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('collection')));

	if ((sizeof($va_occurrences) > 0 ) | (sizeof($va_collections) > 0 )) {	

?>
		<h1><?php print _t("Related"); ?></h1>
		<ul>
<?php
/*		foreach($va_entities as $va_entity) {
			print "<li>".caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"]))."</li>\n";
		} */
		foreach($va_occurrences as $va_occurrence) {
			print "<li>".caNavLink($this->request, $va_occurrence["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_occurrence["occurrence_id"]))."</li>\n";
		}
		foreach($va_collections as $va_collection) {
			print "<li>".caNavLink($this->request, $va_collection["label"], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection["collection_id"]))."</li>\n";
		}		
?>
		</ul>
<?php
	}

?>
			
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="bViewButtons">
<?php
					if(is_array($va_views) && (sizeof($va_views) > 1)){
						foreach($va_views as $vs_view => $va_view_info) {
?>
							<a href="#" onClick="loadResults('<?php print $vs_view; ?>'); return false;"><span class="glyphicon <?php print $va_view_icons[$vs_view]['icon']; ?>"></span></a>
<?php
						}
					}
?>
				</div>
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
	</div><!-- end row -->
</div><!-- end container -->

<script type="text/javascript">
		
		function loadResults(view) {
			jQuery("#browseResultsContainer").data('jscroll', null);
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:{{{^ca_occurrences.occurrence_id}}}'), array('dontURLEncodeParameters' => true)); ?>/view/" + view, function() {
				jQuery("#browseResultsContainer").jscroll({
					autoTrigger: true,
					loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
					padding: 20,
					nextSelector: "a.jscroll-next"
				});
			});
		}
</script>