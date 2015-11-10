<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/advancedSearchMenu.php : 
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
 
?>
				 <li class="dropdown yamm-fw<?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? ' active' : ''; ?>"> <!-- add class yamm-fw for full width-->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" onClick="jQuery('#advancedSearch-menu').load('<?php print caNavUrl($this->request, 'Search', 'Advanced', 'objects'); ?>'); return false;"><?php print _t("Advanced Search"); ?></a>
					<ul class="dropdown-menu" id="advancedSearch-menu">
						

							
					</ul> <!--end dropdown-browse-menu -->	
				 </li><!-- end dropdown -->