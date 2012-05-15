<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "spare")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum1.jpg' border='0' height='360' width='294'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/1825.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>1825 bis heute</span><br/>
			<span><i>Der Weg der Sparkasse Bad Hersfeld-Rotenburg</i></span></div> 
		</div>
		<div>
<p>Die Instituts-Chronik mit einer reizvollen Gegenüberstellung 
zeitgeschichtlicher Ereignisse steht am Anfang des Rundgangs. 
Zwischen 1825 und 1924 entstehen die Vorgängerinstitute: zunächst 
die städtischen Sparkassen, dann die Kreissparkassen. Danach 
fusionieren die Stadt- und Kreissparkassen der beiden Altkreise, bevor 
durch die Kreisreform 1974 die heutige Sparkasse Bad Hersfeld-Rotenburg
entsteht.</p> 
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Chronik"));?>
</p>
		</div>
	</div>
</div>