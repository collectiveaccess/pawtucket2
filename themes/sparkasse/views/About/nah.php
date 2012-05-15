<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "spare")."</span>";
?>	
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "klingende")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum3.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/nah.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Nah am Kunden</span><br/>
			<span><i>Sparkassenfilialen in der Region</i></span></div> 
		</div>
		<div>
<p>Bevor es moderne Kommunikationsnetze gab, bedeutete Kundennähe 
vor allem räumliche Nähe. Das Problem der Versorgung in der Fläche 
wurde im letzten Jahrhundert mit einem dichten Netz aus Zweigstellen, 
Kleinstfilialen und mobilen Serviceangeboten gelöst. Die Arbeitsbedin- 
gungen der „fliegenden Sparkassenmitarbeiter“ mit ihrer Kofferfiliale 
oder im Sparkassen-Bus sowie in der „Ein-Mann“-Filiale werden
nachvollziehbar präsentiert.</p> 
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Filialnetz"));?>
</p>
		</div>
	</div>
</div>