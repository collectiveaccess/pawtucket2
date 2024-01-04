<?php
	$va_types = $this->getVar("types");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_browse = caGetBrowseInstance("ca_objects");
	$va_facet = $o_browse->getFacet('type_facet', array('checkAccess' => $va_access_values, 'request' => $this->request));
	$va_type_ids_with_objects = array_keys($va_facet);

?>
<div class="row">
	<div class="col-md-12 col-lg-10 col-md-offset-1">
		<h1>Explore by Types</h1>
		<div class="typesIntro">
			{{{explore_types_intro}}}
		</div>

		<div class="typesFeaturedList">
<?php	
	if(is_array($va_types) && sizeof($va_types)) {
		$col_c = 1;
		foreach($va_types as $vn_type_id => $va_type) {
			
			if(in_array($vn_type_id, $va_type_ids_with_objects)){
				$vs_image = "";
				if($col_c == 1){
					print "\n<div class='row'>";
				}
				print "<div class='col-sm-12 col-md-6'><div class='typesTile'>";
				if($va_type["image"]){
					print "<div class='typesImage'>".$va_type["image"]."</div>";
				}
				if($va_type["children"]){
					print "<div class='title".(($va_type["image"]) ? "WithImage" : "")."'>".caNavLink($this->request, $va_type["name"]." <i class='fa fa-arrow-right'></i>", "", "", "Explore", "TypesDetail", array("type_id" => $vn_type_id), array("title" => "", "data-toggle" => "popover", "data-content" => "More Types", "data-placement" => "left"))."</div>";
				}else{
					if(in_array($vn_type_id, $va_type_ids_with_objects)){
						print "<div class='title".(($va_type["image"]) ? "WithImage" : "")."'>".caNavLink($this->request, $va_type["name"], "", "", "Browse", "objects", array("facet" => "type_facet", "id" => $vn_type_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Collections", "data-placement" => "left"))."</div>";
					}else{
						print "<div class='title'>".$va_type["name"]."</div>";
					}
				}
				if(in_array($vn_type_id, $va_type_ids_with_objects)){
					print caNavLink($this->request, "<span class='glyphicon glyphicon-search' aria-label='Search'></span><br/><span class='typesBrowseLabel'>Browse the Collections</span>", "typesBrowse", "", "Browse", "objects", array("facet" => "type_facet", "id" => $vn_type_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Collections"));
				}
				print "</div><!-- end tile --></div><!-- end col -->";
			
			
				if($col_c == 2){
					print "</div>";
					$col_c = 1;
				}else{
					$col_c++;
				}
			}
		}
		if($col > 1){
			print "</div>";
		}
	}	
?>		
		</div>	
	</div>
</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {	
		
		var options = {
			placement: "auto top",
			trigger: "hover",
			html: "true"
		};
		
		$('[data-toggle="popover"]').each(function() {
			if($(this).attr('data-content')){
				$(this).popover(options).click(function(e) {
					$(this).popover('toggle');
				});
			}
		});
	});
</script>