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
	$vn_object_id	=		$t_object->get('ca_objects.object_id');
	
	$t_list = new ca_lists();
	$yes_list_value_id =  $t_list->getItemIDFromList('yes_no', 'yes');
	$current_list_value_id =  $t_list->getItemIDFromList('current_previous', 'current');

?>
<div class="container">
	<div class="row">
		<div class="col-xs-1"><div class='previousLink'>{{{previousLink}}}</div></div>
		<div class="col-xs-10">
		
<div class='container'>
	<div class="row detailHead">
		<div class='col-xs-6 objNav'><!--- only shown at small screen size -->
			<div class='resultsLink'>{{{resultsLink}}}</div>
		</div>
		<div class='col-xs-5 pdfLink'>
	<?php		
			#print caNavLink($this->request, caGetThemeGraphic($this->request, 'pdf.png'), 'faDownload', 'Detail', 'objects', $vn_id.'/view/pdf/export_format/_pdf_ca_objects_summary');
	?>	
		</div><!-- end col --> 
	</div>
	<div class="row">
		<div class='col-sm-12 col-md-6 col-lg-6'>
		</div>
		<div class='col-sm-12 col-md-6 col-lg-6 titleCol' >
			<H1>{{{ca_objects.preferred_labels.name}}}</H1>
		</div>
	</div>
	<div class="row">
		<div class='col-sm-10 col-sm-offset-1 col-md-offset-0 col-md-6 col-lg-6 imageCol' style="margin-bottom:40px;">
			{{{representationViewer}}} 
						
			<?php #print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "version" => "iconlarge")); ?>
	<?php
			if ($va_catalog_id = $t_object->get('ca_objects.institutional_id')) { 
				print "<div class='objIdno'>".$va_catalog_id."</div>";
			}	
	?>	
		</div><!-- end col -->		
		<div class='col-sm-10 col-sm-offset-1 col-md-offset-0 col-md-6 col-lg-6 artworkInfo'>
	<?php
			$vn_label_col = "col-sm-4";
			$vn_data_col = "col-sm-8";
			$t_parent = new ca_objects($t_object->get('ca_objects.parent_id'));		
			if ($vs_date = $t_object->get('ca_objects.display_date')) {
				$vs_creation_date = $t_object->get('ca_objects.creation_date');
				print "<div class='unit row'><div class='{$vn_label_col} label'>Date</div><div class='$vn_data_col'>".caNavLink($this->request, $vs_date, '', 'Search', 'artworks', "search/dates", ["values" => json_encode([preg_replace("![ ]*[\-–—][ ]*!u", "-", $vs_creation_date)])])."</div></div>";
			}
			$vn_med = 0;
			if ($va_medium = $t_object->get('ca_objects.medium', array('returnWithStructure' => true))) {
				$va_media_links = array();
				foreach ($va_medium as $va_key => $va_medium_id_t) {
					foreach ($va_medium_id_t as $va_key => $va_medium_id) {
						if ($va_medium_id['medium_list'] == 383){continue;}
						if ($vn_med == 0) {
							$vs_med_name = ucfirst(caGetListItemByIDForDisplay($va_medium_id['medium_list']));
						} else {
							$vs_med_name = strtolower(caGetListItemByIDForDisplay($va_medium_id['medium_list']));
						}
						$va_media_links[] = caNavLink($this->request, $vs_med_name, '', '', 'Browse', 'artworks/facet/medium_facet/id/'.$va_medium_id['medium_list']).($yes_list_value_id == $va_medium_id['medium_uncertain'] ? " <span class='rollover' data-toggle='popover' data-trigger='hover' data-content='uncertain'><i class='fa fa-question-circle' ></i></span>" : "" );	
						$vn_med++;
					}
				}
				if (is_array($va_media_links) && (sizeof($va_media_links) > 0)) {
					print "<div class='unit row'><div class='{$vn_label_col} label'>Medium</div><div class='$vn_data_col'>".join(', ', $va_media_links)."</div></div>";
				}
			}
			if ($va_paper = $t_parent->get('ca_objects.paper', array('returnAsArray' => true, 'excludeIdnos' => array('null')))) {
				$va_paper_links = array();
				foreach ($va_paper as $va_key => $va_paper_id) {
					if ($va_paper_id == 0) {continue;}
					$va_paper_links[] = caNavLink($this->request, ucfirst(caGetListItemByIDForDisplay($va_paper_id)), '', '', 'Browse', 'artworks/facet/paper_facet/id/'.$va_paper_id);	
				}
				if (is_array($va_paper_links) && (sizeof($va_paper_links) > 0)){
					print "<div class='unit row'><div class='{$vn_label_col} label'>Support</div><div class='$vn_data_col'>".join(', ', $va_paper_links)."</div></div>";
				}	
			}				
			if ($va_watermark = $t_parent->get('ca_objects.watermark', array('returnWithStructure' => true))) {
				$va_water_links = array();
				foreach ($va_watermark as $va_key => $va_watermark_id_t) {
					foreach ($va_watermark_id_t as $va_key => $va_watermark_id) {
						if ($va_watermark_id['watermark_list']) {
							$va_water_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_watermark_id['watermark_list']), '', '', 'Browse', 'artworks/facet/watermark_facet/id/'.$va_watermark_id['watermark_list']).($yes_list_value_id == $va_watermark_id['watermark_uncertain'] ? " <span class='rollover' data-toggle='popover' data-trigger='hover' data-content='uncertain'><i class='fa fa-question-circle' ></i></span>" : "" ).($va_watermark_id['watermark_remark'] ? ": ".$va_watermark_id['watermark_remark'] : "");	
						}
					}
				}
				if (is_array($va_water_links) && (sizeof($va_water_links) > 0)) {
					print "<div class='unit row'><div class='{$vn_label_col} label'>Watermark</div><div class='$vn_data_col'>".join(', ', $va_water_links)."</div></div>";
				}
			}
			if ($va_mount = $t_parent->get('ca_objects.mount', array('returnAsArray' => true, 'excludeIdnos' => array('null')))) {
				$va_mount_links = array();
				foreach ($va_mount as $va_key => $va_mount_id) {
					if ($va_mount_id != 0) { 
						$va_mount_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_mount_id), '', '', 'Browse', 'artworks/facet/mount_facet/id/'.$va_mount_id);	
					}
				}
				if (is_array($va_mount_links) && (sizeof($va_mount_links) > 0)) {
					print "<div class='unit row'><div class='{$vn_label_col} label'>Mount</div><div class='{$vn_data_col} mount'>".join(', ', $va_mount_links)."</div></div>";
				}
			}						
			if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions.display_dimensions" min="1"><unit delimiter="<br/>"><ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"> (^ca_objects.dimensions.dimensions_notes)</ifdef><if rule="^ca_objects.dimensions.dimensions_uncertain =~ /yes/"> <span class="rollover" data-toggle="popover" data-trigger="hover" data-content="sight dimensions"><i class="fa fa-question-circle" ></i></span></if></unit></ifcount>')) {
				print "<div class='unit row'><div class='{$vn_label_col} label'>Dimensions</div><div class='$vn_data_col'>".$vs_dimensions."</div></div>";
			}		

			if ($vs_inscription = $t_object->get('ca_objects.inscription')) {
				print "<div class='unit row'><div class='{$vn_label_col} label'>Inscription</div><div class='$vn_data_col'>".$vs_inscription."</div></div>";
			}
			if ($va_estate_id = $t_object->get('ca_objects.estate_number')) {
				print "<div class='unit row'><div class='{$vn_label_col} label'>Estate/Inventory Number</div><div class='$vn_data_col'>".$va_estate_id."</div></div>";
			}

								

			// if ($va_collection = $t_parent->get('ca_objects_x_collections.relation_id', array('returnAsArray' => true))) {
	// 			foreach ($va_collection as $va_key => $va_collection_relation_id) {
	// 				$t_collection_rel = new ca_objects_x_collections($va_collection_relation_id);
	// 				if ($t_collection_rel->get('ca_objects_x_collections.current_collection', array('convertCodesToDisplayText' => true)) == $yes_list_value_id) {
	// 					$vn_current_collection_id = $t_collection_rel->get('ca_objects_x_collections.collection_id');
	// 					print "<div class='unit'>Collection - ".$t_collection_rel->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>')." ".(($t_collection_rel->get('ca_objects_x_collections.uncertain') == $yes_list_value_id) ? "<i class='fa fa-question-circle' data-toggle='popover' data-trigger='hover' data-content='uncertain'></i>" : "")."</div>";
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
				
					$buf = '';
					if ($qr_collections->get('ca_objects_x_collections.current_collection') == $current_list_value_id) {
						$vn_current_collection_id = $qr_collections->get('ca_objects_x_collections.collection_id');
						$t_collection = new ca_collections($vn_current_collection_id);
						
						if ($t_collection->get('ca_collections.public_private', array('convertCodesToDisplayText' => true)) != 'private'){
							$buf .= "<div class='unit row'><div class='{$vn_label_col} label'>Collection</div><div class='$vn_data_col'>".$qr_collections->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>');
							$vs_verso_collection = $qr_collections->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>');
						} else {
							$buf .= "<div class='unit row'><div class='{$vn_label_col} label'>Collection</div><div class='$vn_data_col'>".$qr_collections->getWithTemplate('<unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit>');
							$vs_verso_collection = $qr_collections->getWithTemplate('<unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit>');
						}
						if ($vs_credit_line = $qr_collections->get('ca_objects_x_collections.collection_line')) {
							$buf .= ", ".$vs_credit_line;
						}
						if ($vs_institutional = $t_object->get('ca_objects.institutional_id')) {
							$buf .= ", ".$vs_institutional;
						}
						if ($buf) { $buf .= ". "; }
						if ($va_copyright = $t_parent->get('ca_objects.copyright')) {
							$buf .= $va_copyright;
						}	
						if ($qr_collections->get('ca_objects_x_collections.uncertain') == $yes_list_value_id) {
							$buf .= " <span class='rollover' data-toggle='popover' data-trigger='hover' data-content='uncertain'><i class='fa fa-question-circle' ></i></span>";
						}
						$buf .= "</div><!-- end data --></div><!-- end unit -->";					
					}	
					print $buf;		
				}
			}	

			// if ($va_institutional_id = $t_object->get('ca_objects.institutional_id')) {
