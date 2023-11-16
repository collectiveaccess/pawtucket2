<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$t_list_item = new ca_list_items($t_item->get("type_id"));
	$vs_type_idno = $t_list_item->get("idno");
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	# --- make back button link to parent collection record if on a child record and back button does not link to search results
	$vs_back_link = $this->getVar("resultsLink");
	if(($vn_top_level_collection_id != $t_item->get("ca_collections.collection_id")) && strpos(strToLower($vs_back_link), "collections/index")){
		$vs_back_link = caDetailLink($this->request, '<i class="fa fa-angle-double-left"></i><div class="small">Back</div>', '', 'ca_collections', $vn_top_level_collection_id);
	}
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}<?php print $vs_back_link; ?>{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}<?php print $vs_back_link; ?>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
<?php
					print '<div id="detailTools">';
					print "<div class='detailTool'><span class='glyphicon glyphicon-download'></span>".caDetailLink($this->request, "Finding Aid", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					print "<div class='detailTool'><span class='glyphicon glyphicon-book'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavURL($this->request, '', 'Contact', 'Form', array('table' => 'ca_collections', 'id' => $t_item->get("collection_id"), 'contactType' => 'askCurator'))."\"); return false;' title='"._t("Ask a Curator")."'>"._t("Ask a Curator")."</a></div><!-- end detailTool -->";
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
?>
					<H4><?php print trim($t_item->get("ca_collections.preferred_labels.name")); ?>{{{<ifdef code="ca_collections.collection_date2.collection_date_inclusive">, ^ca_collections.collection_date2.collection_date_inclusive</ifdef>}}}</H4>
<?php
					if(in_array($vs_type_idno, array("series", "file"))){
						print $t_item->getWithTemplate('<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></div></ifdef>');
					}
					
?>
					{{{<ifdef code="ca_collections.idno"><div class="unit">^ca_collections.idno</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.historical_note"><div class="unit"><H6>Historical Note</H6><div class="trimText">^ca_collections.historical_note</div></div></ifdef>}}}
					{{{<ifdef code="ca_collections.scope_content"><div class="unit"><H6>Scope and Content</H6><div class="trimText">^ca_collections.scope_content</div></div></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->
<?php
					if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.idno_sort'))) {
?>
						<div class="collection-form"  >
							<div class="formOutline">
								<div class="form-group" style="position:relative;">
									<input type="text" id="searchfield" class="form-control" placeholder="Search within this collection" >
									<button id="collectionSubmit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
								</div>
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
										var s = escape("(ca_collections.hier_collection_id:<?php print $t_item->get("ca_collections.collection_id"); ?>) AND " + searchstring.val());
										jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', null, array('dontURLEncodeParameters' => false)); ?>", { search: s }, function(response, status, xhr) {
											if(response){
												jQuery('#collectionSearch').jscroll({
													autoTrigger: true,
													loadingHtml: '<?php print addslashes(caBusyIndicatorIcon($this->request).' '._t('Loading...')); ?>',
													padding: 20,
													nextSelector: 'a.jscroll-next'
												});
											}else{
												$('#collectionSearch').html("<H6>Your search found no results</H6>");
											}
										});
									});
								});
								$("#searchfield").keypress(function(e) {
									if(e.which == 13) {
									var searchstring = $('#searchfield');
									searchstring.focus();
										$("#collectionSearch").slideDown("200", function () {
											$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
											var s = escape("(ca_collections.hier_collection_id:<?php print $t_item->get("ca_collections.collection_id"); ?>) AND " + searchstring.val());
											jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', null, array('dontURLEncodeParameters' => false)); ?>", { search: s }, function(response, status, xhr) {
												if(response){
													jQuery('#collectionSearch').jscroll({
														autoTrigger: true,
														loadingHtml: '<?php print addslashes(caBusyIndicatorIcon($this->request).' '._t('Loading...')); ?>',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												}else{
													$('#collectionSearch').html("<H6>Your search found no results</H6>");
												}
											});
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

			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'collection_facet', 'id' => $t_item->get('ca_collections.collection_id'), 'collectionDetail' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print addslashes(caBusyIndicatorIcon($this->request).' '._t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>

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
		  maxHeight: 180,
		  lessLink: '<a href="#">Show less</a>'
		});
	});
</script>
