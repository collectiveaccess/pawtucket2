<?php
/* ----------------------------------------------------------------------
 * app/plugins/bristol/ajax_item_info_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
 
	$t_rep 							= $this->getVar('t_object_representation');
	$vs_display_version 		= $this->getVar('rep_display_version');
	$va_display_options	 	= $this->getVar('rep_display_options');
	
	$va_item 						= $this->getVar("item_info");
	$vn_set_id 					= $this->getVar("set_id");
	
	$t_object						= $this->getVar('t_object');
	
	
	# --- this layout is based on use of a mediumlarge image
	# --- get the height of the media being displayed - either the viewer height or the image height
	if($vs_display_version == 'mediumlarge'){
		$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
		$vn_media_height = $va_media_info["HEIGHT"];
	}else{
		$vn_media_height = $va_display_options['viewer_height'];
	}
	if($vn_media_height <= 450){
		$vn_text_height	= 100 + (450 - $vn_media_height);
	}
	$vs_media_tag 				= $t_rep->getMediaTag('media', $vs_display_version, $va_display_options);
?>
	<div id="galleryOverlayNextPrevious">
<?php
	if($va_item['previous_id']){
		print "<a href='#' onclick=\"loadItem(".$va_item['previous_id']."); return false;\">"._t("&lsaquo; Previous")."</a>";
	}else{
		print _t("&lsaquo; Previous");
	}
	print "&nbsp;&nbsp;|&nbsp;&nbsp;";
	if($va_item['next_id']){
		print "<a href='#' onclick=\"loadItem(".$va_item['next_id']."); return false;\">"._t("Next &rsaquo;")."</a>";
	}else{
		print _t("Next &rsaquo;");
	}
	print "</div>";	
	if($vs_media_tag){
		if ($va_display_options['no_overlay']) {
			print "<div id='galleryOverlayImage'>".$vs_media_tag."</div>";
		} else {
			print "<div id='galleryOverlayImage'>".caNavLink($this->request, $vs_media_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
		}
	}


	if($va_item['label'] || $va_item['description']){
?> 	

		
<?php
	}
	print "<div style='float:left; margin: 10px 10px 0px 10px; width:300px; color:#000;'>";
	if($va_item['object_label']){
		print "<div id='galleryOverlayImageCaption'>".$va_item['object_label']."</div>";
	}	
	if($va_item_id = $t_object->get('ca_objects.idno')) {
		print "<b>ID: </b>".$t_object->get('ca_objects.idno')."</b><br/>";
	}
	if($va_date = $t_object->get('ca_objects.date')) {
		print "<b>Date: </b>".$va_date."<br/>";
	}
	if($va_length = $t_object->get('ca_objects.length')) {
		print "<b>Length: </b>".$va_length."<br/>";
	}
	print "</div><div style='float:left; margin: 30px 10px 0px 10px; width:500px; color:#000;'>";
	print "<b>Permissions: </b>";
	print $t_object->get('ca_entities', array('restrict_to_relationship_types' => 'copyright', 'delimiter' => ', '));
	print "<br/>";
    print "<b>Related Entities: </b>";
   	print $t_object->get('ca_entities', array('restrict_to_relationship_types' => 'appears', 'delimiter' => ', '));
	print "<br/>";
	if($va_exhibit = $t_object->get('ca_objects.exhibitionProject')) {
		print "<b>Exhibition/Projects: </b>".$va_exhibit."<br/>";
	}
	if($va_tape = $t_object->get('ca_objects.tapeNumber')) {
		print "<b>Tape Number: </b>".$va_tape."<br/>";
	}
	print "<b>Condition: </b>".$t_object->get('ca_objects.condition.conditionList', array('convertCodesToDisplayText' => true));
	if ($va_conditionnote = $t_object->get('ca_objects.condition.conditionNote')) {
		print " (".$va_conditionnote.") ";
	}
	print "</div></div>";
?>
<script type="text/javascript">	
function loadItem(item_id) {
            jQuery('#bristolboxContent').load('<?php print caNavUrl($this->request, 'bristol', 'Show', 'setItemInfo', array('set_id' => $vn_set_id)); ?>/set_item_id/' + item_id);
}
</script>