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
	$o_config = $this->getVar("config");
	$va_export_formats = $this->getVar('export_formats');
	$va_browse_type_info = $o_config->get($va_browse_info["table"]);
	$va_all_facets = $va_browse_type_info["facets"];	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
if (!$vb_ajax) {	// !ajax
?>

<div class="row" style="clear:both;">
	<div class='col-sm-12 <?php print (strToLower($this->request->getAction()) != "seasons") ? "col-md-8 col-lg-9 col-xl-8" : ""; ?>'>
		<div class="row">
			<div class="col-md-12 col-lg-5">
				<H1 class="text-capitalize fs-3">
<?php
					print _t('%1 %2', $vn_result_size, ($vn_result_size == 1) ? (($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_PLURAL')) : (($va_browse_info["labelPlural"]) ? $va_browse_info["labelPlural"] : $t_instance->getProperty('NAME_PLURAL')));	
?>		
				</H1>
			</div>
			<div class="col-md-12 col-lg-7 text-lg-end">
				<ul class="list-group list-group-horizontal justify-content-lg-end small">
 					

<?php
				if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
					print "<li class='list-group-item border-0 px-0 pt-1'>\n";
					print "<ul class='list-inline p-0 me-2'><li class='list-inline-item fw-medium text-uppercase me-1'>"._t("Sort by:")."</li>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='list-inline-item me-1'>{$vs_sort}</li>\n";
						} else {
							print "<li class='list-inline-item me-1'>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='list-inline-item me-2'>|</li>";
						}
					}
					print "<li class='list-inline-item'>".caNavLink($this->request, '<i class="bi bi-sort-down"'.(($vs_sort_dir == 'asc') ? '' : '-alt').' aria-label="direction"></i>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
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
							print caNavLink($this->request, '<i class="bi '.$va_view_icons[$vs_view]['icon'].'"></i>', 'btn btn-light btn-sm', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key), array("title" => $vs_view, "aria-label" => $vs_view));
						}
						print "</li>\n";
					}
					print "</ul>\n";
					print "</li>\n";
				}
				if(is_array($va_export_formats) && sizeof($va_export_formats)){
?>
					<li class='list-group-item border-0 px-0 pt-0'>
						<div class="dropdown inline w-auto">
							<button class="btn btn-light btn-sm dropdown-toggle small" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="<?php print _t("Export Results"); ?>">
								<i class="bi bi-download"></i>
							</button>
							<ul class="dropdown-menu" role='menu'>
<?php
							foreach($va_export_formats as $va_export_format){
								print "<li class='dropdown-item' role='menuitem'>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
							}
?>
							</ul>
						</div>
					</li>
<?php
				}

				if(is_array($va_all_facets) && sizeof($va_all_facets)){
?>
					<li class='list-group-item border-0 px-0 pt-0 d-md-none'><button class="btn btn-light btn-sm small ms-1" type="button" aria-expanded="false" aria-controls="bRefine" data-bs-toggle="collapse" data-bs-target="#bRefine" aria-label="<?php print _t("Filter Results"); ?>"><i class="bi bi-sliders"></i></button></li>
<?php
				}
?>
				</ul>
			</div>
		</div>
<?php				
		if($vs_facet_description){
			print "<div class='py-3'>".$vs_facet_description."</div>";
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
<?php
	if(strToLower($this->request->getAction()) != "seasons"){
?>	
	<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 offset-xl-1"><a name="filters"></a>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
	</div><!-- end col-2 -->
<?php
	}
?>	
	
</div><!-- end row -->

<?php
		print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>
