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
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CollectiveAccess error</title>
	<link href="<?= caGetThemeUrlPath(); ?>/assets/pawtucket/css/error.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id='errorDetails'>
		<div id="logo"><?= caGetDefaultLogo(); ?></div><!-- end logo -->
		<div id="content">
			<div class='error'><?= _t("Something went wrong"); ?></div>
<?php if((defined('__CA_ENABLE_DEBUG_OUTPUT__') && __CA_ENABLE_DEBUG_OUTPUT__) || (defined('__CA_STACKTRACE_ON_EXCEPTION__') && __CA_STACKTRACE_ON_EXCEPTION__)) { ?>
			<div id="errorLocation" class="errorPanel">
				<?= caNavIcon(__CA_NAV_ICON_ALERT__ , 2, array('class' => 'permissionErrorIcon')); ?>
				<div class="errorDescription"><span class="errorMessage"><?= $errstr; ?></span> in <?= $errfile; ?> line <?= $errline; ?>:</div>
			</div>
			<div id="stacktace">
				<ol class="tracelist">
<?php
					foreach($errcontext as $vn_i => $va_trace) {
						print "<li>".(($vn_i == 0) ? "In " : "At ").$va_trace['class'].$va_trace['type'].$va_trace['function']."(".join(', ', $pa_errcontext_args[$vn_i] ?? []).") in <a class='tracelistEntry' title='".$va_trace['file']."' ondblclick='var f=this.innerHTML;this.innerHTML=this.title;this.title=f;'>".pathinfo($va_trace['file'], PATHINFO_FILENAME)."</a> line ".$va_trace['line']."</li>\n";
					}
?>
				</ol>
<?php
		if(is_array($request_params) && (sizeof($request_params) > 0)) {
?>
			<div id="requestParameters" class="errorPanel">
				<?= caNavIcon(__CA_NAV_ICON_INFO__ , 2, array('class' => 'permissionErrorIcon')); ?>
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
<?php
		}
} else {
?>
			<div id="errorLocation" class="errorPanel">
				<?= caNavIcon(__CA_NAV_ICON_ALERT__ , 2, array('class' => 'permissionErrorIcon')); ?>
				<div class="errorDescription">
				<?= _t("There was an uncaught fatal error. Please contact your system administrator and check the CollectiveAccess log files."); ?>
				</div>
			</div>
<?php
}
?>
		</div><!-- end content -->
	</div><!-- end box -->
</body>
</html>
