<?php
	$va_set_list = $this->getVar('sets');
	$va_set_display_items = $this->getVar('set_display_items');

?>
<a href='#' id='hideFeatures' onclick='$("#scrollableContainer").slideUp(250); $("#showFeatures").slideDown(1); $("#hideFeatures").slideUp(1); return false;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
<a href='#' id='showFeatures' onclick='$("#scrollableContainer").slideDown(250); $("#showFeatures").slideUp(1); $("#hideFeatures").slideDown(1); return false;'><?php print _t("Browse All Highlights"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
<h1><?php print _t("Highlights"); ?></h1>
<!-- BEGIN List of sets -->
<div id="scrollableContainer">
	<a class="prevPage setTileScrollControl"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_large_gr_lt.gif' width='20' height='31' border='0'></a>
	<!-- root element for scrollable --> 
	<div class="scrollable">     
		<!-- root element for the items --> 
		<div class="items"> 
<?php
		$t_set = new ca_sets();
		$vn_i = 0;
		foreach($va_set_list as $va_set) {
			$vn_set_id = $va_set['set_id'];
			if ($t_set->load($vn_set_id)) {
				$va_item = $va_set_display_items[$vn_set_id][array_shift(array_keys($va_set_display_items[$vn_set_id]))];
				
				$vn_item_width = $va_item['representation_width'];
				$vn_item_height = $va_item['representation_height'];
				
				if ($vn_i == 0) {
					print "<div>";
				}
?>
				<div class='setTile'>
					<div class='setTileImage set<?php print $va_set['set_id']; ?>'>
						<div style='margin-top: <?php print floor((160 - $vn_item_height)/2); ?>px; margin-left: <?php print floor((160 - $vn_item_width)/2); ?>px'><a href='#' onclick='loadSet(<?php print $va_set['set_id']; ?>);  return false;'><?php print $va_item['representation_tag']; ?></a></div>
					
					</div>
				</div>
<?php
				if($t_set->getLabelForDisplay()){
					// set view vars for tooltip
					$this->setVar('tooltip_text', preg_replace('![\n\r]+!', '<br/><br/>', $t_set->getLabelForDisplay()));
					TooltipManager::add(
						".set{$va_set['set_id']}", $this->render('Features/features_tooltip_html.php')
					);
				}
			}
			
			$vn_i++;
			if ($vn_i == 3) {
				print "</div>";
				$vn_i = 0;
			}
		}
			if ($vn_i) {
				print "</div>";
			}
?>
			<div class='setTileEmpty'>
				<!-- empty -->
			</div><div class='setTileEmpty'>
				<!-- empty -->
			</div>
		</div> 
	</div> 
 	<a class="nextPage setTileScrollControl"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_large_gr_rt.gif' width='20' height='31' border='0'></a>
 	<div style="clear: both"><!-- empty --></div>
</div>
<!-- END List of sets -->

<div id="featuresContent">
	<div class="textContent">
<?php
	print $this->render('Features/features_intro_text_html.php');
?>
	</div>
</div>

<script type="text/javascript"> 
	jQuery(document).ready(function() { 
		jQuery("div.scrollable").scrollable({
			next: '.nextPage',
			prev: '.prevPage',
			items: '.items',
			speed: 1200,
			vertical: false
		}); 
	}); 

	function loadSet(set_id) {
		jQuery('#featuresContent').load('<?php print caNavUrl($this->request, '', 'Features', 'displaySet'); ?>', {set_id: set_id});
	}
</script>