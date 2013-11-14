<?php
	$t_set = new ca_sets();
	$va_write_sets = $this->getVar("write_sets");
	$va_read_sets = $this->getVar("read_sets");
	$va_access_values = $this->getVar("access_values");
	
	print "<H1>Lightboxes</H1>";
	print "<p>Write access sets:";
	#print_r($va_write_sets);
	foreach($va_write_sets as $vn_set_id => $va_set_info){
		$t_set->load($vn_set_id);
		$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $this->request->user->get("user_id"), "thumbnailVersions" => array("preview", "icon"), "checkAccess" => $va_access_values, "limit" => 4)));
		print "<div style='width:220px; height:275px; border:1px solid #666666; float:left; margin:5px;'>";
		if(sizeof($va_set_items)){
			$vn_i = 1;
			foreach($va_set_items as $va_set_item){
				if($vn_i == 1){
					print caNavLink($this->request, $va_set_item["representation_tag_preview"], "", "", "Sets", "setDetail", array("set_id" => $vn_set_id))."<br/>";
				}else{
					print $va_set_item["representation_tag_icon"];
				}
				$vn_i++;
			}
		}else{
			print "no items in set";
		}
		print "<div>".$t_set->get("ca_sets.preferred_labels.name")."</div>";
		print "<div>Owned by: ".trim($va_set_info["fname"]." ".$va_set_info["lname"])."</div>";
		print "<div>Num items: ".$t_set->getItemCount(array("user_id" => $this->request->user->get("user_id"), "checkAccess" => $va_access_values))."</div>";
		print "</div>";
	}
	print "<div style='clear:both;'><!-- empty --></div></p>";
	print "<p>Read access sets:<pre>";
	print_r($va_read_sets);
	print "</pre></p>";
?>