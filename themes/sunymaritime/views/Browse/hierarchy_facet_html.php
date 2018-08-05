<?php
/* ----------------------------------------------------------------------
 * views/Browse/hierarhcy_facet_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
	# -----------------------------------------------------------
	# --- facet view for group_mode = hierarchical
	# -----------------------------------------------------------
	
	$vs_browse_type = 		$this->getVar('browse_type');
	$va_facet_content = 	$this->getVar('facet_content');
	$vs_facet_name = 		$this->getVar('facet_name');
	$vs_view = 				$this->getVar('view');
	$vs_key = 				$this->getVar('key');
	$va_facet_info = 		$this->getVar("facet_info");
	$vb_is_nav = 			(bool)$this->getVar('isNav');
	$vn_id = 				$this->request->getParameter('id', pInteger);
	
	if(!$vb_is_nav){
		print "<H1>".$va_facet_info["label_plural"]."</H1>";
	}
	
	print "<div id='bAncestorList' class='bAncestorList_".$vs_facet_name.(($vb_is_nav) ? "Nav" : "")."'></div>";
	print "<div id='bScrollList' class='bScrollListHierarchy'>";

	// Put up spinner while we load data using ajax request
	print "<div id='bHierarchyListMorePanel_".$vs_facet_name.(($vb_is_nav) ? "Nav" : "")."'>".caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...'))."</div>";
	
	print "</div><!-- end bScrollList -->";
	print "<div style='clear:both;'></div>";	
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#bHierarchyListMorePanel_<?php print $vs_facet_name.(($vb_is_nav) ? "Nav" : ""); ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'isNav' => $vb_is_nav ? 1 : 0, 'id' => (int)$vn_id)); ?>");
		jQuery(".bAncestorList_<?php print $vs_facet_name.(($vb_is_nav) ? "Nav" : ""); ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'isNav' => $vb_is_nav ? 1 : 0, 'id' => (int)$vn_id)); ?>");
	});
</script>