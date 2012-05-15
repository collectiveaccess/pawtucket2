<?php
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
<h1><?php print _t("Your Collections").": ".$this->getVar("set_name"); ?></h1>
<?php
		if (!sizeof($va_sets)) {
			// no sets for this user
?>
					<div class="error">
<?php
						print _t('There are no collections to edit. Create a collection to start.');
?>
					</div>
<?php		
		} else {
			if (!$vn_set_id) {
				// no set selected for editing
?>
					<div class="error">
<?php
						print _t('Choose a collection to begin editing.');
?>
					</div>
<?php			
			} else {
				if (!is_array($va_items) || (!sizeof($va_items) > 0)) {
					// set we're editing is empty
?>
					<div class="error">
<?php
						print _t('There are no items in this collection.');
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
<div id="setItemEditor">
	<div id="infoCol">
<?php
	if ($vn_set_id) {
		# --- current set info and form to edit
		if($vn_set_id){
			print "<div class='collapseListHeading'><a href='#' onclick='$(\"#collectionInformation\").slideToggle(250); return false;'>"._t("Collection Information")."</a></div><!-- end collapseListHeading -->";
			print "<div id='collectionInformation' class='listInfo' style='display:none;'>";
			if($this->getVar("set_access") == 1){
				$vs_access = _t("public");
			}else{
				$vs_access = _t("private");
			}
			print "<strong>".$this->getVar("set_name")."</strong>";
			print "&nbsp;&mdash;&nbsp;<em>"._t("This collection is %1", $vs_access)."</em>";
			if ($this->getVar("set_access") == 1) {
				print "<div style='margin:5px 0px 5px 0px;'>"._t('Public URL').":<br/><form><textarea rows='2'>".$this->request->config->get('site_host').caNavUrl($this->request, '', 'Sets', 'Slideshow', array('set_id' => $vn_set_id), array('target' => '_ext'))."</textarea></form></div>";
			}
			if($this->getVar("set_description")){
				print "<div style='margin-top:5px;'>".$this->getVar("set_description")."</div>";
			}
			
			print "<div class='edit'><a href='#' id='editSetButton' onclick='$(\"#editSetButton\").slideUp(1); $(\"#editForm\").slideDown(250); return false;'>"._t("Edit")." &rsaquo;</a></div>";
?>					
				<div id="editForm" <?php print (sizeof($va_errors_edit_set) > 0) ? "" : "style='display:none;'"; ?>>
					<h2><?php print _t("Editing Collection Information"); ?></h2>
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
				</div><!-- end editForm -->
			</div><!-- end collectionInformation -->
<?php
		}
	}

	print "<div class='collapseListHeading'><a href='#' onclick='$(\"#yourCollections\").slideToggle(250); return false;'>"._t("Your Collections")."</a></div><!-- end collapseListHeading -->";
	print "<div id='yourCollections' class='listItems' style='display:none;'>";
	$i = 0;
	foreach($va_sets as $va_set) {
		$i++;
		print "<div class='item'".(($i == sizeof($va_sets)) ? " style='border-bottom:0px;'" : "").">".caNavLink($this->request, $va_set['name'], (($va_set['set_id'] == $vn_set_id) ? 'setsListCurrent' : ''), '', 'Sets', 'index', array('set_id' => $va_set['set_id']))."</div>\n";
	}
	print "</div><!-- end yourCollections -->";
	print "<div class='collapseListHeading'><a href='#' onclick='$(\"#newCollection\").slideToggle(250); return false;'>"._t("New Collection")."</a></div><!-- end collapseListHeading -->";
	print "<div id='newCollection' class='listInfo' ".((sizeof($va_errors_new_set) > 0) ? "" : "style='display:none;'").">";
?>
			<div id="newForm">
				<h2><?php print _t("Make a new Collection"); ?></h2>
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
			</div>
<?php	
	print "</div><!-- end newCollection -->";
	
	if (($vn_set_id) && (is_array($va_items) && (sizeof($va_items) > 0))) {
?>
		<div class="collapseListHeading"><?php print caNavLink($this->request, _t("View slideshow"), '', '', 'Sets', 'slideshow', array('set_id' => $vn_set_id)); ?></div>
<?php
	}
?>
	</div><!-- end infoCol -->
	<div id="setItemList" class='listItems'>
		<H2><?php print _t("Collection Items"); ?></H2>
<?php
		if (is_array($va_items) && (sizeof($va_items) > 0)) {

			foreach($va_items as $vn_item_id => $va_item) {
				$vs_title = "";
?>
				<div class='item' id='setItem<?php print $vn_item_id; ?>'>
						<div class='thumb imagecontainer'>
<?php
						if ($va_item['representation_tag_icon']) {
							print caNavLink($this->request, $va_item['representation_tag_icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']));
						}
?>
						</div><!-- end thumb -->
<?php
						if ($va_item['idno']) {
							$vs_title .= $va_item['idno'].": ";
						}
						if ($va_item['name']) {
							if (unicode_strlen($va_item['name']) > 70) {
								$vs_title = '<em>'.unicode_substr($va_item['name'], 0, 67).'...</em>';
							} else {
								$vs_title = '<em>'.$va_item['name'].'</em>';
							}
						}	
						print caNavLink($this->request, $vs_title, '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']));
?>
						<div class="remove"><a href='#' class='setDeleteButton' id='setItemDelete<?php print $vn_item_id; ?>'>Remove from Collection &rsaquo;</div><!-- end remove -->
						<div style="clear:both;"><!-- empty --></div>
					</div>
<?php	
			}
		}
?>
	</div><!-- end setItemList -->
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