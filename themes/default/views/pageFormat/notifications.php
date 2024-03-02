<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/notifications.php : 
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
 
	if (sizeof($this->getVar('notifications'))) {
		foreach($this->getVar('notifications') as $va_notification) {
			switch($va_notification['type']) {
				case __NOTIFICATION_TYPE_ERROR__:
					$class = "alert alert-danger";
					break;
				case __NOTIFICATION_TYPE_WARNING__:
					$class = "alert alert-warning";
					break;
				default:
					$class = "alert alert-primary";
					break;
			}
?>
				<div role="alert" class="<?php print $class; ?>  alert-dismissible fade show text-center fs-4 rounded-0 position-absolute z-1 w-50 start-50 mt-5 translate-middle">
<?php
					print $va_notification['message'];
?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
<?php
		}
	}
?>