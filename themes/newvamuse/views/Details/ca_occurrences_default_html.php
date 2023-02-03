<?php
	header("Location: /EducationalResources/Resource/id/".$this->getVar('item')->getPrimaryKey(), 302);
	exit;
?>