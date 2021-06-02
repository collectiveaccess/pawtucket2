<?php
	$t_list = new ca_lists();
	$vn_facet_id = $t_list->getItemIDFromList("ornament_category", "printers_mark");
	$vn_facet_id2 = $t_list->getItemIDFromList("ornament_category", "printers_device");
	global $g_ui_locale;
	AssetLoadManager::register("readmore");
 	
?>
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		<H2>Printer's Marks & Devices</H2>
		<hr/>
<?php
			if ($g_ui_locale == 'en_US'){			
?>
				<div class='trimText'>
					{{{printersDevicesIntroEnglish}}}
				</div>
<?php
			}else{
?>
				<div class='trimText'>
					{{{printersDevicesIntroSpanish}}}
				</div>
<?php
			
			}		
?>
		<br/><h3 class="text-center">Browse</h3>
		<hr/>

			<div class="row">
				<div id="browseResultsDetailContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'ornaments', array('facet' => 'ornament_category', 'id' => $vn_facet_id.';'.$vn_facet_id2, 'showFilterPanel' => 1, 'view' => 'list'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>

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