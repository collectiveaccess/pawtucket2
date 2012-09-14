<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
	$t_entity 			= $this->getVar('t_item');
	$vn_entity_id 		= $t_entity->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');
	
	$t_list = new ca_lists();
 	$vn_member_institution_id = $t_list->getItemIDFromList('entity_types', 'member_institution');
 	$vn_organization_id = $t_list->getItemIDFromList('entity_types', 'org');
 	$vn_individual_id = $t_list->getItemIDFromList('entity_types', 'ind');
 	$vn_family_id = $t_list->getItemIDFromList('entity_types', 'fam');

if (!$this->request->isAjax()) {		
?>
<div id='pageBody'>
	<div id="detailBody" style="clear:both;">
	<h1 style="float:left;"><?php print $vs_title; ?></h1>
		<div id="pageNav">
		
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_entities', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&larr; "._t("Previous Entry"), '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('previous_id')), array('id' => 'previous'))."&nbsp;&nbsp;&nbsp;";
				}
				print $vs_back_link;
				if ($this->getVar('next_id') > 0) {
					print "&nbsp;&nbsp;&nbsp;".caNavLink($this->request, _t("Next Entry")." &rarr;", '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('next_id')), array('id' => 'next'));
				}
			}
?>
		</div><!-- end nav -->
		
		<div id="leftCol" class="entity">
			<div class='unit'><a href="#" onclick="$('#shareWidgetsContainer').slideToggle(); return false;" class="shareButton">Share</a></div>
			<!-- AddThis Button BEGIN -->
			<div id="shareWidgetsContainer" style="margin-top:25px;">
				<div class="addthis_toolbox addthis_default_style addthis_entity_page">
					<a class="addthis_button_pinterest_pinit"></a>
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-50278eb55c33574f"></script>
			</div>
			<!-- AddThis Button END -->
<?php
			# --- description
			if($this->request->config->get('ca_entities_description_attribute')){
				if($vs_description_text = $t_entity->get("ca_entities.".$this->request->config->get('ca_entities_description_attribute'))){
					print "<div class='unit'>".$vs_description_text."</div><!-- end unit -->";				
				}
			}
			switch($t_entity->get("type_id")){
				case $vn_member_institution_id:
					if($t_entity->get("ca_entities.mem_inst_image")){
						print "<div class='unit'>".$t_entity->get("ca_entities.mem_inst_image", array("version" => "small", "return" => "tag"))."</div>";
					}
					if($t_entity->get("ca_entities.address")){
						if($t_entity->get("ca_entities.mem_inst_region")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Region").":</span> ".caNavLink($this->request, $t_entity->get("ca_entities.mem_inst_region", array('convertCodesToDisplayText' => true)), "", "", "Browse", "clearAndAddCriteria", array("facet" => "region_facet", "id" => $t_entity->get("ca_entities.mem_inst_region")))."</div>";
						}
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Address").":</span><br/>";
						if($t_entity->get("ca_entities.address.address1")){
							print $t_entity->get("ca_entities.address.address1")."<br/>";
						}
						if($t_entity->get("ca_entities.address.address2")){
							print $t_entity->get("ca_entities.address.address2")."<br/>";
						}
						$va_address_line3 = array();
						if($t_entity->get("ca_entities.address.city")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.city");
						}
						if($t_entity->get("ca_entities.address.county")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.county");
						}
						if($t_entity->get("ca_entities.address.stateprovince")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.stateprovince");
						}
						if($t_entity->get("ca_entities.address.postalcode")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.postalcode");
						}
						if($t_entity->get("ca_entities.address.country")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.country");
						}
						if(sizeof($va_address_line3) > 0){
							print join(", ", $va_address_line3);
						}
						print "</div><!-- end unit -->";
					}
					if($t_entity->get("ca_entities.external_link.url_entry")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Link").":</span> <a href='".$t_entity->get("ca_entities.external_link.url_entry")."'>".$t_entity->get("ca_entities.external_link.url_entry")."</a></div><!-- end unit -->";
					}
					
				break;
				# --------------------------
				case $vn_organization_id:
					if($t_entity->get("ca_entities.business_type")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Business Type").":</span> ".$t_entity->get("ca_entities.business_type")."</div>";
					}
					if($t_entity->get("ca_entities.entity_founded")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Date Founded").":</span> ".$t_entity->get("ca_entities.entity_founded")."</div>";
					}
					if($t_entity->get("ca_entities.entity_incorporated")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Date Incorporated").":</span> ".$t_entity->get("ca_entities.entity_incorporated")."</div>";
					}
					if($t_entity->get("ca_entities.entity_liquidated")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Date Liquidated").":</span> ".$t_entity->get("ca_entities.entity_liquidated")."</div>";
					}
					if($t_entity->get("ca_entities.entity_brands")){
						$va_brands = array();
						foreach($t_entity->get("ca_entities.entity_brands", array("returnAsArray" => 1)) as $i => $va_brand_info){
							$va_brands[] = $va_brand_info["entity_brands"];
						}
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Brand(s)").":</span> ".join(", ", $va_brands)."</div>";
					}
					if($t_entity->get("ca_entities.products")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Product(s)").":</span> ".$t_entity->get("ca_entities.products")."</div>";
					}
					if($t_entity->get("ca_entities.add_info")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Additional Info").":</span> ".$t_entity->get("ca_entities.add_info")."</div>";
					}
					if($t_entity->get("ca_entities.remarks")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Remarks").":</span> ".$t_entity->get("ca_entities.remarks")."</div>";
					}
					if($t_entity->get("ca_entities.remarks_source")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Remarks Source").":</span> ".$t_entity->get("ca_entities.remarks_source")."</div>";
					}
					if($t_entity->get("ca_entities.address")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Address").":</span><br/>";
						if($t_entity->get("ca_entities.address.address1")){
							print $t_entity->get("ca_entities.address.address1")."<br/>";
						}
						if($t_entity->get("ca_entities.address.address2")){
							print $t_entity->get("ca_entities.address.address2")."<br/>";
						}
						$va_address_line3 = array();
						if($t_entity->get("ca_entities.address.city")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.city");
						}
						if($t_entity->get("ca_entities.address.county")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.county");
						}
						if($t_entity->get("ca_entities.address.stateprovince")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.stateprovince");
						}
						if($t_entity->get("ca_entities.address.postalcode")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.postalcode");
						}
						if($t_entity->get("ca_entities.address.country")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.country");
						}
						if(sizeof($va_address_line3) > 0){
							print join(", ", $va_address_line3);
						}
						print "</div><!-- end unit -->";
					}
					if($t_entity->get("ca_entities.external_link.url_entry")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Link").":</span> <a href='".$t_entity->get("ca_entities.external_link.url_entry")."'>".$t_entity->get("ca_entities.external_link.url_entry")."</a></div><!-- end unit -->";
					}
				break;
				# --------------------------
				# --- individuals and families
				default:
					if($t_entity->get("ca_entities.lifespan")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Lifetime").":</span> ".$t_entity->get("ca_entities.lifespan")."</div><!-- end unit -->";
					}
					if($t_entity->get("ca_entities.nationality")){
						print "<div class='unit'><span class='subtitletextcaps'>"._t("Nationality").":</span> ".$t_entity->get("ca_entities.nationality")."</div><!-- end unit -->";
					}
					
				break;
				# --------------------------
			}
			
			# --- entities
			$va_entities = $t_entity->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
