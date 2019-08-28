<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
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

	$vn_result_size 	= (sizeof($va_criteria) > 0) ? $qr_res->numHits() : $this->getVar('totalRecordsAvailable');
	
	
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
	
if (!$vb_ajax) {	// !ajax
?>
<div class="row" style="clear:both;">
	<div class='<?php print ($vs_result_col_class) ? $vs_result_col_class : "col-sm-8 col-md-8 col-lg-8"; ?>'>
<?php 
			if($vs_sort_control_type == 'list'){
				if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
					print "<H5 id='bSortByList'><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='selectedSort'>{$vs_sort}</li>\n";
						} else {
							print "<li>".caNavLink($vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink('<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					print "</ul></H5>\n";
				}
			}
?>
		<H1 class="my-4">
<?php
			print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("Result") : _t("Results"));	
?>
		</H1>
			
			<div class="btn-group">
				<a type="button" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="cog"></ion-icon>
				</a>
				<div class="dropdown-menu">
<?php
					if(($vs_table == "ca_objects") && $vn_result_size && (is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info))){
						print "<div class='dropdown-item'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl('', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveLastResults" => 1))."\"); return false;'>"._t("Add all results to %1", $va_add_to_set_link_info['name_singular'])."</a></div>";
						print "<div class='dropdown-item'><a data-toggle='collapse' href='.bSetsSelectMultiple'>"._t("Select results to add to %1", $va_add_to_set_link_info['name_singular'])."</a></div>";
						print "<div class='dropdown-divider'></div>";
					}
					if($vs_sort_control_type == 'dropdown'){
						if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
							print "<div class='dropdown-header'>"._t("Sort by:")."</div>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<div class='dropdown-item'><a href='#'><em>{$vs_sort}</em></a></div>\n";
								} else {
									print "<div class='dropdown-item'>".caNavLink($vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</div>\n";
								}
							}
							print "<div class='dropdown-divider'></div>\n";
							print "<div class='dropdown-header'>"._t("Sort order:")."</div>\n";
							print "<div class='dropdown-item'>".caNavLink((($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc', '_advanced' => $vn_is_advanced ? 1 : 0))."</div>";
							print "<div class='dropdown-item'>".caNavLink((($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc', '_advanced' => $vn_is_advanced ? 1 : 0))."</div>";
						}
						
						if ((sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) && is_array($va_sorts) && sizeof($va_sorts)) {
?>
						<div class="dropdown-divider"></div>
<?php
						}
					}
					if (sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) {
						print "<div class='dropdown-item'>".caNavLink(_t("Start Over"), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1, '_advanced' => $vn_is_advanced ? 1 : 0))."</div>";
					}
					if(is_array($va_export_formats) && sizeof($va_export_formats)){
						// Export as PDF links
						print "<div class='dropdown-divider'></div>\n";
						print "<div class='dropdown-header'>"._t("Download results as:")."</div>\n";
						foreach($va_export_formats as $va_export_format){
							print "<div class='dropdown-item' class='".$va_export_format["code"]."'>".caNavLink($va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</div>";
						}
					}
?>
				</div>
			</div><!-- end btn-group -->
<?php
			if(is_array($va_facets) && sizeof($va_facets)){
?>
			<a href='#' id='bRefineButton' onclick='jQuery("#bRefine").toggle(); return false;'><i class="fa fa-table"></i></a>
<?php
			}
			if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
				print "<a href='#' class='bSetsSelectMultiple collapse float-right mt-4 d-block' id='bSetsSelectMultipleButton' onclick='jQuery(\"#setsSelectMultiple\").submit(); return false;'><button type='button' class='btn btn-primary btn-sm bSetsSelectMultiple collapse'>"._t("Add selected results to %1", $va_add_to_set_link_info['name_singular'])."</button></a>";
			}

		if (sizeof($va_criteria) == 1) {
			foreach($va_criteria as $va_criterion) {
				$va_current_facet = $va_all_facets[$va_criterion['facet_name']];
				if(!$vb_is_search && $va_current_facet["show_description_when_first_facet"] && ($va_current_facet["type"] == "authority")){
					$t_authority_table = new $va_current_facet["table"];
					$t_authority_table->load($va_criterion['id']);
					$vs_facet_description = $t_authority_table->get($va_current_facet["show_description_when_first_facet"]);
				}
			}
		}
?>		
		
<?php
		if($vs_facet_description){
			print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
		}

		if($vb_showLetterBar){
			print "<div id='bLetterBar'>";
			foreach(array_keys($va_letter_bar) as $vs_l){
				if(trim($vs_l)){
					print caNavLink($vs_l, ($vs_letter == $vs_l) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => $vs_l))." ";
				}
			}
			print " | ".caNavLink(_t("All"), (!$vs_letter) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => 'all')); 
			print "</div>";
		}
?>
		<form id="setsSelectMultiple">
		<div class="row"  id="browseResultsContainer">
<?php
		if($vb_is_search && !$vn_result_size && $vs_search){
			# --- try to display did you mean results if available
			$o_search = caGetSearchInstance($vs_table);
			if (sizeof($va_suggestions = $o_search->suggest($vs_search, array('request' => $this->request)))) {
				$va_suggest_links = array();
				foreach($va_suggestions as $vs_suggestion){
					$va_suggest_links[] = caNavLink($vs_suggestion, '', '*', '*', '*', array('search' => $vs_suggestion, 'sort' => $vs_current_sort, 'view' => $vs_current_view));
				}
				
				if (sizeof($va_suggest_links) > 1) {
					print "<div class='col-sm-12'>"._t("Did you mean one of these: %1?", join(', ', $va_suggest_links))."</div>";
				} else {
					print "<div class='col-sm-12'>"._t("Did you mean %1?", join(', ', $va_suggest_links))."</div>";
				}
			}
		}
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

if (!$vb_ajax) {	// !ajax
?>
		</div><!-- end row browseResultsContainer -->
		</form>
	</div><!-- end col-8 -->
	<div class="bRightCol <?php print ($vs_refine_col_class) ? $vs_refine_col_class : "col-md-4 col-lg-3 offset-lg-1"; ?>">
		<div class="position-fixed vh-100 mr-3"><!-- use class="sticky-top" when site header is not fixed - this makes the div stick to top of page when scroll past it :) -->
			<div id="bViewButtons" class="mb-3 mt-2 text-right">
<?php
			if(is_array($va_views) && (sizeof($va_views) > 1)){
				foreach($va_views as $vs_view => $va_view_info) {
					if ($vs_current_view === $vs_view) {
						print '<a href="#" class="active">'.$va_view_icons[$vs_view]['icon'].'</a> ';
					} else {
						print caNavLink($va_view_icons[$vs_view]['icon'], 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
					}
				}
			}
?>
			</div>
			<div class="bSearchWithinContainer mb-2">
				<form class="form-inline my-2 my-lg-0" role="search" id="searchWithin" action="<?php print caNavUrl('*', 'Search', '*'); ?>">
			  		<input type="text" class="form-control bSearchWithin" placeholder="<?php print _t("Search within results..."); ?>" name="search_refine" autocomplete="off" aria-label="Search">
			  		<button class="btn" type="submit"><i class="material-icons">search</i></button>
			  		<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
					<input type="hidden" name="view" value="<?php print $vs_current_view; ?>">
				</form>
				<div style="clear:both"></div>
			</div>

<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
			<div class="forceWidth">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
		</div>
	</div><!-- end col-2 -->
	
	
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
			caMediaPanel.showPanel('<?php print caNavUrl('', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveSelectedResults" => 1)); ?>/object_ids/' + objIDsAsString);
			e.preventDefault();
			return false;
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
