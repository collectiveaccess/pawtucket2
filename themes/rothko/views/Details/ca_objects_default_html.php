<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_id = 				$t_object->get('ca_objects.object_id');
	$va_access_values = caGetUserAccessValues($this->request);
	
	$t_list = new ca_lists();
	$vs_list_value =  $t_list->getItemIDFromList('yes_no', 'yes');

?>
<div class='container'>
<div class="row">
	<div class='col-xs-12 objNav'><!--- only shown at small screen size -->
		<div class='resultsLink'>{{{resultsLink}}}</div><div class='previousLink'>{{{previousLink}}}</div><div class='nextLink'>{{{nextLink}}}</div>
	</div><!-- end detailTop -->
</div>
<div class="row">
	<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1' style="padding-left:30px;padding-right:30px;">
		{{{representationViewer}}} 
						
		<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "version" => "iconlarge")); ?>
	</div><!-- end col -->
<script>
	jQuery(document).ready(function() {
		$(".detailMediaToolbar").append("<a href='#' class='compare_link' data-id='<?php print $vn_id; ?>'><i class='fa fa-clone' aria-hidden='true'></i></a>");
	});
	
</script>		
	<div class='col-sm-6 col-md-6 col-lg-5'>
<?php
		if ($va_catalog_id = $t_object->get('ca_objects.catalog_number')) {
			print "<div class='unit'>".$va_catalog_id."</div>";
		}
?>	
		<H1 style='margin-top:20px;'>{{{ca_objects.preferred_labels.name}}}</H1>
<?php
		$t_parent = new ca_objects($t_object->get('ca_objects.parent_id'));		
		if ($vs_date = $t_object->get('ca_objects.display_date')) {
			$vs_creation_date = $t_object->get('ca_objects.creation_date');
			print "<div class='unit'>Date - ".caNavLink($this->request, $vs_date, '', 'Search', 'artworks', "search/dates", ["values" => json_encode([$vs_creation_date])])."</div>";
		}
		if ($va_medium = $t_object->get('ca_objects.medium', array('returnWithStructure' => true))) {
			$va_media_links = array();
			foreach ($va_medium as $va_key => $va_medium_id_t) {
				foreach ($va_medium_id_t as $va_key => $va_medium_id) {
					if ($va_medium_id['medium_list'] == 383){continue;}
					$va_media_links[] = caNavLink($this->request, strtolower(caGetListItemByIDForDisplay($va_medium_id['medium_list'])), '', '', 'Browse', 'artworks/facet/medium_facet/id/'.$va_medium_id['medium_list']).($vs_list_value == $va_medium_id['medium_uncertain'] ? " <i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "" );	
				}
			}
			if (sizeof($va_media_links) > 0) {
				print "<div class='unit'>Medium - ".join(', ', $va_media_links)."</div>";
			}
		}
		if ($va_paper = $t_parent->get('ca_objects.paper', array('returnAsArray' => true, 'excludeIdnos' => array('null')))) {
			$va_paper_links = array();
			foreach ($va_paper as $va_key => $va_paper_id) {
				if ($va_paper_id == 0) {continue;}
				$va_paper_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_paper_id), '', '', 'Browse', 'artworks/facet/paper_facet/id/'.$va_paper_id);	
			}
			if (sizeof($va_paper_links) > 0){
				print "<div class='unit'>Support - ".join(', ', $va_paper_links)."</div>";
			}	
		}				
		if ($va_mount = $t_parent->get('ca_objects.mount', array('returnAsArray' => true, 'excludeIdnos' => array('null')))) {
			$va_mount_links = array();
			foreach ($va_mount as $va_key => $va_mount_id) {
				if ($va_mount_id != 0) { 
					$va_mount_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_mount_id), '', '', 'Browse', 'artworks/facet/mount_facet/id/'.$va_mount_id);	
				}
			}
			if (sizeof($va_mount_links) > 0) {
				print "<div class='unit'>Mount - ".join(', ', $va_mount_links)."</div>";
			}
		}
		if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions.display_dimensions" min="1"><unit delimiter="<br/>"><ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"> (^ca_objects.dimensions.dimensions_notes)</ifdef><if rule="^ca_objects.dimensions.dimensions_uncertain =~ /yes/"> <i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-content="sight dimensions"></i></if></unit></ifcount>')) {
			print "<div class='unit'>Dimensions - ".$vs_dimensions."</div>";
		}		
		if ($va_watermark = $t_parent->get('ca_objects.watermark', array('returnWithStructure' => true))) {
			$va_media_links = array();
			foreach ($va_watermark as $va_key => $va_watermark_id_t) {
				foreach ($va_watermark_id_t as $va_key => $va_watermark_id) {
					if ($va_watermark_id['watermark_list'] == 247){continue;}
					$va_media_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_watermark_id['watermark_list']), '', '', 'Browse', 'artworks/facet/watermark_facet/id/'.$va_watermark_id['watermark_list']).($vs_list_value == $va_watermark_id['watermark_uncertain'] ? " <i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "" );	
				}
			}
			if (sizeof($va_media_links) > 0) {
				print "<div class='unit'>Watermark - ".join(', ', $va_media_links)."</div>";
			}
		}
		if ($vs_inscription = $t_object->get('ca_objects.inscription')) {
			print "<div class='unit'>Inscription - ".$vs_inscription."</div>";
		}
		if ($va_estate_id = $t_object->get('ca_objects.estate_number')) {
			print "<div class='unit'>Estate/Inventory Number - ".$va_estate_id."</div>";
		}						

		// if ($va_collection = $t_parent->get('ca_objects_x_collections.relation_id', array('returnAsArray' => true))) {
