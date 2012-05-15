<?php
if (!$this->request->isAjax()) {
?>
		<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- contentArea --></div><!-- end pageArea -->
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
