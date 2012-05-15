<?php
	$t_set = $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$t_new_set = $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$vn_set_id = $t_set->getPrimaryKey();		// primary key of set we're currently editing
	$va_items = $this->getVar('items');			// array of items in the set we're currently editing
	
	$va_sets = $this->getVar('set_list');		// list of existing sets this user has access to
	
	$va_errors = $this->getvar("errors");
	$va_errors_edit_set = $this->getVar("errors_edit_set");
	$va_errors_new_set = $this->getVar("errors_new_set");
	global $g_ui_locale;
?>
<h1><?php print _t("Your Sets"); ?></h1>
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
			print "<b>".$this->getVar("set_name")."</b>";
			print "&nbsp;&mdash;&nbsp;<i>"._t("This set is")." ".$vs_access."</i>";
			if ($this->getVar("set_access") == 1) {
				print "<div style='margin:5px 0px 5px 0px;'>"._t('Public URL').":<br/><form><textarea rows='1' cols='27'>".$this->request->config->get('site_host').caNavUrl($this->request, '', 'Sets', 'Slideshow', array('set_id' => $vn_set_id), array('target' => '_ext'))."</textarea></form></div>";
			}
			if($this->getVar("set_description")){
				print "<div style='margin-top:5px;'>".$this->getVar("set_description")."</div>";
			}
			
			print "<div class='edit'><a href='#' id='editSetButton' onclick='$(\"#editSetButton\").slideUp(1); $(\"#editForm\").slideDown(250); return false;'>"._t("Edit Set")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'></a></div>";
			print "</div>";
?>					
			<div id="editForm" <?php print (sizeof($va_errors_edit_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2>Editing Set Information</h2>
<?php
				if($va_errors_edit_set["edit_set"]){
					print "<div class='formErrors'>".$va_errors_edit_set["edit_set"]."</div>";
				}
?>
				<form action="<?php print caNavUrl($this->request, 'Sets', 'saveSetInfo', ''); ?>" method="post" id="editSetForm">
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
					<textarea name="description" rows="5"><?php print htmlspecialchars($t_set->getAttributesForDisplay('set_intro'), ENT_QUOTES, 'UTF-8'); ?></textarea>
					<br/><a href="#" name="newSetSubmit" onclick="document.forms.editSetForm.submit(); return false;"><?php print _t("Save"); ?></a>
					<input type='hidden' name='set_id' value='<?php print $vn_set_id; ?>'/>
				</form>
				<a href='#' id='editSetButton' onclick='$("#editForm").slideUp(250); $("#editSetButton").slideDown(250); return false;' class='hide'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
			</div><!-- end editForm -->
<?php
		}
	}
?>

		<h2><?php print _t("Your Sets"); ?></h2>
<?php
	foreach($va_sets as $va_set) {
		if($va_set['set_id'] == $vn_set_id){
			print "<div class='setsListCurrent'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".$va_set['name']."</div>\n";
		}else{
			print "<div class='setsList'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, $va_set['name'], '', '', 'Sets', 'index', array('set_id' => $va_set['set_id']))."</div>\n";
		}
	}
?>
		
		<h2><?php print _t("Options"); ?></h2>
<?php
	if (($vn_set_id) && (is_array($va_items) && (sizeof($va_items) > 0))) {
?>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <?php print caNavLink($this->request, _t("View slideshow"), '', '', 'Sets', 'slideshow', array('set_id' => $vn_set_id)); ?></div>
<?php
	}
?>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <a href='#' id='newSetButton' onclick=' $("#helpTips").slideUp(1); $("#newForm").slideDown(250);return false;'><?php print _t("Create a new set"); ?></a></div>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <a href='#' id='helpTipsButton' onclick='$("#newForm").slideUp(1); $("#helpTips").slideDown(250); return false;'><?php print _t("View help tips"); ?></a></div>			
			<div id="newForm" <?php print (sizeof($va_errors_new_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("Make a new set"); ?></h2>
					<form action="<?php print caNavUrl($this->request, 'Sets', 'addNewSet', ''); ?>" method="post" id="newSetForm">
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
				<a href='#' id='editSetButton' onclick='$("#newForm").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
			</div>
			<div id="helpTips" style="display:none;">
<?php
			print "<h2>"._t("Help Tips")."</h2>";
?>
				<ul>
					<li><b><?php print _t("How do I add images to my set?"); ?></b>
						<div>
							<?php print _t("You can add images and video to your set while you are browsing the Wir waren so frei... Momentaufnahmen 19989/1990 website.  You'll find <i>Add to Set</i> links beneath images and video throughout the site."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><b><?php print _t("Can I have more than one image set?"); ?></b>
						<div>
							<?php print _t("Yes.  Click the <i>Make a new Image Set</i> link above to create a new set of images."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><b><?php print _t("How do I change between image sets?"); ?></b>
						<div>
							<?php print _t("Click on the name of the set you want to work with in the <i>YOUR SETS</i> list."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><b><?php print _t("How can I change the name of my set?"); ?></b>
						<div>
							<?php print _t("Click the <i>EDIT</i> link in the <i>CURRENT SET</i> box above.  A form will slide open allowing you to change the name, display options and description of the image set you are currently working with."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><b><?php print _t("Can I change the order of the images in my image set's slide show?"); ?></b>
						<div>
							<?php print _t("Yes.  You can organize the content in your sets by dragging and dropping them into your preferred order.  Your changes are automatically saved once you drop the content into place."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><b><?php print _t("Can I share my set with others?"); ?></b>
						<div>
							<?php print _t("Yes.  When you set the display option of your set to <i>Public</i>, your set's slideshow becomes publicly accessible.  You can share the link to your slideshow with friends, students and colleagues."); ?>
						</div>
					</li>
				</ul>
				<a href='#' id='editSetButton' onclick='$("#helpTips").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
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

			foreach($va_items as $va_item) {
				$vs_title = "";
				$va_title = array();
?>
				<li class='setItem' id='setItem<?php print $va_item['item_id']; ?>'>
					<div id='setItemContainer<?php print $va_item['item_id']; ?>' class='imagecontainer'>
						<div class='remove'><a href='#' class='setDeleteButton' id='setItemDelete<?php print $va_item['item_id']; ?>'>X</a></div>
						<div class='setItemThumbnail'>
<?php
						if ($va_item['representation_tag']) {
							print caNavLink($this->request, $va_item['representation_tag'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']));
						}
						
						if ($va_item['name']) {
							if (unicode_strlen($va_item['name']) > 70) {
								$va_title[] = '<i>'.unicode_substr($va_item['name'], 0, 67).'...</i>';
							} else {
								$va_title[] = '<i>'.$va_item['name'].'</i>';
							}
						}
						
						if ($va_item['idno']) {
							$va_title[] = '<b>'._t('Id:').'</b> '.$va_item['idno'];
						}
						$vs_title = join('<br/>', $va_title);
?>
						</div>
						<div id='caption<?php print $va_item['item_id']; ?>' class='setItemCaption'><?php print $vs_title; ?></div>
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
				jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Sets', 'DeleteItem'); ?>', {'set_id': '<?php print $vn_set_id; ?>', 'item_id':id} , function(data) { 
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
					jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Sets', 'ReorderItems'); ?>', {'set_id': '<?php print $vn_set_id; ?>', 'sort':jQuery("#setItemList").sortable('toArray').join(';')} , function(data) { if(data.status != 'ok') { alert('Error: ' + data.errors.join(';')); }; });
				}
			});
		}
		_makeSortable();
	</script>
</div><!-- end setItemEditor -->