<?php
		$t_item = $this->getVar("item");
		$va_access_values = $this->getVar("access_values");
		$vs_table = $t_item->TableName();
		# --- themes and narrative threads
		$va_attributes = array("narrative_thread" => "narrative_threads_facet", "themes" => "theme_facet");
		$vs_themes = "";
		$t_list = new ca_lists();
		$t_list_item = new ca_list_items();
		foreach($va_attributes as $vs_attribute => $vs_facet){
			if($va_themes = $t_item->get($vs_table.".".$vs_attribute, array("returnAsArray" => true, "checkAccess" => $va_access_values))){
				foreach($va_themes as $vn_theme_id){
					#$vs_theme_name = $t_list->getItemFromListForDisplayByItemID($vs_attribute, $vn_theme_id);
					$t_list_item->load($vn_theme_id);
					#$vs_theme_name = $t_list_item->get("ca_list_item_labels.name_singular");
					$va_theme_hier = $t_list_item->get("ca_list_item_labels.hierarchy", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
					$va_theme_breadcrumb = array();
					if(is_array($va_theme_hier)){
						foreach($va_theme_hier as $va_theme){
							foreach($va_theme as $vn_hier_theme_id => $va_theme_info){
								$va_theme_info = array_pop($va_theme_info);
								$va_theme_breadcrumb[] = caNavLink($this->request, $va_theme_info["name_singular"], "", "", "browse", "objects", array("facet" => $vs_facet, "id" => $vn_hier_theme_id));
							}
						}
						$vs_themes .= "<div><i class='fa fa-angle-right' aria-hidden='true'></i> ".join(" > ", $va_theme_breadcrumb)." <span>(".str_replace("_", " ", $vs_attribute).")</span></div>";
					}
				}
			}
		}
		
		if($vs_themes){
?>							
			<div class="block">
				<h3>Themes</H3>
				<div class="blockContent trimTextSubjects">
<?php
						print $vs_themes; 
						
?>
				</div>
			</div>
<?php
		}

?>