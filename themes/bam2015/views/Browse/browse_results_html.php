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

if($vs_table == "ca_collections"){
	if($qr_res->numHits()== 0){
?>
		<H1>Your search found no results.</H1>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#collectionSearch').delay(1000).slideUp();
			});
		</script>	
<?php
	}
}
if($this->request->getParameter("openResultsInOverlay", pInteger)){
	$vn_search_id = "";  # entity_id or occurrence_id passed through to search from entity/occurrence detail pages.  It can be extracted from the search term
	# --- get the search_id from the search string
	if($vs_search){
		$vn_start_pos = strpos($vs_search, ":");
		if($vn_start_pos){
			$vn_search_id = substr($vs_search, $vn_start_pos + 1);
			$this->setVar("search_id", $vn_search_id); # --- pass through to results
		} 
		if($vs_table == 'ca_occurrences'){
			# --- these are occ results appearing on an entity detail page
			$vs_entity_role = "";
			$vs_entity_role_code = 
			# was a role passed in the filter?
			$vn_start_pos2 = strpos($vs_search, "/");
			if($vn_start_pos2){
				$vs_entity_role_code = substr($vs_search, $vn_start_pos2 + 1);
				$vs_entity_role_code = str_replace(":".$vn_search_id, "", $vs_entity_role_code);
				# --- get label for filtered upon role
				$t_rel_types = new ca_relationship_types();
				$t_rel_types->load(array("type_code" => $vs_entity_role_code));
				$vs_entity_role = $t_rel_types->get("ca_relationship_types.preferred_labels.typename");
			}
		}
	}
	if($vs_table == 'ca_occurrences'){
		$va_ent_x_occ_relationship_types = array();
		$vn_principal_artist_type_id = "";
		$rel_types = new ca_relationship_types();
		$va_ent_x_occ_relationship_types = $rel_types->getRelationshipInfo("ca_entities_x_occurrences");
		$rel_types->load(array("type_code" => "principal_artist"));
		$vn_principal_artist_type_id = $rel_types->get("type_id");
		$va_roles_for_entity = array();
		$va_roles_by_occurrence = array();
		if($vn_search_id){
			# --- get all roles/relationship types associated with the entity so can filter by role
			$t_list = new ca_lists();
 			$vn_event_id = $t_list->getItemIDFromList('occurrence_types', 'special_event');
 			$vn_production_id = $t_list->getItemIDFromList('occurrence_types', 'production');
 			$vn_work_id = $t_list->getItemIDFromList('occurrence_types', 'work');
			$o_db = new Db();
			$q_rel_type_ids = $o_db->query("
											SELECT exo.entity_id, exo.occurrence_id, exo.type_id 
											FROM ca_entities_x_occurrences exo 
											INNER JOIN ca_occurrences AS o ON exo.occurrence_id = o.occurrence_id
											WHERE exo.entity_id = ? AND o.type_id IN (".$vn_event_id.", ".$vn_production_id.", ".$vn_work_id.") AND o.access IN (".join(", ", $va_access_values).") AND o.deleted = 0
											", $vn_search_id); // (removed , ".$vn_work_id." from the o.type_id list)
			if($q_rel_type_ids->numRows()){
				while($q_rel_type_ids->nextRow()){
					if($q_rel_type_ids->get("type_id") != $vn_principal_artist_type_id){
						$va_roles_by_occurrence[$q_rel_type_ids->get("occurrence_id")][] = $va_ent_x_occ_relationship_types[$q_rel_type_ids->get("type_id")]["typename"];
						$va_roles_for_entity[$q_rel_type_ids->get("type_id")] = array("typename" => $va_ent_x_occ_relationship_types[$q_rel_type_ids->get("type_id")]["typename"], "code" => $va_ent_x_occ_relationship_types[$q_rel_type_ids->get("type_id")]["type_code"]);
					}
				}
			}
		}
		$this->setVar("entity_roles_by_occurrence", $va_roles_by_occurrence);
	}	
}
if($this->request->getParameter("detailNav", pInteger)){
	# --- this is the filter/sort nav bar above related objects and productions on production/entity detail pages.
	$vs_search_target = ""; # objects, occurrences --- used to construct links properly --- all nav links must target the container they were ajax loaded in and return the correct type of results
	$vs_load_function = ""; # js function name changes based on target to allow results for both objects and occurrences to be loaded on the same page...can't use the same function anme twice
	$vs_search_string = ""; # what are we searching by, entities of occurrences depending on what detail page we're on
	$vn_end_pos = strpos($vs_search, "/");
	if($vn_end_pos){
		$vs_search_string = substr($vs_search, 0, $vn_end_pos);
		$this->setVar("search_string", $vs_search_string); # --- pass through to results
	}else{
		$vn_end_pos = strpos($vs_search, ":");
		if($vn_end_pos){
			$vs_search_string = substr($vs_search, 0, $vn_end_pos);
			$this->setVar("search_string", $vs_search_string); # --- pass through to results
		}
	}	
	print "<H1 class='detailResults'>";
	switch($vs_table){
		case "ca_objects":
			print _t("Related Objects");
			$vs_search_target = "objects";
			$vs_load_function = "loadResults";
		break;
		# -----
		case "ca_occurrences":
			print _t("Related Productions & Events");
			$vs_search_target = "occurrences";
			$vs_load_function = "loadResultsOcc";
		break;
	}
	print "</H1>";
	print "<div class='resultsLeader'>".$qr_res->numHits()." Result".(($qr_res->numHits() == 1) ? "" : "s")."</div>";
	# --- if there are 6 or less related occ's on the entity detail page, do not show the filter navigation, only the title
	if(($vs_table == "ca_occurrences") && ($qr_res->numHits() < 7) && (sizeof($va_criteria) > 2)){
		print "<hr class='divide'/><br/>";
	}else{

?>
		<div class="container"><div class="row bNavOptions detailBrowse" style="clear:both; position:relative;">
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">FILTER BY 
<?php
		if($vs_entity_role || (sizeof($va_criteria) > 1)){
			if(sizeof($va_criteria) > 1){
				# --- check if type criteria has been selected
				foreach($va_criteria as $va_facet_criteria){
					if($va_facet_criteria["facet_name"] == "type_facet"){
						print '<div class="btn-group filterSelected"><a href="#" onClick="'.$vs_load_function.'(\''.caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\', \''.$vs_search_string.':'.$vn_search_id.'\'); return false;"><highlight>Type</highlight> '.$va_facet_criteria["value"].' <span class="icon-cross"></span></a></div>';
				
						break;
					}
				}
			}
			if($vs_entity_role){
				# --- display filtered role
				print '<div class="btn-group filterSelected"><a href="#" onClick="'.$vs_load_function.'(\''.caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\', \''.$vs_search_string.':'.$vn_search_id.'\'); return false;"><highlight>Artistic Role</highlight> '.$vs_entity_role.' <span class="icon-cross"></span></a></div>';
			}
		}else{
			if(is_array($va_facets["type_facet"]) && sizeof($va_facets["type_facet"])){
?>
				<div class="btn-group filter">
					<a href="#" data-toggle="dropdown"><highlight>Type</highlight><i class="fa fa-caret-down"></i></a>
					<ul class="dropdown-menu" role="menu">
<?php
						foreach($va_facets["type_facet"]["content"] as $vn_item_id => $va_item){
							print '<li><a href="#" onClick="'.$vs_load_function.'(\''.caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'key' => $vs_browse_key, 'facet' => 'type_facet', 'id' => $va_item['id'], 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\', \'\'); return false;">'.$va_item["label"].'</a></li>';
						}
?>
					</ul>
				</div><!-- end btn-group -->
<?php
			}
			if($vs_table == "ca_occurrences" && is_array($va_roles_for_entity) && sizeof($va_roles_for_entity)){
				# show role filter for occ results on entity detail
?>
				<div class="btn-group filter">
					<a href="#" data-toggle="dropdown"><highlight>Artistic Role</highlight><i class="fa fa-caret-down"></i></a>
					<ul class="dropdown-menu" role="menu">
<?php
						foreach($va_roles_for_entity as $vn_type_id => $va_role_info){
							print '<li><a href="#" onClick="'.$vs_load_function.'(\''.caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\', \''.$vs_search_string.'/'.$va_role_info['code'].':'.$vn_search_id.'\'); return false;">'.$va_role_info['typename'].'</a></li>';
						}
?>
					</ul>
				</div><!-- end btn-group -->
<?php
			}
		}
?>
		</div><!-- end col -->
		<div class="col-xs-7 col-sm-5 col-md-4 text-left">SORT BY 
			<div class="btn-group filter">
				<a href="#" data-toggle="dropdown"><highlight><?php print urldecode($vs_current_sort); ?></highlight><i class="fa fa-caret-down"></i></a>
				<ul class="dropdown-menu" role="menu">
<?php
					if($vs_sort_control_type == 'dropdown'){
						if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
							print "<li class='dropdown-header'>"._t("Sort by:")."</li>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li><a href='#' onClick='return false;'><em>{$vs_sort}</em></a></li>\n";
								} else {
									print '<li><a href="#" onClick="'.$vs_load_function.'(\''.caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'key' => $vs_browse_key, 'sort' => $vs_sort, 'view' => $vs_current_view), array('dontURLEncodeParameters' => true)).'\', \'\'); return false;">'.$vs_sort.'</a></li>';
								}
							}
							print "<li class='divider'></li>\n";
							print "<li class='dropdown-header'>"._t("Sort order:")."</li>\n";
							print '<li><a href="#" onClick="'.$vs_load_function.'(\''.caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'key' => $vs_browse_key, 'sort' => $vs_current_sort, 'view' => $vs_current_view, 'direction' => 'asc'), array('dontURLEncodeParameters' => true)).'\', \'\'); return false;">'.(($vs_sort_dir == 'asc') ? '<em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em>' : '').'</a></li>';
							print '<li><a href="#" onClick="'.$vs_load_function.'(\''.caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'key' => $vs_browse_key, 'sort' => $vs_current_sort, 'view' => $vs_current_view, 'direction' => 'desc'), array('dontURLEncodeParameters' => true)).'\', \'\'); return false;">'.(($vs_sort_dir == 'desc') ? '<em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em>' : '').'</a></li>';
						}
					}
