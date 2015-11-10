<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
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
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	

	$o_lightbox_config = caGetLightboxConfig();
	$vs_lightbox_icon = $o_lightbox_config->get("addToLightboxIcon");
	if(!$vs_lightbox_icon){
		$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
	}
	

	if(!($vs_placeholder = $o_config->get("placeholder_media_icon"))){
		$vs_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_placeholder."</div>";
		

		$vn_col_span = 3;
		$vn_col_span_sm = 4;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 3;
			$vn_col_span_sm = 6;
			$vn_col_span_xs = 6;
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			
			if ($vs_table != 'ca_objects') {
				$va_ids = array();
				while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
					$va_ids[] = $qr_res->get($vs_pk);
					$vn_c++;
				}
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'widepreview', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
			
				$vn_c = 0;	
				$qr_res->seek($vn_start);
			}
			
			$vs_add_to_lightbox_msg = addslashes(_t('Add to lightbox'));
			print "<div class='container extitles'><div class='row'>";
			print "<div class='col-xs-2 col-sm-2 col-md-2' style='padding-left:10px;'>&nbsp;</div>";
			print "<div class='col-xs-2 col-sm-2 col-md-2'>Date</div>";
			print "<div class='col-xs-4 col-sm-4 col-md-4'>Title</div>";
			print "<div class='col-xs-4 col-sm-4 col-md-4'>Exhibitors</div>";
			print "<!-- <div class='col-xs-2 col-sm-2 col-md-2'>Curator</div> -->";
			print "</div></div>";
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				if ($qr_res->get('ca_objects.dates.dates_value')) {
					$vn_date = ", ".$qr_res->get('ca_objects.dates.dates_value');
				} else {
					$vn_date = "";
				}
				if ($qr_res->get('ca_entities.preferred_labels')) {
					$vs_entity_detail_link 	= "<p>".$qr_res->get("ca_entities.preferred_labels", array('delimiter' => ', ')).$vn_date."</p>";
				} elseif ($qr_res->get('ca_occurrences.preferred_labels')){
					$vs_entity_detail_link = "<p>".$qr_res->get("ca_occurrences.preferred_labels", array('delimiter' => ', ')).$vn_date."</p>";
				} else {
					$vs_entity_detail_link = ", ".$qr_res->get('ca_objects.dates.dates_value');
				}

				if ($va_closing_dates = $qr_res->get('ca_occurrences.dates', array('returnWithStructure' => true))) {
					foreach ($va_closing_dates as $va_closing_key => $va_closing_t) {
						foreach ($va_closing_t as $va_key => $va_closing) {
							if ($va_closing['dates_type'] == "Exhibition dates") {
								$va_closing_date = $va_closing['dates_value'];
								$vs_date = $va_closing_date;

							}
						}
					}
				} else {
					$va_closing_dates = "";
				}				

				
				if ($qr_res->get('ca_places.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
					$vs_location = $qr_res->get('ca_places.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values));
				} else {
					$vs_location = "";
				}	
				
				if ($qr_res->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('curator'), 'checkAccess' => $va_access_values, 'delimiter' => '<br/>'))) {
					$vs_curator = $qr_res->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('curator'), 'checkAccess' => $va_access_values, 'delimiter' => '<br/>'));
				} else {
					$vs_curator = "";
				}
				
				if ($qr_res->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('exhibitor'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))) {
					$vs_exhibitor = $qr_res->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('exhibitor'), 'checkAccess' => $va_access_values, 'delimiter' => ', '));
				} else {
					$vs_exhibitor = "";
				}
					
				$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels.name"), '', $vs_table, $vn_id);
				$vs_thumbnail = "";
				if ($vs_table == 'ca_objects') {
					if(!($vs_thumbnail = $qr_res->getMediaTag('ca_object_representations.media', 'widepreview', array("checkAccess" => $va_access_values)))){
						$vs_thumbnail = $vs_placeholder_tag;	
					}
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);				
				} else {
					if($va_images[$vn_id]){
						$vs_thumbnail = $va_images[$vn_id];
					}else{
						$vs_thumbnail = $vs_placeholder_tag;
					}
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);			
				}
				$vs_add_to_set_url		= caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array($vs_pk => $vn_id));

				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

				print "
	<div class='bResultItemCol col-xs-12 col-sm-12 col-md-12 exhibitions'>
		<div class='row'>
			<div class='bResultItem ' >
				<div class='bResultItemContent'>
					<div class='col-xs-2 col-sm-2 col-md-2'>
						<div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
					</div>
					<div class='col-xs-2 col-sm-2 col-md-2'>
						{$vs_date}
					</div>
					<div class='col-xs-4 col-sm-4 col-md-4'>
						{$vs_label_detail_link}
					</div>
					<div class='col-xs-4 col-sm-4 col-md-4'>
						{$vs_exhibitor}
					</div>
<!--					<div class='col-xs-2 col-sm-2 col-md-2'>
						{$vs_curator}
					</div>					-->
				</div><!-- end bResultItemContent -->
			</div><!-- end bResultItem -->
		</div><!-- end row -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
		}
?>