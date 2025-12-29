<?php
/* ----------------------------------------------------------------------
 * Browse/facet_hierarchy_level_html.php : 
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
	$va_facet_list = 		$this->getVar('facet_list');
	$vs_facet_name = 		$this->getVar("facet_name");
	$vs_key = 				$this->getVar("key");
	$vs_browse_type = 		$this->getVar("browse_type");
	# --- when vb_more_panel = 1, this is being rendered in the overlay panel and ajax loading / display are different
	$vb_morePanel = 		$this->request->getParameter('morePanel', pInteger);
	$va_facet_info =		$this->getVar("facet_info");
	
	$va_links = array();
	
	if($vb_morePanel){
?>
		<div class="h-100 position:relative p-3 overflow-y-hidden d-flex flex-column">
			<div class="position-absolute end-0 w-auto pe-3"><button type="button" class="btn-close" aria-label="<?= _t("Close"); ?>" data-bs-toggle="collapse" data-bs-target="#bMorePanel" aria-controls="bMorePanel" hx-on:click="htmx.toggleClass(htmx.find('#bRefine'), 'd-none')"></button></div>
			<div id='bMoreHeading' class='flex-shrink-0'>
				<div class='fw-semibold fs-4 text-capitalize pe-4 me-2 lh-sm'><?= $va_facet_info["label_singular"]; ?></div>
				<div class="fw-semibold pt-2 pb-2 border-bottom" hx-target="this" hx-trigger="load" hx-get="<?= caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'id' => $this->request->getParameter('id', pString))); ?>"></div>
			</div>
<?php
	}
	foreach($va_facet_list as $vn_key => $va_facet){
		foreach($va_facet as $vn_id => $va_children){
			if (!is_array($va_children)) { continue; }
			
			$vs_content_count = (isset($va_children['content_count']) && ($va_children['content_count'] > 0)) ? " (".$va_children['content_count'].")" : "";
			$vs_name = caTruncateStringWithEllipsis($va_children["name"], 75);
			
			if(isset($vs_name)){
				$vs_buf = "<dd>";
				if((int)$va_children["children"] > 0){
					$vs_buf .= caNavLink($this->request, $vs_name.$vs_content_count, '', '*', '*', $vs_browse_type, array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $vn_id));
					if($vb_morePanel){
						$vs_buf .= "<a href='#' class='btn btn-light py-0 px-1 ms-2 fs-6' title='"._t('View sub-items')."' hx-trigger='click' hx-target='#bMorePanel' hx-get='".caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('getFacet' => 1, 'facet' => $vs_facet_name, 'key' => $vs_key, 'id' => $vn_id, "browseType" => $vs_browse_type, "morePanel" => 1))."' type='button' aria-controls='bMorePanel' role='button' onClick='document.getElementById(\"bMorePanel\").focus();'><i class='bi bi-chevron-down'></i></a>";
					}else{
						$vs_buf .= "<a href='#' class='btn btn-light py-0 px-1 ms-2 fs-6' title='"._t('View sub-items')."' hx-on:click='htmx.toggleClass(htmx.find(\"#bRefine\"), \"d-none\")' hx-trigger='click' hx-target='#bMorePanel' hx-get='".caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('getFacet' => 1, 'facet' => $vs_facet_name, 'key' => $vs_key, 'id' => $vn_id, "browseType" => $vs_browse_type, "morePanel" => 1))."' type='button' data-bs-toggle='collapse' data-bs-target='#bMorePanel' aria-controls='bMorePanel' role='button' onClick='document.getElementById(\"bMorePanel\").focus();'><i class='bi bi-chevron-down'></i></a>";
					}
				}else{
					$vs_buf .= caNavLink($this->request, $vs_name.$vs_content_count, '', '*', '*', $vs_browse_type, array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $vn_id));
				}
				$vs_buf .= "</dd>";
				$va_links[mb_strtolower($va_children["name"])] = $vs_buf;
			}
		}
	}

	if($vb_morePanel){
		print "<div class='pt-3 overflow-y-scroll flex-grow-1'>";
	}
	if(sizeof($va_links)){
		ksort($va_links);
		print "<dl>".join("\n", $va_links)."</dl>";
	}
	if($vb_morePanel){
		print "</div>";
	}
	if($vb_morePanel){
?>
		</div>

<?php	
	}
?>