<?php
/* ----------------------------------------------------------------------
 * themes/default/views/find/ajax_browse_facet.php 
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
 	
	$va_facet = $this->getVar('facet');
	$vs_facet_name = $this->getVar('facet_name');
	$va_facet_info = $this->getVar('facet_info');
	
	$va_types = $this->getVar('type_list');
	$va_relationship_types = $this->getVar('relationship_type_list');
	
	$vb_individual_group_display = (bool)$this->getVar('individual_group_display');

	$vs_grouping_field = $this->getVar('grouping');
	if ((!isset($va_facet_info['groupings'][$vs_grouping_field]) || !($va_facet_info['groupings'][$vs_grouping_field])) && is_array($va_facet_info['groupings'])) { 
		$va_tmp = array_keys($va_facet_info['groupings']);
		$vs_grouping_field = $va_tmp[0]; 
	}
	
	$vn_element_datatype = null;
	if ($vs_grouping_attribute_element_code = (preg_match('!^ca_attribute_([\w]+)!', $vs_grouping_field, $va_matches)) ? $va_matches[1] : null) {
		$t_element = new ca_metadata_elements();
		$t_element->load(array('element_code' => $vs_grouping_attribute_element_code));
		$vn_grouping_attribute_id = $t_element->getPrimaryKey();
		$vn_element_datatype = $t_element->get('datatype');
	}
	
	$vs_group_mode = $this->getVar('group_mode');
	$vm_modify_id = $this->getVar('modify') ? $this->getVar('modify') : '0';

	if (!$va_facet||!$vs_facet_name) { 
?>
		<div class="browseSelectPanelCacheError">
<?php
			print _t('These results are no longer available. <a href="%1">Click here to restart your browse</a>.', caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'clearCriteria')); 
?>
		</div>
<?php
	} else {
?>
		<!--<span class="listhead"><?php print $vs_facet_name; ?></span>-->
		<ul>
<?php
		foreach($va_facet as $vn_i => $va_item) {
			$vs_label = caGetLabelForDisplay($va_facet, $va_item, $va_facet_info);
			
			#print "<div>".caNavLink($this->request, $vs_label, 'browseSelectPanelLink', $this->request->getModulePath(), $this->request->getController(), ((strlen($vm_modify_id)) ? 'modifyCriteria' : 'addCriteria'), array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'mod_id' => $vm_modify_id))."</div>";
			print "<li><a href='#' class='abFacetOptionsList' id='abFacetOptionsList".$va_item['id']."' onclick='jQuery(\".abFacetOptionsList\").removeClass(\"selected\"); jQuery(\"#abFacetOptionsList".$va_item['id']."\").addClass(\"selected\"); jQuery(\"#contentBox\").load(\"".caNavUrl($this->request, 'eastend', 'ArtistBrowser', 'clearAndAddCriteria', array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'mod_id' => $vm_modify_id))."\"); return false;'>".$vs_label."</a></li>";
		}
?>
		</ul>
<?php
	}
?>