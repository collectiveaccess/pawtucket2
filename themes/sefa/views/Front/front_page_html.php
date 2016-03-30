<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
?>
<div class="row">
<?php
	$va_access_values = $this->getVar("access_values");
	$o_config = caGetFrontConfig();
	# --- grab the set that has the featured 
	$t_set = new ca_sets();
	$t_set->load(array('set_code' => $o_config->get("front_page_exhibit_set_code")));
	$t_exhibition = new ca_occurrences();
	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
		$va_exhibition_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
		$t_exhibition->load($va_exhibition_ids[0]);
	}
	# --- check to see if there is an image set configured
	$t_set->load(array('set_code' => $o_config->get("front_page_set_code")));
	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
		$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
		$qr_res = caMakeSearchResult('ca_objects', $va_featured_ids);
	}
	if($qr_res && $qr_res->numHits()){
		$qr_res = $this->getVar('featured_set_items_as_search_result');
		while($qr_res->nextHit()){
			if($vs_media = $qr_res->getWithTemplate('^ca_object_representations.media.front', array("checkAccess" => $va_access_values))){
				print "<div class='col-sm-12'><div class='frontSlide'>".$vs_media."</div></div>";
				break;
			}
		}
	}else{
		if($t_exhibition->get("occurrence_id")){
			# --- use the featured image from the show
			$va_objects = $t_exhibition->get('ca_objects', array("checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("used_website"), "returnWithStructure" => true));
			if(is_array($va_objects) && sizeof($va_objects)){
				$va_object = array_pop($va_objects);
				$t_object = new ca_objects($va_object["object_id"]);
				print "<div class='col-sm-12'><div class='frontSlide'>".caDetailLink($this->request, $t_object->get("ca_object_representations.media.front", array("checkAccess" => $va_access_values)), '', 'ca_occurrences', $t_exhibition->get("occurrence_id"), null, null, array("type_id" => $t_exhibition->get("ca_occurrences.type_id")))."</div></div>";
			}
		}
	}
?>

	<div class="col-sm-12">
<?php
	if($t_exhibition->get("occurrence_id")){
		print "<h1>".caDetailLink($this->request, $t_exhibition->get("ca_occurrences.preferred_labels.name"), '', 'ca_occurrences', $t_exhibition->get("ca_occurrences.occurrence_id"), null, null, array("type_id" => $t_exhibition->get("ca_occurrences.type_id")))."</h1>";
		if($t_exhibition->get("ca_occurrences.exhibition_subtitle")){
			print "<h2>".caDetailLink($this->request, $t_exhibition->get("ca_occurrences.exhibition_subtitle"), '', 'ca_occurrences', $t_exhibition->get("ca_occurrences.occurrence_id"), null, null, array("type_id" => $t_exhibition->get("ca_occurrences.type_id")))."</h2>";
		}
		print "<h4>".$t_exhibition->get("ca_occurrences.opening_closing").(($t_exhibition->get("ca_occurrences.opening_reception")) ? " | Opening Reception: ".$t_exhibition->get("ca_occurrences.opening_reception") : "")."</h4>";
	}
?>
	</div><!--end col-sm-12-->
</div><!-- end row -->