<?php
/** ---------------------------------------------------------------------
 * app/helpers/configurationHelpers.php : utility functions for setting database-stored configuration values
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2019 Whirl-i-Gig
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
   	
require_once(__CA_LIB_DIR__.'/Configuration.php');

	# ----------------------------------------------------------------
	/**
	  * Returns a sorted list of XML profiles. Keys are display names and values are profile codes (filename without .xml extension).
	  *
	  * @param string $ps_install_dir_prefix optional prefix for install dir
	  * @return array List of available profiles
	  */
	function caGetAvailableXMLProfiles($ps_install_dir_prefix='.') {
		$va_files = caGetDirectoryContentsAsList($ps_install_dir_prefix.'/profiles/xml', false);
		$va_profiles = array();
		
		foreach($va_files as $vs_filepath) {
			if (preg_match("!\.xml$!", $vs_filepath)) {
				$va_tmp = explode('/', $vs_filepath);
				$va_tmp2 = explode('.', array_pop($va_tmp));
				$vs_file = array_shift($va_tmp2);
				$va_profile_info = Installer::getProfileInfo($ps_install_dir_prefix.'/profiles/xml', $vs_file);
				if (!$va_profile_info['useForConfiguration']) { continue; }
				$va_profiles[$va_profile_info['display']] = $vs_file; 
			}
		}
		
		ksort($va_profiles, SORT_STRING | SORT_FLAG_CASE);
		return $va_profiles;
	}
	# ----------------------------------------------------------------
	/**
	 *
	 */
	function caFlushOutput() {
		echo str_pad('',4096)."\n";
		@ob_flush();
		flush();
	}
	# ----------------------------------------------------------------
