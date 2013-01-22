<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Bookmarks/bookmarks_html.php : 
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
	
	$t_folder 			= $this->getVar('t_folder');		// object for ca_bookmark_folders record of folder we're currently editing
	$t_new_folder 		= $this->getVar('t_folder');			// object for ca_bookamrk_folders record of folder we're currently editing
	$vn_folder_id 		= $t_folder->getPrimaryKey();		// primary key of folder we're currently editing
	$va_items 			= $this->getVar('items');			// array of items in the folder we're currently editing
	
	$va_folders 		= $this->getVar('folder_list');		// list of existing folders this user has access to
	
	$va_errors 			= $this->getvar("errors");
	$va_errors_edit_folder = $this->getVar("errors_edit_folder");
	$va_errors_new_folder 	= $this->getVar("errors_new_folder");
?>
<h1><?php print _t("Your Bookmarks"); ?></h1>
<div id="bookmarksEditor">
	<div id="rightCol">
<?php
	if ($vn_folder_id) {
?>
		<h2><?php print _t("Current Folder"); ?></h2>
<?php
		# --- current folder info and form to edit
		if($vn_folder_id){
			print "<div class='folderInfo'>";
			print "<div class='removeFolder'>".caNavLink($this->request, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '', '', 'Bookmarks', 'deleteFolder', array('folder_id' => $vn_folder_id))."</div>";
			print "<strong>".$this->getVar("folder_name")."</strong>";
			
			print "<div class='edit'><a href='#' id='editFolderButton' onclick='$(\"#editFolderButton\").slideUp(1); $(\"#editForm\").slideDown(250); return false;'>"._t("Edit Folder")." &rsaquo;</a></div>";
			print "</div>";
?>					
			<div id="editForm" <?php print (sizeof($va_errors_edit_set) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("Folder Information"); ?></h2>
<?php
				if($va_errors_edit_folder["edit_folder"]){
					print "<div class='formErrors'>".$va_errors_edit_folder["edit_folder"]."</div>";
				}
?>
				<form action="<?php print caNavUrl($this->request, 'Bookmarks', 'saveFolderInfo', ''); ?>" method="post" id="editFolderForm">
<?php
					if($va_errors_edit_folder["name"]){
						print "<div class='formErrors' style='text-align: left;'>".$va_errors_edit_folder["name"]."</div>";
					}
?>
					<div class="formLabel"><?php print _t("Folder Name"); ?></div>
					<input type="text" name="name" value="<?php print htmlspecialchars($t_folder->get("name"), ENT_QUOTES, 'UTF-8'); ?>">
					<br/><a href="#" name="newFolderSubmit" onclick="document.forms.editFolderForm.submit(); return false;"><?php print _t("Save"); ?></a>
					<input type='hidden' name='folder_id' value='<?php print $vn_folder_id; ?>'/>
				</form>
				<a href='#' id='editFolderButton' onclick='$("#editForm").slideUp(250); $("#editFolderButton").slideDown(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div><!-- end editForm -->
<?php
		}
	}
	if(is_array($va_folders) && sizeof($va_folders)){
?>
		<h2><?php print _t("Your Folders"); ?></h2>
<?php
	}
	foreach($va_folders as $va_folder) {
		if($va_folder['folder_id'] == $vn_folder_id){
			print "<div class='foldersListCurrent'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".$va_folder['name']."</div>\n";
		}else{
			print "<div class='foldersList'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, $va_folder['name'], '', '', 'Bookmarks', 'index', array('folder_id' => $va_folder['folder_id']))."</div>\n";
		}
	}
?>		
		<h2><?php print _t("Options"); ?></h2>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <a href='#' id='newFolderButton' onclick=' $("#helpTips").slideUp(1); $("#newForm").slideDown(250);return false;'><?php print _t("Make a new bookmarks folder"); ?></a></div>
		<div class="optionsList"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"> <a href='#' id='helpTipsButton' onclick='$("#newForm").slideUp(1); $("#helpTips").slideDown(250); return false;'><?php print _t("View help tips"); ?></a></div>			
			<div id="newForm" <?php print (sizeof($va_errors_new_folder) > 0) ? "" : "style='display:none;'"; ?>>
				<h2><?php print _t("New bookmarks folder"); ?></h2>
					<form action="<?php print caNavUrl($this->request, 'Bookmarks', 'addNewFolder', ''); ?>" method="post" id="newFolderForm">
<?php
						if($va_errors_new_folder["name"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors_new_folder["name"]."</div>";
						}
?>
						<div class="formLabel"><?php print _t("Folder Name"); ?></div>
						<input type="text" name="name">
						<br/><a href="#" name="newFolderSubmit" onclick="document.forms.newFolderForm.submit(); return false;"><?php print _t("Save"); ?></a>
					</form>
				<a href='#' id='editFolderButton' onclick='$("#newForm").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div>
			<div id="helpTips" style="display:none;">
<?php
			print "<h2>"._t("Help Tips")."</h2>";
?>
				<ul>
					<li><strong><?php print _t("How do I bookmark items?"); ?></strong>
						<div>
							<?php print _t("You can bookmark items while you are browsing the website.  You'll find <em>Bookmark Item</em> links on detail pages throughout the site."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("Can I organize my bookmarks within multiple folders?"); ?></strong>
						<div>
							<?php print _t("Yes.  Click the <em>Make a new bookmarks folder</em> link above to create a new folder."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("How do I change between folders?"); ?></strong>
						<div>
							<?php print _t("Click on the name of the folder you want to work with in the <em>YOUR FOLDERS</em> list."); ?>
						</div>
					</li>
				</ul>
				<ul>
					<li><strong><?php print _t("How can I change the name of my bookmarks folder?"); ?></strong>
						<div>
							<?php print _t("Click the <em>EDIT</em> link in the <em>CURRENT FOLDER</em> area above.  A form will slide open allowing you to change the name of the folder you are currently working with."); ?>
						</div>
					</li>
				</ul>
				<a href='#' id='hideHelpTipsButton' onclick='$("#helpTips").slideUp(250); return false;' class='hide'><?php print _t("Hide"); ?> &rsaquo;</a>
			</div>

	</div><!-- end divRightCol -->
	<div id="leftCol">
<?php
		if (!sizeof($va_folders)) {
			// no folders for this user
?>
					<div class="error">
<?php
						print _t('There are no bookmark folders to edit. Create a folder to begin.');
?>
					</div>
<?php		
		} else {
			if (!$vn_folder_id) {
				// no folder selected for editing
?>
					<div class="error">
<?php
						print _t('Choose a folder to begin editing.');
?>
					</div>
<?php			
			} else {
				if (!is_array($va_items) || (!sizeof($va_items) > 0)) {
					// folder we're editing is empty
?>
					<div class="error">
<?php
						print _t('There are no bookmarks in this folder.');
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
	<div id="bookmarksList">
<?php
		if (is_array($va_items) && (sizeof($va_items) > 0)) {
			$ibg = 1;
			foreach($va_items as $vn_item_id => $va_item) {
				$ps_bg_class = "";
				if($ibg == 1){
					$ps_bg_class = "bookmarkBg";
					$ibg = 0;
				}else{
					$ibg++;
				}
				print "<div class='bookmark ".$ps_bg_class."'>&rsaquo; ";
				print caNavLink($this->request, "&nbsp;", 'removeBookmark', '', 'Bookmarks', 'DeleteItem', array("bookmark_id" => $vn_item_id));
				print caNavLink($this->request, $va_item['label'], '', 'Detail', $va_item['controller'], 'Show', array($va_item['primary_key'] => $va_item['row_id']));
				print "</div>";
?>

<?php	

			}
		}
?>
	</div><!-- end bookmarksList -->
</div><!-- leftCol -->
</div><!-- end bookmarksEditor -->