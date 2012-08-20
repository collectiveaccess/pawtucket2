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
 
	JavascriptLoadManager::register("cycle");
	$t_object = new ca_objects();
		$t_featured = new ca_sets();
	$featured_set = $t_featured->load(array('set_code' => 'splash'));
	$carousel_ids = $t_featured->getItemRowIDs(array('shuffle' => true));
	$qr_set = ca_objects::createResultSet(array_keys($carousel_ids));
	
	$va_item_ids = $this->getVar('featured_content_slideshow_id_list');
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge"));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
	$va_access_values = caGetUserAccessValues($this->request);
 ?>
	<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
		<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
		<div id="splashBrowsePanelContent">
		
		</div>
	</div>
	<script type="text/javascript">
		var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
	</script>
	

	<div id="hpFeatured1">
<?php
$v_i = 0;
$m_i = 0;
	while($qr_set->nextHit()) {

		$object_media = $qr_set->get('ca_object_representations.media.splashthumb');
		$vn_object_id = $qr_set->get('ca_objects.object_id');
		print "<div class='figureDiv'><div class='figure'";
			if ($v_i== 4){
				print "style='margin-right:0px'";
			}
			print ">".caNavLink($this->request, $object_media, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
			$v_i ++;
			$m_i ++;
			if ($v_i > 3) {$v_i = 0;}
			if ($m_i == 16) {break;}
	}


?>
	</div>

<?php
	TooltipManager::add('#splashRandomObject', $this->getVar("random_object_medium")."<br/><div class='tooltipCaption'>".$this->getVar('random_object_title')."</div>");
	TooltipManager::add('#splashRecentlyViewed', $this->getVar("recently_viewed_medium")."<br/><div class='tooltipCaption'>".$this->getVar('recently_viewed_title')."</div>");
	TooltipManager::add('#splashRecentlyAdded', $this->getVar("recently_added_medium")."<br/><div class='tooltipCaption'>".$this->getVar('recently_added_title')."</div>");
?>
<script type="text/javascript">
$(document).ready(function() {
   $('#hpFeatured').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>