// 			foreach ($va_collection as $va_key => $va_collection_relation_id) {
// 				$t_collection_rel = new ca_objects_x_collections($va_collection_relation_id);
// 				if ($t_collection_rel->get('ca_objects_x_collections.current_collection', array('convertCodesToDisplayText' => true)) == $vs_list_value) {
// 					$vn_current_collection_id = $t_collection_rel->get('ca_objects_x_collections.collection_id');
// 					print "<div class='unit'>Collection - ".$t_collection_rel->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>')." ".(($t_collection_rel->get('ca_objects_x_collections.uncertain') == $vs_list_value) ? "<i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "")."</div>";
// 					if ($vs_credit_line = $t_collection_rel->get('ca_objects_x_collections.collection_line')) {
// 						print "<div class='unit'>Credit - ".$vs_credit_line."</div>";
// 					}
// 					if ($vs_institutional = $t_object->get('ca_collections.institutional_id')) {
// 						print "<div class='unit'>Institutional id - ".$vs_institutional."</div>";
// 					}						
// 				}			
// 			}
// 
// 		}
		$vs_verso_collection = null;
		if ($qr_collections = $t_parent->get('ca_objects_x_collections.relation_id', array('returnAsSearchResult' => true))) {
			#print "hits=".$qr_collections->numHits(); 
			while($qr_collections->nextHit()) {
				if ($qr_collections->get('ca_collections.deleted') === null) { continue; } // you check for null because get() won't return info about deleted items
				
				if ($qr_collections->get('ca_objects_x_collections.current_collection') == $vs_list_value) {
					$vn_current_collection_id = $qr_collections->get('ca_objects_x_collections.collection_id');
					$t_collection = new ca_collections($vn_current_collection_id);
					if ($t_collection->get('ca_collections.public_private', array('convertCodesToDisplayText' => true)) != 'private'){
						print "<div class='unit'>Collection - ".$qr_collections->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>')." ".(($qr_collections->get('ca_objects_x_collections.uncertain') == $vs_list_value) ? "<i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "")."</div>";
						$vs_verso_collection = $qr_collections->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>');
					} else {
						print "<div class='unit'>Collection - ".$qr_collections->getWithTemplate('<unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit>')." ".(($qr_collections->get('ca_objects_x_collections.uncertain') == $vs_list_value) ? "<i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "")."</div>";
						$vs_verso_collection = $qr_collections->getWithTemplate('<unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit>');
					}
					if ($vs_credit_line = $qr_collections->get('ca_objects_x_collections.collection_line')) {
						print "<div class='unit'>Credit - ".$vs_credit_line."</div>";
					}
					if ($vs_institutional = $t_object->get('ca_collections.institutional_id')) {
						print "<div class='unit'>Institutional id - ".$vs_institutional."</div>";
					}						
				}			
			}
		}	

		if ($va_institutional_id = $t_object->get('ca_objects.institutional_id')) {
			print "<div class='unit'>Institutional ID - ".$va_institutional_id."</div>";
		}		
		if ($va_copyright = $t_parent->get('ca_objects.copyright')) {
			print "<div class='unit'>Copyright - ".$va_copyright."</div>";
		}	
		if ($va_photo_credit = $t_object->get('ca_objects.photography_credit_line')) {
			print "<div class='unit'>Photography Credit - ".$va_photo_credit."</div>";
		}	
		if ($va_keywords = $t_object->get('ca_list_items.item_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			$va_keyword_links = array();
			foreach ($va_keywords as $va_key => $va_keyword_id) {
				$va_keyword_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_keyword_id), '', '', 'Browse', 'artworks/facet/term_facet/id/'.$va_keyword_id);	
			}
			print "<div class='unit'>Keywords - ".join(', ', $va_keyword_links)."</div>";
		}											
		print "<div class='unit spacer'>".caNavLink($this->request, 'PDF', 'faDownload', 'Detail', 'objects', $vn_id.'/view/pdf/export_format/_pdf_ca_objects_summary')."</div>";
