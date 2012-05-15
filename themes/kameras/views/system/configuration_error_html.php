<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CollectiveAccess configuration error display</title>
	<link href="<?php print str_replace("/index.php", "", $_SERVER["SCRIPT_NAME"]); ?>/support/error/css/site.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="contentArea">
	<div align='center'><img src="<?php print str_replace("/index.php", "", $_SERVER["SCRIPT_NAME"]); ?>/support/error/graphics/ca.png"/></div>
	<p>
	<?php print _t("Apparently the built-in sanity check has found errors in your system configuration.
	    General installation instructions can be found
	    <a href='http://wiki.collectiveaccess.org/index.php?title=Installation_(Pawtucket)' target='_blank'>here</a>.
	    For more specific hints on the existing issues please have a look at the messages below."); ?>
	</p>
<?php
foreach (self::$opa_error_messages as $vs_message):
?>
		<div class="permissionError">
			<img src='<?php print str_replace("/index.php", "", $_SERVER["SCRIPT_NAME"]); ?>/support/error/graphics/vorsicht.gif' class="permissionErrorIcon"/>
			<?php print $vs_message; ?>
		</div>
		<br/>
<?php
endforeach;
?>
	</div>
	</div>
</body>
</html>
