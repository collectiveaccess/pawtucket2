<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewers/MediaElement.php :
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

/**
 *
 */
require_once(__CA_LIB_DIR__.'/Configuration.php');
require_once(__CA_LIB_DIR__.'/Media/IMediaViewer.php');
require_once(__CA_LIB_DIR__.'/Media/BaseMediaViewer.php');

class MediaElement extends BaseMediaViewer implements IMediaViewer {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected static $s_callbacks = [];
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerHTML($po_request, $identifier, $data=null, $options=null) {
		if ($o_view = BaseMediaViewer::getView($po_request)) {
			$o_view->setVar('identifier', $identifier);
			$o_view->setVar('viewer', 'MediaElement');
			
			$t_instance = $data['t_instance'];
			$t_subject = $data['t_subject'];
			
			$o_view->setVar('id', $id = 'caMediaOverlayTimebased_'.$t_instance->getPrimaryKey().'_'.($display_type = caGetOption('display_type', $data, caGetOption('display_version', $data['display'], ''))));
			
			if (is_a($t_instance, "ca_object_representations")) {
				$viewer_opts = [
					'id' => $id, 'class' => caGetOption('class', $data['display'], null),
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'user_interface' => caGetOption('user_interface', $data['display'], null),
					'captions' => $t_instance->getCaptionFileList(),
					'controls' => caGetOption('controls', $data['display'], null),
					'dont_init_plyr' => caGetOption('dontInitPlyr', $options, caGetOption('dontInitPlyr', $data['display'], null)),
				];
				
				if (!$t_instance->hasMediaVersion('media', $version = caGetOption('display_version', $data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('media', $version = caGetOption('alt_display_version', $data['display'], 'original'))) {
						$version = 'original';
					}
				}
				
				// Image above 
				$viewer_image = null;
				if ($image_version = caGetOption('show_image_in_viewer', $data['display'], null)) {
					$image_reps = $t_subject->findRepresentations(['class' => 'image', 'version' => $image_version, 'checkAccess' => $options['checkAccess']]);
					
					$rep = array_filter($image_reps, function($v) { return isset($v['is_primary']) && (bool)$v['is_primary']; });
					$rep = (!sizeof($rep)) ? array_shift($image_reps) : array_shift($rep);
					
					$viewer_image = $rep['urls'][$image_version];
					$viewer_opts['poster_frame_url'] = $viewer_image;
				}
			
				// HTML for MediaElement
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $version, $viewer_opts));
			} elseif (is_a($t_instance, "ca_site_page_media")) {
				$viewer_opts = [
					'id' => $id, 'class' => caGetOption('class', $data['display'], null),
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'user_interface' => caGetOption('user_interface', $data['display'], null),
					'controls' => caGetOption('controls', $data['display'], null)
				];
				
				if (!$t_instance->hasMediaVersion('media', $version = caGetOption('display_version', $data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('media', $version = caGetOption('alt_display_version', $data['display'], 'original'))) {
						$version = 'original';
					}
				}
				
				// HTML for tileviewer
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $version, $viewer_opts));
			} else {
				$viewer_opts = [
					'id' => $id, 'class' => caGetOption('class', $data['display'], null),
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'user_interface' => caGetOption('user_interface', $data['display'], null),
					'controls' => caGetOption('controls', $data['display'], null)
				];
				
				$t_instance->useBlobAsMediaField(true);
				if (!$t_instance->hasMediaVersion('value_blob', $version = caGetOption('display_version', $data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('value_blob', $version = caGetOption('alt_display_version', $data['display'], 'original'))) {
						$version = 'original';
					}
				}
				
				// HTML for MediaElement
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('value_blob', $version, $viewer_opts));
			}
				
			return BaseMediaViewer::prepareViewerHTML($po_request, $o_view, $data, $options);
		}
		
		return _t("Could not load viewer");
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerData($po_request, $identifier, $data=null, $options=null) {
		return _t("No data");
	}
	# -------------------------------------------------------
}