// 				print "<div class='unit row'><div class='{$vn_label_col} label'>Institutional ID</div><div class='$vn_data_col'>".$va_institutional_id."</div></div>";
// 			}		
	
			if ($va_photo_credit = $t_object->get('ca_objects.photography_credit_line')) {
				print "<div class='unit row'><div class='{$vn_label_col} label'>Photography Credit</div><div class='$vn_data_col'>".$va_photo_credit."</div></div>";
			}	
			if ($va_keywords = $t_object->get('ca_list_items.item_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
				$vn_keyword = 0;
				$va_keyword_links = array();
				foreach ($va_keywords as $va_key => $va_keyword_id) {
					if ($vn_keyword == 0) {
						$vs_keyword_label = ucfirst(caGetListItemByIDForDisplay($va_keyword_id));
					} else {
						$vs_keyword_label = caGetListItemByIDForDisplay($va_keyword_id);
					}
					$va_keyword_links[] = caNavLink($this->request, $vs_keyword_label, '', '', 'Browse', 'artworks/facet/term_facet/id/'.$va_keyword_id);	
					$vn_keyword++;
				}
				print "<div class='unit row'><div class='{$vn_label_col} label'>Tags</div><div class='$vn_data_col'>".join(', ', $va_keyword_links)."</div></div>";
			}
			print "<div class='detailDivider row' style='margin-bottom:60px;'></div>";	
			#print "<div class='guide'><a href='#'>".caGetThemeGraphic($this->request, 'guide.png')." Guide to Entries</a></div>";									
	?>			
		</div><!-- end col -->
	</div><!-- end row -->
	<div id="guideLoadContainer" style="display:none;">
		<div class="guideLoadInner">
			<div class="close"><a href="#"><?php print caGetThemeGraphic($this->request, 'close.png'); ?></a></div>
			<div id="guideLoad">
	
			</div>	
			<?php print "<div class='complete'>".caNavLink($this->request, 'See the Complete Guide', '', '', 'About', 'notes')."</div>"; ?>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('#guideLoad').load("<?php print caNavUrl($this->request, '', 'About', 'abguide'); ?>");
			$('.guide').click(function(){
				$('#guideLoadContainer').fadeIn(300);
				return false;
			}); 
			$('.close').click(function(){
				$('#guideLoadContainer').fadeOut(300);
				return false;
			}); 
		})
	</script>	
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
?>
	<div class='row'>
		<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
			<div class='container versoInfo'>
				<div class='row' style='margin-left:-10px;margin-right:-10px;'>
	<?php
			$vs_first = true;
			$vs_no_border = "style=border-top:0px;";
			print "<div class='row'><div class='col-sm-12'><h6 class='verso'>Other Side</h6></div></div>";		
			$t_verso = new ca_objects($vn_verso_id);
			print "<div class='row'>";
			print "<div class='col-xs-4 col-sm-3' style='min-height:140px;'>".caNavLink($this->request, $t_verso->get('ca_object_representations.media.medium', array('checkAccess' => $va_access_values)), '', '', 'Detail', 'objects/'.$vn_verso_id)."</div>";
			print "<div class='col-xs-8 col-sm-9' style='min-height:180px;'>";

			print "<div class='versoTitle'>".caNavLink($this->request, $t_verso->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vn_verso_id)."</div>";
			if ($vn_date = $t_verso->get('ca_objects.display_date')) {
				print "<div class=''>".$vn_date."</div>";
			}		
			if ($vs_verso_collection) {
				print "<div class=''>".$vs_verso_collection."</div>";
			}
			print "</div>";
			print "</div>";
			print "<div class='row'>";
			print "<div class='col-xs-4 col-sm-3'></div>";
			print "<div class='col-xs-8 col-sm-9'>";
				if ($vn_catno = $t_verso->get('ca_objects.institutional_id')) {
					print "<div class='catInfo'>".$vn_catno."</div>";
				}			
				print "<a href='#' class='compare_link verso' title='Compare' data-id='object:{$vn_verso_id}'>".caGetThemeGraphic($this->request, 'rothko-compare.svg')."</a>";
			
			print "</div>";
			print "</div>";	
	?>	

				</div><!-- end row -->
			</div><!-- end container -->
		</div><!-- end col -->
		<div class='col-sm-2'></div>
	</div><!-- end row -->
