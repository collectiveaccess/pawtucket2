<?php
/** ---------------------------------------------------------------------
 * app/plugins/Contribute/BaseEditorController.php : 
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
 * @package CollectiveAccess
 * @subpackage UI
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  *
  */
 
 	require_once(__CA_MODELS_DIR__."/ca_editor_uis.php");
 	require_once(__CA_MODELS_DIR__."/ca_attribute_values.php");
 	require_once(__CA_MODELS_DIR__."/ca_metadata_elements.php");
 	require_once(__CA_MODELS_DIR__."/ca_bundle_mappings.php");
 	require_once(__CA_MODELS_DIR__."/ca_bundle_displays.php");
 	require_once(__CA_LIB_DIR__."/core/Datamodel.php");
 	require_once(__CA_LIB_DIR__."/ca/ApplicationPluginManager.php");
 	require_once(__CA_LIB_DIR__."/ca/ResultContext.php");
	require_once(__CA_LIB_DIR__."/core/Logging/Eventlog.php");
 
 	class BaseEditorController extends ActionController {
 		# -------------------------------------------------------
 		protected $opo_datamodel;
 		protected $opo_app_plugin_manager;
 		protected $opo_result_context;
 		
 		protected $opo_plugin_config;
 		protected $ops_theme;
 		protected $ops_table_name = null;		// name of "subject" table (what we're editing)
 		protected $opo_instance = null;
 		
 		protected $ops_ui_code = null;
 		protected $opa_ui_info = null;
 		# -------------------------------------------------------
 		#
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
			
 			$this->opo_datamodel = Datamodel::load();
 			$this->opo_app_plugin_manager = new ApplicationPluginManager();
 			$this->opo_result_context = new ResultContext($po_request, $this->ops_table_name, ResultContext::getLastFind($po_request, $this->ops_table_name));
 		}
 		# -------------------------------------------------------
 		/**
 		 * Generates a form for editing new or existing records. The form is rendered into the current view, inherited from ActionController
 		 *
 		 * @param array $pa_values An optional array of values to preset in the format, overriding any existing values in the model of the record being editing.
 		 * @param array $pa_options Array of options passed through to _initView
 		 *
 		 */
 		public function Edit($pa_values=null, $pa_options=null) {
 			list($vn_subject_id, $t_subject, $t_ui) = $this->_initView($pa_options);
 			$vs_mode = $this->request->getParameter('mode', pString);
 			
 			//
 			// Don't open existing records
 			//
 			if ($t_subject->hasField('deleted') && $t_subject->get('deleted')) { 
 				$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2550?r='.urlencode($this->request->getFullUrlPath()));
 				return;
 			}
 			
 			
 			if ((!$t_subject->getPrimaryKey()) && ($vn_subject_id)) { 
 				$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2500?r='.urlencode($this->request->getFullUrlPath()));
 				return;
 			}
 			
 			if(is_array($pa_values)) {
 				foreach($pa_values as $vs_key => $vs_val) {
 					$t_subject->set($vs_key, $vs_val);
 				}
 			}
 			
 			// set "context" id from those editors that need to restrict idno lookups to within the context of another field value (eg. idno's for ca_list_items are only unique within a given list_id)
 			if ($vs_idno_context_field = $t_subject->getProperty('ID_NUMBERING_CONTEXT_FIELD')) {
 				if ($vn_subject_id > 0) {
 					$this->view->setVar('_context_id', $t_subject->get($vs_idno_context_field));
 				} 
 			}
 			
 			// get default screen
 			
 			if (!($vn_type_id = $t_subject->getTypeID())) {
 				$vn_type_id = $this->request->getParameter($t_subject->getTypeFieldName(), pInteger);
 			}
 			
 			if (!$this->request->getActionExtra()) {
 				$va_nav = $t_ui->getScreensAsNavConfigFragment($this->request, $vn_type_id, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(),
					array(),
					array()
				);
 				$this->request->setActionExtra($va_nav['defaultScreen']);
 			}
			$this->view->setVar('t_ui', $t_ui);
			if (!$t_ui->getPrimaryKey()) {
				$this->notification->addNotification(_t('There is no configuration available for this editor. Check your system configuration and ensure there is at least one valid configuration for this type of editor.'), __NOTIFICATION_TYPE_ERROR__);
			}
			if ($vn_subject_id) { $this->request->session->setVar($this->ops_table_name.'_browse_last_id', $vn_subject_id); } 	// set last edited
			
			# trigger "EditItem" hook 
			$this->opo_app_plugin_manager->hookEditItem(array('id' => $vn_subject_id, 'table_num' => $t_subject->tableNum(), 'table_name' => $t_subject->tableName(), 'instance' => $t_subject));
			$this->render('screen_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 * Saves the content of a form editing new or existing records. It returns the same form + status messages rendered into the current view, inherited from ActionController
 		 *
 		 * @param array $pa_options Array of options passed through to _initView and saveBundlesForScreen()
 		 */
 		public function Save($pa_options=null) {
 			list($vn_subject_id, $t_subject, $t_ui) = $this->_initView($pa_options);
 			if (!is_array($pa_options)) { $pa_options = array(); }
 			$vs_message = '';
 			
 			$vs_auth_table_name = $this->ops_table_name;
 			if (in_array($this->ops_table_name, array('ca_object_representations', 'ca_representation_annotations'))) { $vs_auth_table_name = 'ca_objects'; }
 			 			
 			if(!sizeof($_POST)) {
 				$this->notification->addNotification(_t("Cannot save using empty request. Are you using a bookmark?"), __NOTIFICATION_TYPE_ERROR__);	
 				$this->render('screen_html.php');
 				return;
 			}
 			
 			// set "context" id from those editors that need to restrict idno lookups to within the context of another field value (eg. idno's for ca_list_items are only unique within a given list_id)
 			$vn_context_id = null;
 			if ($vs_idno_context_field = $t_subject->getProperty('ID_NUMBERING_CONTEXT_FIELD')) {
 				if ($vn_subject_id > 0) {
 					$this->view->setVar('_context_id', $vn_context_id = $t_subject->get($vs_idno_context_field));
 				} 
 				
 				if ($vn_context_id) { $t_subject->set($vs_idno_context_field, $vn_context_id); }
 			}
 			
 			if (!($vs_type_name = $t_subject->getTypeName())) {
 				$vs_type_name = $t_subject->getProperty('NAME_SINGULAR');
 			}
 			
 			if ($vn_subject_id && !$t_subject->getPrimaryKey()) {
 				$this->notification->addNotification(_t("%1 does not exist", $vs_type_name), __NOTIFICATION_TYPE_ERROR__);	
 				return;
 			}
 			
 			# trigger "BeforeSaveItem" hook 
			$this->opo_app_plugin_manager->hookBeforeSaveItem(array('id' => $vn_subject_id, 'table_num' => $t_subject->tableNum(), 'table_name' => $t_subject->tableName(), 'instance' => $t_subject, 'is_insert' => $vb_is_insert));
 			
 			$vb_is_insert = !$t_subject->getPrimaryKey();
 			
 			// Set access and status
 			if(strlen($vn_access = ContributePlugin::getFormSetting('access'))) {
 				$t_subject->set("access", $vn_access);
 			}
 			if(strlen($vn_status = ContributePlugin::getFormSetting('status'))) {
 				$t_subject->set("status", $vn_status);
 			}
 			$vb_save_rc = $t_subject->saveBundlesForScreen($this->request->getActionExtra(), $this->request, array_merge($pa_options, array('ui_instance' => $t_ui)));
			$this->view->setVar('t_ui', $t_ui);
		
			if(!$vn_subject_id) {
				$vn_subject_id = $t_subject->getPrimaryKey();
				if (!$vb_save_rc) {
					$vs_message = "";
				} else {
					if (isset($pa_options['setNotifictionOnSuccess']) && $pa_options['setNotifictionOnSuccess']) {
						$vs_message = _t("Added %1", $vs_type_name);
					}
					$this->request->setParameter($t_subject->primaryKey(), $vn_subject_id, 'GET');
					$this->view->setVar($t_subject->primaryKey(), $vn_subject_id);
					$this->view->setVar('subject_id', $vn_subject_id);
					$this->request->session->setVar($this->ops_table_name.'_browse_last_id', $vn_subject_id);	// set last edited
				}
				
			} else {
 				$vs_message = _t("Saved changes to %1", $vs_type_name);
 			}
 			
 			$va_errors = $this->request->getActionErrors();							// all errors from all sources
 			$va_general_errors = $this->request->getActionErrors('general');		// just "general" errors - ones that are not attached to a specific part of the form
 			if (is_array($va_general_errors) && sizeof($va_general_errors) > 0) {
 				foreach($va_general_errors as $o_e) {
 					$this->notification->addNotification($o_e->getErrorDescription(), __NOTIFICATION_TYPE_ERROR__);
 				}
			}
			
 			if(sizeof($va_errors) + sizeof($va_general_errors) > 0) {
 				$va_error_list = array();
 				$vb_no_save_error = false;
 				foreach($va_errors as $o_e) {
 					$va_error_list[$o_e->getErrorDescription()] = "<li>".$o_e->getErrorDescription()."</li>\n";
 					
 					switch($o_e->getErrorNumber()) {
 						case 1100:	// duplicate/invalid idno
 							if (!$vn_subject_id) {		// can't save new record if idno is not valid (when updating everything but idno is saved if it is invalid)
 								$vb_no_save_error = true;
 							}
 							break;
 					}
 				}
 				if ($vb_no_save_error) {
 					$this->notification->addNotification(_t("There are errors preventing <strong>ALL</strong> information from being saved. Correct the problems and click \"save\" again.\n<ul>").join("\n", $va_error_list)."</ul>", __NOTIFICATION_TYPE_ERROR__);
 				} else {
 					if ($vs_message) { $this->notification->addNotification($vs_message, __NOTIFICATION_TYPE_INFO__); }	
 					$this->notification->addNotification(_t("There are errors preventing information in specific fields from being saved as noted below.\n<ul>").join("\n", $va_error_list)."</ul>", __NOTIFICATION_TYPE_ERROR__);
 				}
 				
 				
 				$this->render('screen_html.php');
 			} else {
				if ($vs_message) { $this->notification->addNotification($vs_message, __NOTIFICATION_TYPE_INFO__); }
 				$this->opo_result_context->invalidateCache();
  				$this->opo_result_context->saveContext();
  				
 				# trigger "SaveItem" hook 
  				$this->opo_app_plugin_manager->hookSaveItem(array('id' => $vn_subject_id, 'table_num' => $t_subject->tableNum(), 'table_name' => $t_subject->tableName(), 'instance' => $t_subject, 'is_insert' => $vb_is_insert));
 			
 				if ((bool)$this->opa_ui_info['set_post_submission_notification']) {
 					if (($t_subject->tableName() == 'ca_objects') && ($t_subject->getRepresentationCount() > 0)) {
 						$this->notification->addNotification($this->opa_ui_info['post_submission_notification_message_with_media'], __NOTIFICATION_TYPE_INFO__);
 					} else {
 						$this->notification->addNotification($this->opa_ui_info['post_submission_notification_message'], __NOTIFICATION_TYPE_INFO__);
 					}
 				}
 				switch($this->opa_ui_info['post_submission_destination']) {
 					case 'url':
 						$vs_url = caNavUrl($this->request, $this->opa_ui_info['post_submission_destination_url']['module'], $this->opa_ui_info['post_submission_destination_url']['controller'], $this->opa_ui_info['post_submission_destination_url']['action']);
 						$this->response->setRedirect($vs_url);
 						
 						break;
 					case 'splash':
 						if ($vs_default_action = $this->request->config->get('default_action')) {
							$va_tmp = explode('/', $vs_default_action);
							$vs_action = array_pop($va_tmp);
							if (sizeof($va_tmp)) { $vs_controller = array_pop($va_tmp); }
							if (sizeof($va_tmp)) { $vs_module_path = join('/', $va_tmp); }
						} else {
							$vs_controller = 'Splash';
							$vs_action = 'Index';
						}
						$vs_url = caNavUrl($this->request, $vs_module_path, $vs_controller, $vs_action);
						$this->response->setRedirect($vs_url);
 						break;
 					case 'last_page': 
 						if (!($vs_url = $this->request->session->getVar('pawtucket2_last_page'))) {
							$vs_action = $vs_controller = $vs_module_path = '';
							if ($vs_default_action = $this->request->config->get('default_action')) {
								$va_tmp = explode('/', $vs_default_action);
								$vs_action = array_pop($va_tmp);
								if (sizeof($va_tmp)) { $vs_controller = array_pop($va_tmp); }
								if (sizeof($va_tmp)) { $vs_module_path = join('/', $va_tmp); }
							} else {
								$vs_controller = 'Splash';
								$vs_action = 'Index';
							}
							$vs_url = caNavUrl($this->request, $vs_module_path, $vs_controller, $vs_action);
						} 
						$this->response->setRedirect($vs_url);
 						break;
 					case 'page':
 					default:
 						$this->render('result_html.php');
 						break;
 				}
 			}
 		}
 		# -------------------------------------------------------
 		/**
 		 * Generates display summary of record data based upon a bundle display for screen
 		 *
 		 * @param array $pa_options Array of options passed through to _initView 
 		 */
 		protected function _initView($pa_options=null) {
 			// load required javascript
 			JavascriptLoadManager::register('bundleableEditor');
 			JavascriptLoadManager::register('imageScroller');
 			$t_subject = $this->opo_datamodel->getInstanceByTableName($this->ops_table_name);
 			$t_subject->purify(true);	// filter HTML for bad things like <script> tags and malformed markup
 			
			// empty (ie. new) rows don't have a type_id set, which means we'll have no idea which attributes to display
			// so we get the type_id off of the request
			if (!$vn_type_id = $this->request->getParameter($t_subject->getTypeFieldName(), pInteger)) {
				$vn_type_id = null;
			}
			
			// then set the empty row's type_id
			$t_subject->set($t_subject->getTypeFieldName(), $vn_type_id);
			
			// then reload the definitions (which includes bundle specs)
			$t_subject->reloadLabelDefinitions();
 			
 			$t_ui = new ca_editor_uis();
 			if (isset($pa_options['ui']) && $pa_options['ui']) {
 				if (is_numeric($pa_options['ui'])) {
 					$t_ui->load((int)$pa_options['ui']);
 				}
 				if (!$t_ui->getPrimaryKey()) {
 					$t_ui->load(array('editor_code' => $pa_options['ui']));
 				}
 			}
 			
 			if (!$t_ui->getPrimaryKey()) {
 				$t_ui->loadDefaultUI($this->ops_table_name, $this->request);
 			}
 			
 			$this->view->setVar('t_subject', $t_subject);
 			
 			return array(null, $t_subject, $t_ui);
 		}
 		# -------------------------------------------------------
		/** 
		 * Returns current result contents
		 *
		 * @return ResultContext ResultContext instance.
		 */
		public function getResultContext() {
			return $this->opo_result_context;
		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		protected function _getTypeIDForUI($t_subject) {
 			$vn_type_id = null;
 			if (isset($this->opa_ui_info) && is_array($this->opa_ui_info)) {
 				if(isset($this->opa_ui_info['type_id']) && ($vn_type_id = $this->opa_ui_info['type_id'])) {
 					return $vn_type_id;
 				}
 			} 
 			$this->notification->addNotification(_t('Type "%1" configured for the Contribute form "%2" is not valid', $this->opa_ui_info['type'], $this->ops_ui_code), __NOTIFICATION_TYPE_ERROR__);	
 			return null;
 		}
		# -------------------------------------------------------
 	}
 ?>