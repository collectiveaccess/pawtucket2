<?php
/** ---------------------------------------------------------------------
 * app/helpers/listingHelpers.php : miscellaneous functions
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
	 * 
	 *
	 * @return Configuration 
	 */
	function caGetListingConfig() {
		return Configuration::load(__CA_THEME_DIR__.'/conf/listing.conf');
	}
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return array 
	 */
	function caGetInfoForListingType($ps_listing_type) {
		$o_listing_config = caGetListingConfig();
		
		$va_listing_types = $o_listing_config->getAssoc('listingTypes');
		$ps_listing_type = strtolower($ps_listing_type);
		
		if (isset($va_listing_types[$ps_listing_type])) {
			return $va_listing_types[$ps_listing_type];
		}
		return null;
	}
	# ---------------------------------------
?>