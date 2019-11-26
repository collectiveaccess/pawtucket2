<?php
$vs_mode = $this->request->getParameter("mode", pString);
$va_options = $this->getVar("config_options");
$t_item = $this->getVar("item");
$vn_id = $t_item->getPrimaryKey();
if($vs_mode == "map"){
	$vs_map = $this->getVar("map");
?>
	<div class="row">
		<div class="col-sm-12 text-center">
			<?php print caDetailLink($this->request, '<button type="button" class="btn btn-default btn-small"><i class="fa fa-angle-double-left"></i> Back</button>', '', $t_item->tableName(), $vn_id); ?>
			<br/><br/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<?php
				if (!is_array($va_map_attributes = caGetOption(['mapAttributes', 'map_attributes'], $va_options, array())) || !sizeof($va_map_attributes)) {
					if ($vs_map_attribute = caGetOption(['mapAttribute', 'map_attribute'], $va_options, false)) { $va_map_attributes = array($vs_map_attribute); }
				}
				if(is_array($va_map_attributes) && sizeof($va_map_attributes)) {
					$o_map = new GeographicMap(caGetOption('map_large_width', $va_options, false), caGetOption('map_large_height', $va_options, false), "map");
					
					$vn_mapped_count = 0;	
					foreach($va_map_attributes as $vs_map_attribute) {
						if ($t_item->get($vs_map_attribute)){
							$va_ret = $o_map->mapFrom($t_item, $vs_map_attribute, array('labelTemplate' => caGetOption('mapLabelTemplate', $va_options, false), 'contentTemplate' => caGetOption('mapContentTemplate', $va_options, false)));
							$vn_mapped_count += $va_ret['items'];
						}
					}
				
					if ($vn_mapped_count > 0) { 
						print $o_map->render('HTML', array("zoomLevel" => caGetOption('map_large_zoom_level', $va_options, null),"maxZoomLevel" => caGetOption('map_large_max_zoom_level', $va_options, null), "minZoomLevel" => caGetOption('map_large_min_zoom_level', $va_options, null)));
					}
				}
			?>
		</div>
	</div>
<?php
}
?>