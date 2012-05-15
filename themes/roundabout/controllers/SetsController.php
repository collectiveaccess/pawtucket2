<?php
/* ----------------------------------------------------------------------
 * includes/SetsController.php
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
 
 	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 
 	class SetsController extends ActionController {
 		# -------------------------------------------------------
 		/** 
 		 * Return set_id from request with fallback to user var, or if nothing there then get the users' first set
 		 * Will return null if there's not set_id to be found anywhere (ie. the user has no sets)
 		 */
 		private function _getSetID() {
 			$vn_set_id = null;
 			if (!$vn_set_id = $this->request->getParameter('set_id', pInteger)) {			// try to get set_id from request
 				if (!$vn_set_id = $this->request->user->getVar('current_set_id')) {		// get last used set_id
 					$t_set = new ca_sets();
 					$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'user_id' => $this->request->getUserID())));
 					$va_first_set = array_shift($va_sets);
 					if (sizeof($va_first_set)) {
 						$vn_set_id = $va_first_set['set_id'];
 					}
 				}
 			}
 			return $vn_set_id;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Uses _getSetID() to figure out the ID of the current set, then returns a ca_sets object for it
 		 * and also sets the 'current_set_id' user variable
 		 */
 		private function _getSet() {
 			$t_set = new ca_sets();
 			$vn_set_id = $this->_getSetID();
 			$t_set->load($vn_set_id);
 			
 			if ($t_set->getPrimaryKey() && ($t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__))) {
 				$this->request->user->setVar('current_set_id', $vn_set_id);
 				return $t_set;
 			}
 			return null;
 		}
 		# -------------------------------------------------------
 		function index() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			if (!$t_set = $this->_getSet()) { $t_set = new ca_sets(); }
 			
 			JavascriptLoadManager::register('sortableUI');
 			
 			# --- get all sets for user
 			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'user_id' => $this->request->getUserID())));
 			
 			$t_new_set = new ca_sets(); # --- new set object used for access drop down in new set form
 			
 			$this->view->setVar('t_set', $t_set);
 			$this->view->setVar('t_new_set', $t_new_set);
 			$this->view->setVar('set_list', $va_sets);
 			$this->view->setVar('set_name', $t_set->getLabelForDisplay());
 			$this->view->setVar('set_description', $t_set->get("ca_sets.set_intro"));
 			$this->view->setVar('set_access', $t_set->get("ca_sets.access"));
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			$this->view->setVar('items', caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('thumbnail', 'icon'), 'checkAccess' => $va_access_values, 'user_id' => $this->request->getUserID()))));
 			$this->render('Sets/sets_html.php');
 		}
 		# -------------------------------------------------------
 		public function addItem() {
 			global $g_ui_locale_id; // current locale_id for user
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			if (!$t_set = $this->_getSet()) { 
 				# --- if there is not a set for this user, make a new set for them
 				$t_new_set = new ca_sets();
				
				$vn_new_set_id = null;
				$t_new_set->setMode(ACCESS_WRITE);
				$t_new_set->set('access', 0);
				$t_new_set->set('table_num', 57); // 57=ca_objects
				
				$t_list = new ca_lists();
				$vn_set_id = $t_list->getItemIDFromList('set_types', $this->request->config->get('user_set_type'));
				$t_new_set->set('type_id', $vn_set_id);
				$t_new_set->set('user_id', $this->request->getUserID());
				$t_new_set->set('set_code', $this->request->getUserID().'_'.time());
				
				// create new attribute
				$t_new_set->insert();
				
				if (!$t_new_set->numErrors()) {
					if ($vn_new_set_id = $t_new_set->getPrimaryKey()) {
						$t_new_set->addLabel(array('name' => _t("Your first collection")), $g_ui_locale_id, null, true); 				
				
						// select the current set
						$this->request->user->setVar('current_set_id', $vn_new_set_id);
						
						//clear t_new_set object so form appears blank and load t_set so edit form is populated
						$t_new_set = new ca_sets();
						$t_set = new ca_sets($vn_new_set_id);
					}
				}
 			}
 			
 			if (!$t_set) {
 				$va_errors[] = _t('Could not create collection for user');
 			} else {
				$pn_item_id = null;
				$pn_object_id = $this->request->getParameter('object_id', pInteger);
				if ($pn_item_id = $t_set->addItem($pn_object_id, array(), $this->request->getUserID())) {
					$va_errors = array();
					$this->view->setVar('message', _t("Successfully added item"));
				} else {
					$va_errors[] = _t('Could not add item to collection');
				}
			}
 			
 			$t_row = new ca_objects($pn_object_id);
 			
 			$this->view->setVar('errors', $va_errors);
 			
 			$this->index();
 		}
 		# -------------------------------------------------------
 		public function saveSetInfo() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			global $g_ui_locale_id; // current locale_id for user
 			
 			$va_errors_edit_set = array();
 			
 			$t_set = new ca_sets();
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$ps_name = $this->request->getParameter('name', pString);
 			if(!$ps_name){
 				$va_errors_edit_set["name"] = _t("You must enter a name for your collection");
 			}
 			$vs_desc =  $this->request->getParameter('description', pString);

 			if(sizeof($va_errors_edit_set) == 0){ 		
				if ($t_set->load($pn_set_id) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) { 
					$t_set->setMode(ACCESS_WRITE);
					$t_set->set('access', $this->request->getParameter('access', pInteger));
					
					// edit/add description
					$va_intro_texts = $t_set->getAttributesByElement('set_intro');
					if(sizeof($va_intro_texts)) {
						// edit existing attribute
						$vn_attribute_id = $va_intro_texts[0]->getAttributeID();
						$t_set->editAttribute($vn_attribute_id, 'set_intro', array('set_intro' => $vs_desc, 'locale_id' => $g_ui_locale_id));
					} else {
						// create new attribute
						$t_set->addAttribute(array('set_intro' => $vs_desc, 'locale_id' => $g_ui_locale_id), 'set_intro');
					}
					
					$t_set->update();
					
					if (sizeof($va_labels = caExtractValuesByUserLocale($t_set->getLabels(array($g_ui_locale_id), __CA_LABEL_TYPE_PREFERRED__)))) {
						// edit label	
						foreach($va_labels as $vn_set_id => $va_label) {
							$t_set->editLabel($va_label[0]['label_id'], array('name' => $ps_name), $g_ui_locale_id);
						}
					} else {
						// add new label
						$t_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true);
					}
					
					
					
				}
			}
 			$this->view->setVar('errors_edit_set', $va_errors_edit_set);
 			$this->index();
 		}
 		# -------------------------------------------------------
 		public function addNewSet() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			global $g_ui_locale_id; // current locale_id for user
 			
 			$va_errors_new_set = array();
 			
 			$t_new_set = new ca_sets();
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$ps_name = $this->request->getParameter('name', pString);
 			if(!$ps_name){
 				$va_errors_new_set["name"] = _t("Please enter the name of your collection");
 			}
 			$vs_desc =  $this->request->getParameter('description', pString);
 			
 			$t_list = new ca_lists();
 			$vn_set_type_user = $t_list->getItemIDFromList('set_types', 'user');
 			if(sizeof($va_errors_new_set) == 0){
				$t_new_set->setMode(ACCESS_WRITE);
				$t_new_set->set('access', $this->request->getParameter('access', pInteger));
				$t_new_set->set('table_num', 57); // 57=ca_objects
				$t_new_set->set('type_id', $vn_set_type_user);	// type="user"
				$t_new_set->set('user_id', $this->request->getUserID());
				$t_new_set->set('set_code', $this->request->getUserID().'_'.time());
				
				// create new attribute
				$t_new_set->addAttribute(array('set_intro' => $vs_desc, 'locale_id' => $g_ui_locale_id), 'set_intro');
				
				$t_new_set->insert();
				
				if ($vn_new_set_id = $t_new_set->getPrimaryKey()) {
					$t_new_set->addLabel(array('name' => $ps_name), $g_ui_locale_id, null, true); 				
			
					// select the current set
					$this->request->user->setVar('current_set_id', $vn_new_set_id);
					
					//clear t_new_set object so form appears blank and load t_set so edit form is populated
					$t_new_set = new ca_sets();
					$t_set = new ca_sets($vn_new_set_id);
				}
			}
			$this->view->setVar('errors_new_set', $va_errors_new_set);
 			$this->index();
 		}
 		# -------------------------------------------------------
 		public function slideshow() {
			$pn_set_id = $this->request->getParameter('set_id', pInteger);
			$t_set = new ca_sets($pn_set_id);
			
			if (!$t_set->getPrimaryKey()) {
				$this->notification->addNotification(_t("The collection does not exist"), __NOTIFICATION_TYPE_ERROR__);	
				$this->Edit();
				return;
			}
			
			if (!$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_READ_ACCESS__)) {
				$this->notification->addNotification(_t("You cannot view this collection"), __NOTIFICATION_TYPE_INFO__);
				$this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form'));
				return;
			}
			
			$this->view->setVar('set_id', $pn_set_id);
			$this->view->setVar('t_set', $t_set);
			
 			$this->render('Sets/sets_slideshow_html.php');
 		}
 		# -------------------------------------------------------
 		# XML data providers
 		# -------------------------------------------------------
 		public function getSetXML() {
			$pn_set_id = $this->request->getParameter('set_id', pInteger);
			$t_set = new ca_sets($pn_set_id);
			 
			if (!$t_set->getPrimaryKey()) {
				$this->notification->addNotification(_t("The collection does not exist"), __NOTIFICATION_TYPE_ERROR__);	
				$this->Edit();
				return;
			}
			
			if (!$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_READ_ACCESS__)) {
				$this->notification->addNotification(_t("You cannot view this collection"), __NOTIFICATION_TYPE_INFO__);
				$this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form'));
				return;
			}
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
			 
			$this->view->setVar('set_id', $pn_set_id);
			$this->view->setVar('t_set', $t_set);
			$this->view->setVar('items', caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersion' => 'large', 'checkAccess' => $va_access_values, 'user_id' => $this->request->getUserID()))));
 			$this->render('Sets/xml_set_items.php');
 		}
 		# -------------------------------------------------------
 		# Ajax handlers
 		# -------------------------------------------------------
 		public function ReorderItems() {
 			if ($this->request->isLoggedIn()) {  
				$t_set = $this->_getSet();
				
				if (!$t_set->getPrimaryKey()) {
					$this->notification->addNotification(_t("The collection does not exist"), __NOTIFICATION_TYPE_ERROR__);	
					return;
				}
				
				// does user have edit access to set?
				if (!$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
					$this->notification->addNotification(_t("You cannot edit this collection"), __NOTIFICATION_TYPE_ERROR__);
					$this->Edit();
					return;
				}
				
				$va_item_ids = explode(';', $this->request->getParameter('sort', pString));
				for($vn_i=0; $vn_i < sizeof($va_item_ids); $vn_i++) {
					$va_item_ids[$vn_i] = str_replace('setItem', '', $va_item_ids[$vn_i]);
				}
				
				// get ranks
				$va_item_ranks = $t_set->getItemRanks(array('user_id' => $this->request->getUserID()));
				
				// rewrite ranks
				$vn_i = 0;
				$o_trans = new Transaction();
				$t_set_item = new ca_set_items();
				$t_set_item->setTransaction($o_trans);
				$t_set_item->setMode(ACCESS_WRITE);
				
				$va_errors = array();
				foreach($va_item_ranks as $vn_item_id => $vn_rank) {
					if ($vn_item_id != $va_item_ids[$vn_i]) {
						if ($t_set_item->load($va_item_ids[$vn_i])) {
							$t_set_item->set('rank', $vn_rank);
							$t_set_item->update();
						
							if ($t_set_item->numErrors()) {
								$va_errors[$va_item_ids[$vn_i]] = _t('Could not reorder item %1: %2', $va_item_ids[$vn_i], join('; ', $t_set_item->getErrors()));
							}
						}
					}
					$vn_i++;
				}
				
				if(sizeof($va_errors)) {
					$o_trans->rollback();
				} else {
					$o_trans->commit();
				}
			} else {
				$va_errors['general'] = 'Must be logged in';
			}
 			$this->view->setVar('errors', $va_errors);
 			$this->render('Sets/ajax_reorder_items_json.php');
 		}
 		# -------------------------------------------------------
 		public function DeleteItem() {
 			if ($this->request->isLoggedIn()) { 
				//$pn_set_id = $this->request->getParameter('set_id', pInteger);
				//$t_set = new ca_sets($pn_set_id);
				$t_set = $this->_getSet();
				
				if (!$t_set->getPrimaryKey()) {
					$this->notification->addNotification(_t("The collection does not exist"), __NOTIFICATION_TYPE_ERROR__);	
					return;
				}
				
				// does user have edit access to set?
				if (!$t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
					$this->notification->addNotification(_t("You cannot edit this collection"), __NOTIFICATION_TYPE_ERROR__);
					$this->Edit();
					return;
				}
				
				$pn_item_id = $this->request->getParameter('item_id', pInteger);
				if ($t_set->removeItemByItemID($pn_item_id, $this->request->getUserID())) {
					$va_errors = array();
				} else {
					$va_errors[] = _t('Could not remove item from collection');
				}
				$this->view->setVar('set_id', $pn_set_id);
				$this->view->setVar('item_id', $pn_item_id);
			} else {
				$va_errors['general'] = 'Must be logged in';	
			}
 			
 			$this->view->setVar('errors', $va_errors);
 			$this->render('Sets/ajax_delete_item_json.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>