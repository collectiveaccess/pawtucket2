<?php
/** ---------------------------------------------------------------------
 * AssetLoadManager.php : class to control loading of Javascript libraries, CSS and images
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2013 Whirl-i-Gig
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
 * @subpackage Misc
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  *
  */

	require_once(__CA_LIB_DIR__.'/core/Configuration.php');

	/*
	 * Globals used by Asset load manager
	 */
	 
	 /**
	  * Contains configuration object for asset.conf file
	  */
	$g_asset_config = null;
	
	/**
	 * Contains list of libraries to load
	 */
	$g_asset_load_list = null;
	
	/**
	 * Contains array of complementary code to load
	 */
	$g_asset_complementary = null;

	class AssetLoadManager {
		# --------------------------------------------------------------------------------
		/**
		 * Flag indicating whether to load minified assets or uncompressed
		 */
		static $s_use_minified = true;
		# --------------------------------------------------------------------------------
		static function init() {
			global $g_asset_config, $g_asset_load_list;
			
			$o_config = Configuration::load();
 			
			$g_asset_config = Configuration::load($o_config->get('assets_config'));
			$g_asset_load_list = array();
			
			$vb_used_minified = !$o_config->get('debug') && $o_config->get('minification') && $g_asset_config->get('minification');
			AssetLoadManager::useMinified($vb_used_minified);
			AssetLoadManager::register('_default');
		}
		# --------------------------------------------------------------------------------
		/**
		 *
		 */
		static function useMinified($pb_use_minified=null) {
			if (!is_null($pb_use_minified)) {
				AssetLoadManager::$s_use_minified = (bool)$pb_use_minified;
			}
			return AssetLoadManager::$s_use_minified;
		}
		# --------------------------------------------------------------------------------
		/**
		 * Causes the specified library (or libraries) to be loaded for the current request.
		 * There are two ways you can trigger loading:
		 *		(1) If you pass via the $ps_package parameter a loadSet name defined in assets.conf then all of the libraries in that loadSet will be loaded
		 * 		(2) If you pass a package and library name (via $ps_package and $ps_library) then the specified library will be loaded
		 *
		 * Whether you use a loadSet or a package/library combination, if it doesn't have a definition in assets.conf nothing will be loaded.
		 *
		 * @param $ps_package (string) - The package name containing the library to be loaded *or* a loadSet name. LoadSets describe a set of libraries to be loaded as a unit.
		 * @param $ps_library (string) - The name of the library contained in $ps_package to be loaded.
		 * @return bool - false if load failed, true if load succeeded
		 */
		static function register($ps_package, $ps_library=null) {
			global $g_asset_config, $g_asset_load_list;
			
			if (!$g_asset_config) { AssetLoadManager::init(); }
			$va_packages = $g_asset_config->getAssoc('packages');
			$va_theme_packages = $g_asset_config->getAssoc('themePackages');
			
			if (is_array($va_theme_packages)) {
				$va_packages += $va_theme_packages;
			}
			
			if ($ps_library) {
				// register package/library
				$va_pack_path = explode('/', $ps_package);
				$vs_main_package = array_shift($va_pack_path);
				if (!($va_list = $va_packages[$vs_main_package])) { return false; }
				 
				while(sizeof($va_pack_path) > 0) {
					$vs_pack = array_shift($va_pack_path);
					$va_list = $va_list[$vs_pack];
					
				}
				if (isset($va_list[$ps_library]) && $va_list[$ps_library]) {
					$g_asset_load_list[$ps_package.'/'.$va_list[$ps_library]] = true;
					return true;
				}
			} else {
				// register loadset
				if(!is_array($va_theme_loadsets = $g_asset_config->getAssoc('themeLoadSets'))) { $va_theme_loadsets = array(); }
				if (!is_array($va_loadsets = $g_asset_config->getAssoc('loadSets'))) { $va_loadsets = array(); }
				
				$va_loadsets = array_merge_recursive($va_loadsets, $va_theme_loadsets);
				
				if (isset($va_loadsets[$ps_package]) && is_array($va_loadset = $va_loadsets[$ps_package])) {
					$vs_loaded_ok = true;
					foreach($va_loadset as $vs_path) {
						$va_tmp = explode('/', $vs_path);
						$vs_library = array_pop($va_tmp);
						$vs_package = join('/', $va_tmp);
						if (!AssetLoadManager::register($vs_package, $vs_library)) {
							$vs_loaded_ok = false;
						}
					}
					return $vs_loaded_ok;
				}
			}
			return false;
		}
		# --------------------------------------------------------------------------------
		/**
		 * Causes the specified code to be loaded.
		 *
		 * @param $ps_scriptcontent (string) - script content to load
		 * @return (bool) - false if empty code, true if load succeeded
		 */
		static function addComplementaryScript($ps_content=null) {
			global $g_asset_config, $g_asset_load_list, $g_asset_complementary;			

			if (!$g_asset_config) { AssetLoadManager::init(); }
			if (!$ps_content) return false;
			$g_asset_complementary[]=$ps_content;			
			return true;
		}
		# --------------------------------------------------------------------------------
		/** 
		 * Returns HTML to load registered libraries. Typically you'll output this HTML in the <head> of your page.
		 * 
		 * @param $ps_baseurlpath (string) - URL path containing the application's "js" directory.
		 * @return string - HTML loading registered libraries
		 */
		static function getLoadHTML($ps_baseurlpath) {
			global $g_asset_config, $g_asset_load_list, $g_asset_complementary;
			
			if (!$g_asset_config) { AssetLoadManager::init(); }
			$vs_buf = '';
			if (is_array($g_asset_load_list)) {
				foreach($g_asset_load_list as $vs_lib => $vn_x) { 
					if (AssetLoadManager::useMinified()) {
						$va_tmp = explode(".", $vs_lib);
						array_splice($va_tmp, -1, 0, array('min'));
						$vs_lib = join('.', $va_tmp);
					}
					
					if (preg_match('!(http[s]{0,1}://.*)!', $vs_lib, $va_matches)) { 
						$vs_url = $va_matches[1];
					} else {
						$vs_url = "{$ps_baseurlpath}/assets/{$vs_lib}";
					}
					
					if (preg_match('!\.css$!', $vs_lib)) {
						$vs_buf .= "<link rel='stylesheet' href='{$vs_url}' type='text/css' media='screen'/>\n";
					} elseif(preg_match('!\.properties$!', $vs_lib)) {
						$vs_buf .= "<link rel='resource' href='{$vs_url}' type='application/l10n' />\n";
					} else {
						$vs_buf .= "<script src='{$vs_url}' type='text/javascript'></script>\n";
					}
				}
			}
			if (is_array($g_asset_complementary)) {
				foreach($g_asset_complementary as $vs_code) { 
					$vs_buf .= "<script type='text/javascript'>\n{$vs_code}</script>\n";
				}
			}
			return $vs_buf;
		}
		# --------------------------------------------------------------------------------
	}
?>