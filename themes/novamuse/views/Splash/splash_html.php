<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Splash/splash_html.php : 
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
 
	require_once(__CA_MODELS_DIR__."/ca_entities.php");
	$t_object = new ca_objects();
	
	$va_item_ids = $this->getVar('featured_content_slideshow_id_list');
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("frontpage"));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);

	if($this->request->config->get("dont_enforce_access_settings")){
		$va_access_values = array();
	}else{
		$va_access_values = caGetUserAccessValues($this->request);
	}
	
	# --- set for share your knowledge box - set name assigned in app.conf - featured_share_set_name
	$t_featured_share = new ca_sets();
	$t_featured_share->load(array('set_code' => $this->request->config->get('featured_share_set_name')));
	# Enforce access control on set
 	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured_share->get("access"), $va_access_values))){
  		$vn_featured_share_set_id = $t_featured_share->get("set_id");
 		$va_featured_share_ids = array_keys(is_array($va_tmp = $t_featured_share->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());	// These are the object ids in the set
 	}
	if(!is_array($va_featured_share_ids) || (sizeof($va_featured_share_ids) == 0)){
		# put a random object in the features variable
		$va_featured_share_ids = array_keys($t_object->getRandomItems(10, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1)));
	}
	$t_object_share = new ca_objects($va_featured_share_ids[0]);
	$va_rep = $t_object_share->getPrimaryRepresentation(array('frontpage'), null, array('return_with_access' => $va_access_values));
	$vn_featured_share_id = $va_featured_share_ids[0];
	$vs_featured_share_image = $va_rep["tags"]["frontpage"];
	$vs_featured_share_label = $t_object->getLabelForDisplay();

	# --- set for featured member - set name assigned in app.conf - featured_member_set_name - this is an ENTITY set
	$t_featured_member = new ca_sets();
	$t_featured_member->load(array('set_code' => $this->request->config->get('featured_member_set_name')));
	# Enforce access control on set
 	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured_member->get("access"), $va_access_values))){
  		$vn_featured_member_set_id = $t_featured_member->get("set_id");
 		$va_featured_member_ids = array_keys(is_array($va_tmp = $t_featured_member->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());	// These are the entity ids in the set
 	}
	$t_entity = new ca_entities($va_featured_member_ids[0]);
	$vn_featured_member_id = $va_featured_member_ids[0];
	$vs_featured_member_image = $t_entity->get("mem_inst_image", array("version" => "frontpage", "return" => "tag"));
	$vs_featured_member_name = $t_entity->getLabelForDisplay();
	
	# --- canned browses
	$va_browse_codes = $this->request->config->get('hp_category_browse_codes');
	$t_list_item = new ca_list_items();
	$va_browses = array();
	if(is_array($va_browse_codes) && sizeof($va_browse_codes)){
		foreach($va_browse_codes as $vs_item_code){
			$t_list_item->load(array('idno' => $vs_item_code));
			$va_browses[$t_list_item->get("item_id")] = array("idno" => $vs_item_code,"name" => $t_list_item->getLabelForDisplay()); 
		}
	}

	if($this->getVar("featured_set_id")){
		$t_featured_set = new ca_sets($this->getVar("featured_set_id"));
?>
		<div id="contentcontainer">
			<div id="objectcontainerHP">
				<div class="homeIntro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque consequat volutpat feugiat.</div><!-- end home intro -->
				<div id="objectslidesContainerHP">
<?php
					# --- featured objects
					foreach ($va_item_media as $vn_object_id => $va_media) {
						if($va_media['urls']['frontpage']){
							$vs_image_tag = $va_media["tags"]["frontpage"];
							$t_title_object = new ca_objects($vn_object_id);
							$va_repo_name = $t_title_object->get('ca_entities.preferred_labels');
							print "<div>";
							print "<div class='objectslidesHP'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."";
							print "<div class='objectslidesCaptionHP'><b>"._t("Featured Item")."</b><br/>".caNavLink($this->request, $va_item_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))." from the ".$va_repo_name."</div></div>";
							print "</div>";
						}
					}
					# --- featured member inst
					if($vs_featured_member_image){
						print "<div>";
						print "<div class='objectslidesHP'>".caNavLink($this->request, $vs_featured_member_image, '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_featured_member_id))."";
						print "<div class='objectslidesCaptionHP'><b>"._t("Featured Member")."</b><br/>".caNavLink($this->request, $vs_featured_member_name, '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_featured_member_id))."</div></div>";
						print "</div>";
					}
					# --- share your knowledge
					if($vs_featured_share_image){
						print "<div>";
						print "<div class='objectslidesHP'>".caNavLink($this->request, $vs_featured_share_image, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_featured_share_id))."";
						print "<div class='objectslidesCaptionHP'><b>"._t("Share Your Knowledge")."</b><br/>".caNavLink($this->request, _t("Help us improve this record. Do you know more about this item?"), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_featured_share_id))."</div></div>";
						print "</div>";
					}
?>
				</div>
<?php
				if($t_featured_set->get("set_description")){
?>
					<p class="setDescription"><?php print $t_featured_set->get("set_description"); ?></p>
<?php
				}
?>
				<!-- AddThis Button BEGIN -->
				<div class="HPshare"><a href="#" onclick="$('#shareWidgetsContainer').slideToggle(); return false;" class="shareButton">Share</a></div>    
				
				<div id="shareWidgetsContainer">
					<div class="addthis_toolbox addthis_default_style" style="padding-left:50px;">
					<a class="addthis_button_pinterest_pinit"></a>
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-50278eb55c33574f"></script>
				</div>
				<!-- AddThis Button END -->

			
			</div><!--end objectcontainer-->
		</div><!--end contentcontainer-->
<?php
	}
?>
<div id="subcontentcontainerHP">
<?php
		foreach($va_browses as $vn_item_id => $va_browse_info){
			print "<div class='hpobject-type'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/novamuse/bluehomeicons/".$va_browse_info["idno"].".gif' alt='".$va_browse_info["name"]."' /><div class='titletextcapsgray'>".$va_browse_info["name"]."</div>", "", "", "Browse", "clearAndAddCriteria", array("facet" => $this->request->config->get("hp_category_browse_facet"), "id" => $vn_item_id))."</div>";
		}
?>	
</div><!--end subcontentcontainer-->

<div class="clear"></div>










<script type="text/javascript">
$(document).ready(function() {
   $('#objectslidesContainerHP').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>