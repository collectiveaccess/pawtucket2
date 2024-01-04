<?php
	$va_types = $this->getVar("types");
	$vs_type_name = $this->getVar("type_name");
	$vn_parent_id = $this->getVar("parent_id");
	$vs_level = $this->getVar("level");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_browse = caGetBrowseInstance("ca_objects");
	$va_facet = $o_browse->getFacet('type_facet', array('checkAccess' => $va_access_values, 'request' => $this->request));
	$va_type_ids_with_objects = array_keys($va_facet);
?>
	<div class="row">
		<div class="col-md-12 col-lg-10 col-md-offset-1">
<H1><?php
			if($vn_parent_id){
				print caNavLink($this->request, "<i class='fa fa-arrow-left'></i>", "", "", "Explore", "TypesDetail", array("type_id" => $vn_parent_id))." ".$vs_type_name;
			}else{
				print caNavLink($this->request, "<i class='fa fa-arrow-left'></i>", "", "", "Explore", "Types")." ".$vs_type_name;
			}
?></H1>
			
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
				print "<div class='col-sm-12 col-md-6'><div class='typesTile ".$va_bgs[$bg_c]."'>";
				if($va_type["image"]){
					print "<div class='typesImage'>".$va_type["image"]."</div>";
				}
				if($va_type["children"] && ($vs_level < 2)){
					print caNavLink($this->request, $va_type["name"]." <i class='fa fa-arrow-right'></i>", "title".(($va_type["image"]) ? "WithImage" : ""), "", "Explore", "TypesDetail", array("type_id" => $vn_type_id), array("title" => "", "data-toggle" => "popover", "data-content" => "More Types"));
				}else{
					if(in_array($vn_type_id, $va_type_ids_with_objects)){
						print "<div class='title".(($va_type["image"]) ? "WithImage" : "")."'>".caNavLink($this->request, $va_type["name"], "", "", "Browse", "objects", array("facet" => "type_facet", "id" => $vn_type_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Collections"))."</div>";
					}else{
						print "<div class='title'>".$va_type["name"]."</div>";
					}
				}
				if(in_array($vn_type_id, $va_type_ids_with_objects)){
					print caNavLink($this->request, "<span class='glyphicon glyphicon-search' aria-label='Submit'></span><br/><span class='typesBrowseLabel'>Browse the Collections</span>", "typesBrowse", "", "Browse", "objects", array("facet" => "type_facet", "id" => $vn_type_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Collections"));
				}
				print "</div><!-- end tile --></div>";
				if($col_c == 2){
					$col_c = 1;
					print "</div>";
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
			placement: "top",
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