<?php
	$vs_first = false;
	}
	if ($va_related_sketchbook_id = $t_parent->get('ca_collections.related.collection_id', array('restrictToTypes' => array('sketchbook')))) {
		$t_sketchbook = new ca_collections($va_related_sketchbook_id);
		print "<div class='row'><div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>";
		print "<div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
		print "<h6><a href='#' onclick='$(\"#sketchDiv\").toggle(400);return false;'>Sketchbook <i class='fa fa-window-minimize'></i></a></h6>";
		print "<div id='sketchDiv'>";
		print "<div class='container versoInfo'><div class='row'>";	
		print "<div class='col-sm-4' style='padding-left:0px;'>";
		if ($va_sk_rep = $t_sketchbook->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values, "limit" => 1))) {
			print "<div class='text-center bResultItemImg'>".caNavLink($this->request, $va_sk_rep, '', '', 'Detail', 'collections/'.$va_related_sketchbook_id)."</div>";
		} else {
			$vs_buf.= '<div class="bResultItemImgPlaceholder"><i class="fa fa-picture-o fa-2x"></i></div>';
		}
		print "</div>";
		print "<div class='col-sm-8'>";
		print "<div class='versoTitle'>".caNavLink($this->request, $t_sketchbook->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_related_sketchbook_id)."</div>"; 
		if ($vs_date = $t_sketchbook->get('ca_collections.display_date')) {
			print "<div>".$vs_date."</div>"; 
		}
		if ($va_collection = $t_sketchbook->getWithTemplate('<unit relativeTo="ca_collections_x_collections" restrictToTypes="collection,other"><if rule="^ca_collections_x_collections.current_collection =~ /yes/"><unit relativeTo="ca_collections" >^ca_collections.preferred_labels</unit></if></unit>')) {
			print "<div>".$va_collection."</div>";
		}	
		//print "<a href='#' onclick='caMediaPanel.showPanel(\"/index.php/Detail/GetMediaOverlay/context/collections/id/".$va_related_sketchbook_id."/representation_id/".$t_sketchbook->get('ca_object_representations.representation_id')."/overlay/1\"); return false;'>View Sketchbook Pages</a>";
		print caNavLink($this->request, 'View Sketchbook Pages', '', '', 'Detail', 'collections/'.$va_related_sketchbook_id);
		
		print "</div><!-- end col --></div><!-- end row --></div><!-- end container -->";
		print "</div><!-- end sketchdiv --></div><!-- end drawer -->";
		print "</div><div class='col-sm-2'></div></div><!-- end col end row -->";
		$vs_first = false;
	}

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
				$vs_provenance.= "<i class='fa fa-chevron-right'></i></div>";
			} elseif ($t_prov->get('access') != 0 ){
				$va_provenance_id = $t_prov->get('ca_collections.collection_id');
				$vs_prov_line = $t_prov->get('ca_collections.preferred_labels');				
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
					if ($t_prov_rel->get('ca_objects_x_collections.gift_artist') == $yes_list_value_id) {
						$vs_buf[] = "gift of the artist";
					}
					if ($t_prov_rel->get('ca_objects_x_collections.sold_yn') == 163) { 
						$vs_buf[]= "(not sold)";
					}	
					if (is_array($vs_buf) && (sizeof($vs_buf) > 0)){
						$vs_prov_line.= ", ".join(', ', $vs_buf);
					}
				}
				if ($t_prov_rel->get('ca_objects_x_collections.uncertain') == $yes_list_value_id) {
					$vs_prov_line.= " <span class='rollover' data-toggle='popover' data-trigger='hover' data-content='uncertain'><i class='fa fa-question-circle' ></i></span>";
				}
				
				//$vs_provenance_remark = ($t_prov_rel && ($vs_remark = $t_prov_rel->get('ca_objects_x_collections.collection_line'))) ? $vs_remark : null;
				
				$vs_provenance.= "<div>".caNavLink($this->request, $vs_prov_line, '', '', 'Detail', 'collections/'.$va_provenance_id)." {$vs_provenance_remark} <i class='fa fa-chevron-right'></i><!-- end prov entry --></div>";
			}
		}
	}
	if ($vs_provenance != "") {
		print "<div class='row'><div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'><div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
		print "<h6><a href='#' data-toggleDiv='provenanceDiv' class='togglertronic'>Provenance <i class='fa fa-minus drawerToggle'></i></a></h6>";
		print "<div id='provenanceDiv'>";
		print $vs_provenance;
		print "</div><!-- end provenanceDiv -->";
		print "</div><!-- end drawer --></div><!-- end col --></div><!-- end row -->";
		$vs_first = false;
	}
