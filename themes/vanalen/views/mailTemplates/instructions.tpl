<?php
print _t("To reset your password copy and paste the following URL into your web browser:");

print $vs_password_reset_url;

print _t("

You will be prompted for a new password. If you have further difficulties, 
or if you did not request your password to be reset, please contact us at %1.

Regards,

The staff
", $this->request->config->get("ca_admin_email"));


	print $this->request->config->get("site_host");
?>