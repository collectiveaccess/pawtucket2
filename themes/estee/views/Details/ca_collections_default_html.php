<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = caGetUserAccessValues($this->request);
	$ps_last_tab = $this->request->getParameter("last_tab", pString);	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$va_collection_type_icons = $o_collections_config->get("collection_type_icons");
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exporting finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	$vb_parent_special_collection = false;
	if($vn_top_level_collection_id){
		$t_parent_collection = new ca_collections($vn_top_level_collection_id);
		# --- yes no codes switched
		if($t_parent_collection->get("ca_collections.featured_collection", array("convertCodesToDisplayText" => true)) == "no"){
			$vb_parent_special_collection = true;
		}
	}
	if($va_brand = $t_item->get('ca_collections.brand', array("returnAsArray" => true))){
		$vn_brand = $va_brand[0];
	}
	$vs_brand_img = "";
	$vs_brand_description = "";
	if($vn_brand){
		$t_list_item = new ca_list_items();
		$t_list_item->load($vn_brand);
		$vs_brand_img = $t_list_item->get("ca_list_items.icon.large");
		if($vs_brand_img == "No media available"){
			$vs_brand_img = $t_list_item->get("ca_list_items.icon.square400");
		}
		$vs_brand_description = $t_list_item->get("ca_list_items.description");
	}
	$vs_related_featured_digital_collections = $t_item->getWithTemplate("<ifcount code='ca_collections.related' min='1'><unit relativeTo='ca_collections.related' delimiter=' '><if rule='^ca_collections.featured_collection =~ /no/'>
																			<div class='col-xs-12 col-sm-6 col-sm-offset-3'><div class='collectionTile'>
																				<div class='row collectionBlock'>
																					<div class='col-xs-12 col-sm-3'><div class='collectionGraphic'><l>^ca_object_representations.media.medium</l></div></div><!-- end col -->
																					<div class='col-xs-12 col-sm-8 collectionText'><div class='collectionTitle'><l>^ca_collections.preferred_labels.name</l></div>	
																					</div>
																				</div></div>
																			</div>
																		</if></unit></ifcount>");
	$o_context = new ResultContext($this->request, "ca_objects", 'detailrelated');
	$o_context->setAsLastFind();
	$o_context->saveContext();
	
	$ps_key = $this->request->getParameter("key", pString);

# --- featured collections should have the original layout with images below
# --- yes no values are switched
if(($t_item->get("featured_collection", array("convertCodesToDisplayText" => true)) == "no") || $vb_parent_special_collection){
?>
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6><br/></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">
				<div class='col-sm-12'><br/>
<?php
				print $t_item->getWithTemplate('<ifdef code="ca_collections.public_notes"><div class="unit"><p>^ca_collections.public_notes</p></div><br/></ifdef><ifdef code="ca_collections.scopecontent"><div class="unit"><p>^ca_collections.scopecontent</p></div><br/></ifdef>');
			
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

				<br/>
				<div id="browseResultsDetailContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsDetailContainer -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'collection_objects', array('search' => 'collection_id:'.$t_item->get('ca_collections.collection_id'), 'sort' => 'Date', 'direction' => 'asc', 'showFilterPanel' => 1, 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
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
}else{
?>
			<div class="row">
				<div class='col-md-12 col-lg-12'>
<?php
					if($vs_brand_img){
?>
					<div class="row">
						<div class='col-sm-4 col-sm-offset-4 collectionLogo text-center'>
							<h1><?php print $vs_brand_img; ?></h1>
							<!--{{{<ifdef code="ca_object_representations.media.medium"><h1>^ca_object_representations.media.medium</h1></ifdef>}}}-->
						</div>
					</div>
<?php
					}
					if($vs_brand_description){
?>
					<div class="row">
						<div class='col-sm-8 col-sm-offset-2'>
							<div class="unit"><p><?php print $vs_brand_description; ?></p></div>
						</div>
					</div>
<?php
					}
?>
					{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6><br/></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			# --- is there a collection chronology to show?
			$vb_show_collection_chronology = false;
			
			if($va_chronology = $t_item->get("ca_occurrences", array("restrictToTypes" => array("chronology"), "checkAccess" => $va_access_values))){
				$vb_show_collection_chronology = true;
			}
			# --- is there a collection guide to show?
			$vb_show_collection_guide = false;
			if($t_item->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values))){
				$vb_show_collection_guide = true;
			}
?>
				<br/>
			<div class="row">
				<div class='col-md-12 col-lg-12 tabModuleContent'>
					<article class="tabModuleContentInner float100">	
						<section class="tabsTitle float100">

							<ul role="tablist">
								<li role="presentation"<?php print ($ps_last_tab != "guide") ? ' class="active"' : ''; ?>><a href="#browse" aria-controls="Browse Items" role="tab" data-toggle="tab">Browse Items</a></li>
<?php
							if($vb_show_collection_guide){
?>
								<li role="presentation"<?php print ($ps_last_tab == "guide") ? ' class="active"' : ''; ?> id='collectionGuideTab'><a href="#guide" aria-controls="Collection Guide" role="tab" data-toggle="tab">Collection Guide</a></li>
<?php
							}
							if($vb_show_collection_chronology){
?>
								<li role="presentation"><a href="#chronology" aria-controls="Chronology" role="tab" data-toggle="tab">Chronology</a></li>
<?php
							}
							if($vs_related_featured_digital_collections){
?>
								<li role="presentation"><a href="#resources" aria-controls="Curated Resources" role="tab" data-toggle="tab">Curated Resources</a></li>
<?php
							}
?>
							</ul>
						</section>
						<section class="tabsContent tabsContentLessPadding float100">

							<div class="tab-content collectionTabs">
								<br/>
								<div role="tabpanel" class="tab-pane<?php print ($ps_last_tab != "guide") ? ' active' : ''; ?>" id="browse">
									<div id="browseResultsDetailContainer">
										<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
									</div><!-- end browseResultsDetailContainer -->
									<script type="text/javascript">
										jQuery(document).ready(function() {
											jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'brand_facet', 'id' => $vn_brand, 'showFilterPanel' => 1, 'view' => 'images', 'dontSetFind' => 1, 'sort' => 'Media', 'direction' => 'asc', 'key' => $ps_key), array('dontURLEncodeParameters' => true)); ?>", function() {
						//						jQuery('#browseResultsDetailContainer').jscroll({
						//							autoTrigger: true,
						//							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
						//							padding: 20,
						//							nextSelector: 'a.jscroll-next'
						//						});
											});
					
										});
									</script>
								</div>
