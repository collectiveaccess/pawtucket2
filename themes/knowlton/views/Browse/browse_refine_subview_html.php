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

if((is_array($va_facets) && sizeof($va_facets)) || ($qr_res->numHits() > 1)){
?>		
	<div id='bRefine' class='sticky-md-top vh-100 collapse bg-white'>
		<div id='bMorePanel' tabindex="-1" class='position-absolute w-100 z-3 bg-light h-100 collapse fs-5'><!-- long lists of facets are loaded here --></div>
		<div class="text-end d-md-none "><button class="btn btn-lg btn-light" type="button" aria-expanded="false" aria-controls="bRefine" aria-label="Close" data-bs-toggle="collapse" data-bs-target="#bRefine"><i class="bi bi-x-circle-fill"></i></button></div>
		<div class="h-100 overflow-y-auto">
<?php
	if($qr_res->numHits() > 1){
?>
		<form id="searchWithin" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
			<div class="input-group px-3 pb-3">
				<label for="search-within" class="form-label visually-hidden">Search within</label>
				<input name="search_refine" id="search-within" type="text" class="bg-white form-control rounded-0 border-black" placeholder="<?php print _t("Search within..."); ?>" aria-label="<?php print _t("Search within"); ?>">
				<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
				<button type="submit" class="btn rounded-0 bg-white border-start-0 border-black" aria-label="search submit"><i class="bi bi-search"></i></button>
			</div>
		</form>
<?php
	}
	if((is_array($va_facets) && sizeof($va_facets))){
		print "<H2 class='fs-5 fw-normal px-3 pt-2 text-uppercase'>"._t("Filter by")."</H2>";
		
		print '<div id="browseRefineFacets" class="px-3 fs-5">';
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			$vs_more_link = "";
			
			if ((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name))) {
				print "<dl><dt class='text-uppercase'>".$va_facet_info['label_singular']."</dt>";

				
?>
					<div id='bHierarchyList_<?php print $vs_facet_name; ?>'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
<?php
				print "</dl>";
			} else {				
				if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
				print "<div class=text-uppercase' id='heading".$vs_facet_name."'><button class='collapsed fw-bold text-uppercase btn btn-white px-0' type='button' data-bs-toggle='collapse' data-bs-target='#".$vs_facet_name."' aria-expanded='false' aria-controls='".$vs_facet_name."'>".$va_facet_info['label_singular']."</button></div>";
				print "<div id='".$vs_facet_name."' class='accordion-collapse collapse' aria-labelledby='heading".$vs_facet_name."' data-bs-parent='#browseRefineFacets'>";
				
				print "<ul class='list-group mb-1'>";
				
						$vn_facet_size = sizeof($va_facet_info['content']);
						$vn_c = 0;
						foreach($va_facet_info['content'] as $va_item) {
							$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
							print "<li class='list-group-item border-0 bg-transparent px-0 py-1'>".caNavLink($this->request, $va_item['label'].$vs_content_count, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</li>";
							$vn_c++;
					
							if(($vn_c == $vn_facet_display_length_maximum) && ($vn_facet_size > $vn_facet_display_length_maximum))  {
								print "<li class='list-group-item border-0 bg-transparent px-0 py-1'><button class='bMoreButton btn btn-sm btn-secondary' hx-trigger='click' hx-target='#bMorePanel' hx-get='".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."' type='button' data-bs-toggle='collapse' data-bs-target='#bMorePanel' aria-controls='bMorePanel' role='button' onClick='document.getElementById(\"bMorePanel\").focus();'>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_maximum)."</button></li>";
								break;
							}
						}

				print "</ul></div>";
			}
		}
		print "</div><!-- end browseRefineFacets -->";
	}
	print "</div></div><!-- end bRefine -->\n";	
}
