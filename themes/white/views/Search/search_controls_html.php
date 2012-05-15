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
?>
<div id="searchOptionsBox">
		<div class="bg">
	<?php
			print caFormTag($this->request, 'Index', 'caSearchOptionsForm'); 
			
			print "<div class='col'>";
			print _t("Sort by:")." <select name='sort' onchange='this.form.submit();'>\n";
			
			$vs_current_sort = $vo_result_context->getCurrentSort();
			if(is_array($this->getVar("sorts")) && (sizeof($this->getVar("sorts")) > 0)){
				foreach($this->getVar("sorts") as $vs_sort => $vs_option){
					print "<option value='".$vs_sort."'".(($vs_current_sort == $vs_sort) ? " SELECTED" : "").">".$vs_option."</option>";
				}
			}
			print "</select>\n";
			print "</div>";
			
			print "<div class='col'>";
			$va_items_per_page = $this->getVar("items_per_page");
			$vs_current_items_per_page = $vo_result_context->getItemsPerPage();
			print _t("Results per page:")." <select name='n' onchange='this.form.submit();'>\n";
			if(is_array($va_items_per_page) && sizeof($va_items_per_page) > 0){
				foreach($va_items_per_page as $vn_items_per_p){
					print "<option value='".$vn_items_per_p."' ".(($vn_items_per_p == $vs_current_items_per_page) ? "SELECTED='1'" : "").">".$vn_items_per_p."</option>\n";
				}
			}
			print "</select>\n";
			print "</div>";

			print "<div class='col'>";
			$va_views = $this->getVar("views");
			$vs_current_view = $vo_result_context->getCurrentView();
			print _t("Layout:")." <select name='view' onchange='this.form.submit();'>\n";
			if(is_array($va_views) && sizeof($va_views) > 0){
				foreach($va_views as $vs_view => $vs_name){
					print "<option value='".$vs_view."' ".(($vs_view == $vs_current_view) ? "SELECTED='1'" : "").">".$vs_name."</option>\n";
				}
			}
			print "</select>\n";
			print "</div>";
	
	
			

			print "</form>\n";
	?>
			<a href='#' id='hideOptions' onclick='jQuery("#searchOptionsBox").slideUp(250); jQuery("#showOptions").slideDown(1); return false;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
			<div style='clear:both;height:1px;'>&nbsp;</div>
		</div><!-- end bg -->
</div><!-- end searchOptionsBox -->
<a href='#' id='showOptions' onclick='jQuery("#searchOptionsBox").slideDown(250); jQuery("#showOptions").slideUp(1);  jQuery("#searchRefineBox").slideUp(250); jQuery("#showRefine").slideDown(1); return false;'><?php print _t("Options"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>