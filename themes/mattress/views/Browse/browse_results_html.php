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
	$va_browse_name 	= $this->getVar('name');				// array of available browse facets	
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	
if (!$vb_ajax) {	// !ajax
?>
<div id='browseResults'>	

	<div  style="clear:both;">
	
		<div class="blockTitle">
<?php
			print "Browse ".ucfirst($va_browse_name);
			print "<div class='resultCount'>"._t('%1 %3', $qr_res->numHits(), $t_instance->getProperty('NAME_SINGULAR'), ($qr_res->numHits() == 1) ? _t("Result") : _t("Results"))."</div>";	

			print $this->render("Browse/browse_refine_subview_html.php");
		
?>			
		</div><!-- end blockTitle -->
			

			
		<div id="contentArea">
			<div id="browseHeader">
			<div id="bViewButtons">
<?php		
			if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts) > 1) {
?>						
				<div class="btn-group">
					<span class='sortBy'>sort by:</span>
					<ul class="dropdown-menu" role="menu">
<?php
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li><a href='#' style='color:#EE3E43;'>{$vs_sort}</a></li>\n";
								} else {
									print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
								}
							}	
?>
					</ul>
				</div><!-- end btn-group -->	
<?php
			} // if sortBy	

			foreach($va_views as $vs_view) {
				if ($vs_current_view === $vs_view) {
					print '<a href="#" class="active"><span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span></a> ';
				} else {
					print caNavLink($this->request, '<span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
				}
			}
?>
			</div><!-- bViewButtons -->		
			
<?php
			if (sizeof($va_criteria) > 0) {
				print "<H2>";
				$i = 0;
				foreach($va_criteria as $va_criterion) {
					print "<span class='criteria'>".$va_criterion['facet'].'</span><span class="facet"> '.$va_criterion['value'].'</span>';
					if ($va_criterion['facet_name'] != '_search') {
						print caNavLink($this->request, "X", 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
					}
					$i++;
					if($i < sizeof($va_criteria)){
						print " ";
					}
				}
				if (sizeof($va_criteria) > ($vb_is_search ? 1 : 0)) {
					print "<span class='startOver'>".caNavLink($this->request, _t("Start Over"), '', '*', '*', '*', array('view' => $vs_current_view))."</span>";
				}
				print "</h2>";
			}
?>		
			</div><!-- browseHeader-->
			<div >
				<div id="browseResultsContainer ">
<?php

} // !ajax

print $this->render("Browse/browse_results_{$vs_current_view}_html.php");			

if (!$vb_ajax) {	// !ajax
?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
		</div><!-- end content -->
	</div><!-- end row -->
</div><!-- end browseResults -->	

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
			print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>