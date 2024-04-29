<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
	$va_access_values = caGetUserAccessValues($this->request);
	# --- if this is not a collection, get the id of the collection this record is part of -> this is used for downloading the top level finding aid
	$t_list = new ca_lists();
 	$vn_collection_type_id = $t_list->getItemIDFromList('collection_types', 'collection');
 	if($t_item->get("type_id") == $vn_collection_type_id){
 		$vn_collection_id = $t_item->get('ca_collections.collection_id');
 	}else{
 		$vn_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
 	}
 	
 	
 	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}

?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		<?php print caNavLink($this->request, "<i class='icon-undo2'></i><div class='small'>Back</div>", '', '', 'FindingAid', 'Collection/Index'); ?>
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class="row">
				<div class='col-sm-1 navLeftRight'>
					<div class="detailNavBgLeft">
						<?php print caNavLink($this->request, "<i class='icon-undo2'></i><div class='small'>Back</div>", '', '', 'FindingAid', 'Collection/Index'); ?>
					</div><!-- end detailNavBgLeft -->
				</div><!-- end col -->			
				<div class='col-sm-10 col-md-10 col-lg-10'>
					<div class="detailHead">
<?php
					print "<div class='leader'>".$t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))."</div>";
					print "<h2>".$t_item->get('ca_collections.preferred_labels')."</h2>";
					
?>
					</div><!-- end detailHead -->
				</div><!-- end col -->
				<div class='col-sm-1 navLeftRight'>
					<div class="detailNavBgRight"></div><!-- end detailNavBgLeft -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">		
				<div class='col-md-12 col-md-12 col-lg-12'>
					<hr class="divide">	
<?php

					print caNavLink($this->request, 'Download Finding Aid', 'faDownload', 'Detail', 'collections', $vn_collection_id.'/view/pdf/export_format/_pdf_ca_collections_summary');
					print "<div class='clearfix'></div>";					
?>
					{{{<ifdef code="ca_collections.parent_id"><div class='unit'><span class='label'>Part of: </span><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
<?php
					if ($vs_historical = $t_item->get('ca_collections.biogHist')) {
						print "<div class='unit'><span class='label'>Historical Note: </span>".$vs_historical."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.scopeContent')) {
						print "<div class='unit'><span class='label'>Scope and Content Note: </span>".$vs_scope."</div>";
					}
					if ($va_extent = $t_item->getWithTemplate('<ifdef code="^ca_collections.extent.extent_value"><unit delimiter=", ">^ca_collections.extent.extent_value ^ca_collections.extent.extent_units</unit></ifdef>')) {
						print "<div class='unit'><span class='label'>Extent: </span>".$va_extent."</div>";
					}					
					#if ($va_events = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('special_event', 'production'), 'delimiter' => ', '))) {
					#	print "<div class='unit'><span class='label'>Related Productions & Events: </span>".$va_events."</div>";
					#}
					
					if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))) {
?>
						<div class="collection-form"  >
							<div class="formOutline" style="position:relative;">
								<div class="form-group">
									<input type="text" id="searchfield" class="form-control" placeholder="Search within this collection" >
								</div>
								<button id="collectionSubmit" class="btn-search"><span class="icon-magnifier"></span></button>
							</div>
						</div>
					
						<div id='collectionSearch'></div>
					
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#collectionSubmit").click(function() {
									var searchstring = $('#searchfield');
									searchstring.focus();
									$("#collectionSearch").slideDown("200", function () {
										$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
										var s = escape("(ca_collections.parent_id:<?php print $vn_id; ?>) AND " + searchstring.val());
										jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('detailNav' => '0', 'openResultsInOverlay' => '0'), array('dontURLEncodeParameters' => false)); ?>", { search: s })
									});
								});
								$("#searchfield").keypress(function(e) {
									if(e.which == 13) {
									var searchstring = $('#searchfield');
									searchstring.focus();
										$("#collectionSearch").slideDown("200", function () {
											$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
											var s = escape("(ca_collections.parent_id:<?php print $vn_id; ?>) AND " + searchstring.val());
											jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('detailNav' => '0', 'openResultsInOverlay' => '0'), array('dontURLEncodeParameters' => false)); ?>", { search: s })
										});
									}
								});
								return false;
							});
						</script>
						<div class='clearfix'></div>					
<?php
					}
?>					
					
					<div class="row unit">
						<div class='col-sm-12'>
		<?php
					if ($vb_show_hierarchy_viewer) {	
		?>
						<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
						<script>
							$(document).ready(function(){
								$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
							})
						</script>
		<?php				
					}									
		?>				
						</div><!-- end col -->
					</div><!-- end row -->
			
				</div><!-- end col -->

			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div id="browseResultsContainer">
						<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
					</div><!-- end browseResultsContainer -->
				</div><!-- end col -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'openResultsInOverlay' => '1', 'sort' => 'Date', 'search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

			<script type='text/javascript'>
				jQuery(document).ready(function() {
					$('.trimText').readmore({
					  speed: 75,
					  maxHeight: 135
					});		
				});
			</script>
	</div><!-- end col -->
</div><!-- end row -->