?>			
	</div><!-- end col -->
</div><!-- end row -->

<?php	
		$vn_verso_id = null;
		if ($va_child_ids = $t_parent->get('ca_objects.children.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			foreach ($va_child_ids as $va_key => $va_child_id) {
				if ($va_child_id != $vn_id) {
					$vn_verso_id = $va_child_id;
				}
			}
		}
	if ($vn_verso_id) {
	print "<h6 style='margin-top:30px;'>Verso</h6>";	
?>
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
		<div class='container versoInfo'>
			<div class='row'>
<?php		
		$t_verso = new ca_objects($vn_verso_id);
		print "<div class='col-sm-2'>".$t_verso->get('ca_object_representations.media.medium', array('checkAccess' => $va_access_values))."</div>";
		print "<div class='col-sm-10'>";
		if ($vn_catno = $t_verso->get('ca_objects.catalog_number')) {
			print "<div class='unit'>".$vn_catno."</div>";
		}
		print "<div class='versoTitle unit'>".$t_verso->get('ca_objects.preferred_labels')."</div>";
		if ($vn_date = $t_verso->get('ca_objects.display_date')) {
			print "<div class='unit'>Date - ".$vn_date."</div>";
		}		
		if ($vs_verso_collection) {
			print "<div class='unit'>Collection - ".$vs_verso_collection."</div>";
		}
		print caNavLink($this->request, 'View', 'viewLink', '', 'Detail', 'objects/'.$vn_verso_id); 
		print "<a href='#' class='compare_link verso' data-id='".$vn_verso_id."'><i class='fa fa-clone' aria-hidden='true'></i></a>";
		print "</div>";	
?>	

			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
<?php
	}
	
if ($va_related_sketchbook_id = $t_parent->get('ca_collections.related.collection_id', array('restrictToTypes' => array('sketchbook')))) {
	$t_sketchbook = new ca_collections($va_related_sketchbook_id);
	print "<div class='row'><div class='col-sm-12 col-md-12 col-lg-12'>";
	print "<div class='drawer'>";
	print "<h6><a href='#' onclick='$(\"#sketchDiv\").toggle(400);return false;'>Related Sketchbook <i class='fa fa-chevron-down'></i></a></h6>";
	print "<div id='sketchDiv'>";	
	print "<div class='col-sm-3 bResultItemCol' style='float:none;padding-left:0px;'><div class='bResultItem'><div class='bResultItemContent'>";
	if ($va_sk_rep = $t_sketchbook->get('ca_object_representations.media.small', array("checkAccess" => $va_access_values, "limit" => 1))) {
		print "<div class='text-center bResultItemImg'>".caNavLink($this->request, $va_sk_rep, '', '', 'Detail', 'collections/'.$va_related_sketchbook_id)."</div>";
	} else {
		$vs_buf.= '<div class="bResultItemImgPlaceholder"><i class="fa fa-picture-o fa-2x"></i></div>';
	}
	print "<div class='bResultItemText'>";
	print "<p>".caNavLink($this->request, $t_sketchbook->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_related_sketchbook_id)."</p>"; 
	if ($vs_date = $t_sketchbook->get('ca_collections.display_date')) {
		print "<p>".$vs_date."</p>"; 
	}
	if ($va_collection = $t_sketchbook->getWithTemplate('<unit relativeTo="ca_collections_x_collections" restrictToTypes="collection,other"><if rule="^ca_collections_x_collections.current_collection =~ /yes/"><unit relativeTo="ca_collections" >^ca_collections.preferred_labels</unit></if></unit>')) {
		print "<p>".$va_collection."</p>";
	}	
	print caNavLink($this->request, 'View', 'viewLink', '', 'Detail', 'collections/'.$va_related_sketchbook_id); 
	print "<a href='#' class='compare_link' data-id='".$va_related_sketchbook_id."'><i class='fa fa-clone' aria-hidden='true'></i></a>";	
	print "</div></div></div></div>";
	print "</div><!-- end sketchdiv --></div><!-- end drawer -->";
	print "</div></div><!-- end col end row -->";
}
?>
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_remarks = $t_object->get('ca_objects.remarks')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#remarksDiv\").toggle(400);return false;'>Remarks <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='remarksDiv'>".$vs_remarks."</div>";
			print "</div>";
		}