?>		
	<div class='row'>
		<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<?php
			if ($vs_exhibition = $t_object->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_objects_x_occurrences" sort="ca_occurrences.occurrence_dates"><l><i>^ca_occurrences.preferred_labels</i><unit relativeTo="ca_occurrences"><ifcount min="1" code="ca_entities.preferred_labels">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="venue" delimiter=", "> ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit></ifcount></unit><ifdef code="ca_occurrences.occurrence_dates">, ^ca_occurrences.occurrence_dates</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</if><ifdef code="ca_objects_x_occurrences.exhibition_remarks">, ^ca_objects_x_occurrences.exhibition_remarks</ifdef>.<if rule="^ca_objects_x_occurrences.uncertain =~ /Yes/"> <span class="rollover" data-toggle="popover" data-trigger="hover" data-content="uncertain"><i class="fa fa-question-circle" ></i></span></if><i class="fa fa-chevron-right"></i></l></unit>')) {
				print "<div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
				print "<h6><a href='#' data-toggleDiv='exhibitionDiv' class='togglertronic'>Exhibitions <i class='fa fa-minus drawerToggle'></i></a></h6>";
				print "<div id='exhibitionDiv'>".$vs_exhibition."</div>";
				print "</div>";
			}
			$vs_first = false;
?>		
		</div>
	</div><!-- end row -->
	<div class='row'>
		<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<?php
			if ($vs_reference = $t_object->getWithTemplate('<unit restrictToTypes="reference" sort="ca_occurrences.occurrence_dates" delimiter="<br/>" relativeTo="ca_objects_x_occurrences" skipWhen=\'^ca_occurrences.preferred_labels.name = ""\'><l>^ca_occurrences.preferred_labels<ifdef code="ca_objects_x_occurrences.reference_remarks">: ^ca_objects_x_occurrences.reference_remarks</ifdef>.<if rule="^ca_objects_x_occurrences.uncertain =~ /Yes/"> <span class="rollover" data-toggle="popover" data-trigger="hover" data-content="uncertain"><i class="fa fa-question-circle" ></i></span></if><i class="fa fa-chevron-right"></i></l></unit>')) { 
				print "<div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
				print "<h6><a href='#' data-toggleDiv='referenceDiv' class='togglertronic'>References <i class='fa fa-minus drawerToggle'></i></a></h6>";
				print "<div id='referenceDiv'>".$vs_reference."</div>";
				print "</div>";
			}
			$vs_first = false; 
