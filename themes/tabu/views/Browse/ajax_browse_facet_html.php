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
	
	$va_types = $this->getVar('type_list');
	$va_relationship_types = $this->getVar('relationship_type_list');
	
	if (!is_array($va_other_params = $this->getVar('other_parameters'))) {
		$va_other_params = array();
	}
	

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
	if (!$va_facet||!$vs_facet_name) { 
		print 'No facet defined'; 
		return;
	}
	
	
	if (!$vm_modify_id = $this->getVar('modify')) { $vm_modify_id = '0'; }
?>
	<div id="breadcrumbTrail">
<?php
	print caNavLink($this->request, "&gt; "._t("Themensuche"), '', '', 'Browse', 'clearCriteria');
	print "<a href='#'>&gt; ".unicode_ucfirst($va_facet_info['label_plural'])."</a>";
?>
	</div><!-- end breadcrumbTrail -->
<H1><?php print unicode_ucfirst($va_facet_info['label_plural']); ?></H1>
<div id='facetList'>

<?php
	$va_grouped_items = array();
	switch($va_facet_info['group_mode']) {
		# ------------------------------------------------------------
		case 'none':
			$vn_col = 0;
			if(sizeof($va_facet) > 10){
				$vn_col = 1;
				$vn_numPerCol = ceil((sizeof($va_facet))/3);
			}				
			$i = 0;
			$i_col = 0;
			foreach($va_facet as $vn_i => $va_item) {
				if($vn_col && $i_col == 0){
					print "<div class='col'>";
				}
				print "<div>".caNavLink($this->request, strip_tags($va_item['label']), 'browseSelectPanelLink', $this->request->getModulePath(), $this->request->getController(), ((strlen($vm_modify_id)) ? 'modifyCriteria' : 'addCriteria'), array_merge(array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'mod_id' => $vm_modify_id), $va_other_params))."</div>";
				$i++;
				$i_col++;
				if($vn_col && (($i_col == $vn_numPerCol) || ($i == sizeof($va_facet)))){
					print "</div>";
					$i_col = 0;
				}
			}
			break;
		# ------------------------------------------------------------
		case 'alphabetical';
		default:
			$o_tep = new TimeExpressionParser();
		
			// TODO: how do we handle non-latin characters?
			$va_label_order_by_fields = isset($va_facet_info['order_by_label_fields']) ? $va_facet_info['order_by_label_fields'] : array('label');
			
			foreach($va_facet as $vn_i => $va_item) {
				$va_groups = array();
				switch($vs_grouping_field) {
					case 'label':
						$va_groups[] = mb_substr($va_item[$va_label_order_by_fields[0]], 0, 1);	
						break;
					case 'relationship_types':
						$vs_extra_padding = 20;
						foreach($va_item['rel_type_id'] as $vs_g) {
							if (isset($va_relationship_types[$vs_g]['typename'])) {
								$va_groups[] = $va_relationship_types[$vs_g]['typename'];
							} else {
								$va_groups[] = $vs_g;
							}
						}
						break;
					case 'type':
						$vs_extra_padding = 20;
						foreach($va_item['type_id'] as $vs_g) {
							if (isset($va_types[$vs_g]['name_plural'])) {
								$va_groups[] = $va_types[$vs_g]['name_plural'];
							} else {
								$va_groups[] = _t('Type ').$vs_g;
							}
						}
						break;
					default:
						if ($vn_grouping_attribute_id) {
							switch($vn_element_datatype) {
								case 2: //date
									$va_tmp = explode(':', $vs_grouping_field);
									if(isset($va_item['ca_attribute_'.$vn_grouping_attribute_id]) && is_array($va_item['ca_attribute_'.$vn_grouping_attribute_id])) {
										foreach($va_item['ca_attribute_'.$vn_grouping_attribute_id] as $vn_i => $va_v) {
											$va_v = $o_tep->normalizeDateRange($va_v['value_decimal1'], $va_v['value_decimal2'], (isset($va_tmp[1]) && in_array($va_tmp[1], array('years', 'decades', 'centuries'))) ? $va_tmp[1] : 'decades');
											foreach($va_v as $vn_i => $vn_v) {
												$va_groups[] = $vn_v;
											}
										}
									}
									break;
								default:
									if(isset($va_item['ca_attribute_'.$vn_grouping_attribute_id]) && is_array($va_item['ca_attribute_'.$vn_grouping_attribute_id])) {
										foreach($va_item['ca_attribute_'.$vn_grouping_attribute_id] as $vn_i => $va_v) {
											$va_groups[] = $va_v['value_longtext1'];
										}
									}
									break;
							}
						} else {
							$va_groups[] = mb_substr($va_item[$va_label_order_by_fields[0]], 0, 1);	
						}
						break;
				}
				
				foreach($va_groups as $vs_group) {
					$vs_group = unicode_ucfirst($vs_group);
					$vs_alpha_key = '';
					foreach($va_label_order_by_fields as $vs_f) {
						$vs_alpha_key .= $va_item[$vs_f];
					}
					$vs_alpha_key = trim($vs_alpha_key);
					if (preg_match('!^[A-Z0-9]{1}!', $vs_group)) {
						$va_grouped_items[$vs_group][$vs_alpha_key] = $va_item;
					} else {
						$va_grouped_items['~'][$vs_alpha_key] = $va_item;
					}
				}
			}
			
			// sort lists alphabetically
			foreach($va_grouped_items as $vs_key => $va_list) {
				ksort($va_list);
				$va_grouped_items[$vs_key] = $va_list;
			}
			ksort($va_grouped_items);
			$va_groups = array_keys($va_grouped_items);
