<?php
		$t_object = $this->getVar("object");
		print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>";

		$va_title_fields = array("mint", "authority", "denomination", "date");
		$va_title_parts = array();
		foreach($va_title_fields as $vs_title_field){
			if($vs_tmp = $t_object->get("ca_objects.".$vs_title_field)){
				$va_title_parts[] = $vs_tmp;
			}
		}
		print "<H4>".join(", ", $va_title_parts)."</H4>";
		
		$va_materiality_fields = array(
			"Weight" => "weight",
			"Material" => "material",
			"Diameter" => "diameter",
			"Measurements" => "measurements",
			"Axis" => "axis",
			"Object Attributes" => "object_attributes",
			"Original Intended Use" => "original_intended_use",
			"authenticity" => "Authenticity",
			"Post Manufacture Alterations" => "post_manufacture_alterations",
			"Materiality notes" => "materiality_notes",
		);
		print "<div class='unit'><H6>Identifier</H6>".$t_object->get("idno")."</div>";
		$vs_materiality = "";
		foreach($va_materiality_fields as $vs_label => $vs_field){
			if($vs_tmp = $t_object->get($vs_field, array("delimiter" => ", "))){
				$vs_materiality .= "<div class='unit'><H6>".$vs_label."</H6>".$vs_tmp."</div>";
			}
		}
		$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("obverse_countermark")));
		if(is_array($va_list_items) && sizeof($va_list_items)){
			$va_terms = array();
			foreach($va_list_items as $va_list_item){
				$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "coins", array("facet" => "icon_facet", "id" => $va_list_item["item_id"]));
			}
			$vs_materiality .= "<div class='unit'><H6>Countermarks</H6>".join($va_terms, ", ")."</div>";	
		}
		if($vs_materiality){
			print $vs_materiality;
		}

		print "<br/><br/>".caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id"));
		
?>