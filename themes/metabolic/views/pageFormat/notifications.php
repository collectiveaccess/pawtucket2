<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/notifications.php : 
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
?>
			<div class="row">
				<div class="col-sm-12 col-md-6 offset-md-3">
					<div class="alert alert-primary mainNotification" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php
					switch($va_notification['type']) {
						case __NOTIFICATION_TYPE_ERROR__:
							print $va_notification['message'];
							break;
						case __NOTIFICATION_TYPE_WARNING__:
							print $va_notification['message'];
							break;
						default:
							print $va_notification['message'];
							break;
					}
?>
					</div>
				</div>
			</div>
					
<?php
		}
	}
?>