<?php
$t_item = $this->getVar("item");
print _t("The following user contributed comment and/or tag(s) has been submitted to %1:\n\n

Comment: %2\n
Tag(s): %3\n
Submitted by: %4, %5\n
Commented on: %6\n

", $this->request->config->get("site_host"), ($ps_comment = $this->getVar("comment")) ? $ps_comment : "-", ($ps_tags = $this->getVar("tags")) ? $ps_tags : "-", ($this->request->user->get("lname")) ? $this->request->user->get("fname")." ".$this->request->user->get("lname"): $this->getVar("name"), ($this->request->user->get("email")) ? $this->request->user->get("email") : $this->getVar("email"), $t_item->getLabelForDisplay()." [".$t_item->get("idno")."]");
?>