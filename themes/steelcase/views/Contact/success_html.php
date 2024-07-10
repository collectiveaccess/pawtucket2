<?php
	if($this->request->isAjax()){
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
<H1><?php print _t("Contact"); ?></H1>
<h2><?php print _t("Your message has been sent."); ?></H2>
<?php
	if($this->request->isAjax()){
?>
		</div>
<?php
	}
?>