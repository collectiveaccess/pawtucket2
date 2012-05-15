<?php
/* ----------------------------------------------------------------------
 * controllers/BookmarksController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
	require_once(__CA_MODELS_DIR__."/ca_bookmarks.php");
	require_once(__CA_MODELS_DIR__."/ca_bookmark_folders.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_LIB_DIR__."/core/Parsers/htmlpurifier/HTMLPurifier.standalone.php");
 
 	class BookmarksController extends ActionController {
 		# -------------------------------------------------------
 		/** 
 		 * Return folder_id from request with fallback to user var, or if nothing there then get the users' first bookmark folder
 		 * Will return null if there's not folder_id to be found anywhere (ie. the user has no bookmark folders)
 		 */
 		private function _getFolderID() {
 			$vn_folder_id = null;
 			if (!$vn_folder_id = $this->request->getParameter('folder_id', pInteger)) {			// try to get folder_id from request
 				if (!$vn_folder_id = $this->request->user->getVar('current_folder_id')) {		// get last used folder_id
 					$t_folder = new ca_bookmark_folders();
 					$va_folders = $t_folder->getFolders($this->request->getUserID());
 					$va_first_folder = array_shift($va_folders);
 					if (sizeof($va_first_folder)) {
 						$vn_folder_id = $va_first_folder['folder_id'];
 					}
 				}
 			}
 			return $vn_folder_id;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Uses _getFolderID() to figure out the ID of the current folder, then returns a ca_bookmark_folders object for it
 		 * and also sets the 'current_folder_id' user variable
 		 */
 		private function _getFolder() {
 			$t_folder = new ca_bookmark_folders();
 			$vn_folder_id = $this->_getFolderID();
 			$t_folder->load($vn_folder_id);
 			
 			if ($t_folder->getPrimaryKey() && ($t_folder->get('user_id') == $this->request->getUserID())) {
 				$this->request->user->setVar('current_folder_id', $vn_folder_id);
 				return $t_folder;
 			}
 			return null;
 		}
 		# -------------------------------------------------------
 		function index() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			if (!$t_folder = $this->_getFolder()) { $t_folder = new ca_bookmark_folders(); }
 			
 			JavascriptLoadManager::register('sortableUI');
 			
 			# --- get all folders for user
 			$va_folders = $t_folder->getFolders($this->request->getUserID());
 			
 			$this->view->setVar('t_folder', $t_folder);
 			$this->view->setVar('folder_list', $va_folders);
 			$this->view->setVar('folder_name', $t_folder->get("name"));
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			$this->view->setVar('items', $t_folder->getBookmarks(null, $this->request->getUserID()));
 			$this->render('Bookmarks/bookmarks_html.php');
 		}
 		# -------------------------------------------------------
 		public function addBookmark() {
 			global $g_ui_locale_id; // current locale_id for user
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			if (!$t_folder = $this->_getFolder()) { 
 				# --- if there is not a folder for this user, make a new folder for them
 				$t_new_folder = new ca_bookmark_folders();
				
				$vn_new_folder_id = null;
				$t_new_folder->setMode(ACCESS_WRITE);
				$t_new_folder->set('user_id', $this->request->getUserID());
				$t_new_folder->set('name', _t("My bookmarks"));
				
				// create new folder
				$t_new_folder->insert();
				
				if (!$t_new_folder->numErrors()) {
					if ($vn_new_folder_id = $t_new_folder->getPrimaryKey()) {
						// select the current folder
						$this->request->user->setVar('current_folder_id', $vn_new_folder_id);
						
						//clear t_new_folder object so form appears blank and load t_folder so edit form is populated
						$t_new_folder = new ca_bookmark_folders();
						$t_folder = new ca_bookmark_folders($vn_new_folder_id);
					}
				}
 			}
 			
 			if (!$t_folder) {
 				$va_errors[] = _t('Could not create bookmark folder for user');
 			} else {
				$pn_row_id = $this->request->getParameter('row_id', pInteger);
				$ps_tablename = $this->request->getParameter('tablename', pString);
				if ($pn_item_id = $t_folder->addBookmark($ps_tablename, $pn_row_id, null, null, null, $this->request->getUserID())) {
					$va_errors = array();
					$this->view->setVar('message', _t("Bookmarked item"));
				} else {
					$va_errors[] = _t('Could not bookmark item');
				}
			}
 			
 			$this->view->setVar('errors', $va_errors);
 			
 			$this->index();
 		}
 		# -------------------------------------------------------
 		public function saveFolderInfo() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			global $g_ui_locale_id; // current locale_id for user
 			
 			$va_errors_edit_folder = array();
 			
 			$o_purifier = new HTMLPurifier();
 			
 			$t_folder = new ca_bookmark_folders();
 			$pn_folder_id = $this->request->getParameter('folder_id', pInteger);
 			$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
 			if(!$ps_name){
 				$va_errors_edit_folder["name"] = _t("You must enter a name for your folder");
 			}

 			if(sizeof($va_errors_edit_folder) == 0){ 		
				if ($t_folder->load($pn_folder_id) && ($t_folder->get('user_id') == $this->request->getUserID())) { 
					$t_folder->setMode(ACCESS_WRITE);
					$t_folder->set('name', $ps_name);
					$t_folder->update();					
				}
			}
 			$this->view->setVar('errors_edit_folder', $va_errors_edit_folder);
 			$this->index();
 		}
 		# -------------------------------------------------------
 		public function addNewFolder() {
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form')); return; }
 			global $g_ui_locale_id; // current locale_id for user
 			
 			$va_errors_new_folder = array();
 			
 			$o_purifier = new HTMLPurifier();
 			
 			$t_new_folder = new ca_bookmark_folders();
 			$pn_folder_id = $this->request->getParameter('folder_id', pInteger);
 			$ps_name = $o_purifier->purify($this->request->getParameter('name', pString));
 			if(!$ps_name){
 				$va_errors_new_folder["name"] = _t("Please enter the name of your folder");
 			}
 			if(sizeof($va_errors_new_folder) == 0){
				$t_new_folder->setMode(ACCESS_WRITE);
				$t_new_folder->set('user_id', $this->request->getUserID());
				$t_new_folder->set('name', $ps_name);
				$t_new_folder->insert();
				
				if ($vn_new_folder_id = $t_new_folder->getPrimaryKey()) {
					// select the current folder
					$this->request->user->setVar('current_folder_id', $vn_new_folder_id);
					
					//clear t_new_folder object so form appears blank and load t_folder so edit form is populated
					$t_new_folder = new ca_bookmark_folders();
					$t_folder = new ca_bookmark_folders($vn_new_folder_id);
				}
			}
			$this->view->setVar('errors_new_folder', $va_errors_new_folder);
 			$this->index();
 		}
 		# -------------------------------------------------------
 		public function DeleteItem() {
 			if ($this->request->isLoggedIn()) { 
				$t_folder = $this->_getFolder();
				
				if (!$t_folder->getPrimaryKey()) {
					$this->notification->addNotification(_t("The folder does not exist"), __NOTIFICATION_TYPE_ERROR__);	
					return;
				}
				
				// does user have access to folder?
				if ($t_folder->get("user_id") != $this->request->getUserID()) {
					$this->notification->addNotification(_t("You cannot edit this folder"), __NOTIFICATION_TYPE_ERROR__);
					$this->index();
					return;
				}
				
				$pn_bookmark_id = $this->request->getParameter('bookmark_id', pInteger);
				if ($t_folder->removeBookmark($pn_bookmark_id, null, $this->request->getUserID())) {
					$va_errors = array();
					$this->view->setVar('message', _t("Removed bookmark"));
				} else {
					$va_errors[] = _t('Could not delete bookmark');
				}
				$this->view->setVar('folder_id', $pn_folder_id);
				$this->view->setVar('bookmark_id', $pn_bookmark_id);
			} else {
				$va_errors['general'] = 'Must be logged in';	
			}
 			
 			$this->view->setVar('errors', $va_errors);
 			$this->index();
 		}
 		# -------------------------------------------------------
 		 public function DeleteFolder() {
 			if ($this->request->isLoggedIn()) { 
				$t_folder = $this->_getFolder();
				
				if (!$t_folder->getPrimaryKey()) {
					$this->notification->addNotification(_t("The folder does not exist"), __NOTIFICATION_TYPE_ERROR__);	
					return;
				}
				
				// does user have access to folder?
				if ($t_folder->get("user_id") != $this->request->getUserID()) {
					$this->notification->addNotification(_t("You cannot edit this folder"), __NOTIFICATION_TYPE_ERROR__);
					$this->index();
					return;
				}
				
				$va_errors = array();
				$t_folder->setMode(ACCESS_WRITE);
				$t_folder->delete(true);
				if ($t_folder->numErrors()) {
					foreach ($t_folder->getErrors() as $vs_e) {  
						$va_errors["general"] = $vs_e;
					}
					if(sizeof($va_errors) > 0){
						$this->notification->addNotification("Could not delete folder", __NOTIFICATION_TYPE_ERROR__);
						$this->index();
						return;
					}
				}else{
					$this->view->setVar('message', _t("Deleted bookmark folder"));
					$this->request->user->setVar('current_folder_id', '');
				}
				
			} else {
				$this->notification->addNotification("You must be logged in", __NOTIFICATION_TYPE_ERROR__);	
			}
 			
 			$this->view->setVar('errors', $va_errors);
 			$this->index();
 		}
 		# -------------------------------------------------------
 	}
 ?>