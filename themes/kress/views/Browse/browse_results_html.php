<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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

	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_is_advanced		= (int)$this->getVar('is_advanced');
	$vb_showLetterBar	= (int)$this->getVar('showLetterBar');	
	$va_letter_bar		= $this->getVar('letterBar');	
	$vs_letter			= $this->getVar('letter');
	$vn_row_id 			= $this->request->getParameter('row_id', pInteger);
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	
	$vs_current_sort	= $this->getVar('sort');
	$vs_sort_dir		= $this->getVar('sort_direction');
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');

	$vn_result_size 	= $qr_res->numHits();
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
	$vb_ajax			= (bool)$this->request->isAjax();
	$va_browse_info = $this->getVar("browseInfo");
	$vs_sort_control_type = caGetOption('sortControlType', $va_browse_info, 'dropdown');
	$o_config = $this->getVar("config");
	$vs_result_col_class = $o_config->get('result_col_class');
	$vs_refine_col_class = $o_config->get('refine_col_class');
	$va_export_formats = $this->getVar('export_formats');
	$va_browse_type_info = $o_config->get($va_browse_info["table"]);
	$va_all_facets = $va_browse_type_info["facets"];	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
	$vn_acquisition_movement_id = (int)$this->request->getParameter("acquisition_movement_id", pInteger);
	$vb_show_filter_panel = $this->request->getParameter("showFilterPanel", pInteger);
	$vs_detail_type = $this->request->getParameter("detailType", pString);


	if ($vb_show_filter_panel && $vn_start == 0) {
		$o_context = new ResultContext($this->request, $vs_table, 'detailrelated', $vs_detail_type);
	
		$o_context->setResultList($qr_res->getPrimaryKeyValues(1000));
		$o_context->setParameter('key', $vs_browse_key);
		
		$qr_res->seek($vn_start);
		$o_context->saveContext();
	}
	
if ($vb_show_filter_panel || !$vb_ajax) {	// !ajax
?>
<div class="row" style="clear:both;">
<?php
	$vs_refine_subview = $this->render("Browse/browse_refine_subview_html.php");
	if($vs_refine_subview || ($vn_result_size > 1)){
?>
		<div class="col-sm-4 col-md-3 col-lg-3" id="browseLeftCol">
<?php		
		if($vn_result_size > 1){
?>
			<div <?php print ($vb_show_filter_panel) ? "class='catchLinks'" : ""; ?>>
				<div class="bSearchWithinContainer">
					<form role="search" id="searchWithin" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
						<button type="submit" class="btn-search-refine"><span class="glyphicon glyphicon-search" aria-label="submit search"></span></button><input type="text" class="form-control bSearchWithin" placeholder="Search within..." name="search_refine" id="searchWithinSearchRefine" aria-label="Search Within">
						<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
						<input type="hidden" name="view" value="<?php print $vs_current_view; ?>">
					</form>
					<div style="clear:both"></div>
				</div>
			</div>
<?php
		}
		if(($vs_table == "ca_objects") && !$vb_show_filter_panel){
			print "<div class='small advancedSearchLink'>".caNavLink($this->request, _t("Advanced Search"), '', 'Search', 'advanced', 'objects')."</div>";
		}
		print $vs_refine_subview;
?>			
		</div><!-- end col-2 -->
<?php
	}
?>
	<div class='col-sm-8 col-md-9 col-lg-9'>
<?php
			if(is_array($va_views) && (sizeof($va_views) > 1)){
				print '<div id="bViewButtons"'.(($vb_show_filter_panel) ? ' class="catchLinks"' : '').'>';
				foreach($va_views as $vs_view => $va_view_info) {
					if ($vs_current_view === $vs_view) {
						#print '<a href="#" class="active"><span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" title="Change view"></span></a> ';
					} else {
						print caNavLink($this->request, '<span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" title="Change view"></span>', '', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
					}
				}
				print "</div>";
			}
			
			if($vs_sort_control_type == 'list'){
				if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
					print "<div id='bSortByList'".(($vb_show_filter_panel) ? " class='catchLinks'" : "")."><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='selectedSort'>{$vs_sort}</li>\n";
						} else {
							print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'" aria-label="direction"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					print "</ul></div>\n";
				}
			}
?>		
			<div id="bExportMenu" class="btn-group">
				<a href="#" data-toggle="dropdown"><i class="fa fa-download bGear" aria-label="Download options" title="Download options"></i></a>
				<ul class="dropdown-menu" role="menu">
<?php
					if(($vs_table == "ca_objects") && $vn_result_size && (is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info))){
						print "<li role='menuitem'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveLastResults" => 1))."\"); return false;'>"._t("Add all results to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
						print "<li role='menuitem'><a href='#' onclick='jQuery(\".bSetsSelectMultiple\").toggle(); return false;'>"._t("Select results to add to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
						print "<li class='divider' role='menuitem'></li>";
					}
					if($vs_sort_control_type == 'dropdown'){
						if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
							print "<li class='dropdown-header' role='menuitem'>"._t("Sort by:")."</li>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li role='menuitem'><a href='#'><em>{$vs_sort}</em></a></li>\n";
								} else {
									print "<li role='menuitem' ".(($vb_show_filter_panel) ? " class='catchLinks'" : "").">".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
								}
							}
							print "<li class='divider' role='menuitem'></li>\n";
							print "<li class='dropdown-header' role='menuitem'>"._t("Sort order:")."</li>\n";
							print "<li role='menuitem'".(($vb_show_filter_panel) ? " class='catchLinks'" : "").">".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
							print "<li role='menuitem'".(($vb_show_filter_panel) ? " class='catchLinks'" : "").">".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
						}
					}
					if(is_array($va_export_formats) && sizeof($va_export_formats)){
						// Export as PDF links
						#print "<li class='divider' role='menuitem'></li>\n";
						print "<li class='dropdown-header' role='menuitem'>"._t("Download results as:")."</li>\n";
						# --- entity excel reports are specific to category
						if($vs_table == "ca_entities"){
							foreach($va_export_formats as $va_export_format){
								if(($va_export_format["type"] == "pdf") || ($va_export_format["code"] == $this->request->getAction()."_excel")){
									print "<li class='".$va_export_format["code"]."' role='menuitem'>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
								}
							}
						}else{
							foreach($va_export_formats as $va_export_format){
								if(!in_array($va_export_format["code"], array("_pdf_thumbnails"))){
									print "<li class='".$va_export_format["code"]."' role='menuitem'>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
								}
							}
						}
					}
