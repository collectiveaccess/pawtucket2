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
	
	$vs_table 			= $this->getVar('table');
	$t_instance			= $this->getVar('t_instance');
	
	$vb_is_search		= ($this->request->getController() == 'Search');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	
if (!$vb_ajax) {	// !ajax
		if (sizeof($va_criteria) > 0) {
			$vs_filters = '<div id="filtros-seleccionados" class="col1">';
			if (sizeof($va_criteria) > 1) {
				$vs_filters .= '<p class="gris">'._t("con tus filtros").':';
			}else{
				$vs_filters .= '<p class="gris">&nbsp;';
			}
			foreach($va_criteria as $va_criterion) {
				if ($va_criterion['facet_name'] == '_search') {
					$vs_search_text = $va_criterion['value'];
				}else{
					$vs_filters .= caNavLink($this->request, $va_criterion['value'].'<span>x</span>', 'btnFiltro', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
				}
			}
			$vs_filters .= '</p></div>';
		}
?>
	<section id="result-busqueda">
                
		<h1 class="col1"><?php print _t("%1 elementos encontrados corresponden a %2", $qr_res->numHits(), "<span class='verdeclaro'>".$vs_search_text."</span>"); ?></h1>
		<?php print $vs_filters; ?>
	</section>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>
	<section id="resultados" class="col1">
<?php
		if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
?>
			<script type="text/javascript">
				$("#orden").on("change", function() {
					$("#orderResults").submit();
				});
			</script>
<?php
			print "<form id='orderResults' action='".caNavUrl($this->request, '', '*', '*', '*')."' class='alignLeft'>";
			print '<label class="gris" for="orden">'._t("Ordenar por").'</label> ';
			print '<select name="sort" id="orden" class="gris">';
			foreach($va_sorts as $vs_sort => $vs_sort_flds) {
				print "<option value='".$vs_sort."' ".(($vs_current_sort === $vs_sort) ? "selected" : "").">".$vs_sort."</option>";
			}
			print "</select>";
			print "<input type='hidden' name='key' value='".$vs_browse_key."'>";
			print "<input type='hidden' name='view' value='".$vs_view."'>";
			print "</form>";
		}
		print caNavLink($this->request, _t('ordenar en iconos'), 'items square alignLeft '.(($vs_current_view == 'images') ? 'active':''), '*', '*', '*', array('view' => 'images', 'key' => $vs_browse_key));
		print caNavLink($this->request, _t('ordenar en lista'), 'items list alignLeft '.(($vs_current_view == 'list') ? 'active':''), '*', '*', '*', array('view' => 'list', 'key' => $vs_browse_key));
?>
		
		<p id="page" class="alignRight">página <span class="caja">1</span> de 34</p>
		<div class="articulos">
			<div class="articleBusquedas alignLeft" id="browseResultsContainer">
<?php
} // !ajax

print $this->render("Browse/browse_results_{$vs_current_view}_html.php");			

if (!$vb_ajax) {	// !ajax
?>
			</div>
		</div>
	</section>
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