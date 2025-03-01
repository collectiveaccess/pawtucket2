<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = caGetUserAccessValues($this->request);
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$va_collection_type_icons = $o_collections_config->get("collection_type_icons");
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	$vb_parent_special_collection = false;
	if($vn_top_level_collection_id){
		$t_parent_collection = new ca_collections($vn_top_level_collection_id);
		if($t_parent_collection->get("featured_collection", array("convertCodesToDisplayText" => true)) == "no"){
			$vb_parent_special_collection = true;
		}
	}
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
					<H2>{{{^ca_collections.preferred_labels.name}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6><br/></ifdef>}}}

					{{{<ifdef code="ca_collections.public_notes"><div class="unit"><p>^ca_collections.public_notes</p></div><br/></ifdef>}}}
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><p>^ca_collections.scopecontent</p></div><br/></ifdef>}}}
					
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
<?php
		# --- featured collections should have the original layout with images below
		# --- yes no values are switched
		if(($t_item->get("featured_collection", array("convertCodesToDisplayText" => true)) == "no") || $vb_parent_special_collection){
?>
			<div class="row">
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

<?php
	if($t_item->get("ca_objects", array("checkAccess" => $va_access_values))){
?>

			<div class="row">
				<br/>
				<div id="browseResultsDetailContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsDetailContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'collection_objects', array('search' => 'collection_id:'.$t_item->get('ca_collections.collection_id'), 'sort' => 'Rank', 'direction' => 'asc', 'showFilterPanel' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
//						jQuery('#browseResultsDetailContainer').jscroll({
//							autoTrigger: true,
//							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
//							padding: 20,
//							nextSelector: 'a.jscroll-next'
//						});
					});
					
				});
			</script>
<?php
	}
?>
<?php
		}else{
?>
			<div class="row">
				<div class="col-sm-3">
<?php
				print "<div class='collectionOverviewContainer'><div class='collectionsContainer'><div class='label'>".ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true)))." Overview</div>";
				print printOverviewLevel($this->request, array($t_item->get('ca_collections.collection_id')), $o_collections_config, 1, array("collection_type_icons" => $va_collection_type_icons));
				if($va_brand = $t_item->get('ca_collections.brand', array("returnAsArray" => true))){
					$vn_brand = $va_brand[0];
					print "<div style='margin-left:5px;'>".caNavLink($this->request, "Products", "", "", "Browse", "Products", array("facet" => "brand_facet", "id" => $vn_brand))."</div>";
				}
				print "</div><div style='clear:both;'><br/></div></div>";
?>
<script>						
	function scrollToDiv(divID){
		$("#level" + divID).parents().show();
		$("#level" + divID).show();
		$('html, body').animate({
			scrollTop: $("#collectionLevel" + divID).offset().top - 50
		}, 2000);
	}
	/* triggered by links in Collection Overview list output in estee/helpers/esteeHelpers.php and scrolls to items in Collection contents list output in estee/views/Collections/child_list_html.php */
</script>		
				</div>
				<div class="col-sm-9">
					<div class='collectionsContentsContainer'>
						<div class='label'><?php print ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true))); ?> Contents</div>
						<div id="collectionLoad"></div>
					</div>
<script>
	$(document).ready(function(){
		$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('show_objects' => true, 'collection_id' => $t_item->get("ca_collections.collection_id"))); ?>");
	});
</script>				
				</div>
			</div>
<?php
		}
?>
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
