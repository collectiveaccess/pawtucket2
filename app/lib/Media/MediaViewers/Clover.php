<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewers/Clover.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2023 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/Configuration.php');
require_once(__CA_LIB_DIR__.'/Media/IMediaViewer.php');
require_once(__CA_LIB_DIR__.'/Media/BaseMediaViewer.php');

class Clover extends BaseMediaViewer implements IMediaViewer {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected static $s_callbacks = [];
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerHTML($po_request, $ps_identifier, $pa_data=null, $pa_options=null) {
		$config = Configuration::load();
		if ($o_view = BaseMediaViewer::getView($po_request)) {
			$o_view->setVar('identifier', $ps_identifier);
			$o_view->setVar('viewer', 'Clover');
			
			$t_instance = $pa_data['t_instance'];
			$t_subject = $pa_data['t_subject'];
			
			if (!$t_instance->hasMediaVersion('media', $vs_version = caGetOption('display_version', $pa_data['display'], 'tilepic'))) {
				if (!$t_instance->hasMediaVersion('media', $vs_version = caGetOption('alt_display_version', $pa_data['display'], 'tilepic'))) {
					$vs_version = 'original';
				}
			}
			
			$o_view->setVar('data_url', $config->get('site_host').$config->get('ca_url_root').'/service/IIIF/manifest/'.$t_subject->tableName().':'.$t_subject->getPrimaryKey());
			
			$o_view->setVar('id', $vs_id = 'caMediaOverlayClover_'.$t_instance->getPrimaryKey().'_'.($vs_display_type = caGetOption('display_type', $pa_data, caGetOption('display_version', $pa_data['display'], ''))));
			
			if (is_a($t_instance, "ca_object_representations")) {
				$va_viewer_opts = [
					'id' => $vs_id,
					'viewer_width' => caGetOption('viewer_width', $pa_data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $pa_data['display'], '100%'),
					'viewer_base_url' => $po_request->getBaseUrlPath(),
					'annotation_load_url' => caNavUrl($po_request, '*', '*', 'GetAnnotations', array('csrfToken' => caGenerateCSRFToken($po_request), 'representation_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey())),
					'annotation_save_url' => caNavUrl($po_request, '*', '*', 'SaveAnnotations', array('csrfToken' => caGenerateCSRFToken($po_request), 'representation_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey())),
					'download_url' => caNavUrl($po_request, '*', '*', 'DownloadMedia', array('csrfToken' => caGenerateCSRFToken($po_request), 'representation_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey(), 'version' => 'original')),
					'help_load_url' => caNavUrl($po_request, '*', '*', 'ViewerHelp', array()),
					'annotationEditorPanel' => 'caRepresentationAnnotationEditor',
					'read_only' => !$po_request->isLoggedIn(),
					'annotationEditorUrl' => caNavUrl($po_request, 'editor/representation_annotations', 'RepresentationAnnotationQuickAdd', 'Form', array('csrfToken' => caGenerateCSRFToken($po_request), 'representation_id' => (int)$t_instance->getPrimaryKey())),
					'captions' => $t_instance->getCaptionFileList(), 'progress_id' => 'caMediaOverlayProgress'
				];
				
				$vb_no_overlay = (caGetOption('no_overlay', $pa_data['display'], null) || caGetOption('noOverlay', $pa_options, null));
				if($vb_no_overlay){
					// HTML for Clover
					$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $vs_version, $va_viewer_opts));
				}else{
					// HTML for Clover
					$o_view->setVar('viewerHTML', "<a href='#' class='zoomButton' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Detail', 'GetMediaOverlay', array('context' => caGetOption('context', $pa_options, null), 'id' => (int)$t_subject->getPrimaryKey(), 'representation_id' => (int)$t_instance->getPrimaryKey(), 'overlay' => 1))."\"); return false;'>".$t_instance->getMediaTag('media', $vs_version, $va_viewer_opts)."</a>");
				}
			} elseif (is_a($t_instance, "ca_site_page_media")) {
				$va_viewer_opts = [
					'id' => $vs_id,
					'read_only' => true,
					'viewer_width' => caGetOption('viewer_width', $pa_data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $pa_data['display'], '100%'),
					'viewer_base_url' => $po_request->getBaseUrlPath(),
					'download_url' => caNavUrl($po_request, '*', '*', 'DownloadMedia', array('media_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey(), 'version' => 'original')),
					'help_load_url' => caNavUrl($po_request, '*', '*', 'ViewerHelp', array())
				];
				
				// HTML for Clover
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('media', $vs_version, $va_viewer_opts));
			} else {
				$va_viewer_opts = [
					'id' => 'caMediaOverlayClover',
					'viewer_width' => caGetOption('viewer_width', $pa_data['display'], '100%'), 'viewer_height' => caGetOption('viewer_height', $pa_data['display'], '100%'),
					'read_only' => true,
					'viewer_base_url' => $po_request->getBaseUrlPath(),
					'download_url' => caNavUrl($po_request, '*', '*', 'DownloadMedia', array('value_id' => (int)$t_instance->getPrimaryKey(), $t_subject->primaryKey() => (int)$t_subject->getPrimaryKey(), 'version' => 'original')),
					'help_load_url' => caNavUrl($po_request, '*', '*', 'ViewerHelp', array()),
					'read_only' => !$po_request->isLoggedIn(),
					'captions' => null, 'progress_id' => 'caMediaOverlayProgress'
				];
				
				$t_instance->useBlobAsMediaField(true);
				if (!$t_instance->hasMediaVersion('value_blob', $vs_version = caGetOption('display_version', $pa_data['display'], 'original'))) {
					if (!$t_instance->hasMediaVersion('value_blob', $vs_version = caGetOption('alt_display_version', $pa_data['display'], 'original'))) {
						$vs_version = 'original';
					}
				}
				
				// HTML for Clover
				$o_view->setVar('viewerHTML', $t_instance->getMediaTag('value_blob', $vs_version, $va_viewer_opts));
			}
			
				
			return BaseMediaViewer::prepareViewerHTML($po_request, $o_view, $pa_data, $pa_options);
		}
		
		return _t("Could not load viewer");
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerData($po_request, $ps_identifier, $pa_data=null, $pa_options=null) {
		header("Content-type: text/json");
		$access_values = caGetUserAccessValues($po_request);
		if ($o_view = BaseMediaViewer::getView($po_request)) {
			if ($t_instance = caGetOption('t_instance', $pa_data, null)) {
				$t_subject = caGetOption('t_subject', $pa_data, null);
			
				$va_display = caGetOption('display', $pa_data, []);
				
				if(is_a($t_instance, "ca_object_representations") || is_a($t_instance, "ca_site_page_media")) {
					$vs_media_fld = 'media';
				} elseif(is_a($t_instance, "ca_attribute_values")) {
					$vs_media_fld = 'value_blob';
				} else {
					throw new ApplicationException(_t('Could not derive media dimensions'));
				}		
								
				$va_labels = [];
				
				$pa_data['width'] = $t_instance->getMediaInfo($vs_media_fld, 'original', 'WIDTH');
				$pa_data['height'] = $t_instance->getMediaInfo($vs_media_fld, 'original', 'HEIGHT');
				
				$o_view->setVar('id', 'caMediaOverlayMirador_'.$t_instance->getPrimaryKey().'_'.($vs_display_type = caGetOption('display_type', $pa_data, caGetOption('display_version', $pa_data['display'], ''))));
			
				$vn_use_mirador_for_image_list_length = caGetOption('use_mirador_for_image_list_length_at_least', $pa_data['display'], null);
				if (((($vs_display_version = caGetOption('display_version', $pa_data['display'], 'tilepic')) == 'tilepic')) && !$vn_use_mirador_for_image_list_length) {
					$pa_data['resources'] = $t_instance->getFileList(null, null, null, [$vs_display_version, 'preview']);
				} elseif (is_a($t_instance, "ca_object_representations") && $pa_data['t_subject'] && $vn_use_mirador_for_image_list_length && ($va_reps = $pa_data['t_subject']->getRepresentations(['small', $vs_display_version, 'original'], null, []))) {
					$t_rep = new ca_object_representations();
					
					if (is_a($t_instance, "ca_object_representations") && caGetOption('expand_hierarchically', $pa_data['display'], null) && $pa_data['t_subject'] && $pa_data['t_subject']->isHierarchical() && (is_array($va_ids = $pa_data['t_subject']->getHierarchy(null, ['idsOnly' => true, 'sort' => 'idno_sort']))) && (sizeof($va_ids) > 1)) {  
						$vn_root_id = $pa_data['t_subject']->getHierarchyRootID();
						$va_ids = array_filter($va_ids, function($v) use ($vn_root_id) { return $v != $vn_root_id; });
						$va_reps = $pa_data['t_subject']->getPrimaryMediaForIDs($va_ids, ['small', $vs_display_version, 'original']);
					}
					
					if(sizeof($va_reps) < $vn_use_mirador_for_image_list_length) {
						$pa_data['resources'][] = [
							'url' => $pa_data['t_instance']->getMediaUrl($vs_media_fld, $vs_display_version)
						];
					} else {
						$va_labels = $t_rep->getPreferredDisplayLabelsForIDs(caExtractArrayValuesFromArrayOfArrays($va_reps, 'representation_id'));
	
						foreach($va_reps as $va_rep) {
							if (is_array($access_values) && sizeof($access_values) && !in_array($va_rep['access'], $access_values)) { continue; }
							$pa_data['resources'][] = [
								'title' => str_replace("[".caGetBlankLabelText('ca_object_representations')."]", "", $va_labels[$va_rep['representation_id']]),
								'representation_id' => $va_rep['representation_id'],
								'preview_url' => $va_rep['urls']['small'],
								'url' => $va_rep['urls'][$vs_display_version],
								'width' => $va_rep['info']['original']['WIDTH'],
								'height' => $va_rep['info']['original']['HEIGHT'],
								'noPages' => true
							];
						}
					}
				} else {
					$pa_data['resources'][] = [
						'url' => $pa_data['t_instance']->getMediaUrl($vs_media_fld, $vs_display_version)
					];
				}
				
				$o_view->setVar('t_subject', $pa_data['t_subject']);
				$o_view->setVar('t_instance', $t_instance);
				$o_view->setVar('request', $po_request);
				$o_view->setVar('identifier', $ps_identifier);
				$o_view->setVar('data', $pa_data);
				
				return $o_view->render("CloverManifest.php");
			}
		}
		
		throw new ApplicationException(_t('Media manifest is not available'));
	}
	# -------------------------------------------------------
}