?>
				</ul>
			</div><!-- end btn-group -->
		</div><!-- end col -->
		<div class="col-xs-0 col-sm-0 col-md-0 col-lg-2 blankSpace"></div>
		<div class="col-xs-5 col-sm-2 col-md-3 col-lg-2">
<?php
			print _t("View");
			if(is_array($va_views) && (sizeof($va_views) > 1)){
				foreach($va_views as $vs_view => $va_view_info) {
					if ($vs_current_view === $vs_view) {
						print '<a href="#" class="active" onCLick="return false;">'.$va_view_icons[$vs_view]['icon'].'</a> ';
					} else {
?>
						<a href="#" onClick="<?php print $vs_load_function; ?>('<?php print caNavUrl($this->request, '', 'Search', $vs_search_target, array('detailNav' => '1', 'openResultsInOverlay' => 1, 'key' => $vs_browse_key, 'view' => $vs_view), array('dontURLEncodeParameters' => true)); ?>', ''); return false;"><?php print $va_view_icons[$vs_view]['icon']; ?></a>
<?php
					}
				}
			}
?>			
		</div><!-- end col -->
	</div><!-- end row --></div><!-- end container -->
	<br/><br/>
	<script type="text/javascript">		
		function <?php print $vs_load_function; ?>(url, searchParam) {
			jQuery("#browseResultsContainer<?php print ($vs_table == ca_occurrences) ? "Occ" : ""; ?>").data('jscroll', null);
			jQuery("#browseResultsContainer<?php print ($vs_table == ca_occurrences) ? "Occ" : ""; ?>").load(url, {'search': searchParam}, function() {
				jQuery("#browseResultsContainer<?php print ($vs_table == ca_occurrences) ? "Occ" : ""; ?>").jscroll({
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
}
if (!$vb_ajax) {	// !ajax
?>
<div class="container">
<div class="row bNavOptions fullBrowse" style="clear:both; position:relative;">
	<div class="col-xs-12 col-sm-12 col-md-4">
<?php
	print $va_browse_info["displayName"]." <span class='grayText'>(".$qr_res->numHits()." result".(($qr_res->numHits() != 1 ? "s" : "")).")</span>";	
?>
	</div><!-- end col -->
	<div class="col-xs-12 col-sm-5 col-md-3">
		<form role="search" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
			<button type="submit" class="btn-search pull-right"><span class="icon-magnifier"></span></button><input type="text" class="form-control bSearchWithin" placeholder="Search within" <?php #print ($vs_search) ? "value='".$vs_search."'" : ""; ?> name="search_refine">
			<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
		</form>
	</div><!-- end col -->
	<div class="col-xs-7 col-sm-4 col-md-3">
		<div class="btn-group">
			<a href="#" data-toggle="dropdown">SORT BY <highlight><?php print urldecode($vs_current_sort); ?></highlight><i class="fa fa-caret-down"></i></a>
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
	<div class="col-xs-5 col-sm-3 col-md-2">
<?php
		print _t("View");
		if(is_array($va_views) && (sizeof($va_views) > 1)){
			foreach($va_views as $vs_view => $va_view_info) {
				if ($vs_current_view === $vs_view) {
					print '<a href="#" class="active" onClick="return false;">'.$va_view_icons[$vs_view]['icon'].'</a> ';
				} else {
					print caNavLink($this->request, $va_view_icons[$vs_view]['icon'], 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
				}
			}
		}
?>			
	</div><!-- end col -->
</div><!-- end row --></div><!-- end container -->
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
?>		
			</H5>
			</div><!-- end col -->
		</div>	
		<div class="row">
<?php
	if((sizeof($va_facets) > 0) || ((sizeof($va_criteria) > 0))){
?>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<?php print $this->render("Browse/browse_refine_subview_html.php"); ?>			
			</div>
			<div class="col-sm-8 col-md-8 col-lg-8">
<?php
	}else{
?>
			<div class="col-md-12">
<?php
	}
?>
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
			</div><!-- end col -->
		</div><!-- end row -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 60,
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
} //!ajax
?>