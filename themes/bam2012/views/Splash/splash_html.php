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
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("medium"), array('checkAccess' => array(1)));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
 ?>
	<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
		<div id="splashBrowsePanelContent">
		
		</div>
	</div>
	<script type="text/javascript">
		var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
	</script>
	
<div id="hpPageArea">
	<div id="hpFeatured">
<?php
	foreach ($va_item_media as $vn_object_id => $va_media) {
			$vs_image_tag = $va_media["tags"]["medium"];
			$vn_padding_top = 0;
			$vn_padding_top = ((450 - $va_media["info"]["medium"]["HEIGHT"]) / 2);
			print "<div><div id='featuredScroll' style='margin-top:".$vn_padding_top."px; margin-bottom:".$vn_padding_top."px;'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			print "<div id='featuredScrollCaption'>".caNavLink($this->request, $va_item_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
	}
?>
	</div><!-- end hpFeatured -->
	<div id="hpTextContainer">
		<div id="hpText">
<?php
		print $this->render('Splash/splash_intro_text_html.php');
?> 
		</div><!-- end hpText -->		
		<div id="hpBrowse">
<?php
			print caNavLink($this->request, _t("Browse for Objects"), "", "", "Browse", "clearCriteria", array("target" => "ca_objects"))."<br/>";
			print caNavLink($this->request, _t("Browse for Productions"), "", "", "Browse", "clearCriteria", array("target" => "ca_occurrences"))."<br/>";
			print caNavLink($this->request, _t("Browse for People"), "", "", "Browse", "clearCriteria", array("target" => "ca_entities"));

?>
		</div><!-- end hpBrowse-->
	</div><!-- end hpTextContainer -->
	<div style="clear:both;"><!-- empty --></div>
</div><!-- end hpPageArea -->
<script type="text/javascript">
$(document).ready(function() {
   $('#hpFeatured').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>