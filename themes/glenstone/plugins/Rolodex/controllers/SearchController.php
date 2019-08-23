<?php
/* ----------------------------------------------------------------------
 * controllers/CollectionController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
	require_once(__CA_LIB_DIR__."/BasePluginController.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');
 	require_once(__CA_MODELS_DIR__.'/ca_entities.php');
 
 	class SearchController extends BasePluginController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
  		 	if ($po_request->config->get('pawtucket_requires_login')&&!($po_request->isLoggedIn())) {
                $po_response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            			
            $this->ops_theme = __CA_THEME__;	
           															// get current theme
 			if(!is_dir(__CA_BASE_DIR__.'/themes/glenstone/plugins/Rolodex/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			parent::__construct($po_request, $po_response, array(__CA_BASE_DIR__.'/themes/glenstone/plugins/Rolodex/themes/'.$this->ops_theme.'/views'));
 			
 			caSetPageCSSClasses(array("rolodex"));
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function Index() {
 			$ps_forename = $this->request->getParameter('forename', pString);
 			$ps_surname = $this->request->getParameter('surname', pString);
 			$ps_org = $this->request->getParameter('organization', pString);
 			
 			$va_fields = array('ca_entity_labels.forename' => 'forename', 'ca_entity_labels.surname' => 'surname', 'ca_entities.affiliation' =>'organization');
 			
 			$va_search_terms = array();
 			foreach($va_fields as $vs_qualifier => $vs_field) {
 				if ($vs_term = $this->request->getParameter($vs_field, pString)) {
 					$va_search_terms[] = "{$vs_qualifier}:\"{$vs_term}\"";
 				}
 			}
 			
 			if (sizeof($va_search_terms) > 0) { 
 				$o_search = new EntitySearch();
 				$this->view->setVar('results', $o_search->search(join(" AND ", $va_search_terms), array('sort' => 'ca_entity_labels.surname;ca_entity_labels.forename')));
 			}
 			$this->render("index_html.php");
 		}
 		# ------------------------------------------------------
 	}