?>
	<div id="browseSelectPanelHeader">
		<div id="browseSelectPanelHeaderContent"><nobr>
<?php 
	foreach($va_groups as $vs_group) {
		$vs_group_proc = preg_replace("![^A-Za-z0-9]+!", "_", $vs_group);
		if($vs_extra_padding){
			$vs_group = "<span style='padding-right:25px;'>".$vs_group."</span>";
		}
		print " <a href='#' onclick='jQuery(\".browseSelectPanelList\").scrollTop(jQuery(\".browseSelectPanelList\").scrollTop() + jQuery(\"#browse_group_{$vs_group_proc}\").offset().top - 193); return false;'>{$vs_group}</a> ";
	}
?>
		</nobr></div>
	</div>
	<div class="listDivide">&nbsp;</div>
	<div class="browseSelectPanelList">
<?php
			foreach($va_grouped_items as $vs_group => $va_items) {
				$va_row = array();
				if ($vs_group === '~') {
					$vs_group = '~';
				}
				$vs_group_proc = preg_replace("![^A-Za-z0-9]+!", "_", $vs_group);
				print "<div class='browseSelectPanelListGroupHeading' id='browse_group_{$vs_group_proc}'><a name='{$vs_group_proc}' class='browseSelectPanelListGroupHeading'>{$vs_group}</a></div>\n";
?>
		<table class='browseSelectPanelListTable'>
<?php
				foreach($va_items as $va_item) {
					$va_row[] = "<td class='browseSelectPanelListCell'>".caNavLink($this->request, $va_item['label'], 'browseSelectPanelLink', $this->request->getModulePath(), $this->request->getController(), ((strlen($vm_modify_id) > 0) ? 'modifyCriteria' : 'addCriteria'), array_merge(array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'mod_id' => $vm_modify_id), $va_other_params))."</td>";
					
					if (sizeof($va_row) == 5) {
						print "<tr valign='top'>".join('', $va_row)."</tr>\n";
						
						$va_row = array();
					}
				}
				if (sizeof($va_row) > 0) {
					if (sizeof($va_row) < 5) {
						for($vn_i = sizeof($va_row); $vn_i <= 5; $vn_i++) {
							$va_row[] = '<td> </td>';
						}
					}
					print "<tr valign='top'>".join('', $va_row)."</tr>\n";
				}
?>
		</table>
		<div class="listDivide">&nbsp;</div>
<?php
			}
?>
	</div>
<?php
			break;
		# ------------------------------------------------------------
	}
?>
</div>