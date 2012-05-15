<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ajax_browse_facet.php 
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
<script type="text/javascript">
	function caUpdateFacetDisplay(grouping) {
		caUIBrowsePanel.showBrowsePanel('<?php print $vs_facet_name; ?>', <?php print (intval($vm_modify_id) > 0) ? 'true' : 'false'; ?>, <?php print (intval($vm_modify_id) > 0) ? intval($vm_modify_id) : 'null'; ?>, grouping);
	}
	
	//
	// Handle browse header scrolling
	//
	jQuery(document).ready(function() {
		if (jQuery('#browseSelectPanelHeaderContent').width() > jQuery('#browseSelectPanelHeader').width()) {
			jQuery('#browseFacetNextPrevControls').show();
			jQuery('#browseSelectPanelHeaderContent').css('left', "0px");
			jQuery('#browseFacetNextControl').click(function() {
				if ((parseInt(jQuery('#browseSelectPanelHeaderContent').css('left'))) >=  ((jQuery('#browseSelectPanelHeaderContent').width() - jQuery('#browseSelectPanelHeader').width()) * -1)) {
					jQuery('#browseSelectPanelHeaderContent').animate({'left': (parseInt(jQuery('#browseSelectPanelHeaderContent').css('left')) - jQuery('#browseSelectPanelHeader').width()) + "px" }, 250); 
				}
			});
			jQuery('#browseFacetPrevControl').click(function() {
				if ((parseInt(jQuery('#browseSelectPanelHeaderContent').css('left')) + jQuery('#browseSelectPanelHeader').width()) <= 0) {
					jQuery('#browseSelectPanelHeaderContent').animate({'left': (parseInt(jQuery('#browseSelectPanelHeaderContent').css('left')) + jQuery('#browseSelectPanelHeader').width()) + "px"}, 250); 
				}
			});
		} else {
			jQuery('#browseFacetNextPrevControls').hide();
		}
	});
</script>
<div id="title"><?php print unicode_ucfirst($va_facet_info['label_plural']); ?></div>
<div class="browseSelectPanelContentArea">
<?php 
	if (isset($va_facet_info['groupings']) && is_array($va_facet_info['groupings']) && sizeof($va_facet_info['groupings'] )) {
		print "<div id='browseFacetGroupingControls'>";
		print _t('Group by').': '; 
		
		$i = 1;
		foreach($va_facet_info['groupings'] as $vs_grouping => $vs_grouping_label) {
			print "<a href='#' onclick='caUpdateFacetDisplay(\"{$vs_grouping}\");' class='".(($vs_grouping == $vs_grouping_field) ? 'selected' : '')."'>{$vs_grouping_label}</a>";
			if($i < sizeof($va_facet_info['groupings'])){
				print " | ";
			}
			$i++;
		}
		print "</div>";
	}
?>
	<div id="browseSelectPanelHeaderScrollButtons">
		<div id="browseFacetNextPrevControls"><a href="#" id="browseFacetPrevControl"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrowLeft.gif" width="10" height="12" border="0"></a> <a href="#" id="browseFacetNextControl"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrowRight.gif" width="10" height="12" border="0"></a></div>
	</div>
<?php
	$va_grouped_items = array();
	switch($va_facet_info['group_mode']) {
		# ------------------------------------------------------------
		case 'none':
			sort($va_facet);
?>
	<div class="browseSelectPanelList">
		<table class='browseSelectPanelListTable'>
<?php
			$va_row = array();
			foreach($va_facet as $vn_i => $va_item) {
?>
<?php
				$va_row[] = "<td class='browseSelectPanelListCell'>".caNavLink($this->request, $va_item['label'], 'browseSelectPanelLink', $this->request->getModulePath(), $this->request->getController(), ((strlen($vm_modify_id)) ? 'modifyCriteria' : 'addCriteria'), array_merge(array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'mod_id' => $vm_modify_id), $va_other_params))."</td>";
				
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
	</div>
<?php
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
						foreach($va_item['rel_type_id'] as $vs_g) {
							if (isset($va_relationship_types[$vs_g]['typename'])) {
								$va_groups[] = $va_relationship_types[$vs_g]['typename'];
							} else {
								$va_groups[] = $vs_g;
							}
						}
						break;
					case 'type':
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