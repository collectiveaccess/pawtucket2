<?php
print _t("<p>Your %1 password was reset on %2 at %3. If you did not reset your password, please contact us at %4.</p>


<p>Regards,<br/>

The staff</p>

", $this->request->config->get("app_display_name"), date("F j, Y"), date("G:i"), $this->request->config->get("ca_admin_email"));


	print $this->request->config->get("site_host");
?>