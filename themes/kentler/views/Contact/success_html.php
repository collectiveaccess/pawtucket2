<?php
	$ps_contactType = $this->request->getParameter("contactType", pString);
	if($ps_contactType == "benefit"){
?>
		<H1><?php print _t("Virtual Benefit: Select Item"); ?></H1>
		<b><?php print _t("Your item has been selected!"); ?></b>
<?php

		print "<p class='text-center'>".caNavLink($this->request, "Back to Virtual Benefit", "btn btn-default", "Detail", "exhibitions", $this->request->config->get("virtual_benefit_id"))."</p>";
	
	}else{
?>
	<H1><?php print _t("Contact"); ?></H1>
	<b><?php print _t("Your message has been sent."); ?></b>
<?php	
	}
?>
