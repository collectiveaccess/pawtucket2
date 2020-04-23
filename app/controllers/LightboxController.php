<?php
/* ----------------------------------------------------------------------
 * controllers/LightboxController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/ApplicationError.php");
	require_once(__CA_LIB_DIR__."/Datamodel.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_user_groups.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets_x_users.php");
 	require_once(__CA_APP_DIR__."/controllers/BrowseController.php");
 	require_once(__CA_LIB_DIR__."/GeographicMap.php");
	require_once(__CA_LIB_DIR__.'/Parsers/ZipStream.php');
	require_once(__CA_LIB_DIR__.'/Logging/Downloadlog.php');
 
 	class LightboxController extends BrowseController {
 		# -------------------------------------------------------
        /**
         * @var array
         */
 		 protected $opa_access_values;

        /**
         * @var array
         */
 		 protected $opa_user_groups;

        /**
         * @var
         */
 		 protected $ops_lightbox_display_name;

        /**
         * @var
         */
 		 protected $ops_lightbox_display_name_plural;

        /**
         * @var
         */
        protected $opb_is_login_redirect = false;
        
        /**
         * @var HTMLPurifier
         */
        protected $purifier;
        
        /**
         * @var string
         */
        protected $ops_tablename = 'ca_objects';
        
 		/**
 		 *
 		 */
 		protected $ops_view_prefix = 'Lightbox';
 		protected $ops_description_attribute;
        
 		# -------------------------------------------------------
        /**
         * @param RequestHTTP $po_request
         * @param ResponseHTTP $po_response
         * @param null $pa_view_paths
         * @throws ApplicationException
         */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			$this->ops_find_type = 'lightbox';

 			parent::__construct($po_request, $po_response, $pa_view_paths);

            // Catch disabled lightbox
            if ($this->request->config->get('disable_lightbox')) {
 				throw new ApplicationException('Lightbox is not enabled');
 			}
 			if (!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl("", "LoginReg", "LoginForm"));
                $this->opb_is_login_redirect = true;
                return;
            }
            
 			$t_user_groups = new ca_user_groups();
 			$this->opa_user_groups = $t_user_groups->getGroupList("name", "desc", $this->request->getUserID());
 			$this->view->setVar("user_groups", $this->opa_user_groups);

 			$this->opo_config = caGetLightboxConfig();
 			$this->view->setVar("config", $this->opo_config);
 			caSetPageCSSClasses(["lightbox", "results"]);
 			
 			$va_lightboxDisplayName = caGetLightboxDisplayName($this->opo_config);
 			$this->view->setVar('set_config', $this->opo_config);
 			
			$this->ops_lightbox_display_name = $va_lightboxDisplayName["singular"];
			$this->ops_lightbox_display_name_plural = $va_lightboxDisplayName["plural"];
			$this->ops_description_attribute = ($this->opo_config->get("lightbox_set_description_element_code") ? $this->opo_config->get("lightbox_set_description_element_code") : "description");
			$this->view->setVar('description_attribute', $this->ops_description_attribute);
			
			$this->purifier = new HTMLPurifier();
			
 			parent::setTableSpecificViewVars();
 		}
 		# -------------------------------------------------------
        /**
         *
         */
 		function index($options = null) {
 			if($this->opb_is_login_redirect) { return; }

			$va_lightbox_displayname = caGetLightboxDisplayName();
			$this->view->setVar('lightbox_displayname', $va_lightbox_displayname["singular"]);
			$this->view->setVar('lightbox_displayname_plural', $va_lightbox_displayname["plural"]);

			$this->opo_result_context = new ResultContext($this->request, 'ca_objects', 'lightbox');
			$this->opo_result_context->setAsLastFind();
			
			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").ucfirst($this->ops_lightbox_display_name));
 			
 			$this->render(caGetOption("view", $pa_options, "Lightbox/index_html.php"));
 		}
		# -------------------------------------------------------
		/**
		 *
		 */
		function list($options = null) {
			if ($this->opb_is_login_redirect) {
				return;
			}
			$this->view->setVar("write_sets", $va_write_sets);
			$t_sets = new ca_sets();
			$va_read_sets = $t_sets->getSetsForUser(array("user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "access" => (!is_null($vn_access = $this->request->config->get('lightbox_default_access'))) ? $vn_access : 1, "parents_only" => true));
			$va_write_sets = $t_sets->getSetsForUser(array("user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "parents_only" => true));

			$this->view->setVar("data", ['sets' => $va_write_sets]);
			$this->render("Lightbox/browse_data_json.php");
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		public function getContent() {
			if ($this->opb_is_login_redirect) {
				return;
			}
			$browse_info = $this->opo_config->get("lightboxBrowse");
			if ($set_id = $this->request->getParameter('set_id', pInteger)) {
				Session::setVar("lightbox_last_set_id", $set_id);
			} else {
				$set_id = Session::getVar("lightbox_last_set_id");
			}

			$t_set = new ca_sets($set_id);
			$introduction = [
				'title' => $t_set->get('ca_sets.preferred_labels.name')
			];

			parent::__call('getContent', ['browseInfo' => $browse_info, 'introduction' => $introduction, 'dontSetFind' => true, 'noCache' => true]);
		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function view($options = null) {
			if ($this->opb_is_login_redirect) {
				return;
			}
			$this->render("Lightbox/contents_html.php");
		}
		# ------------------------------------------------------
		/**
		 *
		 */
		function add($options = null) {
			global $g_ui_locale_id;
			if ($this->opb_is_login_redirect) {
				return;
			}

			$name = $this->request->getParameter('name', pString);
			$table = $this->request->getParameter('table', pString);
			if ($table_num = Datamodel::getTableNum($table)) {
				if (strlen($name) === 0) {
					$data = ['err' => _t('Lightbox name must not be blank', $name)];
				} elseif ($t_set = ca_sets::find(['name' => $name, 'table_num' => $table_num, 'user_id' => $this->request->getUserID()], ['returnAs' => 'firstModelInstance'])) {
					$data = ['err' => _t('Lightbox with name %1 already exists', $name)];
				} else {
					$t_set = new ca_sets();
					$t_set->set([
						'type_id' => ($this->request->config->get('user_set_type')) ? $this->request->config->get('user_set_type') : 'user',
						'table_num' => $table_num,
						'user_id' => $this->request->getUserID(),
						'set_code' => caGenerateGUID(),
						'access' => 1
					]);
					$t_set->insert();
					if ($t_set->numErrors() > 0) {
						$data = ['err' => _t('Could not create new lightbox: %1', join("; ", $t_set->getErrors()))];
					} else {
						$t_set->addLabel(['name' => $name], $g_ui_locale_id, null, true);
						$data = ['ok' => 1, 'name' => $name, 'set_id' => $t_set->getPrimaryKey(), 'item_type_singular' => Datamodel::getTableProperty($table_num, 'NAME_SINGULAR'), 'item_type_plural' => Datamodel::getTableProperty($table_num, 'NAME_PLURAL')];
					}

				}
			} else {
				$data = ['err' => _t('Invalid light box type')];
			}
			$this->view->setVar("data", $data);
			$this->render("Lightbox/browse_data_json.php");
		}
		# ------------------------------------------------------
		/**
		 *
		 */
		function edit($options = null) {
			global $g_ui_locale_id;
			if ($this->opb_is_login_redirect) {
				return;
			}

			$set_id = $this->request->getParameter('set_id', pInteger);
			$name = $this->request->getParameter('name', pString);

			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
				$t_set->replaceLabel(['name' => $name], $g_ui_locale_id, null, true);
				if ($t_set->numErrors() > 0) {
					$data = ['err' => _t('Could not save set title: %1', join("; ", $t_set->getErrors()))];
				} else{
					$data = ['ok' => 1, 'name' => $name];
				}
			} else {
				$data = ['err' => _t('Invalid set id')];
			}
			$this->view->setVar("data", $data);
			$this->render("Lightbox/browse_data_json.php");
		}
		# ------------------------------------------------------
		/**
		 *
		 */
		function delete($options = null) {
			global $g_ui_locale_id;
			if ($this->opb_is_login_redirect) {
				return;
			}

			$set_id = $this->request->getParameter('set_id', pInteger);
			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
				$t_set->delete(true);
				if ($t_set->numErrors() > 0) {
					$data = ['err' => _t('Could not delete set: %1', join("; ", $t_set->getErrors()))];
				} else{
					$data = ['ok' => 1];
				}
			} else {
				$data = ['err' => _t('Invalid set id')];
			}

			$this->view->setVar("data", $data);
			$this->render("Lightbox/browse_data_json.php");
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		public function addToLightbox() {
			global $g_ui_locale_id;
			if ($this->opb_is_login_redirect) {
				return;
			}
			$set_id = $this->request->getParameter('set_id', pInteger);

			$add_item_ids = array();
			if(($pb_saveLastResults = $this->request->getParameter('saveLastResults', pString)) || ($item_ids = $this->request->getParameter('item_ids', pString)) || ($item_id = $this->request->getParameter('item_id', pInteger))){
				if($pb_saveLastResults){
					// get object ids from last result
					$o_context = ResultContext::getResultContextForLastFind($this->request, "ca_objects");
					$add_item_ids = $o_context->getResultList();
				} elseif($item_id) {
					$add_item_ids = [$item_id];
				}else{
					$add_item_ids = explode(";", $item_ids);
				}
			}


			if ($set_id == null) {
				$table = $this->request->getParameter('table', pString);
				if ($table_num = Datamodel::getTableNum($table)) {
					$name = ($vs_tmp = $this->request->getParameter('label', pString)) ? $vs_tmp : "My ".$this->opo_config->get("lightboxDisplayName");

					$t_set = new ca_sets();
					$t_set->set([
						'type_id' => ($this->request->config->get('user_set_type')) ? $this->request->config->get('user_set_type') : 'user',
						'table_num' => $table_num,
						'user_id' => $this->request->getUserID(),
						'set_code' => caGenerateGUID(),
						'access' => 1
					]);
					$t_set->insert();
					if ($t_set->numErrors() > 0) {
						$data = ['err' => _t('Could not create new lightbox: %1', join("; ", $t_set->getErrors()))];
					} else {
						$t_set->addLabel(['name' => $name], $g_ui_locale_id, null, true);
						$t_set->addItems($add_item_ids);
						$data = ['ok' => 1, 'label' => $name, 'set_id' => $t_set->getPrimaryKey(), 'count' => $t_set->getItemCount(array('user_id' => $this->request->getUserID(), 'checkAccess' => $this->opa_access_values)), 'item_type_singular' => Datamodel::getTableProperty($table_num, 'NAME_SINGULAR'), 'item_type_plural' => Datamodel::getTableProperty($table_num, 'NAME_PLURAL')];

					}
				}else {
					$data = ['err' => _t('Cannot add to this lightbox')];
				}
			}elseif (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
				$t_set->addItems($add_item_ids);

				$data = ['ok' => 1, 'label' => $t_set->getLabelForDisplay(), 'set_id' => $t_set->getPrimaryKey(), 'count' => $t_set->getItemCount(array('user_id' => $this->request->getUserID(), 'checkAccess' => $this->opa_access_values)), 'item_type_singular' => Datamodel::getTableProperty($table_num, 'NAME_SINGULAR'), 'item_type_plural' => Datamodel::getTableProperty($table_num, 'NAME_PLURAL')];
			} else {
				$data = ['err' => _t('Cannot add to this lightbox')];
			}
			$this->view->setVar("data", $data);
			$this->render("Lightbox/browse_data_json.php");
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		public function removeFromLightbox() {
			if ($this->opb_is_login_redirect) {
				return;
			}
			$set_id = $this->request->getParameter('set_id', pInteger);
			$item_id = $this->request->getParameter('item_id', pInteger);

			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
				$t_set->removeItem($item_id);

				$data = ['ok' => 1];
			} else {
				$data = ['err' => _t('Cannot remove from this lightbox')];
			}
			$this->view->setVar("data", $data);
			$this->render("Lightbox/browse_data_json.php");
		}
		# -------------------------------------------------------
		/**
		 *
		 */
		public function getLigthboxAccessForCurrentUser() {
			if ($this->opb_is_login_redirect) {
				return;
			}
			$set_id = $this->request->getParameter('set_id', pInteger);

			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_READ_ACCESS__)) {
				
				$data = ['ok' => 1, 'access' => (($t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) ? 2 : 1)];
			} else {
				$data = ['err' => _t('Cannot load set')];
			}
			$this->view->setVar("data", $data);
			$this->render("Lightbox/browse_data_json.php");
		}
		# ------------------------------------------------------
		/**
		 *
		 */
		function getUsers($options = null) {
			global $g_ui_locale_id;
			if ($this->opb_is_login_redirect) {
				return;
			}

			$set_id = $this->request->getParameter('set_id', pInteger);
			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_READ_ACCESS__)) {
				$va_users = $t_set->getSetUsers();
				$data = ['status' => 'ok', "users" => $va_users];
			} else {
				$data = ['status' => 'error', 'err' => _t('Invalid set id')];
			}

			$this->view->setVar("data", $data);
			$this->render("Lightbox/browse_data_json.php");
		}
		
		# ------------------------------------------------------
		/**
		 *
		 */
		function shareSet($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }

 			$set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($set_id);
 			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_READ_ACCESS__)) {
			
				$vb_errors = false;
				$field_errors = [];
				$vs_display_name = caGetOption("display_name", $pa_options, $this->ops_lightbox_display_name);
				$vs_display_name_plural = caGetOption("display_name_plural", $pa_options, $this->ops_lightbox_display_name_plural);
				$ps_users = $this->purifier->purify($this->request->getParameter('users', pString));
			
				// ps_user can be list of emails separated by comma
				$va_users = explode(", ", $ps_users);
				$pn_group_id = $this->request->getParameter('group_id', pInteger);
				if(!$ps_users){
					$field_errors["users"] = _t("Please enter a user");
					$vb_errors = true;
				}
				$pn_access = $this->request->getParameter('access', pInteger);
				if(!$pn_access){
					$field_errors["access"] = _t("Please select an access level");
					$vb_errors = true;
				}
				#$vs_share_message = $this->purifier->purify($this->request->getParameter('share_message', pString));
				#$this->view->setVar('share_message', $vs_share_message);
				if(!$vb_errors){
				
						$va_error_emails = array();
						$va_success_emails = array();
						$va_error_emails_has_access = array();
					
						foreach($va_users as $vs_user){
							// lookup the user/users
							$t_user = ca_users::find(['email' => $vs_user, 'active' => 1, 'userclass' => ['<', 255]], ['returnAs' => 'firstModelInstance']);
							if($t_user && ($vn_user_id = $t_user->get("user_id"))){
								$t_sets_x_users = new ca_sets_x_users();
								if(($vn_user_id == $t_set->get("user_id")) || ($t_sets_x_users->load(array("set_id" => $t_set->get("set_id"), "user_id" => $vn_user_id)))){
									$va_error_emails_has_access[] = $vs_user;
								}else{
									$t_sets_x_users->setMode(ACCESS_WRITE);
									$t_sets_x_users->set('access',  $pn_access);
									$t_sets_x_users->set('user_id',  $vn_user_id);
									$t_sets_x_users->set('set_id',  $t_set->get("set_id"));
									$t_sets_x_users->insert();
									if($t_sets_x_users->numErrors()) {
										$va_errors["general"] = _t("There were errors while sharing this %1 with %2", $vs_display_name, $vs_user).join("; ", $t_sets_x_users->getErrors());
										$this->view->setVar('errors', $va_errors);
										$this->shareSetForm();
									}else{
										$va_success_emails[] = $vs_user;
										$va_success_emails_info[] = array("email" => $vs_user, "name" => trim($t_user->get("fname")." ".$t_user->get("lname")));
									}
								}
							}else{
								$va_error_emails[] = $vs_user;
							}
						}
						if((sizeof($va_error_emails)) || (sizeof($va_error_emails_has_access))){
							$va_user_errors = array();
							if(sizeof($va_error_emails)){
								$va_user_errors[] = _t("The following email(s) you entered do not belong to a registered user: ").implode(", ", $va_error_emails);
							}
							if(sizeof($va_error_emails_has_access)){
								$va_user_errors[] = _t("The following email(s) you entered already have access to this %1: ", $vs_display_name).implode(", ", $va_error_emails_has_access);
							}
							if(sizeof($va_success_emails)){
								$vs_message = _t('Shared %1 with: ', $vs_display_name).implode(", ", $va_success_emails);
							}
							$vs_error = implode("<br/>", $va_user_errors);
						
						}else{
							$vs_message = _t('Shared %1 with: ', $vs_display_name).implode(", ", $va_success_emails);
						}
						if(is_array($va_success_emails_info) && sizeof($va_success_emails_info)){
							// send email to user
							// send email confirmation
							$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
							$o_view->setVar("set", $t_set->getLabelForDisplay());
							$o_view->setVar("from_name", trim($this->request->user->get("fname")." ".$this->request->user->get("lname")));
							$o_view->setVar("display_name", $vs_display_name);
							$o_view->setVar("display_name_plural", $vs_display_name_plural);
							$o_view->setVar("share_message", $vs_share_message);
					
							# -- generate email subject line from template
							$vs_subject_line = $o_view->render("mailTemplates/share_set_notification_subject.tpl");
						
							# -- generate mail text from template - get both the text and the html versions
							$vs_mail_message_text = $o_view->render("mailTemplates/share_set_notification.tpl");
							$vs_mail_message_html = $o_view->render("mailTemplates/share_set_notification_html.tpl");
					
							foreach($va_success_emails as $vs_email){
								caSendmail($vs_email, $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
							}
							$this->view->setVar('data', [
								'status' => 'ok', 'message' => $vs_message, 'error' => $vs_error
							]);
						}else{
							# --- no matching emails
							$this->view->setVar('data', [
								'status' => 'err', 'error' => $vs_error
							]);
						}
				}else{
					$this->view->setVar('data', [
						'status' => 'err', 'error' => 'Please correct the errors below', 'fieldErrors' => $field_errors
					]);
				}
			}else{
				$this->view->setVar('data', ['status' => 'err', 'error' => _t('Invalid set id')]);
			}
			$this->render("Lightbox/browse_data_json.php");	
 		}
 		# -------------------------------------------------------
		/** 
		 */
 		function removeUserAccess() {
            if($this->opb_is_login_redirect) { return; }

 			$set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($set_id);
 			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {			
				$pn_user_id = $this->request->getParameter('user_id', pInteger);
				$t_item = new ca_sets_x_users();
				$t_item->load(array('set_id' => $t_set->get('set_id'), 'user_id' => $pn_user_id));
				if($t_item->get("relation_id")){
					$t_item->setMode(ACCESS_WRITE);
					$t_item->delete(true);
					if ($t_item->numErrors()) {
						$data = ['status' => 'err', 'error' => join("; ", $t_item->getErrors())];
					}else{
						$data = ['status' => 'ok', 'message' => _t("Removed user access to %1", $this->ops_lightbox_display_name)];
					}
				}else{
					$data = ['status' => 'err', 'error' => _t("invalid user/set id")];
				}
			}else{
				$data = ['status' => 'err', 'error' => _t('Invalid set id')];
			}
			$this->view->setVar('data', $data);
			$this->render("Lightbox/browse_data_json.php");
 		}
 		# -------------------------------------------------------
		/**
		 * Download (accessible) media
		 * have support for all in set (just set_id), array of hand selected in set (set_id and record_ids - string of ids separated by ;) and cache key (set_id, key, sort, sort_direction)
		 */
		public function getSetMedia() {
			$va_errors = array();
			set_time_limit(600); // allow a lot of time for this because the sets can be potentially large
			if($this->opb_is_login_redirect) { return; }

 			$set_id = $this->request->getParameter('set_id', pInteger);
 			$key = $this->request->getParameter('key', pString);
 			if($record_ids = $this->request->getParameter('record_ids', pString)){
 				$record_ids = explode(";", $record_ids);
 			}
 			
 			if(!$record_ids && $key){
 				$o_browse = caGetBrowseInstance("ca_objects");
 				$o_browse->reload($key);
 				$qr_res = $o_browse->getResults(array('sort' => $this->request->getParameter('sort', pString), 'sort_direction' => $this->request->getParameter('sort_direction', pString)));
 				$record_ids = $qr_res->getPrimaryKeyValues(1000);
 			}
 			
 			if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_READ_ACCESS__)) {			
				$va_set_record_ids = array_keys($t_set->getItemRowIDs(array('checkAccess' => $this->opa_access_values, 'limit' => 100000)));
				if(!$record_ids){
					$record_ids = $va_set_record_ids;	
				}
				if(!is_array($record_ids) || !sizeof($record_ids)) {
					$va_errors[] = _t('No media is available for download');				
				}
				$vs_subject_table = Datamodel::getTableName($t_set->get('table_num'));
				# --- lightbox is only for objects
				if($vs_subject_table != "ca_objects"){
					$va_errors[] = _t('This is not an object set');
				}
				if(sizeof($va_errors) == 0){
					$t_instance = Datamodel::getInstanceByTableName($vs_subject_table);
					if(!$qr_res){
						$qr_res = $vs_subject_table::createResultSet($record_ids);
# TODO: all media or primary?	Currenlty only primary					$qr_res->filterNonPrimaryRepresentations(false);
					}
					$va_paths = array();
					while($qr_res->nextHit()) {
						if(((is_array($this->opa_access_values)) && (sizeof($this->opa_access_values)) && ((!in_array($qr_res->get("ca_objects.access"), $this->opa_access_values)) || (!in_array($qr_res->get("ca_object_representations.access"), $this->opa_access_values)))) || (!in_array($qr_res->get("ca_objects.object_id"), $va_set_record_ids))){
							continue;
						}

						$va_rep_display_info = caGetMediaDisplayInfo('download', $qr_res->getMediaInfo('ca_object_representations.media', 'INPUT', 'MIMETYPE'));
						$vs_media_version = $va_rep_display_info['download_version'];
						$va_original_paths = $qr_res->getMediaPaths('ca_object_representations.media', 'large');
						if(sizeof($va_original_paths)>0) {
							$va_paths[$qr_res->get($t_instance->primaryKey())] = array(
								'idno' => $qr_res->get($t_instance->getProperty('ID_NUMBERING_ID_FIELD')),
								# --- this path is only the primary rep path
								'paths' => $va_original_paths,
								'rep_id' => $qr_res->get("ca_object_representations.representation_id")
							);
						}
					}
					if (sizeof($va_paths) > 0){
						$o_zip = new ZipStream();
			
						$vs_downloaded_file_naming = $this->request->config->get('downloaded_file_naming');
							
						foreach($va_paths as $vn_pk => $va_path_info) {
							$vn_c = 1;
							foreach($va_path_info['paths'] as $vs_path) {
								if (!file_exists($vs_path)) { continue; }
								$vs_idno_proc = preg_replace('![^A-Za-z0-9_\-]+!', '_', $va_path_info['idno']);
								if(!$vs_idno_proc){
									$vs_idno_proc = $vn_pk;
								}
								$vs_ext = pathinfo($vs_path, PATHINFO_EXTENSION);
								switch($vs_downloaded_file_naming) {
									case 'idno':
										$vs_file_name = $vs_idno_proc.'_'.$vn_c.'.'.$vs_ext;
										break;
									case 'idno_and_version':
										$vs_file_name = $vs_idno_proc.'_'.$vs_media_version.'_'.$vn_c.'.'.$vs_ext;
										break;
									case 'idno_and_rep_id_and_version':
										$vs_file_name = $vs_idno_proc.'_representation_'.$va_path_info['rep_id'].'_'.$vs_media_version.'.'.$vs_ext;
										break;
									case 'original_name':
									default:
										$t_rep = new ca_object_representations($va_path_info['rep_id']);
										$va_info = $t_rep->getMediaInfo('media');
										$va_rep_info = $t_rep->getMediaInfo('media', $vs_media_version);
										$vals = ['idno' => $vs_idno_proc];
										foreach(array_merge($va_rep_info, $va_info) as $k => $v) {
											if (is_array($v)) { continue; }
											if (strtolower($k) == 'original_filename') { $v = pathinfo($v, PATHINFO_FILENAME); }
											$vals[strtolower($k)] = preg_replace('![^A-Za-z0-9_\-]+!', '_', $v);
										}

										if (strpos($vs_downloaded_file_naming, "^") !== false) { // template
											$vs_file_name = caProcessTemplate($vs_downloaded_file_naming, $vals);
										} elseif ($va_info['ORIGINAL_FILENAME']) {
											$va_tmp = explode('.', $va_info['ORIGINAL_FILENAME']);
											if (sizeof($va_tmp) > 1) { 
												if (strlen($vs_ext = array_pop($va_tmp)) < 3) {
													$va_tmp[] = $vs_ext;
												}
											}
											$vs_file_name = join('_', $va_tmp); 					
										} else {
											$vs_file_name = $vs_idno_proc.'_representation_'.$va_path_info['rep_id'].'_'.$vs_media_version;
										}
						
										if (isset($va_file_names[$vs_file_name.'.'.$vs_ext])) {
											$vs_file_name.= "_{$vn_c}";
										}
										$vs_file_name .= '.'.$vs_ext;
										break;
								}			
								
								$o_zip->addFile($vs_path, $vs_file_name);

								$vn_c++;
							}
						}

						// send files
						$this->view->setVar('zip_stream', $o_zip);
						$this->view->setVar('archive_name', 'media_for_'.mb_substr(preg_replace('![^A-Za-z0-9]+!u', '_', ($vs_set_code = $t_set->get('set_code')) ? $vs_set_code : $t_set->getPrimaryKey()), 0, 20).'.zip');
						$this->render('bundles/download_file_binary.php');
						return;
					} else {
						$data = ['status' => 'err', 'error' => _t('No media is available for download')];
					}


				}else{
					$data = ['status' => 'err', 'error' => _t("There was an error").": ".join($va_errors, "; ")];
				}
			}else{
				$data = ['status' => 'err', 'error' => _t('Invalid set id')];
			}
			$this->view->setVar('data', $data);
			$this->render("Lightbox/browse_data_json.php");

		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
			return [
				'module_path' => '',
				'controller' => 'Lightbox',
				'action' => 'Index',
				'params' => []
			];
 		}
 		# -------------------------------------------------------
 	}
