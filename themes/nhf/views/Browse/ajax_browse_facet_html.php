<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ajax_browse_facet.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
	$va_facet = $this->getVar('facet');
	$vs_facet_name = $this->getVar('facet_name');
	$va_facet_info = $this->getVar('facet_info');
	if (!is_array($va_other_params = $this->getVar('other_parameters'))) {
		$va_other_params = array();
	}
	if (!$va_facet||!$vs_facet_name) { 
		print 'No facet defined'; 
		return;
	}
	
	
	if (!$vm_modify_id = $this->getVar('modify')) { $vm_modify_id = '0'; }
?>
<div id="title"><?php print unicode_ucfirst($va_facet_info['label_plural']); ?></div>
<div class="browsePanelContentArea">
	<div class="browsePanelList">
<?php
		$vn_items_per_row = ceil(sizeof($va_facet)/3);
		$i = 0;
		$total = 0;
		$col = 0;
		foreach($va_facet as $vn_i => $va_item){
			if($i == 0){
				$col++;
				print "<div class='browsePanelListCol' ".(($col == 3) ? "style='border-right:0px;'" : "").">";
			}
			print "<div>";
			print caNavLink($this->request, $va_item['label'], 'browsePanelLink', $this->request->getModulePath(), $this->request->getController(), ((strlen($vm_modify_id) > 0) ? 'modifyCriteria' : 'addCriteria'), array_merge(array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'mod_id' => $vm_modify_id), $va_other_params));
			print "</div>";
			$i++;
			$total++;
			if(($i == $vn_items_per_row) || ($total == sizeof($va_facet))){
				print "</div><!-- end browsePanelListCol -->";
				$i = 0;
			}
		}	
?>
	</div>
</div>