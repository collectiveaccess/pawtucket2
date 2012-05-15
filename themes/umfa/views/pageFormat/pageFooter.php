<?php
if (!$this->request->isAjax()) {
?>
		<div id="contentFooter" style="position:relative;">
			<div id="donate"><div id="close"><a href="#" onclick='$("#donate").hide(0); return false;'>close</a></div><b>Thank you for your support!</b><br/>To make a donation <a href="https://umarket.utah.edu/development/form.tpl">CLICK HERE</a> and make sure to specify that you want your donation to go towards the UMFA's Collection Database under "Special Instructions and Comments" (step two).</div>
			<a href="#" onclick='$("#donate").show(0); return false;'>Like what you see? Support the UMFA's Collection Database</a>
<?php
				print "&nbsp;&nbsp;|&nbsp;&nbsp;".caNavLink($this->request, _t("Help"), "", "About", "Index", "");
				if (!$this->request->config->get('dont_allow_registration_and_login')) {
					print "&nbsp;|&nbsp;&nbsp;";
					if($this->request->isLoggedIn()){
						print caNavLink($this->request, _t("My Sets"), "", "", "Sets", "index");
						print "&nbsp;&nbsp;|&nbsp;&nbsp;";
						print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
					}else{
						print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form", array("site_last_page" => "default"));
					}
				}
?>
		</div><!-- end contentFooter --><div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end pageArea -->
		
				
		<center><table border="0" cellpadding="0" cellspacing="0" style="height: 28px" width="760"><tbody><tr><td align="center" valign="middle"><hr /><font size="1">Marcia & John Price Museum Building | 410 Campus Center Drive, Salt Lake City, UT 84112-0350 | Phone: 801-581-7332 | </font><a href="http://www.utah.edu" target="blank"><font size="1">University of Utah</font></a><font size="1"> - </font><a href="http://www.utah.edu/disclaimer" target="blank"><font size="1">Disclaimer</font></a><br><font size=1>Solar-Powered CMS by </font><a target=blank href="http://www.centralpointsystems.com"><font size=1>www.centralpointsystems.com</font></a></td></tr></tbody></table></center>
		</div>
		
		</div>
		</div>
		</div>

<?php
}
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