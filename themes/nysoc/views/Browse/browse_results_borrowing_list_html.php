<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
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
 
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";

	
	$o_set_config = caGetLightboxConfig();
	$vs_lightbox_icon = $o_set_config->get("add_to_lightbox_icon");
	if(!$vs_lightbox_icon){
		$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
	}
	$va_lightbox_display_name = caGetLightboxDisplayName($o_set_config);
	$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
	$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
	
		$vn_col_span = 4;
		$vn_col_span_sm = 4;
		$vn_col_span_xs = 12;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 4;
			$vn_col_span_sm = 4;
			$vn_col_span_xs = 6;
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
?>		
			<div id='circTab' <?php print $vs_style; ?>>
				<table id='circTable' class="display" style='width:100%;'>
					<thead class='titleBar' >									
						<tr>
							<th>Borrower<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
							<th>Author<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>										
							<th>Title<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>								
							<th>Volume<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
							<th>Date Out<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
							<th>Date In<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>									
							<th>Fine<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>		
							<th>Ledger<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
						</tr><!-- end row -->
					</thead>
					<tbody>
					</tbody>
				</table><!-- end table -->
			</div><!-- end circTab -->
<?php
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
		$('#circTable').dataTable({
			paging: true,
			serverSide: true,
			searching: false,
			lengthChange: false,
			ajax: '<?php print caNavUrl($this->request, '*', '*', '*', array('view' => 'jsonData', '_advanced' => 1)); ?>',
    		//order: [[ 4, "asc" ]],
    		columnDefs: [
    			{ type: 'natural', orderable: false, targets: [1,3,7] }, 
    			{ type: 'natural', targets: [0,2,5,6] }
    		]
    	});		
	});
</script>