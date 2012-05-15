		<div style="clear:both; height:1px;"><!-- empty --></div>
			<div id="footerLogos">
				<table width="100%" border="0">
					<tr>
						<td align="center" valign="middle" width="25%"><a href="http://www.eastmanhouse.org" target="_blank"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/clir2/logo_geh.gif" border="0"></a></td>
						<td align="center" valign="middle" width="10%">&nbsp;</td>
						<td align="center" valign="middle" width="30%"><a href="http://www.oldfilm.org" target="_blank"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/clir2/logo_nhf.jpg" border="0"></a></td>
						<td align="center" valign="middle" width="7%">&nbsp;</td>
						<td align="center" valign="middle" width="28%"><a href="http://www.queensmuseum.org" target="_blank"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/clir2/logo_qma.gif" border="0"></a></td>
					</tr>
				</table>
			</div>
		<div id="footer">
			<?php print _t("Funding for this project is provided through the Council on Library and Information Resources program, <a href='http://www.clir.org/hiddencollections/'>Cataloging Hidden Special Collections and Archives</a>.<br/>Website &copy; 2011 Northeast Historic Film."); ?> 
			<?php print "&nbsp;".caNavLink($this->request, "Site Map", "", "", "About", "Sitemap"); ?>
		</div><!-- end footer -->
	</div><!-- end pageArea -->		
<?php
print TooltipManager::getLoadHTML();
?>
	<div id="caMediaPanel"> 
		<div id="close"><a href="#" onclick="caMediaPanel.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>
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
				exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
				panelTransitionSpeed: 200, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport'
			});
		}
	});
	</script>
	</body>
</html>
