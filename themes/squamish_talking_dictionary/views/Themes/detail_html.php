<?php
	$va_themes = $this->getVar("themes");
	$vs_theme_name = $this->getVar("theme_name");
	$vn_parent_id = $this->getVar("parent_id");
	$vs_level = $this->getVar("level");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_browse = caGetBrowseInstance("ca_objects");
	$va_facet = $o_browse->getFacet('themes_facet', array('checkAccess' => $va_access_values, 'request' => $this->request));
	$va_theme_ids_with_objects = array_keys($va_facet);
?>
	<div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1">
<H1><?php
			if($vn_parent_id){
				print caNavLink($this->request, "<i class='fa fa-arrow-left'></i>", "", "", "Themes", "Detail", array("theme_id" => $vn_parent_id))." ".$vs_theme_name;
			}else{
				print caNavLink($this->request, "<i class='fa fa-arrow-left'></i>", "", "", "Themes", "Index")." ".$vs_theme_name;
			}
?></H1>
			
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="themesFeaturedList">
<?php	
	$va_bgs = array("bgOchre", "bgLtGreen", "bgLtOrange", "bgLtBrown");
	if(is_array($va_themes) && sizeof($va_themes)) {
		$bg_c = 0;
		foreach($va_themes as $vn_theme_id => $va_theme) {
			$vs_image = "";
			print "\n<div class='row'><div class='col-sm-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3'><div class='themesTile ".$va_bgs[$bg_c]."'>";
			if($va_theme["image"]){
				print "<div class='themesImage'>".$va_theme["image"]."</div>";
			}
			if($va_theme["children"] && ($vs_level < 2)){
				print caNavLink($this->request, $va_theme["name"]." <i class='fa fa-arrow-right'></i>", "title".(($va_theme["image"]) ? "WithImage" : ""), "", "Themes", "Detail", array("theme_id" => $vn_theme_id), array("title" => "", "data-toggle" => "popover", "data-content" => "More Themes"));
			}else{
				if(in_array($vn_theme_id, $va_theme_ids_with_objects)){
					print caNavLink($this->request, $va_theme["name"], "title".(($va_theme["image"]) ? "WithImage" : ""), "", "Browse", "dictionary", array("facet" => "themes_facet", "id" => $vn_theme_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Dictionary"));
				}else{
					print "<div class='title'>".$va_theme["name"]."</div>";
				}
			}
			if(in_array($vn_theme_id, $va_theme_ids_with_objects)){
				print caNavLink($this->request, "<span class='glyphicon glyphicon-search' aria-label='Submit'></span><br/><span class='themesBrowseLabel'>Browse the Dictionary</span>", "themesBrowse", "", "Browse", "dictionary", array("facet" => "themes_facet", "id" => $vn_theme_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Dictionary"));
			}
			print "</div><!-- end tile --></div></div>";
			if($bg_c == 3){
				$bg_c = 0;
			}else{
				$bg_c++;
			}
		}
	}
		
	
?>		
			</div>
		</div>
	</div>
	
<script type='text/javascript'>
	jQuery(document).ready(function() {	
		
		var options = {
			placement: "left",
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