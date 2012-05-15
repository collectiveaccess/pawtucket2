<?php
$ps_panorama_tooltip_content = '
<div id="container" style="width:640px;height:480px;">
		This content requires HTML5/CSS3, WebGL, or Adobe Flash Player Version 9 or higher.
</div>
';

//TooltipManager::add("#panorama",$ps_panorama_tooltip_content);
?>
<script src='/js/ca/ca.genericpanel.js' type='text/javascript'></script>
<script src='/js/jquery/jquery.tools.min.js' type='text/javascript'></script>
<div>
		<div style='float:left; width:300px; margin-left:30px;'>
			<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum0.jpg' border='0' height='289' width='296'>
		</div>
		<div style='float:right; width:422px; line-height: 1.5em;'>
		<p style='font-size: 14px; font-weight: bold;'>Das Museum der Sparkasse Bad Hersfeld-Rotenburg </p>
Entdecken Sie ein liebevoll und wissenschaftlich fundiert eingerichtetes 
Museum: Im Dachgeschoss der Hauptstelle erwarten Sie knapp zwei 
Jahrhunderte regionaler Sparkassengeschichte – anschaulich, informativ 
und voller Überraschungen. Mit einem Klick auf die Symbole erhalten 
Sie knappe Einblicke in das jeweilige Thema. Hier kommen Sie zur 
<a href='#' onclick='caMediaPanel.showPanel("<?php print $this->request->getThemeUrlPath()?>/graphics/Spk-Museum7.html"); return false;' >Panoramaansicht</a>.<br/><br/>
Das Museum öffnet nach Absprache. Ehemalige Sparkassen-Mitarbeiter 
führen die Besuchergruppen. Schüler, Vereine, private Gruppen sind 
herzlich willkommen! Senden Sie <a href="mailto:marketing@spk-hef.de">eine Anfrage per Mail</a> oder vereinbaren 
Sie telefonisch einen Termin:<br />
Alfons Retting Tel. 06621/851371, Mike Rimbach Tel. 06621/851376<br /> 
<a href='<?php print $this->request->getThemeUrlPath()?>/graphics/Info-Faltblatt.pdf'>Info-Faltblatt</a>
		</div>
	</div>
	<br /><br />
	<div style='margin:0px 0px 0px 50px; width:800px; height:300px; clear:both;'>
		<img style="margin-top:30px" src='<?php print $this->request->getThemeUrlPath()?>/graphics/museum_map.jpg' border='0' height='282' width='741' usemap='#museumMap'>
	</div>
<map name="museumMap" id="museumMap" >
  <area shape="rect" coords="47,125,88,168"  href="<?php print caNavUrl($this->request, '', 'About','1825'); ?>" id="eighteen" title="1825 bis heute" />
  <area shape="rect" coords="167,203,208,244"  href="<?php print caNavUrl($this->request, '', 'About','spare'); ?>"  id="spare" title="Spare in der Zeit!" />
  <area shape="rect" coords="327,203,367,244"  href="<?php print caNavUrl($this->request, '', 'About','nah'); ?>"  id="nah" title="Nah am Kunden" />
  <area shape="rect" coords="462,203,504,244"  href="<?php print caNavUrl($this->request, '', 'About','klingende'); ?>"  id="klingende" title="Klingende Münze" />
  <area shape="rect" coords="660,155,702,196"  href="<?php print caNavUrl($this->request, '', 'About','sicher'); ?>"  id="sicher" title="Sicher ist sicher" />
  <area shape="rect" coords="504,29,545,70"  href="<?php print caNavUrl($this->request, '', 'About','soll'); ?>"  id="soll" title="Soll und Haben" />
  <area shape="rect" coords="328,29,368,70"  href="<?php print caNavUrl($this->request, '', 'About','giro'); ?>"  id="giro" title="Giro und Kontokorrent" />
  <area shape="rect" coords="194,29,235,70"  href="<?php print caNavUrl($this->request, '', 'About','rechnen'); ?>"  id="rechnen" title="Rechnen, schreiben, kommunizieren" />
  <area shape="rect" coords="269,112,312,155"  href="<?php print caNavUrl($this->request, '', 'About','abfertigen'); ?>"  id="abfertigen" title="Abfertigen oder bedienen" />
</map>
</div>
<?php
	TooltipManager::add(
		"#eighteen", "<div style='color:red'>1825 bis heute</div>"
	);
	TooltipManager::add(
		"#spare", "<div style='color:red'>Spare in der Zeit!</div>"
	);
	TooltipManager::add(
		"#nah", "<div style='color:red'>Nah am Kunden</div>"
	);
	TooltipManager::add(
		"#klingende", "<div style='color:red'>Klingende Münze</div>"
	);
	TooltipManager::add(
		"#sicher", "<div style='color:red'>Sicher ist sicher</div>"
	);
	TooltipManager::add(
		"#soll", "<div style='color:red'>Soll und Haben</div>"
	);
	TooltipManager::add(
		"#giro", "<div style='color:red'>Giro und Kontokorrent</div>"
	);
	TooltipManager::add(
		"#rechnen", "<div style='color:red'>Rechnen, schreiben, kommunizieren</div>"
	);
	TooltipManager::add(
		"#abfertigen", "<div style='color:red'>Abfertigen oder bedienen</div>"
	);
	
?>