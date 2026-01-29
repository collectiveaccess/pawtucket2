<?php
	$va_categories = $this->getVar("categories");
	$qr_categories = $this->getVar("categories_search");
	global $g_ui_locale;
	AssetLoadManager::register("readmore");
 	
?>
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
<?php
			if ($g_ui_locale == 'en_US'){			
?>
				<H2>Ornaments & Illustrations</H2>
				<hr/>

				<div class='trimText'>
					{{{ornamentsIntroEnglish}}}
				</div>
<?php
			}else{
?>
				<H2>Ornamentos e Ilustraciones</H2>
				<hr/>

				<div class='trimText'>
					{{{ornamentsIntroSpanish}}}
				</div>
<?php
			
			}		
?>
		<br/>
		<hr/>
<?php
		if($qr_categories && $qr_categories->numHits()){
?>
			<div class="row ornamentsGrid">
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
			if ($g_ui_locale == 'en_US'){			
?>
				<H2 style="margin-top:40px;">Bibliography</H2>
				<hr/>

				<div class='trimText'>
					{{{ornamentsBibEnglish}}}
				</div>
<?php
			}else{
?>
				<H2 style="margin-top:40px;">Bibliografia</H2>
				<hr/>

				<div class='trimText'>
					{{{ornamentsBibSpanish}}}
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