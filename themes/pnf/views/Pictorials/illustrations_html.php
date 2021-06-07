<?php
	$t_list = new ca_lists();
	$vn_facet_id = $t_list->getItemIDFromList("type_category", "illustration");
	global $g_ui_locale;
	AssetLoadManager::register("readmore");
 	
?>
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		<H2>Illustrations</H2>
		<hr/>
<?php
			if ($g_ui_locale == 'en_US'){			
?>
				<div class='trimText'>
					{{{illustrationsIntroEnglish}}}
				</div>
<?php
			}else{
?>
				<div class='trimText'>
					{{{illustrationsIntroSpanish}}}
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
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'ornaments', array('facet' => 'ornament_category', 'id' => $vn_facet_id, 'showFilterPanel' => 1, 'view' => 'list'), array('dontURLEncodeParameters' => true)); ?>", function() {
						
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