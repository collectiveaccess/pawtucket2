<div id="subNav">
	<div style="margin-left:180px;"><?php print caNavLink($this->request, _t("Overview"), ((($this->request->getController() == "Engage") && ($this->request->getAction() == "Index")) ? "selected" : ""), "clir2", "Engage", "Index"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Your Sets"), (($this->request->getController() == "YourSets") ? "selected" : ""), "clir2", "YourSets", "Index"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Comments"), (($this->request->getController() == "Comments") ? "selected" : ""), "clir2", "Comments", "Index"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Exhibits"), (($this->request->getController() == "Exhibits") ? "selected" : ""), "clir2", "Exhibits", "Index"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("Essays"), (($this->request->getAction() == "Essays") ? "selected" : ""), "clir2", "Engage", "Essays"); ?></div>
		<div class="spacerLine"><!-- empty --></div>
	<div><?php print caNavLink($this->request, _t("More"), (($this->request->getAction() == "More") ? "selected" : ""), "clir2", "Engage", "More"); ?></div>
</div><!-- end subNav -->