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
		<div class="col-xs-1"><div class='previousLink'>{{{previousLink}}}</div></div>
		<div class="col-xs-10">

<div class="container">
	<div class="row detailHead">
		<div class='col-xs-10 objNav'><!--- only shown at small screen size -->
			<div class='resultsLink'>{{{resultsLink}}}</div>
		</div>
	</div>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='padding-bottom:35px;'>
<?php
		print "<h6 class='leader'>Provenance</h6>";
		print "<h1>".$t_item->get('ca_collections.preferred_labels')."</h1>";
		
		if ($va_places = $t_item->get('ca_places.hierarchy.preferred_labels', array('returnWithStructure' => true))) {
			$va_place_list = array_reverse(array_pop($va_places));
			$va_place_output = array();
			foreach ($va_place_list as $va_key => $va_place_ids) {
				foreach ($va_place_ids as $va_key => $va_place_id_t) {
					foreach ($va_place_id_t as $va_key => $va_place_name) {
						$va_place_output[] = caNavLink($this->request, $va_place_name, '', 'Search', 'provenance', 'search/location', ["values" => [$va_place_name]]);
					}
				}
			}
		}
		if (sizeof($va_place_output) > 0) {
			print "<div class='unit borderless'>".join(', ', $va_place_output)."</div>";
		}		
		
		if ($vs_remarks = $t_item->get('ca_collections.collection_notes')) {
			print "<div class='col-sm-12 col-md-6 collectionText'>";
			#print "<h6><a href='#' onclick='$(\"#remarksDiv\").toggle(400);return false;'>Remarks <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div class='trimText'>{$vs_remarks}</div>";
			print "</div>";
		}
?>			
	</div><!-- end col -->
</div><!-- end row -->

{{{<ifcount code="ca_objects" relativeTo="ca_objects"  min="1">
	
	<div class="row"><div class='col-sm-12'>
	<hr style='margin-left:-5x;margin-right:-5px;'>
		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
	</div><!-- end col --></div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'worksInCollection', array('facet' => 'collection', 'id' => '^ca_collections.collection_id', 'detailNav' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
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
			</div>
			<div class="col-xs-1"><div class='nextLink'>{{{nextLink}}}</div></div>
		</div><!-- end row -->
	</div><!-- end container -->
	
	
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 318,
		  moreLink: '<a href="#">More</a>',
		});

        tronicTheToggles();
	});
</script>	
