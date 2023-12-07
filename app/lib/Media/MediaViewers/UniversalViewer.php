<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewers/UniversalViewer.php :
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
require_once(__CA_LIB_DIR__."/MediaContentLocationIndexer.php");
require_once(__CA_MODELS_DIR__.'/ca_object_representations.php');

class UniversalViewer extends BaseMediaViewer implements IMediaViewer {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected static $s_callbacks = ['getViewerManifest'];
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerHTML($request, $identifier, $data=null, $options=null) {
		if ($o_view = BaseMediaViewer::getView($request)) {
			$o_view->setVar('identifier', $identifier);
			
			$params = ['identifier' => $identifier, 'context' => caGetOption('context', $options, $request->getAction())];
			
			// Pass subject key when getting viewer data
			if ($data['t_subject']) { $params[$data['t_subject']->primaryKey()] = $data['t_subject']->getPrimaryKey(); }
			
			$o_view->setVar('data_url', caNavUrl($request, '*', '*', 'GetMediaData', $params, ['absolute' => true]));
			$o_view->setVar('viewer', 'UniversalViewer');
			$o_view->setVar('width', caGetOption('width', $data['display'], null));
			$o_view->setVar('height', caGetOption('height', $data['display'], null));
		}
		
		return BaseMediaViewer::prepareViewerHTML($request, $o_view, $data, $options);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerData($request, $identifier, $data=null, $options=null) {
		$access_values = caGetUserAccessValues($request);
		if ($o_view = BaseMediaViewer::getView($request)) {
			if ($t_instance = caGetOption('t_instance', $data, null)) {
			
				$display = caGetOption('display', $data, []);
				
				if(is_a($t_instance, "ca_object_representations") || is_a($t_instance, "ca_site_page_media")) {
					$media_fld = 'media';
				} elseif(is_a($t_instance, "ca_attribute_values")) {
					$media_fld = 'value_blob';
				} else {
					throw new ApplicationException(_t('Could not derive media dimensions'));
				}
				
				$data['width'] = $t_instance->getMediaInfo($media_fld, 'original', 'WIDTH');
				$data['height'] = $t_instance->getMediaInfo($media_fld, 'original', 'HEIGHT');
				
				$o_view->setVar('id', 'caMediaOverlayUniversalViewer_'.$t_instance->getPrimaryKey().'_'.($display_type = caGetOption('display_type', $data, caGetOption('display_version', $data['display'], ''))));
			
				$vn_use_universal_viewer_for_image_list_length = caGetOption('use_universal_viewer_for_image_list_length_at_least', $data['display'], null);
				if (((($display_version = caGetOption('display_version', $data['display'], 'tilepic')) == 'tilepic')) && !$vn_use_universal_viewer_for_image_list_length) {
					$data['resources'] = $t_instance->getFileList(null, null, null, [$display_version, 'preview']);
				} elseif (is_a($t_instance, "ca_object_representations") && $data['t_subject'] && $vn_use_universal_viewer_for_image_list_length) {
					$reps = $data['t_subject']->getRepresentations(['small', $display_version, 'original'], null, []);
					
					$t_rep = new ca_object_representations();
					$labels = $t_rep->getPreferredDisplayLabelsForIDs(caExtractArrayValuesFromArrayOfArrays($reps, 'representation_id'));
	
					foreach($reps as $rep) {
						if (is_array($access_values) && sizeof($access_values) && !in_array($rep['access'], $access_values)) { continue; }
						$data['resources'][] = [
							'title' => str_replace("[".caGetBlankLabelText('ca_object_representations')."]", "", $labels[$rep['representation_id']]),
							'representation_id' => $rep['representation_id'],
							'preview_url' => $rep['urls']['small'],
							'url' => $rep['urls'][$display_version],
							'width' => $rep['info']['original']['WIDTH'],
							'height' => $rep['info']['original']['HEIGHT'],
							'noPages' => true
						];
					}
				} else {
					$data['resources'][] = [
						'url' => $data['t_instance']->getMediaUrl($media_fld, $display_version)
					];
				}
				
				$o_view->setVar('t_subject', $data['t_subject']);
				$o_view->setVar('request', $request);
				$o_view->setVar('identifier', $identifier);
				$o_view->setVar('data', $data);
				
				return $o_view->render("UniversalViewerManifest.php");
			}
		}
		
		throw new ApplicationException(_t('Media manifest is not available'));
	}
	
	# -------------------------------------------------------
	/**
	 * Return word occurrence data for in-viewer search
	 *
	 * @param RequestHTTP $request
	 * @param string $identifier Media identifier
	 * @param array $data Viewer request data
	 * @param array $options No options are currently supported
	 *
	 * @return sting IIIF search API manifest
	 * @throws ApplicationException
	 */
	public static function searchViewerData($request, $identifier, $data=null, $options=null) {
		if ($o_view = BaseMediaViewer::getView($request)) {
			$q = $request->getParameter('q', pString);
			
			$identifier = caParseMediaIdentifier($identifier);
			$t_rep = new ca_object_representations();
			$t_attr = new ca_attribute_values();
			if (
				($identifier['type'] == 'representation') && (!is_array($pages = $t_rep->getFileList($identifier['id'], 0, 1, ['original'])) || !sizeof($pages))
				||
				
				($identifier['type'] == 'attribute') && (!is_array($pages = $t_attr->getFileList($identifier['id'], 0, 1, ['original'])) || !sizeof($pages))
			) {
				$data['width'] = $data['height'] = 0;
				$locs = [];
			} else {
				$page = array_shift($pages);
				$data['width'] = $page['original_width'];
				$data['height'] = $page['original_height'];
				switch($identifier['type']) {
					case 'representation':
					default:
						$locs = MediaContentLocationIndexer::SearchWithinMedia($q, 'ca_object_representations', $identifier['id'], 'media');
						break;
					case 'attribute':
						$locs = MediaContentLocationIndexer::SearchWithinMedia($q, 'ca_attribute_values', $identifier['id'], 'value_blob');
						break;
				}
			}
			
			$o_view->setVar('request', $request);
			$o_view->setVar('identifier', $identifier);
			$o_view->setVar('data', $data);
			
			$o_view->setVar('locations', $locs);
			return $o_view->render("UniversalViewerSearchManifest.php");
		}
		
		throw new ApplicationException(_t('Media search is not available'));
	}
	# -------------------------------------------------------
	/**
	 * Return autocomplete matches for in-viewer search
	 *
	 * @param RequestHTTP $request
	 * @param string $identifier Media identifier
	 * @param array $data Viewer request data
	 * @param array $options No options are currently supported
	 *
	 * @return sting IIIF autocomplete manifest
	 * @throws ApplicationException
	 */
	public static function autocomplete($request, $identifier, $data=null, $options=null) {
		if ($o_view = BaseMediaViewer::getView($request)) {
			$q = $request->getParameter('q', pString);
			
			$identifier = caParseMediaIdentifier($identifier);
			switch($identifier['type']) {
				case 'representation':
				default:
					$matches = MediaContentLocationIndexer::autocomplete($q, 'ca_object_representations', $identifier['id']);
					break;
				case 'attribute':
					$matches = MediaContentLocationIndexer::autocomplete($q, 'ca_attribute_values', $identifier['id']);
					break;
			}
		   
			$o_view->setVar('request', $request);
			$o_view->setVar('identifier', $identifier);
			
			$o_view->setVar('matches', $matches);
			return $o_view->render("UniversalViewerAutocomplete.php");
		}
		
		throw new ApplicationException(_t('Media search autocomplete is not available'));
	}
	# -------------------------------------------------------
}
