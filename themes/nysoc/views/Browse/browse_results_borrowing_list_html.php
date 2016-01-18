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
<?php
			$va_books = $qr_res->getAllFieldValues('ca_objects_x_entities.object_id');
			$qr_res->seek($vn_start);
			$qr_books = caMakeSearchResult('ca_objects', array_unique($va_books));
			
			$va_authors = $va_authors_sort = array();
			while($qr_books->nextHit()) {
				$vn_object_id = $qr_books->get('ca_objects.object_id');
				
				$va_labels = $qr_books->get('ca_entities.preferred_labels', array('returnAsArray' => true, 'assumeDisplayField' => false, 'restrictToRelationshipTypes' => array('author')));
				foreach($va_labels as $va_label) {
					$va_authors[$vn_object_id] = (($va_authors[$vn_object_id]) ? "; " : "").$va_label['displayname'];
					$va_authors_sort[$vn_object_id] = (($va_authors[$vn_object_id]) ? "; " : "").addslashes($va_label['surname'].', '.$va_label['forename']);
				}
			}
			
			while($qr_res->nextHit()) { // && ($vn_c < $vn_hits_per_block)) {
				
				if ($vs_title = $qr_res->get('ca_objects.parent.preferred_labels.name', array('returnAsLink' => true))) {
					$vs_title_sort = addslashes($qr_res->get('ca_objects.parent.preferred_labels.name_sort'));
					$vs_volume = $qr_res->get('ca_objects.preferred_labels.name', array('returnAsLink' => true));
					$vs_volume_sort = addslashes($qr_res->get('ca_objects.preferred_labels.name_sort'));
				} else {
					$vs_title = $qr_res->get('ca_objects.preferred_labels.name', array('returnAsLink' => true));
					$vs_title_sort = addslashes($qr_res->get('ca_objects.preferred_labels.name_sort'));
					$vs_volume = $vs_volume_sort = '';
				}
				$vs_author = $va_authors[$qr_res->get("ca_objects_x_entities.object_id")];
				$vs_author_sort = $va_authors_sort[$qr_res->get("ca_objects_x_entities.object_id")];
				$vs_borrower = $qr_res->get('ca_entities.preferred_labels.displayname', array('returnAsLink' => true));
				$vs_borrower_sort = $qr_res->get('ca_entities.preferred_labels.surname').", ".$qr_res->get('ca_entities.preferred_labels.forename');
				$vs_date_out = $qr_res->get('ca_objects_x_entities.date_out');
				//$vs_date_out_sort = $qr_res->get('ca_objects_x_entities.date_out', array('getDirectDate' => true));
				$vs_date_in = $qr_res->get('ca_objects_x_entities.date_in');
				//$vs_date_in_sort = $qr_res->get('ca_objects_x_entities.date_in', array('getDirectDate' => true));
				
				print "<tr class='ledgerRow detail'>";
				print "<td><span title='{$vs_borrower_sort}'></span>{$vs_borrower}</td>";
				print "<td><span title='{$vs_author_sort}'></span>{$vs_author}</td>";
				print "<td><div class='bookTitle'><span title='{$vs_title_sort}'></span>{$vs_title}</div></td>";
				print "<td><span title='{$vs_volume_sort}'>{$vs_volume}</span></td>";
				print "<td>{$vs_date_out}</td>";
				print "<td>{$vs_date_in}</td>";
				print "<td>".$qr_res->get('ca_objects_x_entities.fine')."</td>";
				print "<td class='detail'>".caNavLink($this->request, '<i class="fa fa-file-text"></i>', '', '', 'Detail', 'objects/'.$qr_res->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true)))."</td>";
				print "</tr>\n";
			//	if ($vn_c > 10)  break;
				$vn_c++;
			}
?>
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
    		"order": [[ 3, "asc" ]],
    		columnDefs: [{ 
       			type: 'title-string', targets: [0,1]
       		}, { 
       			type: 'natural', targets: [2,5,6] 
    		}],
     		paging: false
    	});		
	});
</script>