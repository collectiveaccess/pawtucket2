<?php
	$o_config = $this->getVar("config");
	$va_type_icons = $o_config->get("type_icons");
	$va_types = $this->getVar("types");
?>
<div class="row"><div class="col-sm-12">
	<H1 class="text-center">Explore</H1>
</div></div>
<div class="row exploreTypes">
<?php
	$i = 1;
	foreach($va_types as $va_type){
		$va_type = $va_type[1];
		print "<div class='col-sm-2".(($i == 1) ? " col-sm-offset-1" : "")."'>";
		print caNavLink($this->request, "<div class='exploreType'>".$va_type_icons[$va_type["idno"]]."<br/>".$va_type["name_plural"]."</div>", "", "", "Explore", "type", array("type_id" => $va_type["item_id"]));
		print "</div>";
		$i++;
	}
?>
</div>
<div class="row"><div class="col-sm-12">
	<H1 class="text-center">Browse</H1>
</div></div>
<div class="row exploreBrowseTypes">
<?php
	$i = 0;
	foreach($va_types as $va_type){
		$va_type = $va_type[1];
		if($i == 0){
			print "<div class='row'>";
		}
?>
		<div class='col-sm-12 col-md-6'>
			<div class='exploreBrowse'>
				<div class="row">
					<div class="col-sm-6">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'explore_'.$va_type["idno"].'.jpg', array("alt" => "Explore ".$va_type["name_plural"])), "", "", "Browse", "objects", array("facet" => "type_facet", "id" => $va_type["item_id"])); ?>
					</div>
					<div class="col-sm-6">
						<?php print caNavLink($this->request, $va_type["name_plural"], "exploreBrowseTitle", "", "Browse", "objects", array("facet" => "type_facet", "id" => $va_type["item_id"])); ?>
						<p>{{{explore_browse_<?php print $va_type["idno"]; ?>}}}</p>
					</div>
				</div>
				<br/><div class="text-center">
<?php
				print caNavLink($this->request, "Browse ".$va_type["name_plural"], "btn btn-default", "", "Browse", "objects", array("facet" => "type_facet", "id" => $va_type["item_id"]));
?>
				</div>
			</div>
		</div>
<?php
		$i++;
		if($i == 2){
			print "</div>";
			$i = 0;
		}
	}
	if($i > 1){
		print "</div>";
	}
?>
</div>