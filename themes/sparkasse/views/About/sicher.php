<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "klingende")."</span>";
?>	
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "soll")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum5.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/sicher.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Sicher ist sicher</span><br/>
			<span><i>Sicherheit als Geschäftsprinzip</i></span></div> 
		</div>
		<div>
<p>Sicherheit ist die grundlegendste Dienstleistung der Sparkassen. 
Stahlkammer und Kundenschließfächer, Nachttresor und Panzerschrank 
dokumentieren die sichere Verwahrung materieller Werte. Alte 
Hypothekenbriefe sowie mündelsichere und dollargebundene 
Sparbücher stehen für das Versprechen der Anlagesicherheit. Auch das 
Regelwerk zum Schutz vor Unterschlagung und die Vorkehrungen 
gegen Betrug und Raub werden präsentiert.</p> 
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Sicherheit"));?>
</p>
		</div>
	</div>
</div>