<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2026 Whirl-i-Gig
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
$facets 		= $this->getVar('facets');				// array of available browse facets
$criteria_list 	= $this->getVar('criteria');			// array of browse criteria
$key 			= $this->getVar('key');					// cache key for current browse
$access_values 	= $this->getVar('access_values');		// list of access values for this user
$view			= $this->getVar('view');
$browse_type	= $this->getVar('browse_type');
$o_browse		= $this->getVar('browse');
$browse_key 	= $this->getVar('key');					// cache key for current browse
$current_view	= $this->getVar('view');
$qr_res 		= $this->getVar('result');				// browse results (subclass of SearchResult)

$facet_display_length_maximum = 12;
$criteria = "";
if (sizeof($criteria_list) > 0) {
	$i = 0;
	$start_over = false;
	foreach($criteria_list as $criterion) {
		$criteria .= caNavLink($this->request, $criterion['value'].' <i aria-hidden="true" class="bi bi-x-circle-fill ms-1"></i>', 'browseRemoveFacet btn btn-secondary btn-sm w-100 mb-2', '*', '*', '*', array('removeCriterion' => $criterion['facet_name'], 'removeID' => urlencode($criterion['id']), 'view' => $current_view, 'key' => $browse_key), array("aria-label" => _t("Remove filter: %1", $criterion['value'])));
		$start_over = true;
		$i++;
	}
	if($start_over){
		$criteria .= caNavLink($this->request, _t("Start Over"), 'browseRemoveFacet btn btn-secondary btn-sm w-100 mb-2', '', 'Browse', '*', array('view' => $current_view, 'key' => $browse_key, 'clear' => 1, '_advanced' => $is_advanced ? 1 : 0), array("role" => "button"));
	}
}

if((is_array($facets) && sizeof($facets)) || ($criteria) || ($qr_res->numHits() > 1)){
?>		
	<div id='bMorePanel' tabindex='-1' class='sticky-md-top w-100 z-3 bg-light vh-100 collapse'><!-- long lists of facets are loaded here --></div>
	<div id='bRefine' class='bg-light sticky-md-top vh-100 collapse overflow-y-auto'>
		<div class="text-end float-end d-md-none "><button class="btn btn-lg btn-light" type="button" aria-expanded="false" aria-controls="bRefine" aria-label="Close" data-bs-toggle="collapse" data-bs-target="#bRefine"><i class="bi bi-x-circle-fill"></i></button></div>
<?php
	if($qr_res->numHits() > 1){
?>
		<form role="search" id="searchWithin" class="pt-1 pt-md-0" action="<?= caNavUrl($this->request, '*', 'Search', '*'); ?>">
			<div class="input-group p-3">
				<label for="search-within" class="form-label visually-hidden">Search within</label>
				<input name="search_refine" id="search-within" type="text" class="bg-white form-control rounded-0  border-0" placeholder="<?= _t("Search within..."); ?>" aria-label="<?= _t("Search within"); ?>">
				<input type="hidden" name="key" value="<?= $browse_key; ?>">
				<button type="submit" class="btn rounded-0 bg-white" aria-label="search submit"><i class="bi bi-search"></i></button>
			</div>
		</form>
<?php
	}
	if((is_array($facets) && sizeof($facets)) || ($criteria)){
		print "<H2 class='fs-4 px-3 py-2'>"._t("Filter by")."</H2>";
		
		if($criteria){
			print "<div class='p-3'>".$criteria."</div>";
		}
		print '<div class="accordion accordion-flush" id="browseRefineFacets">';
		foreach($facets as $facet_name => $facet_info) {
			if (!is_array($facet_info['content']) || !sizeof($facet_info['content'])) { continue; }
			$more_link = "";
			print "<div class='accordion-item'>";
		
			if ((caGetOption('deferred_load', $facet_info, false) || ($facet_info["group_mode"] === 'hierarchical')) && ($o_browse->getFacet($facet_name))) {
				print "<div class='accordion-header' id='heading{$facet_name}'><button class='accordion-button collapsed fw-medium text-capitalize' type='button' data-bs-toggle='collapse' data-bs-target='#{$facet_name}' aria-expanded='false' aria-controls='{$facet_name}'>{$facet_info['label_singular']}</button></div>";		
?>
				<div id='<?= $facet_name; ?>' class='accordion-collapse collapse' aria-labelledby='heading<?= $facet_name; ?>' data-bs-parent='#browseRefineFacets'>
					<div class='accordion-body'>
						<div id='bHierarchyList_<?= $facet_name; ?>'><?= caBusyIndicatorIcon($this->request).' '._t('Loading...'); ?></div>
						<div hx-target="#bHierarchyList_<?= $facet_name; ?>" hx-trigger="load" hx-get="<?= caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', ['facet' => $facet_name, 'browseType' => $browse_type, 'key' => $key]); ?>"  ></div>
					</div>
				</div>
<?php
			} else {				
				print "<div class='accordion-header' id='heading{$facet_name}'><button class='accordion-button collapsed fw-medium text-capitalize ' type='button' data-bs-toggle='collapse' data-bs-target='#".$facet_name."' aria-expanded='false' aria-controls='".$facet_name."'>".$facet_info['label_singular']."</button></div>";

				print "<div id='".$facet_name."' class='accordion-collapse collapse' aria-labelledby='heading".$facet_name."' data-bs-parent='#browseRefineFacets'>
					<div class='accordion-body small'><ul class='list-group'>";
						$facet_size = sizeof($facet_info['content']);
						$c = 0;
						foreach($facet_info['content'] as $item) {
							$content_count = (isset($item['content_count']) && ($item['content_count'] > 0)) ? " (".$item['content_count'].")" : "";
							print "<li class='list-group-item border-0 bg-transparent px-0 py-1'>".caNavLink($this->request, $item['label'].$content_count, '', '*', '*','*', array('key' => $key, 'facet' => $facet_name, 'id' => $item['id'], 'view' => $view))."</li>";
							$c++;
					
							if(($c == $facet_display_length_maximum) && ($facet_size > $facet_display_length_maximum))  {
								$more_link = "<li class='list-group-item border-0 bg-transparent px-0 py-1'><button class='btn btn-sm btn-secondary' hx-on:click='htmx.toggleClass(htmx.find(\"#bRefine\"), \"d-none\")' hx-trigger='click' hx-target='#bMorePanel' hx-get='".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $facet_name, 'view' => $view, 'key' => $key))."' type='button' data-bs-toggle='collapse' data-bs-target='#bMorePanel' aria-controls='bMorePanel' role='button' onClick='document.getElementById(\"bMorePanel\").focus();'>"._t("and %1 more", $facet_size - $facet_display_length_maximum)."</button></li>";
								break;
							}
						}

				print "</ul>".$more_link."</div></div>";
			}
			print "</div><!-- end accordion-item -->";
		}
		print "</div><!-- end accordian browseRefineFacets -->";
	}
	print "</div><!-- end bRefine -->\n";	
}
