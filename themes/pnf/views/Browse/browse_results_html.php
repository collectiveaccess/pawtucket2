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
	$vn_is_advanced		 = (int)$this->getVar('is_advanced');	
	
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	
	$vs_current_sort	= $this->getVar('sort');
	$vs_sort_dir		= $this->getVar('sort_direction');
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
	$vb_ajax			= (bool)$this->request->isAjax();
	$va_browse_info = $this->getVar("browseInfo");
	$vs_sort_control_type = caGetOption('sortControlType', $va_browse_info, 'dropdown');
	$o_config = $this->getVar("config");
	$vs_result_col_class = $o_config->get('result_col_class');
	$vs_refine_col_class = $o_config->get('refine_col_class');
	$va_export_formats = $this->getVar('export_formats');
	if ($vs_table == "ca_collections") { $vs_class = "collectionsBrowse col-sm-8";}
	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
if (!$vb_ajax) {	// !ajax
?>
<div class="row" style="clear:both;">
	<div class='<?php print ($vs_table == "ca_collections" ? "col-sm-12" : "col-sm-8 col-md-9 col-lg-9"); ?>'>
<?php 
			if($vs_sort_control_type == 'list'){
				if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
					print "<H5 id='bSortByList'><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='selectedSort'>{$vs_sort}</li>\n";
						} else {
							print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					print "</ul></H5>\n";
				}
			}
		if ($vs_table != "ca_collections") {		

		print "<h2 style='margin-bottom:5px;'>".$va_browse_info["displayName"]." <span class='grayText'>(".$qr_res->numHits()." result".(($qr_res->numHits() != 1 ? "s" : "")).")</span></h2>";	

?>
		<H5>
		
<?php
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			foreach($va_criteria as $va_criterion) {
				print "<strong>".$va_criterion['facet'].':</strong>';
				if ($va_criterion['facet_name'] != '_search') {
					print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
				}else{
					print ' '.$va_criterion['value'];
					$vs_search = $va_criterion['value'];
				}
				$i++;
				if($i < sizeof($va_criteria)){
					print " ";
				}
				$va_current_facet = $va_facets[$va_criterion['facet_name']];
				if((sizeof($va_criteria) == 1) && !$vb_is_search && $va_current_facet["show_description_when_first_facet"] && ($va_current_facet["type"] == "authority")){
					$t_authority_table = new $va_current_facet["table"];
					$t_authority_table->load($va_criterion['id']);
					$vs_facet_description = $t_authority_table->get($va_current_facet["show_description_when_first_facet"]);
				}
			}
		}
?>		
		</H5>
		<hr>
		<div id="searchOptions" >
			<div class='row'>	
				<div class='col-sm-6 col-md-6 col-lg-6 btn-group'>
				<a href='#' data-toggle="dropdown">Sort By: <span class='btn'><?php print $vs_current_sort;?><b class="caret"></b></span></a>
				<ul class="dropdown-menu" role="menu">
<?php				
					if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
						foreach($va_sorts as $vs_sort => $vs_sort_flds) {
							if ($vs_current_sort === $vs_sort) {
								print "<li><a href='#'><em>".$vs_sort."</em></a></li>\n";
							} else {
								print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
							}
						}
					}
					
?>										
				</ul>
				</div><!-- end buttongrp -->
				<div class='col-sm-6 col-md-6 col-lg-6 btn-group'>
<?php
					if ($vs_sort_dir == 'asc') {
						$vs_sort_label = "ascending";
					} else {
						$vs_sort_label = "descending";
					}
?>				
					<a href='#' data-toggle="dropdown">Sort Order: <span class='btn'><?php print ucfirst($vs_sort_label);?><b class="caret"></b></span></a>
					<ul class="dropdown-menu" role="menu">
<?php	
						if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc'))."</li>";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc'))."</li>";
						}
?>										
					</ul>
				</div><!-- end buttongrp -->
			</div><!-- end row -->										
		</div><!-- end searchoptions -->

<?php
		}
		if($vs_facet_description){
			print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
		}
?>
		<form id="setsSelectMultiple">
		<div class="row">
