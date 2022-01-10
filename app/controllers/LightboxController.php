<?php
/* ----------------------------------------------------------------------
 * controllers/LightboxController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2021 Whirl-i-Gig
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
 
require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
require_once(__CA_LIB_DIR__.'/Parsers/ZipStream.php');
require_once(__CA_LIB_DIR__.'/Logging/Downloadlog.php');
require_once(__CA_APP_DIR__."/controllers/BrowseController.php");

class LightboxController extends BrowseController {
	# -------------------------------------------------------
	/**
	 * @var array
	 */
	 protected $access_values;

	/**
	 * @var array
	 */
	 protected $user_groups;

	/**
	 * @var string
	 */
	 protected $lightbox_display_name;

	/**
	 * @var string
	 */
	 protected $lightbox_display_name_plural;
	
	/**
	 * @var HTMLPurifier
	 */
	protected $purifier;
	
	/**
	 * @var string
	 */
	protected $ops_tablename = 'ca_objects';
	
	/**
	 *
	 */
	protected $ops_view_prefix = 'Lightbox';
	protected $ops_description_attribute;
	
	# -------------------------------------------------------
	/**
	 * @param RequestHTTP $po_request
	 * @param ResponseHTTP $po_response
	 * @param null $pa_view_paths
	 * @throws ApplicationException
	 */
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		$this->ops_find_type = 'lightbox';

		parent::__construct($po_request, $po_response, $pa_view_paths);

		// Catch disabled lightbox
		if ($this->request->config->get('disable_lightbox')) {
			throw new ApplicationException('Lightbox is not enabled');
		}
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function _checkAccess() {
		$t_set = null;
		if($token = $this->request->getParameter('token', pString)) {
			$t_set = ca_sets::getInstanceByGUID($token);
			if($t_set) { // && in_array((int)$t_set->get('ca_sets.access'), caGetUserAccessValues(), true)) {
				return $t_set;
			}
		}
		
		if (!($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl("", "LoginReg", "LoginForm"));
			return false;
		}
		
		return true;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function index($options = null) {
		if(!($ret = $this->_checkAccess())) { throw new ApplicationException(_('Lightbox is not available')); }
		
		$this->view->setVar("config", caGetLightboxConfig());
		caSetPageCSSClasses(["lightbox", "results"]);
		
		$this->opo_result_context = new ResultContext($this->request, 'ca_objects', 'lightbox');
		$this->opo_result_context->setAsLastFind();
		
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").ucfirst($this->lightbox_display_name));
		
		// Set API access key
		if(method_exists($ret, 'getGUID')) {
			// Anonymous access
			$key = GraphQLServices\GraphQLServiceController::encodeJWTRefresh(['anonymous' => $ret->getGUID()]);
		} else {
			// Authenticated user access
			$key = GraphQLServices\GraphQLServiceController::encodeJWTRefresh(['id' => $this->request->user->getPrimaryKey()]);
		}
		$this->view->setVar('key', $key);
		
		$this->render(caGetOption("view", $options, "Lightbox/index_html.php"));
	}
	# -------------------------------------------------------
	/**
	 * View lightbox using anonymous access token in the form 
	 * http://mysite.com/Lightbox/view/b7cb7ba3-dcec-43b7-9de0-951491780e2d
	 */
	public function view($options = null) {
		$this->request->setParameter('token', $this->request->getActionExtra());
		return $this->index($options);
	}
	# -------------------------------------------------------
	/**
	 * Download (accessible) media
	 * have support for all in set (just set_id), array of hand selected in set (set_id and record_ids - string of ids separated by ;) and cache key (set_id, key, sort, sort_direction)
	 */
	public function getSetMedia() {
		if(!$this->_checkAccess()) { throw new ApplicationException(_('Lightbox is not available')); }
		set_time_limit(600); // allow a lot of time for this because the sets can be potentially large
		$va_errors = [];

		$set_id = $this->request->getParameter('set_id', pInteger);
		$key = $this->request->getParameter('key', pString);
		if($record_ids = $this->request->getParameter('record_ids', pString)){
			$record_ids = explode(";", $record_ids);
		}
		
		if(!$record_ids && $key){
			$o_browse = caGetBrowseInstance("ca_objects");
			$o_browse->reload($key);
			$qr_res = $o_browse->getResults(array('sort' => $this->request->getParameter('sort', pString), 'sort_direction' => $this->request->getParameter('sort_direction', pString)));
			$record_ids = $qr_res->getPrimaryKeyValues(1000);
		}
		
		if (($t_set = ca_sets::find(['set_id' => $set_id], ['returnAs' => 'firstModelInstance'])) && $t_set->haveAccessToSet($this->request->getUserID(), __CA_SET_READ_ACCESS__)) {			
			$va_set_record_ids = array_keys($t_set->getItemRowIDs(array('checkAccess' => $this->access_values, 'limit' => 100000)));
			if(!$record_ids){
				$record_ids = $va_set_record_ids;	
			}
			if(!is_array($record_ids) || !sizeof($record_ids)) {
				$va_errors[] = _t('No media is available for download');				
			}
			$vs_subject_table = Datamodel::getTableName($t_set->get('table_num'));
			# --- lightbox is only for objects
			if($vs_subject_table != "ca_objects"){
				$va_errors[] = _t('This is not an object set');
			}
			if(sizeof($va_errors) == 0){
				$t_instance = Datamodel::getInstanceByTableName($vs_subject_table);
				if(!$qr_res){
					$qr_res = $vs_subject_table::createResultSet($record_ids);
# TODO: all media or primary?	Currenlty only primary					$qr_res->filterNonPrimaryRepresentations(false);
				}
				$va_paths = array();
				while($qr_res->nextHit()) {
					if(((is_array($this->access_values)) && (sizeof($this->access_values)) && ((!in_array($qr_res->get("ca_objects.access"), $this->access_values)) || (!in_array($qr_res->get("ca_object_representations.access"), $this->access_values)))) || (!in_array($qr_res->get("ca_objects.object_id"), $va_set_record_ids))){
						continue;
					}

					$va_rep_display_info = caGetMediaDisplayInfo('download', $qr_res->getMediaInfo('ca_object_representations.media', 'INPUT', 'MIMETYPE'));
					$vs_media_version = $va_rep_display_info['download_version'];
					$va_original_paths = $qr_res->getMediaPaths('ca_object_representations.media', $vs_media_version);
					if(sizeof($va_original_paths)>0) {
						$info = $qr_res->getMediaInfo('ca_object_representations.media');
						$va_paths[$qr_res->get($t_instance->primaryKey())] = array(
							'idno' => $qr_res->get($t_instance->getProperty('ID_NUMBERING_ID_FIELD')),
							# --- this path is only the primary rep path
							'paths' => $va_original_paths,
							'rep_id' => $qr_res->get("ca_object_representations.representation_id"),
							'original_filename' => caGetOption('ORIGINAL_FILENAME', $info, null)
						);
					}
				}
				if (sizeof($va_paths) > 0){
					$o_zip = new ZipStream();
						
					foreach($va_paths as $vn_pk => $va_path_info) {
						$vn_c = 1;
						foreach($va_path_info['paths'] as $vs_path) {
							if (!file_exists($vs_path)) { continue; }
							
							$vs_filename = caGetRepresentationDownloadFileName($t_instance->tableName(), ['idno' => $va_path_info['idno'], 'index' => $vn_c, 'version' => $vs_media_version, 'extension' => pathinfo($vs_path, PATHINFO_EXTENSION), 'original_filename' => $va_info['ORIGINAL_FILENAME'], 'representation_id' => $va_path_info['rep_id']]);		
							
							$o_zip->addFile($vs_path, $vs_filename);

							$vn_c++;
						}
					}

					// send files
					$this->view->setVar('zip_stream', $o_zip);
					$this->view->setVar('archive_name', 'media_for_'.mb_substr(preg_replace('![^A-Za-z0-9]+!u', '_', ($vs_set_code = $t_set->get('set_code')) ? $vs_set_code : $t_set->getPrimaryKey()), 0, 20).'.zip');
					$this->render('bundles/download_file_binary.php');
					return;
				} else {
					$data = ['status' => 'err', 'error' => _t('No media is available for download')];
				}


			}else{
				$data = ['status' => 'err', 'error' => _t("There was an error").": ".join($va_errors, "; ")];
			}
		}else{
			$data = ['status' => 'err', 'error' => _t('Invalid set id')];
		}
		$this->view->setVar('data', $data);
		$this->render("Lightbox/browse_data_json.php");

	}
	# -------------------------------------------------------
	/** 
	 * Generate the URL for the "back to results" link from a browse result item
	 * as an array of path components.
	 */
	public static function getReturnToResultsUrl($po_request) {
		return [
			'module_path' => '',
			'controller' => 'Lightbox',
			'action' => 'Index',
			'params' => []
		];
	}
	# -------------------------------------------------------
}
