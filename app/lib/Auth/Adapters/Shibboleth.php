<?php
/** ---------------------------------------------------------------------
 * app/lib/Auth/Adapters/Shibboleth.php : default authentication backend
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2018-2022 Whirl-i-Gig
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
 * @subpackage Auth
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
require_once('/var/simplesamlphp/lib/_autoload.php');
require_once(__CA_LIB_DIR__.'/Auth/BaseAuthAdapter.php');
require_once(__CA_MODELS_DIR__.'/ca_users.php');

class ShibbolethAuthAdapter extends BaseAuthAdapter implements IAuthAdapter {
    public function __construct(){
    	if(caIsRunFromCLI()) { return; }

        $this->auth_config = Configuration::load(__CA_APP_DIR__."/conf/authentication.conf");
        $shibSP = $this->auth_config->get('shibboleth_service_provider');
        try{
                $this->shibAuth = new \SimpleSAML\Auth\Simple($shibSP);
        } catch (Exception $e) {
                throw new ShibbolethException("Could not create SimpleSAML auth object: ".$e->getMessage());
        }
    }
	# --------------------------------------------------------------------------------
	public function authenticate($username, $password = '', $options=null) {
    	if(caIsRunFromCLI()) { return false; }
		try{
        	$this->shibAuth->requireAuth();
		} catch (Exception $e){
			die("Shibboleth error: {$e}");
		}
		
		if(!$this->shibAuth->isAuthenticated()){
			return false;
		}

		if (!($attrs = $this->shibAuth->getAttributes())) { return false; }
	    if (!is_array($attrs['emailAddress'])) { return false; }
	    ///print_R($va_attrs);
	    $uid = array_shift($attrs['emailAddress']);

		// if (!($attrs = $this->shibAuth->getAttributes())) { return false; }
// 	    
//         $map = array_flip($this->auth_config->get('shibboleth_field_map'));
// 	    $uid = array_shift($attrs[$map['uid']]);
	    if (!$uid) { return false; }
	    if (ca_users::find(['user_name' => $uid], ['returnAs' => 'count']) > 0) {
	        return true;
	    }
	    return false;
	}
    # --------------------------------------------------------------------------------
	/**
	 *
	 */
	public function getUserInfo($username, $password, $options=null) {
    	if(caIsRunFromCLI()) { return null; }
        if(!$this->shibAuth->isAuthenticated()){
            if (!$this->authenticate($username, $password)) {
                throw new ShibbolethException(_t("User could not be authenticated."));
            }
        }
        if($this->shibAuth->isAuthenticated()){
            $default_roles =  $this->auth_config->get('shibboleth_users_default_roles');
            $default_groups = $this->auth_config->get('shibboleth_users_default_groups');
            
            $attrs = $this->shibAuth->getAttributes();
            return [
                'user_name' => $username ? $username : $attrs['emailAddress'][0],
				'email' => $attrs['emailAddress'][0],
				'fname' => $attrs['fname'][0],
				'lname' => $attrs['emailAddress'][0],
				'active' => 1,
				'roles' => $default_roles,
				'groups' => $default_groups
            ];
        }
		throw new ShibbolethException(_t("User could not be found."));
    }
	# --------------------------------------------------------------------------------
	/**
	 * @param string $username Username to create account for
	 * @param string $passowrd Ignored
	 */
	public function createUserAndGetPassword($username, $password=null) {
    	if(caIsRunFromCLI()) { return null; }
		// ca_users takes care of creating the backend record for us. There's nothing else to do here
		if(function_exists('mcrypt_create_iv')) {
			$password = base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		} elseif(function_exists('openssl_random_pseudo_bytes')) {
			$password = base64_encode(openssl_random_pseudo_bytes(32));
		} else {
			throw new Exception('mcrypt or OpenSSL is required for CollectiveAccess to run');
		}

        return $password;
	}
	# --------------------------------------------------------------------------------
	public function supports($feature) {
		switch($feature){
		    case __CA_AUTH_ADAPTER_FEATURE_USE_ADAPTER_LOGIN_FORM__:
		        return true;
			case __CA_AUTH_ADAPTER_FEATURE_RESET_PASSWORDS__:
			case __CA_AUTH_ADAPTER_FEATURE_UPDATE_PASSWORDS__:
				return false;
			case __CA_AUTH_ADAPTER_FEATURE_AUTOCREATE_USERS__:
			    return true;
			default:
				return false;
		}
	}
	# --------------------------------------------------------------------------------
	public function updatePassword($username, $password) {
		// ca_users takes care of creating the backend record for us. There's nothing else to do here
		return create_hash($password);
	}
	# --------------------------------------------------------------------------------
	public function deleteUser($username) {
		// ca_users takes care of deleting the db row for us. Nothing else to do here.
		return true;
	}
    # --------------------------------------------------------------------------------
    public function getAccountManagementLink() {
        return false;
    }
	# --------------------------------------------------------------------------------
	/**
	 * Deauthenticate session by removing SimpleSAML cookies
	 *
	 */
    public function deauthenticate($options=null) {
    	if(caIsRunFromCLI()) { return false; }
        setcookie("SimpleSAML", "", time()-3600, '/');
        setcookie("SimpleSAMLAuthToken", "", time()-3600, '/');
        setcookie($this->auth_config->get('shibboleth_token_cookie'), '', time()-3600, __CA_URL_ROOT__);
        return true;
    }
	# --------------------------------------------------------------------------------
}

class ShibbolethException extends Exception {}
