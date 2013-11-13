<?php
	if (sizeof($this->getVar('notifications'))) {
		foreach($this->getVar('notifications') as $va_notification) {
?>
			<div class="notificationMessage">
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
<?php
		}
	}
?>