?>
				<div class="unit"><h2><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("Entities") : _t("Entity")); ?></h2>
<?php
				foreach($va_entities as $va_entity) {
					print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".$va_entity['relationship_typename'].")</div>";		
				}
?>
				</div><!-- end unit -->
<?php
			}
			print "<div class='unit'>";
			if($this->request->config->get('ca_entities_map_attribute') && $t_entity->get($this->request->config->get('ca_entities_map_attribute'))){
				$o_map = new GeographicMap(285, 200, 'map');
				$o_map->mapFrom($t_entity, $this->request->config->get('ca_entities_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}
			print "</div>";
		# --- user data --- comments - ranking - tagging
		$va_comments = $this->getVar("comments");
		if(is_array($va_comments) && (sizeof($va_comments) > 0)){	
			print '<div id="objUserData">';
?>
			<H2><div id="numComments">(<?php print sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment")); ?>)</div><?php print _t("User Comments"); ?></H2>
<?php
			foreach($va_comments as $va_comment){
				if($va_comment["media1"]){
?>
					<div class="commentImage" id="commentMedia<?php print $va_comment["comment_id"]; ?>">
						<?php print $va_comment["media1"]["tiny"]["TAG"]; ?>							
					</div><!-- end commentImage -->
<?php
					TooltipManager::add(
						"#commentMedia".$va_comment["comment_id"], $va_comment["media1"]["large_preview"]["TAG"]
					);
				}
				if($va_comment["comment"]){
?>					
				<div class="comment">
					<?php print $va_comment["comment"]; ?>
				</div>
<?php
				}
?>					
				<div class="byLine">
					<?php print $va_comment["author"].", ".$va_comment["date"]; ?>
				</div>
<?php
			}
?>
			</div><!-- end objUserData -->
<?php			
			}
		if($this->request->isLoggedIn()){
?>
			<form class="appnitro" method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Entity', 'saveCommentRanking', array('entity_id' => $vn_entity_id)); ?>" name="comment" enctype='multipart/form-data'>
				<div class="form_description">
					<h2>Leave your comments</h2>
					<p>You are logged in as <?php print trim($this->request->user->get("fname")." ".$this->request->user->get("lname"));?>.</p>
				</div>						
				<ul>
					<li id="li_2" >
						<label class="description" for="element_2">Comments </label>
						<div>
							<textarea id="element_2" name="comment" class="element textarea medium"></textarea> 
						</div> 
					</li>
					<li id="li_3" >
						<label class="description" for="element_3">Upload a File </label>
						<div>
							<input id="element_3" name="media1" class="element file" type="file"/> 
						</div>  
					</li>
					<li class="buttons">
						<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
					</li>
				</ul>
			</form>
<?php
		}else{
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				print "<p class='detail-login-link'>".caNavLink($this->request, _t("Do you know more about this record?<br/>Login to add your comment!"), "", "", "LoginReg", "form", array('site_last_page' => 'EntityDetail', 'entity_id' => $vn_entity_id))."</p>";
			}
		}
?>

	</div><!-- end leftCol -->
	<div id="rightCol" class="entity">
		<div id="resultBox">
<?php
}
	// set parameters for paging controls view
	$this->setVar('other_paging_parameters', array(
		'entity_id' => $vn_entity_id
	));
	print $this->render('related_objects_grid.php');
	
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
	</div><!-- end rightCol -->
</div><!-- end detailBody -->
</div><!-- end pageBody -->
<?php
}
?>