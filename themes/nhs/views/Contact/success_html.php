<?php
	$ps_contactType = $this->request->getParameter("contactType", pString);
	if($this->request->isAjax()){
?>
		<div id="caFormOverlay" class="caFormOverlayWide"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
<H1><?php print ($ps_contactType == "askCurator") ? _t("Ask a Curator / Request an Image") : _t("Contact"); ?></H1>
<h2><?php print _t("Your message has been sent."); ?></H2>

<?php
	if($this->request->isAjax()){
?>
			<br/><br/><div class="text-center"><a href="#" class="btn-default" onclick="caMediaPanel.hidePanel(); return false;">Close</a></div>
		</div>
<?php
	}elseif($ps_contactType == "askCurator"){
		print "<a href='".$this->request->getParameter("itemURL", pString)."'><b>Back</b></a>";
	}
?>