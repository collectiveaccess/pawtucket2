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
	$o_config = $this->getVar("config");
	$va_export_formats = $this->getVar('export_formats');
	$va_browse_type_info = $o_config->get($va_browse_info["table"]);
	$va_all_facets = $va_browse_type_info["facets"];	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
if (!$vb_ajax) {	// !ajax

	$vs_page_title = "";
	$vs_criteria = "";
	if (sizeof($va_criteria) > 0) {
		$vb_start_over = false;
		foreach($va_criteria as $va_criterion) {
			$va_current_facet = $va_all_facets[$va_criterion['facet_name']];
			if((sizeof($va_criteria) == 1) && !$vb_is_search && $va_current_facet["show_description_when_first_facet"] && ($va_current_facet["type"] == "authority")){
				$t_authority_table = new $va_current_facet["table"];
				$t_authority_table->load($va_criterion['id']);
				$vs_facet_description = $t_authority_table->get($va_current_facet["show_description_when_first_facet"]);
				$vs_page_title = $va_criterion['value'];
			}else{
				if($va_criterion["facet_name"] == "_search"){
					$facet_name = "Search";
				}else{
					$facet_name = $va_criterion["facet"];
				}
				$vs_criteria .= "<span class='text-capitalize fs-5'>".$facet_name.":</span> ".caNavLink($this->request, $va_criterion['value'].' <i class="bi bi-x-circle-fill ms-1"></i>', 'browseRemoveFacet btn btn-secondary btn-sm me-4', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key), array("aria-label" => _t("Remove filter: %1", $va_criterion['value'])));
				$vb_start_over = true;
			}
		}
		
	}
?>

<div class="row" style="clear:both;">
	<div class='col-sm-12 col-md-8 col-lg-9 col-xl-9'>
<?php
		if($vs_page_title){
?>
			<H1 class="text-capitalize display-3 mb-3 pb-2 fw-bold" aria-live="polite">
<?php
			print _t("%1 <span class='fw-normal fs-3'>(%2)</span>", $vs_page_title, $vn_result_size);	
?>		
			</H1>
<?php
		}else{
?>
			<H1 class="text-capitalize fs-2 mb-5 pb-2">
<?php
				if(!$vs_page_title){
					$vs_page_title = (($va_browse_info["labelPlural"]) ? $va_browse_info["labelPlural"] : $t_instance->getProperty('NAME_PLURAL'));
				}
				print _t("%1 <span class='fw-normal'>(%2)</span>", (($va_browse_info["labelPlural"]) ? $va_browse_info["labelPlural"] : $t_instance->getProperty('NAME_PLURAL')), $vn_result_size);	
?>		
			</H1>
<?php
		}
?>	
	</div>
	<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
		<ul class="list-group list-group-horizontal justify-content-lg-end small">
			

<?php
		if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
			print "<li class='list-group-item border-0 px-0 pt-1'>\n";
			print "<ul class='list-inline p-0 me-2'><li class='list-inline-item fw-medium me-1'>"._t("Sort by")."</li>\n";
			$i = 0;
			foreach($va_sorts as $vs_sort => $vs_sort_flds) {
				$i++;
				if ($vs_current_sort === $vs_sort) {
					print "<li class='list-inline-item me-1 fw-semibold'>{$vs_sort}</li>\n";
				} else {
					print "<li class='list-inline-item me-1'>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
				}
				if($i < sizeof($va_sorts)){
					print "<li class='list-inline-item me-2'>/</li>";
				}
			}
			print "<li class='list-inline-item'>".caNavLink($this->request, '<i class="bi bi-arrow-down" aria-label="direction ascending"></i>', (($vs_sort_dir == 'asc') ? '' : 'text-secondary'), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
			print "<li class='list-inline-item'>".caNavLink($this->request, '<i class="bi bi-arrow-up" aria-label="direction descending"></i>', (($vs_sort_dir == 'desc') ? '' : 'text-secondary'), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
			print "</ul>\n";
			print "</li>\n";
		}

		if(is_array($va_views) && (sizeof($va_views) > 1)){
			print "<li class='list-group-item border-0 px-0 pt-0'>\n";
			print "<ul class='list-inline p-0 me-2'>\n";
			foreach($va_views as $vs_view => $va_view_info) {
				print "<li class='list-inline-item me-1'>";
				if ($vs_current_view === $vs_view) {
					print '<button class="btn btn-dark btn-sm disabled" aria-label="'.$vs_view.'"  title="'.$vs_view.'"><i class="bi '.$va_view_icons[$vs_view]['icon'].'"></i></button>';
				} else {
					print caNavLink($this->request, '<i class="bi '.$va_view_icons[$vs_view]['icon'].'"></i>', 'btn btn-light btn-sm', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key), array("title" => $vs_view, "aria-label" => $vs_view, "role" => "button"));
				}
				print "</li>\n";
			}
			print "</ul>\n";
			print "</li>\n";
		}

		if(is_array($va_all_facets) && sizeof($va_all_facets)){
?>
			<li class='list-group-item border-0 px-0 pt-0 d-md-none'><button class="btn btn-light btn-sm small ms-1" type="button" aria-expanded="false" aria-controls="bRefine" data-bs-toggle="collapse" data-bs-target="#bRefine" aria-label="<?php print _t("Filter Results"); ?>"><i class="bi bi-sliders"></i></button></li>
<?php
		}
?>
		</ul>
	</div>
<div>
<div class="row">
	<div class='col-sm-12 col-md-8 col-lg-9 col-xl-9'>
<?php

		if($vs_criteria){
			print "<div class='mt-md-n5 mb-3 pt-2'>".$vs_criteria."</div>";	
		}
				
		if($vs_facet_description){
			print "<div class='mb-3 fs-2'>".$vs_facet_description."</div>";
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
			<a href="#filters" id="skipBrowse" class="visually-hidden">Skip to Result Filters</a>
			<div id="browseResultsContainer">
				<div class="row">
<?php
} // !ajax

# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id.$vs_letter);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{
	$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
	print $vs_result_page;
}		

if (!$vb_ajax) {	// !ajax
?>
			
			</div><!-- end row -->
		</div><!-- end browseResultsContainer -->
	</div><!-- end col-8 -->
	
	<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3"><a name="filters"></a>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
	</div><!-- end col-2 -->
	
	
</div><!-- end row -->

<?php
} //!ajax
?>
