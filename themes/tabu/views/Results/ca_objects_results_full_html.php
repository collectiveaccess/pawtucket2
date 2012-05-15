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
 * Copyright 2008-2010 Whirl-i-Gig
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
 	
$vo_result 					= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$va_access_values 		= $this->getVar('access_values');

# --- if the user is logged in, get the current set so can check if results are in set
$va_set_items = array();
if($this->request->isLoggedIn()){
	$t_set = new ca_sets();
	$va_sets = caExtractValuesByUserLocale($t_set->getSets("ca_objects", $this->request->getUserID()));
	$va_first_set = array_shift($va_sets);
	if (sizeof($va_first_set)) {
		$vn_set_id = $va_first_set['set_id'];
	}
	$t_set->load($vn_set_id);
	# --- get items from set
	$va_set_items_info = $t_set->getItems(array('returnRowIdsOnly' => 1, 'checkAccess' => $va_access_values));
	if(!is_array($va_set_items_info)){
		$va_set_items_info = array();
	}
	$va_set_items = array_keys($va_set_items_info);
}

if($vo_result) {
	$vn_item_count = 0;
	
	switch(ResultContext::getLastFind($this->request, 'ca_objects')) {
		case 'basic_browse':
			$vs_find_controller = 'Browse';
			break;
		case 'advanced_search':
			$vs_find_controller = 'AdvancedSearch';
			break;
		case 'basic_search':
		default:
			$vs_find_controller = 'Search';
			break;
	}
?>
	<table class="resultsTable" border="0">
		<thead>
		<tr>
			<td colspan="21" class="border"><!-- empty --></td>
		</tr>
		<tr>
			<th class="borderDash"><!-- empty --></th>
			<th><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/order_results.gif" border="0"><?php print _t("Nr."); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th style="width:75px;"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/order_results.gif" border="0"><?php print _t("Merken"); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/order_results.gif" border="0">'._t("Typ"), '', '', $vs_find_controller, 'Index', array("sort" => 'ca_objects.type_id' )); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/order_results.gif" border="0">'._t("Datensatz-Nr."), '', '', $vs_find_controller, 'Index', array("sort" => 'ca_objects.idno_sort' )); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/order_results.gif" border="0">'._t("Einstellungs-Nr."), '', '', $vs_find_controller, 'Index', array("sort" => 'ca_objects.einstellungs_nr' )); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/order_results.gif" border="0">'._t("Datum"), '', '', $vs_find_controller, 'Index', array("sort" => 'ca_objects.date_translated' )); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/order_results.gif" border="0">'._t("Drehort"), '', '', $vs_find_controller, 'Index', array("sort" => 'ca_objects.location' )); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th style="width:75px;"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/order_results.gif" border="0">'._t("Kameramann"), '', '', $vs_find_controller, 'Index', array("sort" => 'ca_objects.cameraman' )); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th style="width:65px;"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/order_results.gif" border="0">'._t("Personen"), '', '', $vs_find_controller, 'Index', array("sort" => 'ca_objects.people' )); ?></th>
			<th class="borderDash"><!-- empty --></th>
			<th style="width:10px;"></th>
			<th class="borderDash"><!-- empty --></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td colspan="21" class="spacer"><!-- empty --></td>
		</tr>
		<tr>
			<td colspan="21" class="border"><!-- empty --></td>
		</tr>
<?php
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		$vn_item_count++;
		$vn_item_count_display = (($this->getVar('page') - 1) * $vn_items_per_page) + $vn_item_count;
?>
		<tr>
			<td class="borderDash"><!-- empty --></td>
			<td><?php print $vn_item_count_display; ?></td>
			<td class="borderDash"><!-- empty --></td>
			<td style="text-align:center; vertical-align:middle;">
<?php
			if($this->request->isLoggedIn()){
				if(in_array($vn_object_id, $va_set_items)){
					print "<img src='".$this->request->getThemeUrlPath()."/graphics/box_on_red.gif' border='0'>";
				}else{
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/box_off.gif' border='0'>", '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
				}
			}else{
				print caNavLink($this->request, _t("Anmelden um Lesezeichen zu setzen"), '', '', 'LoginReg', 'form');
			}
?>
			</td>
			<td class="borderDash"><!-- empty --></td>
			<td style="text-align:center; vertical-align:middle;">
<?php
			switch($vo_result->get('ca_objects.type_id')){
				case 23:
					print "<img src='".$this->request->getThemeUrlPath()."/graphics/type_video_results.gif' border='0'>";
				break;
				# ------------------
				case 21:
					print "<img src='".$this->request->getThemeUrlPath()."/graphics/type_script_results.gif' border='0'>";
				break;
				# ------------------
				case 22:
					print "<img src='".$this->request->getThemeUrlPath()."/graphics/type_continuity_results.gif' border='0'>";
				break;
				# ------------------
			}
?>
			</td>
			<td class="borderDash"><!-- empty --></td>
			<td><?php print caNavLink($this->request, $vo_result->get('ca_objects.idno'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td>
			<td class="borderDash"><!-- empty --></td>
			<td><?php print caNavLink($this->request, $vo_result->get('ca_objects.einstellungs_nr'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td>
			<td class="borderDash"><!-- empty --></td>
			<td><?php print $vo_result->get('ca_objects.date_translated'); ?></td>
			<td class="borderDash"><!-- empty --></td>
			<td><?php print $vo_result->get('ca_objects.location'); ?></td>
			<td class="borderDash"><!-- empty --></td>
			<td><?php print $vo_result->get('ca_objects.cameraman'); ?></td>
			<td class="borderDash"><!-- empty --></td>
			<td><?php print $vo_result->get('ca_objects.people'); ?></td>
			<td class="borderDash"><!-- empty --></td>
			<td>
<?php
				if($vo_result->get('ca_objects.action')){
?>
					<a href="#" onclick='$("#action<?php print $vo_result->get('ca_objects.object_id'); ?>").toggle(); $("#border<?php print $vo_result->get('ca_objects.object_id'); ?>").toggle(); return false;'>+</a>
<?php
				}
?>
			</td>
			<td class="borderDash"><!-- empty --></td>
		</tr>
		<tr>
			<td colspan="21" class="border"><!-- empty --></td>
		</tr>
<?php
		if($vo_result->get('ca_objects.action')){
?>
			<tr class="actionRow" id="action<?php print $vo_result->get('ca_objects.object_id'); ?>">
				<td class="borderDash"><!-- empty --></td>
				<td colspan="19" class='action'><div class="heading"><?php print _t("Action"); ?></div><div><?php print $vo_result->get('ca_objects.action'); ?></div></td>
				<td class="borderDash"><!-- empty --></td>
			</tr>
			<tr class="actionBorderRow" id="border<?php print $vo_result->get('ca_objects.object_id'); ?>">
				<td colspan="21" class="border"><!-- empty --></td>
			</tr>
<?php
		}
	}
?>
	</tbody></table>
<?php
}
?>