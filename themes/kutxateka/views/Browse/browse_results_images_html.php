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
	
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			
			if ($vs_table != 'ca_objects') {
				$va_ids = array();
				while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
					$va_ids[] = $qr_res->get($vs_pk);
					$vn_c++;
				}
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small'));
			
				$vn_c = 0;	
				$qr_res->seek($vn_start);
			}
			
			$vs_add_to_lightbox_msg = addslashes(_t('Add to lightbox'));
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label = $qr_res->get("{$vs_table}.preferred_labels.name");
				$vs_label_detail_link 	= caDetailLink($this->request, ((mb_strlen($vs_label) > 75) ? mb_substr($vs_label, 0, 72).'...' : $vs_label), 'verde', $vs_table, $vn_id);
				if ($vs_table == 'ca_objects') {
					$vs_rep_detail_link 	= caDetailLink($this->request, $qr_res->getMediaTag('ca_object_representations.media', 'mediumlarge', array('class'=>'esta')), '', $vs_table, $vn_id);				
					$vs_rep_tooltip_img = $qr_res->getMediaTag('ca_object_representations.media', 'mediumlarge');
				} else {
					$vs_rep_detail_link 	= caDetailLink($this->request, $va_images[$vn_id], '', $vs_table, $vn_id);			
				}
				$vs_add_to_set_url		= caNavUrl($this->request, '', 'Sets', 'addItemForm', array($vs_pk => $vn_id));

				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

				print "<article>";
				if($vs_rep_tooltip_img){
					print "<figure>".$vs_rep_detail_link."<div class='visor left'>".$vs_rep_tooltip_img."</div></figure><!-- end figure -->";
				}else{
					print "<figure><br/><br/><br/><br/><p style='text-align:center;'>"._t("No media available")."</p></figure>";
				}
				print "<H2>".$vs_label_detail_link."</H2>";
				$va_item = $t_list->getItemFromListByItemID("object_types", $qr_res->get("type_id"));
				$vs_type_class = "";
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
				print "<p><span class='items ".$vs_type_class." tooltip' rel='".$qr_res->get("ca_objects.type_id")."'></span> ";
				$vs_created_by = "";
				$vs_created_by = $qr_res->get("ca_entity_labels.displayname", array("restrict_to_relationship_types" => array("created_by", "created_by_photographer"), "delimiter" => "; ", "limit" => 1));
				print _t("Autor").": ".caNavLink($this->request, ((mb_strlen($vs_created_by) > 20) ? mb_substr($vs_created_by, 0, 17)."...": $vs_created_by), "azul", "", "Search", "objects", array("search" => $vs_created_by));
				if($vs_created_by && $qr_res->get("ca_objects.date")){
					print " | ";
				}
				if($qr_res->get("ca_objects.date")){
					print caNavLink($this->request, $qr_res->get("ca_objects.date"), "azul", "", "Search", "objects", array("search" => $qr_res->get("ca_objects.date")));
				}
				print "</p>
	</article><!-- end article -->";
				
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
		}
?>