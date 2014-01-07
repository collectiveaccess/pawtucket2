<?php
/* ----------------------------------------------------------------------
 * controllers/SetsController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_LIB_DIR__."/core/Datamodel.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_users.php");
 
 	class SetsController extends ActionController {
 		# -------------------------------------------------------
 		 protected $opa_access_values;
 		 protected $opa_user_groups;
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->opa_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar("access_values", $this->opa_access_values);
 			$t_user_groups = new ca_user_groups();
 			$this->opa_user_groups = $t_user_groups->getGroupList("name", "desc", $this->request->getUserID());
 			$this->view->setVar("user_groups", $this->opa_user_groups);
 		}
 		# -------------------------------------------------------
 		function Index() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$t_sets = new ca_sets();
 			$va_read_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "access" => 1));
 			$va_write_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "access" => 2));
 			# --- remove write sets from the read array
 			$va_read_sets = array_diff_key($va_read_sets, $va_write_sets);
 			$this->view->setVar("read_sets", $va_read_sets);
 			$this->view->setVar("write_sets", $va_write_sets);
 			$va_set_ids = array_merge(array_keys($va_read_sets), array_keys($va_write_sets));
 			$va_set_change_log = $t_sets->getSetChangeLog($va_set_ids);
 			$this->view->setVar("activity", $va_set_change_log);
 			$this->render("Sets/set_list_html.php");
 		}
 		# ------------------------------------------------------
 		function setDetail() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $this->request->getUserID(), "thumbnailVersions" => array("preview"), "checkAccess" => $this->opa_access_values)));
			$this->view->setVar("set", $t_set);
			$this->view->setVar("set_items", $va_set_items);
			$va_comments = $t_set->getComments();
 			$this->view->setVar("comments", $va_comments);
			$this->render("Sets/set_detail_thumbnail_html.php");
 		}
 		# ------------------------------------------------------
 		function setForm() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			# --- if set exists, we're being redirected here after attempting a save
 			if (!$t_set){
 				# --- set_id is passed, so we're editing a set
 				if($this->request->getParameter('set_id', pInteger)){
					$t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__);
					# --- pass name and description to populate form
					$this->view->setVar("name", $t_set->getLabelForDisplay());
					$this->view->setVar("description", $t_set->get("description"));
				}else{
					$t_set = new ca_sets();
				}
 			}
 			$this->view->setVar("set", $t_set);
 			$this->render("Sets/form_set_info_html.php");
 		}
 		# ------------------------------------------------------
 		function saveSetInfo() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			$o_purifier = new HTMLPurifier();
 			
 			# --- set_id is passed through form, otherwise we're saving a new set
 			if($this->request->getParameter('set_id', pInteger)){
 				$t_set = $this->_getSet(__CA_EDIT_READ_ACCESS__);
 			}else{
 				$t_set = new ca_sets();
 			}
 			# --- check for errors
 			# --- set name - required
 			$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
 			if(!$ps_name){
 				$va_errors["name"] = _t("Please enter the name of your lightbox");
 			}else{
 				$this->view->setVar("name", $ps_name);
 			}
 			# --- set description - optional
 			$ps_description =  $o_purifier->purify($this->request->getParameter('description', pString));
 			$this->view->setVar("description", $ps_description);

 			$t_list = new ca_lists();
 			$vn_set_type_user = $t_list->getItemIDFromList('set_types', $this->request->config->get('user_set_type'));
 			$t_object = new ca_objects();
 			$vn_object_table_num = $t_object->tableNum();
 			if(sizeof($va_errors) == 0){
				$t_set->setMode(ACCESS_WRITE);
				$t_set->set('access', $this->request->getParameter('access', pInteger));
				if($t_set->get("set_id")){
					# --- edit/add description
					$t_set->replaceAttribute(array('description' => $ps_description, 'locale_id' => $g_ui_locale_id), 'description');
					$t_set->update();
				}else{
					$t_set->set('table_num', $vn_object_table_num);
					$t_set->set('type_id', $vn_set_type_user);
					$t_set->set('user_id', $this->request->getUserID());
					$t_set->set('set_code', $this->request->getUserID().'_'.time());
					# --- create new attribute
					$t_set->addAttribute(array('description' => $ps_description, 'locale_id' => $g_ui_locale_id), 'description');
					$t_set->insert();
				}
				if($t_set->numErrors()) {
					$va_errors["general"] = join("; ", $t_set->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->setForm();
				}else{
					# --- save name
					if (sizeof($va_labels = caExtractValuesByUserLocale($t_set->getLabels(array($g_ui_locale_id), __CA_LABEL_TYPE_PREFERRED__)))) {
						# --- edit label	
						foreach($va_labels as $vn_set_id => $va_label) {
							$t_set->editLabel($va_label[0]['label_id'], array('name' => $ps_name), $g_ui_locale_id);
						}
					} else {
						# --- add new label
						$t_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					}
					
					# --- select the current set
					$this->request->user->setVar('current_set_id', $t_set->get("set_id"));
					
					$this->view->setVar("message", _t('Saved lightbox.'));
 					$this->render("Form/reload_html.php");
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->setForm();
			} 			
 		}
 		# ------------------------------------------------------
 		function shareSetForm() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$this->render("Sets/form_share_set_html.php");
 		}
 		# ------------------------------------------------------
 		function saveShareSet() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__);
 			$o_purifier = new HTMLPurifier();$ps_user = $o_purifier->purify($this->request->getParameter('user', pString));
 			$pn_group_id = $this->request->getParameter('group_id', pInteger);
 			if(!$pn_group_id && !$ps_user){
 				$va_errors["general"] = _t("Please select a user or group");
 			}
 			$pn_access = $this->request->getParameter('access', pInteger);
 			if(!$pn_access){
 				$va_errors["access"] = _t("Please select an access level");
 			}
 			if(sizeof($va_errors) == 0){
				if($pn_group_id){
					$t_sets_x_user_groups = new ca_sets_x_user_groups();
					if($t_sets_x_user_groups->load(array("set_id" => $t_set->get("set_id"), "group_id" => $pn_group_id))){
						$this->view->setVar("message", _t('Group already has access to the lightbox'));
						$this->render("Form/reload_html.php");
					}else{
						$t_sets_x_user_groups->setMode(ACCESS_WRITE);
						$t_sets_x_user_groups->set('access',  $pn_access);
						$t_sets_x_user_groups->set('group_id',  $pn_group_id);
						$t_sets_x_user_groups->set('set_id',  $t_set->get("set_id"));
						$t_sets_x_user_groups->insert();
						if($t_sets_x_user_groups->numErrors()) {
							$va_errors["general"] = join("; ", $t_sets_x_user_groups->getErrors());
							$this->view->setVar('errors', $va_errors);
							$this->shareSetForm();
						}else{
							$this->view->setVar("message", _t('Shared lightbox'));
							$this->render("Form/reload_html.php");
						}
					}
				}else{
					# --- lookup the user
					$t_user = new ca_users(array("email" => $ps_user));
					if($vn_user_id = $t_user->get("user_id")){
						$t_sets_x_users = new ca_sets_x_users();
						if($t_sets_x_users->load(array("set_id" => $t_set->get("set_id"), "user_id" => $vn_user_id))){
							$this->view->setVar("message", _t('User already has access to the lightbox'));
							$this->render("Form/reload_html.php");
						}else{
							$t_sets_x_users->setMode(ACCESS_WRITE);
							$t_sets_x_users->set('access',  $pn_access);
							$t_sets_x_users->set('user_id',  $vn_user_id);
							$t_sets_x_users->set('set_id',  $t_set->get("set_id"));
							$t_sets_x_users->insert();
							if($t_sets_x_users->numErrors()) {
								$va_errors["general"] = join("; ", $t_sets_x_users->getErrors());
								$this->view->setVar('errors', $va_errors);
								$this->shareSetForm();
							}else{
								$this->view->setVar("message", _t('Shared lightbox'));
								$this->render("Form/reload_html.php");
							}
						}
					}else{
						$va_errors["user"] = _t("The email address you entered does not belong to a registered user");
						$this->view->setVar('errors', $va_errors);
						$this->shareSetForm();
					}
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->shareSetForm();
			} 		
 		}
 		# ------------------------------------------------------
 		function userGroupList() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$this->render("Sets/user_group_list_html.php");
 		}
 		# ------------------------------------------------------
 		function userGroupForm() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			if(!$t_user_group){
 				$t_user_group = new ca_user_groups();
 			}
 			$this->view->setVar("user_group",$t_user_group);
 			$this->render("Sets/form_user_group_html.php");
 		}
 		# ------------------------------------------------------
 		function saveUserGroup() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			$o_purifier = new HTMLPurifier();
 			
 			$t_user_group = new ca_user_groups();
 			if($pn_group_id = $this->request->getParameter('group_id', pInteger)){
 				$t_user_group->load($pn_group_id);
 			}
 			
 			# --- check for errors
 			# --- group name - required
 			$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
 			if(!$ps_name){
 				$va_errors["name"] = _t("Please enter the name of your user group");
 			}else{
 				$this->view->setVar("name", $ps_name);
 			}
 			# --- user group description - optional
 			$ps_description =  $o_purifier->purify($this->request->getParameter('description', pString));
 			$this->view->setVar("description", $ps_description);

 			if(sizeof($va_errors) == 0){
				$t_user_group->setMode(ACCESS_WRITE);
				$t_user_group->set('name',  $ps_name);
				$t_user_group->set('description',  $ps_description);
				if($t_user_group->get("group_id")){
					$t_user_group->update();
				}else{
					$t_user_group->set('user_id', $this->request->getUserID());
					$t_user_group->set('code', 'lb_'.$this->request->getUserID().'_'.time());
					$t_user_group->insert();
					if($t_user_group->get("group_id")){
						$t_user_group->addUsers($this->request->getUserID());
					}
				}
				if($t_user_group->numErrors()) {
					$va_errors["general"] = join("; ", $t_user_group->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->userGroupForm();
				}else{
					# --- add current user to group
					$this->view->setVar("message", _t('Saved user group.'));
 					$this->render("Form/reload_html.php");
				}
			}else{
				$this->view->setVar('errors', $va_errors);
				$this->userGroupForm();
			} 			
 		}
 		# ------------------------------------------------------
 		function AjaxListComments() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$o_datamodel = new Datamodel();
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			# --- check this is a valid table to have comments in the lightbox
 			if(!in_array($ps_tablename, array("ca_sets", "ca_set_items"))){ $this->Index();}
 			# --- load table
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$t_item = $o_datamodel->getTableInstance($ps_tablename);
 			$t_item->load($pn_item_id);
 			$va_comments = $t_item->getComments();
 			
 			$this->view->setVar("tablename", $ps_tablename);
 			$this->view->setVar("item_id", $pn_item_id);
 			$this->view->setVar("comments", $va_comments);
			$this->render("Sets/ajax_comments.php");
 		}
 		# ------------------------------------------------------
 		function AjaxSaveComment() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			# --- when close is set to true, will make the form view disappear after saving form
 			$vb_close = false;
 			$o_datamodel = new Datamodel();
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			# --- check this is a valid table to have comments in the lightbox
 			if(!in_array($ps_tablename, array("ca_sets", "ca_set_items"))){ $this->Index(); }
 			# --- load table
 			$t_item = $o_datamodel->getTableInstance($ps_tablename);
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$t_item->load($pn_item_id);
 			$ps_comment = $this->request->getParameter('comment', pString);
 			if(!$ps_comment){
 				$vs_error = _t("Please enter a comment");
 				$this->AjaxListComments();
 				return;
 			}else{
 				# --- pass user's id as moderator - all set comments should be made public, it's a private space and comments should not need to be moderated
 				if($t_item->addComment($ps_comment, null, $this->request->getUserID(), null, null, null, 1, $this->request->getUserID(), array("purify" => true))){
 					$vs_message = _t("Saved comment");
 					$vb_close = true;
 				}else{
 					$vs_error = _t("There were errors adding your comment: ".join("; ", $t_item->getErrors()));
 					$this->AjaxListComments();
 					return;
 				}
 			}
 			$this->view->setVar("tablename", $ps_tablename);
 			$this->view->setVar("item_id", $pn_item_id);
 			$this->view->setVar("message", $vs_message);
			$this->view->setVar("error", $vs_error);
			$this->view->setVar("close", $vb_close);
			$this->render("Sets/ajax_comments.php");
 		}
 		# ------------------------------------------------------
 		function saveComment() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			$o_datamodel = new Datamodel();
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			# --- check this is a valid table to have comments in the lightbox
 			if(!in_array($ps_tablename, array("ca_sets", "ca_set_items"))){ $this->Index(); }
 			# --- load table
 			$t_item = $o_datamodel->getTableInstance($ps_tablename);
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$t_item->load($pn_item_id);
 			$ps_comment = $this->request->getParameter('comment', pString);
 			if(!$ps_comment){
 					$this->notification->addNotification(_t("Please enter a comment"), __NOTIFICATION_TYPE_ERROR__);
 			}else{
 				# --- pass user's id as moderator - all set comments should be made public, it's a private space and comments should not need to be moderated
 				if($t_item->addComment($ps_comment, null, $this->request->getUserID(), null, null, null, 1, $this->request->getUserID(), array("purify" => true))){
 					$this->notification->addNotification(_t("Saved comment"), __NOTIFICATION_TYPE_INFO__);
 				}else{
 					$this->notification->addNotification(_t("There were errors saving your comment"), __NOTIFICATION_TYPE_ERROR__);
 				}
 			}
 			if($ps_tablename == "ca_sets"){
 				$this->setDetail();
 			}
 		}
 		# -------------------------------------------------------
 		public function DeleteSet() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			if ($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)) { 
 				$vs_set_name = $t_set->getLabelForDisplay();
 				$t_set->setMode(ACCESS_WRITE);
 				$t_set->delete();
 				
 				if($t_set->numErrors()) {
 					$this->notification->addNotification(_t("<em>%1</em> could not be deleted: %2", $vs_set_name, join("; ", $t_set->getErrors())), __NOTIFICATION_TYPE_ERROR__);
 				} else {
 					$this->notification->addNotification(_t("<em>%1</em> was deleted", $vs_set_name), __NOTIFICATION_TYPE_INFO__);
 				}
 			}
 			$this->Index();
 		}
 		# ------------------------------------------------------
 		public function AjaxReorderItems() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
			if($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
				
				$this->view->setVar("set_id", $t_set->get("set_id"));
				
				$va_row_ids = array();
				$va_row_ids_raw = explode('&', $this->request->getParameter('row_ids', pString));
				foreach($va_row_ids_raw as $vn_row_id_raw){
					$va_row_ids[] = str_replace('row[]=', '', $vn_row_id_raw);
				}
				$va_errors = $t_set->reorderItems($va_row_ids);
			}else{
				$va_errors[] = _t("lightbox is not defined or you don't have access to the lightbox");
			}
			$this->view->setVar('errors', $va_errors);
			$this->render('Sets/ajax_reorder_items_json.php');
 		}
 		# -------------------------------------------------------
 		public function AjaxDeleteItem() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
			if($t_set = $this->_getSet(__CA_SET_EDIT_ACCESS__)){
				
				$pn_item_id = $this->request->getParameter('item_id', pInteger);
				if ($t_set->removeItemByItemID($pn_item_id, $this->request->getUserID())) {
					$va_errors = array();
				} else {
					$va_errors[] = _t('Could not remove item from lightbox');
				}
				$this->view->setVar('set_id', $pn_set_id);
				$this->view->setVar('item_id', $pn_item_id);
			} else {
				$va_errors['general'] = _t('You do not have access to the lightbox');	
			}
 			
 			$this->view->setVar('errors', $va_errors);
 			$this->render('Sets/ajax_delete_item_json.php');
 		}
 		# -------------------------------------------------------
 		public function AjaxAddItem() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			$o_purifier = new HTMLPurifier();
 			
 			# --- set_id is passed through form, otherwise we're saving a new set, and adding the item to it
 			if($this->request->getParameter('set_id', pInteger)){
 				$t_set = $this->_getSet(__CA_EDIT_READ_ACCESS__);
 				if(!$t_set && $t_set = $this->_getSet(__CA_SET_READ_ACCESS__)){
 					$va_errors["general"] = _t("You can not add items to this lightbox.  You have read only access.");
 					$this->view->setVar('errors', $va_errors);
 					$this->addItemForm();
 					return;
 				}
 			}else{
 				$t_set = new ca_sets();
				# --- set name - if not sent, make a decent default
				$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
				if(!$ps_name){
					$ps_name = _t("Your lightbox");
				}
				# --- set description - optional
				$ps_description =  $o_purifier->purify($this->request->getParameter('description', pString));
	
				$t_list = new ca_lists();
				$vn_set_type_user = $t_list->getItemIDFromList('set_types', $this->request->config->get('user_set_type'));
				$t_object = new ca_objects();
				$vn_object_table_num = $t_object->tableNum();
				$t_set->setMode(ACCESS_WRITE);
				$t_set->set('access', $this->request->getParameter('access', pInteger));
				$t_set->set('table_num', $vn_object_table_num);
				$t_set->set('type_id', $vn_set_type_user);
				$t_set->set('user_id', $this->request->getUserID());
				$t_set->set('set_code', $this->request->getUserID().'_'.time());
				# --- create new attribute
				if($ps_description){
					$t_set->addAttribute(array('description' => $ps_description, 'locale_id' => $g_ui_locale_id), 'description');
				}
				$t_set->insert();
				if($t_set->numErrors()) {
					$va_errors["general"] = join("; ", $t_set->getErrors());
					$this->view->setVar('errors', $va_errors);
					$this->addItemForm();
					return;
				}else{
					# --- save name - add new label
					$t_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					# --- select the current set
					$this->request->user->setVar('current_set_id', $t_set->get("set_id"));

				}			
			}
			if($t_set){
				$pn_item_id = null;
				$pn_object_id = $this->request->getParameter('object_id', pInteger);
				if($pn_object_id){
					if(!$t_set->isInSet("ca_objects", $pn_object_id, $t_set->get("set_id"))){
						if ($pn_item_id = $t_set->addItem($pn_object_id, array(), $this->request->getUserID())) {
							//
							// Select primary representation
							//
							$t_object = new ca_objects($pn_object_id);
							$vn_rep_id = $t_object->getPrimaryRepresentationID();	// get representation_id for primary
							
							$t_item = new ca_set_items($pn_item_id);
							$t_item->addSelectedRepresentation($vn_rep_id);			// flag as selected in item vars
							$t_item->update();
							
							$va_errors = array();
							$this->view->setVar('message', _t("Successfully added item."));
							$this->render("Form/reload_html.php");
						} else {
							$va_errors["message"] = _t('Could not add item to lightbox');
							$this->render("Form/reload_html.php");
						}
					}else{
						$this->view->setVar('message', _t("Item already in lightbox."));
						$this->render("Form/reload_html.php");
					}				
				}else{
					$this->view->setVar('message', _t("Object ID is not defined"));
					$this->render("Form/reload_html.php");
				}
			}
 		}
 		# -------------------------------------------------------
 		public function addItemForm(){
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			$this->view->setvar("set", new ca_Sets());
 			$this->view->setvar("object_id", $this->request->getParameter('object_id', pInteger));
 			if($this->request->getParameter('object_id', pInteger)){
 				$this->render("Sets/form_add_set_item_html.php");
 			}else{
 				$this->view->setVar('message', _t("Object ID is not defined"));
				$this->render("Form/reload_html.php");
 			}
 		}
 		# ----------------------------------------------------------
		# --- Export --- Generate  export file of current set items
		# ----------------------------------------------------------
		public function export() {
			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'loginForm')); return; }
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { 
 				$this->notification->addNotification(_t("You must select a set to export"), __NOTIFICATION_TYPE_INFO__);
				$this->Index();
 			}
 			set_time_limit(7200);
 			$ps_output_type = $this->request->getParameter('output_type', pString);
 			$this->view->setVar('t_set', $t_set);
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			$va_items = caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('thumbnail', 'icon'), 'checkAccess' => $va_access_values, 'user_id' => $this->request->getUserID())));
 			$this->view->setVar('items', $va_items);
			$vs_output_filename = $t_set->getLabelForDisplay();
			$vs_output_filename = mb_substr($vs_output_filename, 0, 30);

			switch($ps_output_type) {
				case '_pdf':
				default:
					require_once(__CA_LIB_DIR__.'/core/Parsers/dompdf/dompdf_config.inc.php');
					$vs_output_file_name = preg_replace("/[^A-Za-z0-9\-]+/", '_', $vs_output_filename);
					header("Content-Disposition: attachment; filename=export_results.pdf");
					header("Content-type: application/pdf");
					$vs_content = $this->render('Sets/exportTemplates/ca_objects_sets_pdf_html.php');
					$o_pdf = new DOMPDF();
					// Page sizes: 'letter', 'legal', 'A4'
					// Orientation:  'portrait' or 'landscape'
					$o_pdf->set_paper("letter", "portrait");
					$o_pdf->load_html($vs_content, 'utf-8');
					$o_pdf->render();
					$o_pdf->stream($vs_output_file_name.".pdf");
					return;
					break;
				case '_csv':
					$vs_delimiter = ",";
					$vs_output_file_name = preg_replace("/[^A-Za-z0-9\-]+/", '_', $vs_output_filename.'_csv');
					$vs_file_extension = 'txt';
					$vs_mimetype = "text/plain";
					break;
				case '_tab':
					$vs_delimiter = "\t";	
					$vs_output_file_name = preg_replace("/[^A-Za-z0-9\-]+/", '_', $vs_output_filename.'_tab');
					$vs_file_extension = 'txt';
					$vs_mimetype = "text/plain";	
					break;
			}

			header("Content-Disposition: attachment; filename=export_".$vs_output_file_name.".".$vs_file_extension);
			header("Content-type: ".$vs_mimetype);
			
			$va_rows = array();
			# --- headings
			$va_row[] = _t("Media");
			$va_row[] = _t("ID");
			$va_row[] = _t("Label");
			$va_rows[] = join($vs_delimiter, $va_row);
			foreach($va_items as $va_item){
				$va_row = array();
				$va_row[] = $va_item["representation_url_thumbnail"];
				$va_row[] = $va_item["idno"];
				$va_row[] = $va_item["name"];
				$va_rows[] = join($vs_delimiter, $va_row);
			}
			$this->opo_response->addContent(join("\n", $va_rows), 'view');		
		}
		# ------------------------------------------------------
		/**
		 *
		 */
		public function Present() {
			AssetLoadManager::register("reveal.js");
			$o_app = AppController::getInstance();
			$o_app->removeAllPlugins();
			$t_set = $this->_getSet();
			$this->view->setVar("set", $t_set);

			$this->render("Sets/present_html.php");
		}
 		# -------------------------------------------------------
 		
 		/** 
 		 * Return set_id from request with fallback to user var, or if nothing there then get the users' first set
 		 */
 		private function _getSetID() {
 			$vn_set_id = null;
 			if (!$vn_set_id = $this->request->getParameter('set_id', pInteger)) {			// try to get set_id from request
 				if(!$vn_set_id = $this->request->user->getVar('current_set_id')){		// get last used set_id
 					return null;
 				}
 			}
 			return $vn_set_id;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Uses _getSetID() to figure out the ID of the current set, then returns a ca_sets object for it
 		 * and also sets the 'current_set_id' user variable
 		 */
 		private function _getSet($vs_access_level = __CA_SET_EDIT_ACCESS__) {
 			$t_set = new ca_sets();
 			$vn_set_id = $this->_getSetID();
 			if($vn_set_id){
				$t_set->load($vn_set_id);
				
				if ($t_set->getPrimaryKey() && ($t_set->haveAccessToSet($this->request->getUserID(), $vs_access_level))) {
					$this->request->user->setVar('current_set_id', $vn_set_id);
					# --- pass the access level the user has to the set - needed to display the proper controls in views
					$vb_write_access = false;
					if($t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)){
						$vb_write_access = true;
					}
					$this->view->setVar("write_access", $vb_write_access);
					return $t_set;
				}
			}
 			return null;
 		}
 		# -------------------------------------------------------
 	}
 ?>