<?php
/** ---------------------------------------------------------------------
 * themes/ctco/helpers/customThemeHelpers.php : theme specific helpers
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
 * Format source
 *
 * @param RequestHTTP $po_request
 * @param ca_objects object of record
 */

   	function getSourceAsLink($o_request, $source_id, $vs_classname) {
		if(!$source_id){
			return null;
		}
		$va_access_values = caGetUserAccessValues($o_request);
		$t_list_items = new ca_list_items($source_id);
		
		if($vs_source_idno = $t_list_items->get("ca_list_items.idno")){
			$t_entity = new ca_entities();
			$t_entity->load(array("idno" => $vs_source_idno));
			if(!(is_array($va_access_values) && sizeof($va_access_values) && !in_array($t_entity->get("ca_entities.access"), $va_access_values))){
				return caDetailLink($o_request, $t_entity->get("ca_entities.preferred_labels"), $vs_classname, "ca_entities",  $t_entity->get("ca_entities.entity_id"));
			}else{
				return null;
			}
		}
		
		
	
	}
?>