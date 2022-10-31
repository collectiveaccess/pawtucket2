<?php
/** ---------------------------------------------------------------------
 * app/lib/BatchEditorProgress.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012-2021 Whirl-i-Gig
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
 * @subpackage UI
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  * Implements batch modification of records invoked via the web UI
  * This application dispatcher plugin ensures that the indexing starts
  * after the web UI page has been sent to the client
  */ 
require_once(__CA_LIB_DIR__.'/Controller/AppController/AppControllerPlugin.php');
require_once(__CA_LIB_DIR__.'/BatchProcessor.php');

class BatchEditorProgress extends AppControllerPlugin {
	# -------------------------------------------------------
	private $request;
	private $record_set;
	private $t_subject;
	private $options;
	# -------------------------------------------------------
	public function __construct(RequestHTTP $request, RecordSelection $record_set, $t_subject, array $options=null) {
		$this->request = $request;
		$this->record_set = $record_set;
		$this->t_subject = $t_subject;
		$this->options = is_array($options) ? $options : array();
	}
	# -------------------------------------------------------
	public function dispatchLoopShutdown() {	
		//
		// Force output to be sent - we need the client to have the page before
		// we start flushing progress bar updates
		//	
		$app = AppController::getInstance();
		$req = $app->getRequest();
		$resp = $app->getResponse();
		$resp->sendResponse();
		$resp->clearContent();
		
		//
		// Do batch processing
		//
		if ($req->isLoggedIn()) {
			set_time_limit(3600*24); // if it takes more than 24 hours we're in trouble

			if(isset($this->options['isBatchDelete']) && $this->options['isBatchDelete']) {
				$errors = BatchProcessor::deleteBatch($this->request, $this->record_set, $this->t_subject, array_merge($this->options, array('progressCallback' => 'caIncrementBatchEditorProgress', 'reportCallback' => 'caCreateBatchEditorResultsReport')));	
			} elseif(isset($this->options['isBatchTypeChange']) && $this->options['isBatchTypeChange']) {
				$errors = BatchProcessor::changeTypeBatch($this->request, $this->options['type_id'], $this->record_set, $this->t_subject, array_merge($this->options, array('progressCallback' => 'caIncrementBatchEditorProgress', 'reportCallback' => 'caCreateBatchEditorResultsReport')));	
			} else {
				$errors = BatchProcessor::saveBatchEditorForm($this->request, $this->record_set, $this->t_subject, array_merge($this->options, array('progressCallback' => 'caIncrementBatchEditorProgress', 'reportCallback' => 'caCreateBatchEditorResultsReport')));	
			}
		}
	}	
	# -------------------------------------------------------
}
