<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewers/TileViewer.php :
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

class TileViewer extends BaseMediaViewer implements IMediaViewer {
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
			$o_view->setVar('viewer', 'TileViewer');
			
			$t_instance = $data['t_instance'];
			$t_subject = $data['t_subject'];
			
			if (!$t_instance->hasMediaVersion('media', $version = caGetOption('display_version', $data['display'], 'tilepic'))) {
				if (!$t_instance->hasMediaVersion('media', $version = caGetOption('alt_display_version', $data['display'], 'tilepic'))) {
					$version = 'original';
				}
			}
			
			$o_view->setVar('id', $id = 'caMediaOverlayTileViewer_'.$t_instance->getPrimaryKey().'_'.($display_type = caGetOption('display_type', $data, caGetOption('display_version', $data['display'], ''))));
			
			if (is_a($t_instance, "ca_object_representations")) {
				$viewer_opts = [
					'id' => $id,
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'viewer_base_url' => $request->getBaseUrlPath(),
					'annotation_load_url' => caNavUrl($request, '*', '*', 'GetAnnotations', array('csrfToken' => caGenerateCSRFToken($request), 'representation_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey())),
					'annotation_save_url' => caNavUrl($request, '*', '*', 'SaveAnnotations', array('csrfToken' => caGenerateCSRFToken($request), 'representation_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey())),
					'download_url' => caNavUrl($request, '*', '*', 'DownloadMedia', array('csrfToken' => caGenerateCSRFToken($request), 'representation_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey(), 'version' => 'original')),
					'help_load_url' => caNavUrl($request, '*', '*', 'ViewerHelp', array()),
					'annotationEditorPanel' => 'caRepresentationAnnotationEditor',
					'read_only' => !$request->isLoggedIn(),
					'annotationEditorUrl' => caNavUrl($request, 'editor/representation_annotations', 'RepresentationAnnotationQuickAdd', 'Form', array('csrfToken' => caGenerateCSRFToken($request), 'representation_id' => (int)$t_instance->getPrimaryKey())),
					'captions' => $t_instance->getCaptionFileList(), 'progress_id' => 'caMediaOverlayProgress'
				];
				
				$vb_no_overlay = (caGetOption('no_overlay', $data['display'], null) || caGetOption('noOverlay', $options, null));
				if($vb_no_overlay){
					// HTML for tileviewer
					$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $version, $viewer_opts));
				}else{
					// HTML for tileviewer
					$o_view->setVar('viewerHTML', "<a href='#' class='zoomButton' onclick='caMediaPanel.showPanel(\"".caNavUrl($request, '', 'Detail', 'GetMediaOverlay', array('context' => caGetOption('context', $options, null), 'id' => (int)$t_subject->getPrimaryKey(), 'representation_id' => (int)$t_instance->getPrimaryKey(), 'overlay' => 1))."\"); return false;'>".$t_instance->getMediaTag('media', $version, $viewer_opts)."</a>");
				}
			} elseif (is_a($t_instance, "ca_site_page_media")) {
				$viewer_opts = [
					'id' => $id,
					'read_only' => true,
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'viewer_base_url' => $request->getBaseUrlPath(),
					'download_url' => caNavUrl($request, '*', '*', 'DownloadMedia', array('media_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey(), 'version' => 'original')),
					'help_load_url' => caNavUrl($request, '*', '*', 'ViewerHelp', array())
				];
				
				// HTML for tileviewer
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $version, $viewer_opts));
			} else {
				$viewer_opts = [
					'id' => 'caMediaOverlayTileViewer',
					'viewer_width' => caGetOption('viewer_width', $data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $data['display'], '100%'),
					'read_only' => true,
					'viewer_base_url' => $request->getBaseUrlPath(),
					'download_url' => caNavUrl($request, '*', '*', 'DownloadMedia', array('value_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey(), 'version' => 'original')),
					'help_load_url' => caNavUrl($request, '*', '*', 'ViewerHelp', array()),
					'read_only' => !$request->isLoggedIn(),
					'captions' => null, 'progress_id' => 'caMediaOverlayProgress'
				];
				
				$t_instance->useBlobAsMediaField(true);
				if (!$t_instance->hasMediaVersion('value_blob', $version = caGetOption('display_version', $data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('value_blob', $version = caGetOption('alt_display_version', $data['display'], 'original'))) {
						$version = 'original';
					}
				}
				
				// HTML for tileviewer
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
