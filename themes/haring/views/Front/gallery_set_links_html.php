<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
?>
			
<?php
			$t_set_list = new ca_sets();
 			$va_sets = $t_set_list->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "access" => 1));
			print "<div class='myBoxes'>";
			if (sizeof($va_sets) > 0) {
				print "<h2>My Lightboxes</h2>";
				foreach ($va_sets as $va_set_id => $va_set) {
					$t_set = new ca_sets($va_set['set_id']);
					print "<div class='userSets'>";
					print caNavLink($this->request, $t_set->get('ca_sets.preferred_labels'), '', 'Lightbox', 'setDetail', 'set_id/'.$va_set['set_id']);
					print "<div class='setDescription'>".$t_set->get('ca_sets.set_description')."</div>";
					print "</div>";
				}
			} else {
				print "No lightboxes are available.";
			}
			print "</div>";
?>