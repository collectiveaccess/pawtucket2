<?php
print _t("<p>Thank you for registering for \"%1\".</p>

<p>As a registered user you can now save images to your gallery for purchase or later research use.  If you need help using your gallery or have questions <a href=\"http://digitallibrary.hsp.org/index.php/About/faq\">please see the FAQ</a> for video tutorials help with using the Historical Society of Pennsylvania's Digital Library. </p>

<p>Regards,<br/>
Historical Society of Pennsylvania</p>

", $this->request->config->get("app_display_name"));

	print "<p>".$this->request->config->get("site_host")."</p>";
?>
