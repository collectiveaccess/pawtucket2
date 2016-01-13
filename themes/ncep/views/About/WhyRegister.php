<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Why Register?");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Why Register?"); ?></H1>
<div class="row">
	<div class="col-sm-12">
		<p>NCEP modules are available free of charge for educational use. For access to educator-only restricted content available under "Teach" (e.g., Exercise Solutions) and to interact with our larger Network under "Connect," please register online.</p>
	
<?php
		print "<br/><br/><a href='#' class='btn-default btn-orange' style='width:100%;' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register Now!")."</a>";
?>
	</div>
</div>
</div>