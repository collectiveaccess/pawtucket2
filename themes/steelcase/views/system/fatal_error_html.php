<?php
/* ----------------------------------------------------------------------
 * views/system/fatal_error_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2022 Whirl-i-Gig
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
 
$tmp = explode("/", str_replace("\\", "/", $_SERVER['SCRIPT_NAME']));
array_pop($tmp);
$path = join("/", $tmp);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CollectiveAccess error</title>
	<link href="<?= $path; ?>/themes/default/assets/pawtucket/css/error.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id='errorDetails'>
		<div id="logo"><img src="<?= $path ?>/themes/default/assets/pawtucket/graphics/logos/logo.svg" width="350" height="35" alt="CollectiveAccess"/></div><!-- end logo -->
		<div id="content">
			<div class='error'>Something went wrong</div>	
			
			<div id="errorLocation" class="errorPanel">
				<img src='<?= $path; ?>/themes/default/assets/pawtucket/graphics/glyphicons_078_warning_sign.png' class="permissionErrorIcon"/>
				<div class="errorDescription"><span class="errorMessage"><?= $errstr; ?></span> in <?= $errfile; ?> line <?= $pn_errline; ?>:</div>
			</div>
			<div id="stacktace">
					<ol class="tracelist">
<?php
						foreach($errcontext as $i => $trace) {
							print "<li>".(($i == 0) ? "In " : "At ").$trace['class'].$trace['type'].$trace['function']."(".join(', ', $pa_errcontext_args[$i]).") in <a class='tracelistEntry' title='".$trace['file']."' ondblclick='var f=this.innerHTML;this.innerHTML=this.title;this.title=f;'>".pathinfo($trace['file'], PATHINFO_FILENAME)."</a> line ".$trace['line']."</li>\n";
						}
?>
					</ol>
	
			<div id="requestParameters" class="errorPanel">
				<img src='<?= $path; ?>/themes/default/assets/pawtucket/graphics/glyphicons_195_circle_info.png' class="permissionErrorIcon"/>
				<div class="errorDescription">
					<span class="errorMessage"></span>Request parameters:</span>
					<ol class="paramList">
<?php
					foreach($request_params as $k => $v) {
						print "<li>{$k} =&gt; {$v}</li>";
					}
?>
					</ol>
				</div>
			</div>
		</div><!-- end content -->
	</div><!-- end box -->
</body>
</html>
