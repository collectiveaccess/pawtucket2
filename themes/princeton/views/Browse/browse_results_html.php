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
	$vn_is_advanced		= (int)$this->getVar('is_advanced');
	$vb_showLetterBar	= (int)$this->getVar('showLetterBar');	
	$va_letter_bar		= $this->getVar('letterBar');	
	$vs_letter			= $this->getVar('letter');
	$vn_row_id 			= $this->request->getParameter('row_id', pInteger);
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	
	$vs_current_sort	= $this->getVar('sort');
	$vs_sort_dir		= $this->getVar('sort_direction');
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');

	$vn_result_size 	= (sizeof($va_criteria) > 0) ? $qr_res->numHits() : $this->getVar('totalRecordsAvailable');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
	$vb_ajax			= (bool)$this->request->isAjax();
	$va_browse_info = $this->getVar("browseInfo");
	$vs_sort_control_type = caGetOption('sortControlType', $va_browse_info, 'dropdown');
	$o_config = $this->getVar("config");
	$vs_result_col_class = $o_config->get('result_col_class');
	$vs_refine_col_class = $o_config->get('refine_col_class');
	$va_export_formats = $this->getVar('export_formats');
	$va_browse_type_info = $o_config->get($va_browse_info["table"]);
	$va_all_facets = $va_browse_type_info["facets"];	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

