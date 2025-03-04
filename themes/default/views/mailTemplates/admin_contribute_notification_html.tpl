<?php
$t_item = $this->getVar("item");
print _t("<p>A new contribution has been submitted to %1.  Please login to review the contribution.</p><p>%2</p>", $this->request->config->get("app_display_name"), $this->request->config->get("site_host"));
?>