<?php
/* ----------------------------------------------------------------------
 * app/plugins/NovaStory/themes/newvamuse/views/place_map_balloon_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2023 Whirl-i-Gig
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
 
	$place_ids		= $this->getVar("place_ids");
	$t_place = new ca_places();
?>
	<div id="memberMapBalloonContainer">
<?php
	$current_name_output = false;
	foreach($place_ids as $place_id){
		$t_place->load($place_id);
		
		if($current_name_output === false) {
			$current_name = $t_place->get('nonpreferred_labels');
			print "<h1>{$current_name}</h1>\n";
			$current_name_output = true;	
		}
		
		$old_name = $t_place->getLabelForDisplay();
		$culture_id = $t_place->get('hierarchy_id');
		$culture = caGetListItemByIDForDisplay($culture_id);
	
		print "<div style='font-size: 12px;'><strong>{$old_name}</strong> ({$culture})</div>\n";
		
		if($t_place->get("notes")){
			print "<blockquote>".$t_place->get("notes")."</blockquote>\n";
		}
	}
?>
	<div style="clear:both"><!-- empty --></div></div><!-- end memberMapBalloonContainer -->