<?php
/* ----------------------------------------------------------------------
 * pawtucket2/app/controllers/CollectionController.php : controller for Collection detail page
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_collections.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_relationship_types.php");
 	require_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");
 	require_once(__CA_LIB_DIR__.'/ca/Browse/OccurrenceBrowse.php');
 	require_once(__CA_LIB_DIR__.'/pawtucket/BaseDetailController.php');
 	
 	class CollectionController extends BaseDetailController {
 		# -------------------------------------------------------
 		/** 
 		 * Number of similar items to show
 		 */
 		 protected $opn_similar_items_per_page = 12;
 		 /**
 		 * Name of subject table (ex. for a collection search this is 'ca_collections')
 		 */
 		protected $ops_tablename = 'ca_collections';
 		
 		protected $opa_sorts;
 		
 		/**
 		 * Name of application (eg. providence, pawtucket, etc.)
 		 */
 		protected $ops_appname = 'pawtucket2';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		 	parent::__construct($po_request, $po_response, $pa_view_paths);
		 	
		 	// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
            }		
 		}
 		# -------------------------------------------------------
 		/**
 		 * shows the basic info for a collection
 		 */ 
 		public function Show() {
 			parent::Show();
 		}
 		# -------------------------------------------------------
 	}
 ?>
