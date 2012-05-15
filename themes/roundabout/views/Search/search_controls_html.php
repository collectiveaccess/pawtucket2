<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Search/search_controls_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
	$vo_result_context 		= $this->getVar('result_context');
	$va_result_views_options = $this->getVar('result_views_options');
	if(!$va_result_views_options){
		$va_result_views_options = array();
	}
?>
<div id="searchOptionsBox">
		<div class="bg">
<?php
			print caFormTag($this->request, 'Index', 'caSearchOptionsForm', null, 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true)); 

			//print "<div class='col'>";
			print "<div class='unit'>";
				print "<span>"._t("Sort")."</span>";
				print "<select name='sort' style='width:120px;'>\n";
				$vs_current_sort = $vo_result_context->getCurrentSort();
				$vs_current_sort_direction = $vo_result_context->getCurrentSortDirection();
				if(is_array($this->getVar("sorts")) && (sizeof($this->getVar("sorts")) > 0)){
					foreach($this->getVar("sorts") as $vs_sort => $vs_option){
						print "<option value='".$vs_sort."'".(($vs_current_sort == $vs_sort) ? " SELECTED" : "").">".$vs_option."</option>";
					}
				}
				print "</select>\n";
			
				print caHTMLSelect('direction', array(
					'Ascending' => 'asc',
					'Descending' => 'desc'
				), array(), array('value' => $vs_current_sort_direction));
			
				$va_items_per_page = $this->getVar("items_per_page");
				$vs_current_items_per_page = $vo_result_context->getItemsPerPage();
			
				print "&nbsp; &nbsp;<span>"._t("Results per page")."</span>";
			
				print "<select name='n'>\n";
				if(is_array($va_items_per_page) && sizeof($va_items_per_page) > 0){
					foreach($va_items_per_page as $vn_items_per_p){
						print "<option value='".$vn_items_per_p."' ".(($vn_items_per_p == $vs_current_items_per_page) ? "SELECTED='1'" : "").">".$vn_items_per_p."</option>\n";
					}
				}
				print "</select>\n";
			
				$va_views = $this->getVar("views");
				$vs_current_view = $vo_result_context->getCurrentView();
				if(is_array($va_views) && sizeof($va_views) > 0){
					print "&nbsp; &nbsp;<span>"._t("Layout")."</span>";
					print "<select name='view'>";
					foreach($va_views as $vs_view => $vs_name){
						print "<option value='".$vs_view."' ".(($vs_view == $vs_current_view) ? "SELECTED='1'" : "").">".$vs_name."</option>\n";						
					}
					print "</select>";
				}
			
			print "</div><!-- end unit -->";
			//print '<div class="clearfix"></div>';
?>
			<a href="#" class="apply-search-btn block-btn" onclick="document.forms.caSearchOptionsForm.submit(); return false;"><?php print _t("Apply"); ?></a>
<?php
			$va_search_history = $this->getVar('search_history');
			$vs_cur_search = $vo_result_context->getSearchExpression();
			if (is_array($va_search_history) && sizeof($va_search_history) > 0) {
				print "<div class='unit'><span>"._t("Your recent searches")."</span>";
				print "<select name='search' style='width:244px;'>\n";
				foreach(array_reverse($va_search_history) as $vs_search => $va_search_info) {
					$SELECTED = ($vs_cur_search == $va_search_info['display']) ? 'SELECTED="1"' : '';
					$vs_display = strip_tags($va_search_info['display']);
					$vs_display = substr($vs_display, strrpos($vs_display, ':'));
					print "<option value='".htmlspecialchars($vs_search, ENT_QUOTES, 'UTF-8')."' {$SELECTED}>".$vs_display." (".$va_search_info['hits'].")</option>\n";
				}
				print "</select>\n";
				print "</div><!-- end unit -->";
			}
			//print '<div class="clearfix"></div>';
			
			//print "</div><!-- end col -->";

			print "</form>\n";
	?>
			<div class="clearfix"></div>
		</div><!-- end bg -->
</div><!-- end searchOptionsBox -->





