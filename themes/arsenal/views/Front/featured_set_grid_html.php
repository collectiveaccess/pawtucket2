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
	$va_access_values = $this->getVar("access_values");
	$o_config = $this->getVar("config");
	#$qr_res = $this->getVar('featured_set_items_as_search_result');
	$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
	if(!$vs_caption_template){
		$vs_caption_template = "<l>^ca_occurrences.preferred_labels.name</l>";
	}
	
	#
	# --- if there is a set configured to show on the front page, load it now
	# --- it will be an occurrence set
	#
	$vs_title = "";
	$va_featured_ids = array();
	if($vs_set_code = $o_config->get("front_page_set_code2")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		$vs_title = $t_set->getLabelForDisplay();
		$vn_shuffle = 0;
		if($o_config->get("front_page_set_random")){
			$vn_shuffle = 1;
		}
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
			$qr_res = caMakeSearchResult('ca_occurrences', $va_featured_ids);
		}
	}
	#
	# --- no configured set/items in set so grab random objects with media
	#
	if(sizeof($va_featured_ids) == 0){
		$t_occurrences = new ca_occurrences();
		$va_list_items = new ca_list_items(array("idno" => "work"));
		$va_featured_ids = array_keys($t_occurrences->getRandomItems(40, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1, 'restrictByIntrinsic' => array("type_id" => $va_list_items->get("ca_list_items.item_id")))));
		$qr_res = caMakeSearchResult('ca_occurrences', $va_featured_ids);
	}
	if($qr_res && $qr_res->numHits()){
?>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-8 col-lg-offset-2">
				<div class="frontGrid">	
<?php
	if($vs_title){
		print '<div class="frontGridTitle">'.$vs_title.'</div>';
	}

		$i = $vn_col = 0;
		while($qr_res->nextHit()){
			if($vs_media = $qr_res->getWithTemplate('<ifdef code="ca_object_representations.media.widepreview"><l>^ca_object_representations.media.widepreview</l></ifdef>', array("checkAccess" => $va_access_values))){
				if($vn_col == 0){
					print "<div class='row'>";
				}
				print "<div class='col-sm-3 col-xs-6'>".$vs_media;
				$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
				if($vs_caption){
					print "<div class='frontGridCaption'>".$vs_caption."</div>";
				}
				print "</div>";
				$vb_item_output = true;
				$i++;
				$vn_col++;
				if($vn_col == 4){
					print "</div>";
					$vn_col = 0;
				}
			}
		}
		if($vn_col > 0){
			print "</div><!-- end row -->";
		}
?>
			</div>
		</div>
	</div>
</div>
<?php
		}
?>