<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Collection finding aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginTop 1.1in
 * @marginBottom 0.5in
 
 * @tables ca_collections
 *
 * ----------------------------------------------------------------------
 */
 	include_once($this->request->getThemeDirectoryPath()."/helpers/findingAidHelpers.php");
 	set_time_limit(300);
 	$t_item = $this->getVar('t_subject');
 	
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = caGetCollectionsConfig();
	$vn_collection_id = $t_item->get("ca_collections.collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	
	$t_list = new ca_lists();
	$va_collection_types = array(
		"collection" => $t_list->getItemIDFromList("collection_types", "collection"),
		"record_group" => $t_list->getItemIDFromList("collection_types", "record_group"),
		"series" => $t_list->getItemIDFromList("collection_types", "series"),
		"subseries" => $t_list->getItemIDFromList("collection_types", "subseries"),
		"file" => $t_list->getItemIDFromList("collection_types", "file"),
		"box" => $t_list->getItemIDFromList("collection_types", "box"),
		"folder" => $t_list->getItemIDFromList("collection_types", "folder")
	);

 	print $this->render($this->getVar('base_path')."/pdfStart.php");
	print $this->render($this->getVar('base_path')."/header.php");
	print $this->render($this->getVar('base_path')."/footer.php");
if ($vn_collection_id) {
	print printLevelPDF($this->request, array($vn_collection_id), $o_collections_config, 1, array("exclude_collection_type_ids" => $va_exclude_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collection_types" => $va_collection_types));
}
	print $this->render($this->getVar('base_path')."/pdfEnd.php");
?>
