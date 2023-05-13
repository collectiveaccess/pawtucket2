<?php
	/**
	 * Generate tag list for Metabolic front page
	 */
	function getTagsForFrontPage() {
		$o_db = new Db();
		$q_tags = $o_db->query("SELECT ixt.tag_id, count(ixt.tag_id) as tagCount, t.tag from ca_items_x_tags ixt INNER JOIN ca_item_tags as t on t.tag_id = ixt.tag_id GROUP BY ixt.tag_id ORDER BY tagCount DESC limit 20");
		if($q_tags->numRows()){
		
			$buf = '<div class="row bg-1 pt-4 mb-5 hpTags">';

			while($q_tags->nextRow()){
				$buf .= '<div class="col-sm-6 col-md-3 pb-4">';
				$buf .= caNavLink("<div class='bg-2 text-center py-2 uppercase'>".$q_tags->get("tag")."</div>", "", "", "MultiSearch", "Index", array("search" => "ca_item_tags.tag:'".$q_tags->get("tag")."'"));
				$buf .= "</div>\n";
			}

			$buf .=  "</div>\n";
		}
		return $buf;
	}
	
	/**
	 * Generate Galleries list for Metabolic front page
	 */
	function getGalleriesForFrontPage() {
		$va_access_values = caGetUserAccessValues();
		$o_front_config = caGetFrontConfig();
		$o_gallery_config = caGetGalleryConfig();
		
		if(!$vs_section_name = $o_gallery_config->get('gallery_section_name')){
			$vs_section_name = _t("Featured Galleries");
		}
		$t_list = new ca_lists();
		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type'));
		if($vn_gallery_set_type_id){
			$t_set = new ca_sets();
			$va_un_sorted_sets = caExtractValuesByUserLocale($t_set->getSets(array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
			if(is_array($va_un_sorted_sets) && sizeof($va_un_sorted_sets)){
				shuffle($va_un_sorted_sets);
				$va_sets = array();
				foreach($va_un_sorted_sets as $va_set){
					if($va_set["set_code"] != $o_front_config->get("front_page_set_code")){
						$va_sets[$va_set["set_id"]] = $va_set;
					}
				}
				$va_sets = array_slice($va_sets,0,8,true);
				$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
			}
		}	
		$buf = '';
		if(is_array($va_sets) && sizeof($va_sets)){		
		
			$sets = '';
			foreach($va_sets as $vn_set_id => $va_set){
				$sets .= "<div class='col-sm-6 col-md-3 pb-4 mb-4'>";
				$va_first_item = null;
				if($va_set_first_items[$vn_set_id]){
					$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
				}
				if ($va_first_item) {
					$sets .= caNavLink($va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
					$sets .= "<div class='pt-2'>".$va_set["name"]."</div><div>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</div>";
				}
				$sets .= "</div>";
			}
			$buf = "
				<div class=\"row mt-5\">
					<div class=\"col-md-6 mt-5\">
						<H1>{$vs_section_name}</H1>
					</div>
					<div class=\"col-md-6 mt-5 text-right\">".
					caNavLink(_t("View All"), "btn btn-sm btn-primary", "", "Gallery", "Index")."
					</div>
				</div>
				<div class=\"row mb-5\">
					<div class=\"col-lg-12\">
						<div class=\"row\">
							{$sets}
						</div>
					</div>
				</div>";
		}
		return $buf;
	}