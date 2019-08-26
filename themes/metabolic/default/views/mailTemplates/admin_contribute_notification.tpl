<?php
$t_item = $this->getVar("item");
print _t("A new contribution has been submitted to %1.  Please login to review the contribution.

%2", $this->request->config->get("app_display_name"), $this->request->config->get("site_host"));
?>