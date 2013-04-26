<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 
JavascriptLoadManager::register('jquery', 'expander'); 	
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$va_access_values 		= $this->getVar('access_values');

if($vo_result) {
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		
		if($vn_item_count % 2 != 0) { 
			$is_striped = 'withBg';
		}else {
			$is_striped = '';
		}
	
		print "<div class='searchResultFull ".$is_striped."'>";
		$vs_image = "";
		if($vs_image = $vo_result->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values))){
			print "<div class='searchResultFullImageContainer'>";
			print caNavLink($this->request, $vs_image, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			print "</div>";
		}else{
			$vs_restricted_media = "";
			if($vs_restricted_media = $vo_result->getMediaTag('ca_object_representations.media', 'small')){
				print "<div class='searchResultFullImageContainer' style='height:auto; padding: 50px 0px 50px 0px;'>";
				print "<span class='restricted-media'>Restricted media. To view, please contact <a href='mailto:archives@roundabouttheatre.org'>archivist</a>.</span>";
				print "</div>";
			}
		}
		
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		print "<div class='searchResultFullText'>";
		print "<p>".caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</p>";
		print "<p>"._t("Identifier").": ".$vo_result->get("ca_objects.idno")."</p>\n";
		$vs_description = "";
		$vs_description = $vo_result->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'));
		if($vs_description){
			print "<div id='description".$vn_object_id."'><p><strong>Description</strong><br/>".$vs_description."</p></div>";
?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#description<?php print $vn_object_id; ?>').expander({
							slicePoint: 400,
							expandText: '<?php print _t('more'); ?>',
							userCollapse: false
						});
					});
				</script>
<?php
		}
		print "</div><!-- end searchResultFullText --><div style='clear:both;'><!-- empty --></div></div><!-- END searchResultFull -->\n";
		$vn_item_count++;
	}
}
?>