?>		
		</div>
	</div><!-- end row -->
	<div class='row'>
		<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<?php
			if ($vs_rel_works = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
				$vs_buf = null;
				foreach ($vs_rel_works as $va_key => $vs_rel_work_id) {		
					$t_work = new ca_objects($vs_rel_work_id);
					$vn_parent_id = $t_work->get("ca_objects.parent_id");
					$t_rel_parent = new ca_objects($vn_parent_id);
					$vs_buf.= "<div class='col-xs-6 col-md-6 bResultItemCol'><div class='bResultItem'><div class='bResultItemContent'>";
					if ($va_rep = $t_work->get('ca_object_representations.media.small', array("checkAccess" => $va_access_values))) {
						$vs_buf.= "<div class='text-center bResultItemImg'>".caNavLink($this->request, $va_rep, '', '', 'Detail', 'objects/'.$vs_rel_work_id)."</div>";
					} else {
						$vs_buf.= '<div class="bResultItemImgPlaceholder"><i class="fa fa-picture-o fa-2x"></i></div>';
					}
					$vs_buf.= "<div class='bResultItemText'>";
					$vs_buf.= "<p class='resultLabel'>".caNavLink($this->request, $t_work->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vs_rel_work_id)."</p>"; 
					if ($vs_date = $t_work->get('ca_objects.display_date')) {
						$vs_buf.= "<p>".$vs_date."</p>"; 
					}
					if ($va_collection = $t_rel_parent->getWithTemplate('<unit relativeTo="ca_objects_x_collections"><if rule="^ca_objects_x_collections.current_collection =~ /yes/"><unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit></if></unit>')) {
						$vs_buf.= "<p>".$va_collection."</p>";
					}	
					if ($vs_catno = $t_work->get('ca_objects.institutional_id')) {
						$vs_buf.= "<div class='catno'>".$vs_catno."</div>"; 
					}	
					$vs_buf.= "<a href='#' class='compare_link' data-id='object:{$vs_rel_work_id}'>".caGetThemeGraphic($this->request, 'rothko-compare.svg')."</a>";
					$vs_buf.= "</div></div></div><!-- end col -->";			
					$vs_buf.= "</div>";
				}
				print "<div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
				print "<h6><a href='#' data-toggleDiv='relatedWorksDiv' class='togglertronic'>Related Works on Paper<i class='fa fa-minus drawerToggle'></i></a></h6>";
				print "<div id='relatedWorksDiv'><div class='row'>".$vs_buf."</div></div>";
				print "</div>";
				$vs_first = false;
			}
