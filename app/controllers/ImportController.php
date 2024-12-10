<?php
/* ----------------------------------------------------------------------
 * controllers/ImportController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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
require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
require_once(__CA_LIB_DIR__.'/Service/GraphQLServiceController.php');

class ImportController extends BasePawtucketController {
	# -------------------------------------------------------
	
	# -------------------------------------------------------
	/**
	 * @param RequestHTTP $request
	 * @param ResponseHTTP $response
	 * @param null $view_paths
	 * @throws ApplicationException
	 */
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		
		if (!($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
			$this->opb_is_login_redirect = true;
			return;
		}
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function Index($options = null) {
		if($this->opb_is_login_redirect) { return; }
		
		// API key
		$this->view->setVar('key', GraphQLServices\GraphQLServiceController::encodeJWTRefresh(['id' => $this->request->user->getPrimaryKey()]));
		
		$this->render("Import/index_html.php");
	}
	# -------------------------------------------------------
	# Services
	# -------------------------------------------------------
	/**
	 * tus resume-able file upload API endpoint (see https://tus.io and https://github.com/ankitpokhrel/tus-php)
	 */
	public function tus(){
		$user_id = $this->request->getUserID();

		$server = MediaUploadManager::getTUSServer($user_id);
		try {
			$response = $server->serve();
			$response->send();
		} catch(Exception $e) {
			// Delete all files
			$request = $server->getRequest();
			$key = $request->header('x-session-key');

			if ($session = MediaUploadManager::findSession($key, $user_id)) {
				if(is_array($progress_data = $session->get('progress'))) {
					foreach(array_keys($progress_data) as $f) {
						@unlink($f);
					}	
				}
			}

			// Return error
			AppController::getInstance()->removeAllPlugins();
			http_response_code(401);
			header("Tus-Resumable: 1.0.0");
			$this->view->setVar('response', ['error' => $e->getMessage(), 'global' => true, 'state' => 'quota']);
			$this->render('Import/response_json.php');
			return;
		}
	}
	# -------------------------------------------------------
}
