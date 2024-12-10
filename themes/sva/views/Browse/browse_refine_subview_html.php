<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2024 Whirl-i-Gig
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
$va_facets 			= $this->getVar('facets');				// array of available browse facets
$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
$vs_key 			= $this->getVar('key');					// cache key for current browse
$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
$vs_view			= $this->getVar('view');
$vs_browse_type		= $this->getVar('browse_type');
$o_browse			= $this->getVar('browse');
$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
$vs_current_view	= $this->getVar('view');
$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)

$vn_facet_display_length_maximum = 12;
$vs_criteria = "";
if (sizeof($va_criteria) > 0) {
	$vb_start_over = $vb_set = false;
	foreach($va_criteria as $va_criterion) {
		if(str_contains($va_criterion['value'], "ca_sets.set_id:")){
			$vb_set = true;
		}else{
			$vs_criteria .= caNavLink($this->request, $va_criterion['value'].' <i aria-hidden="true" class="bi bi-x-circle-fill ms-1"></i>', 'browseRemoveFacet btn btn-secondary btn-sm w-100 mb-2', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key), array("aria-label" => _t("Remove filter: %1", $va_criterion['value'])));
			$vb_start_over = true;
		}
	}
	if($vb_start_over && !$vb_set){
		$vs_criteria .= caNavLink($this->request, _t("Start Over"), 'browseRemoveFacet btn btn-secondary btn-sm w-100 mb-2', '', 'Browse', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1, '_advanced' => $vn_is_advanced ? 1 : 0), array("role" => "button"));
	}
}

if((is_array($va_facets) && sizeof($va_facets)) || ($vs_criteria) || ($qr_res->numHits() > 1)){
?>		
	<div id='bRefine' class='bg-light sticky-md-top vh-100 collapse overflow-y-auto'>
		<div id='bMorePanel' tabindex='-1' class='position-absolute w-100 z-3 bg-light h-100 collapse'><!-- long lists of facets are loaded here --></div>
		<div class="text-end float-end d-md-none "><button class="btn btn-lg btn-light" type="button" aria-expanded="false" aria-controls="bRefine" aria-label="Close" data-bs-toggle="collapse" data-bs-target="#bRefine"><i class="bi bi-x-circle-fill"></i></button></div>
<?php
	if($qr_res->numHits() > 1){
?>
		<form role="search" id="searchWithin" class="pt-1 pt-md-0" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
			<div class="input-group p-3">
				<label for="search-within" class="form-label visually-hidden">Search within</label>
				<input name="search_refine" id="search-within" type="text" class="bg-white form-control rounded-0  border-0" placeholder="<?php print _t("Search within..."); ?>" aria-label="<?php print _t("Search within"); ?>">
				<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
				<button type="submit" class="btn rounded-0 bg-white" aria-label="search submit"><i class="bi bi-search"></i></button>
			</div>
		</form>
<?php
	}
	if((is_array($va_facets) && sizeof($va_facets)) || ($vs_criteria)){
		print "<H2 class='fs-4 px-3 py-2'>"._t("Filter by")."</H2>";
		
		if($vs_criteria){
			print "<div class='p-3'>".$vs_criteria."</div>";
		}
		print '<div class="accordion accordion-flush" id="browseRefineFacets">';
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			$vs_more_link = "";
			print "<div class='accordion-item'>";
		
			if ((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name))) {
				print "<div class='accordion-header' id='heading".$vs_facet_name."'><button class='accordion-button collapsed fw-medium text-capitalize ' type='button' data-bs-toggle='collapse' data-bs-target='#".$vs_facet_name."' aria-expanded='false' aria-controls='".$vs_facet_name."'>".$va_facet_info['label_singular']."</button></div>";

				print "<div id='".$vs_facet_name."' class='accordion-collapse collapse' aria-labelledby='heading".$vs_facet_name."' data-bs-parent='#browseRefineFacets'>
					<div class='accordion-body '>";
				
?>
					<script>
						jQuery(document).ready(function() {
							jQuery("#bHierarchyList_<?php print $vs_facet_name; ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'linkTo' => 'morePanel')); ?>");
						});
					</script>
					<div id='bHierarchyList_<?php print $vs_facet_name; ?>'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
<?php
				print "</div></div>";
			} else {				
				if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
				print "<div class='accordion-header' id='heading".$vs_facet_name."'><button class='accordion-button collapsed fw-medium text-capitalize ' type='button' data-bs-toggle='collapse' data-bs-target='#".$vs_facet_name."' aria-expanded='false' aria-controls='".$vs_facet_name."'>".$va_facet_info['label_singular']."</button></div>";

				print "<div id='".$vs_facet_name."' class='accordion-collapse collapse' aria-labelledby='heading".$vs_facet_name."' data-bs-parent='#browseRefineFacets'>
					<div class='accordion-body small'><ul class='list-group'>";
						$vn_facet_size = sizeof($va_facet_info['content']);
						$vn_c = 0;
						foreach($va_facet_info['content'] as $va_item) {
							$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
							print "<li class='list-group-item border-0 bg-transparent px-0 py-1'>".caNavLink($this->request, $va_item['label'].$vs_content_count, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</li>";
							$vn_c++;
					
							if(($vn_c == $vn_facet_display_length_maximum) && ($vn_facet_size > $vn_facet_display_length_maximum))  {
								$vs_more_link = "<li class='list-group-item border-0 bg-transparent px-0 py-1'><button class='btn btn-sm btn-secondary' hx-trigger='click' hx-target='#bMorePanel' hx-get='".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."' type='button' data-bs-toggle='collapse' data-bs-target='#bMorePanel' aria-controls='bMorePanel' role='button' onClick='document.getElementById(\"bMorePanel\").focus();'>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_maximum)."</button></li>";
								break;
							}
						}

				print "</ul>".$vs_more_link."</div></div>";
			}
			print "</div><!-- end accordion-item -->";
		}
		print "</div><!-- end accordian browseRefineFacets -->";
	}
	print "</div><!-- end bRefine -->\n";	
}
