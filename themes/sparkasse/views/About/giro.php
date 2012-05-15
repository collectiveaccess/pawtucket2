<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "soll")."</span>";
?>	
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "rechnen")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum7.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/giro.jpg' border='0' height='29' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Giro und Kontokorrent</span><br/>
			<span><i>Der bargeldlose Zahlungsverkehr</i></span></div> 
		</div>
		<div>
<p>Seit 1923 konnten die Sparkassenkunden der Region Girokonten 
eröffnen. Ende der 50er Jahre stieg die Zahl der Privatkonten rasant an. 
Die Bewältigung des Massengeschäftes hatte weitreichende Folgen für 
die Arbeit in der Sparkasse: Die organisatorische Rationalisierung ging 
einher mit einem Wandel im Formularwesen sowie neuen Maschinen 
und Apparaten. Die Abläufe im bargeldlosen Zahlungsverkehr erklärt 
eine Multi-Media Station in einem originalen SB-Terminal.</p>
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:bargeldlos"));?>
</p>
		</div>
	</div>
</div>