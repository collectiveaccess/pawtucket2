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
	
	$vs_buf.= "<h3><a name='overview'>Collection Overview</a></h3>";
	$va_anchors[] = "<a href='#overview'>Collection Overview</a>";
	$vs_buf.= "<div class='unit'><span class='collectionLabel'>Collection Title: </span>".$t_item->get('ca_collections.preferred_labels')."</div>";
	$vs_buf.= "<div class='unit'><span class='collectionLabel'>Identifier: </span>".$t_item->get('ca_collections.idno')."</div>";
	if ($t_item->get('ca_collections.unitdate.date_value')) {
		$vs_buf.= "<div class='unit'>".$t_item->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types</span><br/>^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
	}
	if ($va_extent = $t_item->get('ca_collections.extentDACS')) {
		$vs_buf.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$va_extent."</div>";
	}
	if ($va_abstract = $t_item->get('ca_collections.abstract')) {
		$vs_buf.= "<h3><a name='abstract'>Abstract</a></h3><div class='unit'>".$va_abstract."</div>";
		$va_anchors[] = "<a href='#abstract'>Abstract</a>";
	}
	if ($va_bio_note = $t_item->get('ca_collections.adminbiohist')) {
		$vs_buf.= "<h3><a name='bionote'>Biographical Note</a></h3><div class='unit'>".$va_bio_note."</div>";
		$va_anchors[] = "<a href='#bionote'>Biographical Note</a>";
	}
	if ($va_scope_content = $t_item->get('ca_collections.scopecontent')) {
		$vs_buf.= "<h3><a name='scope'>Scope & Content</a></h3><div class='unit'>".$va_scope_content."</div>";
		$va_anchors[] = "<a href='#scope'>Scope & Content</a>";
	}
	$vs_buf.= "<h3><a name='admin'>Administrative Information</a></h3>";
	$va_anchors[] = "<a href='#admin'>Administrative Information</a>";
	if ($va_access = $t_item->get('ca_collections.accessrestrict')) {
		$vs_buf.= "<span class='collectionLabel'>Conditions Governing Access: </span><div class='unit'>".$va_access."</div>";
	}	
	if ($va_citation = $t_item->get('ca_collections.preferCite')) {
		$vs_buf.= "<span class='collectionLabel'>Preferred Citation: </span><div class='unit'>".$va_citation."</div>";
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
		$vs_buf.= "<span class='collectionLabel'>Subjects</span><div class='unit'>";
		$vs_buf.= join('<br/>',$va_subject_list);
		$vs_buf.= "</div>";
	}
	if ($va_entities = $t_item->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
		$vs_buf.= "<span class='collectionLabel'>Related Entities: </span><div class='unit'>".$va_entities."</div>";
	}				
	$va_top_level = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true));
	if ($va_top_level) {
		$vs_buf.= "<h3><a name='contents'>Collection Contents</a></h3>";
		$va_anchors[] = "<a href='#contents'>Collection Contents</a>";
		$vn_i = 0;
		foreach($va_top_level as $vn_i => $va_top_level_id) {
			$t_top_collection = new ca_collections($va_top_level_id);
			
			$va_series_level = $t_top_collection->get('ca_collections.children.collection_id', array('returnAsArray' => true));

			$vs_buf.= "<div>".(sizeof($va_series_level) > 0 ? "<a href='#' onclick='$(\".seriesLevel".$va_top_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_top_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_top_collection->get('ca_collections.collection_id'))."</div>";
			$vs_buf.= "<div class='seriesLevel".$va_top_level_id."' style='margin-left:20px;'>";
			
			foreach($va_series_level as $vn_i2 => $va_series_level_id) {
				$t_series_level = new ca_collections($va_series_level_id);
				
				#$va_subseries_level = $t_series_level->get('ca_collections.children.collection_id', array('returnAsArray' => true));
				$va_subseries_level = $t_series_level->getHierarchyChildren(null, array("idsOnly" => true));
				
				$vs_buf.= "<div>".(sizeof($va_subseries_level) > 0 ? "<a href='#' onclick='$(\".subseriesLevel".$va_series_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_series_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_series_level->get('ca_collections.collection_id'))."</div>";
				$vs_buf.= "<div class='subseriesLevel".$va_series_level_id."' style='margin-left:40px;'>";
				
				foreach($va_subseries_level as $vn_i3 => $va_subseries_level_id) {
					$t_subseries_level = new ca_collections($va_subseries_level_id);
					$va_box_levels = $t_subseries_level->getHierarchyChildren(null, array("idsOnly" => true));

					$vs_buf.= "<div>".(sizeof($va_box_levels) > 0 ? "<a href='#' onclick='$(\".boxLevel".$va_subseries_level_id."\").toggle(200);return false;'><i class='fa fa-plus-square-o'></i> </a>" : "<span class='colspacer'></span>").caNavLink($this->request, $t_subseries_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_subseries_level->get('ca_collections.collection_id'))."</div>";
					$vs_buf.= "<div class='boxLevel".$va_subseries_level_id."' style='margin-left:60px;'>";
					foreach ($va_box_levels as $vn_i4 => $va_box_level_id) {
						$t_box_level = new ca_collections($va_box_level_id);
						$vs_buf.= "<div><span class='colspacer'></span>".caNavLink($this->request, $t_box_level->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$t_box_level->get('ca_collections.collection_id'))."</div>";
					}
					$vs_buf.= "</div><!-- end boxlevel -->";
				}
				
				$vs_buf.= "</div><!-- end subseries -->";
			}
			$vs_buf.= "</div><!-- end series -->";
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
<?php
							print caNavLink($this->request, 'Download Finding Aid', '', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary');
?>							
							</div><!-- end col -->
						</div><!-- end row -->


		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-12 col-lg-12'>
<?php
					print $vs_buf;																														
?>								
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->


					</div> <!-- end col-->	
				</div> <!-- end container--></div> <!-- end row-->	
			</div> <!-- end content-inner -->
		</div> <!-- end content-wrapper -->	
	</div> <!-- end wrapper -->	
</div> <!-- end page -->
