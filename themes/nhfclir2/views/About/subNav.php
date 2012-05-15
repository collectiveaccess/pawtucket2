<div id="subNav">
	<div style="margin-left:215px;"><?php print caNavLink($this->request, _t("About the Project"), (($this->request->getAction() == "Index") ? "selected" : ""), "", "About", "Index"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Partners"), (($this->request->getAction() == "Partners") ? "selected" : ""), "", "About", "Partners"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Participants"), (($this->request->getAction() == "Participants") ? "selected" : ""), "", "About", "Participants"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Cataloging Resources"), (($this->request->getAction() == "CatalogingResources") ? "selected" : ""), "", "About", "CatalogingResources"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Project Blog"), (($this->request->getAction() == "ProjectBlog") ? "selected" : ""), "", "About", "ProjectBlog"); ?></div>
</div><!-- end subNav -->