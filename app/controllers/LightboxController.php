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
 	require_once(__CA_APP_DIR__."/controllers/FindController.php");
 	require_once(__CA_LIB_DIR__."/GeographicMap.php");
	require_once(__CA_LIB_DIR__.'/Parsers/ZipStream.php');
	require_once(__CA_LIB_DIR__.'/Logging/Downloadlog.php');
 
 	class LightboxController extends FindController {
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
 		function index($pa_options = null) {
 			if($this->opb_is_login_redirect) { return; }

			$va_lightbox_displayname = caGetLightboxDisplayName();
			$this->view->setVar('lightbox_displayname', $va_lightbox_displayname["singular"]);
			$this->view->setVar('lightbox_displayname_plural', $va_lightbox_displayname["plural"]);

            # Get sets for display
            $t_sets = new ca_sets();
 			$va_read_sets = $t_sets->getSetsForUser(array("user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "access" => (!is_null($vn_access = $this->request->config->get('lightbox_default_access'))) ? $vn_access : 1, "parents_only" => true));
 			$va_write_sets = $t_sets->getSetsForUser(array("user_id" => $this->request->getUserID(), "checkAccess" => $this->opa_access_values, "parents_only" => true));

 			# Remove write sets from the read array
 			$va_read_sets = array_diff_key($va_read_sets, $va_write_sets);

            $this->view->setVar("read_sets", $va_read_sets);
 			$this->view->setVar("write_sets", $va_write_sets);

//            $va_set_ids = array_merge(array_keys($va_read_sets), array_keys($va_write_sets));
// 			$this->view->setVar("set_ids", $va_set_ids);

            MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").ucfirst($this->ops_lightbox_display_name));
 			
 			$this->render(caGetOption("view", $pa_options, "Lightbox/list_html.php"));
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function view($pa_options = null) {
			if ($this->opb_is_login_redirect) {
				return;
			}
			$this->render("Lightbox/contents_html.php");
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
				'action' => 'view',
				'params' => []
			];
 		}
 		# -------------------------------------------------------
 	}
