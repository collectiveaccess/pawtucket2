<?php
print _t("<p>The following user contributed comment and/or tag(s) has been submitted to %1:</p>

<p>Comment: %2<br/>
Tag(s): %3<br/>
Submitted by: %4, %5<br/>
Commented on: %6</p>

", $this->request->config->get("site_host"), ($ps_comment) ? $ps_comment : "-", ($ps_tags) ? $ps_tags : "-", ($this->request->user->get("lname")) ? $this->request->user->get("fname")." ".$this->request->user->get("lname"): $ps_name, ($this->request->user->get("email")) ? $this->request->user->get("email") : $ps_email, $t_item->getLabelForDisplay()." [".$t_item->get("idno")."]");
?>