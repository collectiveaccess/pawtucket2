		<div style="clear:both; height:1px;"><!-- empty --></div>
		<div id="footer">
		[<?php print $this->request->session->elapsedTime(4).'s'; ?>/<?php print caGetMemoryUsage(); ?>]
		</div><!-- end footer -->

		<?php print TooltipManager::getLoadHTML(); ?>

	</body>
</html>
