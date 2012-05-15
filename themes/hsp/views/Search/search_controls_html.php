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
			<a href='#' id='hideOptions' onclick='$("#searchOptionsBox").slideUp(250); $("#showOptions").slideDown(1); return false;'><?php print _t("Hide"); ?> &rsaquo;</a>
<?php
			print caFormTag($this->request, 'Index', 'caSearchOptionsForm', null, 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true)); 

			print "<div class='col'>";
			print "<div class='heading'>"._t("Display options:")."</div>";
			print "<div class='unit'>";
			print _t("Sort results by")."<br/><select name='sort' style='width:120px;'>\n";
		
			$vs_current_sort = $vo_result_context->getCurrentSort();
			$vs_current_sort_direction = $vo_result_context->getCurrentSortDirection();
			if(is_array($this->getVar("sorts")) && (sizeof($this->getVar("sorts")) > 0)){
				foreach($this->getVar("sorts") as $vs_sort => $vs_option){
					print "<option value='".$vs_sort."'".(($vs_current_sort == $vs_sort) ? " SELECTED" : "").">".$vs_option."</option>";
				}
			}
			print "</select>\n";
			print caHTMLSelect('direction', array(
				'↑' => 'asc',
				'↓' => 'desc'
			), array(), array('value' => $vs_current_sort_direction));
			
			print "</div><!-- end unit --><div class='unit'>";
			$va_items_per_page = $this->getVar("items_per_page");
			$vs_current_items_per_page = $vo_result_context->getItemsPerPage();
			print _t("Results per page")."<br/><select name='n'>\n";
			if(is_array($va_items_per_page) && sizeof($va_items_per_page) > 0){
				foreach($va_items_per_page as $vn_items_per_p){
					print "<option value='".$vn_items_per_p."' ".(($vn_items_per_p == $vs_current_items_per_page) ? "SELECTED='1'" : "").">".$vn_items_per_p."</option>\n";
				}
			}
			print "</select>\n";
			print "</div><!-- end unit -->";
	
			$va_search_history = $this->getVar('search_history');
			$vs_cur_search = $vo_result_context->getSearchExpression();
			if (is_array($va_search_history) && sizeof($va_search_history) > 0) {
				print "<div class='heading' style='clear:left;'>"._t("Search history:")."</div>";
				print "<div class='unit'>"._t("Your recent searches")."<br/>";
				print "<select name='search' style='width:244px;'>\n";
				foreach(array_reverse($va_search_history) as $vs_search => $va_search_info) {
					$SELECTED = ($vs_cur_search == $va_search_info['display']) ? 'SELECTED="1"' : '';
					$vs_display = strip_tags($va_search_info['display']);
					print "<option value='".htmlspecialchars($vs_search, ENT_QUOTES, 'UTF-8')."' {$SELECTED}>".$vs_display." (".$va_search_info['hits'].")</option>\n";
				}
				print "</select>\n";
				print "</div><!-- end unit -->";
			}
			print "</div><!-- end col -->";

			print "<div class='layout'>";
			$va_views = $this->getVar("views");
			$vs_current_view = $vo_result_context->getCurrentView();
			print "<div class='heading'>"._t("Layout options:")."</div>";
			if(is_array($va_views) && sizeof($va_views) > 0){
				foreach($va_views as $vs_view => $vs_name){
?>								
				<table cellpadding="2px" cellspacing="2px">
					<tbody><tr>
						<td align="left" valign="top"><input name="view" value="<?php print $vs_view; ?>" type="radio" <?php print (($vs_view == $vs_current_view) ? "checked" : ""); ?>></td>
						<td colspan="2" align="left" valign="top"><b><?php print $vs_name; ?></b></td>
					</tr>
					<tr>
						<td><!-- empty --></td>
						<td align="left" valign="top"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/<?php print $va_result_views_options[$vs_view]["icon"]; ?>"></td>
						<td align="left" valign="top"><?php print $va_result_views_options[$vs_view]["description"]; ?></td>
					</tr>
				</tbody></table>
<?php								
				}
			}
			print "</div>";		
			

			print "</form>\n";
	?>
			<div style='clear:both;height:1px;'>&nbsp;</div>
			<div class="apply">
				<a href="#" onclick="document.forms.caSearchOptionsForm.submit(); return false;"><?php print _t("Apply"); ?> &rsaquo;</a>
			</div>
		</div><!-- end bg -->
</div><!-- end searchOptionsBox -->