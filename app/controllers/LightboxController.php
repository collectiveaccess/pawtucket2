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
 			caSetPageCSSClasses(["lightbox"]);
 			
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
			// TODO: generalize this
			$browse_info = [
				'displayName' => _('Archive'),
				'labelSingular' => _("item"),
 				'labelPlural' =>  _("items"),
				'table' => 'ca_objects',

				'restrictToTypes' => [],
				'availableFacets' => [],
				'facetGroup' => 'archive',

				'itemsPerPage' => 12,

				'views' => [
					'images' => [
						'representation' => "<ifdef code='ca_object_representations.media.small.url'>^ca_object_representations.media.small.url</ifdef><ifnotdef code='ca_object_representations.media.small.url'>/themes/noguchi/assets/pawtucket/graphics/placeholder.png</ifnotdef>",
			    		'caption' => "^ca_objects.preferred_labels.name",
			    		'caption2' => " ^ca_objects.idno"
						]
					],
				
				'sortBy' => [
					'Date' => 'ca_objects.date.parsed_date;ca_objects.idno'
				],
				'sortDirection' => [
							'Date' => 'asc'
				],
				'excludeFieldsFromSearch' => ['ca_objects.internal_notes']
			];
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
						'type_id' => 'public_presentation',
						'table_num' => $table_num,
						'user_id' => $this->request->getUserID(),
						'set_code' => mb_substr(preg_replace("![^A-Za-z0-9\-_]+!", "_", $name), 0, 30),
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
			global $$g_ui_locale_id;
			if ($this->opb_is_login_redirect) {
				return;
			}
			$set_id = $this->request->getParameter('set_id', pInteger);
			$item_id = $this->request->getParameter('item_id', pInteger);

			if ($set_id == null) {
				$table = $this->request->getParameter('table', pString);
				if ($table_num = Datamodel::getTableNum($table)) {
					$name = "My documents";

					$t_set = new ca_sets();
					$t_set->set([
						'type_id' => 'public_presentation',
						'table_num' => $table_num,
						'user_id' => $this->request->getUserID(),
						'set_code' => mb_substr(preg_replace("![^A-Za-z0-9\-_]+!", "_", $name), 0, 30),
						'access' => 1
					]);
					$t_set->insert();
					if ($t_set->numErrors() > 0) {
						$data = ['err' => _t('Could not create new lightbox: %1', join("; ", $t_set->getErrors()))];
					} else {
						$t_set->addLabel(['name' => $name], $g_ui_locale_id, null, true);
						$t_set->addItem($item_id);
						$data = ['ok' => 1, 'label' => $name, 'set_id' => $t_set->getPrimaryKey(), 'count' => 1, 'item_type_singular' => Datamodel::getTableProperty($table_num, 'NAME_SINGULAR'), 'item_type_plural' => Datamodel::getTableProperty($table_num, 'NAME_PLURAL')];

					}
				}else {
					$data = ['err' => _t('Cannot add to this lightbox')];
				}
			}elseif (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_EDIT_ACCESS__)) {
				$t_set->addItem($item_id);

				$data = ['ok' => 1];
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
		 * Generate the URL for the "back to results" link from a browse result item
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($po_request) {
			return [
				'module_path' => '',
				'controller' => 'Lightbox',
				'action' => 'index/last',
				'params' => []
			];
 		}
 		# -------------------------------------------------------
 	}
