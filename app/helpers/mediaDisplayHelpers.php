<?php
/** ---------------------------------------------------------------------
 * app/helpers/mediaDisplayHelpers.php : miscellaneous functions
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020 Whirl-i-Gig
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
 * @subpackage utils
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

  /**
   *
   */

 	require_once(__CA_LIB_DIR__.'/Configuration.php');

	# ------------------------------------------------------------------------------------------------
	/**
	 *
	 *
	 * @param RepresentableBaseModel $instance
	 * @param string $context
	 * @param array $options Options include:
	 *		versions = 
	 *		asJson = Return representation data as JSON. [Default is false]
	 *
	 * @return mixed Array of data; string is asJson option is set; null on error
	 */
	function caGetMediaViewerDataForRepresentations(RepresentableBaseModel $instance, string $context, array $options=null) {
		$app_config = Configuration::load();
		$display_config = caGetMediaDisplayConfig();
		
		$display_config_for_context = $display_config->get($context);
		
		if(!$display_config_for_context) {
			throw ApplicationException(_t('Invalid media display context: %1', $context));
		}
		
		$base_url = $app_config->get('ca_url_root');
		$versions = caGetOption('versions', $options, ['original', 'page', 'icon', 'iconlarge', 'small', 'medium', 'large', 'h264_hi', 'mp3', 'tilepic']);
		
		$replist = $instance->getRepresentations($versions, null, $options);
	
		$replist = array_values(array_map(function($v) use ($context, $base_url, $display_config_for_context) {
			$pages = $v['info']['original']['PROPERTIES']['pages'] ?? 1;
			unset($v['media']);
			unset($v['media_metadata']);
			unset($v['media_content']);
			unset($v['info']);
			unset($v['md5']);
			unset($v['dimensions']);
			unset($v['paths']);
			unset($v['md5']);
			$settings = caGetMediaDisplayInfo($context, $v['mimetype']);
		
			$v['class'] = caGetMediaClass($v['mimetype']);
			$v['viewer_width'] = $settings['viewer_width'];
			$v['viewer_height'] = $settings['viewer_height'];
			$v['version'] = $version = $settings['display_version'];
			
			if ($v['urls']['tilepic']) {
				$v['urls']['tilepic'] = "{$base_url}/service.php/IIIF/".$v['representation_id']."/info.json";
			}
			$v['url'] = $v['urls'][$version];
			$v['pages'] = $pages;
			
			unset($v['tags']);
			//unset($v['urls']);
			
			return $v;
		}, $replist));
		
		if(caGetOption('asJson', $options, false)) {
			return json_encode($replist);
		}
		
		return $replist;
	}
	# ------------------------------------------------------------------------------------------------
	/**
	 * 
	 */
	function xxx($yy=null) {
		
	}
	# ------------------------------------------------------------------------------------------------
