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
	<div class='col-sm-6 col-md-6 col-lg-5'>
		<H1 style='margin-top:40px;'>{{{ca_objects.preferred_labels.name}}}</H1>
<?php
		$t_parent = new ca_objects($t_object->get('ca_objects.parent_id'));
		if ($va_date = $t_object->get('ca_objects.display_date')) {
			$va_creation_date = $t_object->get('ca_objects.creation_date');
			print "<div class='unit'>Creation year - ".caNavLink($this->request, $va_date, '', 'Search', 'artworks', 'search/ca_objects.creation_date:'.$va_creation_date)."</div>";
		}
		if ($va_medium = $t_object->get('ca_objects.medium', array('returnWithStructure' => true))) {
			$va_media_links = array();
			foreach ($va_medium as $va_key => $va_medium_id_t) {
				foreach ($va_medium_id_t as $va_key => $va_medium_id) {
					if ($va_medium_id['medium_list'] == 387){continue;}
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
				$va_paper_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_paper_id), '', '', 'Browse', 'artworks/facet/paper_facet/id/'.$va_paper_id);	
			}
			print "<div class='unit'>Support - ".join(', ', $va_paper_links)."</div>";
		}				
		if ($va_mount = $t_parent->get('ca_objects.mount', array('returnAsArray' => true, 'excludeIdnos' => array('null')))) {
			$va_mount_links = array();
			foreach ($va_mount as $va_key => $va_mount_id) { 
				$va_mount_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_mount_id), '', '', 'Browse', 'artworks/facet/mount_facet/id/'.$va_mount_id);	
			}
			print "<div class='unit'>Mount - ".join(', ', $va_mount_links)."</div>";
		}
		if ($va_watermark = $t_object->get('ca_objects.watermark', array('returnWithStructure' => true))) {
			$va_media_links = array();
			foreach ($va_watermark as $va_key => $va_watermark_id_t) {
				foreach ($va_watermark_id_t as $va_key => $va_watermark_id) {
					if ($va_watermark_id['watermark_list'] == 387){continue;}
					$va_media_links[] = caNavLink($this->request, strtolower(caGetListItemByIDForDisplay($va_watermark_id['watermark_list'])), '', '', 'Browse', 'artworks/facet/watermark_facet/id/'.$va_watermark_id['watermark_list']).($vs_list_value == $va_watermark_id['watermark_uncertain'] ? " <i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "" );	
				}
			}
			if (sizeof($va_media_links) > 0) {
				print "<div class='unit'>watermark - ".join(', ', $va_media_links)."</div>";
			}
		}				
		if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions.display_dimensions" min="1"><unit delimiter="<br/>"><ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"> (^ca_objects.dimensions.dimensions_notes)</ifdef><if rule="^ca_objects.dimensions.dimensions_uncertain =~ /163/"> <i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-content="uncertain"></i></if></unit></ifcount>')) {
			print "<div class='unit'>Dimensions - ".$vs_dimensions."</div>";
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
		if ($qr_collections = $t_parent->get('ca_objects_x_collections.relation_id', array('returnAsSearchResult' => true))) {
			while($qr_collections->nextHit()) {
				if ($qr_collections->get('ca_collections.deleted') === null) { continue; } // you check for null because get() won't return info about deleted items
				
				if ($qr_collections->get('ca_objects_x_collections.current_collection', array('convertCodesToDisplayText' => true)) == $vs_list_value) {
					$vn_current_collection_id = $qr_collections->get('ca_objects_x_collections.collection_id');
					print "<div class='unit'>Collection - ".$qr_collections->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>')." ".(($qr_collections->get('ca_objects_x_collections.uncertain') == $vs_list_value) ? "<i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "")."</div>";
					if ($vs_credit_line = $qr_collections->get('ca_objects_x_collections.collection_line')) {
						print "<div class='unit'>Credit - ".$vs_credit_line."</div>";
					}
					if ($vs_institutional = $t_object->get('ca_collections.institutional_id')) {
						print "<div class='unit'>Institutional id - ".$vs_institutional."</div>";
					}						
				}			
			}
		}	
		if ($va_catalog_id = $t_object->get('ca_objects.catalog_number')) {
			print "<div class='unit'>Catalog ID - ".$va_catalog_id."</div>";
		}
		if ($va_copyright = $t_parent->get('ca_objects.copyright')) {
			print "<div class='unit'>Copyright - ".$va_copyright."</div>";
		}		
		if ($va_keywords = $t_object->get('ca_list_items.item_id', array('returnAsArray' => true))) {
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
		if ($va_child_ids = $t_parent->get('ca_objects.children.object_id', array('returnAsArray' => true))) {
			foreach ($va_child_ids as $va_key => $va_child_id) {
				if ($va_child_id != $vn_id) {
					$vn_verso_id = $va_child_id;
				}
			}
		}
	if ($vn_verso_id) {	
?>
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
		<div class='container versoInfo'>
			<div class='row'>
<?php		
		$t_verso = new ca_objects($vn_verso_id);
		print "<div class='col-sm-2'>".$t_verso->get('ca_object_representations.media.small')."</div>";
		print "<div class='col-sm-10'>";
		print "<div class='versoTitle unit'>".$t_verso->get('ca_objects.preferred_labels')." <i>(verso)</i></div>";
		if ($vs_verso_date = $t_verso->get('ca_objects.display_date')) {
			print "<div class='unit'>Creation year - ".$vs_verso_date."</div>";
		}
		if ($vs_verso_medium = $t_verso->get('ca_objects.medium.medium_list', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
			print "<div class='unit'>Medium - ".$vs_verso_medium."</div>";
		}	
		if ($vs_cat_id = $t_verso->get('ca_objects.catalog_number')) {
			print "<div class='unit'>Catalog ID - ".$vs_cat_id."</div>";
		}
		print caNavLink($this->request, 'View', 'viewLink', '', 'Detail', 'objects/'.$vn_verso_id); 
		print "</div>";	
?>	

			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
<?php
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
<?php
	$vs_provenance = "";
	if ($va_provenance = $t_parent->get('ca_collections', array('returnWithStructure' => true))) {
		foreach ($va_provenance as $va_key => $va_relation_id) {
			$t_prov = new ca_collections($va_relation_id['collection_id']);
			$t_prov_rel = new ca_objects_x_collections($va_relation_id['relation_id']);
			if ($t_prov->get('ca_collections.public_private', array('convertCodesToDisplayText' => true)) == 403) {
				$vs_provenance.= "<div>";
				$vs_provenance.= $t_prov->get('ca_collections.preferred_labels');
				if ($vs_display_date = $t_prov_rel->get('ca_objects_x_collections.display_date')) {
					$vs_provenance.= ", ".$vs_display_date;
				}
				$vs_provenance.= "</div>";
			} else { //if ($t_prov->get('access') != 0 )
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
					if ($t_prov_rel->get('ca_objects_x_collections.sold_yn', array('convertCodesToDisplayText' => true)) == 163) {
						$vs_buf[]= "(not sold)";
					}	
					if (sizeof($vs_buf) > 0){
						$vs_provenance.= ", ".join(', ', $vs_buf);
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
		if ($vs_exhibition = $t_object->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l><ifcount min="1" code="ca_entities.preferred_labels">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="venue" delimiter=", "> ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit></ifcount><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</if><unit relativeTo="ca_objects_x_occurrences"><if rule="^ca_objects_x_occurrences.uncertain =~ /163/"> <i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-content="uncertain"></i></if></unit></unit>')) {
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
		if ($vs_reference = $t_object->getWithTemplate('<unit restrictToTypes="reference" delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.nonpreferred_labels">, ^ca_occurrences.nonpreferred_labels</ifdef></l><ifcount code="ca_entities.preferred_labels" min="1">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", ">^ca_entities.preferred_labels</unit></ifcount><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef></unit>')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#referenceDiv\").toggle(400);return false;'>Reference <i class='fa fa-chevron-down'></i></a></h6>";
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