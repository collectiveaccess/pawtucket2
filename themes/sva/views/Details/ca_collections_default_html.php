<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
 	$va_object_browse_info = caGetInfoForBrowseType("objects");
 	$va_views = $va_object_browse_info["views"];
 	$o_config = caGetBrowseConfig();
 	$va_view_icons = $o_config->getAssoc("views")	
?>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12 content'>
					
		<div class='objTitle'><?php print $t_item->get('ca_collections.preferred_labels'); ?></div>
<?php	
	if ($va_abstract = $t_item->get('ca_collections.abstract')) {	
		print "<h1>Abstract</h1>";
		print"<p>".$va_abstract."</p>";
	}
	print "<div style='width:100%;clear:both;height:1px;'></div>";

	if ($t_item->get('ca_collections.extent.extent_amount') != "") {	
		if ($va_extent = $t_item->get('ca_collections.extent', array('template' => '^extent_amount'))) {	
			print "<h1>Extent</h1>";
			print "<p>".$va_extent."</p>";
		}
	}
	print "<div style='width:100%;clear:both;height:1px;'></div>";
	
		if ($va_content = $t_item->get('ca_collections.hierarchy.preferred_labels', array('returnAsArray' => true, 'removeFirstItems' => 0))) {	
		$content_id = $t_item->get('ca_collections.hierarchy.collection_id', array('returnAsArray' => true, 'removeFirstItems' => 0));
		$va_content_array = array_combine($content_id, $va_content);
		print "<h1>Hierarchy</h1><ul>";
		foreach ($va_content_array as $id => $content) {
			print "<li>".caNavLink($this->request, $content, '', '', 'Detail', 'collections/'.$id)."</li>";
		}
	print "</ul><div style='width:100%;clear:both;height:1px;'></div>";
	}
	
	if ($va_content = $t_item->get('ca_collections.children.preferred_labels', array('returnAsArray' => true))) {	
		$content_id = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true));
		$va_content_array = array_combine($content_id, $va_content);
		natsort($va_content_array);
		print "<h1>Content</h1><ul>";
		foreach ($va_content_array as $id => $content) {
			print "<li>".caNavLink($this->request, $content, '', '', 'Detail', 'collections/'.$id)."</li>";
		}
	print "</ul><div style='width:100%;clear:both;height:1px;'></div>";
	}
	

	
	# --- entities
	$va_entities = $t_item->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
	$va_occurrences = $t_item->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
	$va_collections = $t_item->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno'));

	if ((sizeof($va_entities) > 0) | (sizeof($va_occurrences) > 0) ) {
?>
		<h1><?php print _t("Related"); ?></h1>
		<ul>
<?php
		if (sizeof($va_entities)) {
			foreach($va_entities as $va_entity) {
				print "<li>".caNavLink($this->request, $va_entity["label"], '', '', 'Detail', 'entities/'.$va_entity["entity_id"])."</li>\n";
			}
		}
		if (sizeof($va_occurrences)) {
			foreach($va_occurrences as $va_occurrence) {
				print "<li>".caNavLink($this->request, $va_occurrence["label"], '', '', 'Detail', 'occurrences/'.$va_occurrence["occurrence_id"])."</li>\n";
			}
		}
?>
		</ul>
<?php				
	}
?>					
				</div><!-- end col -->
			</div><!-- end row -->

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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

<script type="text/javascript"> 
		
		function loadResults(view) {
			jQuery("#browseResultsContainer").data('jscroll', null);
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:{{{^ca_collections.collection_id}}}'), array('dontURLEncodeParameters' => true)); ?>/view/" + view, function() {
				jQuery("#browseResultsContainer").jscroll({ 
					autoTrigger: true,
					loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
					padding: 20,
					nextSelector: "a.jscroll-next"
				});
			});
		}
</script>