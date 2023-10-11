<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Browse");


print $this->render("pageFormat/browseMenu.php");
?>