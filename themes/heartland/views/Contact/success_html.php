<?php
	$o_config = caGetContactConfig();
	$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
	
	$ps_contactType = $this->request->getParameter("contactType", pString);
	if($ps_contactType == "takedown"){
		$vs_page_title = ($o_config->get("takedown_request_title")) ? $o_config->get("takedown_request_title") : _t("Request Item Takedown");
	}else{
		$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
	}
?>
<H1><?php print $vs_page_title; ?></H1>
<h2><?php print _t("Your message has been sent."); ?></H2>