<?php
/** ---------------------------------------------------------------------
 * themes/nhf/helpers/nhfHelpers.php : theme specific helpers
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2017 Whirl-i-Gig
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
 * return array of collection ids with video
 *
 * @param RequestHTTP $po_request
 */

   	function nhfCollectionsWithClips($o_request) {
   		$va_collection_ids = array();
   		$o_db = new Db();
   		$va_access_values = caGetUserAccessValues($o_request);
   		$q_collections_with_media = $o_db->query("
   			SELECT DISTINCT c.collection_id
   			FROM ca_collections c
   			INNER JOIN ca_occurrences_x_collections AS oc ON oc.collection_id = c.collection_id
   			INNER JOIN ca_objects_x_occurrences AS oo ON oo.occurrence_id = oc.occurrence_id
   			INNER JOIN ca_objects_x_object_representations AS oor ON oor.object_id = oo.object_id
   			INNER JOIN ca_occurrences as occ ON occ.occurrence_id = oc.occurrence_id
   			INNER JOIN ca_objects AS o ON oo.object_id = o.object_id
   			INNER JOIN ca_object_representations AS obr ON obr.representation_id = oor.representation_id
   			WHERE o.access IN (".join(", ", $va_access_values).") 
   			AND c.access IN (".join(", ", $va_access_values).") 
   			AND obr.access IN (".join(", ", $va_access_values).") 
   			AND occ.access IN (".join(", ", $va_access_values).") 
   		");
   		if($q_collections_with_media->numRows()){
   			while($q_collections_with_media->nextRow()){
   				$va_collection_ids[] = $q_collections_with_media->get("ca_collections.collection_id");
   			}
   		}
   		
   		return $va_collection_ids;
   	
   	}
   	
   	function nhfOccWithClips($o_request, $vn_collection_id = null) {
   		$va_occurrence_ids = array();
   		$o_db = new Db();
   		$va_access_values = caGetUserAccessValues($o_request);
   		$vs_wheres = "";
   		if($vn_collection_id){
   			$vs_wheres = " AND c.collection_id = ".$vn_collection_id;
   		}
   		$q_occs_with_media = $o_db->query("
   			SELECT DISTINCT occ.occurrence_id
   			FROM ca_collections c
   			INNER JOIN ca_occurrences_x_collections AS oc ON oc.collection_id = c.collection_id
   			INNER JOIN ca_objects_x_occurrences AS oo ON oo.occurrence_id = oc.occurrence_id
   			INNER JOIN ca_objects_x_object_representations AS oor ON oor.object_id = oo.object_id
   			INNER JOIN ca_occurrences as occ ON occ.occurrence_id = oc.occurrence_id
   			INNER JOIN ca_objects AS o ON oo.object_id = o.object_id
   			INNER JOIN ca_object_representations AS obr ON obr.representation_id = oor.representation_id
   			WHERE o.access IN (".join(", ", $va_access_values).") 
   			AND c.access IN (".join(", ", $va_access_values).") 
   			AND obr.access IN (".join(", ", $va_access_values).") 
   			AND occ.access IN (".join(", ", $va_access_values).")  
   			{$vs_wheres}
   		");
   		if($q_occs_with_media->numRows()){
   			while($q_occs_with_media->nextRow()){
   				$va_occurrence_ids[] = $q_occs_with_media->get("ca_occurrences.occurrence_id");
   			}
   		}
   		
   		return $va_occurrence_ids;
   	
   	}
?>