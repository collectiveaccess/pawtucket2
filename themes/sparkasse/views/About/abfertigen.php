<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "rechnen")."</span>";
?>	
	
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum9.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/abfertigen.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Abfertigen oder bedienen</span><br/>
			<span><i>Kundenkontakt im Wandel</i></span></div> 
		</div>
		<div>
<p>Den Abschluss der Ausstellung bildet eine weitere Chronologie: der 
Blick in die Kassenhallen der Hauptstellen zu unterschiedlichen Zeiten. 
Deren Ausstattung und Gestaltung hat sich seit den 20er Jahren 
mehrfach stark verändert. In der Art und Weise, wie sich die 
Sparkassen ihren Kunden präsentierte, spiegelt sich mehr als nur der 
Wandel in Mode und Zeitgeist. Hier werden auch starke Veränderungen 
in Unternehmensphilosophie und Kundenansprache erkennbar.</p>
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Kundenkontakt"));?>
</p>
		</div>
	</div>
</div>