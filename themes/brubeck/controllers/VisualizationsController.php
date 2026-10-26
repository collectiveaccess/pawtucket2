<?php
/* ----------------------------------------------------------------------
 * app/controllers/GalleryController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_object_representations.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class VisualizationsController extends BasePawtucketController {
 		# -------------------------------------------------------
  		/**
 		 *
 		 */ 
 		public function __construct(&$request, &$response, $view_paths=null) {
 			parent::__construct($request, $response, $view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
 			$this->config = caGetDetailConfig();
 		}
 		# -------------------------------------------------------
		/**
 		 *
 		 */ 
		public function getTourInfoAsJSON() {
			$tour_id = $this->getRequest()->getParameter('tour_id', pInteger);
			$t_tour = new ca_occurrences($tour_id);
			if(!$t_tour->get("ca_occurrences.occurrence_id")){
				throw new ApplicationException("Invalid tour id");
			}
 			$qr_appearances = caMakeSearchResult(
				"ca_occurrences",
				$t_tour->get("ca_occurrences.related.occurrence_id", array("returnAsArray" => true, "restrictToTypes" => array("appearance"), "restrictToRelationshipTypes" => array("included"), "checkAccess" => $this->opa_access_values)),
				['checkAccess' => $this->opa_access_values]
			);

			$this->getView()->setVar('appearances', $qr_appearances);
			$this->getView()->setVar('tour', $t_tour);

			$this->render('Details/tour_detail_storymap_json.php');
		}
 		# -------------------------------------------------------
	}
