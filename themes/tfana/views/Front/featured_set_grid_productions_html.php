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
	$access_values = $this->getVar("access_values");
	$o_config = $this->getVar("config");
	$vs_caption_template = $o_config->get("set_item_caption_template_productions");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_occurrences.preferred_labels.name</l>";
	}
	if($set_code = $o_config->get("set_code_productions")){
		$t_set = new ca_sets();
		$t_set->load(['set_code' => $set_code]);
		$shuffle = (bool)$o_config->get("set_random_productions");			
		// Enforce access control on set
		if((sizeof($access_values) == 0) || (sizeof($access_values) && in_array($t_set->get("access"), $access_values))){
			$featured_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $access_values, 'shuffle' => $shuffle])) ? $tmp : []);
		}
	}
	if(is_array($featured_ids) && sizeof($featured_ids)){
		$qr_res = caMakeSearchResult('ca_occurrences', $featured_ids);
	}
	if($qr_res && $qr_res->numHits()){
?>   
<div class="frontGrid container">	
<?php
		$i = $vn_col = 0;
		while($qr_res->nextHit()){
			$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
			if($vs_caption){
				$vs_caption = "<div class='pt-1 px-2 pb-4'><hr/><div class='frontGridCaption fs-4 fw-bold lh-sm'>".$vs_caption."</div></div>";
			}
			$vs_image = $qr_res->getWithTemplate("<ifcount code='ca_objects' restrictToRelationshipTypes='select' min='1'><unit relativeTo='ca_objects' restrictToRelationshipTypes='select'>^ca_object_representations.media.iconlarge</unit></ifcount>");
			$vs_link = $qr_res->getWithTemplate('<l class="text-decoration-none h-100 d-block bg-secondary">'.$vs_image.$vs_caption.'</l>', array("checkAccess" => $access_values));
			if($vn_col == 0){
				print "<div class='row g-4'>";
			}
			print "<div class='col-sm-3 col-xs-6 img-fluid'><div class='h-100'>".$vs_link."</div></div>";
			$i++;
			$vn_col++;
			if($vn_col == 4){
				print "</div>";
				$vn_col = 0;
			}
			if($i == 4){
				break;
			}
		}
		if($vn_col > 0){
			print "</div><!-- end row -->";
		}
?>
</div>
<?php
	}
?>