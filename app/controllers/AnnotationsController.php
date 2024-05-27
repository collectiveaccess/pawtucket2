<?php
/* ----------------------------------------------------------------------
 * controllers/AnnotationController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__."/ApplicationError.php");
require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
require_once(__CA_APP_DIR__."/helpers/exportHelpers.php");

class AnnotationsController extends BasePawtucketController {
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Annotations"));
		caSetPageCSSClasses(array("annotations"));
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	public function Index() {
		$annotations = ca_user_representation_annotations::getAnnotations(['request' => $this->request, 'groupBy' => 'ca_objects']);
	
		$this->view->setVar('annotations', $annotations);
		
		$this->render("Annotations/index_html.php");
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	public function Delete() {
		$confirm = $this->request->getParameter('confirm', pInteger);
		if($confirm) {
			$annotations = ca_user_representation_annotations::getAnnotations(['request' => $this->request]);
			$c = 0;
			foreach($annotations as $annotation_id => $anno) {
				if($t_anno = ca_user_representation_annotations::findAsInstance($annotation_id)) {
					if($t_anno->delete(true)) {
						$c++;
					}
				}
			}
			
			$this->notification->addNotification(($c == 1) ? _t("Deleted %1 clipping", $c) : _t("Deleted %1 clippings", $c), __NOTIFICATION_TYPE_INFO__);
			return $this->Index();
		} else {
			$this->render('Annotations/delete_confirm_html.php');
		}
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	public function DownloadPDF() {
		$annotations = ca_user_representation_annotations::getAnnotations(['request' => $this->request]);
		
		$this->view->setVar('annotations', $annotations);
		$content = $this->view->render('Annotations/export/annotations_pdf_html.php', true);
	
		caExportContentAsPDF($content, [
			'pageSize' => 'letter', 'pageOrientation' => 'portrait',
			'marginLeft' => '0.5in', 'marginRight' => '0.5in', 'marginTop' => '0.5in', 'marginBottom' => '0.5in',
		], 'my_clippings.pdf', []);
		
		return;
	}
	# ------------------------------------------------------
	/**
	 *
	 */
	public function DownloadFiles() {
		$annotations = ca_user_representation_annotations::getAnnotations(['request' => $this->request]);
		
		$this->view->setVar('annotations', $annotations);
		$content = $this->view->render('Annotations/export/annotations_pdf_html.php', true);
		
		$this->request->isDownload(true);
		
		$file_paths = [];
		foreach($annotations as $anno) {
			$file_paths[$anno['original_path']] = preg_replace("![^A-Za-z0-9_\-]+!u", "_", $anno['object_label'].(($anno['page'] > 0) ? '_PAGE_'.$anno['page'].'_' : '').$anno['label']).".jpg"; 
		}
		
		array_map(function($v) {
			return $v['original'];
		}, $annotations);
		if (sizeof($file_paths) > 1) {
			if (!($limit = ini_get('max_execution_time'))) { $limit = 30; }
			set_time_limit($limit * 2);
			$o_zip = new ZipStream();
			foreach($file_paths as $path => $name) {
				$o_zip->addFile($path, $name);
			}
			$this->view->setVar('zip_stream', $o_zip);
			$this->view->setVar('archive_name', 'my_clippings.zip');
			
			$rc = $this->render('bundles/download_file_binary.php');
		} else {
			foreach($file_paths as $path => $name) {
				$this->view->setVar('archive_path', $path);
				$this->view->setVar('archive_name', $name);
			}
			$rc = $this->render('bundles/download_file_binary.php');
		}
		return $rc;
	}
	# ------------------------------------------------------
}
