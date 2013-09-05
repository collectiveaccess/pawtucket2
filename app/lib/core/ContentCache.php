<?php
/* ----------------------------------------------------------------------
 * app/lib/core/ContentCache.php : Caching of arbitrary content; wrapper for Zend_Cache
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
 	require_once(__CA_LIB_DIR__.'/core/Zend/Cache.php');
 	
	class ContentCache {
		# -------------------------------------------------------
		/**
		 * Cache content in $pm_content using cache key $ps_key
		 *
		 * @param $ps_key - string key to cache data under
		 * @param $pm_content - mixed data (string, number, array) to cache
		 * @param $pn_timeout - number of seconds until cached item expires and is removed from the cache; defaults to 120 seconds
		 *
		 * @return boolean - true on success, false if cache operation fails
		 */
		public function cache($ps_key, $pm_content, $pn_timeout=120) {
			if(!($vo_cache = $this->getZendCacheObject($pn_timeout))) { return false; }
			$vo_cache->save($pm_content, 'ca_content_cache_'.$ps_key, array('ca_content_cache'));
			return true;
		}
		# -------------------------------------------------------
		/**
		 * Checks if there is cached content for the specified cache key
		 *
		 * @param $ps_key - string key to check if content is available for
		 *
		 * @return boolean - true if content exists, false if not
		 */
		public function isInCache($ps_key) {
			return $this->getFromCache($ps_key) ? true : false;
		}
		# -------------------------------------------------------
		/**
		 * Fetch data from cache
		 *
		 * @param $ps_key - string key to fetch content for
		 *
		 * @return mixed - cached content; null if cache fetch failed
		 */
		public function getFromCache($ps_key) {
			if(!($vo_cache = $this->getZendCacheObject())) { return null; }
			return $vo_cache->load('ca_content_cache_'.$ps_key);
		}
		# -------------------------------------------------------
		/**
		 * Removed content cached under the specified key
		 *
		 * @param $ps_key - string key to remove content for
		 *
		 * @return boolean - true if remove succeeded, false if not
		 */
		public function removeFromCache($ps_key) {
			if(!($vo_cache = $this->getZendCacheObject())) { return false; }
			$vo_cache->remove($ps_key);
			
			return true;
		}
		# -------------------------------------------------------
		/**
		 * Removes all content from cache
		 *
		 * @return boolean - true if clear succeeded, false if not
		 */
		public function clearCache() {
			if(!($vo_cache = $this->getZendCacheObject())) { return false; }
			$vo_cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('ca_content_cache'));
			
			return true;
		}
		# -------------------------------------------------------
		/**
		 * Returns cache key for a controller and parameter set given the current request
		 *
		 * @param $po_request - an RequestHTTP instance representing the current request
		 * @param $pa_parameter_names - indexed array of request parameters to generate the key with; these should be the parameters that uniquely identify the cached content item
		 */
		public function generateKeyFromRequest($po_request, $pa_parameter_names) {
			$va_parameter_values = array();
			
			$vs_controller_path = $po_request->getModulePath().'/'.$po_request->getController();
			foreach($pa_parameter_names as $vs_parameter_name) {
				$va_parameter_values[] = $po_request->getParameter($vs_parameter_name, pString);
			}
			return md5($vs_controller_path.join(';', $va_parameter_values));
		}
		# -------------------------------------------------------
		/**
		 * Initializes a Zend_Cache object that implements the underlying cache
		 */
		private function getZendCacheObject($pn_timeout=120) {
			$o_config = Configuration::load();
			if (!($vs_cache_dir = $o_config->get('content_cache_dir'))) { $vs_cache_dir = __CA_APP_DIR__.'/tmp'; }
			
			$va_frontend_options = array(
				'lifetime' => $pn_timeout, 						
				'logging' => false,							/* do not use Zend_Log to log what happens */
				'write_control' => true,					/* immediate read after write is enabled (we don't write often) */
				'automatic_cleaning_factor' => true, 		/* use automatic cache cleaning */
				'automatic_serialization' => true			/* we store arrays, so we have to enable that */
			);
			$va_backend_options = array(
				'cache_dir' => $vs_cache_dir,				/* where to store cache data? */
				'file_locking' => true,						/* cache corruption avoidance */
				'read_control' => false,					/* no read control */
				'file_name_prefix' => 'ca_content_cache',	/* prefix of cache files */
				'cache_file_umask' => 0700					/* permissions of cache files */
			);
			
			try {
				$vo_cache = Zend_Cache::factory('Core', 'File', $va_frontend_options, $va_backend_options);
			} catch (Exception $e) {
				return null;
			}
			
			return $vo_cache;
		}
		# -------------------------------------------------------
	}
?>