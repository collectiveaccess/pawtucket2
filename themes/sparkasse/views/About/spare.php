<div class='upperDiv'>
	<span style='margin-right:30px;'><b>
<?php 
	print caNavLink($this->request, _t("zur Übersicht"), "", "", "About", "museum");
?>
	</b></span>
<span>
<?php 
	print caNavLink($this->request, _t("zurück&nbsp; <img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='14' width='12'>"), "", "", "About", "1825")."</span>";
?>	
	<span>
<?php 
	print caNavLink($this->request, _t("<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='14' width='12'>&nbsp; vor"), "", "", "About", "nah")."</span>";
?>
</div>
<div>
	<div class='leftSide'>
		<img src='<?php print $this->request->getThemeUrlPath()?>/graphics/Museum2.jpg' border='0' height='367' width='275'>
	</div>
	<div class='rightSide'>	
		<div class='leader'>
			<div style='float:left;'><img src='<?php print $this->request->getThemeUrlPath()?>/graphics/spare.jpg' border='0' height='28' width='29'></div>
			<div style='float:left; width:340px; margin:0px 0px 10px 10px; line-height:1.4em;'><span style='color:red; font-weight:bold;'>Spare in der Zeit!</span><br/>
			<span><i>Die Entwicklung der Sparkultur</i></span></div> 
		</div>
		<div>
<p>Sparsamkeit ist eine kulturelle Leistung des Menschen, die einem 
geschichtlichen Wandel unterworfen ist. Die Sparkassen entwickelten 
verschiedene Techniken, um die Idee des Sparens im Bewusstsein 
möglichst breiter Bevölkerungsschichten zu verankern. Sparbücher und 
Sparmarken sind hier die ältesten Zeugnisse. Auch die Aktivitäten zum 
Weltspartag und PS-Sparen sind dokumentiert. Und natürlich fehlt auch 
eine große bunte Sammlung unterschiedlichster Spardosen nicht.</p> 
<p>
<?php print caNavLink($this->request, "Objekte zu diesem Thema", "", "", "Search", "Index",array("search" => "ca_storage_location_labels.name:Sparen"));?>
</p>
		</div>
	</div>
</div>