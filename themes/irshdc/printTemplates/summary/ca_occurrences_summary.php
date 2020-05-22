<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * @name Digital Exhibition Summary
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_occurrences
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
	
	$va_content_block_ids = $t_item->get("ca_occurrences.children.occurrence_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("content_blocks"), "sort" => "ca_occurrences.rank"));
	$qr_content_blocks = caMakeSearchResult("ca_occurrences", $va_content_block_ids);

?>
	<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
	
<?php
					if($qr_content_blocks->numHits()){
						while($qr_content_blocks->nextHit()){
							$vs_format = $qr_content_blocks->get("display_options", array("convertCodesToDisplayText" => true));
							$vs_content_block_title = $qr_content_blocks->get("ca_occurrences.preferred_labels.name");
							if($vs_content_block_title == "[BLANK]"){
								$vs_content_block_title = "";
							}
							$vs_quote = $qr_content_blocks->get("description");
							$vs_main_text = $qr_content_blocks->get("main_text");

							$vn_set_id = "";
							$vs_set_code = $qr_content_blocks->get("ca_occurrences.set_code");	
							$t_set = new ca_sets();
							if($vs_set_code){				
								$t_set->load(array("set_code" => $vs_set_code));
								if(!in_array($t_set->get("ca_sets.access"), $va_access_values)){
									$t_set = new ca_sets();
								}
							}
							
							$vs_featured_image = "";
							$vs_featured_image_small = "";
							$vn_featured_object_ids = $qr_content_blocks->get("ca_objects.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
							$vn_featured_object_id = $vn_featured_object_ids[0];
					
							if($vn_featured_object_id){
								# --- display the rep viewer for the featured object so if it's video, it will play
								$t_featured_object = new ca_objects($vn_featured_object_id);
								$t_representation = $t_featured_object->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values));
								$va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE'));
								$vs_version = $va_media_display_info["display_version"];
								if($vs_version != "mp3"){
									# --- skip audio cause there is nothing to show in a pdf
									$vs_featured_image = $t_representation->get("ca_object_representations.media.mediumlarge");
									$vs_featured_image_small = $t_representation->get("ca_object_representations.media.medium");
									if($vs_caption = $t_representation->get("ca_object_representations.preferred_labels.name")){
										$vs_featured_image .= "<div class='small'>".$vs_caption."</div>";
										$vs_featured_image_small .= "<div class='small'>".$vs_caption."</div>";
									};
								}
							}





?>
							<div class="unit">
								<a name="<?php print $qr_content_blocks->get("ca_occurrences.idno"); ?>" class="digExhAnchors"></a>
<?php
								if($vs_content_block_title){
									print "<h2>".$vs_content_block_title."</h2>";
								}
								
								if($vs_format && ($vs_format != "one column")){
									
									# --- 2 columns
									if($vs_main_text && $vs_featured_image && $vs_quote){
										if($vs_main_text){
											print "<div class='unit'>".$vs_main_text."</div>";
										}
?>
										<div class="unit">
											<table>
												<tr>
													<td valign="middle" align="center">
														<div class='quote'><?php print $vs_quote; ?></div>
													</td>
													<td valign="middle" align="center">
														<?php print $vs_featured_image_small; ?>
													</td>
												</tr>
											</table>
										</div>
<?php	
									}elseif($vs_main_text && $vs_featured_image && !$vs_quote){
?>
										<div class="unit">
											<table>
												<tr>
													<td valign="middle" align="center">
														<?php print $vs_featured_image_small; ?>
													</td>
													<td valign="middle" align="center">
														<?php print $vs_main_text; ?>
													</td>
												</tr>
											</table>
										</div>
<?php									
									}elseif($vs_main_text && !$vs_featured_image && $vs_quote){
?>
										<div class="unit">
											<table>
												<tr>
													<td valign="middle" align="center">
														<?php print $vs_main_text; ?>
													</td>
													<td valign="middle" align="center">
														<div class='quote'><?php print $vs_quote; ?></div>
													</td>
												</tr>
											</table>
										</div>
<?php										
									}elseif(!$vs_main_text && $vs_featured_image && $vs_quote){
?>
										<div class="unit">
											<table>
												<tr>
													<td valign="middle" align="center">
														<div class='quote'><?php print $vs_quote; ?></div>
													</td>
													<td valign="middle" align="center">
														<?php print $vs_featured_image_small; ?>
													</td>
												</tr>
											</table>
										</div>
<?php										
									
									}
									
								}else{
									# --- one column
									if($vs_main_text){
										print "<div class='unit'>".$vs_main_text."</div>";
									}
									if($vs_featured_image){								
										print "<div class='unit' style='text-align:center;'>".$vs_featured_image."</div>";
									}
									if($vs_quote){
										print "<div class='unit'><div class='quote'>".$vs_quote."</div></div>";
									}
								}
?>
							</div><br/>
<?php
						}
					}
?>
					{{{<ifdef code="ca_occurrences.external_link.external_link_link">
						<div class="unit">
							<h3>Links</h3>
							<unit relativeTo="ca_occurrences.external_link" delimiter="<br/>">
								<a href="^ca_occurrences.external_link.external_link_link" target="_blank"><ifdef code="ca_occurrences.external_link.external_link_text">^ca_occurrences.external_link.external_link_text</ifdef><ifnotdef code="ca_occurrences.external_link.external_link_text">^ca_occurrences.external_link.external_link_link</ifnotdef> <span class="glyphicon glyphicon-new-window"></span></a>
							</unit>
						</div>
					</ifdef>}}}


<?php	
	print $this->render("pdfEnd.php");