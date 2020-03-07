<?php
$va_lightboxDisplayName = caGetLightboxDisplayName();
$t_item = $this->getVar("item");
print _t("%1 added a comment to the %2 %3:\n\n

<p>Comment: %4\n
Submitted by: %1, %5\n
Commented on: %3\n

", (($this->request->user->get("lname")) ? $this->request->user->get("fname")." ".$this->request->user->get("lname") : $this->getVar("name")), $va_lightboxDisplayName["singular"], $t_item->getLabelForDisplay(), (($ps_comment = $this->getVar("comment")) ? $ps_comment : "-"), (($this->request->user->get("email")) ? $this->request->user->get("email") : $this->getVar("email")));
?>