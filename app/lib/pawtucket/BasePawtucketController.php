<?php
/* ----------------------------------------------------------------------
 * app/lib/pawtucket/BasePawtucketController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2025 Whirl-i-Gig
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
 	
class BasePawtucketController extends ActionController {
	# ------------------------------------------------------- 	
	/**
	 * @var array
	 */
	protected $opa_access_values;
	
	/**
	 *
	 */
	protected $dont_require_login = false;
	# -------------------------------------------------------
	public function __construct($request, $response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		if (!$this->dont_require_login && ($request->getController() !== 'LoginReg') && $request->config->get('pawtucket_requires_login') && !($request->isLoggedIn())) {
			$response->setRedirect(caNavUrl($request, "", "LoginReg", "LoginForm"));
		}
		
		$this->opa_access_values = caGetUserAccessValues($request);
		$this->view->setVar("access_values", $this->opa_access_values);
	}
	# -------------------------------------------------------
}
