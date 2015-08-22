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
 	require_once(__CA_MODELS_DIR__."/ca_places.php");
 	
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
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();

	if(!($vs_placeholder = $o_config->get("placeholder_media_icon"))){
		$vs_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_placeholder."</div>";
	
	$o_lightbox_config = caGetLightboxConfig();
	$vs_lightbox_icon = $o_lightbox_config->get("addToLightboxIcon");
	if(!$vs_lightbox_icon){
		$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
	}
	
	$t_lists = new ca_lists();
	$va_eggshell_type_ids = array($t_lists->getItemIDFromList("object_types", "fossil"), $t_lists->getItemIDFromList("object_types", "recent"), $t_lists->getItemIDFromList("object_types", "pseudo"), $t_lists->getItemIDFromList("object_types", "associated"));
	$va_vertebrate_type_ids = array($t_lists->getItemIDFromList("object_types", "vertebrate"), $t_lists->getItemIDFromList("object_types", "vertebrate_item"), $t_lists->getItemIDFromList("object_types", "vertebrate_cast"), $t_lists->getItemIDFromList("object_types", "ost_specimen"));
	$va_track_type_ids = array($t_lists->getItemIDFromList("object_types", "track"), $t_lists->getItemIDFromList("object_types", "track_item"), $t_lists->getItemIDFromList("object_types", "tracing"), $t_lists->getItemIDFromList("object_types", "cast"));
	$va_place_type_ids_to_exclude = array($t_lists->getItemIDFromList("place_types", "continent"), $t_lists->getItemIDFromList("place_types", "city"), $t_lists->getItemIDFromList("place_types", "basin"), $t_lists->getItemIDFromList("place_types", "other"), $t_lists->getItemIDFromList("place_types", "locality"));
	$va_place_type_ids_to_exclude_vert = array($t_lists->getItemIDFromList("place_types", "city"), $t_lists->getItemIDFromList("place_types", "basin"), $t_lists->getItemIDFromList("place_types", "other"), $t_lists->getItemIDFromList("place_types", "locality"));
	$t_place = new ca_places();
	
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			
			$va_ids = array();
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$va_ids[] = $qr_res->get("{$vs_table}.{$vs_pk}");
				$vn_c++;
			}
			$qr_res->seek($vn_start);
			$vn_c = 0;
			
			if ($vs_table != 'ca_objects') {
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
			} else {
				$va_images = null;
			}
			
			$va_element_ids = array_keys($t_instance->getApplicableElementCodes(null, false, false));
			ca_attributes::prefetchAttributes($t_instance->getDb(), $t_instance->tableNum(), $va_ids, $va_element_ids);
			
			$vs_add_to_lightbox_msg = addslashes(_t('Add to lightbox'));
			$t_list_item = new ca_list_items();
			
			$va_locality_cache = $va_taxonomy_cache = array();
		
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno				= $qr_res->get('ca_objects.idno');
				$vn_type_id				= $qr_res->get('ca_objects.type_id');
				
				$vs_image = ($vs_table === 'ca_objects') ? $qr_res->getMediaTag("ca_object_representations.media", 'small', array("checkAccess" => $va_access_values)) : $va_images[$vn_id];
				
				if(!$vs_image && (!in_array($vn_type_id, $va_vertebrate_type_ids))){
					$vs_image = $vs_placeholder_tag;
				}
				if($vs_image){
					$vs_rep_detail_link = caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id, array("subsite" => $this->request->session->getVar("coloradoSubSite")));	
				}
				print "<div class='bResultListItemCol col-xs-12 col-sm-12 col-md-12'>";
				if($vs_rep_detail_link){
					print "<div class='text-center bResultListItemImg'>{$vs_rep_detail_link}</div>";
				}

