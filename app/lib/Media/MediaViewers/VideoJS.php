<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewers/VideoJS.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2023 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/Media/IMediaViewer.php');
require_once(__CA_LIB_DIR__.'/Media/BaseMediaViewer.php');

class VideoJS extends BaseMediaViewer implements IMediaViewer {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected static $s_callbacks = [];
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerHTML($request, $identifier, $data=null, $options=null) {
		if ($o_view = BaseMediaViewer::getView($request)) {
			$o_view->setVar('identifier', $identifier);
			$o_view->setVar('viewer', 'VideoJS');
			
			$t_instance = $data['t_instance'];
			$t_subject = $data['t_subject'];
			
			$o_view->setVar('id', $id = 'caMediaOverlayTimebased_'.$t_instance->getPrimaryKey().'_'.($display_type = caGetOption('display_type', $data, caGetOption('display_version', $data['display'], ''))));
			
			if (is_a($t_instance, "ca_object_representations")) {
				$poster = $t_instance->getMediaUrl('media', caGetOption('viewer_poster_version', $data['display'], 'small'));
				$viewer_opts = [
					'id' => $id, 'class' => caGetOption('class', $data['display'], null),
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'poster_frame_url' => $poster, 'captions' => $t_instance->getCaptionFileList(), 'autoplay' => caGetOption('autoplay', $data['display'], false),
					'controls' => caGetOption('controls', $data['display'], null),
					'dont_init_plyr' => caGetOption('dontInitPlyr', $options, caGetOption('dontInitPlyr', $data['display'], null)),
				];
				
				if (!$t_instance->hasMediaVersion('media', $version = caGetOption('display_version', $data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('media', $version = caGetOption('alt_display_version', $data['display'], 'original'))) {
						$version = 'original';
					}
				}
				
				if(is_array($controls_when = caGetOption('controls_when', $data['display'], null))) {
					foreach($controls_when as $n => $info) {
						$exp = $info['expression'] ?? null;
						if(!$exp) { continue; }
						
						$tags = caGetTemplateTags($exp);
						$values = [];
						foreach($tags as $t) {
							if (is_null($values[$t] = $t_instance->get($t, ['convertCodesToIdno' => true]))) {
								$values[$t] = $t_subject->get($t, ['convertCodesToIdno' => true]);
							}
						}
						if (ExpressionParser::evaluate($exp, $values)) {
							$viewer_opts['controls'] = $info['controls'];
							break;
						}
					}
				}
				
				// HTML for VideoJS
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $version, $viewer_opts));
			} elseif (is_a($t_instance, "ca_site_page_media")) {	
				if (!$t_instance->hasMediaVersion('media', $version = caGetOption('display_version', $data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('media', $version = caGetOption('alt_display_version', $data['display'], 'original'))) {
						$version = 'original';
					}
				}
				
				$poster = $t_instance->getMediaUrl('media', caGetOption('viewer_poster_version', $data['display'], 'small'));
				$viewer_opts = [
					'id' => $id, 'class' => caGetOption('class', $data['display'], null),
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'poster_frame_url' => $poster
				];
				
				// HTML for tileviewer
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $version, $viewer_opts));
			} else {
				$t_instance->useBlobAsMediaField(true);
				if (!$t_instance->hasMediaVersion('value_blob', $version = caGetOption('display_version', $data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('value_blob', $version = caGetOption('alt_display_version', $data['display'], 'original'))) {
						$version = 'original';
					}
				}
				$poster = $t_instance->getMediaUrl('value_blob', caGetOption('viewer_poster_version', $data['display'], 'small'));
				$viewer_opts = [
					'id' => $id, 'class' => caGetOption('class', $data['display'], null),
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'poster_frame_url' => $poster
				];
				
				// HTML for VideoJS
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('value_blob', $version, $viewer_opts));
			}
			
				
			return BaseMediaViewer::prepareViewerHTML($request, $o_view, $data, $options);
		}
		
		return _t("Could not load viewer");
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerData($request, $identifier, $data=null, $options=null) {
		return _t("No data");
	}
	# -------------------------------------------------------
}
