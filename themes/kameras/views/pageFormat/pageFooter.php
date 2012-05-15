<?php
if (!$this->request->isAjax()) {
?>
		<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- contentArea --></div><!-- end pageArea -->
		<div id="footer"><?php print caNavLink($this->request, _t("Imprint"), "", "", "About", "imprint")."&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;".caNavLink($this->request, _t("Contact"), "", "", "About", "contact"); ?></div><!-- end footer -->
<?php
}
print TooltipManager::getLoadHTML();
?>
	<div id="objectInfoRepresentationOverlay"> 
		<div id="objectInfoRepresentationOverlayContentContainer">
			
		</div>
	</div>
	</body>
</html>
