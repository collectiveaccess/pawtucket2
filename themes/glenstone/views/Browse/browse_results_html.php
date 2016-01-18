<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
	$va_browse_name 	= $this->getVar('name');
	
	$vs_current_sort	= $this->getVar('sort');
	$vs_sort_dir		= $this->getVar('sort_direction');
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	$va_browse_info 	= $this->getVar("browseInfo");
	
	$va_export_formats = $this->getVar('export_formats');
	$vs_export_format_select = $this->getVar('export_format_select');
	
		
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_displayname = $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	
if (!$vb_ajax) {	// !ajax
?>
<div id="bViewButtons">
<?php

	foreach($va_views as $vs_view => $va_view_info) {
		if ($vs_current_view === $vs_view) {
			print '<a href="#" class="active"><span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span></a> ';
		} else {
			print caNavLink($this->request, '<span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
		}
	}
if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
	// Export as PDF
	print "<div class='reportTools'>";
	print caFormTag($this->request, 'view/pdf', 'caExportForm', ($this->request->getModulePath() ? $this->request->getModulePath().'/' : '').$this->request->getController().'/'.$this->request->getAction(), 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
	print caHTMLHiddenInput('key', array('value' => $vs_browse_key));
	print "{$vs_export_format_select}".caFormSubmitLink($this->request, _t('Download'), 'button', 'caExportForm')."</form>\n";
	print "</div>"; 
}	  
?>
</div>		
<H1>
<?php 
	if ($t_instance->getProperty('NAME_SINGULAR') == "object") {
		print _t('%1 %2 %3', $qr_res->numHits(), ucwords($va_browse_info['displayName']), ($qr_res->numHits() == 1) ? _t("Result") : _t("Results"));
	} else {
		print _t('%1 %2 %3', $qr_res->numHits(), ucwords($t_instance->getProperty('NAME_SINGULAR')), ($qr_res->numHits() == 1) ? _t("Result") : _t("Results"));		
	}
?>		
	<div class="btn-group">
		<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
		<ul class="dropdown-menu" role="menu">
<?php
			if($qr_res->numHits()){
				print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array("saveLastResults" => 1))."\"); return false;'>"._t("Add all results to %1", $vs_lightbox_displayname)."</a></li>";
				print "<li><a href='#' onclick='jQuery(\".bSetsSelectMultiple\").toggle(); return false;'>"._t("Select results to add to %1", $vs_lightbox_displayname)."</a></li>";
				print "<li class='divider'></li>";
			}
			if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
				foreach($va_sorts as $vs_sort => $vs_sort_flds) {
					if ($vs_current_sort === $vs_sort) {
						print "<li><a href='#'><em>{$vs_sort}</em></a></li>\n";
					} else {
						print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
					}
				}
			}
			
			if ((sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) && is_array($va_sorts) && sizeof($va_sorts)) {
?>
			<li class="divider"></li>
<?php
			}
			
			if (sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) {
				print "<li>".caNavLink($this->request, _t("Start Over"), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1))."</li>";
			}
?>
		</ul>
	</div><!-- end btn-group -->
<?php
		print "<a href='#' class='bSetsSelectMultiple' id='bSetsSelectMultipleButton' onclick='jQuery(\"#setsSelectMultiple\").submit(); return false;'><button type='button' class='btn btn-default btn-sm'>"._t("Add selected results to %1", $vs_lightbox_displayname)."</button></a>";
?>
</H1>
<div class="row" style="clear:both;">
	<div class='col-xs-9 col-sm-9 col-md-9 col-lg-9'>
		<H5>
<?php
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			foreach($va_criteria as $va_criterion) {
				if ($va_criterion['facet_name'] != '_search') {
					print "<strong>".$va_criterion['facet'].':</strong> '.$va_criterion['value'];
					print ' '.caNavLink($this->request, '<span class="glyphicon glyphicon-remove-circle"></span>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
				} else {
					print "<strong>".$va_criterion['facet'].':</strong> '.SearchEngine::getSearchExpressionForDisplay($va_criterion['value'], $vs_table);
				}
				$i++;
				if($i < sizeof($va_criteria)){
					print ", ";
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
	</div><!-- end col-10 -->
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
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
		
		jQuery('#setsSelectMultiple input:checkbox').bind('change', function(e) {
			var c = jQuery.cookieJar('lastChecked');
			c.set(jQuery(this).attr('id'), jQuery(this).prop('checked'));
		});
		
		jQuery('#setsSelectMultiple input:checkbox').each(function() {
			var c = jQuery.cookieJar('lastChecked');
			if (c.get(jQuery(this).attr('id'))) {
				c.set(jQuery(this).prop('checked', 1));
				jQuery('#bSetsSelectMultipleButton').show();
				jQuery(".bSetsSelectMultiple").show();
			}
		});
		
		jQuery('#setsSelectMultiple').submit(function(e){		
			objIDs = [];
			jQuery('#setsSelectMultiple input:checkbox:checked').each(function() {
			   objIDs.push($(this).val());
			});
			objIDsAsString = objIDs.join(';');
			caMediaPanel.showPanel('<?php print caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array("saveSelectedResults" => 1)); ?>/object_ids/' + objIDsAsString);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
			print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>