<?php
	$va_access_values = $this->getVar("access_values");
	$pn_period = $this->getVar("period");
	$va_periods = $this->getVar("periods");
	$va_period_data = $this->getVar("period_data");
	$q_objects = $va_period_data["objects"];
	$q_occurrences = $va_period_data["occurrences"];
	$q_styles_schools = $va_period_data["styles_schools"];
	$q_entities = $va_period_data["entities"];
	
	$va_entities_with_objects = $va_period_data["entities_with_objects"];
	$va_occurrences_with_objects = $va_period_data["occurrences_with_objects"];		// NOT CURRENTLY USED
	$va_list_items_with_objects = $va_period_data["list_items_with_objects"];
?>

	<div id="subnav">
		<ul>
<?php
			foreach($va_periods as $vn_period => $va_period_info){
				print "<li>".caNavLink($this->request, $va_period_info["label"].(($vn_period == $pn_period) ? " &raquo;" : ""), ($vn_period == $pn_period) ? "selected" : "", "eastend", "Chronology", "Index", array("period" => $vn_period))."</li>";
			}
?>
		</ul>		
	</div><!--end subnav-->
	<div id="chron_content">
		<div id="chron_thumb">
<?php
			print $this->render('chronology_object_results_html.php');
?>
		</div> <!--end chron_thumb-->
		<div id="chron_info">
			<h2><?php print $va_periods[$pn_period]["label"]; ?></h2>
<?php
			# --- set the height of the scrolling lists based on how many lists there are, this way the height of the column matches the height of the image column
			$vn_col_height = 490;
			$vn_num_cols = 0;
			if($q_occurrences->numHits()){
				$vn_num_cols++;
			}
			if($q_styles_schools->numHits()){
				$vn_num_cols++;
			}
			if($q_entities->numHits()){
				$vn_num_cols++;
			}
			switch($vn_num_cols){
				case 1:
					$vn_col_height = 490;
				break;
				# ---
				case 2:
					$vn_col_height = 227;
				break;
				# ---
				case 3:
					$vn_col_height = 139;
				break;
				# ---
			}
			# --- list of all occurrences from the period
			if($q_occurrences->numHits()){
				print "<div class='linedivide'></div>";
				print "<span class='listhead caps'>"._t("Events & Exhibitions")."</span>";
				print "<div class='chronoLists' style='height:".$vn_col_height."px;'><div><ul>";
				while($q_occurrences->nextHit()){
					print "<li>";
					#print "<a href='#' onclick='jQuery(\"#chron_thumb\").load(\"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'occurrence_id' => $q_occurrences->get("occurrence_id")))."\"); return false;'>".join(", ", $q_occurrences->getDisplayLabels())."</a>";
					print caNavLink($this->request, join(", ", $q_occurrences->getDisplayLabels()), "", "Detail", "Occurrence", "Show", array("occurrence_id" => $q_occurrences->get("occurrence_id")));
					print "</li>";
				}
				print "</ul></div></div>";
			}
			# --- list of all styles and schools from the period
			if($q_styles_schools->numHits()){
				print "<div class='linedivide'></div>";
				print "<span class='listhead caps'>"._t("Styles & Schools")."</span>";
				print "<div class='chronoLists' style='height:".$vn_col_height."px;'><div><ul>";
				while($q_styles_schools->nextHit()){
					$vn_item_id = $q_styles_schools->get("item_id");
					print "<li>";
					if (!in_array($vn_item_id, $va_list_items_with_objects)) {
						print join(", ", $q_styles_schools->getDisplayLabels());
					} else {
						//print "<a href='#' onclick='jQuery(\"#chron_thumb\").load(\"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'item_id' => $vn_item_id))."\"); return false;'>".join(", ", $q_styles_schools->getDisplayLabels())."</a>";
						print "<a href='#' onclick='jQuery(\"#chron_thumbScroll\").smoothDivScroll(\"getAjaxContent\", \"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'item_id' => $vn_item_id))."\",\"replace\"); return false;'>".join(", ", $q_styles_schools->getDisplayLabels())."</a>";
						
						#print join(", ", $q_styles_schools->getDisplayLabels());
					}
					print "</li>";
				}
				print "</ul></div></div>";
			}
			# --- list of all people from the period
			if($q_entities->numHits()){
				print "<div class='linedivide'></div><span class='listhead caps'>"._t("People")."</span>";
				print "<div class='chronoLists' style='height:".$vn_col_height."px;'><div><ul>";
				while($q_entities->nextHit()){
					$vn_entity_id = $q_entities->get('entity_id');
					print "<li>";
					if (!in_array($vn_entity_id, $va_entities_with_objects)) {
						print join(", ", $q_entities->getDisplayLabels());
					} else {
						//print "<a href='#' onclick='jQuery(\"#chron_thumb\").load(\"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'entity_id' => $vn_entity_id))."\", function() { $(\"div#chron_thumbScroll\").smoothDivScroll({ visibleHotSpotBackgrounds: \"always\" }); }); return false;'>".join(", ", $q_entities->getDisplayLabels())."</a>";
						
						print "<a href='#' onclick='jQuery(\"#chron_thumbScroll\").smoothDivScroll(\"getAjaxContent\", \"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'entity_id' => $vn_entity_id))."\",\"replace\"); return false;'>".join(", ", $q_entities->getDisplayLabels())."</a>";
						
						
						#print "<a href='#' onclick='jQuery(\"#chron_thumb\").load(\"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'entity_id' => $q_entities->get("entity_id")))."\", function() { $(\"div.chron_thumbScroll".$q_entities->get("entity_id")."\").smoothDivScroll({ visibleHotSpotBackgrounds: \"always\" }); alert(\"what?\"); }); return false;'>".join(", ", $q_entities->getDisplayLabels())."</a>";
						#print "<a href='#' onclick='jQuery(\"#chron_thumb\").load(\"".caNavUrl($this->request, 'eastend', 'Chronology', 'RefineSearch', array('period' => $pn_period, 'entity_id' => $q_entities->get("entity_id")))."\"); return false;'>".join(", ", $q_entities->getDisplayLabels())."</a>";						
					}
					print "</li>";
				}
				print "</ul></div></div>";
			}
?>
		</div><!--end chron_info-->
	</div><!--end chron_content-->	
	<script type="text/javascript">
		// Initialize the plugin
		$(document).ready(function () {
			$("div.chronoLists").smoothDivScroll({
				visibleHotSpotBackgrounds: "always",
				hotSpotScrollingInterval: 45
			});
		});
	</script>
	
	
	
	
	
	
	
	
