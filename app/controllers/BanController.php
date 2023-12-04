<?php
/* ----------------------------------------------------------------------
 * controllers/BanController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2023 Whirl-i-Gig
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

class BanController extends BasePawtucketController {
	# -------------------------------------------------------
	 
	# -------------------------------------------------------
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		caSetPageCSSClasses(array("banPage"));
	}
	# -------------------------------------------------------
	public function __call($method, $path) {
		$this->view->setVar('errors', []);
		$this->render("Ban/verify_html.php", false);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function confirm() {
		try {
			caVerifyCaptcha($this->request->getParameter("g-recaptcha-response", pString));
			
			ca_ip_whitelist::whitelist($this->request, 24*60*60, 'Captcha');	// white list for 24 hours
			if(!($url = Session::getVar('pawtucket2_last_page'))) {
				$url = caNavUrl($this->request, '', 'Front', 'Index');
			}
			$this->response->setRedirect($url);
		} catch(CaptchaException $e) {
			$this->view->setVar('errors', [$e->getMessage()]);
			$this->render("Ban/verify_html.php", false);
		}
	}
	# -------------------------------------------------------
}
