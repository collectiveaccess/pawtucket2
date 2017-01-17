<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
?>
<div class="container">
<div class="row">
	<div class='col-xs-12 objNav'><!--- only shown at small screen size -->
		<div class='resultsLink'>{{{resultsLink}}}</div><div class='previousLink'>{{{previousLink}}}</div><div class='nextLink'>{{{nextLink}}}</div>
	</div><!-- end detailTop -->
</div>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
		print "<h6 class='leader'>Provenance</h6>";
		print "<h1>".$t_item->get('ca_collections.preferred_labels')."</h1>";
		if ($vs_remarks = $t_item->get('ca_collections.collection_notes')) {
			print "<div class='drawer' style='border-bottom:0px; padding-top:0px;'>";
			#print "<h6><a href='#' onclick='$(\"#remarksDiv\").toggle(400);return false;'>Remarks <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='remarksDiv'>{$vs_remarks}</div>";
			print "</div>";
		}
?>			
	</div><!-- end col -->
</div><!-- end row -->

{{{<ifcount code="ca_objects" relativeTo="ca_objects"  min="1">
	
	<div class="row"><div class='col-sm-12'>
	<hr>
		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
	</div><!-- end col --></div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'ca_collections.collection_id:^ca_collections.collection_id', 'detailNav' => 1, 'collection_id' => '^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
