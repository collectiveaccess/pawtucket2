<div id="searchOptionsCol">
	<div class="title"><?php print _t("Search history"); ?></div>
	<div class="bg">
<?php
		$va_search_history = $this->getVar('search_history');
		$vs_cur_search = $this->getVar("last_search");
		if (is_array($va_search_history) && sizeof($va_search_history) > 0) {
			print caFormTag($this->request, 'Index', 'caSearchHistoryForm', 'Search'); 
			
			print "<select name='search' onchange='this.form.submit();'>\n";
			foreach(array_reverse($va_search_history) as $vs_search => $va_search_info) {
				$SELECTED = ($vs_cur_search == $va_search_info['display']) ? 'SELECTED="1"' : '';
				$vs_display = strip_tags($va_search_info['display']);
				if (unicode_strlen($vs_display) > 25) {
					$vs_display = unicode_substr($vs_display, 0, 22).'...';
				}
				print "<option value='".htmlspecialchars($vs_search, ENT_QUOTES, 'UTF-8')."' {$SELECTED}>".$vs_display." (".$va_search_info['hits'].")</option>\n";
			}
			print "</select>\n";
			print "</form>\n";
		}
?>			
	</div><!-- end bg -->
	<div class="title"><?php print _t("Search Options"); ?></div>
	<div class="bg">
<?php
		print caFormTag($this->request, 'Index', 'caSearchOptionsForm', 'search'); 
		
		print _t("Sort results by:")."<br/><select name='sort' onchange='this.form.submit();'>\n";
		if(is_array($this->getVar("sorts")) && (sizeof($this->getVar("sorts")) > 0)){
			foreach($this->getVar("sorts") as $vs_sort => $vs_option){
				print "<option value='".$vs_sort."'".(($this->getVar("current_sort") == $vs_sort) ? " SELECTED" : "").">".$vs_option."</option>";
			}
		}
		print "</select>\n";
		
		$va_items_per_page = $this->getVar("items_per_page");
		print "<br/><br/>"._t("Results per page:")."<br/><select name='n' onchange='this.form.submit();'>\n";
		if(is_array($va_items_per_page) && sizeof($va_items_per_page) > 0){
			foreach($va_items_per_page as $vn_items_per_p){
				print "<option value='".$vn_items_per_p."' ".(($vn_items_per_p == $this->getVar("current_items_per_page")) ? "SELECTED='1'" : "").">".$vn_items_per_p."</option>\n";
			}
		}
		print "</select>\n";
		
		$va_views = $this->getVar("views");
		print "<br/><br/>"._t("Results layout:")."<br/><select name='view' onchange='this.form.submit();'>\n";
		if(is_array($va_views) && sizeof($va_views) > 0){
			foreach($va_views as $vs_view => $vs_name){
				print "<option value='".$vs_view."' ".(($vs_view == $this->getVar("current_view")) ? "SELECTED='1'" : "").">".$vs_name."</option>\n";
			}
		}
		print "</select>\n";
		print "</form>\n";
?>
	</div><!-- end bg -->
</div><!-- end searchOptionsCol -->