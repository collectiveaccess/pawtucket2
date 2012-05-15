<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Sets/sets_html.php : 
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
 
	global $g_ui_locale;
	
	$t_set 				= $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$t_new_set 			= $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$vn_set_id 			= $t_set->getPrimaryKey();		// primary key of set we're currently editing
	$va_items 			= $this->getVar('items');			// array of items in the set we're currently editing
	
	$va_sets 			= $this->getVar('set_list');		// list of existing sets this user has access to
	
	$va_errors 			= $this->getvar("errors");
	$va_errors_edit_set = $this->getVar("errors_edit_set");
	$va_errors_new_set 	= $this->getVar("errors_new_set");
?>
 		<div id="breadcrumbTrail">
<?php
		print caNavLink($this->request, "&gt; "._t("Merkliste"), '', '', 'Sets', 'Index');
?>
		</div><!-- end breadcrumbTrail -->
<h1><?php print _t("Merkliste"); ?></h1>
<div id="setItemEditor">
<?php
		if (!sizeof($va_sets)) {
			// no sets for this user
?>
					<div class="error">
<?php
						print _t('There are no bookmark lists to edit. Create a list to start.');
?>
					</div>
<?php		
		} else {
			if (!$vn_set_id) {
				// no set selected for editing
?>
					<div class="error">
<?php
						print _t('Bookmark list is not selected.');
?>
					</div>
<?php			
			} else {
				if (!is_array($va_items) || (!sizeof($va_items) > 0)) {
					// set we're editing is empty
?>
					<div class="error">
<?php
						print _t('There are no bookmarked items.');
?>
					</div>
<?php
				}
			}
		}
		if($this->getvar("message")){
			print "<div class='message'>".$this->getvar("message")."</div>";
		}
		if(sizeof($va_errors) > 0){
			print "<div class='message'>".implode(", ", $va_errors)."</div>";
		}
?>
	<div id="setItems">
<?php
		if (is_array($va_items) && (sizeof($va_items) > 0)) {
?>
		<table class="resultsTable" id="bookmarkListTable">
			<thead>
			<tr>
				<td colspan="21" class="border"><!-- empty --></td>
			</tr>
			<tr>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Nr."); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Gemerkt"); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Typ"); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Datensatz-Nr."); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Einstellungs-Nr."); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Datum"); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Drehort"); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Kameramann"); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th><?php print _t("Personen"); ?></th>
				<th class="borderDash"><!-- empty --></th>
				<th></th>
				<th class="borderDash"><!-- empty --></th>
			</tr></thead>
			<tbody>
			<tr>
				<td colspan="21" class="spacer"><!-- empty --></td>
			</tr>
			<tr>
				<td colspan="21" class="border"><!-- empty --></td>
			</tr>
<?php

			$vn_item_count = 0;
			foreach($va_items as $vn_item_id => $va_item) {					
				$vn_object_id = $va_item['row_id'];
				$t_object = new ca_objects($vn_object_id);
				$vn_item_count++;
?>
				<tr id="setItem<?php print $vn_item_id; ?>">
					<td class="borderDash"><!-- empty --></td>
					<td><?php print $vn_item_count; ?></td>
					<td class="borderDash"><!-- empty --></td>
					<td style="text-align:center; vertical-align:middle;"><a href="#" class='setDeleteButton' id='setItemDelete<?php print $vn_item_id; ?>'><?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/box_on_red.gif' border='0'>"; ?></a></td>
					<td class="borderDash"><!-- empty --></td>
					<td style="text-align:center; vertical-align:middle;">
<?php
					switch($t_object->get('ca_objects.type_id')){
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
					<td><?php print caNavLink($this->request, $t_object->get('ca_objects.idno'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td>
					<td class="borderDash"><!-- empty --></td>
					<td><?php print caNavLink($this->request, $t_object->get('ca_objects.einstellungs_nr'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td>
					<td class="borderDash"><!-- empty --></td>
					<td><?php print $t_object->get('ca_objects.date_translated'); ?></td>
					<td class="borderDash"><!-- empty --></td>
					<td><?php print $t_object->get('ca_objects.location'); ?></td>
					<td class="borderDash"><!-- empty --></td>
					<td><?php print $t_object->get('ca_objects.cameraman'); ?></td>
					<td class="borderDash"><!-- empty --></td>
					<td><?php print $t_object->get('ca_objects.people'); ?></td>
					<td class="borderDash"><!-- empty --></td>
					<td>
<?php
						if($t_object->get('ca_objects.action')){
?>
							<a href="#" onclick='$("#action<?php print $t_object->get('ca_objects.object_id'); ?>").toggle(); $("#border<?php print $t_object->get('ca_objects.object_id'); ?>").toggle(); return false;'>+</a>
<?php
						}
?>
					</td>
					<td class="borderDash"><!-- empty --></td>

				</tr>
				<tr id="setItemBorder<?php print $vn_item_id; ?>">
					<td colspan="21" class="border"><!-- empty --></td>
				</tr>
<?php
				if($t_object->get('ca_objects.action')){
?>
					<tr class="actionRow" id="action<?php print $t_object->get('ca_objects.object_id'); ?>">
						<td class="borderDash"><!-- empty --></td>
						<td colspan="21" class='action'><div class="heading"><?php print _t("Action"); ?></div><div><?php print $t_object->get('ca_objects.action'); ?></div></td>
						<td class="borderDash"><!-- empty --></td>
					</tr>
					<tr class="actionBorderRow" id="border<?php print $t_object->get('ca_objects.object_id'); ?>">
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
	</div><!-- end setItems -->
	<script type="text/javascript">
		jQuery(".setDeleteButton").click(
			function() {
				var id = this.id.replace('setItemDelete', '');
				jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Sets', 'DeleteItem'); ?>', {'set_id': '<?php print $vn_set_id; ?>', 'item_id':id} , function(data) { 
					if(data.status == 'ok') { 
						jQuery('#setItem' + data.item_id).fadeOut(500, function() { jQuery('#setItem' + data.item_id).remove(); });
						jQuery('#setItemBorder' + data.item_id).fadeOut(500);
					} else {
						alert('Error: ' + data.errors.join(';')); 
					}
				});
				return false;
			}
		);
	</script>
</div><!-- end setItemEditor -->