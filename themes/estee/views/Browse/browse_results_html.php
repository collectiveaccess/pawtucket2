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
	$va_sort_directions = $va_browse_info["sortDirection"];
	$va_all_facets = $va_browse_type_info["facets"];	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
	$vb_show_filter_panel = $this->request->getParameter("showFilterPanel", pInteger);
	$vb_show_chronology_filters = $this->request->getParameter("showChronologyFilters", pInteger);

	if ($vb_show_filter_panel && $vn_start == 0) {
		$o_context = new ResultContext($this->request, "ca_objects", 'detailrelated');
		
		$o_context->setResultList($qr_res->getPrimaryKeyValues(1000));
		#$o_context->setResultList(array_merge($o_context->getResultList(), $qr_res->getPrimaryKeyValues(1000)));
		$o_context->setParameter('key', $vs_browse_key);
		$qr_res->seek($vn_start);
		$o_context->saveContext();
	}
	
if ($vb_show_filter_panel || !$vb_ajax) {	// !ajax
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
							print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					print "</ul></H5>\n";
				}
			}
?>
		<H1 <?php print (($vb_show_filter_panel) ? "class='catchLinks'" : ""); ?>>
<?php
			print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("Result") : _t("Results"));	
?>		
			<div class="btn-group">
				<a href="#" data-toggle="dropdown"><i class="material-icons">settings</i></a>
				<ul class="dropdown-menu <?php print ($vb_show_filter_panel) ? "catchLinks" : ""; ?>" role="menu">
<?php
					if(($vs_table == "ca_objects") && $vn_result_size && (is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info))){
						print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("noRefresh" => 1, "saveLastResults" => 1))."\"); return false;'>"._t("Add all results to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
						print "<li><a href='#' onclick='jQuery(\".bSetsSelectMultiple\").toggle(); return false;'>"._t("Select results to add to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
						print "<li class='divider'></li>";
					}
					if($vs_sort_control_type == 'dropdown'){
						if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
							print "<li class='dropdown-header'>"._t("Sort by:")."</li>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li><a href='#'><em>{$vs_sort}</em></a></li>\n";
								} else {
									print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, 'direction' => $va_sort_directions[$vs_sort], '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
								}
							}
							print "<li class='divider'></li>\n";
							print "<li class='dropdown-header'>"._t("Sort order:")."</li>\n";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
						}
						
						if ((sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) && is_array($va_sorts) && sizeof($va_sorts)) {
?>
						<li class="divider"></li>
<?php
						}
					}
					if (sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) {
						print "<li>".caNavLink($this->request, _t("Start Over"), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					}
					if(is_array($va_export_formats) && sizeof($va_export_formats)){
						// Export as PDF links
						print "<li class='divider'></li>\n";
						print "<li class='dropdown-header'>"._t("Download results as:")."</li>\n";
						foreach($va_export_formats as $va_export_format){
							print "<li class='".$va_export_format["code"]."'>".caNavLink($this->request, $va_export_format["name"], "dontCatch", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
						}
					}
?>
				</ul>
			</div><!-- end btn-group -->
<?php
			if(is_array($va_facets) && sizeof($va_facets)){
?>
			<a href='#' id='bRefineButton' onclick='jQuery("#bRefine").toggle(); return false;'><i class="fa fa-table"></i></a>
<?php
			}
			if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
				print "<a href='#' class='bSetsSelectMultiple' id='bSetsSelectMultipleButton' onclick='jQuery(\"#setsSelectMultiple\").submit(); return false;'><button type='button' class='btn btn-default btn-sm'>"._t("Add selected results to %1", $va_add_to_set_link_info['name_singular'])."</button></a>";
			}
			print caNavLink($this->request, '<span class="glyphicon glyphicon-eye-open"></span> &nbsp;View all available digital assets', '', '*', '*','*', array('key' => $vs_browse_key, 'facet' => 'has_media_facet', 'id' => 1, 'view' => $vs_current_view), array("id" => "showMediaEye"));

?>
			
		</H1>
		<H5 <?php print ($vb_show_filter_panel) ? "class=' catchLinks'" : ""; ?>>
<?php
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			foreach($va_criteria as $va_criterion) {
					if($va_criterion["facet_name"] == "has_media_facet"){
?>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#showMediaEye").hide();
							});
						</script>
<?php
					}
					if(!$vb_show_filter_panel){
						$vs_display_value = $va_criterion['value'];
						if(strpos($va_criterion["value"], "ca_object_representations.representation_id:*") !== false){
							$vs_display_value = "Digital archival media";
?>
							<script type="text/javascript">
								jQuery(document).ready(function() {
									jQuery("#showMediaEye").hide();
								});
							</script>
<?php
						}
						print "<strong>".$va_criterion['facet'].': </strong>';
						print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$vs_display_value.' <i class="material-icons inline">close</i></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key));
					}else{
						if(strpos($va_criterion["value"], "collection_id") === false && strpos(strToLower($va_criterion["facet"]), "brand") === false){
							print "<strong>".$va_criterion['facet'].': </strong>';
							print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <i class="material-icons inline">close</i></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key));
						}
					}
				$i++;
				if($i < sizeof($va_criteria)){
					print " ";
				}
				$va_current_facet = $va_all_facets[$va_criterion['facet_name']];
				if((sizeof($va_criteria) == 1) && !$vb_is_search && $va_current_facet["show_description_when_first_facet"] && ($va_current_facet["type"] == "authority")){
					$t_authority_table = new $va_current_facet["table"];
					$t_authority_table->load($va_criterion['id']);
					$vs_facet_description = $t_authority_table->get($va_current_facet["show_description_when_first_facet"]);
				}
			}
		}