<?php
						if($vb_show_collection_guide){
?>
								<div role="tabpanel" class="tab-pane<?php print ($ps_last_tab == "guide") ? ' active' : ''; ?>" id="guide">
									<div class="row">
										<div class="col-sm-12">
<?php
											print $t_item->getWithTemplate('<ifdef code="ca_collections.public_notes"><div class="unit"><p>^ca_collections.public_notes</p></div><br/></ifdef><ifdef code="ca_collections.scopecontent"><div class="unit"><p>^ca_collections.scopecontent</p></div><br/></ifdef>');
?>
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='detailTools'><div class='detailTool'><i class='material-icons inline'>save_alt</i>".caDetailLink($this->request, "Download Collection Guide", "", "ca_collections", $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div></div>";
					}
?>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class='collectionsContentsContainer'>
												<H2><?php print ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true))); ?> Contents</H2>
												<div id="collectionLoad"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
											</div>
										</div>
									</div>
								</div><!-- end tabpanel guide -->
<?php
						}
						if($vb_show_collection_chronology){
?>
								<div role="tabpanel" class="tab-pane" id="chronology">						
									<div id="browseCollectionContainer">
										<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
									</div><!-- end browseResultsContainer -->
									<script type="text/javascript">
										jQuery(document).ready(function() {
											jQuery("#browseCollectionContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'chronology', array('showChronologyFilters' => 1, 'facet' => 'collection_facet', 'id' => $t_item->get("ca_collections.collection_id"))); ?>");
					
					
										});
									</script>
						
								</div>
<?php
						}
						if($vs_related_featured_digital_collections){
?>
								<div role="tabpanel" class="tab-pane" id="resources">
									<div class="row collectionsList">						
<?php
									print $vs_related_featured_digital_collections;
?>
									</div>
								</div>
<?php
						}
?>			
							</div><!-- end tab-content-->
							<script type='text/javascript'>
								jQuery(document).ready(function() {
									//$('.collectionTabs a').click(function (e) {
									//	e.preventDefault()
									//	$(this).tab('show')
									//});

									var hash = document.location.hash;
									var prefix = "tab_";
									if (hash) {
										$('.tabsTitle a[href="'+hash.replace(prefix,"")+'"]').tab('show');
									} 

									// Change hash for page-reload
									$('.tabsTitle a').on('shown.bs.tab', function (e) {
										window.location.hash = e.target.hash.replace("#", "#" + prefix);
									});
								
									jQuery('#collectionGuideTab').on('click', loadCollectionGuide);
									
if(jQuery('#collectionGuideTab.active').length > 0) {
									$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('show_objects' => true, 'collection_id' => $t_item->get("ca_collections.collection_id"), 'row_id' => $this->request->getParameter('row_id', pInteger))); ?>");
}
								});
								
								function loadCollectionGuide() {									
									$(document).ready(function(){
										$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'Collections', 'childList', array('show_objects' => true, 'collection_id' => $t_item->get("ca_collections.collection_id"), 'row_id' => $this->request->getParameter('row_id', pInteger))); ?>");
									});
								}
								
							</script>
						</section>
					</article>

				</div>
			</div>
<?php
}
?>