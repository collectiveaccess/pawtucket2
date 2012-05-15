<?php
/** ---------------------------------------------------------------------
 * app/lib/core/Plugins/SearchEngine/SphinxConfigurationSettings.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009 Whirl-i-Gig
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
 * @subpackage Search
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  *
  */

# ------------------------------------------------
/* are we able to write the sphinx configuration files? */
define('__CA_SPHINX_SETTING_WEBSERVER_DIR_PERMISSIONS__',5001);
/* Sphinx running?  */
define('__CA_SPHINX_SETTING_RUNNING__',5002);
# ------------------------------------------------
require_once(__CA_LIB_DIR__.'/core/Datamodel.php');
require_once(__CA_LIB_DIR__.'/core/Configuration.php');
require_once(__CA_LIB_DIR__.'/core/Search/SearchBase.php');
require_once(__CA_LIB_DIR__.'/core/Search/ASearchConfigurationSettings.php');
require_once(__CA_LIB_DIR__.'/core/Plugins/SearchEngine/Sphinx.php');
require_once(__CA_LIB_DIR__.'/core/Zend/Http/Client.php');
require_once(__CA_LIB_DIR__.'/core/Zend/Http/Response.php');
require_once(__CA_LIB_DIR__.'/core/Zend/Cache.php');
# ------------------------------------------------
class SphinxConfigurationSettings extends ASearchConfigurationSettings {
	# ------------------------------------------------
	private $opo_app_config;
	private $opo_search_config;
	private $opo_search_indexing_config;
	private $ops_webserver_user;
	# ------------------------------------------------
	private $opa_setting_names;
	private $opa_setting_descriptions;
	private $opa_setting_hints;
	# ------------------------------------------------
	public function __construct(){
		$this->opo_search_base = new SearchBase();
		$this->opo_app_config = Configuration::load();
		$this->opo_search_config = Configuration::load($this->opo_app_config->get("search_config"));
		$this->opo_search_indexing_config = Configuration::load($this->opo_search_config->get("search_indexing_config"));
		$this->ops_webserver_user = posix_getpwuid(posix_getuid());
		$this->ops_webserver_user = $this->ops_webserver_user['name'];
		$this->opa_setting_descriptions = array();
		$this->opa_setting_names = array();
		$this->opa_setting_hints = array();
		$this->_initMessages();
		parent::__construct();
	}
	# ------------------------------------------------
	public function getEngineName() {
		return "Sphinx";
	}
	# ------------------------------------------------
	private function _initMessages(){
		# ------------------------------------------------
		$this->opa_setting_names[__CA_SPHINX_SETTING_WEBSERVER_DIR_PERMISSIONS__]=
			_t("Write permissions for Sphinx home directory");
		$this->opa_setting_names[__CA_SPHINX_SETTING_RUNNING__] =
			_t("Sphinx process up and running");
		# ------------------------------------------------
		$this->opa_setting_descriptions[__CA_SPHINX_SETTING_WEBSERVER_DIR_PERMISSIONS__] =
			_t("The web server user (%1) must be able to read and write the whole Sphinx configuration.",$this->ops_webserver_user);
		$this->opa_setting_descriptions[__CA_SPHINX_SETTING_RUNNING__] =
			_t("Sphinx must be running.");
		# ------------------------------------------------
		$this->opa_setting_hints[__CA_SPHINX_SETTING_WEBSERVER_DIR_PERMISSIONS__] =
			_t("Change the owner of the Sphinx home directory to the web server user (%1).",$this->ops_webserver_user);
		$this->opa_setting_hints[__CA_SPHINX_SETTING_RUNNING__] =
			_t("Make sure Sphinx is started");
		# ------------------------------------------------
	}
	# ------------------------------------------------
	public function setSettings(){
		$this->opa_possible_errors = array_keys($this->opa_setting_names);
	}
	# ------------------------------------------------
	public function checkSetting($pn_setting_num){
		switch($pn_setting_num){
			case __CA_SPHINX_SETTING_RUNNING__:
				return $this->_checkSphinxDirPermissions();
			case __CA_SPHINX_SETTING_RUNNING__:
				return $this->_checkSphinxProcess();
			default:
				return false;
		}
	}
	# ------------------------------------------------
	public function getSettingName($pn_setting_num){
		return $this->opa_setting_names[$pn_setting_num];
	}
	# ------------------------------------------------
	public function getSettingDescription($pn_setting_num){
		return $this->opa_setting_descriptions[$pn_setting_num];
	}
	# ------------------------------------------------
	public function getSettingHint($pn_setting_num){
		return $this->opa_setting_hints[$pn_setting_num];
	}
	# ------------------------------------------------
	private function _checkSphinxDirPermissions(){
		$vs_solr_home = $this->opo_search_config->get("search_sphix_home_dir");
		/* try to create a new directory and delete it afterwards */
		if(!@mkdir($vs_solr_home."/tmp", 0700)){
			return __CA_SEARCH_CONFIG_ERROR__;
		}
		if(!@rmdir($vs_solr_home."/tmp")){
			return __CA_SEARCH_CONFIG_ERROR__;
		}
		return __CA_SEARCH_CONFIG_OK__;
	}
	# ------------------------------------------------
	private function _checkSphinxProcess(){
		// TODO: code test
		
		/* everything passed */
		return __CA_SEARCH_CONFIG_OK__;
	}
	# ------------------------------------------------
}
?>