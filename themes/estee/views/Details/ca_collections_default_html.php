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
		# --- yes no codes switched
		if($t_parent_collection->get("ca_collections.featured_collection", array("convertCodesToDisplayText" => true)) == "no"){
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
<?php
					print caNavLink($this->request, '<span class="glyphicon glyphicon-eye-open"></span> &nbsp;View all available digital archival media in this collection', '', '', 'Search','objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id").' and ca_object_representations.mimetype:*'));
?>					
				</div><!-- end col -->
			</div><!-- end row -->
<?php
		# --- featured collections should have the original layout with images below
		# --- yes no values are switched
		if(($t_item->get("featured_collection", array("convertCodesToDisplayText" => true)) == "no") || $vb_parent_special_collection){
?>
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
			# --- is there a collection chronology to show?
			$vb_show_collection_chronology = false;
			$va_chronology = array_pop($t_item->get("ca_collections.collection_chronology", array("returnWithStructure" => true, "convertCodesToDisplayText" => true)));
			$va_chronology_processed = array();
			if(is_array($va_chronology) && sizeof($va_chronology)){
				foreach($va_chronology as $va_entry){
					if($va_entry["chronology_public"] == "yes"){
						$va_tmp = explode("/", $va_entry["chronology_date_sort_"]);
						$va_chronology_processed[$va_tmp[0]] = array("date" => $va_entry["chronology_date"], "season" => $va_entry["chronology_season"], "text" => $va_entry["chronology_text"], "source" => $va_entry["chronology_source"]);
						$vb_show_collection_chronology = true;
					}
				}
			}
			if($vb_show_collection_chronology){
?>
				<br/>
				<ul id="collectionTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#guide" aria-controls="Collection Guide" role="tab" data-toggle="tab">Collection Guide</a></li>
					<li role="presentation"><a href="#chronology" aria-controls="Chronology" role="tab" data-toggle="tab">Chronology</a></li>
				</ul>
				<div class="tab-content collectionTabs">
					<br/>
					<div role="tabpanel" class="tab-pane active" id="guide">
<?php
			}
?>
						<div class="row">
							<div class="col-sm-12">
<?php
								print $t_item->getWithTemplate('<ifdef code="ca_collections.public_notes"><div class="unit"><p>^ca_collections.public_notes</p></div><br/></ifdef><ifdef code="ca_collections.scopecontent"><div class="unit"><p>^ca_collections.scopecontent</p></div><br/></ifdef>');
?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
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
			if($vb_show_collection_chronology){
?>
					</div><!-- end tabpanel guide -->
					<div role="tabpanel" class="tab-pane" id="chronology">
						<div class="row">
							<div class="col-sm-12">
<?php
							if(is_array($va_chronology_processed) && sizeof($va_chronology_processed)){
								ksort($va_chronology_processed);
								foreach($va_chronology_processed as $va_chronology_entry){
									print "<div class='unit collectionChronology'>";
									if($va_chronology_entry["date"] || $va_chronology_entry["season"]){
										print "<H6>".$va_chronology_entry["date"].(($va_chronology_entry["date"] && $va_chronology_entry["season"]) ? ", " : "").$va_chronology_entry["season"]."</H6>";
									}
									if($va_chronology_entry["text"]){
										print $va_chronology_entry["text"];
									}
									print "</div>";
								}
							}
?>
							</div>
						</div>
					</div>
			
				</div><!-- end tab-content-->
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						$('#collectionTabs a').click(function (e) {
							e.preventDefault()
							$(this).tab('show')
						});
						$('#myTabs a[href="#guide"]').tab('show');
					});
				</script>

		<?php
			}
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
