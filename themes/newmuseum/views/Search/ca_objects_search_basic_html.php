<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_objects_search_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009 Whirl-i-Gig
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
	$vo_result = $this->getVar('result');
 ?>
	<div id="quickLookOverlay"> 
		<div id="quickLookOverlayContent">
		
		</div>
	</div>
	<div id="search">
<?php
	if(!$this->request->isAjax()) { 
?>
	<div id="resultsTitle"><?php print ("Results For"); ?> &nbsp;<span id="searchingFor"><?php print $this->getVar('search'); ?></span></div><!-- end searchTitle -->
<?php
	}
?>
 	<div id="resultBox">
<?php
	if($vo_result) {
?>
	<div class="sectionBox">
<?php
		$vs_view = $this->getVar('current_view');
	//	if ($vo_result->numHits() == 0) { $vs_view = 'no_results'; }
		switch($vs_view) {
			case 'full':
				print $this->render('Results/ca_objects_results_full_html.php');
				break;
			case 'no_results':
				print $this->render('Results/ca_objects_search_no_results_html.php');
				break;
			default:
				print $this->render('Results/ca_objects_results_thumbnail_html.php');
				break;
		}
?>		
	</div><!-- end sectionbox -->
<?php
	}
?>
	</div><!-- end resultbox -->
	</div><!-- end search -->
<script type="text/javascript">
	jQuery(".qlButton").overlay({
		speed: 120,
		top: 20,
		onBeforeLoad: function(content, link) {
			jQuery('#quickLookOverlayContent').empty();
			jQuery(".qlButtonContainerThumbnail").css("display", "none");
		},
		onLoad: function(content, link) {
			content.find("#quickLookOverlayContent").load('<?php print caNavUrl($this->request, 'find', 'SearchObjects', 'QuickLook', array());?>' + '/object_id/' + link.attr("href")); 
    	} 
    });
</script>