<?php
	$o_config = caGetContactConfig();
	$page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact Us");
	if($id > 0) {
		$url = $this->request->config->get("site_host").caDetailUrl($this->request, $table, $id);
		$name = $t_item->get("{$table}.preferred_labels");
		$idno = $t_item->get("{$table}.idno");
		$page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Ask a Historian");
	}

?>
<H1><?php print $page_title; ?></H1>
<h2><?php print _t("Thank you for contacting the White House Workers History Project team. We will review your message and get back to you as soon as possible."); ?></H2>