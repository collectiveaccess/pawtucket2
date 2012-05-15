<?php
print _t("The following user contributed comment and/or tag(s) has been submitted to %1:

Comment: %2
Tag(s): %3
Submitted by: %4, %5
Commented on: %6

", $this->request->config->get("site_host"), ($ps_comment) ? $ps_comment : "-", ($ps_tags) ? $ps_tags : "-", ($this->request->user->get("lname")) ? $this->request->user->get("fname")." ".$this->request->user->get("lname"): $ps_name, ($this->request->user->get("email")) ? $this->request->user->get("email") : $ps_email, (is_object($t_item) && $t_item->primaryKey()) ? $t_item->getLabelForDisplay()." [".$t_item->get("idno")."]" : _t("New Site Comment"));
?>