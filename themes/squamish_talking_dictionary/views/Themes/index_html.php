<?php
	$va_themes = $this->getVar("themes");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_browse = caGetBrowseInstance("ca_objects");
	$va_facet = $o_browse->getFacet('themes_facet', array('checkAccess' => $va_access_values, 'request' => $this->request));
	$va_theme_ids_with_objects = array_keys($va_facet);

?>
	
<div class="intro">
<div class="row bgGreen">
	<div class="col-md-3 col-md-offset-1 col-lg-2 col-lg-offset-2">
		<div class='introTitle'>
			Themes
		</div>
	</div>
	<div class="col-md-7 col-lg-6">
		<div class="introText">
			{{{td_themes_intro}}}
		</div>
	</div>
</div></div>
<div class="row bgOchre bgBorder"><div class="col-sm-12"></div></div>
	<div class="row">
		<div class="col-sm-12">
			<div class="themesFeaturedList">
<?php	
	$va_bgs = array("bgOchre", "bgLtGreen", "bgLtOrange", "bgLtBrown");
	if(is_array($va_themes) && sizeof($va_themes)) {
		$col_c = 0;
		$bg_c = 0;
		foreach($va_themes as $vn_theme_id => $va_theme) {
			$vs_image = "";
			print "\n<div class='row'><div class='col-sm-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3'><div class='themesTile ".$va_bgs[$bg_c]."'>";
			if($va_theme["image"]){
				print "<div class='themesImage'>".$va_theme["image"]."</div>";
			}
			if($va_theme["children"]){
				print "<div class='title".(($va_theme["image"]) ? "WithImage" : "")."'>".caNavLink($this->request, $va_theme["name"]." <i class='fa fa-arrow-right'></i>", "", "", "Themes", "Detail", array("theme_id" => $vn_theme_id), array("title" => "", "data-toggle" => "popover", "data-content" => "More Themes", "data-placement" => "left"))."</div>";
			}else{
				if(in_array($vn_theme_id, $va_theme_ids_with_objects)){
					print "<div class='title".(($va_theme["image"]) ? "WithImage" : "")."'>".caNavLink($this->request, $va_theme["name"], "", "", "Browse", "dictionary", array("facet" => "themes_facet", "id" => $vn_theme_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Dictionary", "data-placement" => "left"))."</div>";
				}else{
					print "<div class='title'>".$va_theme["name"]."</div>";
				}
			}
			if(in_array($vn_theme_id, $va_theme_ids_with_objects)){
				print caNavLink($this->request, "<span class='glyphicon glyphicon-search' aria-label='Search'></span><br/><span class='themesBrowseLabel'>Browse the Dictionary</span>", "themesBrowse", "", "Browse", "dictionary", array("facet" => "themes_facet", "id" => $vn_theme_id), array("title" => "", "data-toggle" => "popover", "data-content" => "Browse the Dictionary"));
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