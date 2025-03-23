<?php
/* ----------------------------------------------------------------------
 * controllers/DefaultController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2025 Whirl-i-Gig
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

class DefaultController extends BasePawtucketController {
	# -------------------------------------------------------
	 
	# -------------------------------------------------------
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		caSetPageCSSClasses(array("staticPage"));
	}
	# -------------------------------------------------------
	public function __call($method, $path) {
		global $g_ui_locale_id;
		
		$this->view->setVar('response', $this->response);
		
		array_unshift($path[0], $method);
		
		if(!($content = ca_site_pages::renderPageForPath($this, "/".trim(join("/", $path[0]), "/"), ['locale_id' => $g_ui_locale_id, 'incrementViewCount' => true, 'checkAccess' => caGetUserAccessValues($this->request)]))) {
			if($path[0][sizeof($path[0])-1] === '_default') {
				$def_path = $path[0];
				array_pop($def_path);
				$content = $content = ca_site_pages::renderPageForPath($this, "/".trim(join("/", $def_path), "/"), ['incrementViewCount' => true, 'checkAccess' => caGetUserAccessValues($this->request)]);
			}
		}
		if ($content) {
			$this->response->addContent($content);
			return;
		}
		
		if($this->viewExists($v = join("/", $path[0]).".php")) {
			$this->render($v, false);
		} else {
			$this->response->addContent($m = _t('Page is not available'));
			$this->response->setHTTPResponseCode(404, $m);
		}
	}
	# ------------------------------------------------------
}
