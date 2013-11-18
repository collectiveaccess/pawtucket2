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
 
 	class SetsController extends ActionController {
 		# -------------------------------------------------------
 		 protected $opa_access_values;
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			if (!$this->request->isLoggedIn()) { $this->response->setRedirect(caNavUrl($this->request, '', '', '')); return; }
 			$this->opa_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar("access_values", $this->opa_access_values);
 		}
 		# -------------------------------------------------------
 		function Index() {
 			$t_sets = new ca_sets();
 			$va_read_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->user->get("user_id"), "checkAccess" => $this->opa_access_values, "access" => 1));
 			$va_write_sets = $t_sets->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->user->get("user_id"), "access" => 2));
 			$this->view->setVar("read_sets", $va_read_sets);
 			$this->view->setVar("write_sets", $va_write_sets);
 			$this->render("Sets/set_list_html.php");
 		}
 		# ------------------------------------------------------
 		function setDetail() {
 			if (!$t_set = $this->_getSet(__CA_SET_READ_ACCESS__)) { $this->Index(); }
 			$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $this->request->user->get("user_id"), "thumbnailVersions" => array("preview"), "checkAccess" => $this->opa_access_values)));
			$this->view->setVar("set", $t_set);
			$this->view->setVar("set_items", $va_set_items);
			$this->render("Sets/set_detail_thumbnail_html.php");
 		}
 		# ------------------------------------------------------
 		function AjaxListComments() {
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
 				if($t_item->addComment($ps_comment, null, $this->request->user->get("user_id"), null, null, null, 1, array("purify" => true))){
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
					return $t_set;
				}
			}
 			return null;
 		}
 		# -------------------------------------------------------
 	}
 ?>