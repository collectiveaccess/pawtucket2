<?php
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
# --- collection types
	$t_list = new ca_lists();
	$va_collection_types = array(
		"collection" => $t_list->getItemIDFromList("collection_types", "collection"),
		"record_group" => $t_list->getItemIDFromList("collection_types", "record_group"),
		"series" => $t_list->getItemIDFromList("collection_types", "series"),
		"subseries" => $t_list->getItemIDFromList("collection_types", "subseries"),
		"file" => $t_list->getItemIDFromList("collection_types", "file"),
		"box" => $t_list->getItemIDFromList("collection_types", "box"),
		"folder" => $t_list->getItemIDFromList("collection_types", "folder")
	);
	$t_item = $this->getVar("item");
	$vs_collection_type = $t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
	$va_access_values = caGetUserAccessValues($this->request);
	$vb_has_children = false;
	if($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))){
		$vb_has_children = true;
	}
	$vs_home = caNavLink($this->request, "City Readers", '', '', '', '');
	$vs_type = caNavLink($this->request, "Finding Aids", '', '', 'Collections', 'Index');
	$va_title = $t_item->get('ca_collections.hierarchy.preferred_labels', array('returnWithStructure' => true));
	$vn_collection_root = null;
	if(!$t_item->get('ca_collections.parent.collection_id')){
		$vn_collection_root = $t_item->get('ca_collections.collection_id');
	}
	foreach ($va_title as $va_collection_key => $va_collection_names) {
		foreach ($va_collection_names as $vn_collection_id => $va_collection_name) {
			foreach ($va_collection_name as $vn_key => $va_name) {
				if(!$vn_collection_root){
					$vn_collection_root = $vn_collection_id; 
				}
				if ($vn_id != $vn_collection_id) {
					$va_collection_list[] = caNavLink($this->request, $va_name['name'], '', '', 'Detail', 'collections/'.$vn_collection_id);
				} else {
					$va_collection_list[] = $va_name['name'];
				}
			}
		}
	}
	MetaTagManager::setWindowTitle($vs_home." > ".$vs_type." > ".join(' > ', $va_collection_list));
	
	$vs_buf = null;
	$va_anchors = array();
	$vn_type_id = $t_item->get('ca_collections.type_id');
	if(($vn_type_id == $va_collection_types['collection']) || ($vn_type_id == $va_collection_types['record_group']) || $vn_type_id == $va_collection_types['series']){
		$va_subject_list = array();
		if ($t_item->get('ca_collections.LcshNames') | $t_item->get('ca_collections.LcshTopical') | $t_item->get('ca_collections.LcshGeo')) {
			if($va_names = $t_item->get('ca_collections.LcshNames', array('returnAsArray' => true, 'returnWithStructure' => true))){
				foreach(array_pop($va_names) as $vn_item_id => $va_subject_info){
					$va_subject_parts = explode(' [',$va_subject_info["LcshNames"]);
					#$va_subject_list[$va_subject_parts[0]] = caNavLink($this->request, $va_subject_parts[0], '', '', 'MultiSearch', 'Index', array('search' => $va_subject_parts[0]));
					$va_subject_list[$va_subject_parts[0]] = $va_subject_parts[0];
				}
			}
			if($va_topical = $t_item->get('ca_collections.LcshTopical', array('returnAsArray' => true, 'returnWithStructure' => true))){
				foreach(array_pop($va_topical) as $vn_item_id => $va_subject_info){
					$va_subject_parts = explode(' [',$va_subject_info["LcshTopical"]);
					#$va_subject_list[$va_subject_parts[0]] = caNavLink($this->request, $va_subject_parts[0], '', '', 'MultiSearch', 'Index', array('search' => $va_subject_parts[0]));
					$va_subject_list[$va_subject_parts[0]] = $va_subject_parts[0];
				}
			}
			if($va_geo = $t_item->get('ca_collections.LcshGeo', array('returnAsArray' => true, 'returnWithStructure' => true))){
				foreach(array_pop($va_geo) as $vn_item_id => $va_subject_info){
					$va_subject_parts = explode(' [',$va_subject_info["LcshGeo"]);
					#$va_subject_list[$va_subject_parts[0]] = caNavLink($this->request, $va_subject_parts[0], '', '', 'MultiSearch', 'Index', array('search' => $va_subject_parts[0]));
					$va_subject_list[$va_subject_parts[0]] = $va_subject_parts[0];
				}
			}
			#$va_subjects[] = $t_item->get('ca_collections.LcshNames', array('returnAsArray' => true, 'returnWithStructure' => true));
			#$va_subjects[] = $t_item->get('ca_collections.LcshTopical', array('returnAsArray' => true, 'returnWithStructure' => true));
			#$va_subjects[] = $t_item->get('ca_collections.LcshGeo', array('returnAsArray' => true, 'returnWithStructure' => true));
			#foreach ($va_subjects as $vn_item_id => $vs_subject) {
			#	$va_subject_parts = explode('[',$vs_subject);
			#	$va_subject_list[] = caNavLink($this->request, $va_subject_parts[0], '', '', 'MultiSearch', 'Index', array('search' => 'ca_list_items.item_id:'.$vn_item_id));
			#}
			ksort($va_subject_list);
		}	
	}
	$vs_trail = $t_item->getWithTemplate('<ifdef code="ca_collections.parent_id"><div class="unit"><span class="collectionLabel">Part of: </span><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>');
	switch($vn_type_id){
		case $va_collection_types['collection']:
			$vs_buf.= "<h3><a name='overview'>Collection Overview</a></h3>";
			$va_anchors[] = "<a href='#overview' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Collection Overview</a>";
			$vs_buf.= "<div class='unit'><span class='collectionLabel'>Collection Title: </span>".$t_item->get('ca_collections.preferred_labels')."</div>";
			if ($vs_entities = $t_item->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Creator(s): </span>".$vs_entities."</div>";
			}
			if ($t_item->get('ca_collections.unitdate.date_value')) {
				$vs_buf.= "<div class='unit'>".$t_item->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
			}
			if ($vs_extent = $t_item->get('ca_collections.extentDACS')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
			}
			if ($vs_container = $t_item->get('ca_collections.archival_container')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
			}
			if ($vs_scope_content = $t_item->get('ca_collections.scopecontent')) {
				$vs_buf.= "<h3><a name='scope'>Scope & Content</a></h3><div class='unit'>".$vs_scope_content."</div>";
				$va_anchors[] = "<a href='#scope' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Scope & Content</a>";
			}
			if ($vs_historical = $t_item->get('ca_collections.adminbiohist')) {
				$vs_buf.= "<h3><a name='scope'>Historical Note</a></h3><div class='unit'>".$vs_historical."</div>";
				$va_anchors[] = "<a href='#scope' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Historical Note</a>";
			}
			if ($vs_processInfo = $t_item->get('ca_collections.processInfo')) {
				$vs_buf.= "<h3><a name='proc'>Processing Note</a></h3><div class='unit'>".$vs_processInfo."</div>";
				$va_anchors[] = "<a href='#proc' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Processing Note</a>";
			}
			if (($vs_access = $t_item->get('ca_collections.accessrestrict')) | $vs_repo = $t_item->get('ca_collections.reproduction')) {
				$vs_buf.= "<h3><a name='admin'>Administrative Information</a></h3>";
				$va_anchors[] = "<a href='#admin' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Administrative Information</a>";
			}
			if ($vs_access) {
				$vs_buf.= "<span class='collectionLabel'>Conditions Governing Access: </span><div class='unit'>".$vs_access."</div><br/>";
			}
			if ($vs_repo) {
				$vs_buf.= "<span class='collectionLabel'>Conditions Governing Reproduction: </span><div class='unit'>".$vs_repo."</div>";
			}
			if (is_array($va_subject_list) && sizeof($va_subject_list)) {
				$vs_buf.= "<h3><a name='subjects'>Subjects</a></h3>";
				$va_anchors[] = "<a href='#subjects' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Subjects</a>";
				$vs_buf.= "<div class='unit'>";
				$vs_buf.= join('<br/>',$va_subject_list);
				$vs_buf.= "</div>";
			}
		
		break;
		# ---------------------------
		case $va_collection_types['record_group']:
		case $va_collection_types['series']:
			$vs_buf.= "<h3><a name='overview'>".$vs_collection_type." Overview</a></h3>";
			$va_anchors[] = "<a href='#overview' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>".$vs_collection_type." Overview</a>";
			$vs_buf.= "<div class='unit'><span class='collectionLabel'>".$vs_collection_type." Title: </span>".$t_item->get('ca_collections.preferred_labels')."</div>";
			if($vs_trail){
				$vs_buf.= $vs_trail;
			}
			if ($t_item->get('ca_collections.unitdate.date_value')) {
				$vs_buf.= "<div class='unit'>".$t_item->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
			}
			if ($vs_extent = $t_item->get('ca_collections.extentDACS')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
			}
			if ($vs_container = $t_item->get('ca_collections.archival_container')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
			}
			if ($vs_scope_content = $t_item->get('ca_collections.scopecontent')) {
				$vs_buf.= "<h3><a name='scope'>Scope & Content</a></h3><div class='unit'>".$vs_scope_content."</div>";
				$va_anchors[] = "<a href='#scope' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Scope & Content</a>";
			}
			if ($vs_historical = $t_item->get('ca_collections.adminbiohist')) {
				$vs_buf.= "<h3><a name='scope'>Historical Note</a></h3><div class='unit'>".$vs_historical."</div>";
				$va_anchors[] = "<a href='#scope' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Historical Note</a>";
			}
			if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
				$vs_buf.= "<h3><a name='arr'>System of Arrangement</a></h3><div class='unit'>".$vs_arrangement."</div>";
				$va_anchors[] = "<a href='#arr' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>System of Arrangement</a>";
			}
			if (is_array($va_subject_list) && sizeof($va_subject_list)) {
				$vs_buf.= "<h3><a name='subjects'>Subjects</a></h3>";
				$va_anchors[] = "<a href='#subjects' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Subjects</a>";
				$vs_buf.= "<div class='unit'>";
				$vs_buf.= join('<br/>',$va_subject_list);
				$vs_buf.= "</div>";
			}
			
		break;
		# ---------------------------
		case $va_collection_types['subseries']:
			$vs_buf.= "<h3><a name='overview'>".$vs_collection_type." Overview</a></h3>";
			$va_anchors[] = "<a href='#overview' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>".$vs_collection_type." Overview</a>";
			$vs_buf.= "<div class='unit'><span class='collectionLabel'>".$vs_collection_type." Title: </span>".$t_item->get('ca_collections.preferred_labels')."</div>";
			if($vs_trail){
				$vs_buf.= $vs_trail;
			}
			if ($t_item->get('ca_collections.unitdate.date_value')) {
				$vs_buf.= "<div class='unit'>".$t_item->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
			}
			if ($vs_extent = $t_item->get('ca_collections.extentDACS')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
			}
			if ($vs_container = $t_item->get('ca_collections.archival_container')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
			}
			if ($vs_scope_content = $t_item->get('ca_collections.scopecontent')) {
				$vs_buf.= "<h3><a name='scope'>Scope & Content</a></h3><div class='unit'>".$vs_scope_content."</div>";
				$va_anchors[] = "<a href='#scope' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Scope & Content</a>";
			}
			if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
				$vs_buf.= "<h3><a name='arr'>System of Arrangement</a></h3><div class='unit'>".$vs_arrangement."</div>";
				$va_anchors[] = "<a href='#arr' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>System of Arrangement</a>";
			}		
		break;
		# ---------------------------
		default:
		# - file, box, folder
			$vs_buf.= "<h3><a name='overview'>".$vs_collection_type." Overview</a></h3>";
			$va_anchors[] = "<a href='#overview' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>".$vs_collection_type." Overview</a>";
			$vs_buf.= "<div class='unit'><span class='collectionLabel'>".$vs_collection_type." Title: </span>".$t_item->get('ca_collections.preferred_labels')."</div>";
			if($vs_trail){
				$vs_buf.= $vs_trail;
			}
			if ($t_item->get('ca_collections.unitdate.date_value')) {
				$vs_buf.= "<div class='unit'>".$t_item->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
			}
			if ($vs_extent = $t_item->get('ca_collections.extentDACS')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
			}
			if ($vs_container = $t_item->get('ca_collections.archival_container')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
			}
			if ($vs_idno = $t_item->get('ca_collections.idno')) {
				$vs_buf.= "<div class='unit'><span class='collectionLabel'>Identifier: </span>".$vs_idno."</div>";
			}
			if ($vs_scope_content = $t_item->get('ca_collections.scopecontent')) {
				$vs_buf.= "<a name='scope'></a><div class='unit'>".$vs_scope_content."</div>";
				$va_anchors[] = "<a href='#scope' onclick='$(\"#findingTable\").tabs(\"option\", \"active\", 0);'>Folder Note</a>";
			}			
		break;
		# ---------------------------
	}
