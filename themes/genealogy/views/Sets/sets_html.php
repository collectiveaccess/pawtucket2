<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Sets/sets_html.php : 
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
 
	global $g_ui_locale;
	
	$t_set 				= $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$t_new_set 			= $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$vn_set_id 			= $t_set->getPrimaryKey();			// primary key of set we're currently editing
	$va_items 			= $this->getVar('items');			// array of items in the set we're currently editing
	
	$va_sets 			= $this->getVar('set_list');		// list of existing sets this user has access to
	
	$va_errors 			= $this->getvar("errors");
	$va_errors_edit_set = $this->getVar("errors_edit_set");
	$va_errors_new_set 	= $this->getVar("errors_new_set");
	
	$o_client_services_config = $this->getVar('client_services_config');
	
 	$va_messages_by_transaction = $this->getVar('messages');
?>
<h1><?php print _t("Lightbox"); ?></h1>
<div id="setItemEditor">
<?php
	//
	// Right column (info display and edit forms)
	//
?>
	<div id="rightCol">
<?php
	//
	// Action buttons (create new set)
	//
	print "<div class='optionsList'><a href='#' id='newSetButton' onclick='caShowCollectionForm(\"new\"); return false;'>"._t("Start a new lightbox")." &rsaquo;</a></div>";
?>
		<div id="currentSetContainer">
