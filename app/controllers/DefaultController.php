<?php
/* ----------------------------------------------------------------------
 * controllers/DefaultController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2016 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
	require_once(__CA_MODELS_DIR__.'/ca_site_pages.php');
	require_once(__CA_MODELS_DIR__.'/ca_site_templates.php');
 
 	class DefaultController extends BasePawtucketController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			caSetPageCSSClasses(array("staticPage"));
 		}
 		# -------------------------------------------------------
 		public function __call($ps_method, $pa_path) {
 			$this->view->setVar('response', $this->response);
 			
 			array_unshift($pa_path[0], $ps_method);
 			
 			if ($vs_content = ca_site_pages::renderPageForPath($this, $vs_path = "/".trim(join("/", $pa_path[0]), "/"), ['incrementViewCount' => true, 'checkAccess' => caGetUserAccessValues($this->request)])) {
 				$this->response->addContent($vs_content);
 				return;
 			}
 			$this->render(join("/", $pa_path[0]).".php", false);
 		}
 		# ------------------------------------------------------
 	}
