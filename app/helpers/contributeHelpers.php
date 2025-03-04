<?php
/** ---------------------------------------------------------------------
 * app/helpers/contributeHelpers.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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

 /**
   *
   */
	
	# ---------------------------------------
	/**
	 * Get theme-specific contribute form configuration
	 *
	 * @return Configuration 
	 */
	function caGetContributeFormConfig() {
		if (file_exists(__CA_THEME_DIR__.'/conf/contribute.conf')) {
			return Configuration::load(__CA_THEME_DIR__.'/conf/contribute.conf');
		}
		return Configuration::load(__CA_THEMES_DIR__.'/default/conf/contribute.conf');
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return array 
	 */
	function caGetInfoForContributeFormType($ps_form_type) {
		$o_contribute_config = caGetContributeFormConfig();
		
		$va_form_types = $o_contribute_config->getAssoc('formTypes');
	
		$ps_form_type = strtolower($ps_form_type);
		
		if (isset($va_form_types[$ps_form_type])) {
			return $va_form_types[$ps_form_type];
		}
		return null;
	}
	# ---------------------------------------