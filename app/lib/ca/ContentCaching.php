<?php
/* ----------------------------------------------------------------------
 * includes/ContentCaching.php : AppController plugin to selectively cache content
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
 
 	require_once(__CA_LIB_DIR__.'/core/Controller/AppController/AppControllerPlugin.php');
 	require_once(__CA_LIB_DIR__.'/core/Configuration.php');
 	require_once(__CA_LIB_DIR__.'/core/ContentCache.php');
 
	class ContentCaching extends AppControllerPlugin {
		# -------------------------------------------------------
		private $opo_caching_config = null;
		private $opo_content_cache = null;
		
		private $opb_needs_to_be_cached = false;
		private $opb_output_from_cache = false;
		# -------------------------------------------------------
		public function __construct() {
			parent::__construct();
			
			$this->opo_caching_config = Configuration::load(__CA_APP_DIR__.'/conf/content_caching.conf');
			$this->opo_content_cache = new ContentCache();
		}
		# -------------------------------------------------------
		private function getKeyForRequest() {
			if ($va_caching_settings = $this->getCachingSettingsForRequest()) {
				$va_param_list = is_array($va_caching_settings['parameters']) ? $va_caching_settings['parameters'] : array();
				$vs_key = $this->opo_content_cache->generateKeyFromRequest($this->getRequest(), $va_param_list);
					
				return $vs_key;
			}
			
			return null;
		}
		# -------------------------------------------------------
		private function getCachingSettingsForRequest() {
			$o_req = $this->getRequest();
			$vs_controller_path = $o_req->getModulePath();
			$vs_controller = $o_req->getController();
			
			$vs_path = ($o_req->getModulePath() ? $o_req->getModulePath().'/' : '').$o_req->getController();
			
			$va_cached_actions = $this->opo_caching_config->getAssoc('cached_actions');
			
			if (isset($va_cached_actions[$vs_path]) && is_array($va_cached_actions[$vs_path])) {
				$vs_action = $o_req->getAction();
				if (isset($va_cached_actions[$vs_path][$vs_action]) && is_array($va_cached_actions[$vs_path][$vs_action])) {
					return $va_cached_actions[$vs_path][$vs_action];
				}
			}
			
			return null;
		}
		# -------------------------------------------------------
		# Plugin methods
		# -------------------------------------------------------
		public function preDispatch() {
			if (!$this->getRequest()->config->get('do_content_caching')) { return null; }
			// does this need to be cached?
			if ($vs_key = $this->getKeyForRequest()) {
				// is this cached?			
				if ($this->opo_content_cache->isInCache($vs_key)) {
					// yep... so prevent dispatch and output cache in postDispatch
					$this->opb_output_from_cache = true;
					
					$app = AppController::getInstance();
					$app->removeAllPlugins();
					$o_dispatcher = $app->getDispatcher();
					$o_dispatcher->setPlugins(array($this));
					return array('dont_dispatch' => true);
				} else {
					// not cached so dispatch and cache in postDispatch
					$this->opb_needs_to_be_cached = true;
				}
			}
			
			return null;
		}
		# -------------------------------------------------------
		public function postDispatch() {
			if (!$this->getRequest()->config->get('do_content_caching')) { return null; }
			// does this need to be cached?
			$vs_key = $this->getKeyForRequest();
			$o_resp = $this->getResponse();
			if ($this->opb_needs_to_be_cached) {
				// cache output
				$va_caching_settings = $this->getCachingSettingsForRequest();
				if (($vn_lifetime = $va_caching_settings['lifetime']) <= 0) {
					$vn_lifetime = 120;		// default cache lifetime for item is 120 seconds
				}
				$this->opo_content_cache->cache($vs_key, $o_resp->getContent(), $vn_lifetime);
			} else {
				if ($this->opb_output_from_cache) {
					// request wasn't dispatched so we need to add content to response from cache here
					$o_resp->addContent($this->opo_content_cache->getFromCache($vs_key));
				}
			}
		}
		# -------------------------------------------------------
	}
?>
