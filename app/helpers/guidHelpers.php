<?php
/** ---------------------------------------------------------------------
 * app/helpers/guidHelpers.php : guid helper functions
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2020 Whirl-i-Gig
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
 * @subpackage utils
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

require_once(__CA_LIB_DIR__.'/ApplicationVars.php');

/**
 * Ensure system GUID is set and set system-wide GUID constant
 */
function caGetSystemGuid() {
	$av = new ApplicationVars();
	if(!($system_guid = $av->getVar('system_guid'))) {
		$system_guid = caGenerateGUID();
		$av->setVar('system_guid', $system_guid);
		$av->save();
	}
	define('__CA_SYSTEM_GUID__', $system_guid);
	
	return $system_guid;
}
