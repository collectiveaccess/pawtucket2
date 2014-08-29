Errors occurred when trying to access <code><?php print $this->getVar('referrer'); ?></code>:<br/>

<ul>
<?php
	foreach($this->getVar("error_messages") as $va_notification) {
		print "<li>{$va_notification['message']}</li>\n";
	}
?>
</ul>