<?php
print _t("<p>To reset your password copy and paste the following URL into your web browser:</p>");

print "<p>".$vs_password_reset_url."</p>";

print _t("<p>You will be prompted for a new password. If you have further difficulties, 
or if you did not request your password to be reset, please contact us at %1.</p>

<p>Regards,<br/>

The staff</p>
", $this->request->config->get("ca_admin_email"));


	print $this->request->config->get("site_host");
?>