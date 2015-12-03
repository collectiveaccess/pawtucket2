<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
	$va_access_values = caGetUserAccessValues($this->request);
	
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	$va_type = caNavLink($this->request, "Finding Aids", '', 'FindingAid', 'Collection', 'Index');
	$va_title = $t_item->get('ca_collections.hierarchy.preferred_labels', array('returnWithStructure' => true));
	foreach ($va_title as $va_collection_key => $va_collection_names) {
		foreach ($va_collection_names as $va_key => $va_collection_name) {
			foreach ($va_collection_name as $vn_collection_id => $va_name) {
				if ($vn_id != $vn_collection_id) {
					$va_collection_list[] = caNavLink($this->request, $va_name['name'], '', '', 'Detail', 'collections/'.$vn_collection_id);
				} else {
					$va_collection_list[] = $va_name['name'];
				}
			}
		}
	}
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".join(' > ', $va_collection_list));
	
	$vs_buf = null;
	$va_anchors = array();
	$va_collection_type = $t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
	$vs_buf.= "<h3><a name='overview'>Collection Overview</a></h3>";
	$va_anchors[] = "<a href='#overview'>Collection Overview</a>";
	if ($va_collection_type == "Collection") {
		$vs_buf.= "<div class='unit'><span class='collectionLabel'>Collection Title: </span>".$t_item->get('ca_collections.preferred_labels')."</div>";
		$vs_buf.= "<div class='unit'><span class='collectionLabel'>Identifier: </span>".$t_item->get('ca_collections.idno')."</div>";
	}
	if ($t_item->get('ca_collections.unitdate.date_value')) {
		$vs_buf.= "<div class='unit'>".$t_item->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
	}
	if ($va_extent = $t_item->get('ca_collections.extentDACS')) {
		$vs_buf.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$va_extent."</div>";
	}
	if ($va_collection_type == "Collection") {
		if ($va_abstract = $t_item->get('ca_collections.abstract')) {
			$vs_buf.= "<h3><a name='abstract'>Abstract</a></h3><div class='unit'>".$va_abstract."</div>";
			$va_anchors[] = "<a href='#abstract'>Abstract</a>";
		}
	}
	if ($va_bio_note = $t_item->get('ca_collections.adminbiohist')) {
		$vs_buf.= "<h3><a name='bionote'>Biographical Note</a></h3><div class='unit'>".$va_bio_note."</div>";
		$va_anchors[] = "<a href='#bionote'>Biographical Note</a>";
	}
	if ($va_scope_content = $t_item->get('ca_collections.scopecontent')) {
		$vs_buf.= "<h3><a name='scope'>Scope & Content</a></h3><div class='unit'>".$va_scope_content."</div>";
		$va_anchors[] = "<a href='#scope'>Scope & Content</a>";
	}
	if ($va_collection_type != "Collection") {
		if ($va_arrangement = $t_item->get('ca_collections.arrangement')) {
			$vs_buf.= "<h3><a name='arr'>System of Arrangement</a></h3><div class='unit'>".$va_arrangement."</div>";
			$va_anchors[] = "<a href='#arr'>System of Arrangement</a>";
		}
	}
	if ($va_collection_type != "Collection") {
		if ($va_processInfo = $t_item->get('ca_collections.processInfo')) {
			$vs_buf.= "<h3><a name='proc'>Processing Note</a></h3><div class='unit'>".$va_processInfo."</div>";
			$va_anchors[] = "<a href='#proc'>Processing Note</a>";
		}
	}
	if ($va_collection_type != "Collection") {
		if ($va_provenance = $t_item->get('ca_collections.provenance')) {
			$vs_buf.= "<h3><a name='prov'>Provenance</a></h3><div class='unit'>".$va_provenance."</div>";
			$va_anchors[] = "<a href='#prov'>Provenance</a>";
		}
	}
	if ($va_collection_type == "Collection") {			
		$vs_buf.= "<h3><a name='admin'>Administrative Information</a></h3>";
		$va_anchors[] = "<a href='#admin'>Administrative Information</a>";
	}
	if ($va_access = $t_item->get('ca_collections.accessrestrict')) {
		$vs_buf.= "<span class='collectionLabel'>Conditions Governing Access: </span><div class='unit'>".$va_access."</div>";
	}
	if ($va_collection_type == "Collection") {	
		if ($va_citation = $t_item->get('ca_collections.preferCite')) {
			$vs_buf.= "<span class='collectionLabel'>Preferred Citation: </span><div class='unit'>".$va_citation."</div>";
		}
	}
	if ($va_collection_type != "Collection") {	
		if ($va_archival_container = $t_item->get('ca_collections.archival_container', array('delimiter' => '<br/>'))) {
			$vs_buf.= "<span class='collectionLabel'>Archival Container: </span><div class='unit'>".$va_archival_container."</div>";
		}
	}	
	$va_subjects = array();
	$va_subject_list = array();
	if ($t_item->get('ca_collections.LcshNames') | $t_item->get('ca_collections.LcshTopical') | $t_item->get('ca_collections.LcshGeo')) {
		$va_subjects[] = $t_item->get('ca_collections.LcshNames', array('returnAsArray' => true));
		$va_subjects[] = $t_item->get('ca_collections.LcshTopical', array('returnAsArray' => true));
		$va_subjects[] = $t_item->get('ca_collections.LcshGeo', array('returnAsArray' => true));
		foreach ($va_subjects as $va_key => $va_subject) {
			foreach ($va_subject as $va_key2 => $va_subject2) {
				$va_subject2 = explode('[',$va_subject2);
				$va_subject_list[] = caNavLink($this->request, $va_subject2[0], '', '', 'MultiSearch', 'Index?search="'.$va_subject2[0].'"');
			}
		}
		asort($va_subject_list);
		$vs_buf.= "<span class='collectionLabel'>Subjects:</span><div class='unit'>";
		$vs_buf.= join('<br/>',$va_subject_list);
		$vs_buf.= "</div>";
	}
	if ($va_collection_type == "Collection") {
		if ($va_entities = $t_item->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
			$vs_buf.= "<div class='unit'><span class='collectionLabel'>Related Entities: </span>".$va_entities."</div>";
		}
	}
					
	$va_top_level = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true));
	if ($va_top_level) {
		$vn_i = 0;
		foreach($va_top_level as $vn_i => $va_top_level_id) {
			$t_top_collection = new ca_collections($va_top_level_id);
			
			$va_series_level = $t_top_collection->get('ca_collections.children.collection_id', array('returnAsArray' => true));
			$top_scope = null;
			if ($va_scope = $t_top_collection->get('ca_collections.scopecontent')) {
				$top_scope = "<p class='label'>Scope and Content</p><p>".$va_scope."</p>";
			}
			if ($va_arrangement = $t_top_collection->get('ca_collections.arrangement')) {
				$top_scope.= "<p class='label'>System of Arrangement</p><p>".$va_arrangement."</p>";
			}
			$vs_contents.= "<div>".(sizeof($va_series_level) > 0 ? "<a href='#' onclick='$(\".seriesLevel".$va_top_level_id."\").toggle(200);return false;'><i class='fa fa-chevron-down'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_top_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_top_collection->get('ca_collections.collection_id'))."</div>".$top_scope;
			$vs_contents.= "<div class='seriesLevel".$va_top_level_id."' style='margin-left:40px; display:none;'>";
			
			foreach($va_series_level as $vn_i2 => $va_series_level_id) {
				$t_series_level = new ca_collections($va_series_level_id);
				
				#$va_subseries_level = $t_series_level->get('ca_collections.children.collection_id', array('returnAsArray' => true));
				$va_subseries_level = $t_series_level->getHierarchyChildren(null, array("idsOnly" => true));
				$vs_series_scope = null;
				if ($va_scope = $t_series_level->get('ca_collections.scopecontent')) {
					$vs_series_scope = "<p class='label'>Scope and Content</p><p>".$va_scope."</p>";
				}
				if ($va_arrangement = $t_series_level->get('ca_collections.arrangement')) {
					$vs_series_scope.= "<p class='label'>System of Arrangement</p><p>".$va_arrangement."</p>";
				}				
				$vs_contents.= "<div>".(sizeof($va_subseries_level) > 0 ? "<a href='#' onclick='$(\".subseriesLevel".$va_series_level_id."\").toggle(200);return false;'><i class='fa fa-chevron-down'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_series_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_series_level->get('ca_collections.collection_id'))."</div>".$vs_series_scope;
				$vs_contents.= "<div class='subseriesLevel".$va_series_level_id."' style='margin-left:40px; display:none;'>";
				
				foreach($va_subseries_level as $vn_i3 => $va_subseries_level_id) {
					$t_subseries_level = new ca_collections($va_subseries_level_id);
					$va_box_levels = $t_subseries_level->getHierarchyChildren(null, array("idsOnly" => true));
					$vs_subseries_scope = null;
					if ($va_scope = $t_subseries_level->get('ca_collections.scopecontent')) {
						$vs_subseries_scope = "<p class='label'>Scope and Content</p><p>".$va_scope."</p>";
					}
					if ($va_arrangement = $t_subseries_level->get('ca_collections.arrangement')) {
						$vs_subseries_scope.= "<p class='label'>System of Arrangement</p><p>".$va_arrangement."</p>";
					}
					$vs_contents.= "<div>".(sizeof($va_box_levels) > 0 ? "<a href='#' onclick='$(\".boxLevel".$va_subseries_level_id."\").toggle(200);return false;'><i class='fa fa-chevron-down'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_subseries_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_subseries_level->get('ca_collections.collection_id'))."</div>".$vs_subseries_scope;
					$vs_contents.= "<div class='boxLevel".$va_subseries_level_id."' style='margin-left:40px; display:none;'>";
					foreach ($va_box_levels as $vn_i4 => $va_box_level_id) {
						$t_box_level = new ca_collections($va_box_level_id); 
						$vs_box_scope = null;
						if ($va_scope = $t_box_level->get('ca_collections.scopecontent')) {
							$vs_box_scope = "<p class='label'>Scope and Content</p><p>".$va_scope."</p>";
						}
						if ($va_arrangement = $t_box_level->get('ca_collections.arrangement')) {
							$vs_box_scope.= "<p class='label'>System of Arrangement</p><p>".$va_arrangement."</p>";
						}						
						
						$vs_contents.= "<div><span class='colspacer'></span>".caNavLink($this->request, $t_box_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_box_level->get('ca_collections.collection_id'))."</div>".$vs_box_scope;
					}
					$vs_contents.= "</div><!-- end boxlevel -->";
				}
				
				$vs_contents.= "</div><!-- end subseries -->";
			}
			$vs_contents.= "</div><!-- end series -->";
		}
	}								
	if ($va_objects = $t_item->get('ca_objects.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
		$vs_buf.= "<h3><a name='objects'>Related Objects</a></h3><div class='unit'>".$va_objects."</div>";
		$va_anchors[] = "<a href='#objects'>Related Objects</a>";
	}
?>

<div class="page">
	<div class="wrapper">
		<div class="sidebar">
			<div class='collectionNav'>
				<h5>Table of Contents</h5>
<?php 
			foreach ($va_anchors as $va_key => $va_anchor) {
				print "<div>".$va_anchor."</div>";
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
					print "<div class='faDownload'>".caNavLink($this->request, '<i class="glyphicon glyphicon-download-alt"></i> Download Finding Aid', '', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary')."</div>";
?>					
				</div>
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-12 col-lg-12'>
				
				<div id="findingTable">
					<ul class='row'>
						<li><a href="#ovTab">Overview</a></li>
						<li><a href="#contTab">Collection Contents</a></li>
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
					<div id="contTab">
						<div class='container'>
							<div class='row'>
								<div class='col-sm-12 col-md-12 col-lg-12' style='padding-top:20px;'>
<?php
									print $vs_contents;
?>										
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->						
					</div>				
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
