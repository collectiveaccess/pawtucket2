<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Why Register?");
?>
<H1><?php print _t("Why Register?"); ?></H1>
<div class="row">
	<div class="col-sm-8">
		<p>By Registering, educators are granted access to additional resources for classroom use.</p>
	</div>
	<div class="col-sm-3 col-sm-offset-1">
<?php
		print "<button type='button' class='btn btn-default btn-orange' style='width:100%;' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register Now!")."</button>";
?>
	</div>
</div>