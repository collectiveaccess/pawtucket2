<?php
/** ---------------------------------------------------------------------
 * app/lib/core/Plugins/SearchEngine/LuceneConfigurationSettings.php :
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
define('__CA_LUCENE_SETTING_DIR_PERMISSIONS__',2001);
define('__CA_LUCENE_SETTING_INDEXES__',2002);
# ------------------------------------------------
require_once(__CA_LIB_DIR__.'/core/Datamodel.php');
require_once(__CA_LIB_DIR__.'/core/Search/SearchBase.php');
require_once(__CA_LIB_DIR__.'/core/Search/ASearchConfigurationSettings.php');
# ------------------------------------------------
class LuceneConfigurationSettings extends ASearchConfigurationSettings {
	# ------------------------------------------------
	public function __construct(){
		parent::__construct();
	}
	# ------------------------------------------------
	public function getEngineName() {
		return "PHP Lucene (Zend)";
	}
	# ------------------------------------------------
	public function setSettings(){
		$this->opa_possible_errors = array(
			__CA_LUCENE_SETTING_DIR_PERMISSIONS__,
			__CA_LUCENE_SETTING_INDEXES__
		);
	}
	# ------------------------------------------------
	public function checkSetting($pn_setting_num){
		switch($pn_setting_num){
			case __CA_LUCENE_SETTING_DIR_PERMISSIONS__:
				return $this->_checkLuceneDirPermissions();
			case __CA_LUCENE_SETTING_INDEXES__:
				return $this->_checkLuceneIndexes();
			default:
				return false;
		}
	}
	# ------------------------------------------------
	public function getSettingName($pn_setting_num){
		switch($pn_setting_num){
			case __CA_LUCENE_SETTING_DIR_PERMISSIONS__:
				return _t("Write permissions to Lucene index directory");
			case __CA_LUCENE_SETTING_INDEXES__:
				return _t("Indexes must exist and be readable");
			default:
				return null;
		}
	}
	# ------------------------------------------------
	public function getSettingDescription($pn_setting_num){
		$vs_webserver_user = posix_getpwuid(posix_getuid());
		$vs_webserver_user = $vs_webserver_user['name'];
		$vo_app_config = Configuration::load();
		$vs_lucene_dir = $vo_app_config->get('search_lucene_index_dir');
		switch($pn_setting_num){
			case __CA_LUCENE_SETTING_DIR_PERMISSIONS__:
				return _t("The web server user (%1) must be allowed to write the Lucene index directory (%2). You have to ensure that in order to get the Lucene search engine back-end to work.",$vs_webserver_user,$vs_lucene_dir);
			case __CA_LUCENE_SETTING_INDEXES__:
				return _t("You have to ensure that all Lucene indexes exist and can be opened. Please check if a) the web server user (%1) is allowed to read and write all subdirectories of %2 and b) that all indexes have been created (by running a full reindex on the whole database).
				",$vs_webserver_user,$vs_lucene_dir);
			default:
				return null;
		}
	}
	# ------------------------------------------------
	public function getSettingHint($pn_setting_num){
		$vs_webserver_user = posix_getpwuid(posix_getuid());
		$vs_webserver_user = $vs_webserver_user['name'];
		$vo_app_config = Configuration::load();
		$vs_lucene_dir = $vo_app_config->get('search_lucene_index_dir');
		switch($pn_setting_num){
			case __CA_LUCENE_SETTING_DIR_PERMISSIONS__:
				return _t("Open a typical Unix shell (e.g. bash on Linux, Mac OS X, Solaris etc.) and run &quot;chown -R ".$vs_webserver_user." ".$vs_lucene_dir." &amp;&amp; chmod -R 755 ".$vs_lucene_dir."&quot; or similar.");
			case __CA_LUCENE_SETTING_INDEXES__:
				return _t("Open a typical Unix shell (e.g. bash on Linux, Mac OS X, Solaris etc.) and run &quot;chown -R ".$vs_webserver_user." ".$vs_lucene_dir." &amp;&amp; chmod -R 755 ".$vs_lucene_dir."&quot; and &quot;sudo -u ".$vs_webserver_user." php ".__CA_BASE_DIR__."/support/utils/reindex.php yourhostname&quot;");
			default:
				return null;
		}
	}
	# ------------------------------------------------
	private function _checkLuceneDirPermissions(){
		$vo_app_config = Configuration::load();
		$vs_lucene_dir = $vo_app_config->get('search_lucene_index_dir');
		/* try to create a new directory and delete it afterwards */
		if(!@mkdir($vs_lucene_dir."/tmp", 0700)){
			return __CA_SEARCH_CONFIG_ERROR__;
		}
		if(!@rmdir($vs_lucene_dir."/tmp")){
			return __CA_SEARCH_CONFIG_ERROR__;
		}
		return __CA_SEARCH_CONFIG_OK__;
	}
	# ------------------------------------------------
	private function _checkLuceneIndexes(){
		$vo_search_base = new SearchBase();
		$vo_datamodel = Datamodel::load();
		$vo_app_config = Configuration::load();
		foreach($vo_search_base->getIndexedTables() as $vs_table){
			$vn_table_num = $vo_datamodel->getTableNum($vs_table);
			$vs_index_path = $vo_app_config->get('search_lucene_index_dir').'/t_'.$vn_table_num;
			try {
				$vo_lucene_index = Zend_Search_Lucene::open($vs_index_path);
			} catch (Zend_Search_Lucene_Exception $ex) {
				return __CA_SEARCH_CONFIG_ERROR__;
			}
			$vo_lucene_index->removeReference();
			unset($vo_lucene_index);
		}
		return __CA_SEARCH_CONFIG_OK__;
	}
	# ------------------------------------------------
}
