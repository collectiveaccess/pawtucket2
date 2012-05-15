<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "nah")."</span>";
?>	
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "sicher")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum4.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/klingende.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Klingende Münze</span><br/>
			<span><i>Arbeit mit Münzen und Noten</i></span></div> 
		</div>
		<div>
<p>Trotz Chipkarte und Giroverkehr ist die Arbeit mit realem Geld nach 
wie vor fester Bestandteil der Sparkassenarbeit. Die Hilfsmittel für die  
Sparkassenmitarbeiter wurden im Laufe der Zeit immer leistungsfähiger.
Die Ausstellung präsentiert hier eine Vielzahl von Geräten 
und Automaten. Auch das Geld in den Händen der Kunden und 
Mitarbeiter änderte sich im Laufe der Jahrzehnte mehrfach. Eine 
Münzsammlung macht diesen Wandel greifbar.</p> 
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Bargeld"));?>
</p>
		</div>
	</div>
</div>