?>		
		</div>
	</div><!-- end row -->	
	<div class='row'>
		<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<?php
			if ($vs_remarks = $t_object->get('ca_objects.remarks')) {
				print "<div class='drawer' ".( $vs_first == true ? $vs_no_border : "").">";
				print "<h6><a href='#' data-toggleDiv='remarksDiv' class='togglertronic'>Remarks <i class='fa fa-minus drawerToggle'></i></a></h6>";
				print "<div id='remarksDiv'><div class='trimText'>".$vs_remarks."</div>";
				
				if ($va_remarks_images = $t_object->get('ca_objects.remarks_images', array('returnWithStructure' => true, 'version' => 'medium'))) {
					print "<div class='row'>";
					foreach ($va_remarks_images as $vn_attribute_id => $va_remarks_image_info) {
						foreach ($va_remarks_image_info as $vn_value_id => $va_remarks_image) {
							print "<div class='col-xs-6 col-sm-6 col-md-6 '><div class='container remarksImg'><div class='row'>"; 
							print "<div class='col-sm-5'>";
							print $va_remarks_image['remark_media'];

							$o_db = new Db();
							$t_element = ca_attributes::getElementInstance('remark_media');
							$vn_media_element_id = $t_element->getElementID('remark_media');							

							$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_value_id, $vn_media_element_id)) ;
							if ($qr_res->nextRow()) {
								$vn_attr_id = (int)$qr_res->get("value_id");
								print "<div class='zoomIcon'><a href='#' title='Zoom' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'identifier' => "attribute:{$vn_attr_id}", 'overlay' => 1))."\"); return false;'>".caGetThemeGraphic($this->request, 'magnify.svg')."</a></div>";
						
								print "<div class='compare'><a href='#' class='compare_link' title='Compare' data-id='attribute:{$vn_attr_id}'>".caGetThemeGraphic($this->request, 'rothko-compare.svg')."</a></div>";
							}
							print "</div>";
							print "<div class='col-sm-7'><div class='remarkText'>".$va_remarks_image['remark_caption']."</div></div>"; 
							print "</div></div></div>";
						}
					}
					print "</div>";
				}				
				
				print "</div>";
				print "</div>";
				$vs_first = false;
			}

?>		
		</div><!-- end col -->
	</div><!-- end row -->		
</div><!-- end container -->	
		
		</div><!-- end col -->
		<div class="col-xs-1"><div class='nextLink'>{{{nextLink}}}</div></div>
	</div>
</div>
		
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 326,
		  moreLink: '<a href="#">More</a>',
		});
	});
</script>
<script>
	jQuery(document).ready(function() {
		$('.rollover').popover(); 

        jQuery('.togglertronic').on('click', function(e) {
            var state = jQuery(this).data('togglestate');
            
            var toggle = this;
            if (state == 'open') {
                jQuery('#' + jQuery(toggle).data('togglediv')).slideUp(200, function() {
                    jQuery(toggle).data('togglestate', 'closed').find('.drawerToggle').hide().attr("class", "fa fa-plus drawerToggle").show();
                });
            } else {
                jQuery('#' + jQuery(toggle).data('togglediv')).slideDown(200, function() {
                    jQuery(toggle).data('togglestate', 'open').find('.drawerToggle').hide().attr("class", "fa fa-minus drawerToggle").show();
                });
                
            }
            e.preventDefault();
            return false;
        });	
	});



</script>
