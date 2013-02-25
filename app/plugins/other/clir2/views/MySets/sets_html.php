<?php
/* ----------------------------------------------------------------------
 * app/plugins/clir2/views/MySets/sets_html.php : 
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
<h1><?php print _t("My Sets"); ?></h1>
<div id="setItemEditor">
	<div id="rightCol">
<?php
	if ($vn_set_id) {
?>
		<h2><?php print _t("Current Set"); ?></h2>
<?php
		# --- current set info and form to edit
		if($vn_set_id){
			print "<div class='setInfo'>";
			if($this->getVar("set_access") == 1){
				$vs_access = _t("public");
			}else{
				$vs_access = _t("private");
			}
			print "<strong>".$this->getVar("set_name")."</strong>";
			print "&nbsp;&mdash;&nbsp;<em>"._t("This set is %1", $vs_access)."</em>";
			if ($this->getVar("set_access") == 1) {
				print "<div style='margin:5px 0px 5px 0px;'>"._t('Public URL').":<br/><form><textarea rows='2' cols='27'>".$this->request->config->get('site_host').caNavUrl($this->request, 'clir2', 'MySets', 'Slideshow', array('set_id' => $vn_set_id), array('target' => '_ext'))."</textarea></form></div>";
			}
			if($this->getVar("set_description")){
				print "<div style='margin-top:5px;'>".$this->getVar("set_description")."</div>";
			}
			
			print "<div class='edit'><a href='#' id='editSetButton' onclick='$(\"#editSetButton\").slideUp(1); $(\"#editForm\").slideDown(250); return false;'>"._t("Edit Set")." &rsaquo;</a></div>";
			print "</div>";
?>					
			<div id="editForm" <?php print (sizeof($va_errors_edit_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("Set Information"); ?></h2>
<?php
				if($va_errors_edit_set["edit_set"]){
					print "<div class='formErrors'>".$va_errors_edit_set["edit_set"]."</div>";
				}
?>
				<form action="<?php print caNavUrl($this->request, 'clir2', 'MySets', 'saveSetInfo'); ?>" method="post" id="editSetForm">
<?php
					if($va_errors_edit_set["name"]){
						print "<div class='formErrors' style='text-align: left;'>".$va_errors_edit_set["name"]."</div>";
					}
?>
					<div class="formLabel"><?php print _t("Title"); ?></div>
					<input type="text" name="name" value="<?php print htmlspecialchars($t_set->getLabelForDisplay(), ENT_QUOTES, 'UTF-8'); ?>">
					<div class="formLabel"><?php print _t("Display Option"); ?></div>
					<select name="access" id="access">
						<option value="0" <?php print ($this->getVar("set_access") == 0) ? "selected" : ""; ?>><?php print _t("Private"); ?></option>
						<option value="1"  <?php print ($this->getVar("set_access") == 1) ? "selected=" : ""; ?>><?php print _t("Public"); ?></option>
					</select>
					<div class="formLabel"><?php print _t("Description"); ?></div>
					<textarea name="description" rows="5"><?php print htmlspecialchars($t_set->getAttributesForDisplay('description'), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<br/><a href="#" name="newSetSubmit" onclick="document.forms.editSetForm.submit(); return false;"><?php print _t("Save"); ?></a>
					<input type='hidden' name='set_id' value='<?php print $vn_set_id; ?>'/>
				</form>
				<a href='#' id='editSetButton' onclick='$("#editForm").slideUp(250); $("#editSetButton").slideDown(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div><!-- end editForm -->
<?php
		}
	}
?>

		<h2><?php print _t("My Sets"); ?></h2>
<?php
	foreach($va_sets as $va_set) {
		if($va_set['set_id'] == $vn_set_id){
			print "<div class='setsListCurrent'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".$va_set['name']."</div>\n";
		}else{
			print "<div class='setsList'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, $va_set['name'], '', 'clir2', 'MySets', 'index', array('set_id' => $va_set['set_id']))."</div>\n";
		}
	}
?>
		
		<h2><?php print _t("Options"); ?></h2>
<?php
	if (($vn_set_id) && (is_array($va_items) && (sizeof($va_items) > 0))) {
?>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <?php print caNavLink($this->request, _t("View slideshow"), '', 'clir2', 'MySets', 'slideshow', array('set_id' => $vn_set_id)); ?></div>
<?php
	}
?>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <a href='#' id='newSetButton' onclick=' $("#helpTips").slideUp(1); $("#newForm").slideDown(250);return false;'><?php print _t("Make a new set"); ?></a></div>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <a href='#' id='helpTipsButton' onclick='$("#newForm").slideUp(1); $("#helpTips").slideDown(250); return false;'><?php print _t("View help tips"); ?></a></div>			
			<div id="newForm" <?php print (sizeof($va_errors_new_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("Make a new set"); ?></h2>
					<form action="<?php print caNavUrl($this->request, 'clir2', 'MySets', 'addNewSet'); ?>" method="post" id="newSetForm">
<?php
						if($va_errors_new_set["name"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors_new_set["name"]."</div>";
						}
?>
						<div class="formLabel"><?php print _t("Title"); ?></div>
						<input type="text" name="name">
						<div class="formLabel"><?php print _t("Display Option"); ?></div>
					<select name="access" id="access">
						<option value="0"><?php print _t("Private"); ?></option>
						<option value="1"><?php print _t("Public"); ?></option>
					</select>
						<div class="formLabel"><?php print _t("Description"); ?></div>
						<textarea name="description" rows="5"></textarea>
						<br/><a href="#" name="newSetSubmit" onclick="document.forms.newSetForm.submit(); return false;"><?php print _t("Save"); ?></a>
					</form>
				<a href='#' id='editSetButton' onclick='$("#newForm").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div>
			<div id="helpTips" style="display:none;">
<?php
			print "<h2>"._t("Help Tips")."</h2>";
?>
				<ul>
					<li><strong><?php print _t("How do I add content to my set?"); ?></strong>
						<div>
							<?php print _t("You can add images and video to your set while you are browsing the website.  You'll find <em>Add to Set</em> links beneath images and video throughout the site."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("Can I have more than one set?"); ?></strong>
						<div>
							<?php print _t("Yes.  Click the <em>Make a new set</em> link above to create a new set."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("How do I change between sets?"); ?></strong>
						<div>
							<?php print _t("Click on the name of the set you want to work with in the <em>MY SETS</em> list."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("How can I change the name of my set?"); ?></strong>
						<div>
							<?php print _t("Click the <em>EDIT</em> link in the <em>CURRENT SET</em> box above.  A form will slide open allowing you to change the name, display options and description of the set you are currently working with."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("Can I change the order of the content in my set's slide show?"); ?></strong>
						<div>
							<?php print _t("Yes.  You can organize the content in your sets by dragging and dropping them into your preferred order.  Your changes are automatically saved once you drop the content into place."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("Can I share my set with others?"); ?></strong>
						<div>
							<?php print _t("Yes.  When you set the display option of your set to <em>Public</em>, your set's slideshow becomes publicly accessible.  You can share the link to your slideshow with friends, students and colleagues, and it will be made available on the Your Sets page in the Engage section of this website."); ?>
						</div>
					</li>
				</ul>
				<a href='#' id='editSetButton' onclick='$("#helpTips").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div>

	</div><!-- end divRightCol -->
	<div id="leftCol">
<?php
		if (!sizeof($va_sets)) {
			// no sets for this user
?>
					<div class="error">
<?php
						print _t('There are no sets to edit. Create a set to start.');
?>
					</div>
<?php		
		} else {
			if (!$vn_set_id) {
				// no set selected for editing
?>
					<div class="error">
<?php
						print _t('Choose a set to begin editing.');
?>
					</div>
<?php			
			} else {
				if (!is_array($va_items) || (!sizeof($va_items) > 0)) {
					// set we're editing is empty
?>
					<div class="error">
<?php
						print _t('There are no items in this set.');
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
		<ul id="setItemList">
<?php
		if (is_array($va_items) && (sizeof($va_items) > 0)) {
			$t_occurrence = new ca_occurrences();
			foreach($va_items as $vn_item_id => $va_item) {
				$t_occurrence->load($va_item['row_id']);
				$vs_title = "";
				$va_title = array();
?>
				<li class='setItem' id='setItem<?php print $vn_item_id; ?>'>
					<div id='setItemContainer<?php print $vn_item_id; ?>' class='imagecontainer'>
						<div class='remove'><a href='#' class='setDeleteButton' id='setItemDelete<?php print $vn_item_id; ?>'>X</a></div>
						<div class='setItemThumbnail'>
<?php
						$va_still_thumbnail = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "thumbnail", "showMediaInfo" => false, "returnAsArray" => true));
						if((is_array($va_still_thumbnail)) && (sizeof($va_still_thumbnail) > 0)){
							print caNavLink($this->request, array_shift($va_still_thumbnail), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_item['row_id']));						
						}
						
						if ($va_item['name']) {
							if (unicode_strlen($va_item['name']) > 70) {
								$va_title[] = '<em>'.unicode_substr($va_item['name'], 0, 67).'...</em>';
							} else {
								$va_title[] = '<em>'.$va_item['name'].'</em>';
							}
						}
						
						if ($va_item['idno']) {
							$va_title[] = '<strong>'._t('Id:').'</strong> '.$va_item['idno'];
						}
						$vs_title = join('<br/>', $va_title);
?>
						</div>
						<div id='caption<?php print $vn_item_id; ?>' class='setItemCaption'><?php print caNavLink($this->request, $vs_title, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_item['row_id'])); ?></div>
					</div>
				</li>
<?php	
			}
		}
?>
		</ul>
	</div><!-- end setItems -->
</div><!-- leftCol -->
	<script type="text/javascript">
		jQuery(".setDeleteButton").click(
			function() {
				var id = this.id.replace('setItemDelete', '');
				jQuery.getJSON('<?php print caNavUrl($this->request, 'clir2', 'MySets', 'DeleteItem'); ?>', {'set_id': '<?php print $vn_set_id; ?>', 'item_id':id} , function(data) { 
					if(data.status == 'ok') { 
						jQuery('#setItem' + data.item_id).fadeOut(500, function() { jQuery('#setItem' + data.item_id).remove(); });
					} else {
						alert('Error: ' + data.errors.join(';')); 
					}
				});
				return false;
			}
		);
		
		function _makeSortable() {
			jQuery("#setItemList").sortable({ opacity: 0.7, 
				revert: true, 
				scroll: true , 
				handle: $(".setItem").add(".imagecontainer a img") ,
				update: function(event, ui) {
					jQuery.getJSON('<?php print caNavUrl($this->request, 'clir2', 'MySets', 'ReorderItems'); ?>', {'set_id': '<?php print $vn_set_id; ?>', 'sort':jQuery("#setItemList").sortable('toArray').join(';')} , function(data) { if(data.status != 'ok') { alert('Error: ' + data.errors.join(';')); }; });
				}
			});
		}
		_makeSortable();
	</script>
</div><!-- end setItemEditor -->