<?php	
/* ----------------------------------------------------------------------
 * app/templates/header.php : standard PDF report header
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2016 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Header
 * @type fragment
 *
 * ----------------------------------------------------------------------
 */
 
	if($this->request->config->get('summary_header_enabled')) {
	switch($this->getVar('PDFRenderer')) {
		case 'wkhtmltopdf':
?><!--BEGIN HEADER--><!DOCTYPE html><html>
	<head>
		<link type="text/css" href="<?php print $this->getVar('base_path');?>/pdf.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
	
	</head>
	<body style='margin-top:0;padding-bottom:0.1in;'><div id='header_wk' >
<?php
		if($this->request->config->get('summary_page_numbers')) {
			print "<div class='pagingText'>"._t('Page')." </div>";
		}
?>
		<div ><br/><br/><br/><span class='logoUpper'>Mark Rothko</span><span class='logoLower'>works on paper</span></div>
	</div>
</body>
</html><!--END HEADER-->
<?php
			break;
		default:
?><div id='header'>
<?php
	if(file_exists($this->request->getThemeDirectoryPath()."/assets/pawtucket/graphics/".$this->request->config->get('report_img'))){
		print '<img src="'.$this->request->getThemeDirectoryPath().'/assets/pawtucket/graphics/'.$this->request->config->get('report_img').'" class="headerImg"/>';
	}
	if($this->request->config->get('summary_page_numbers')) {
		print "<div class='pagingText'>"._t('Page')." </div>";
	}
?>
</div>
<?php
			break;
	}
}
?>