?>

<div class="page">
	<div class="wrapper">
		<div class="sidebar">
			<div class='collectionNav'>
<?php
			if ($vb_show_hierarchy_viewer && $vb_has_children) {	
?>
					<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
					<script>
						$(document).ready(function(){
							$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'), 'subcollection_id' => $this->request->getParameter('subcollection_id', pInteger), 'expandAll' => $this->request->getParameter('expandAll', pInteger))); ?>"); 
						})
					</script>
<?php				
			}else{
?>
				
				<h5>Table of Contents</h5>
<?php 
				foreach ($va_anchors as $va_key => $va_anchor) {
					print "<div>".$va_anchor."</div>";
				}
			}
?>	
			</div>	
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="row">
							<div class='col-md-6 col-lg-6'>
								<div class="detailNav">
									<div class='left'>
										<div class='resLink'>{{{resultsLink}}}</div>
									</div>
									<div class='right'>
										<div class='prevLink'>{{{previousLink}}}</div>
										<div class='nextLink'>{{{nextLink}}}</div>
									</div>
								</div>
							</div>
							<div class='col-md-6 col-lg-6' style='text-align:right;'>
						
							</div><!-- end col -->
						</div><!-- end row -->


		<div class="container">  
			<div class="row">
				<div class='col-sm-8 col-md-8 col-lg-8'>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
				</div><!-- end col -->
				<div class='col-sm-4 col-md-4 col-lg-4'>