?>		
		</H5>
<?php
		if($vs_facet_description){
			print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
		}

		if($vb_showLetterBar){
			print "<div id='bLetterBar'>";
			foreach(array_keys($va_letter_bar) as $vs_l){
				if(trim($vs_l)){
					print caNavLink($this->request, $vs_l, ($vs_letter == $vs_l) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => $vs_l))." ";
				}
			}
			print " | ".caNavLink($this->request, _t("All"), (!$vs_letter) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => 'all')); 
			print "</div>";
		}
?>
		<form id="setsSelectMultiple">
		<div class="row">
			<div id="browseResultsContainer">
<?php
		if($vb_is_search && !$vn_result_size && $vs_search){
			# --- try to display did you mean results if available
			$o_search = caGetSearchInstance($vs_table);
			if (sizeof($va_suggestions = $o_search->suggest($vs_search, array('request' => $this->request)))) {
				$va_suggest_links = array();
				foreach($va_suggestions as $vs_suggestion){
					$va_suggest_links[] = caNavLink($this->request, $vs_suggestion, '', '*', '*', '*', array('search' => $vs_suggestion, 'sort' => $vs_current_sort, 'view' => $vs_current_view));
				}
				
				if (sizeof($va_suggest_links) > 1) {
					print "<div class='col-sm-12'>"._t("Did you mean one of these: %1?", join(', ', $va_suggest_links))."</div>";
				} else {
					print "<div class='col-sm-12'>"._t("Did you mean %1?", join(', ', $va_suggest_links))."</div>";
				}
			}
		}
}
if($vb_ajax && $vb_show_chronology_filters){	
	# --- merge applied and available chronology type facets to display as buttons at top of chronology browse embedded in collection detail page
	$va_chrono_types_process = array();
	$t_list = new ca_lists();
	$va_chronology_types = $t_list->getItemsForList("chronology_types");
	if(is_array($va_chronology_types) && sizeof($va_chronology_types)){
		foreach($va_chronology_types as $va_chrono_type){
			$va_chrono_type = array_pop($va_chrono_type);
			$va_chrono_types_process[$va_chrono_type["name_singular"]] = array("id" => $va_chrono_type["item_id"], "label" => $va_chrono_type["name_singular"], "selected" => "");
		}
	}
	$va_search_within_terms = array();
	$vb_chrono_filtered = false;
	$vn_collection_id = $vs_collection = "";
	if (sizeof($va_criteria) > 0) {
		foreach($va_criteria as $va_criterion) {
			switch($va_criterion["facet_name"]){
				case "chronology_type_facet":
					$va_chrono_types_process[$va_criterion['value']]["selected"] = 1;
					$vb_chrono_filtered = true;
				break;
				# ------------------------------
				case "_search":
					$va_search_within_terms[] = $va_criterion['value'];
				break;
				# ------------------------------
				case "collection_facet":
					$vn_collection_id = $va_criterion['id'];
					$vs_collection = $va_criterion['value'];
					# --- get available factes for the entire collection's chrono events
					if(sizeof($va_criteria) == 1){
						ExternalCache::save("facets_for_collection_chron".$vn_collection_id, $va_facets, 'facets_for_collection_chron', $o_config->get("cache_timeout"));
						$va_facets_for_collection_chron = $va_facets;
					}else{
						$va_facets_for_collection_chron =  ExternalCache::fetch("facets_for_collection_chron".$vn_collection_id, 'facets_for_collection_chron');
					}
				break;
				# ------------------------------
			}
		}
	}
	ksort($va_chrono_types_process);
?>
	<div class="bChronologyHeading">
		<div class="row">
			<div class="col-lg-9">
				<div class='filterChronologyButtons'><H4>Filter By: </H4><br/>
<?php
					foreach($va_chrono_types_process as $va_chrono_type){
						if($va_chrono_type["selected"]){
							print "<a href='#' class='selected btn btn-default' onClick='removeFacet(".$va_chrono_type["id"]."); return false;'>".$va_chrono_type["label"]."</a>";
						}else{	
							# --- only display the chronology types that are available or have already been applied
							if(is_array($va_facets_for_collection_chron) && $va_facets_for_collection_chron["chronology_type_facet"] && $va_facets_for_collection_chron["chronology_type_facet"]["content"][$va_chrono_type["id"]]){
								print "<a href='#' class='btn btn-default outline' onClick='applyFacet(".$va_chrono_type["id"]."); return false;'>".$va_chrono_type["label"]."</a>";
							}
						}
					}
					print "<a href='#' class='btn btn-default".(($vb_chrono_filtered) ? " outline" : "")."' onClick='jQuery(\"#browseCollectionContainer\").load(\"".caNavUrl($this->request, '', 'Browse', 'chronology', array('showChronologyFilters' => 1, 'facet' => 'collection_facet', 'id' => $vn_collection_id))."\"); return false;'>All</a>";
				
?>
					<div style="clear:both;"></div>
				</div><!-- end filterChronologyButtons -->
			</div>
			<div class="col-lg-3 bChronoSearchWithin">
				<div class="bSearchWithinContainer">
					<form role="search" id="searchWithinChrono" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
						<input type="text" class="form-control" placeholder="Search within..." name="search_refine" id="searchWithinSearchRefineChrono"><button type="submit" class="btn-search-refine"><i class="material-icons">search</i></button>
						<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
						<input type="hidden" name="view" value="<?php print $vs_current_view; ?>">
					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-9 bChronoSearchCriteria">
<?php
				if(sizeof($va_search_within_terms)){
					print "<H5>Search:";
					foreach($va_search_within_terms as $vs_search_term){
						print " <a href='#' class='browseRemoveFacet' onClick='jQuery(\"#browseCollectionContainer\").load(\"".caNavUrl($this->request, '', 'Browse', 'chronology', array('showChronologyFilters' => 1, 'key' => $vs_browse_key, 'removeCriterion' => '_search', 'removeID' => $vs_search_term))."\"); return false;'><button type='button' class='btn btn-default btn-sm'>".$vs_search_term." <i class='material-icons inline'>close</i></button></a>";
					}
					print "</H5>";
				}
?>
			</div>
			<div class="col-lg-3 bChronoDownloadCol">
				<div class="btn-group" id="bChronoDownloadDD">
					<a href="#" data-toggle="dropdown" class="bChronoDownloadDDLink"><i class="material-icons inline">save_alt</i> Download</i></a>
					<ul class="dropdown-menu" role="menu">
<?php
						print "<li>".caNavLink($this->request, "PDF", "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => "_pdf_chronology", "key" => $vs_browse_key, "brand" => $vs_collection))."</li>";
						print "<li>".caNavLink($this->request, "Excel", "", "*", "*", "*", array("view" => "xlsx", "download" => true, "export_format" => "chronology_excel", "key" => $vs_browse_key))."</li>";

?>		
					</ul>
					&nbsp;&nbsp;&nbsp;<a href="#" class="bChronoDownloadDDLink" onClick="changeSort(); return false;"><i class="material-icons inline"><?php print ($vs_sort_dir == 'asc') ? 'expand_less' : 'expand_more'; ?></i> Sort</i></a>
					
				</div>
			</div>
		</div>
	</div>
	
	<script type='text/javascript'>
		function applyFacet(id){
			jQuery("#browseCollectionContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'chronology', array('showChronologyFilters' => 1, 'key' => $vs_browse_key, 'facet' => 'chronology_type_facet')); ?>/id/" + id);
		}
		function removeFacet(id){
			jQuery("#browseCollectionContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'chronology', array('showChronologyFilters' => 1, 'key' => $vs_browse_key, 'removeCriterion' => 'chronology_type_facet')); ?>/removeID/" + id);
		}
		function changeSort(){
			jQuery("#browseCollectionContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'chronology', array('showChronologyFilters' => 1, 'key' => $vs_browse_key, 'direction' => ($vs_sort_dir == 'asc') ? 'desc' : 'asc')); ?>");
		}
		$("#searchWithinChrono").submit(function( event ) {
			event.preventDefault();
			var url = $("#searchWithinChrono").attr('action') + "/showChronologyFilters/1/key/<?php print $vs_browse_key; ?>/view/<?php print $vs_current_view; ?>/search_refine/" + encodeURIComponent($('#searchWithinSearchRefineChrono').val());
			$('#browseCollectionContainer').load(url);
		});
		jQuery(document).ready(function() {
			jQuery('#browseResultsCollectionContainer').jscroll({
				autoTrigger: true,
				loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
				padding: 800,
				nextSelector: 'a.jscroll-next'
			});
		});
		

	</script>
	<div id="browseResultsCollectionContainer">
<?php
}
# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id);
if(!$va_browse_info['noCache'] && ($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{
	$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
	print $vs_result_page;
}		
if($vb_show_chronology_filters){
?>
	</div>
<?php
}
if ($vb_show_filter_panel || !$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		</form>
	</div><!-- end col-8 -->
	<div class="col-sm-3 <?php print ($vb_show_filter_panel) ? "catchLinks" : ""; ?>">
		<div id="bViewButtons">
<?php
		if(!$vb_show_filter_panel){
			if(is_array($va_views) && (sizeof($va_views) > 1)){
				foreach($va_views as $vs_view => $va_view_info) {
					if ($vs_current_view === $vs_view) {
						print '<a href="#" class="active">'.$va_view_icons[$vs_view]['icon'].'</a> ';
					} else {
						print caNavLink($this->request, $va_view_icons[$vs_view]['icon'], 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
					}
				}
			}
		}
?>
		</div>
		<div class="bSearchWithinContainer">
			<form role="search" id="searchWithin" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
				<button type="submit" class="btn-search-refine"><i class="material-icons">search</i></button><input type="text" class="form-control bSearchWithin" placeholder="Search within..." name="search_refine" id="searchWithinSearchRefine">
				<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
				<input type="hidden" name="view" value="<?php print $vs_current_view; ?>">
			</form>
			<div style="clear:both"></div>
		</div>
<?php

		if(in_array(strToLower($this->request->getAction()), array("objects", "products"))){
			print "<div class='productCodeHelp'>End product code searches with an asterisk (*)</div>";
		}
		# --- objects, archival, products
		#$vs_browse_type = strToLower($this->request->getAction());
		#if(in_array($vs_browse_type, array("objects", "archival", "products"))){
			# --- if there is a brand filter, pass it through as you change type
		#	$vn_brand_facet_id = "";
		#	if (sizeof($va_criteria) > 0) {
		#		foreach($va_criteria as $va_criterion) {
		#			if($va_criterion["facet_name"] == "brand_facet"){
		#				$vn_brand_facet_id = $va_criterion["id"];
		#				break;
		#			}
		#		}
		#	}
		#	print "<div class='browseTypeButtons'>";
		#	print caNavLink($this->request, _t("Products"), "btn btn-default ".(($vs_browse_type == "products") ? "" : " outline"), "", "Browse", "products", array("facet" => "brand_facet", "id" => $vn_brand_facet_id));
		#	print caNavLink($this->request, _t("Items"), "btn btn-default ".(($vs_browse_type == "archival") ? "" : " outline"), "", "Browse", "archival", array("facet" => "brand_facet", "id" => $vn_brand_facet_id));
		#	print caNavLink($this->request, _t("All"), "btn btn-default browseTypeButtonAll ".(($vs_browse_type == "objects") ? "" : " outline"), "", "Browse", "objects", array("facet" => "brand_facet", "id" => $vn_brand_facet_id));
		#	print "<div style='clear:both;'></div></div>";
		#}
		#if(in_array(strToLower($this->request->getAction()), array("objects", "archival"))){
		#	print caNavLink($this->request, _t("Browse All Products"), "btn-default browseProducts", "", "Browse", "products");
		#}
?>
		
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
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
		jQuery('#setsSelectMultiple').submit(function(e){		
			objIDs = [];
			jQuery('#setsSelectMultiple input:checkbox:checked').each(function() {
			   objIDs.push($(this).val());
			});
			objIDsAsString = objIDs.join(';');
			caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveSelectedResults" => 1, "noRefresh" => 1)); ?>/object_ids/' + objIDsAsString);
			e.preventDefault();
			return false;
		});
<?php
		}
		if($vb_show_filter_panel){
?>			
			$(".catchLinks").on("click", "a", function(event){
				if(!$(this).hasClass('dontCatch') && $(this).attr('href') != "#"){
					event.preventDefault();
					var url = $(this).attr('href') + "/showFilterPanel/1/dontSetFind/1";
					$('#browseResultsDetailContainer').load(url);
				}
								
			});
			$("#searchWithin").submit(function( event ) {
  				event.preventDefault();
 				var url = $("#searchWithin").attr('action') + "/dontSetFind/1/showFilterPanel/1/key/<?php print $vs_browse_key; ?>/view/<?php print $vs_current_view; ?>/search_refine/" + encodeURIComponent($('#searchWithinSearchRefine').val());
 				$('#browseResultsDetailContainer').load(url);
			});
<?php
		}
?>
	});

</script>
<?php
		print $this->render('Browse/browse_panel_subview_html.php');
}
?>