?>
				</ul>
			</div><!-- end btn-group -->

		<H1>
<?php
			if ($vb_show_filter_panel){
				print _t('%1 %2 %3', $vn_result_size, " Related ", ($vn_result_size > 1) ? $va_browse_info["labelPlural"] : $va_browse_info["labelSingular"]);	
			}else{
				print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("Result") : _t("Results"));	
			}

			if((strToLower($this->request->getAction()) != "other_entities") && ((is_array($va_facets) && sizeof($va_facets)) || (sizeof($va_criteria)))){
?>
			<a href='#' id='bRefineButton' onclick='jQuery("#bRefine").toggle(); return false;'><i class="fa fa-table"></i></a>
<?php
			}
			if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
				print "<a href='#' class='bSetsSelectMultiple' id='bSetsSelectMultipleButton' onclick='jQuery(\"#setsSelectMultiple\").submit(); return false;'><button type='button' class='btn btn-default btn-sm'>"._t("Add selected results to %1", $va_add_to_set_link_info['name_singular'])."</button></a>";
			}
?>
		</H1>
<?php
		if($vb_showLetterBar){
			print "<div id='bLetterBar".($vb_show_filter_panel) ? " catchLinks" : ""."'>";
			foreach(array_keys($va_letter_bar) as $vs_l){
				if(trim($vs_l)){
					print caNavLink($this->request, $vs_l, ($vs_letter == $vs_l) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => $vs_l))." ";
				}
			}
			print " | ".caNavLink($this->request, _t("All"), (!$vs_letter) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => 'all')); 
			print "</div>";
		}
		if(!$vb_show_filter_panel){
			$vs_introduction = $this->getVar("browse_introduction_".$this->request->getAction());
			if($vs_introduction){
				print "<p class='bIntroduction'>".$vs_introduction."</p>";
			}
			if(($vs_current_view == "images") && (in_array($this->request->getAction(), array("objects", "archival", "acquisitions")))){
				$vs_compare_help_text = $this->getVar("compare_images_help");
				if($vs_compare_help_text){
					print "<i class='fa fa-clone' aria-hidden='true'></i> ".$vs_compare_help_text."</p>";
				}
			}
		}
?>
		<form id="setsSelectMultiple">
		<div class="row">
			<div id="browseResultsContainer">
<?php
} // !ajax

# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{
	$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
	print $vs_result_page;
}		

if ($vb_show_filter_panel || !$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		</form>
	</div><!-- end col-8 -->
</div><!-- end row -->

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 800,
			nextSelector: 'a.jscroll-next'
		});
<?php
		if($vn_row_id){
?>
			window.setTimeout(function() {
				$("window,body,html").scrollTop( $("#row<?php print $vn_row_id; ?>").offset().top);
			}, 0);
<?php
		}
		if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
?>
		jQuery('#setsSelectMultiple').on('submit', function(e){		
			objIDs = [];
			jQuery('#setsSelectMultiple input:checkbox:checked').each(function() {
			   objIDs.push($(this).val());
			});
			objIDsAsString = objIDs.join(';');
			caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveSelectedResults" => 1)); ?>/object_ids/' + objIDsAsString);
			e.preventDefault();
			return false;
		});
<?php
		}
		if($vb_show_filter_panel){
?>			
			$('.catchLinks a').bind('click', function(e) {           
  				if($(this).attr('href') != "#"){
					var url = $(this).attr('href') + "/dontSetFind/1/showFilterPanel/1<?php print ($vn_acquisition_movement_id) ? "/acquisition_movement_id/".$vn_acquisition_movement_id : ""; ?><?php print ($vs_detail_type) ? "/detailType/".$vs_detail_type : ""; ?> ";
					$('#browseResultsDetailContainer').load(url);
					e.preventDefault();
					return false;
				}
			});
			
			$("#searchWithin").submit(function( event ) {
  				event.preventDefault();
 				var url = $("#searchWithin").attr('action') + "/dontSetFind/1/showFilterPanel/1<?php print ($vn_acquisition_movement_id) ? "/acquisition_movement_id/".$vn_acquisition_movement_id : ""; ?><?php print ($vs_detail_type) ? "/detailType/".$vs_detail_type : ""; ?>/key/<?php print $vs_browse_key; ?>/view/<?php print $vs_current_view; ?>/search_refine/" + encodeURIComponent($('#searchWithinSearchRefine').val());
 				$('#browseResultsDetailContainer').load(url);
			});
<?php
		}
?>
	});

</script>
<?php
		print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>
