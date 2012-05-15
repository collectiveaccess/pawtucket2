<?php
	$va_errors = $this->getVar('errors');
	
	if (sizeof($va_errors)) {
			print json_encode(array('status' => 'error', 'errors' => $va_errors));
	} else {
			print json_encode(array('status' => 'ok', 'set_id' => $this->getVar('set_id')));
	}
?>