<?php
					print "<div class='faDownload'>".caNavLink($this->request, '<i class="glyphicon glyphicon-download-alt"></i> Download Finding Aid', '', 'Detail', 'collections', $vn_collection_root.'/view/pdf/export_format/_pdf_ca_collections_summary')."</div>";
?>					
				</div>
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-12 col-lg-12'>
				
				<div id="findingTable">
					<ul class='row'>
						<li><a href="#ovTab">Overview</a></li>
<?php
						if($vb_has_children){
?>
							<li id="contTabLink"><a href="#contTab"><?php print $vs_collection_type; ?> Browser</a></li>
<?php
						}
						$o_search = caGetSearchInstance("ca_objects");
						$qr_res = $o_search->search("ca_collections.collection_id:".$t_item->get("collection_id"), array("sort" => "ca_object_labels.name", "sort_direction" => "desc", "checkAccess" => $va_access_values));
						$vn_rel_object_count = $qr_res->numHits();
						if($vn_rel_object_count){
							print '<li><a href="#relObjectsTab">Digitized Items</a></li>';
						}
							
?>
					</ul>
					<div id="ovTab">
						<div class='container'>
							<div class='row'>
								<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
									print $vs_buf;
?>										
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->						
					</div>
<?php
			if ($vb_show_hierarchy_viewer && $vb_has_children) {	
?>
					<div id="contTab">
						<div class='container'>
							<div class='row'>
								<div class='col-sm-12 col-md-12 col-lg-12'>
									<div id='collectionLoad' class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>
										<span class='collectionLoadDefault'><i class='fa fa-arrow-left'></i> Click a <?php print ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true))); ?> container to the left to see its contents.</span>
									</div>
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->						
					</div><!-- end contTab -->
<?php				
			}	
			if($vn_rel_object_count){								
?>				

				<div id="relObjectsTab">
					<div class='container'>
						<div class="row">
							<div id="browseResultsContainer">
								<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
							</div><!-- end browseResultsContainer -->
						</div><!-- end row -->
					</div><!-- end container -->						
				</div><!-- end relObjectsTab -->	
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'docs', array('search' => 'collection_id:'.$t_item->get('collection_id')), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: '<?php print addslashes(caBusyIndicatorIcon($this->request).' '._t('Loading...')); ?>',
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						});
			
			
					});
				</script>
<?php
			}
?>				
				</div><!-- end Finding Table -->								
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->


					</div> <!-- end col-->	
				</div> <!-- end container--></div> <!-- end row-->	
			</div> <!-- end content-inner -->
		</div> <!-- end content-wrapper -->	
	</div> <!-- end wrapper -->	
</div> <!-- end page -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
		$('#findingTable').tabs();
	});
</script>
