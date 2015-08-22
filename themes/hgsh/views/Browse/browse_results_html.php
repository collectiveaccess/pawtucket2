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
	
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_displayname = $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	
if (!$vb_ajax) {	// !ajax
?>
<div class="row" style="clear:both;">
	<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
			#print "<H1>"._t('%1 %2 %3', $qr_res->numHits(), ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($qr_res->numHits() == 1) ? _t("Result") : _t("Results"))."</H1>";	
		if($vb_is_search){
			print "<H5>";
		}
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			foreach($va_criteria as $va_criterion) {
				if ($va_criterion['facet_name'] != '_search') {
					# --- browse refinement is not used in this system
					# --- instead, detail pages have links to "related" objects browse results
					# --- there is only ever one criteria, and it should serve as a title including a link back to it's detail page
					#print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
					switch($va_criterion['facet_name']){
						case "entity_org_facet":
							$vs_table = "ca_entities";
						break;
						# --------------------
						case "place_facet":
							$vs_table = "ca_places";
						break;
						# --------------------
						case "collection_facet":
							$vs_table = "ca_collections";
						break;
						# --------------------
						case "event_facet":
							$vs_table = "ca_occurrences";
						break;
						# --------------------
						
					}
					print caDetailLink($this->request, "<div class='btn pull-left'><i class='fa fa-angle-double-left'></i></div><H1>".$va_criterion['value']."</H1>", '', $vs_table, $va_criterion['id']);
				}else{
					print "<strong>".$va_criterion['facet'].':</strong>';
					print ' '.$va_criterion['value'];
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
		if($vb_is_search){
			print "</H5>";
		}
		if($vs_facet_description){
			print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
		}
?>
		<div class="row">
			<div id="browseResultsContainer">
<?php
} // !ajax

print $this->render("Browse/browse_results_{$vs_current_view}_html.php");			

if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
	</div><!-- end col -->
</div><!-- end row -->	
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 20,
			nextSelector: 'a.jscroll-next'
		});
	});

</script>

<?php
} //!ajax
?>