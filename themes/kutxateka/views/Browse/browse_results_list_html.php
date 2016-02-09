<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	# --- get the icon for the object type based on the type_id
	$t_list = new ca_lists();
	$vn_photo_report_type_id = $t_list->getItemIDFromList("object_types", "photo_report");

	if($qr_res->numHits()){
	
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
	
			$vs_rep_detail_link = "";
			$vs_rep_tooltip_img = "";
			
			if ($vs_table == 'ca_objects') {
				if (($vn_s = (int)$qr_res->currentIndex()) < 0) { $vn_s = 0; }
				
				$va_rel_object_ids = array();
				$va_rep_detail_links = array();
				$va_rep_tooltip_imgs = array();
				$va_images = array();
				while($qr_res->nextHit() && ($vn_c <= $vn_hits_per_block)) {
					# --- if it's a photo report, grab a related object to show the image of
					if($qr_res->get("type_id") == $vn_photo_report_type_id){
						$vn_object_id = $qr_res->get('ca_objects.object_id');
						$va_related_objects = $qr_res->get("ca_objects.related.object_id", array("restrict_to_relationship_types" => array("part_of"), "returnAsArray" => 1, "checkAccess" => $va_access_values, "limit" => 1));
						$va_rel_object_ids[$vn_object_id] = $va_related_objects[0];
					}
					$vn_c++;
				}
				if (sizeof($va_rel_object_ids)) {
					$qr_rel_objects = caMakeSearchResult('ca_objects', array_values($va_rel_object_ids));
					while($qr_rel_objects->nextHit()) {
						$va_related_images[$qr_rel_objects->get("ca_objects.object_id")] = array("mediumlarge" => $qr_rel_objects->getMediaTag('ca_object_representations.media', 'mediumlarge', array('class'=>'esta', 'style'=>'margin-left:-'.$vs_margin.'px;')), "small" => $qr_rel_objects->getMediaTag('ca_object_representations.media', 'small', array('class'=>'esta')));
						$vn_object_id = $qr_rel_objects->get('ca_objects.object_id');
					}
				}
				$vn_c = 1;
				$qr_res->seek($vn_s);
			}


			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vs_tt_class = "";
				if(in_array($vn_c, array(1,3,5,7,9,11,13))){
					$vs_tt_class = "left";
				}else{
					$vs_tt_class = "right";
				}
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label = $qr_res->get("{$vs_table}.preferred_labels.name");
				$vs_label_detail_link 	= caDetailLink($this->request, ((mb_strlen($vs_label) > 280) ? mb_substr($vs_label, 0, 272).'...' : $vs_label), 'verde', $vs_table, $vn_id);
				$va_item = $t_list->getItemFromListByItemID("object_types", $qr_res->get("type_id"));
				$vs_type_class = "";
				if ($vs_table == 'ca_objects') {
					# --- if the result is a photoreport, we need to grab one of the related photos to show.
					if($qr_res->get("type_id") == $vn_photo_report_type_id){
						$vs_rep_detail_link = caDetailLink($this->request, $va_related_images[$va_rel_object_ids[$vn_id]]['small'], '', $vs_table, $vn_id);
						$vs_rep_tooltip_img = $va_related_images[$va_rel_object_ids[$vn_id]]['mediumlarge'];
					}else{
						$vs_rep_detail_link = caDetailLink($this->request, $qr_res->getMediaTag('ca_object_representations.media', 'small', array('class'=>'esta')), '', $vs_table, $vn_id);
						$vs_rep_tooltip_img = $qr_res->getMediaTag('ca_object_representations.media', 'mediumlarge');
					}
				}
				print "<articleList>";
				if($vs_rep_tooltip_img){
					print "<figure class='alignLeft'>".$vs_rep_detail_link."<div class='visor ".$vs_tt_class."''>".$vs_rep_tooltip_img."</div></figure><!-- end div -->";
				}else{
					print "<figure class='alignLeft'><br/><br/><br/><br/><p>"._t("No media available")."</p></figure>";
				}
				print "<H2>".$vs_label_detail_link."</H2>";
				switch($va_item["idno"]){
					case "photo_report":
					case "photo_report_ib":
					case "photo_album":
					case "container":
					case "photo_roll":
						$vs_type_class = "carpeta";
						break;
					# --------------------------------
					case "photo":
						$vs_type_class = "camara";
						break;
					# --------------------------------
					case "artwork":
					case "artwork_components":
						$vs_type_class = "arte";
						break;
					# --------------------------------
					case "books":
						$vs_type_class = "libro";
						break;
					# --------------------------------
				}
				print "<p><span class='items ".$vs_type_class." tooltip' rel='".$qr_res->get("ca_objects.type_id")."' title='".$qr_res->get("type_id", array("convertCodesToDisplayText" => true))."'></span> ";
				$vs_created_by = "";
				$vs_created_by = $qr_res->get("ca_entity_labels.displayname", array("restrict_to_relationship_types" => array("created_by", "created_by_photographer"), "delimiter" => "; ", "limit" => 1, "checkAccess" => $va_access_values));
				$vs_created_by_id = $qr_res->get("ca_entities.entity_id", array("restrict_to_relationship_types" => array("created_by", "created_by_photographer"), "delimiter" => "; ", "limit" => 1, "checkAccess" => $va_access_values));
				print _t("Autor").": ".caNavLink($this->request, ((mb_strlen($vs_created_by) > 20) ? mb_substr($vs_created_by, 0, 17)."...": $vs_created_by), "azul", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $vs_created_by_id));
				if($vs_created_by && $qr_res->get("ca_objects.date")){
					print " | ";
				}
				if($qr_res->get("ca_objects.date")){
					print caNavLink($this->request, $qr_res->get("ca_objects.date"), "azul", "", "Search", "objects", array("search" => $qr_res->get("ca_objects.date")));
				}
				print "</p>
	</articleList><!-- end articleList -->";
				
				$vn_c++;
			}
			# --- ajax load these in browseResultsContainer
			if($qr_res->numHits() > ($vn_start + $vn_hits_per_block)){
				print "<a href='#' class='items btnRight botonDer' onClick='$(\"#browseResultsContainer\").load(\"".caNavUrl($this->request, '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view))."\"); return false;'>"._t('Right')."</a>";
			}
			if($vn_start > 0){
				print "<a href='#' class='items btnLeft botonIzq' onClick='$(\"#browseResultsContainer\").load(\"".caNavUrl($this->request, '*', '*', '*', array('s' => $vn_start - $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view))."\"); return false;'>"._t('Left')."</a>";
			}
		}

	}
?>