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
 ?>
	<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
		<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
		<div id="splashBrowsePanelContent">
		
		</div>
	</div>
	<script type="text/javascript">
		var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
	</script>
	

	<div id="hpFeatured">
<?php
	foreach ($va_item_media as $vn_object_id => $va_media) {
			$vs_image_tag = $va_media["tags"]["mediumlarge"];
			$vn_padding_top = 0;
			$vn_padding_top = ((450 - $va_media["info"]["mediumlarge"]["HEIGHT"]) / 2);
			print "<div style='margin-top:10px;'><div id='featuredScroll' style='margin-top:".$vn_padding_top."px; margin-bottom:".$vn_padding_top."px;'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			print "<div id='featuredScrollCaption'>".caNavLink($this->request, $va_item_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
	}
?>
	</div>
	<div id="hpTextContainer">
			

		<div id="hpBrowseDiv">
			<div id="hpBrowse">
			<div class="hpBrowseTitle"><?php print _t("Begin Browsing By"); ?></div>
				<ul><div id="hpBrowseFacet">
<?php

					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<li><a href="#" style="white-space:nowrap;" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>"); return false;'><?php print ucwords($va_facet_info['label_plural']); ?></a></li>
<?php
					}
?>
				</div></ul>
			</div><!-- end hpBrowse-->
		</div>
			
		
	</div>


		
		<div id="recentlyAdded">
		<div class="hpBrowseTitle"><?php print _t("Recently Added"); ?></div>
<?php
		$va_recently_added_items = $t_object->getRecentlyAddedItems(9, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
		$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_recently_added_items));
		$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_recently_added_items), array('small', 'icon','thumbnail', 'preview', 'widepreview', 'medium'), array("checkAccess" => $va_access_values));
		foreach($va_recently_added_items as $vn_object_id => $va_object_info){
			$va_object_info['title'] = $va_labels[$vn_object_id];
			$va_object_info['media'] = $va_media[$vn_object_id];
			$va_recently_added_objects[$vn_object_id] = $va_object_info;
		}
		$recent_array = $va_recently_added_objects;
		$v_i = 0;
		foreach ($recent_array as $id => $recent) {
			$recent_id = $recent["object_id"];
			
			$v_i++;
			if ($v_i == 3) {
				print "<div class='recentlyAddedItem'>".caNavLink($this->request, $recent['media']['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' =>  $recent['object_id']))."</div>";  
				$v_i = 0;
			} else {
			 	print "<div class='recentlyAddedItem' style='margin-right: 10px;'>".caNavLink($this->request, $recent['media']['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' =>  $recent['object_id']))."</div>"; 
			}
				
		}
?>
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