if($vs_detailNav = $this->request->getParameter("detailNav", pString)){
	# --- this is the filter/sort nav bar above related objects on entity and occurrence
	# --- detailNav = entity, occurrence, collection
	switch($vs_detailNav){
		case "collections":
			$va_filter_facets = array("type_facet");
		break;
		# -------------------
		
	}
	$vs_browse_type = $this->request->getAction();
?>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="detailFilter">

<?php				
				$vs_label_output = 0;

				if((sizeof($va_criteria) > 1)){
					# --- check if type criteria has been selected
					foreach($va_criteria as $va_facet_criteria){
						if (!in_array($va_facet_criteria['facet_name'], array("collection_facet"))) {
							if(!$vs_label_output){
								print "Filter by: ";
								$vs_label_output = 1;
							}
							print '<div class="btn-group"><a href="#" onClick="loadDetailResults'.$vs_browse_type.'(\''.caNavUrl($this->request, '', $this->request->getController(), $this->request->getAction(), array('detailNav' => $vs_detailNav, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'sort' => $vs_current_sort, 'removeCriterion' => $va_facet_criteria['facet_name'], 'removeID' => urlencode($va_facet_criteria['id'])), array('dontURLEncodeParameters' => true)).'\'); return false;"><button class="btn btn-default">'.$va_facet_criteria["facet"].": ".str_replace("Texts ➜ ", "", $va_facet_criteria["value"]).' <span class="glyphicon glyphicon-remove-circle"></span></button></a></div>';
						}
					}
				}


				foreach($va_filter_facets as $vs_filter_facet){
					if(is_array($va_facets[$vs_filter_facet]) && sizeof($va_facets[$vs_filter_facet]) && sizeof($va_facets[$vs_filter_facet]["content"]) > 1){
						if(!$vs_label_output){
							print "Filter by: ";
							$vs_label_output = 1;
						}
?>
								<div class="btn-group">
									<a href="#" data-toggle="dropdown"><button class='btn btn-default'><?php print $va_facets[$vs_filter_facet]["label_singular"]; ?> <i class="fa fa-caret-down"></button></i></a>
									<ul class="dropdown-menu" role="menu">
<?php
										foreach($va_facets[$vs_filter_facet]["content"] as $vn_item_id => $va_item){
											print '<li><a href="#" onClick="loadDetailResults'.$vs_browse_type.'(\''.caNavUrl($this->request, '', $this->request->getController(), $this->request->getAction(), array('detailNav' => $vs_detailNav, 'key' => $vs_browse_key, 'facet' => $vs_filter_facet, 'id' => $va_item['id'], 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\'); return false;">'.$va_item["label"].'</a></li>';
										}
?>
									</ul>
								</div><!-- end btn-group -->
<?php
					}
				}
?>

<?php					
				if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
?>
								Sort by: <div class="btn-group">
								<a href="#" data-toggle="dropdown"><button class='btn btn-default'><?php print urldecode($vs_current_sort); ?> <i class="fa fa-caret-down"></i></button></a>
								<ul class="dropdown-menu" role="menu">
<?php
									print "<li class='dropdown-header'>"._t("Sort by:")."</li>\n";
									foreach($va_sorts as $vs_sort => $vs_sort_flds) {
										if ($vs_current_sort === $vs_sort) {
											print "<li><a href='#' onClick='return false;'><em>{$vs_sort}</em></a></li>\n";
										} else {
											print '<li><a href="#" onClick="loadDetailResults'.$vs_browse_type.'(\''.caNavUrl($this->request, '', $this->request->getController(), $this->request->getAction(), array('detailNav' => $vs_detailNav, 'key' => $vs_browse_key, 'sort' => $vs_sort, 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\'); return false;">'.$vs_sort.'</a></li>';
										}
									}
									print "<li class='divider'></li>\n";
									print "<li class='dropdown-header'>"._t("Sort order:")."</li>\n";
									print '<li><a href="#" onClick="loadDetailResults'.$vs_browse_type.'(\''.caNavUrl($this->request, '', $this->request->getController(), $this->request->getAction(), array('detailNav' => $vs_detailNav, 'key' => $vs_browse_key, 'sort' => $vs_current_sort, 'view' => $vs_current_view, 'direction' => 'asc'), array('dontURLEncodeParameters' => true)).'\'); return false;">'.(($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : '').'</a></li>';
									print '<li><a href="#" onClick="loadDetailResults'.$vs_browse_type.'(\''.caNavUrl($this->request, '', $this->request->getController(), $this->request->getAction(), array('detailNav' => $vs_detailNav, 'key' => $vs_browse_key, 'sort' => $vs_current_sort, 'view' => $vs_current_view, 'direction' => 'desc'), array('dontURLEncodeParameters' => true)).'\'); return false;">'.(($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : '').'</a></li>';
?>
								</ul>
							</div>
<?php
				}
				if($vb_showLetterBar){
					print "<div id='bLetterBar'>";
					foreach(array_keys($va_letter_bar) as $vs_l){
						if(trim($vs_l)){
							#print caNavLink($this->request, $vs_l, ($vs_letter == $vs_l) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => $vs_l))." ";
							print '<a href="#" '.(($vs_letter == $vs_l) ? 'class="selectedLetter"' : '').' onClick="loadDetailResults'.$vs_browse_type.'(\''.caNavUrl($this->request, '', $this->request->getController(), $this->request->getAction(), array('detailNav' => $vs_detailNav, 'key' => $vs_browse_key, 'l' => $vs_l, 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\'); return false;">'.$vs_l.'</a>';
						}
					}
					#print " | ".caNavLink($this->request, _t("All"), (!$vs_letter) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => 'all')); 
					print ' | <a href="#" '.((!$vs_letter) ? 'class="selectedLetter"' : '').' onClick="loadDetailResults'.$vs_browse_type.'(\''.caNavUrl($this->request, '', $this->request->getController(), $this->request->getAction(), array('detailNav' => $vs_detailNav, 'key' => $vs_browse_key, 'l' => 'all', 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\'); return false;">All</a>';
					print "</div>";
				}
?>
				</div></div></div><!--- end row --></div><!--- end container -->
	<script type='text/javascript'>	
		function loadDetailResults<?php print $vs_browse_type; ?>(url) {
			jQuery("#browseResultsContainer<?php print $vs_browse_type; ?>").data('jscroll', null);
			jQuery("#browseResultsContainer<?php print $vs_browse_type; ?>").load(url, function() {
				jQuery("#browseResultsContainer<?php print $vs_browse_type; ?>").jscroll({
					autoTrigger: true,
					loadingHtml: "<i class='caIcon fa fa fa-cog fa-spin fa-1x' ></i> Loading...",
					padding: 20,
					nextSelector: "a.jscroll-next"
				});
			});
		}
	</script>
<?php
}	
if (!$vb_ajax) {	// !ajax
?>
<div class="row" style="clear:both;">
	<div class='<?php print ($vs_result_col_class) ? $vs_result_col_class : "col-sm-8 col-md-8 col-lg-8"; ?>'>
<?php 
			if($vs_sort_control_type == 'list'){
				if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
					print "<div id='bSortByList'><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
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
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'" aria-label="direction" role="button"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					print "</ul></div>\n";
				}
			}
?>
		<H1>
<?php
			print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("Result") : _t("Results"));	
?>		
			<div class="btn-group">
				<a href="#" data-toggle="dropdown"><i class="fa fa-cog bGear" aria-label="Result options"></i></a>
				<ul class="dropdown-menu" role="menu">
<?php
					if(($vs_table == "ca_objects") && $vn_result_size && (is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info))){
						print "<li role='menuitem'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveLastResults" => 1))."\"); return false;'>"._t("Add all results to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
						print "<li role='menuitem'><a href='#' onclick='jQuery(\".bSetsSelectMultiple\").toggle(); return false;'>"._t("Select results to add to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
						print "<li class='divider' role='menuitem'></li>";
					}
					if($vs_sort_control_type == 'dropdown'){
						if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
							print "<li class='dropdown-header' role='menuitem'>"._t("Sort by:")."</li>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li role='menuitem'><a href='#'><em>{$vs_sort}</em></a></li>\n";
								} else {
									print "<li role='menuitem'>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
								}
							}
							print "<li class='divider' role='menuitem'></li>\n";
							print "<li class='dropdown-header' role='menuitem'>"._t("Sort order:")."</li>\n";
							print "<li role='menuitem'>".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
							print "<li role='menuitem'>".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc', '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
						}
						
						if ((sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) && is_array($va_sorts) && sizeof($va_sorts)) {
?>
						<li class="divider" role='menuitem'></li>
<?php
						}
					}
					if (sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) {
						print "<li role='menuitem'>".caNavLink($this->request, _t("Start Over"), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
					}
					if(is_array($va_export_formats) && sizeof($va_export_formats)){
						// Export as PDF links
						print "<li class='divider' role='menuitem'></li>\n";
						print "<li class='dropdown-header' role='menuitem'>"._t("Download results as:")."</li>\n";
						foreach($va_export_formats as $va_export_format){
							print "<li class='".$va_export_format["code"]."' role='menuitem'>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
						}
					}
?>
				</ul>
			</div><!-- end btn-group -->
<?php
			if(is_array($va_facets) && sizeof($va_facets)){
?>
			<a href='#' id='bRefineButton' onclick='jQuery("#bRefine").toggle(); return false;'><i class="fa fa-table"></i></a>
<?php
			}
			if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
				print "<a href='#' class='bSetsSelectMultiple' id='bSetsSelectMultipleButton' onclick='jQuery(\"#setsSelectMultiple\").submit(); return false;'><button type='button' class='btn btn-default btn-sm'>"._t("Add selected results to %1", $va_add_to_set_link_info['name_singular'])."</button></a>";
			}
?>
		</H1>
<?php
		if($vs_facet_description){
			print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
		}

		if($vb_showLetterBar){
			print "<div id='bLetterBar'>";
			foreach(array_keys($va_letter_bar) as $vs_l){
				if(trim($vs_l)){
					print caNavLink($this->request, $vs_l, ($vs_letter == $vs_l) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => $vs_l))." ";
				}
			}
			print " | ".caNavLink($this->request, _t("All"), (!$vs_letter) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => 'all')); 
			print "</div>";
		}
?>
		<form id="setsSelectMultiple">
		<div class="row">
			<div id="browseResultsContainer">
<?php
} // !ajax

# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id.$vs_letter);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{
	$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
	print $vs_result_page;
}		

if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		</form>
	</div><!-- end col-8 -->
	<div class="<?php print ($vs_refine_col_class) ? $vs_refine_col_class : "col-sm-4 col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1"; ?>">
		<div id="bViewButtons">
<?php
		if(is_array($va_views) && (sizeof($va_views) > 1)){
			foreach($va_views as $vs_view => $va_view_info) {
				if ($vs_current_view === $vs_view) {
					print '<a href="#" class="active"><span class="glyphicon  '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" role="button"></span></a> ';
				} else {
					print caNavLink($this->request, '<span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" role="button"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
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
			padding: 800,
			nextSelector: 'a.jscroll-next'
		});
<?php
		if($vn_row_id){
?>
			window.setTimeout(function() {
				$("window,body,html").scrollTop( $("#row<?php print $vn_row_id; ?>").offset().top);
			}, 0);
<?php
		}
		if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
?>
		jQuery('#setsSelectMultiple').on('submit', function(e){		
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
