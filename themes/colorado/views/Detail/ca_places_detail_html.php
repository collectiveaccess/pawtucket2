<div id="browse"><?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_places_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
	$t_place 			= $this->getVar('t_item');
	$vn_place_id 	= $t_place->getPrimaryKey();
	
	$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_places', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'place', 'Show', array('place_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'place', 'Show', array('place_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<h1><?php if($t_place->get('idno')){
				print "<b>"._t("Locality Number")."</b>: ".$t_place->get('idno')."<!-- end unit -->";
			} ?></h1>
		<div id="leftCol">	
<?php
			if((!$this->request->config->get('dont_allow_registration_and_login')) && $this->request->config->get('enable_bookmarks')){
?>
				<!-- bookmark link BEGIN -->
				<div class="unit">
<?php
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_place_id, 'tablename' => 'ca_places'));
				}else{
					print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_place_id, 'tablename' => 'ca_places'));
				}
?>
				</div><!-- end unit -->
				<!-- bookmark link END -->
<?php
			}
			# --- name
			if(is_array($va_place_hier = $t_place->get('ca_places.hierarchy.preferred_labels', array('returnAsArray' => true, 'checkAccess' => $va_access_values)))){
				$va_place_hier = array_values($va_place_hier); array_shift($va_place_hier);
				print "<div class='unit'><b>"._t("Locality Name")."</b>: ".join(" / ", $va_place_hier)."</div><!-- end unit -->";
				
			}
			# --- attributes
			$va_attributes = $this->request->config->get('ca_places_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_place->get("ca_places.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$t_place->getDisplayLabel("ca_places.{$vs_attribute_code}").":</b> ".caReturnDefaultIfBlank($vs_value)."</div><!-- end unit -->";
					}
				}
			}
			
			
			# --- objects
			$va_objects = $t_place->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_objects = array();
			if(sizeof($va_objects) > 0){
				$t_obj = new ca_objects();
				$va_item_types = $t_obj->getTypeList();
				foreach($va_objects as $va_object) {
					$t_obj->load($va_object['object_id']);
					$va_sorted_objects[$va_object['item_type_id']][$va_object['object_id']] = $va_object;
				}
				
				foreach($va_sorted_objects as $vn_object_type_id => $va_object_list) {
?>
						<div class="unit"><h2><?php print _t("Related")." ".$va_item_types[$vn_object_type_id]['name_singular'].((sizeof($va_object_list) > 1) ? "s" : ""); ?></h2>
<?php
					foreach($va_object_list as $vn_rel_object_id => $va_info) {
						print "<div>".(($this->request->config->get('allow_detail_for_ca_objects')) ? caNavLink($this->request, $va_info["idno"], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
			}
			
?>
	</div><!-- end leftCol -->
			</div>
	<div id="rightColMap">
		<!-- end resultBox -->
<?php
# --- map
			#if($this->request->config->get('ca_places_map_attribute') && $t_place->get($this->request->config->get('ca_places_map_attribute'))){
			#	$o_map = new GeographicMap(300, 200, 'map');
			#	$o_map->mapFrom($t_place, $this->request->config->get('ca_places_map_attribute'));
			#	print "<div class='unit'>".$o_map->render('HTML')."</div>";
			#}
			if($t_place->get("ca_places.publicGeoreference") || $t_place->get("ca_places.publicGeoreference")){
				$o_map = new GeographicMap(550, 400, 'map');
				$o_map->mapFrom($t_place, "ca_places.publicGeoreference");
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}

	?>
	</div><!-- end rightCol -->
</div><!-- end detailBody -->
<?php
}
?>