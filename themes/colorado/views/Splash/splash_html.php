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
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge"));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);

	$vs_tag = "";
	if($vn_featured_content_id = $this->getVar("featured_content_id")){
		if($this->request->config->get("dont_enforce_access_settings")){
			$va_access_values = array();
		}else{
			$va_access_values = caGetUserAccessValues($this->request);
		}
		$t_object = new ca_objects($vn_featured_content_id);
		$va_rep = $t_object->getPrimaryRepresentation(array('mediumlarge'), null, array('return_with_access' => $va_access_values));
		$vs_tag = $va_rep["tags"]["mediumlarge"];
	}
	
?>
		
		
			
			<div id="hpBrowse">
				<div style="color:#888"><b><?php print _t(""); ?></b></div>
				<div style="margin-top:15px;">
<?php
					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a><br/>
<?php
					}
?>
				</div>
				

			</div><!-- end hpBrowse-->
</div><!-- end nav opened in pageHeader.php -->
		<div id="browse"><div id="hpFeatured">
<?php
	foreach ($va_item_media as $vn_object_id => $va_media) {
			$vs_image_tag = $va_media["tags"]["mediumlarge"];
			$vn_padding_top = 0;
			$vn_padding_top = ((450 - $va_media["info"]["mediumlarge"]["HEIGHT"]) / 2);
			print "<div style='margin-top:10px;'><div id='featuredScroll' style='margin-top:".$vn_padding_top."px; margin-bottom:".$vn_padding_top."px;'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			print "<div id='featuredScrollCaption'>".caNavLink($this->request, $va_item_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
	}
?>
				
		</div><div id="hpText">
<?php
				print $this->render('Splash/splash_intro_text_html.php');
?> 				
			</div></div>
		
<script type="text/javascript">
$(document).ready(function() {
   $('#hpFeatured').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>
			<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
