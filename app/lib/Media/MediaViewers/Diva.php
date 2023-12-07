<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewers/Diva.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019-2023 Whirl-i-Gig
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

class Diva extends BaseMediaViewer implements IMediaViewer {
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
			if ($data['t_subject']) { 
				$params[$data['t_subject']->primaryKey()] = $data['t_subject']->getPrimaryKey(); 
				
				$o_view->setVar('index', 0);
				if ($data['t_instance']) {
					$rep_id = $data['t_instance']->getPrimaryKey();
					if (is_array($rep_ids = Diva::getViewerRepresentationIDList($request, $identifier, $data, $options))) {
						$o_view->setVar('index', array_search($rep_id, $rep_ids));
					}
				}
			}
			
			$o_view->setVar('data_url', caNavUrl($request, '*', '*', 'GetMediaData', $params, ['absolute' => true]));
			$o_view->setVar('viewer', 'Diva');
			$o_view->setVar('width', caGetOption('width', $data['display'], null));
			$o_view->setVar('height', caGetOption('height', $data['display'], null));
			$o_view->setVar('data', $data);
		}
		
		return BaseMediaViewer::prepareViewerHTML($request, $o_view, $data, $options);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerRepresentationIDList($request, $identifier, $data=null, $options=null) {
		if ($t_instance = caGetOption('t_instance', $data, null)) {
		
			$display = caGetOption('display', $data, []);
			
			if(is_a($t_instance, "ca_object_representations") || is_a($t_instance, "ca_site_page_media")) {
				$media_fld = 'media';
			} elseif(is_a($t_instance, "ca_attribute_values")) {
				$media_fld = 'value_blob';
			} else {
				throw new ApplicationException(_t('Could not derive media dimensions'));
			}
			
			$use_diva_for_image_list_length = caGetOption('use_diva_for_image_list_length_at_least', $data['display'], null);
			if (is_a($t_instance, "ca_object_representations") && caGetOption('expand_hierarchically', $data['display'], null) && $data['t_subject'] && $data['t_subject']->isHierarchical() && (is_array($ids = $data['t_subject']->getHierarchy(null, ['idsOnly' => true, 'sort' => 'idno_sort']))) && sizeof($ids)) {  
				$root_id = $data['t_subject']->getHierarchyRootID();
				$ids = array_filter($ids, function($v) use ($root_id) { return $v != $root_id; });
				return array_values(array_map(function($v) { return $v['representation_id']; }, $data['t_subject']->getPrimaryMediaForIDs($ids, ['small'])));
			} elseif (is_a($t_instance, "ca_object_representations") && $data['t_subject'] && $use_diva_for_image_list_length && ($reps = $data['t_subject']->getRepresentations(['small'], null, [])) && (sizeof($reps) >= $use_diva_for_image_list_length)) {
				return array_values(array_map(function($v) { return $v['representation_id']; }, $reps));
			}
		}
		return null;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerData($request, $identifier, $data=null, $options=null) {
		if ($o_view = BaseMediaViewer::getView($request)) {
			if ($t_instance = caGetOption('t_instance', $data, null)) {
				$t_subject = caGetOption('t_subject', $data, null);
			
				$display = caGetOption('display', $data, []);
				
				if(is_a($t_instance, "ca_object_representations") || is_a($t_instance, "ca_site_page_media")) {
					$media_fld = 'media';
				} elseif(is_a($t_instance, "ca_attribute_values")) {
					$media_fld = 'value_blob';
				} else {
					throw new ApplicationException(_t('Could not derive media dimensions'));
				}		
								
				$labels = [];
				
				$data['width'] = $t_instance->getMediaInfo($media_fld, 'original', 'WIDTH');
				$data['height'] = $t_instance->getMediaInfo($media_fld, 'original', 'HEIGHT');
				
				$o_view->setVar('id', 'caMediaOverlayDiva_'.$t_instance->getPrimaryKey().'_'.($display_type = caGetOption('display_type', $data, caGetOption('display_version', $data['display'], ''))));
			
				$use_diva_for_image_list_length = caGetOption('use_diva_for_image_list_length_at_least', $data['display'], null);
				if (((($display_version = caGetOption('display_version', $data['display'], 'tilepic')) == 'tilepic')) && !$use_diva_for_image_list_length) {
					$data['resources'] = $t_instance->getFileList(null, null, null, [$display_version, 'preview']);
				} elseif (is_a($t_instance, "ca_object_representations") && $data['t_subject'] && $use_diva_for_image_list_length && ($reps = $data['t_subject']->getRepresentations(['small', $display_version, 'original'], null, []))) {
					$t_rep = new ca_object_representations();
					
					if (is_a($t_instance, "ca_object_representations") && caGetOption('expand_hierarchically', $data['display'], null) && $data['t_subject'] && $data['t_subject']->isHierarchical() && (is_array($ids = $data['t_subject']->getHierarchy(null, ['idsOnly' => true, 'sort' => 'idno_sort']))) && (sizeof($ids) > 1)) {  
						$root_id = $data['t_subject']->getHierarchyRootID();
						$ids = array_filter($ids, function($v) use ($root_id) { return $v != $root_id; });
						$reps = $data['t_subject']->getPrimaryMediaForIDs($ids, ['small', $display_version, 'original']);
					}
					
					if(sizeof($reps) < $use_diva_for_image_list_length) {
						$data['resources'][] = [
							'url' => $data['t_instance']->getMediaUrl($media_fld, $display_version)
						];
					} else {
						$labels = $t_rep->getPreferredDisplayLabelsForIDs(caExtractArrayValuesFromArrayOfArrays($reps, 'representation_id'));
	
						foreach($reps as $rep) {
							$data['resources'][] = [
								'title' => str_replace("[".caGetBlankLabelText('ca_object_representations')."]", "", $labels[$rep['representation_id']]),
								'representation_id' => $rep['representation_id'],
								'preview_url' => $rep['urls']['small'],
								'url' => $rep['urls'][$display_version],
								'width' => $rep['info'][$display_version]['WIDTH'],
								'height' => $rep['info'][$display_version]['HEIGHT'],
								'noPages' => true
							];
						}
					}
				} else {
					$data['resources'][] = [
						'url' => $data['t_instance']->getMediaUrl($media_fld, $display_version)
					];
				}
				
				
				$o_view->setVar('t_subject', $data['t_subject']);
				$o_view->setVar('t_instance', $t_instance);
				$o_view->setVar('request', $request);
				$o_view->setVar('identifier', $identifier);
				$o_view->setVar('data', $data);
				
				return $o_view->render("DivaManifest.php");
			}
		}
		
		throw new ApplicationException(_t('Media manifest is not available'));
	}
	# -------------------------------------------------------
}
