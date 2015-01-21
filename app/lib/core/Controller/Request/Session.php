<?php
/** ---------------------------------------------------------------------
 * app/lib/core/Controller/Request/Session.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2000-2015 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  *
  */
 
require_once(__CA_LIB_DIR__."/core/Error.php");
require_once(__CA_LIB_DIR__."/core/Configuration.php");
require_once(__CA_LIB_DIR__."/core/Db.php");
require_once(__CA_APP_DIR__."/helpers/utilityHelpers.php");

class Session {
	# ----------------------------------------
	# --- Properties
	# ----------------------------------------
	private $domain = ""; 	# domain session is registered to (eg. "www.whirl-i-gig.com"); blank means domain cookie was set from
	private $lifetime = 0;	# session lives for $lifetime minutes; session exists for entire browser session if 0
	private $name = "";		# application name

	private $start_time = 0;	# microtime session object was created - used for page performance measurements
	
	# ----------------------------------------
	# --- Constructor
	# ----------------------------------------
	/**
	 * @param string $ps_app_name An app name to use if no app name is configured in the application configuration file.
	 * @param bool $pb_dont_create_new_session No new session will be created if set to true. Default is false.
	 */
	public function __construct($ps_app_name=null, $pb_dont_create_new_session=false) {
 		$o_config = Configuration::load();
		# --- Init
		if (defined("__CA_MICROTIME_START_OF_REQUEST__")) {
			$this->start_time = __CA_MICROTIME_START_OF_REQUEST__;
		} else {
			$this->start_time = microtime();
		}
		
		# --- Read configuration
		$this->name = ($vs_app_name = $o_config->get("app_name")) ? $vs_app_name : $ps_app_name;
		$this->domain = $o_config->get("session_domain");
		$this->lifetime = (int) $o_config->get("session_lifetime");

		if(!$this->lifetime) {
			$this->lifetime = 3600 * 24 * 7;
		}
		
		if (!$pb_dont_create_new_session) {
			if (!($vs_key = $this->getSessionID())) {
				$vs_cookiepath = ((__CA_URL_ROOT__== '') ? '/' : __CA_URL_ROOT__);
				if (!caIsRunFromCLI()) { setcookie($this->name, $_COOKIE[$this->name] = $vs_session_id = caGenerateGUIDV4(), $this->lifetime ? time() + $this->lifetime : null, $vs_cookiepath); }
		 	}
		 	
			// initialize session var storage
			if($vs_key && !ExternalCache::contains($vs_key, 'SessionVars')) {
				ExternalCache::save($vs_key, array(), 'SessionVars', $this->lifetime);
			}
		}
	}
	# ----------------------------------------
	# --- Methods
	# ----------------------------------------
	/**
	 * Returns client's session_id. 
	 */
	public function getSessionID () {
		if (isset($_COOKIE[$this->name]) && $_COOKIE[$this->name]) { return $_COOKIE[$this->name]; }
		
		// If client doesn't support cookies and connects repeatedly then we'll end up creating a session for
		// each connection. GoogleSearch appliances do this.
		//
		// To avoid this we keep track of connections by IP address and if it connects without a session cookie 
		// too many times in a given period we force it to a fixed session key
		if (!is_array($va_ip_list = ExternalCache::fetch('ipList', 'SessionVars'))) { $va_ip_list = array(); }
		if (!is_array($va_ip_last_seen = ExternalCache::fetch('ipLastSeen', 'SessionVars'))) { $va_ip_last_seen = array(); }
		if (!is_array($va_ip_session_keys = ExternalCache::fetch('ipSessionKeys', 'SessionVars'))) { $va_ip_session_keys = array(); }
		if (isset($va_ip_last_seen[$_SERVER['REMOTE_ADDR']]) && ((time() - $va_ip_last_seen[$_SERVER['REMOTE_ADDR']]) > (60*60*4))) {	// 4 hour window
			$va_ip_list[$_SERVER['REMOTE_ADDR']] = 0;
		}
		$va_ip_list[$_SERVER['REMOTE_ADDR']]++;
		$va_ip_last_seen[$_SERVER['REMOTE_ADDR']] = time();
		
		if($vs_key && ($va_ip_list[$_SERVER['REMOTE_ADDR']] > 5)) {
			$va_ip_session_keys[$_SERVER['REMOTE_ADDR']] = caGenerateGUIDV4();
		}
		
		ExternalCache::save('ipList', $va_ip_list, 'SessionVars', 60 * 60 * 24);				// ip lists persist for 24 hours
		ExternalCache::save('ipLastSeen', $va_ip_last_seen, 'SessionVars', 60 * 60 * 24);
		ExternalCache::save('ipSessionKeys', $va_ip_session_keys, 'SessionVars', 60 * 60 * 24);
	
		return (isset($va_ip_session_keys[$_SERVER['REMOTE_ADDR']]) && $va_ip_session_keys[$_SERVER['REMOTE_ADDR']]) ? $va_ip_session_keys[$_SERVER['REMOTE_ADDR']] : null;
	}
	# ----------------------------------------
	/**
	 * Removes session. Session key is no longer valid after this operation.
	 * Useful for logging out users (destroying the session destroys the login)
	 */
	public function deleteSession() {
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()- (24 * 60 * 60),'/');
		}
		// Delete session data
		ExternalCache::delete($this->getSessionID(), 'SessionVars');
		
		// Delete ip tracking
		if (!is_array($va_ip_list = ExternalCache::fetch('ipList', 'SessionVars'))) { $va_ip_list = array(); }
		if (!is_array($va_ip_last_seen = ExternalCache::fetch('ipLastSeen', 'SessionVars'))) { $va_ip_last_seen = array(); }
		if (!is_array($va_ip_session_keys = ExternalCache::fetch('ipSessionKeys', 'SessionVars'))) { $va_ip_session_keys = array(); }
		unset($va_ip_list[$_SERVER['REMOTE_ADDR']]);
		unset($va_ip_last_seen[$_SERVER['REMOTE_ADDR']]);
		unset($va_ip_session_keys[$_SERVER['REMOTE_ADDR']]);
		ExternalCache::save('ipList', $va_ip_list, 'SessionVars', 60 * 60 * 24);
		ExternalCache::save('ipLastSeen', $va_ip_last_seen, 'SessionVars', 60 * 60 * 24);
		ExternalCache::save('ipSessionKeys', $va_ip_session_keys, 'SessionVars', 60 * 60 * 24);
		
		session_destroy();
	}
	# ----------------------------------------
	/**
	 * Set session variable
	 * Sesssion var may be number, string or array
	 */
	public function setVar($ps_key, $pm_val, $pa_options=null) {
		if (!is_array($pa_options)) { $pa_options = array(); }
		
		if ($ps_key && $this->getSessionID()) {
			$va_vars = ExternalCache::fetch($this->getSessionID(), 'SessionVars');
			if (isset($pa_options["ENTITY_ENCODE_INPUT"]) && $pa_options["ENTITY_ENCODE_INPUT"]) {
				if (is_string($pm_val)) {
					$vm_val = html_entity_decode($pm_val);
				} else {
					$vm_val = $pm_val;
				}
			} else {
				if (isset($pa_options["URL_ENCODE_INPUT"]) && $pa_options["URL_ENCODE_INPUT"]) {
					$vm_val = urlencode($pm_val);
				} else {
					$vm_val = $pm_val;
				}
			}
			$va_vars[$ps_key] = $vm_val;
			ExternalCache::save($this->getSessionID(), $va_vars, 'SessionVars', $this->lifetime);
			return true;
		}
		return false;
	}
	# ----------------------------------------
	/**
	 * Delete session variable
	 */
	public function delete ($ps_key) {
		$va_vars = ExternalCache::fetch($this->getSessionID(), 'SessionVars');
		unset($va_vars[$ps_key]);
		ExternalCache::save($this->getSessionID(), $va_vars, 'SessionVars', $this->lifetime);
	}
	# ----------------------------------------
	/**
	 * Get value of session variable. Var may be number, string or array.
	 */
	public function getVar($ps_key) {
		if(!$this->getSessionID()) { return null; }

		if(ExternalCache::contains($this->getSessionID(), 'SessionVars')) {
			$va_vars = ExternalCache::fetch($this->getSessionID(), 'SessionVars');
			return isset($va_vars[$ps_key]) ? $va_vars[$ps_key] : null;
		}
		return null;
	}
	# ----------------------------------------
	/**
	 * Return names of all session vars
	 */
	public function getVarKeys() {
		if(ExternalCache::contains($this->getSessionID(), 'SessionVars')) {
			$va_vars = ExternalCache::fetch($this->getSessionID(), 'SessionVars');
			return array_keys($va_vars);
		}
		return array();
	}
	# ----------------------------------------
	/**
	 * Close session
	 */
	public function close() {
		// NOOP
	}
	# ----------------------------------------
	# --- Page performance
	# ----------------------------------------
	# Return number of seconds since request processing began
	public function elapsedTime($pn_decimal_places=4) {
		list($sm, $st) = explode(" ", $this->start_time);
		list($em, $et) = explode(" ",microtime());

		return sprintf("%4.{$pn_decimal_places}f", (($et+$em) - ($st+$sm)));
	}
	# ----------------------------------------
}