<?php
/* ----------------------------------------------------------------------
 * controllers/CollectionController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/core/ApplicationError.php"); 
	require_once(__CA_LIB_DIR__."/ca/BasePluginController.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_LIB_DIR__.'/ca/Search/CollectionSearch.php');
 	require_once(__CA_MODELS_DIR__.'/ca_collections.php');
 
 	class CollectionController extends BasePluginController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			 if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
 			
 			caSetPageCSSClasses(array("findingaid"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function Index() {
 			$this->view->setVar('t_collection', new ca_collections());
 			$this->view->setVar('display_template', $this->config->get('display_template'));
 			$this->view->setVar('ancestor_template', $this->config->get('ancestor_template'));
 			$this->view->setVar('page_title', $this->config->get('page_title'));
 			$this->view->setVar('intro_text', $this->config->get('intro_text'));
 			$this->view->setVar('open_by_default', $this->config->get('open_by_default'));
 			
 			
			$va_user_access = caGetUserAccessValues($this->request);
			$t_parent = new ca_collections();
 			if (!($pn_parent_id = $this->request->getParameter('id', pInteger))) { 
				$pn_parent_id = null; 
				$t_parent = null;
			} else {
				if ($t_parent->load($pn_parent_id)) {
					if (!in_array($t_parent->get('access'), $va_user_access)) { 
						$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2500?r='.urlencode($this->request->getFullUrlPath()));
						return;
					}
				} else {
					$t_parent = null; $pn_parent_id = null;
				}
			}
			
			$this->view->setVar('parent_id', $pn_parent_id);
			$this->view->setVar('t_parent', $t_parent);
 			
 			$va_restrict_to_types = explode(", ", $this->config->get('restrict_to_types'));
			$vs_restrict_types = '"'.implode('", "', $va_restrict_to_types).'"';	
			$this->view->setVar('restrict_to_types', $vs_restrict_types);
					
 			$this->render("index_html.php");
 		}
 		# ------------------------------------------------------
 	}