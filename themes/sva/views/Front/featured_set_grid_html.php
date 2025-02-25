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
	$set_tables = array("ca_collections", "ca_objects", "ca_occurrences");
	$o_config = $this->getVar("config");

	$i = 0;
	foreach($set_tables as $set_table){
		$t_set = $heading = $qr_res = $set_code = null;
		$heading = $o_config->get($set_table."_heading");
		$featured_ids = [];
		$caption_template = $o_config->get($set_table."_front_page_set_item_caption_template");
		if(!$caption_template){
			$caption_template = "<l>^".$set_table.".preferred_labels.name</l>";
		}
		if($set_code = $o_config->get($set_table."_set_code")){
			$t_set = new ca_sets();
			$t_set->load(['set_code' => $set_code]);
			$shuffle = (bool)$o_config->get($set_table."_set_random");
			
			if($t_set->get("ca_sets.set_id")){
				// Enforce access control on set
				if((sizeof($access_values) == 0) || (sizeof($access_values) && in_array($t_set->get("access"), $access_values))){
					$featured_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $access_values, 'shuffle' => $shuffle])) ? $tmp : []);
				}
				if(sizeof($featured_ids)){
					$qr_res = caMakeSearchResult($set_table, $featured_ids);
					$o_result_context = new ResultContext($this->request, $set_table, 'front');
					$o_result_context->setAsLastFind();
					if($qr_res && $qr_res->numHits()){
					$i++;
		?>   
							<div class="container-fluid pb-5<?= ($i==1) ? " pt-5" : ""; ?>">
								<div class="row">
									<div class="col-sm-12"><H2 class="pb-2"><?= $heading; ?></H2></div>
								</div>
								
		<?php
								$i = $vn_col = 0;
								while($qr_res->nextHit()){
									$media = "";
									if($set_table == "ca_occurrences"){
										$thumbnails = "";
										if($thumbnails = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' delimiter='|'><if rule='^ca_objects.series =~ /Posters/'>^ca_object_representations.media.iconlarge</if></unit>", array("checkAccess" => $access_values))){
											$tmp = explode("|", $thumbnails);
											$media = $tmp[0];
										}elseif($thumbnails = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' delimiter='|'><if rule='^ca_objects.series =~ /Announcement/'>^ca_object_representations.media.iconlarge</if></unit>", array("checkAccess" => $access_values))){
											$tmp = explode("|", $thumbnails);
											$media = $tmp[0];
										}elseif($thumbnails = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' delimiter='|'><if rule='^ca_objects.series =~ /Catalogue/'>^ca_object_representations.media.iconlarge</if></unit>", array("checkAccess" => $access_values))){
											$tmp = explode("|", $thumbnails);
											$media = $tmp[0];
										}elseif($thumbnails = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' delimiter='|'><if rule='^ca_objects.series =~ /Photographic Material/'>^ca_object_representations.media.iconlarge</if></unit>", array("checkAccess" => $access_values))){
											$tmp = explode("|", $thumbnails);
											$media = $tmp[0];
										}elseif($thumbnails = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' delimiter='|' limit='1'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $access_values))){
											$tmp = explode("|", $thumbnails);
											$media = $tmp[0];
										}
									}else{
										$media = $qr_res->get('ca_object_representations.media.iconlarge', array("checkAccess" => $access_values));
									}
									if($media){
										$vs_media = '<div class="img-fluid">'.$media.'</div>';
										if($vn_col == 0){
											print "<div class='row g-5 mb-5'>";
										}
										print "<div class='col-sm-3 col-xs-6'>";
										$tmp = "";
										$tmp .= $vs_media;
										$vs_caption = $qr_res->getWithTemplate($caption_template);
										if($vs_caption){
											$tmp .= "<div class='text-center text-black sansserif fs-5 pt-2'>".$vs_caption."</div>";
										}
										print $qr_res->getWithTemplate("<l>".$tmp."</l>");
										print "</div>";
										$vb_item_output = true;
										$i++;
										$vn_col++;
										if($vn_col == 4){
											print "</div>";
											$vn_col = 0;
										}
									}
									if($i == 8){
										break;
									}
								}
								if($vn_col > 0){
									print "</div><!-- end row -->";
								}
								$more = "";
								switch($set_table){
									case "ca_collections":
										$more = caNavLink($this->request, "All ".$heading, "btn btn-primary", "", "Collections", "Index");
									break;
									# ------------------
									case "ca_occurrences":
										$more = caNavLink($this->request, "All ".$heading, "btn btn-primary", "", "Browse", "exhibitions");
									break;
									# ------------------
									case "ca_objects":
										$more = caNavLink($this->request, "All ".$heading, "btn btn-primary", "", "Browse", "objects");
									break;
									# ------------------
								}
		?>
							<div class="row">
								<div class="col-sm-12 text-center pb-2"><?=  $more; ?></div>
							</div>
						</div>
		<?php
					}
				}
			}
		}	
	}
?>