<?php
		if ($vn_set_id) {
?>
			<div class="boxBg">
			<h2><?php print _t("Now Viewing"); ?></h2>
<?php
			# --- current set info and form to edit
			if($vn_set_id){
				print "<div class='setInfo'>";
				print "<strong>".$this->getVar("set_name")."</strong>";
				print "<div class='edit'><a href='#' id='editSetButton' onclick='jQuery(\"#editSetButton\").slideUp(1); jQuery(\"#editForm\").slideDown(250); return false;'>"._t("Edit")." &rsaquo;</a></div>";
				print "</div>";
?>					
				<div id="editForm" <?php print (sizeof($va_errors_edit_set) > 0) ? "" : "style='display:none;'"; ?>>
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
						<div class="formLabel"><?php print _t("Notes"); ?></div>
						<textarea name="description" rows="5"><?php print htmlspecialchars($t_set->get('ca_sets.set_description'), ENT_QUOTES, 'UTF-8'); ?></textarea>

						<a href="#" name="newSetSubmit" onclick="jQuery('#editSetForm').submit(); return false;"><?php print _t("Save"); ?></a>
						<input type='hidden' name='set_id' value='<?php print $vn_set_id; ?>'/>
					</form>
					<a href='#' onclick='jQuery("#editForm").slideUp(250); jQuery("#editSetButton").slideDown(250); return false;' class='hide'><?php print _t("Cancel"); ?> &rsaquo;</a>
				</div><!-- end editForm -->
<?php
			}
?>
			</div>
<?php
		}

		//
		// Client communication form
		//
		if ((bool)$o_client_services_config->get('enable_user_communication')) {
			//
			// Start a conversation, or reply to an existing one
			//
?>
		<div id="caClientCommunicationsContainer" >
<?php
			if(sizeof($va_messages_by_transaction)){
				print "<div class='reply'><a href='#' onclick='jQuery(\"#newFormContainer\").slideUp(0); jQuery(\".reply\").hide(); jQuery(\"#caClientCommunications\").slideDown(250); return false;'>"._t("Reply")."  &rsaquo;</a></div>";
?>
			<h2><?php print _t("Inbox"); ?></h2>
<?php
			}else{
?>
			<h2 style="display:none;" id="inquiryTitle"><?php print _t("Inquiry"); ?></h2>
<?php	
			}

?>
			<div id="caClientCommunications" style="display:none;">
<?php
				print caFormTag($this->request, 'SendReply', 'caClientCommunicationsReplyForm', null, 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
				$t_comm = new ca_commerce_communications();
				
				// Get subject line from last message to use as default for replies
				if (is_array($va_last_transaction = $va_messages_by_transaction[array_pop(array_keys($va_messages_by_transaction))])) {
					$va_last_message = $va_last_transaction[array_pop(array_keys($va_last_transaction))];
				} else {
					$va_last_message = array('subject' => _t('New inquiry'));
				}
				
				$vs_subject = isset($va_last_message['subject']) ? $va_last_message['subject'] : '';
				if (sizeof($va_messages_by_transaction) && (!preg_match('!'._t("Re:").'!i', $vs_subject))) {
					$vs_subject = _t("Re:").' '.$vs_subject;
				}
				
				$t_comm->set('subject', $vs_subject);
				#print "<div class='formLabel'>"._t('Date:').' '.caGetLocalizedDateRange($t=time(), $t, array('dateFormat' => 'delimited'))."</div>";
				#print "<div class='formLabel'>"._t('To:')." ".$this->request->config->get('app_display_name')."</div>";
				
				foreach($t_comm->getFormFields() as $vs_f => $va_info) {
					switch($vs_f) {
						case 'subject':
						case 'message':
						case 'transaction_id':
							print $t_comm->htmlFormElement($vs_f, "<div class='formLabel'>^LABEL<br/>^ELEMENT</div>")."\n";
							break;
					}
				}
				
				print caHTMLHiddenInput('set_id', array('value' => $t_set->getPrimaryKey()));
				
				print "<a href='#' onclick='jQuery(\"#caClientCommunicationsReplyForm\").submit(); return false;' class='save'>"._t("Send")."</a>";
?>
				<a href='#' id='editSetButton' onclick='jQuery("#caClientCommunications").slideUp(200); <?php print (!sizeof($va_messages_by_transaction)) ? "jQuery(\"#inquiryTitle\").hide(); jQuery(\"#inquiry\").show(); " : " jQuery(\".reply\").show(); "; ?>return false;' class='hide'><?php print _t("Cancel"); ?> &rsaquo;</a>
				</form>
			</div>
<?php
			if(sizeof($va_messages_by_transaction)){
?>
 			<div id="caClientCommunicationsMessageList">
<?php
				//
				// List of messages
				//
				foreach($va_messages_by_transaction as $vn_tranaction_id => $va_messages) {
					$va_message = array_pop($va_messages);
					$va_messages = array_reverse($va_messages);
					print caClientServicesFormatMessageSummaryPawtucket($this->request, $va_message, array('viewContentDivID' => 'caClientCommunicationsMessageDisplay', 'additionalMessages' => $va_messages));
				}
?> 	
 			</div>
<?php
			}
?>
 		</div>	
<?php
		}
?>
	</div>
	<div id="newSetContainer" class="boxBg" <?php print (sizeof($va_errors_new_set) > 0) ? "" : "style='display:none;'"; ?>>
<?php
		//
		// New set form
		//	
?>
		<div id="newFormContainer">
			<h2><?php print _t("Your new lightbox"); ?></h2>
				<form action="<?php print caNavUrl($this->request, 'Sets', 'addNewSet', ''); ?>" method="post" id="newSetForm">
<?php
					if($va_errors_new_set["name"]){
						print "<div class='formErrors' style='text-align: left;'>".$va_errors_new_set["name"]."</div>";
					}
?>
					<div class="formLabel"><?php print _t("Title"); ?></div>
					<input type="text" name="name">
					<div class="formLabel"><?php print _t("Notes"); ?></div>
					<textarea name="description" rows="5"></textarea>
					<a href="#" name="newSetSubmit" onclick="jQuery('#newSetForm').submit(); return false;"><?php print _t("Save"); ?></a>
				</form>
			<a href='#' id='editSetButton' onclick='caShowCollectionForm("current"); return false;' class='hide'><?php print _t("Cancel"); ?> &rsaquo;</a>
		</div>
	</div>
<?php
?>
	</div><!-- end div rightCol -->
<?php
	//
	// Left column (display of set items)
	//
?>
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
	<div id="setItems" class="setItems">
		<ul id="setItemList" class="setItemList">
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
							if (mb_strlen($va_item['name']) > 70) {
								$va_title[] = '<em>'.mb_substr($va_item['name'], 0, 67).'...</em>';
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
		function caShowCollectionForm(mode, delay) {
			if (delay == undefined) { delay = 200; }
			if (mode == 'new') {
				jQuery("#currentSetContainer").slideUp(delay); jQuery("#newSetContainer").slideDown(delay);
			} else {
				jQuery("#currentSetContainer").slideDown(delay); jQuery("#newSetContainer").slideUp(delay);
			}
		}
		
		function showHideCommunicationAttachedMedia() {
			jQuery('#caClientCommunicationsAttachedMedia').slideToggle(250, function() {
				if(jQuery('#caClientCommunicationsAttachedMedia').css("display") == 'none') {
					jQuery('#caClientCommunicationsAttachedMediaControl').html("Show attached media &rsaquo;");
				} else {
					jQuery('#caClientCommunicationsAttachedMediaControl').html("Hide attached media &rsaquo;");
				}
			});
		}
		
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

<?php
	if (sizeof($va_errors_new_set) > 0) {
?>
		jQuery(document).ready(function() {
			caShowCollectionForm('new', 0);
		});
<?php
	}
?>
	</script>
</div><!-- end setItemEditor -->


<div id="caClientCommunicationsViewerPanel"> 
	<div id="close"><a href="#" onclick="caClientCommunicationsViewerPanelRef.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>
	<div id="caClientCommunicationsViewerPanelContentArea">
	 
	</div>
</div>
<script type="text/javascript">
/*
	Set up the "caClientCommunicationsViewerPanel" panel that will be triggered by links in communication list
*/
var caClientCommunicationsViewerPanelRef;
jQuery(document).ready(function() {
	if (caUI.initPanel) {
		caClientCommunicationsViewerPanelRef = caUI.initPanel({ 
			panelID: 'caClientCommunicationsViewerPanel',						/* DOM ID of the <div> enclosing the panel */
			panelContentID: 'caClientCommunicationsViewerPanelContentArea',		/* DOM ID of the content area <div> in the panel */
			exposeBackgroundColor: '#000000',					/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
			exposeBackgroundOpacity: 0.5,						/* opacity of background color masking out page content; 1.0 is opaque */
			panelTransitionSpeed: 400, 							/* time it takes the panel to fade in/out in milliseconds */
			allowMobileSafariZooming: true,
			mobileSafariViewportTagID: '_msafari_viewport',
			closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
		});
	}
	
	jQuery('.caClientCommunicationsAdditionalMessageSummary, .caClientCommunicationsMessageSummaryContainer').click(function() {
		var id = jQuery(this).attr('id');
		var bits = id.split(/_/);
		caClientCommunicationsViewerPanelRef.showPanel("<?php print caNavUrl($this->request, '', 'Sets', 'ViewMessage'); ?>/communication_id/" + bits[1]);
	});
	
	jQuery('.caClientCommunicationsMessageSummaryCounter').click(function() {	// prevent bubbling when clicking counter
		return false;
	});
});
</script>