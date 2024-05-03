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
	$this->config = caGetFrontConfig();
	$va_access_values = $this->getVar("access_values");
	$featured_ids = [];
	if($set_code = $this->config->get("collections_set_code")){
		$t_set = new ca_sets();
		$t_set->load(['set_code' => $set_code]);
		if($t_set->get("ca_sets.set_id")){
			$shuffle = false;
		
			// Enforce access control on set
			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
				$featured_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $va_access_values, 'shuffle' => $shuffle])) ? $tmp : []);
			}
		}
	}
	if(is_array($featured_ids) && sizeof($featured_ids)){
		$qr_res = caMakeSearchResult('ca_collections', $featured_ids);
		if($qr_res && $qr_res->numHits()){
?>
	<div class="row justify-content-center text-left mb-5">
		<div class="col-12 hpExplore mt-4 mb-5">
			<H2 class="mb-3">Explore By Collection</H2>
			<div class="row mb-5">
<?php
			while($qr_res->nextHit()){
				if(!($vs_thumbnail = $qr_res->get("ca_object_representations.media.medium", array("checkAccess" => $va_access_values, "class" => "object-fit-cover w-100")))){
					$vs_thumbnail = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' length='1'><ifdef code='ca_object_representations.media.medium'>^ca_object_representations.media.medium</ifdef></unit>", array("checkAccess" => $va_access_values, "class" => "object-fit-cover w-100"));
				}
				print "<div class='col-md-3'>".caNavLink($this->request, $qr_res->getWithTemplate($vs_thumbnail."<div class='pb-5'><div class='fw-semibold pt-2 text-start'>^ca_collections.preferred_labels.name <span class='fw-normal'>(<unit relativeTo='ca_objects' limit='1'>^count</unit>)</span></div><ifdef code='ca_collections.short_des'><div class='fs-5 fw-light blurb'>^ca_collections.short_des</ifdef></div>", array("checkAccess" => $va_access_values)), "text-decoration-none", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => $qr_res->get("ca_collections.collection_id")))."</div>";
			}
?>
			</div>
		</div>
	</div>
<?php
		}
	}
?>