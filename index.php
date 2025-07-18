<?php
/* ----------------------------------------------------------------------
 * index.php : primary application controller for cataloguing module
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2025 Whirl-i-Gig
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
define("__CA_APP_TYPE__", "PAWTUCKET");
define("__CA_MICROTIME_START_OF_REQUEST__", microtime());
define("__CA_SEARCH_IS_FOR_PUBLIC_DISPLAY__", 1);
define("__CA_BASE_MEMORY_USAGE__", memory_get_usage(true));

require("./app/helpers/errorHelpers.php");

if (!file_exists('./setup.php')) {
	caDisplayException(new ApplicationException("No setup.php found"));
	exit; 
}
require_once('./setup.php');

try {
	// connect to database
	$o_db = new Db(null, null, false);
	if (!$o_db->connected()) {
		$opa_error_messages = array("Could not connect to database. Check your database configuration in <em>setup.php</em>.");
		require_once(__CA_BASE_DIR__."/themes/default/views/system/configuration_error_html.php");
		exit();
	}
	//
	// do a sanity check on application and server configuration before servicing a request
	//
	require_once(__CA_APP_DIR__.'/lib/pawtucket/ConfigurationCheck.php');
	ConfigurationCheck::performQuick();
	if(ConfigurationCheck::foundErrors()){
		ConfigurationCheck::renderErrorsAsHTMLOutput();
		exit();
	}

	// run garbage collector
	GarbageCollection::gc();

	$app = AppController::getInstance();

	$g_request = $app->getRequest();
	$resp = $app->getResponse();
	
	if (($g_request->getController() !== 'Ban') && !BanHammer::verdict($g_request)) {
		if(!$g_request->isAjax()) {
			Session::setVar('pawtucket2_page_at_ban', $g_request->getFullUrlPath());
		}
		$g_request->setInternalRedirect(['module' => '', 'controller' => 'Ban', 'action' => 'verify']);
	}

	// TODO: move this into a library so $_, $g_ui_locale_id and $g_ui_locale gets set up automatically
	require_once(__CA_APP_DIR__."/helpers/initializeLocale.php");
	$va_ui_locales = $g_request->config->getList('ui_locales');
	if ($vs_lang = $g_request->getParameter('lang', pString)) {
		if (in_array($vs_lang, $va_ui_locales)) {
			Session::setVar('lang', $vs_lang);
		}
	}
	if (!($g_ui_locale = Session::getVar('lang'))) {
		$g_ui_locale = $va_ui_locales[0];
	}

	if (!in_array($g_ui_locale, $va_ui_locales)) {
		$g_ui_locale = $va_ui_locales[0];
	}
	
	$t_locale = new ca_locales();
	$g_ui_locale_id = $t_locale->localeCodeToID($g_ui_locale);		// get current UI locale as locale_id	  (available as global)
	if($vs_lang || (!isset($_locale)) || (isset($_COOKIE['CA_'.__CA_APP_NAME__.'_ui_locale']) && ($g_ui_locale != $_COOKIE['CA_'.__CA_APP_NAME__.'_ui_locale']))) {
		if(!initializeLocale($g_ui_locale)) die("Error loading locale ".$g_ui_locale);
		$g_request->reloadAppConfig();	// need to reload app config to reflect current locale
	}
	
	//
	// PageFormat plug-in generates header/footer shell around page content
	//
	if (!$g_request->isAjax() && !$g_request->isDownload()) {
		require_once(__CA_LIB_DIR__.'/pawtucket/PageFormat.php');
		$app->registerPlugin(new PageFormat());
	} else {
		require_once(__CA_LIB_DIR__.'/pawtucket/AjaxFooter.php');
		$app->registerPlugin(new AjaxFooter());
	}

	//
	// ContentCaching plug-in caches output of selected pages for performance
	//
	require_once(__CA_LIB_DIR__.'/ContentCaching.php');
	$app->registerPlugin(new ContentCaching());

	//
	// Load mobile
	//
	if (caDeviceIsMobile()) { AssetLoadManager::register('mobile'); }

	// Prevent caching
	$resp->addHeader("Cache-Control", "no-cache, no-store, must-revalidate");
	$resp->addHeader("Expires", "Mon, 26 Jul 1997 05:00:00 GMT");
	
	//
	// Output configurable headers from headers.conf
	//
	caEmitHeaders($resp);
	
	//
	// Don't try to authenticate when doing a login attempt or trying to access the 'forgot password' feature
	// Do try to authenticate when login is required or session has a user_id set (may have been set by single-sign-on)
	//
	if (((bool)$g_request->config->get('pawtucket_requires_login') || (Session::$s_session_vars[__CA_APP_NAME__.'_user_id'])) && ((!preg_match("/^[\/]{0,1}system\/auth\/callback/", strtolower($g_request->getPathInfo()))) || !preg_match("/^[\/]{0,1}system\/auth\/(dologin|login|forgot|requestpassword|initreset|doreset|callback)/", strtolower($g_request->getPathInfo())))) {
		$vb_auth_success = $g_request->doAuthentication(array('dont_redirect' => true, 'noPublicUsers' => false, 'allow_external_auth' => ($g_request->getController() == 'LoginReg')));
	}
	$app->dispatch(true);

	//
	// Send output to client
	//
	$resp->sendResponse();

	// Note url of this page as "last page"
	// the 'dont_set_pawtucket2_last_page' is a lame-but-effective way of suppressing recording of something we don't want to be a "last page" (and potentially redirected to)
	if (($resp->getHTTPResponseCode() == 200) && (!in_array($g_request->getController(), ['LoginReg', 'Ban']) && (!$g_request->isAjax()) && (!$g_request->getParameter('dont_set_pawtucket2_last_page', pInteger)))) {	
		Session::setVar('pawtucket2_last_page', $g_request->getFullUrlPath());
	}
	$g_request->close();
} catch (Exception $e) {
	caDisplayException($e);
}
