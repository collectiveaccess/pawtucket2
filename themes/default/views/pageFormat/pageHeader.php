<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath()); ?>

	<title><?php print $this->request->config->get('html_page_title'); ?></title>
</head>
<body>
