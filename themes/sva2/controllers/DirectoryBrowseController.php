<?php
/* ----------------------------------------------------------------------
 * controllers/DirectoryBrowseController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');

class DirectoryBrowseController extends BasePawtucketController {
	# -------------------------------------------------------
	
	# -------------------------------------------------------
	/**
	 * @param RequestHTTP $request
	 * @param ResponseHTTP $response
	 * @param null $view_paths
	 * @throws ApplicationException
	 */
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function People($options = null) {
		$this->render("DirectoryBrowse/people_html.php");
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function Exhibitions($options = null) {
		$this->render("DirectoryBrowse/exhibitions_html.php");
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function Dates($options = null) {
		$this->render("DirectoryBrowse/dates_html.php");
	}
	# -------------------------------------------------------
}
