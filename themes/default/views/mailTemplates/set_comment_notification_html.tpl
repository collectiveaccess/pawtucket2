<?php
$va_lightboxDisplayName = caGetLightboxDisplayName();
$t_item = $this->getVar("item");
print _t("<p>%1 added a comment to the %2 %3:</p>

<p>Comment: %4<br/>
Submitted by: %1, %5<br/>
Commented on: %3</p>

", (($this->request->user->get("lname")) ? $this->request->user->get("fname")." ".$this->request->user->get("lname") : $this->getVar("name")), $va_lightboxDisplayName["singular"], $t_item->getLabelForDisplay(), (($ps_comment = $this->getVar("comment")) ? $ps_comment : "-"), (($this->request->user->get("email")) ? $this->request->user->get("email") : $this->getVar("email")));
?>