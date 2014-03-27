<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/browseMenu.php : 
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
 * ----------------------------------------------------------------------
 */
 
	$va_browse_types = caGetBrowseTypes();
	if(sizeof($va_browse_types)){
?>
 <li class="dropdown yamm-fw"> <!-- add class yamm-fw for full width-->
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print _t("Browse"); ?></a>
	<ul class="dropdown-menu" id="browse-menu">
		<li class="browseNavFacet">			
			<div class="browseMenuContent container text-center">
<?php
		if(sizeof($va_browse_types) > 1){
?>	
			Find: 
<?php
			foreach($va_browse_types as $vs_browse_name => $va_browse_type){
				print caNavLink($this->request, caUcFirstUTF8Safe($vs_browse_name).' &nbsp;'.$va_browse_type["icon_class"].'', 'browseMenuBrowseAll btn btn-default btn-lg', '', 'Browse', $vs_browse_name, '');
			}
		}
?>
			</div><!-- end browseMenuContent container -->		
		</li><!-- end browseNavFacet -->
	</ul> <!--end dropdown-browse-menu -->	
 </li><!-- end dropdown -->
<?php	
	}
?>