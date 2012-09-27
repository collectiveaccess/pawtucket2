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
	$va_errors_share_set 	= $this->getVar("errors_share_set");
	
	# --- share - email a friend
	# --- if there were errors in the form, the form paramas are passed back to preload the form
	$vs_to_email = $this->getVar("to_email");
	$vs_from_email = $this->getVar("from_email");
	$vs_from_name = $this->getVar("from_name");
	$vs_subject = $this->getVar("subject");
	$vs_message = $this->getVar("email_message");
	
	# --- if params have not been passed, set some defaults
	if(!$vs_subject && !$va_errors['subject']){
		$vs_subject = $t_set->getLabelForDisplay();
	}
	if(!$vs_from_email && $this->request->isLoggedIn() && !$va_errors['from_email']){
		$vs_from_email = $this->request->user->get("email");
	}	
	if(!$vs_from_name && $this->request->isLoggedIn() && !$va_errors['from_name']){
		$vs_from_name = $this->request->user->getName();
	}
?>
<h1><?php print _t("Lightbox"); ?></h1>
<div id="setItemEditor">
	<div id="rightCol"><div class="boxBg">
<?php
	if ($vn_set_id) {
?>
		<h2><?php print _t("Current Lightbox"); ?></h2>
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
			print "&nbsp;&mdash;&nbsp;<em>"._t("This lightbox is %1", $vs_access)."</em>";
			if ($this->getVar("set_access") == 1) {
				print "<div style='margin:5px 0px 5px 0px;'>"._t('Public URL').":<br/><form><textarea rows='2' cols='27'>".$this->request->config->get('site_host').caNavUrl($this->request, '', 'Sets', 'Slideshow', array('set_id' => $vn_set_id), array('target' => '_ext'))."</textarea></form></div>";
			}
			if($this->getVar("set_description")){
				print "<div style='margin-top:5px;'>".$this->getVar("set_description")."</div>";
			}
			
			print "<div class='edit'><a href='#' id='editSetButton' onclick='$(\"#editSetButton\").slideUp(1); $(\"#editForm\").slideDown(250); return false;'>"._t("Edit Lightbox")." &rsaquo;</a></div>";
			print "</div>";
?>					
			<div id="editForm" <?php print (sizeof($va_errors_edit_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("Lightbox Information"); ?></h2>
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
					<div class="formLabel"><?php print _t("Title"); ?><br/>
						<input type="text" name="name" value="<?php print htmlspecialchars($t_set->getLabelForDisplay(), ENT_QUOTES, 'UTF-8'); ?>">
					</div>
					<div class="formLabel"><?php print _t("Display Option"); ?><br/>
						<select name="access" id="access">
							<option value="0" <?php print ($this->getVar("set_access") == 0) ? "selected" : ""; ?>><?php print _t("Private"); ?></option>
							<option value="1"  <?php print ($this->getVar("set_access") == 1) ? "selected=" : ""; ?>><?php print _t("Public"); ?></option>
						</select>
					</div>
					<div class="formLabel"><?php print _t("Description"); ?><br/>
						<textarea name="description" rows="5"><?php print htmlspecialchars($t_set->getAttributesForDisplay('set_intro'), ENT_QUOTES, 'UTF-8'); ?></textarea>
					</div>
					<a href="#" name="newSetSubmit" onclick="document.forms.editSetForm.submit(); return false;"><?php print _t("Save"); ?></a>
					<input type='hidden' name='set_id' value='<?php print $vn_set_id; ?>'/>
				</form>
				<a href='#' id='editSetButton' onclick='$("#editForm").slideUp(250); $("#editSetButton").slideDown(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div><!-- end editForm -->
<?php
		}
	}
?>

		<h2><?php print _t("Your Lightboxes"); ?></h2>
<?php
	foreach($va_sets as $va_set) {
		if($va_set['set_id'] == $vn_set_id){
			print "<div class='setsListCurrent'>&rsaquo; ".$va_set['name']."</div>\n";
		}else{
			print "<div class='setsList'>&rsaquo; ".caNavLink($this->request, $va_set['name'], '', '', 'Sets', 'index', array('set_id' => $va_set['set_id']))."</div>\n";
		}
	}
?>
		
		<h2><?php print _t("Options"); ?></h2>
<?php
	if (($vn_set_id) && (is_array($va_items) && (sizeof($va_items) > 0))) {
		print "<div class='optionsList'>&rsaquo; <a href='#' onclick='caSetsSlideshowPanel.showPanel(\"".caNavUrl($this->request, '', 'Sets', 'SlideShow', array('set_id' => $vn_set_id))."\"); return false;' >"._t("View slideshow")."</a></div>";
	}
?>
		<div class="optionsList">&rsaquo; <a href='#' id='shareSetButton' onclick='$("#newForm").slideUp(1); $("#helpTips").slideUp(1); $("#shareForm").slideDown(250); return false;'><?php print _t("Share this lightbox"); ?></a></div>
		<div class="optionsList">&rsaquo; <a href='#' id='newSetButton' onclick='$("#shareForm").slideUp(1); $("#helpTips").slideUp(1); $("#newForm").slideDown(250); return false;'><?php print _t("Make a new lightbox"); ?></a></div>
<?php
	if (($vn_set_id) && (is_array($va_items) && (sizeof($va_items) > 0))) {
		print "<div class='optionsList'>&rsaquo; ".caNavLink($this->request, _t("Download lightbox as PDF"), '', '', 'Sets', 'export', array('set_id' => $vn_set_id, 'output_type' => '_pdf', 'download' => 1))."</div>";
	}
?>
		<div class="optionsList">&rsaquo; <a href='#' id='helpTipsButton' onclick='$("#shareForm").slideUp(1); $("#newForm").slideUp(1); $("#helpTips").slideDown(250); return false;'><?php print _t("View help tips"); ?></a></div>			
			<div id="newForm" <?php print (sizeof($va_errors_new_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("Make a new lightbox"); ?></h2>
					<form action="<?php print caNavUrl($this->request, 'Sets', 'addNewSet', ''); ?>" method="post" id="newSetForm">
<?php
						if($va_errors_new_set["name"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors_new_set["name"]."</div>";
						}
?>
						<div class="formLabel"><?php print _t("Title"); ?><br/>
							<input type="text" name="name">
						</div>
						<div class="formLabel"><?php print _t("Display Option"); ?><br/>
							<select name="access" id="access">
								<option value="0"><?php print _t("Private"); ?></option>
								<option value="1"><?php print _t("Public"); ?></option>
							</select>
						</div>
						<div class="formLabel"><?php print _t("Description"); ?><br/>
							<textarea name="description" rows="5"></textarea>
						</div>
						<a href="#" name="newSetSubmit" onclick="document.forms.newSetForm.submit(); return false;"><?php print _t("Save"); ?></a>
					</form>
				<a href='#' id='editSetButton' onclick='$("#newForm").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div>
			<div id="shareForm" <?php print (sizeof($va_errors_share_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("Share this lightbox"); ?></h2>
<?php
				if($t_set->get("access") == 0){
					print "<div class='formErrors' style='text-align: left;'>"._t("To email a link to this lightbox you must first edit the lightbox and make the display option Public")."</div>";
				}else{
?>
					<form action="<?php print caNavUrl($this->request, 'Sets', 'shareSet', ''); ?>" method="post" id="shareSetForm">
						<div class="formLabel">
<?php
						if($va_errors_share_set["to_email"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors_share_set["to_email"]."</div>";
						}
?>
						<?php print _t("To e-mail address")."<br/><span class='formLabelNote'>"._t("(Enter multiple addresses separated by commas)"); ?></span><br/>
							<input type="text" name="to_email" value="<?php print $vs_to_email; ?>">
						</div>
						<div class="formLabel">
<?php
						if($va_errors_share_set["from_email"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors_share_set["from_email"]."</div>";
						}
?>
						<?php print _t("Your e-mail address"); ?><br/>
							<input type="text" name="from_email" value="<?php print $vs_from_email; ?>">
						</div>
						<div class="formLabel">
<?php
						if($va_errors_share_set["from_name"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors_share_set["from_name"]."</div>";
						}
?>
						<?php print _t("Your name"); ?><br/>
							<input type="text" name="from_name" value="<?php print $vs_from_name; ?>">
						</div>
						<div class="formLabel">
<?php
						if($va_errors_share_set["subject"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors_share_set["subject"]."</div>";
						}
?>
						<?php print _t("Subject"); ?><br/>
							<input type="text" name="subject" value="<?php print $vs_subject; ?>">
						</div>
						<div class="formLabel"><?php print _t("Message"); ?><br/>
							<textarea name="email_message" rows="5"><?php print $vs_message; ?></textarea>
						</div>
						<a href="#" name="shareSetSubmit" onclick="document.forms.shareSetForm.submit(); return false;"><?php print _t("Send"); ?></a>
						<input type='hidden' name='set_id' value='<?php print $vn_set_id; ?>'/>
					</form>
				<a href='#' id='editSetButton' onclick='$("#shareForm").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
<?php
				}
?>
			</div>
			<div id="helpTips" style="display:none;">
<?php
			print "<h2>"._t("Help Tips")."</h2>";
?>
				<ul>
					<li><strong><?php print _t("How do I add content to my lightbox?"); ?></strong>
						<div>
							<?php print _t("You can add images and video to your lightbox while you are browsing the website.  You'll find <em>Add to Lightbox</em> links beneath images and video throughout the site."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("Can I have more than one lightbox?"); ?></strong>
						<div>
							<?php print _t("Yes.  Click the <em>Make a new lightbox</em> link above to create a new lightbox."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("How do I change between lightboxes?"); ?></strong>
						<div>
							<?php print _t("Click on the name of the lightbox you want to work with in the <em>YOUR LIGHTBOXES</em> list."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("How can I change the name of my lightbox?"); ?></strong>
						<div>
							<?php print _t("Click the <em>EDIT</em> link in the <em>CURRENT LIGHTBOX</em> box above.  A form will slide open allowing you to change the name, display options and description of the lightbox you are currently working with."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("Can I change the order of the content in my lightbox's slide show?"); ?></strong>
						<div>
							<?php print _t("Yes.  You can organize the content in your lightboxes by dragging and dropping them into your preferred order.  Your changes are automatically saved once you drop the content into place."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("Can I share my lightbox with others?"); ?></strong>
						<div>
							<?php print _t("Yes.  When you set the display option of your lightbox to <em>Public</em>, your lightbox's slideshow becomes publicly accessible.  You can share the link to your slideshow with friends, students and colleagues."); ?>
						</div>
					</li>
				</ul>
				<a href='#' id='editSetButton' onclick='$("#helpTips").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div>

	</div><!-- end boxBg --></div><!-- end divRightCol -->
	<div id="leftCol">
<?php
		if (!sizeof($va_sets)) {
			// no sets for this user
?>
					<div class="error">
<?php
						print _t('There are no lightboxes to edit. Create a lightbox to start.');
?>
					</div>
<?php		
		} else {
			if (!$vn_set_id) {
				// no set selected for editing
?>
					<div class="error">
<?php
						print _t('Choose a lightbox to begin editing.');
?>
					</div>
<?php			
			} else {
				if (!is_array($va_items) || (!sizeof($va_items) > 0)) {
					// set we're editing is empty
?>
					<div class="error">
<?php
						print _t('There are no items in this lightbox.');
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

			foreach($va_items as $vn_item_id => $va_item) {
				$vs_title = "";
				$va_title = array();
?>
				<li class='setItem' id='setItem<?php print $vn_item_id; ?>'>
					<div id='setItemContainer<?php print $vn_item_id; ?>' class='imagecontainer'>
						<div class='remove'><a href='#' class='setDeleteButton' id='setItemDelete<?php print $vn_item_id; ?>'>X</a></div>
						<div class='setItemThumbnail'>
<?php
						if ($va_item['representation_tag_thumbnail']) {
							print caNavLink($this->request, $va_item['representation_tag_thumbnail'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']));
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
						<div id='caption<?php print $vn_item_id; ?>' class='setItemCaption'><?php print caNavLink($this->request, $vs_title, '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id'])); ?></div>
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

	<div id="caSetsSlideshowPanel"> 
		<div id="close"><a href="#" onclick="caSetsSlideshowPanel.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>
		<div id="caSetsSlideshowPanelContentArea">
		
		</div>
	</div>
	<script type="text/javascript">
	/*
		Set up the "caSetsSlideshowPanel" panel that will be triggered by links in sets interface
		Note that the actual <div>'s implementing the panel are located here in views/Sets/sets_html.php
	*/
	var caSetsSlideshowPanel;
	jQuery(document).ready(function() {
		if (caUI.initPanel) {
			caSetsSlideshowPanel = caUI.initPanel({ 
				panelID: 'caSetsSlideshowPanel',										/* DOM ID of the <div> enclosing the panel */
				panelContentID: 'caSetsSlideshowPanelContentArea',		/* DOM ID of the content area <div> in the panel */
				exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
				exposeBackgroundOpacity: 0.8,							/* opacity of background color masking out page content; 1.0 is opaque */
				panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport',
				closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
			});
		}
	});
	</script>