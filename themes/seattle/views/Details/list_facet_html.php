<?php
/* ----------------------------------------------------------------------
 * views/Details/list_facet_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 
	# -----------------------------------------------------------
	# --- facet view for group_mode = alphabetical, none
	# -----------------------------------------------------------

	$va_facet_content = 	$this->getVar('facet_content');
	$vs_facet_name = 		$this->getVar('facet_name');
	$vs_view = 				$this->getVar('view');
	$vs_key = 				$this->getVar('key');
	$va_facet_info = 		$this->getVar("facet_info");
	$vb_is_nav = 			(bool)$this->getVar('isNav');
	$vn_start =				$this->getVar('start');
	$vn_items_per_page =	$this->getVar('limit');

	if ($vn_start == 0) {
?>
		<div id="detailPanel<?php print $vs_facet_name; ?>" class="row">
<?php
	}
	
	
	$vn_c = 0;
	foreach($va_facet_content as $vn_id => $va_item) {
		print "<div class='browseFacetItem col-sm-4 col-md-3'>";
		print caNavLink($this->request, $va_item['label'], '', '*', '*', $this->request->getAction().'/'.$this->request->getActionExtra(), array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view, 'key' => $vs_key, 'browseType' => 'objects'));
		print "</div>";
		$vn_c++;
		
		if (($vn_items_per_page > 0) && ($vn_c >= $vn_items_per_page)) { break; }
	}
	print caNavLink($this->request, caBusyIndicatorIcon($this->request).' '._t('Loading'), '', '*', '*', '*', array('facet' => $vs_facet_name, 'getFacet' => 1, 'key' => $vs_key, 'view' => $vs_view, 'isNav' => $vb_is_nav ? 1 : 0, 's' => $vn_start + $vn_items_per_page, 'browseType' => 'objects'));
	if ($vn_start == 0) {
?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#detailPanel<?php print $vs_facet_name; ?>").jscroll({
					loadingHtml: "<div class='browseFacetItem col-sm-4 col-md-3'><a href='#'><?php print addslashes(caBusyIndicatorIcon($this->request).' '._t('Loading...')); ?></a></div>"
				});
			});	
		</script>
<?php
	}