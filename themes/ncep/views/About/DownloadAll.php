<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Download");
	$pn_object_id = $this->request->getParameter('object_id', pInteger);
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Download Options"); ?></H1>
<div class="row">
	<div class="col-sm-12 text-center">
		<br/><p>Please log in to also access educator-only files</p>
	</div>
</div>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
<?php
		print "<br/><a href='#' class='btn-default btn-orange' style='width:100%;' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a>";
		print "<br/><br/>".caNavLink($this->request, "Continue without logging in", 'btn-default btn-orange', 'Detail', 'DownloadMedia', '', array("object_id" => $pn_object_id, "download" => 1), array("onCLick" => "caMediaPanel.hidePanel();")); 
		print "<br/><br/><a href='#' class='btn-default btn-orange' style='width:100%;' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register As Educator")."</a>";
?>
	</div>
</div>
</div>