<?php
			if ($vs_table == "ca_collections") {
				global $g_ui_locale;
				if ($g_ui_locale == 'en_US'){
					print "<div class='mapInfo'>Click on collection names for locations and contact information.</div>";
				} else {
					print "<div class='mapInfo'>Haga clic en los nombres de colección para las direcciones y sitios web de las bibliotecas.</div>";
				}
			}
			if ($this->request->getAction() == "collections") {
				print "<div class='institutionList col-sm-4'>";
				$qr_res->seek(0);
				$i = 0;
				while($qr_res->nextHit()) {
					print "<div class='institutionUnit'>";
					print "<a href='#' onclick='$(\"#institutionMore".$qr_res->get('ca_collections.collection_id')."\").toggle(300); google.maps.event.trigger(caMap_map_markers[{$i}], \"click\"); return false;'><i class='fa fa-bank'></i> ".$qr_res->get('ca_collections.preferred_labels')."</a>";
					print "<div id='institutionMore".$qr_res->get('ca_collections.collection_id')."' class='institutionMore'>"; 
					print $qr_res->getWithTemplate('<ifcount code="ca_collections.collection_address" min="1"><unit><ifdef code="ca_collections.collection_address.collection_address_data1">^ca_collections.collection_address.collection_address_data1<br/></ifdef><ifdef code="ca_collections.collection_address.collection_address_data2">^ca_collections.collection_address.collection_address_data2<br/></ifdef><ifdef code="ca_collections.collection_address.collection_city">^ca_collections.collection_address.collection_city, </ifdef><ifdef code="ca_collections.collection_address.collection_stateprovince">^ca_collections.collection_address.collection_stateprovince </ifdef><ifdef code="ca_collections.collection_address.collection_postalcode">^ca_collections.collection_address.collection_postalcode </ifdef></unit></ifcount>');

					print $qr_res->getWithTemplate('<ifcount code="ca_collections.collection_website" min="1"><unit><ifdef code="ca_collections.collection_website"><br/><a href="^ca_collections.collection_website" target="_blank">^ca_collections.collection_website</a><br/></ifdef></unit><ifcount>');
					print "<br/>".caNavLink($this->request, 'Sueltas in this collection', 'institutionLink', '', 'Detail', 'collections/'.$qr_res->get('ca_collections.collection_id'));
					print "</div>";
					print "</div>";
					print "<hr>";
					$i++;
				}
				$qr_res->seek(0);
				print "</div>";
			}
?>		
			<div id="browseResultsContainer" <?php print "class='".$vs_class."'";?> >
<?php
		if($vb_is_search && !$qr_res->numHits() && $vs_search){
			# --- try to display did you mean results if available
			$o_search = caGetSearchInstance($vs_table);
			if (sizeof($va_suggestions = $o_search->suggest($vs_search, array('request' => $this->request)))) {
				$va_suggest_links = array();
				foreach($va_suggestions as $vs_suggestion){
					$va_suggest_links[] = caNavLink($this->request, $vs_suggestion, '', '*', '*', '*', array('search' => $vs_suggestion, 'sort' => $vs_current_sort, 'view' => $vs_current_view));
				}
				
				if (sizeof($va_suggest_links) > 1) {
					print "<div class='col-sm-12'>"._t("Did you mean one of these: %1?", join(', ', $va_suggest_links))."</div>";
				} else {
					print "<div class='col-sm-12'>"._t("Did you mean %1?", join(', ', $va_suggest_links))."</div>";
				}
			}
		}
} // !ajax

print $this->render("Browse/browse_results_{$vs_current_view}_html.php");			

if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		</form>
	</div><!-- end col-8 -->
	<div class="<?php print ($vs_refine_col_class) ? $vs_refine_col_class : "col-sm-4 col-md-3 col-lg-3"; ?>">
		<div id="bViewButtons">
<?php
		if(is_array($va_views) && (sizeof($va_views) > 1)){
			foreach($va_views as $vs_view => $va_view_info) {
				if ($vs_current_view === $vs_view) {
					print '<a href="#" class="active"><span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span></a> ';
				} else {
					print caNavLink($this->request, '<span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
				}
			}
		}
?>
		</div>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
	</div><!-- end col-2 -->
	
	
</div><!-- end row -->	

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 20,
			nextSelector: 'a.jscroll-next'
		});
<?php
		if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
?>
		jQuery('#setsSelectMultiple').submit(function(e){		
			objIDs = [];
			jQuery('#setsSelectMultiple input:checkbox:checked').each(function() {
			   objIDs.push($(this).val());
			});
			objIDsAsString = objIDs.join(';');
			caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveSelectedResults" => 1)); ?>/object_ids/' + objIDsAsString);
			e.preventDefault();
			return false;
		});
<?php
		}
?>
	});

</script>
<?php
		print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>