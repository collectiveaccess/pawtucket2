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
	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
if($this->request->getParameter("detailNav", pInteger)){
?>
	<div class="container"><div class="row bNavOptions" style="clear:both; position:relative;">
	<div class="col-xs-12 col-sm-2">
<?php
	print _t("Related objects");	
?>
	</div><!-- end col -->
	<div class="col-xs-12 col-sm-8 text-center bNavOptionsFilterList">
<?php
	if (sizeof($va_criteria) > 1) {
		foreach($va_criteria as $va_criteria_info){
			if($va_criteria_info["facet_name"] == "type_facet"){
				print _t("Filtering by")." <i>".$va_criteria_info["value"]."</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
?>
		<a href="#" onClick="loadResults('<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'search' => $this->request->getParameter("search", pString), 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)); ?>'); return false;">View All</a>
<?php
	}else{
		if(is_array($va_facets["type_facet"]) && sizeof($va_facets["type_facet"])){
			print _t("FILTER");
			foreach($va_facets["type_facet"]["content"] as $vn_item_id => $va_item){
?>
				<a href="#" onClick="loadResults('<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'key' => $vs_browse_key, 'facet' => 'type_facet', 'id' => $va_item['id'], 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)); ?>'); return false;"><?php print $va_item["label"]; ?></a>
<?php
			}
		}
	}
?>
	</div><!-- end col -->
	<div class="col-xs-12 col-sm-2">
<?php
		print _t("View");
		if(is_array($va_views) && (sizeof($va_views) > 1)){
			foreach($va_views as $vs_view => $va_view_info) {
				if ($vs_current_view === $vs_view) {
					print '<a href="#" class="active">'.$va_view_icons[$vs_view]['icon'].'</a> ';
				} else {
?>
					<a href="#" onClick="loadResults('<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'key' => $vs_browse_key, 'view' => $vs_view), array('dontURLEncodeParameters' => true)); ?>'); return false;"><?php print $va_view_icons[$vs_view]['icon']; ?></a>
<?php
				}
			}
		}
?>			
	</div><!-- end col -->
</div><!-- end row --></div><!-- end container -->
<br/><br/>
<script type="text/javascript">		
	function loadResults(url) {
		jQuery("#browseResultsContainer").data('jscroll', null);
		jQuery("#browseResultsContainer").load(url, function() {
			jQuery("#browseResultsContainer").jscroll({
				autoTrigger: true,
				loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
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
<div class="container">
<div class="row bNavOptions" style="clear:both; position:relative;">
	<div class="col-xs-12 col-sm-2">
<?php
	print _t("Results")."&nbsp;&nbsp;&nbsp;<span class='highlight'>".$qr_res->numHits()."</span>";	
?>
	</div><!-- end col -->
<?php
	if(is_array($va_facets) && sizeof($va_facets)){
?>
	<div class="col-xs-12 col-sm-2">
		<a href="#" onClick="jQuery('#bRefineContainer').toggle();">BROWSE<i class="fa fa-caret-down"></i></a>
	</div><!-- end col -->
<?php
	}else{
?>
		<div class="col-xs-12 col-sm-2">
		<?php print caNavLink($this->request, _t("View All"), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1)); ?>
		</div><!-- end col -->
<?php
	}
?>
	<div class="col-xs-12 col-sm-2">
		<div class="btn-group">
			<a href="#" data-toggle="dropdown">SORT<i class="fa fa-caret-down"></i></a>
			<ul class="dropdown-menu" role="menu">
<?php
				if($vs_sort_control_type == 'dropdown'){
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
				}
?>
			</ul>
		</div><!-- end btn-group -->
	</div><!-- end col -->
<?php
	$vs_search = "";
	if (sizeof($va_criteria) > 0) {
		foreach($va_criteria as $va_criterion) {
			if ($va_criterion['facet_name'] == '_search') {
				$vs_search = $va_criterion['value'];
				break;
			}
		}
		reset($va_criteria);
	}
?>
	<div class="col-xs-12 col-sm-4">
		<form role="search" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
			<button type="submit" class="btn-search pull-right"><span class="icon-magnifier"></span></button><input type="text" class="form-control bSearchWithin" placeholder="<?php print ($vs_search) ? $vs_search : "Search"; ?>" name="search">
			<!--<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
			<input type="hidden" name="facet" value="_search">-->
		</form>
	</div><!-- end col -->
	<div class="col-xs-12 col-sm-2">
<?php
		print _t("View");
		if(is_array($va_views) && (sizeof($va_views) > 1)){
			foreach($va_views as $vs_view => $va_view_info) {
				if ($vs_current_view === $vs_view) {
					print '<a href="#" class="active">'.$va_view_icons[$vs_view]['icon'].'</span></a> ';
				} else {
					print caNavLink($this->request, $va_view_icons[$vs_view]['icon'], 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
				}
			}
		}
?>			
	</div><!-- end col -->
</div><!-- end row --></div><!-- end container -->
<div class="container" style="position:relative;">
	<div class="row" id="bRefineContainer">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-2 borderTop"></div>
				<div class="col-xs-12 col-sm-2"></div>
				<div class="col-xs-12 col-sm-8 borderTop"></div>
			</div>
			<?php print $this->render("Browse/browse_refine_subview_html.php"); ?>
		</div>
	</div><!-- end row --></div>
		<div class="row">
			<div class="col-xs-12">
			<H5>
<?php
		if($vs_table == 'ca_objects'){
?>
			<div class="pull-right">
				<div class="btn-group pull-right">
					<span class="glyphicon glyphicon-heart bGear" data-toggle="dropdown"></span>
					<ul class="dropdown-menu" role="menu">
<?php
						if($qr_res->numHits() && (is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info))){
							print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveLastResults" => 1))."\"); return false;'>"._t("Add all results to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
							print "<li><a href='#' onclick='jQuery(\".bSetsSelectMultiple\").toggle(); return false;'>"._t("Select results to add to %1", $va_add_to_set_link_info['name_singular'])."</a></li>";
						}
					
?>
					</ul>
				</div><!-- end btn-group -->
<?php
			if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
				print "<a href='#' class='bSetsSelectMultiple' id='bSetsSelectMultipleButton' onclick='jQuery(\"#setsSelectMultiple\").submit(); return false;'><button type='button' class='btn btn-default btn-sm bCriteria'>"._t("Add selected results to %1", $va_add_to_set_link_info['name_singular'])."</button></a>";
			}
?>			
			</div>
<?php
		}
		if (sizeof($va_criteria) > 1) {
			$i = 0;
			print "<strong>"._t("Filtering by").":</strong>";
			foreach($va_criteria as $va_criterion) {
				if ($va_criterion['facet_name'] != '_search') {
					print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm bCriteria">'.$va_criterion['value'].' <span class="icon-cross"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
				}else{
					#print ' '.$va_criterion['value'];
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
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
		<form id="setsSelectMultiple">
		<div class="row">
			<div id="browseResultsContainer">
<?php
} // !ajax

print $this->render("Browse/browse_results_{$vs_current_view}_html.php");			

if (!$vb_ajax) {	// !ajax
?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		</form>
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
</div>
<?php
			#print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>