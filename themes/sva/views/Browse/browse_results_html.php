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
	
	
if (!$vb_ajax) {	// !ajax
?>
<div class="row" style="clear:both;">
	<div class='<?php print ($vs_result_col_class) ? $vs_result_col_class : "col-sm-12 col-md-12 col-lg-12"; ?>'>
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
							print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc"))))."</li>";
					print "</ul></H5>\n";
				}
			}
?>
		<H1>
<?php
			print _t('%1 %2 %3', $qr_res->numHits(), ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($qr_res->numHits() == 1) ? _t("Result") : _t("Results"));	
			if($vs_sort_control_type == 'dropdown'){
?>		
			<div class="btn-group">
				<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
				<ul class="dropdown-menu" role="menu">
<?php
					if($qr_res->numHits()){
						print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array("saveLastResults" => 1))."\"); return false;'>"._t("Add all results to lightbox")."</i></a></li>";
?>
						<li class="divider"></li>
<?php
					}
					if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
						print "<li class='dropdown-header'>"._t("Sort by:")."</li>\n";
						foreach($va_sorts as $vs_sort => $vs_sort_flds) {
							if ($vs_current_sort === $vs_sort) {
								print "<li><a href='#'><em>{$vs_sort}</em></a></li>\n";
							} else {
								print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
							}
						}
						print "<li class='divider'></li>\n";
						print "<li class='dropdown-header'>"._t("Sort order:")."</li>\n";
						print "<li>".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc'))."</li>";
						print "<li>".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc'))."</li>";
					}
					
					if ((sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) && is_array($va_sorts) && sizeof($va_sorts)) {
?>
					<li class="divider"></li>
<?php
					}
					
					if (sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) {
						print "<li>".caNavLink($this->request, _t("Start Over"), '', '*', '*', '*', array('view' => $vs_current_view))."</li>";
					}
					if(is_array($va_export_formats) && sizeof($va_export_formats)){
						// Export as PDF links
						print "<li class='divider'></li>\n";
						print "<li class='dropdown-header'>"._t("Download results as:")."</li>\n";
						foreach($va_export_formats as $va_export_format){
							print "<li>".caNavLink($this->request, $va_export_format["name"], "", "*", "*", "*", array("view" => "pdf", "download" => true, "export_format" => $va_export_format["code"], "key" => $vs_browse_key))."</li>";
						}
					}
?>
				</ul>
			</div><!-- end btn-group -->
<?php
			}
?>
		</H1>
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
<?php
		if($vs_facet_description){
			print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
		}
?>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
<?php		
				print $this->render("Browse/browse_refine_subview_html.php");
?>	
			</div>	
		</div>
<?php
	
			//
			// Handle optional paging
			//
			$vs_page_control = '';
			switch($this->getVar('paging')){
				case 'nextprevious':
					$vs_page_control .= "<div class=\"row\"><div class=\"col-sm-12 col-md-12 col-lg-12\">";
					$vs_page_control .= '<ul class="pagination">';

					if ($vn_start > 0) {
						$vs_page_control .= "<li>".caNavLink($this->request, "<i class='fa fa-angle-double-left'></i> "._t('Previous'), 'prevNav', '*', '*', '*', array('s' => $vn_start - $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view)).'</li> ';
					}
					$vn_num_pages = ceil($qr_res->numHits() / $vn_hits_per_block);
					$vn_i = 1;
					while ($vn_num_pages > 0) {
						$vs_page_control .= "<li ".($vn_start==(($vn_hits_per_block*$vn_i)-$vn_hits_per_block) ? 'class="active"': "").">".caNavLink($this->request, $vn_i , 'nextNav', '*', '*', '*', array('s' => ($vn_hits_per_block*$vn_i)-$vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view))."</li>";
						$vn_i++;
						$vn_num_pages--;
					}					
					if (($vn_start + $vn_hits_per_block) < $qr_res->numHits()) {
						$vs_page_control .= "<li>".caNavLink($this->request, _t('Next')." <i class='fa fa-angle-double-right'></i>", 'nextNav', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view)).'</li>';
					}
					$vs_page_control .= "</ul>";
					$vs_page_control .= "</div></div>\n"; 
					
					print $vs_page_control;
					break;
				case 'letter':
?>
					<div class='alpha'> 	
<?php
						$vs_current_letter = $this->request->getParameter("l", pString);
						if (is_array($va_letters = $this->getVar('letterBar'))) {
							print "Jump To ...<br/>";
							foreach($va_letters as $vs_letter => $vn_count) {
								if ($vs_letter == $vs_current_letter) { 
									print "<strong>{$vs_letter}</strong> ";
								} else {
									print caNavLink($this->request, $vs_letter, '', '*', '*', '*', array('l' => $vs_letter, 'key' => $vs_browse_key, 'view' => $vs_current_view)).' ';
								}
							}
							$this->setVar('hits_per_block', 500);
							print "<div class='currentLetter'>".$vs_current_letter."</div>";
						}
?>
					</div>
<?php				
					break;
			}	
?>			
		<div class="row">
			<div id="browseResultsContainer">
<?php
} // !ajax

print $this->render("Browse/browse_results_{$vs_current_view}_html.php");			

if (($qr_res->numHits() > 0) && ($this->getVar('paging') === 'continuous')) {
	print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
}

if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
	</div><!-- end col-8 -->
	
	
</div><!-- end row -->	
<?php
					
				if ($this->getVar('paging') == 'nextprevious') {
					print $vs_page_control;
				}
?>

<script type="text/javascript">
<?php
	//
	// For continuous scroll add jscroll
	//
	if($this->getVar('paging') === 'continuous') {
?>
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 20,
			nextSelector: 'a.jscroll-next'
		});
	});
<?php
	}
?>
</script>
<?php
			print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>