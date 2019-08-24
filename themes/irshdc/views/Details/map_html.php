<?php
		$t_item = $this->getVar("item");
		$vn_id = $t_item->getPrimaryKey();
		if($vs_map = $this->getVar("map")){
			#$va_coordinates_raw = $t_item->get("ca_places.georeference", array("delimiter" => ";", "returnAsArray" => true));
			#$va_coordinates_processed = array();
			#if($va_coordinates_raw && is_array($va_coordinates_raw)){
			#	foreach($va_coordinates_raw as $vs_coordinates_raw){
			#		$vn_start = strpos($vs_coordinates_raw, "[");
			#		$vn_end = strpos($vs_coordinates_raw, "]");
			#		$vs_coor_tmp = substr($vs_coordinates_raw, $vn_start + 1, $vn_end - ($vn_start + 1));
			#		$va_coordinates_processed[] = $vs_coor_tmp;
			#	}
			#}
			#$vs_coordinates_processed = join("; ", $va_coordinates_processed);
			print "<div class='unit detailMap'>".$vs_map;
			print caDetailLink($this->request, '<span class="glyphicon glyphicon-new-window"></span>', '', $t_item->tableName(), $vn_id, array("mode" => "map"));
			#if($vs_coordinates_processed){
				# link is not right
			#	print "<a href='https://www.google.com/maps/place/".$vs_coordinates_processed."' target='_blank'><span class='glyphicon glyphicon-new-window'></span></a>";
			#}
			print "</div>";
		}
?>