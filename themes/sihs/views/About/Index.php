<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>
<H1><?php print _t("About the Shelter Island Historical Society"); ?></H1>
<div class="row">
	<div class="col-sm-8">
		<p>The mission of the Shelter Island Historical Society is to research, preserve and share our heritage and Island history through education, exhibition, scholarship and community activities.  The Society currently has approximately 70,000 items in its collection, including original documents dating back to the original settling of Shelter Island in the mid-seventeenth century.   A much smaller but increasing number of the many items in the Society's collection are described and available as digital images through this website ---- connected to the Society's collections management system, using open source software known as <em>Collective Access</em> (CA).   Thanks to a generous grant from the David Lion Gardiner Foundation, the Society is pleased to be able to provide limited access to its holdings through this preliminary website.  We hope that the information provided will be of interest to you and will increase your appreciation for the rich heritage we share.  Your comments and suggestions concerning the capabilities of this system are welcome.  </p>
	</div>
	<div class="col-sm-3 col-sm-offset-1">
		<address>Physical Address<br/>16 South Ferry Road<br/>Shelter Island, NY 11964<br/><br/>Mailing Address<br/>P.O. Box 847<br/>Shelter Island, NY 11964</address>
		
		<address>Phone: 631-749-0025<br/>Fax: 631-749-1825</address>
		
		<address><?php print caNavLink($this->request, _t("Contact the Society <i class='fa fa-envelope-o'></i>"), "", "", "Contact", "Form"); ?></address>
	</div>
</div>