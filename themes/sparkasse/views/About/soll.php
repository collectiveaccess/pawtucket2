<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "sicher")."</span>";
?>	
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "giro")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum6.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/soll.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Soll und Haben</span><br/>
			<span><i>Die Buchhaltung der Sparkasse</i></span></div> 
		</div>
		<div>
<p>Bis etwa 1925 wurde jede Buchung handschriftlich in großen Büchern 
verzeichnet. Die Rationalisierung verlief schrittweise: Auflösung der 
Bücher in lose Karten und Belege, Einsatz von Buchungsmaschinen und 
schließlich Übergang zur Computertechnik. Für jede dieser Phasen 
zeigt die Ausstellung originale Objekte, vom großformatigen 
Kassabuch über die feinmechanischen Meisterwerke der Buchungsmaschinen
bis zu den „Dinosauriern“ der Datenverarbeitung.</p>
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Buchhaltung"));?>
</p>

		</div>
	</div>
</div>