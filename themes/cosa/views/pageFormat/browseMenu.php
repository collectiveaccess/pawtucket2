<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/browseMenu.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
 
	$va_browse_types = caGetBrowseTypes(array('forMenuBar' => true));
	$o_config = caGetBrowseConfig();
	
	if(sizeof($va_browse_types)){
		foreach($va_browse_types as $vs_browse_name => $va_browse_type){
			if(!$va_browse_type["dontShowInBrowseMenu"]){
				print "<li class='nav-item'>".caNavLink($this->request, caUcFirstUTF8Safe($va_browse_type['displayName']), 'nav-link'.((strToLower($this->request->getAction()) == strToLower($vs_browse_name)) ? " active" : ""), '', 'Browse', $vs_browse_name, '')."</li>";
			}
		}
	}
?>