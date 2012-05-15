<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "giro")."</span>";
?>	
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "abfertigen")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum8.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/rechnen.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Rechnen, schreiben, kommunizieren</span><br/>
			<span><i>Büroarbeit im Sparkassenbetrieb</i></span></div> 
		</div>
		<div>
<p>Die Mechanisierungswelle im Bürobereich erfasste die hiesigen 
Sparkassen erst in den 20er Jahren. Die gezeigten Rechen- und 
Additionsmaschinen, die Schreibmaschinen und Kommunikationsgeräte
dokumentieren sieben Jahrzehnte der Mechanisierung und 
Technisierung von Büroarbeit. Wie fast alle Objekte der Ausstellung 
waren sie in der Sparkasse Bad Hersfeld-Rotenburg bzw. einer ihrer 
Vorgängerinstitute im Einsatz.</p>
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Rechnen"));?>
</p>
		</div>
	</div>
</div>