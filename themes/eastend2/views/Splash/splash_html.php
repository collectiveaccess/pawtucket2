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
 
	$t_object = new ca_objects();
	
	$va_item_ids = $this->getVar('featured_content_slideshow_id_list');
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("hpFeatured"));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
	$qr_hits = ca_objects::createResultSet($va_item_ids);
	$va_item_captions = array();
	$va_item_vaga = array();
	$va_item_do_not_show = array();
	if($qr_hits->numHits()){
		while($qr_hits->nextHit()){
			# --- vaga/ARS no image - remove from slideshow
			if($qr_hits->get("ca_objects.object_status") == 348){
				$va_item_do_not_show[$qr_hits->get("ca_objects.object_id")] = 1;
			}
			$vs_caption = "";
			if($qr_hits->get("ca_objects.object_status") == 349){
				$vs_caption = "<a href='http://www.vagarights.com' target='_blank'>".$qr_hits->get("ca_objects.caption")."</a>";
				$va_item_vaga[$qr_hits->get("ca_objects.object_id")] = 1;
			}else{
				$vs_caption = $qr_hits->get("ca_objects.caption");
			}
			$va_item_captions[$qr_hits->get("ca_objects.object_id")] = $vs_caption;
		}
	}
 ?>
	<div id="hpFeatured">
<?php
	foreach ($va_item_media as $vn_object_id => $va_media) {
		if(!$va_item_do_not_show[$vn_object_id]){
			$vs_image_tag = $va_media["tags"]["hpFeatured"];
			print "<div><div id='hpFeaturedImg'".(($va_item_vaga[$vn_object_id]) ? " class='vagaDisclaimer'" : "").">".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			print "<div id='hpFeaturedScrollCaption'".(($va_item_vaga[$vn_object_id]) ? " class='vagaDisclaimer'" : "").">".caNavLink($this->request, $va_item_labels[$vn_object_id].(($va_item_captions[$vn_object_id]) ? "<br/>".$va_item_captions[$vn_object_id] : ""), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
		}
	}
?>
	</div>
	<div id="hpTextContainer">
		<div id="hpTextHeader">
			East End Stories, presented by the Parrish Art Museum, explores the enduring presence of artists on the East End of Long Island.
		</div>
		<div id="hpText">
			Begin your journey by browsing the catalog of artists<!--, finding hubs of activity on the map, --> or exploring the chronology.
		</div>			
	</div>
<script type="text/javascript">
$(document).ready(function() {
   $('#hpFeatured').cycle({
		   fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		   speed:  1000,
		   timeout: 4000
       });
});
</script>