?>		
	</div><!-- end col -->
</div><!-- end row -->
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_rel_works = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			$vs_buf = null;
			foreach ($vs_rel_works as $va_key => $vs_rel_work_id) {		
				$t_work = new ca_objects($vs_rel_work_id);
				$vn_parent_id = $t_work->get("ca_objects.parent_id");
				$t_rel_parent = new ca_objects($vn_parent_id);
				$vs_buf.= "<div class='col-sm-3 bResultItemCol'><div class='bResultItem'><div class='bResultItemContent'>";
				if ($va_rep = $t_work->get('ca_object_representations.media.small', array("checkAccess" => $va_access_values))) {
					$vs_buf.= "<div class='text-center bResultItemImg'>".caNavLink($this->request, $va_rep, '', '', 'Detail', 'objects/'.$vs_rel_work_id)."</div>";
				} else {
					$vs_buf.= '<div class="bResultItemImgPlaceholder"><i class="fa fa-picture-o fa-2x"></i></div>';
				}
				$vs_buf.= "<div class='bResultItemText'>";
				if ($vs_catno = $t_work->get('ca_objects.catalog_number')) {
					$vs_buf.= "<p>".$vs_catno."</p>"; 
				}	
				$vs_buf.= "<p>".caNavLink($this->request, $t_work->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vs_rel_work_id)."</p>"; 
				if ($vs_date = $t_work->get('ca_objects.display_date')) {
					$vs_buf.= "<p>".$vs_date."</p>"; 
				}
				if ($va_collection = $t_rel_parent->getWithTemplate('<unit relativeTo="ca_objects_x_collections"><if rule="^ca_objects_x_collections.current_collection =~ /yes/"><unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit></if></unit>')) {
					$vs_buf.= "<p>".$va_collection."</p>";
				}	
				$vs_buf.= "<a href='#' class='compare_link' data-id='".$vs_rel_work_id."'><i class='fa fa-clone' aria-hidden='true'></i></a>";
				$vs_buf.= "</div></div></div><!-- end col -->";			
				$vs_buf.= "</div>";
			}
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#relatedWorksDiv\").toggle(400);return false;'>Related Works <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='relatedWorksDiv'><div class='row'>".$vs_buf."</div></div>";
			print "</div>";
		}
?>		
	</div>
