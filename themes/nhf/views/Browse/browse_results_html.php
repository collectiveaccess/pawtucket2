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

# --- force result view to lit_long when there are browse/search criteria passed
if(sizeof($va_criteria) == 0 && ($vs_table == "ca_collections")){
	$vs_current_view = "list";
}else{
	$vs_current_view = "list_long";
}
if (!$vb_ajax) {	// !ajax
?>
<div class="row" style="clear:both;">
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<form role="search" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
			<div class="bSearchWithinContainer">
			<input type="text" class="bSearchWithin" placeholder="Search within..." <?php #print ($vs_search) ? "value='".$vs_search."'" : ""; ?> name="search_refine"><input type="submit" name="op" id="edit-submit" value="GO"  class="form-submit" />
			<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
			</div>
		</form>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>			
	</div><!-- end col -->

	<div class='col-sm-9'>
		<div id="browseListBody"><a name="top"></a>
			<div id="title"><?php print $va_browse_info["displayName"]; ?></div>
	<?php
			if (sizeof($va_criteria) > 0) {
				print "<div id='searchFor'>Results for: ";
				$i = 0;
				foreach($va_criteria as $va_criterion) {
					#if ($va_criterion['facet_name'] != '_search') {
						print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
					#}else{
					#	print ' '.$va_criterion['value'];
					#	$vs_search = $va_criterion['value'];
					#}
					$i++;
					if($i < sizeof($va_criteria)){
						print " ";
					}
				}
				
				print "</div><div id='searchCount'>Showing ".$qr_res->numHits()." ".(($qr_res->numHits() == 1) ? $va_browse_info["labelSingular"] : $va_browse_info["labelPlural"])."</div>";
			}else{
				if($vs_table == "ca_collections"){
?>
					<div id="introText">
						We care for approximately 800 moving image collections, which would take more than a year to watch. Of these, 300+ are described online at the collection level. To read about each collection, click on the collection name.

					</div><!-- end introText -->
<?php
				}
			}

			if($vb_showLetterBar && ($vs_current_view == "list")){
				print "<div id='letterBar'>Jump to: ";
				foreach(array_keys($va_letter_bar) as $vs_l){
					if(trim($vs_l)){
						print "<a href='#".strtoupper($vs_l)."'>".strtoupper($vs_l)."</a>";
					}
				}
				print "</div>";
			}
		
?>
		<form id="setsSelectMultiple">
		<div class="row">
			<div id="list"><div id="browseResultsContainer">
<?php
} // !ajax

# --- check if this result page has been cached
# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id);
if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
	print ExternalCache::fetch($vs_cache_key, 'browse_results');
}else{
	$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
	ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results');
	print $vs_result_page;
}		

if (!$vb_ajax) {	// !ajax
?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end list -->
		</div><!-- end row -->
		</form>
	</div><!-- end col-8 -->
	
</div><!-- end row -->	
</div><!-- end browseListBody -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 1000,
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