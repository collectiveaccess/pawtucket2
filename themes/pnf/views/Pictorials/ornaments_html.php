<?php
	$va_categories = $this->getVar("categories");
	$qr_categories = $this->getVar("categories_search");
	global $g_ui_locale;
	AssetLoadManager::register("readmore");
 	
?>
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		<H2>Ornaments</H2>
		<hr/>
<?php
			if ($g_ui_locale == 'en_US'){			
?>
				<div class='trimText'>
					{{{ornamentsIntroEnglish}}}
				</div>
<?php
			}else{
?>
				<div class='trimText'>
					{{{ornamentsIntroSpanish}}}
				</div>
<?php
			
			}		
?>
		<br/><h3 class="text-center">Browse</h3>
		<hr/>
<?php
		if($qr_categories && $qr_categories->numHits()){
?>
			<div>
<?php
			while($qr_categories->nextHit()){
				if(!in_array(strToLower($qr_categories->get("ca_list_item_labels.name_singular")), array("illustration", "printer's device"))){
					print "<div class='col-sm-12 col-md-6 col-lg-4'>".caNavLink($this->request, "<div class='ornamentsCatItem'>".strToLower($qr_categories->get("ca_list_item_labels.name_singular"))."</div>", "", "", "Browse", "ornaments", array("facet" => "ornament_category", "id" => $qr_categories->get("ca_list_items.item_id")))."</div>";
				}
			}
?>
			</div>
<?php
		}
?>
	</div>
</div>

<script type="text/javascript">
	
	jQuery(document).ready(function() {
		$(".trimText").readmore({
		  speed: 75,
		  maxHeight: 225,
		  moreLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ MORE" : "LEER MÁS"; ?></a>",
		  lessLink: "<a href='#'><?php print ($g_ui_locale == 'en_US') ? "READ LESS" : "CERRAR"; ?></a>",
  
		});
	});
</script>