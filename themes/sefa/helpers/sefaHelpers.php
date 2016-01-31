<?php
/** ---------------------------------------------------------------------
 * themes/sefa/helpers/sefaHelpers.php : theme specific helpers
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2014 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage utils
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 * 
 * ----------------------------------------------------------------------
 */
   
/**
 * Format artwork caption
 *
 * @param RequestHTTP $po_request
 * @param ca_objects object of record
 */

   	function sefaFormatCaption($o_request, $o_object = null) {
		$va_access_values = caGetUserAccessValues($o_request);
		$va_caption_parts = array();
		if(is_object($o_object) && $o_object->get("object_id")){
			$vs_name = $vs_title = $vs_year = $vs_medium = $vs_dimensions = "";
			#if($vs_name = $o_object->getWithTemplate("^ca_entities.preferred_labels.display_name", array("restrictToRelationshipTypes" => array("creator", "creator_website"), "checkAccess" => $va_access_values))){
			if($vs_name = $o_object->get("ca_entities", array("restrictToRelationshipTypes" => array("creator", "creator_website", "creator_hidden")))){
				$va_caption_parts[] = $vs_name;
			}
			if($o_object->get("ca_objects.preferred_labels.name")){
				$vs_title = "<i>".$o_object->get("ca_objects.preferred_labels.name")."</i> ";
			}
			if($vs_year = $o_object->get("ca_objects.date_created")){
				$vs_title .= "(".$vs_year.")";
			}
			if($vs_title){
				$va_caption_parts[] = $vs_title;
			}
			# -- medium/materials
			if($o_object->get("materials_notes")){
				$va_caption_parts[] = $o_object->get("materials_notes");
			}else{
				if($o_object->get("sculpture_material", array('convertCodesToDisplayText' => true)) && $o_object->get("sculpture_material", array('convertCodesToDisplayText' => true)) != " "){
					$va_medium = $o_object->get("sculpture_material", array('convertCodesToDisplayText' => true, 'returnWithStructure' => true));
					if(sizeof($va_medium) > 2){
						$vs_medium = $o_object->get("sculpture_material", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}else{
						$vs_medium = $o_object->get("sculpture_material", array('convertCodesToDisplayText' => true, 'delimiter' => ' and '));
					}	
				}elseif($o_object->get("mixed_media_material", array('convertCodesToDisplayText' => true)) && $o_object->get("mixed_media_material", array('convertCodesToDisplayText' => true)) != " "){
					$va_medium = $o_object->get("mixed_media_material", array('convertCodesToDisplayText' => true, 'returnWithStructure' => true));
					if(sizeof($va_medium) > 2){
						$vs_medium = $o_object->get("mixed_media_material", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}else{
						$vs_medium = $o_object->get("mixed_media_material", array('convertCodesToDisplayText' => true, 'delimiter' => ' and '));
					}	
				}elseif($o_object->get("photography_material", array('convertCodesToDisplayText' => true)) && $o_object->get("photography_material", array('convertCodesToDisplayText' => true)) != " "){
					$va_medium = $o_object->get("photography_material", array('convertCodesToDisplayText' => true, 'returnWithStructure' => true));
					if(sizeof($va_medium) > 2){
						$vs_medium = $o_object->get("photography_material", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}else{
						$vs_medium = $o_object->get("photography_material", array('convertCodesToDisplayText' => true, 'delimiter' => ' and '));
					}	
				}elseif($o_object->get("works_paper_medium", array('convertCodesToDisplayText' => true)) && $o_object->get("works_paper_medium", array('convertCodesToDisplayText' => true)) != " "){
					$va_medium = $o_object->get("works_paper_medium", array('convertCodesToDisplayText' => true, 'returnWithStructure' => true));
					if(sizeof($va_medium) > 2){
						$vs_medium = $o_object->get("works_paper_medium", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}else{
						$vs_medium = $o_object->get("works_paper_medium", array('convertCodesToDisplayText' => true, 'delimiter' => ' and '));
					}
				}elseif($o_object->get("painting_medium", array('convertCodesToDisplayText' => true)) && $o_object->get("painting_medium", array('convertCodesToDisplayText' => true)) != " "){
					$va_medium = $o_object->get("painting_medium", array('convertCodesToDisplayText' => true, 'returnWithStructure' => true));
					if(sizeof($va_medium) > 2){
						$vs_medium = $o_object->get("painting_medium", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}else{
						$vs_medium = $o_object->get("painting_medium", array('convertCodesToDisplayText' => true, 'delimiter' => ' and '));
					}
					if($o_object->get("painting_material", array('convertCodesToDisplayText' => true)) && $o_object->get("painting_material", array('convertCodesToDisplayText' => true)) != " "){
						$vs_medium .= " on ".$o_object->get("painting_material", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}
				}elseif($o_object->get("print_medium", array('convertCodesToDisplayText' => true)) && $o_object->get("print_medium", array('convertCodesToDisplayText' => true)) != " "){
					$va_medium = $o_object->get("print_medium", array('convertCodesToDisplayText' => true, 'returnWithStructure' => true));
					if(sizeof($va_medium) > 2){
						$vs_medium = $o_object->get("print_medium", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}else{
						$vs_medium = $o_object->get("print_medium", array('convertCodesToDisplayText' => true, 'delimiter' => ' and '));
					}
					if($o_object->get("print_material", array('convertCodesToDisplayText' => true)) && ($o_object->get("print_material", array('convertCodesToDisplayText' => true)) != " ")){
						$vs_medium .= " on ".$o_object->get("print_material", array('convertCodesToDisplayText' => true, 'delimiter' => ', '));
					}
				}
				if($vs_medium){
					$va_caption_parts[] = $vs_medium;
				}
			}
			# -- dimensions
			if($vs_dimensions = $o_object->get("ca_objects.dimensions.display_dimensions")){
				$va_caption_parts[] = $vs_dimensions;
			}
			# --- availability
			$vs_available = "";
			if(($o_object->get("type_id") != 27) && ($o_object->get("availability", array('convertCodesToDisplayText' => true)) == "sold")){
				$vs_available = " <span class='captionAvailable'><i class='fa fa-circle'></i></span>";
			}
			return implode(", ", $va_caption_parts).$vs_available;
		}else{
			return null;
		}
	}
?>