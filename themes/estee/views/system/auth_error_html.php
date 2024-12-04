Errors occurred:<br/>

<ul>
<?php
	foreach($this->getVar("notifications") as $va_error) {
		print "<li>{$va_error['message']}</li>\n";
	}
?>
</ul>
