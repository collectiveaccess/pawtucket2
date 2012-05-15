<?php
	$va_set_list = $this->getVar('sets');
	$va_set_display_items = $this->getVar('set_display_items');

?>
<a href='#' id='hideFeatures' onclick='$("#scrollableContainer").slideUp(250); $("#showFeatures").slideDown(1); $("#hideFeatures").slideUp(1); return false;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
<a href='#' id='showFeatures' onclick='$("#scrollableContainer").slideDown(250); $("#showFeatures").slideUp(1); $("#hideFeatures").slideDown(1); return false;'><?php print _t("Browse All Features"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
<h1>Features</h1>
<!-- BEGIN List of sets -->
<div id="scrollableContainer">
	<a class="prevPage setTileScrollControl"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browse_arrow_large_gr_lt.gif' width='20' height='31' border='0'></a>
	<!-- root element for scrollable --> 
	<div class="scrollable">     
		<!-- root element for the items --> 
		<div class="items"> 
<?php
		$t_set = new ca_sets();
		foreach($va_set_list as $va_set) {
			$vn_set_id = $va_set['set_id'];
			if ($t_set->load($vn_set_id)) {
				$va_item = $va_set_display_items[$vn_set_id][array_shift(array_keys($va_set_display_items[$vn_set_id]))];
				
				$vn_item_width = $va_item['representation_width'];
				$vn_item_height = $va_item['representation_height'];
?>
				<div class='setTile'>
					<div class='setTileImage set<?php print $va_set['set_id']; ?>'>
						<div style='margin-top: <?php print floor((160 - $vn_item_height)/2); ?>px; margin-left: <?php print floor((160 - $vn_item_width)/2); ?>px'><a href='#' onclick='loadSet(<?php print $va_set['set_id']; ?>);  return false;'><?php print $va_item['representation_tag']; ?></a></div>
					
					</div>
				</div>
<?php
				if($t_set->getLabelForDisplay()){
					// set view vars for tooltip
					$this->setVar('tooltip_text', preg_replace('![\n\r]+!', '<br/><br/>', addslashes($t_set->getLabelForDisplay())));
					TooltipManager::add(
						".set{$va_set['set_id']}", $this->render('Features/features_tooltip_html.php')
					);
				}
			}
		}
?>
			<div class='setTileEmpty'>
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
		<div>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sapien libero, consectetur vitae placerat 
			vitae, congue at odio. Cras urna lectus, hendrerit vitae tempor sit amet, dapibus sit amet libero. Nunc at 
			massa lorem, vel interdum dui. Sed id ante vitae elit tristique consequat. Morbi eu fringilla felis. Sed 
			euismod augue a elit adipiscing et tempor tellus iaculis. Etiam nec mollis dolor. Nam vulputate lorem eu 
			leo pretium eleifend. Vivamus eu varius mauris. Nunc mi massa, dictum in luctus vel, tempor sodales diam. 
			Morbi in nisi urna. In ac risus quis justo venenatis semper eget nec diam. Aenean sollicitudin ligula et mi 
			faucibus quis convallis justo eleifend.
		</div>
		<div>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque viverra ante eu tellus pharetra ultricies. 
			Aliquam erat volutpat. Donec non ligula et velit condimentum blandit. Aenean eu dolor orci. Duis eu sodales tellus. 
			Sed non diam et dolor pharetra rhoncus eget non purus. In sit amet metus a odio egestas tincidunt vitae in erat. 
			Praesent rhoncus neque vel dui euismod ac commodo felis egestas. Phasellus auctor vulputate eleifend. Quisque varius 
			egestas eros.
		</div>
	</div>
</div>

<script type="text/javascript"> 
	jQuery(document).ready(function() { 
		jQuery("div.scrollable").scrollable(); 
	 
	}); 

	function loadSet(set_id) {
		jQuery('#featuresContent').load('<?php print caNavUrl($this->request, '', 'Features', 'displaySet'); ?>', {set_id: set_id});
	}
</script>