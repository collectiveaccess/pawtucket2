<?php
/* ----------------------------------------------------------------------
 * app/lib/pawtucket/ConfigurationCheck.php : configuration check singleton class
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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

require_once(__CA_LIB_DIR__."/core/Configuration.php");

final class ConfigurationCheck {
	# -------------------------------------------------------
	private static $opa_error_messages;
	private static $opo_config;
	private static $opo_db;
	# -------------------------------------------------------
	/**
	 * Invokes all "QuickCheck" methods. Note that this is usually invoked
	 * in index.php and that any errors set here cause the application
	 * to die and display a nasty configuration error screen.
	 */
	public static function performQuick() {
		self::$opa_error_messages = array();
		self::$opo_db = new Db();
		self::$opo_config = ConfigurationCheck::$opo_db->getConfig();

		/* execute checks */
		$vo_reflection = new ReflectionClass("ConfigurationCheck");
		$va_methods = $vo_reflection->getMethods();
		foreach($va_methods as $vo_method){
			if(strpos($vo_method->name,"QuickCheck")!==false){
				if (!$vo_method->invoke("ConfigurationCheck")) {
					return;
				}
			}
		}
	}
	# -------------------------------------------------------
	/**
	 * Performs all "ExpensiveCheck" methods. Note that this is usually
	 * invoked in the Configuration check screen and therefore any
	 * errors set here are "non-lethal", i.e. the application still works
	 * although certain features may not function properly.
	 */
	public static function performExpensive() {
		self::$opa_error_messages = array();
		self::$opo_db = new Db();
		self::$opo_config = ConfigurationCheck::$opo_db->getConfig();

		/* execute checks */
		$vo_reflection = new ReflectionClass("ConfigurationCheck");
		$va_methods = $vo_reflection->getMethods();
		foreach($va_methods as $vo_method){
			if(strpos($vo_method->name,"ExpensiveCheck")!==false){
				if (!$vo_method->invoke("ConfigurationCheck")) {	// true means keep on doing checks; false means stop performing checks
					return;
				}
			}
		}
	}
	# -------------------------------------------------------
	private static function addError($ps_error) {
		self::$opa_error_messages[] = $ps_error;
	}
	# -------------------------------------------------------
	public static function foundErrors(){
		return (sizeof(self::$opa_error_messages) > 0);
	}
	# -------------------------------------------------------
	public static function getErrors() {
		return self::$opa_error_messages;
	}
	# -------------------------------------------------------
	public static function renderErrorsAsHTMLOutput(){
		require_once(self::$opo_config->get("views_directory")."/system/configuration_error_html.php");
	}
	# -------------------------------------------------------
	# Quick configuration check functions
	# -------------------------------------------------------
	/**
	 * Check if database login works okay
	 */
	public static function DBLoginQuickCheck() {
		if (!self::$opo_config->get('db_type')) {
			self::addError(_t("No database login information found. Have you specified it in your setup.php file?"));
		}
		if (!self::$opo_db->connected()) {
			self::addError(_t("Could not connect to database. Did you enter your database login information into setup.php?"));
		}
		
		return true;
	}
	# -------------------------------------------------------
	/**
	 * Does database have any tables in it?
	 */
	public static function DBTableQuickCheck() {
		$va_tmp = self::$opo_db->getTables();
		if (!is_array($va_tmp) || !in_array('ca_users', $va_tmp)) {
			self::addError(_t("<em>Pawtucket</em> requires a working <em>Providence</em> installation and looks like you have not installed your database yet. Check your configuration or run the <em>Providence</em> installer."));
			return false;
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * Is the DB schema up-to-date?
	 */
	public static function DBOutOfDateQuickCheck() {
		if (!in_array('ca_schema_updates', self::$opo_db->getTables())) {
			self::addError(_t("Your database is out-of-date. Please all install database migrations starting with migration #1. See <a href=\"http://wiki.collectiveaccess.org/index.php?title=Upgrade\">http://wiki.collectiveaccess.org/index.php?title=Upgrade</a> for migration instructions."));
		} else if (($vn_schema_revision = self::getSchemaVersion()) < __CollectiveAccess_Schema_Rev__) {
			self::addError(_t("Your database is out-of-date. Please install all schema migrations starting with migration #%1. See <a href=\"http://wiki.collectiveaccess.org/index.php?title=Upgrade\">http://wiki.collectiveaccess.org/index.php?title=Upgrade</a> for migration instructions.",($vn_schema_revision + 1)));
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * Is the PHP version too old?
	 */
	public static function PHPVersionQuickCheck() {
		$va_php_version = caGetPHPVersion();
		if($va_php_version["versionInt"]<50106){
			self::addError(_t("CollectiveAccess requires PHP version 5.1.6 or higher to function properly. You're running %1. Please upgrade.",$va_php_version["version"]));
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * Does the app/tmp dir exist and is it writable?
	 */
	public static function tmpDirQuickCheck() {
		if(!file_exists(__CA_APP_DIR__."/tmp") || !is_writable(__CA_APP_DIR__."/tmp")){
			self::addError(_t("It looks like the directory for temporary files is not writable by the webserver. Please change the permissions of %1 and enable the user which runs the webserver to write this directory.",__CA_APP_DIR__."/tmp"));
		}
		return true;
	}
	# -------------------------------------------------------
	public static function mediaDirQuickCheck() {
		$vs_media_root = self::$opo_config->get("ca_media_root_dir");
		if(!file_exists($vs_media_root)){
			self::addError(_t("It looks like the media directory is not writable by the webserver. Please change the permissions of %1 (or create it if it doesn't exist already) and enable the user which runs the webserver to write this directory.",$vs_media_root));
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * Does the HTMLPurifier DefinitionCache dir exist and is it writable?
	 */
	public static function htmlPurifierDirQuickCheck() {
		if(!file_exists(__CA_LIB_DIR__."/core/Parsers/htmlpurifier/standalone/HTMLPurifier/DefinitionCache") || !is_writable(__CA_LIB_DIR__."/core/Parsers/htmlpurifier/standalone/HTMLPurifier/DefinitionCache")){
			self::addError(_t("It looks like the directory for HTML filtering caches is not writable by the webserver. Please change the permissions of %1 and enable the user which runs the webserver to write this directory.",__CA_LIB_DIR__."/core/Parsers/htmlpurifier/standalone/HTMLPurifier/DefinitionCache"));
		}
		return true;
	}
	# -------------------------------------------------------
	public static function caUrlRootQuickCheck() {
		$vs_script_name = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"]);
		$va_script_name_parts = explode("/",$vs_script_name);
		$vs_script_called = $va_script_name_parts[sizeof($va_script_name_parts)-1]; // index.php or service.php
		$vs_probably_correct_urlroot = str_replace("/{$vs_script_called}", "", $vs_script_name);
		
		$vs_probably_correct_urlroot = str_replace("/index.php", "", $vs_script_name);
		
		if (caGetOSFamily() === OS_WIN32) {	// Windows paths are case insensitive
			if(strcasecmp($vs_probably_correct_urlroot, __CA_URL_ROOT__) != 0) {
				self::addError(_t("It looks like the __CA_URL_ROOT__ variable in your setup.php is not set correctly. Please try to set it to &quot;%1&quot;. We came up with this suggestion because you accessed this script via &quot;&lt;your_hostname&gt;%2&quot;.",$vs_probably_correct_urlroot,$vs_script_name));
			}
		} else {
			if(!($vs_probably_correct_urlroot == __CA_URL_ROOT__)) {
				self::addError(_t("It looks like the __CA_URL_ROOT__ variable in your setup.php is not set correctly. Please try to set it to &quot;%1&quot;. We came up with this suggestion because you accessed this script via &quot;&lt;your_hostname&gt;%2&quot;. Note that paths are case sensitive.",$vs_probably_correct_urlroot,$vs_script_name));
			}
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * I suspect that the application would die before we even reach this check if the base dir is messed up?
	 */
	public static function caBaseDirQuickCheck() {
		$vs_script_filename = str_replace("\\", "/", $_SERVER["SCRIPT_FILENAME"]);
		$va_script_name_parts = explode("/",$vs_script_filename);
		$vs_script_called = $va_script_name_parts[sizeof($va_script_name_parts)-1]; // index.php or service.php
		$vs_probably_correct_base = str_replace("/{$vs_script_called}", "", $vs_script_filename);

		if (caGetOSFamily() === OS_WIN32) {	// Windows paths are case insensitive
			if(strcasecmp($vs_probably_correct_base, __CA_BASE_DIR__) != 0) {
				self::addError(_t("It looks like the __CA_BASE_DIR__ variable in your setup.php is not set correctly. Please try to set it to &quot;%1&quot;. We came up with this suggestion because the location of this script is &quot;%2&quot;.",$vs_probably_correct_base,$vs_script_filename));
			}
		} else {
			if(!($vs_probably_correct_base == __CA_BASE_DIR__)) {
				self::addError(_t("It looks like the __CA_BASE_DIR__ variable in your setup.php is not set correctly. Please try to set it to &quot;%1&quot;. We came up with this suggestion because the location of this script is &quot;%2&quot;. Note that paths are case sensitive.",$vs_probably_correct_base,$vs_script_filename));
			}
		}
		return true;
	}
	# -------------------------------------------------------
	public static function PHPModuleRequirementQuickCheck() {
		//mbstring, JSON, mysql, iconv, zlib, PCRE are required
		if (!function_exists("json_encode")) {
			self::addError(_t("PHP JSON module is required for CollectiveAccess to run. Please install it."));
		}
		if (!function_exists("mb_strlen")) {
			self::addError(_t("PHP mbstring module is required for CollectiveAccess to run. Please install it."));
		}
		if (!function_exists("iconv")) {
			self::addError(_t("PHP iconv module is required for CollectiveAccess to run. Please install it."));
		}
		if (!function_exists("mysql_query")) {
			self::addError(_t("PHP mysql module is required for CollectiveAccess to run. Please install it."));
		}
		if (!function_exists("gzcompress")){
			self::addError(_t("PHP zlib module is required for CollectiveAccess to run. Please install it."));
		}
		if (!function_exists("preg_match")){
			self::addError(_t("PHP PCRE module is required for CollectiveAccess to run. Please install it."));
		}
		if (!class_exists("DOMDocument")){
			self::addError(_t("PHP Document Object Model (DOM) module is required for CollectiveAccess to run. Please install it."));
		}
		
		if (@preg_match('/\p{L}/u', 'a') != 1) {
			self::addError(_t("Your version of the PHP PCRE module lacks unicode features. Please install a module version with UTF-8 support."));
		}
		return true;
	}
	# -------------------------------------------------------
	/**
	 * Check if app_name is valid
	 */
	public static function appNameValidityQuickCheck() {
		if(!preg_match("/^[[:alnum:]|_]+$/", __CA_APP_NAME__)){
			self::addError(_t('It looks like the __CA_APP_NAME__ setting in your setup.php is invalid. It may only consist of alphanumeric ASCII characters and underscores (&quot;_&quot;)'));
		}
		return true;
	}
	# -------------------------------------------------------
	# Expensive configuration check functions
	# These are not executed on every page refresh and should be used for more "expensive" checks.
	# They appear in the "configuration check" screen under manage -> system configuration.
	# -------------------------------------------------------
	/**
	 * Now this check clearly isn't expensive but we don't want it to have the
	 * application die in case it fails as it only breaks display of media
	 * and 99% of the other features work just fine. Also the check may
	 * fail if everything is just fine because users tend to to crazy things
	 * with their /etc/hosts files.
	 */
	public static function hostNameExpensiveCheck() {
		if(__CA_SITE_HOSTNAME__ != $_SERVER["HTTP_HOST"]){
			self::addError(_t(
				"It looks like the __CA_SITE_HOSTNAME__ setting in your setup.php may be set incorrectly. ".
				"If you experience any troubles with image display try setting this to &quot;%1&quot;. ".
				"We came up with this suggestion because this is the hostname you used to access this script. ".
				"It may only be valid for you (and not for other users of the system) though (e.g. if you use ".
				"'localhost' or a feature like /etc/hosts on UNIX-based operating systems) so you have to be ".
				"very careful when editing this.",$_SERVER["HTTP_HOST"]
			));
		}
		return true;
	}
	# -------------------------------------------------------
	# UTILITIES
	# -------------------------------------------------------
	private static function getSubdirectoriesAsArray($vs_dir) {
		$va_items = array();
		if ($vr_handle = opendir($vs_dir)) {
			while (false !== ($vs_file = readdir($vr_handle))) {
				if ($vs_file != "." && $vs_file != "..") {
					if (is_dir($vs_dir. "/" . $vs_file)) {
						$va_items = array_merge($va_items, self::getSubdirectoriesAsArray($vs_dir. "/" . $vs_file));
						$vs_file = $vs_dir . "/" . $vs_file;
						$va_items[] = preg_replace("/\/\//si", "/", $vs_file);
					}
				}
			}
			closedir($vr_handle);
		}
		return $va_items;
	}
	# -------------------------------------------------------
	/**
	 * Returns number of currently loaded schema version
	 */
	private static function getSchemaVersion() {
		$qr_res = self::$opo_db->query('
			SELECT max(version_num) n
			FROM ca_schema_updates
		');
		if ($qr_res->nextRow()) {
			return $qr_res->get('n');
		}
		return null;
	}
	# -------------------------------------------------------
}