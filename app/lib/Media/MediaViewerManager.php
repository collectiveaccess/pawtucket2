<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewerManager.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2024 Whirl-i-Gig
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
 * @subpackage Media
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
use CA\MediaViewers;

class MediaViewerManager {
	# -------------------------------------------------------
	/** 
	 * @var Global flag indicating whether we've required() viewer plugins yet
	 */
	static $s_manager_did_do_init = false;
	
	/** 
	 * 
	 */
	static $s_media_viewer_plugin_dir;
	
	/** 
	 * 
	 */
	static $s_media_viewers = [];
	
	/** 
	 * 
	 */
	static $s_viewer_options = [];
	
	# -------------------------------------------------------
	#
	# -------------------------------------------------------
	/**
	 * Loads viewers
	 */
	public static function initViewers() {
		MediaViewerManager::$s_media_viewer_plugin_dir = __CA_LIB_DIR__.'/Media/MediaViewers';	// set here for compatibility with PHP 5.5 and earlier
		
		if (MediaViewerManager::$s_manager_did_do_init) { return true; }
		
		MediaViewerManager::$s_media_viewers = array_map("strtolower", MediaViewerManager::getViewerNames());
		MediaViewerManager::$s_manager_did_do_init = true;
		
		return true;
	}
	# -------------------------------------------------------
	/**
	 * 
	 */
	public static function viewerIsAvailable(string $viewer_name) {
		MediaViewerManager::initViewers();
		if (in_array(strtolower($viewer_name), MediaViewerManager::$s_media_viewers)) {
			return true;
		}
		return false;
	}
	# -------------------------------------------------------
	/**
	 * Returns names of all media viewers
	 */
	public static function getViewerNames() {
		if(!file_exists(MediaViewerManager::$s_media_viewer_plugin_dir)) { return array(); }
		
		$media_viewers = [];
		if (is_resource($r_dir = opendir(MediaViewerManager::$s_media_viewer_plugin_dir))) {
			while (($plugin = readdir($r_dir)) !== false) {
				$plugin_proc = str_replace(".php", "", $plugin);
				if (preg_match("/^[A-Za-z_]+[A-Za-z0-9_]*$/", $plugin_proc)) {
					require_once(MediaViewerManager::$s_media_viewer_plugin_dir."/".$plugin);
					$media_viewers[] = $plugin_proc;
				}
			}
		}
		
		sort($media_viewers);
		
		return $media_viewers;
	}
	# ----------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerForMimetype(string $context, string $mimetype) {
		$config = Configuration::load(__CA_CONF_DIR__.'/media_display.conf');
		
		$info = caGetMediaDisplayInfoForMimetype($context, $mimetype);
		
		$viewer_name = null;
		if (!isset($info['viewer']) || !($viewer_name = $info['viewer'])) { 
			$viewer_name = caGetDefaultMediaViewer($mimetype);
		}
		if (!$viewer_name) { return null; }
		if(MediaViewerManager::viewerIsAvailable($viewer_name)) {
			require_once(__CA_LIB_DIR__."/Media/MediaViewers/{$viewer_name}.php");
			$viewer_name = "CA\\MediaViewers\\{$viewer_name}";
			return new $viewer_name();
		}
		return null;
	} 
	# ----------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerByDisplayClass(string $context, string $display_class) {
		$config = Configuration::load(__CA_CONF_DIR__.'/media_display.conf');
		
		$info = caGetMediaDisplayInfoForDisplayClass($context, $display_class);
		
		$viewer_name = null;
		if (!isset($info['viewer']) || !($viewer_name = $info['viewer'])) { 
			return null;
		}
		if (!$viewer_name) { return null; }
		if(MediaViewerManager::viewerIsAvailable($viewer_name)) {
			require_once(__CA_LIB_DIR__."/Media/MediaViewers/{$viewer_name}.php");
			$viewer_name = "CA\\MediaViewers\\{$viewer_name}";
			return new $viewer_name();
		}
		return null;
	}
	# ----------------------------------------------------------
	/**
	 *
	 */
	public static function viewerOptionsForDisplayClass(string $context, string $display_class) : ?array {
		if(self::$s_viewer_options["{$context}/{$display_class}"] ?? null) {
			return self::$s_viewer_options["{$context}/{$display_class}"];
		}
		$config = Configuration::load(__CA_CONF_DIR__.'/media_display.conf');
		
		$info = caGetMediaDisplayInfoForDisplayClass($context, $display_class);
		
		$viewer_name = null;
		if (!isset($info['viewer']) || !($viewer_name = $info['viewer'])) { 
			$viewer_name = caGetDefaultMediaViewer($mimetype);
		}
		if (!$viewer_name) { return null; }
		require_once(__CA_LIB_DIR__."/Media/MediaViewers/{$viewer_name}.php");
		$viewer_name = "CA\\MediaViewers\\{$viewer_name}";
		
		$opt_values = [];
		foreach($viewer_name::viewerOptions() as $opt) {
			$opt_values[$opt] = $info[$opt] ?? null;
		}
		return self::$s_viewer_options["{$context}/{$display_class}"] = $opt_values;
	} 
	# ----------------------------------------------------------
}
