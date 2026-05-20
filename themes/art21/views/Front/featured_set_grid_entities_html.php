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
	$vs_caption_template = $o_config->get("set_item_caption_template_entities");
	if(!$vs_caption_template){
		$vs_caption_template = "<l class='pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black'>^ca_entities.preferred_labels.displayname</l>";
	}
	if($set_code = $o_config->get("set_code_entities")){
		$t_set = new ca_sets();
		$t_set->load(['set_code' => $set_code]);
		$shuffle = (bool)$o_config->get("set_random_entities");			
		// Enforce access control on set
		if((sizeof($access_values) == 0) || (sizeof($access_values) && in_array($t_set->get("access"), $access_values))){
			$featured_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $access_values, 'shuffle' => $shuffle])) ? $tmp : []);
		}
	}
	if(is_array($featured_ids) && sizeof($featured_ids)){
		$qr_res = caMakeSearchResult('ca_entities', $featured_ids);
	}
	if($qr_res && $qr_res->numHits()){
?>   
<div class="container frontGrid">
	<h2 class="mt-5">Featured Artists</h2>	
<?php
		$i = $vn_col = 0;
		print "<div class='row'>";
		$i = $vn_col = 0;
		while($qr_res->nextHit()){
			if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.iconlarge</l>', array("checkAccess" => $va_access_values))){
				print "<div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center'>";
				$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
				if($vs_caption){
					print $vs_caption;
				}
				print "</div>";
				$i++;
				$vn_col++;
			}
			if($i == 8){
				break;
			}
		}
?>
	</div>
	<div class="row mt-3 mb-5">
		<div class="col text-center"><?php print caNavLink($this->request, _t("All Artists"), "btn btn-primary btn-lg", "", "Browse", "artists"); ?></div>
	</div>

</div>
<?php
	}
?>