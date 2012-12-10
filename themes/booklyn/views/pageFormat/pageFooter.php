		</div><!-- end pageArea -->
	<br clear="all">
	</div>	<!-- end content -->
		<div id="footer">

			<div id="subInfoInterior" ><a href="#">FB</a>  <a href="#">TW</a> 37 Greenpoint Ave. Brooklyn NY 11222</div>

			<table id="mailingList"><form><tr><td valign="center" style="padding:4px 0 0 0 ;">Mailing List:</td><td width="4">&nbsp;</td><td valign="center"><input class="textBox" type="text" / value="ENTER EMAIL" onclick="this.value=''"></td><td width="4">&nbsp;</td><td valign="center"><input type="submit" class="submitBox" value="JOIN" /></td><td width="13">&nbsp;</td></tr></form></table>

		</div><!-- end footer -->
	</div><!-- end maincontent -->
<?php
print TooltipManager::getLoadHTML();
?>
	<div id="caMediaPanel"> 
		<!--<div id="close"><a href="#" onclick="caMediaPanel.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>-->
		<div id="caMediaPanelContentArea">
		
		</div>
	</div>
	<script type="text/javascript">
	/*
		Set up the "caMediaPanel" panel that will be triggered by links in object detail
		Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
	*/
	var caMediaPanel;
	jQuery(document).ready(function() {
		if (caUI.initPanel) {
			caMediaPanel = caUI.initPanel({ 
				panelID: 'caMediaPanel',										/* DOM ID of the <div> enclosing the panel */
				panelContentID: 'caMediaPanelContentArea',		/* DOM ID of the content area <div> in the panel */
				exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
				exposeBackgroundOpacity: 0.8,							/* opacity of background color masking out page content; 1.0 is opaque */
				panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport',
				closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
			});
		}
	});
	</script>
	</body>
</html>
