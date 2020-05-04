<?php
	$ps_contactType = $this->request->getParameter("contactType", pString);
?>
<H1><?php print ($ps_contactType == "askArchivist") ? _t("Ask an Archivist") : _t("Contact"); ?></H1>
<h2><?php print _t("Your message has been sent."); ?></H2>

<?php
	if($ps_contactType == "askArchivist"){
		print "<a href='".$this->request->getParameter("itemURL", pString)."'><b>Back</b></a>";
	}
?>