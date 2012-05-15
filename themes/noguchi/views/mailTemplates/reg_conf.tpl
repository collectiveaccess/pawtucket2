<?php
print _t("Thank you for registering for \"%1\".

As a member you can rank, comment and tag items on the site.  You can also create your own sets from the collection and share your slide-shows with friends and colleagues.

Regards,
the Staff

", $this->request->config->get("app_display_name"));

	print $this->request->config->get("site_host");
?>