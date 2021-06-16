<?php
/* ----------------------------------------------------------------------
 * controllers/CookiesController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2016 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/CookieOptionsManager.php');

class CookiesController extends BasePawtucketController {
	# -------------------------------------------------------
	
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		caSetPageCSSClasses(["cookies"]);
		
		if(!CookieOptionsManager::cookieManagerEnabled()){
			$this->notification->addNotification(_t('Cookie manager is not enabled'), __NOTIFICATION_TYPE_ERROR__);
			$this->response->setRedirect(caNavUrl($this->request, '', 'Front', 'Index'));
		}
		
		$this->config = caGetCookiesConfig();
		$this->view->setVar('config', $this->config);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function manage() {
		$this->view->setVar('cookiesByCategory', CookieOptionsManager::cookieList());
		
		if($accept = (bool)$this->request->getParameter("accept", pInteger)) {
			CookieOptionsManager::allowAll();
			$this->response->setRedirect(Session::getVar('pawtucket2_last_page'));	
		}
		$this->render("Cookies/form_manage_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	public function save() {
		$this->notification->addNotification(_t('Saved settings'), __NOTIFICATION_TYPE_INFO__);
	
		
		$accept_all = (bool)$this->request->getParameter("accept_all", pInteger);
		
		foreach(CookieOptionsManager::cookieList() as $category_code => $category_info) {
			if($accept || $accept_all || !is_null($allow = $this->request->getParameter("cookie_options_{$category_code}", pInteger))) {
				CookieOptionsManager::set($category_code, $accept_all ? 1 : $allow);
			}
		}
		return $this->manage();
	}
	# ------------------------------------------------------
}