//
// Eggshells
//
				if (in_array($vn_type_id, $va_eggshell_type_ids)) {										
					if($vs_idno){
						print "<div class='searchFullTitle'>".caDetailLink($this->request, $vs_idno, '', 'ca_objects', $vn_id, array("subsite" => $this->request->session->getVar("coloradoSubSite")), array(), array('action' => $this->request->getAction()))."</div>";
					}
					print "<div class='searchFullText'>";
					print "<div><b>"._t("Specimen Type").":</b> ".caReturnDefaultIfBlank($qr_res->get('ca_objects.specimenType', array("convertCodesToDisplayText" => true, "delimiter" => ", ")))."</div>";
					print "<div><b>"._t("Class").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.class"))."</div>";
					print "<div><b>"._t("Order").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.order"))."</div>";
					print "<div><b>"._t("Family").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.family"))."</div>";
					print "<div><b>"._t("Genus").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.genus"))."</div>";
					print "<div><b>"._t("Species").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.species"))."</div>";
					print "</div><!-- END text1 -->";
					print "<div class='searchFullText2'>";
					print "<div><b>"._t("Parataxon").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.parataxon"))."</div>";
					print "<div><b>"._t("Pore System").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.poreSystem"))."</div>";
					print "<div><b>"._t("Morphotype").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.morphotype"))."</div>";
					# --- place hierarchy
					$vs_locality = "";
					$va_locality_list = $qr_res->get("ca_places", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
					if(sizeof($va_locality_list)){
						foreach($va_locality_list as $va_locality){
							$va_hierarchy = caExtractValuesByUserLocale($t_place->getHierarchyAncestors($va_locality["place_id"], array("additionalTableToJoin" => "ca_place_labels", "additionalTableSelectFields" => array("name"))));
							$va_hierarchy = array_reverse($va_hierarchy);
							array_shift($va_hierarchy);
							foreach($va_hierarchy as $va_hier_locality){
								if(!in_array($va_hier_locality["type_id"], $va_place_type_ids_to_exclude)){
									$vs_locality .= $va_hier_locality["name"]." / ";
								}
							}
						}
					}
					if($qr_res->get('ca_places.idno') && in_array($qr_res->get('ca_places.access'), $va_access_values)){
						$vs_locality .= caDetailLink($this->request, $qr_res->get('ca_places.idno', array('delimiter' => ', ', 'checkAccess' => $va_access_values)), '', 'ca_places', $qr_res->get('ca_places.place_id'), array("subsite" => "eggshell"));
					}
					print "<div><b>"._t('Locality').":</b> ".caReturnDefaultIfBlank($vs_locality)."</div>";
					print "<div><b>"._t("Locality Formation").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_places.formation"))."</div>";
					print "<div><b>"._t("Locality Member").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_places.member"))."</div>";
					print "<div><b>"._t("Locality Age").":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_places.ageNALMA"))."</div>";
					print "</div><!-- END searchFullText -->\n";
				}elseif(in_array($vn_type_id, $va_vertebrate_type_ids)) {

//
// Vertebrates
//
					print "<div class='searchFullTitle'>".caDetailLink($this->request, "UCM ".($vs_idno ? $vs_idno : 'not available'), '', 'ca_objects', $vn_id, array("subsite" => $this->request->session->getVar("coloradoSubSite")), array(), array('action' => $this->request->getAction()))."</div>";
					
					print "<div class='searchFullText".(($vs_image) ? "Small" : "")."'>";	
					$vs_other = $qr_res->get("ca_objects.other_catalog_number");
					print "<div><b>"._t('Alternate Catalog Number').":</b> ".caReturnDefaultIfBlank($vs_other)."</div>";
					if($vn_taxonomy = $qr_res->get('ca_objects.taxonomic_rank', array('idsOnly' => true))){
						if (isset($va_taxonomy_cache[$vn_taxonomy])) { 
							print $va_taxonomy_cache[$vn_taxonomy]; 
						} else { 
						
							$va_hierarchy = caExtractValuesByUserLocale($t_list_item->getHierarchyAncestors($vn_taxonomy, array("includeSelf" => true, "additionalTableToJoin" => "ca_list_item_labels", "additionalTableSelectFields" => array("name_singular"))));
							$va_hierarchy = array_reverse($va_hierarchy);	
						
							$vs_buf = '';				
							foreach($va_hierarchy as $va_hier_taxonomy){
								if($va_hier_taxonomy["parent_id"]){
									$vs_buf .= "<div><b>".$t_lists->getItemFromListForDisplayByItemID("list_item_types", $va_hier_taxonomy["type_id"]).": </b>".$va_hier_taxonomy["name_singular"]."</div>";
								}
							}
							print $va_taxonomy_cache[$vn_taxonomy] = $vs_buf;
						}
					}else{
						print "<div><b>"._t('Taxonomy').":</b> ".caReturnDefaultIfBlank($qr_res->get('ca_objects.taxonomic_rank'))."</div>";					
					}				
					if($vs_description = $qr_res->get("ca_objects.description")){
						print "<div><b>"._t('Description').":</b> {$vs_description}</div>";
					}
					print "<div><b>"._t('Photo').":</b> ".(($vs_image) ? "Yes" : "No")."</div>";
					$vs_cast = $qr_res->get("ca_objects.cast_model", array("convertCodesToDisplayText" => true));
					print "<div><b>"._t('Cast').":</b> ".(($vs_cast) ? $vs_cast : "No")."</div>";
					$vs_track_type_status = $qr_res->get('ca_objects.track_type_status' , array('convertCodesToDisplayText' => true));
					if (substr($vs_track_type_status, -1) == 's'){ $vs_track_type_status = substr($vs_track_type_status, 0, -1);}
					print "<div class='unit'><b>"._t('Type Status').":</b> ".caReturnDefaultIfBlank($vs_track_type_status)."</div>";
										
					print "</div><!-- END searchFullText col1 -->\n";
					print "<div class='searchFullText".(($vs_image) ? "Small" : "")."'>";
					$vs_era = $qr_res->get('ca_places.era', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_period = $qr_res->get('ca_places.period', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_period = str_replace(array("-, -", "-,", ", -", "-"), "", $vs_period);
					$vs_epoch = $qr_res->get('ca_places.epoch', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_epoch = str_replace(array("-, -", "-,", ", -", "-"), "", $vs_epoch);
					$vs_ageNALMA = $qr_res->get('ca_places.ageNALMA', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_unit = $qr_res->get('ca_places.unit', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_group = $qr_res->get('ca_places.group', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_formation = $qr_res->get('ca_places.formation', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_member = $qr_res->get('ca_places.member', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					print "<div><b>"._t('Era').": </b>".caReturnDefaultIfBlank($vs_era)."</div>";
					print "<div><b>"._t('Period').": </b>".caReturnDefaultIfBlank(str_replace(", -", "", $vs_period))."</div>";
					print "<div><b>"._t('Epoch').": </b>".caReturnDefaultIfBlank($vs_epoch)."</div>";
					print "<div><b>"._t('Age').": </b>".caReturnDefaultIfBlank($vs_ageNALMA)."</div>";
					print "<div><b>"._t('Zone').": </b>".caReturnDefaultIfBlank($vs_unit)."</div>";
					print "<div><b>"._t('Group').": </b>".caReturnDefaultIfBlank($vs_group)."</div>";
					print "<div><b>"._t('Formation').": </b>".caReturnDefaultIfBlank($vs_formation)."</div>";
					print "<div><b>"._t('Member').": </b>".caReturnDefaultIfBlank($vs_member)."</div>";
					$vs_locality = "";
					if($qr_res->get('ca_places.idno') && in_array($qr_res->get('ca_places.access'), $va_access_values)){
						$vs_locality = caDetailLink($this->request, $qr_res->get('ca_places.idno', array('delimiter' => ', ', 'checkAccess' => $va_access_values)), '', 'ca_places', $qr_res->get('ca_places.place_id'), array("subsite" => "vertebrate"));
					}
					print "<div><b>"._t('Locality').":</b> ".caReturnDefaultIfBlank($vs_locality)."</div>";
					print "</div><!-- END searchFullText col2 -->\n";
					print "<div class='searchFullText".(($vs_image) ? "Small" : "")."'>";
										
					# --- place hierarchy
					$va_locality_list = $qr_res->get("ca_places", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
					if(sizeof($va_locality_list)){
						foreach($va_locality_list as $va_locality){
							if (isset($va_locality_cache[$va_locality["place_id"]])) { print $va_locality_cache[$va_locality["place_id"]]; continue; }
							$va_hierarchy = caExtractValuesByUserLocale($t_place->getHierarchyAncestors($va_locality["place_id"], array("additionalTableToJoin" => "ca_place_labels", "additionalTableSelectFields" => array("name"))));
							$va_hierarchy = array_reverse($va_hierarchy);
							array_shift($va_hierarchy);
							
							$vs_buf = '';
							foreach($va_hierarchy as $va_hier_locality){
								if(!in_array($va_hier_locality["type_id"], $va_place_type_ids_to_exclude_vert)){
									$vs_buf .= "<div><b>".$t_lists->getItemFromListForDisplayByItemID("place_types", $va_hier_locality["type_id"]).": </b>".$va_hier_locality["name"]."</div>";
								}
							}
							print $va_locality_cache[$va_locality["place_id"]] = $vs_buf;
						}
					}
					print "</div><!-- END searchFullText  col 3 -->\n";
				}elseif(in_array($vn_type_id, $va_track_type_ids)){
//
// Tracks
//
					if($vs_idno){
						print "<div class='searchFullTitle'>".caDetailLink($this->request, "UCM ".$vs_idno, '', 'ca_objects', $vn_id, array("subsite" => $this->request->session->getVar("coloradoSubSite")), array(), array('action' => $this->request->getAction()))."</div>";
					}
					print "<div class='searchFullTextSmall'>";
					print "<div class='searchFullTextTitle'>Taxonomy</div>";
					print "<div><b>"._t('Ichnospecies').":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.ichnospecies", array('convertCodesToDisplayText' => true, 'delimiter' => ', ')))."</div>";
					print "<div><b>"._t('Ichnogenus').":</b> ".caReturnDefaultIfBlank($qr_res->get('ca_objects.ichnogenus' , array('convertCodesToDisplayText' => true, 'delimiter' => ', ')))."</div>";
					print "<div><b>"._t('Trackmaker clade').":</b> ".caReturnDefaultIfBlank($qr_res->get("ca_objects.clade", array('convertCodesToDisplayText' => true, 'delimiter' => ', ')))."</div>";
					print "<div><b>"._t('Track Type').":</b> ".caReturnDefaultIfBlank($qr_res->get('ca_objects.trace_type' , array('convertCodesToDisplayText' => true)))."</div>";
					print "<div><b>"._t('Original').":</b> ".caReturnDefaultIfBlank($qr_res->get('ca_objects.original' , array('convertCodesToDisplayText' => true)))."</div>";	
					print "<div><b>"._t('Natural Cast or True Track').":</b> ".caReturnDefaultIfBlank($qr_res->get('ca_objects.natura_true' , array('convertCodesToDisplayText' => true)))."</div>";
					if (($vn_type_id == $t_lists->getItemIDFromList("object_types", "track")) || ($vn_type_id == $t_lists->getItemIDFromList("object_types", "track_item"))){
						if($qr_res->get('ca_objects.related.idno', array('delimiter' => ', '))){
							print "<div><b>"._t('Tracing Number').":</b> ".$qr_res->get('ca_objects.related.idno', array('delimiter' => ', ', 'template' => '<l>^ca_objects.related.idno</l>'))."</div>";
						}		
					}
					if ($vn_type_id == $t_lists->getItemIDFromList("object_types", "tracing")){
						if($qr_res->get('ca_objects.related.idno', array('delimiter' => ', '))){
							print "<div><b>"._t('Track').":</b> ".$qr_res->get('ca_objects.related.idno', array('delimiter' => ', ', 'template' => '<l>^ca_objects.related.idno</l>'))."</div>";
						}		
					}									
					print "</div><!-- end searchFullText -->\n";
					print "<div class='searchFullTextSmall'>";
					print "<div class='searchFullTextTitle'>Stratigraphy</div>";
					$vs_era = $qr_res->get('ca_places.era', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_period = $qr_res->get('ca_places.period', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_period = str_replace(array("-, -", "-,", ", -", "-"), "", $vs_period);
					$vs_epoch = $qr_res->get('ca_places.epoch', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_epoch = str_replace(array("-, -", "-,", ", -", "-"), "", $vs_epoch);
					$vs_group = $qr_res->get('ca_places.group', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					$vs_formation = $qr_res->get('ca_places.formation', array("convertCodesToDisplayText" => true, "delimiter" => ", "));
					print "<div><b>"._t('Era').": </b>".caReturnDefaultIfBlank($vs_era)."</div>";
					print "<div><b>"._t('Period').": </b>".caReturnDefaultIfBlank(str_replace(", -", "", $vs_period))."</div>";
					print "<div><b>"._t('Epoch').": </b>".caReturnDefaultIfBlank($vs_epoch)."</div>";
					print "<div><b>"._t('Group').": </b>".caReturnDefaultIfBlank($vs_group)."</div>";
					print "<div><b>"._t('Formation').": </b>".caReturnDefaultIfBlank($vs_formation)."</div>";
					$vs_locality = "";
					if($qr_res->get('ca_places.idno') && in_array($qr_res->get('ca_places.access'), $va_access_values)){
						$vs_locality = caDetailLink($this->request, $qr_res->get('ca_places.idno', array('delimiter' => ', ', 'checkAccess' => $va_access_values)), '', 'ca_places', $qr_res->get('ca_places.place_id'), array("subsite" => "tracks"));
					}
					print "<div><b>"._t('Locality').":</b> ".caReturnDefaultIfBlank($vs_locality)."</div>";
					print "</div><!-- END searchFullText col2 -->\n";
					# --- place hierarchy
					$va_locality_list = $qr_res->get("ca_places", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
					
					if(sizeof($va_locality_list)){
						print "<div class='searchFullTextSmall'>";
						print "<div class='searchFullTextTitle'>Geographic Location</div>";				
						foreach($va_locality_list as $va_locality){
							$va_hierarchy = caExtractValuesByUserLocale($t_place->getHierarchyAncestors($va_locality["place_id"], array("additionalTableToJoin" => "ca_place_labels", "additionalTableSelectFields" => array("name"))));
							$va_hierarchy = array_reverse($va_hierarchy);
							array_shift($va_hierarchy);
							foreach($va_hierarchy as $va_hier_locality){
								if(!in_array($va_hier_locality["type_id"], $va_place_type_ids_to_exclude)){
									print "<div><b>".$t_lists->getItemFromListForDisplayByItemID("place_types", $va_hier_locality["type_id"]).": </b>".$va_hier_locality["name"]."</div>";
								}
							}
						}
						print "</div><!-- END searchFullText  col 3 -->\n";
					}
				}								
				print "<div style='clear:both;'></div></div><!-- end col -->";
				
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
		}