</div><!-- end row -->	
<?php
	$vs_provenance = "";
	if ($va_provenance = $t_parent->get('ca_objects_x_collections.relation_id', array('returnWithStructure' => true, 'restrictToTypes' => array('collection', 'other'), 'sort' => 'ca_objects_x_collections.rank', 'sortOrder' => 'ASC'))) {
		foreach ($va_provenance as $va_key => $va_relation_id) {
			$t_prov_rel = new ca_objects_x_collections($va_relation_id);
			$t_prov = new ca_collections($t_prov_rel->get('ca_collections.collection_id'));
			if ($t_prov->get('ca_collections.public_private', array('convertCodesToDisplayText' => true)) == 'private') {
				$vs_provenance.= "<div>";
				$vs_provenance.= $t_prov->get('ca_collections.preferred_labels');
				if ($vs_display_date = $t_prov_rel->get('ca_objects_x_collections.display_date')) {
					$vs_provenance.= ", ".$vs_display_date;
				}				
				if ($vs_remark = $t_prov_rel->get('ca_objects_x_collections.collection_line')) {
					$vs_provenance.= ", ".$vs_remark;
				}				
				$vs_provenance.= "</div>";
			} elseif ($t_prov->get('access') != 0 ){
				$va_provenance_id = $t_prov->get('ca_collections.collection_id');
				$vs_provenance.= "<div>".caNavLink($this->request, $t_prov->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_provenance_id);				
				if ($t_prov_rel) {
					$vs_buf = array();
					if ($vs_auction_name = $t_prov_rel->get('ca_objects_x_collections.auction_name')) {
						$vs_buf[]= $vs_auction_name;
					}						
					if ($vs_sale = $t_prov_rel->get('ca_objects_x_collections.sale_name')) {
						$vs_buf[]= $vs_sale;
					}
					if ($vs_display_date = $t_prov_rel->get('ca_objects_x_collections.display_date')) {
						$vs_buf[]= $vs_display_date;
					}
					if ($vs_lot_number = $t_prov_rel->get('ca_objects_x_collections.lot_number')) {
						$vs_buf[]= "Lot number ".$vs_lot_number;
					}
					if ($t_prov_rel->get('ca_objects_x_collections.gift_artist') == $vs_list_value) {
						$vs_buf[] = "gift of the artist";
					}
					if ($t_prov_rel->get('ca_objects_x_collections.sold_yn') == 163) { 
						$vs_buf[]= "(not sold)";
					}	
					if (sizeof($vs_buf) > 0){
						$vs_provenance.= ", ".join(', ', $vs_buf);
					}
					if ($vs_remark = $t_prov_rel->get('ca_objects_x_collections.collection_line')) {
						$vs_provenance.= ", ".$vs_remark;
					}
				}
				if ($t_prov_rel->get('ca_objects_x_collections.uncertain') == $vs_list_value) {
					$vs_provenance.= " <i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>";
				}
				$vs_provenance.= "</div><!-- end prov entry -->";
			}
		}
	}
	if ($vs_provenance != "") {
		print "<div class='row'><div class='col-sm-12 col-md-12 col-lg-12'><div class='drawer'>";
		print "<h6><a href='#' onclick='$(\"#provenanceDiv\").toggle(400);return false;'>Provenance <i class='fa fa-chevron-down'></i></a></h6>";
		print "<div id='provenanceDiv'>";
		print $vs_provenance;
		print "</div><!-- end provenanceDiv -->";
		print "</div><!-- end drawer --></div><!-- end col --></div><!-- end row -->";
	}
?>		
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_exhibition = $t_object->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_objects_x_occurrences" sort="ca_occurrences.occurrence_dates"><l><i>^ca_occurrences.preferred_labels</i></l><unit relativeTo="ca_occurrences"><ifcount min="1" code="ca_entities.preferred_labels">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="venue" delimiter=", "> ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit></ifcount></unit><ifdef code="ca_occurrences.occurrence_dates">, ^ca_occurrences.occurrence_dates</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</if><ifdef code="ca_objects_x_occurrences.exhibition_remarks">, ^ca_objects_x_occurrences.exhibition_remarks</ifdef>.<if rule="^ca_objects_x_occurrences.uncertain =~ /yes/"> <i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-content="uncertain"></i></if></unit>')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#exhibitionDiv\").toggle(400);return false;'>Exhibitions <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='exhibitionDiv'>".$vs_exhibition."</div>";
			print "</div>";
		}
?>		
	</div>
</div><!-- end row -->
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_reference = $t_object->getWithTemplate('<unit restrictToTypes="reference" sort="ca_occurrences.occurrence_dates" delimiter="<br/>" relativeTo="ca_objects_x_occurrences" skipWhen=\'^ca_occurrences.preferred_labels.name = ""\'><l>^ca_occurrences.preferred_labels</l><ifdef code="ca_objects_x_occurrences.reference_remarks">: ^ca_objects_x_occurrences.reference_remarks</ifdef>.<if rule="^ca_objects_x_occurrences.uncertain =~ /yes/"> <i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-content="uncertain"></i></if></unit>')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#referenceDiv\").toggle(400);return false;'>References <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='referenceDiv'>".$vs_reference."</div>";
			print "</div>";
		}
?>		
	</div>
</div><!-- end row -->
		
</div><!-- end container -->	

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
<script>
	jQuery(document).ready(function() {
		$('.fa-question-circle').popover(); 
	});
	
</script>