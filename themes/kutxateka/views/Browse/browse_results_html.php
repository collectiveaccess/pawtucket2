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
                
		<h1 class="col1">
<?php
		if($qr_res->numHits() == 1){
			print _t("%1 elemento encontrado corresponde a %2", $qr_res->numHits(), "<span class='verdeclaro'>".$vs_search_text."</span>");
		}else{
			print _t("%1 elementos encontrados corresponden a %2", $qr_res->numHits(), "<span class='verdeclaro'>".$vs_search_text."</span>");
		}
		print "</h1><div style='clear:both;'></div>";
		print $vs_filters;
?>
	</section>
<?php
		print $this->render("Browse/browse_refine_subview_html.php");
?>
	<section id="resultados" class="col1">
		<div id="browseResultsContainer">
<?php
} // !ajax

	if($qr_res->numHits()){
		# --- get the number of pages
		$vn_num_pages = ceil($qr_res->numHits()/$vn_hits_per_block);
		$vn_cur_page = ($vn_start/$vn_hits_per_block) + 1;
			
		if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
			print "<form id='orderResults' action='".caNavUrl($this->request, '', '*', '*', '*')."' class='alignLeft'>";
			print '<label class="gris" for="orden">'._t("Ordenar por").'</label> ';
			print '<select name="sort" id="orden" class="gris" onchange="this.form.submit();">';
			foreach($va_sorts as $vs_sort => $vs_sort_flds) {
				print "<option value='".$vs_sort."' ".(($vs_current_sort === $vs_sort) ? "selected" : "").">".$vs_sort."</option>";
			}
			print "</select>";
			print "<input type='hidden' name='key' value='".$vs_browse_key."'>";
			print "<input type='hidden' name='view' value='".$vs_view."'>";
			print "</form>";
		}
		print caNavLink($this->request, _t('ordenar en iconos'), 'items square alignLeft '.(($vs_current_view == 'images') ? 'active':''), '*', '*', '*', array('view' => 'images', 'key' => $vs_browse_key), array('title' => _t('ordenar en iconos')));
		print caNavLink($this->request, _t('ordenar en lista'), 'items list alignLeft '.(($vs_current_view == 'list') ? 'active':''), '*', '*', '*', array('view' => 'list', 'key' => $vs_browse_key), array('title' => _t('ordenar en lista')));
?>		
		<p id="page" class="alignRight">
<?php
			print "<form id='jumpPage' action='".caNavUrl($this->request, '', '*', '*', '*')."' class='alignRight'>";
			print _t("página").' <input type="text" class="caja" name="page" id="jumpToPageInput" value="'.$vn_cur_page.'" size="1"> '._t("de").' '.$vn_num_pages;
?>
			</form>
			<script type='text/javascript'>	
				jQuery(document).ready(function() {
					jQuery('#jumpPage').submit(function(e){		
						var s;
						s = (jQuery('#jumpToPageInput').val() * <?php print $vn_hits_per_block; ?>) - <?php print $vn_hits_per_block; ?>;
						
						jQuery('#browseResultsContainer').load(
							'<?php print caNavUrl($this->request, '*', '*', '*'); ?>/s/' + s + '/key/<?php print $vs_browse_key; ?>/view/<?php print $vs_current_view; ?>'
						);
						e.preventDefault();
						return false;
					});
				});
			</script>
		</p>
		<div style="clear:both;">
			<div class="articleBusquedas alignLeft">
<?php
print $this->render("Browse/browse_results_{$vs_current_view}_html.php");			
?>
		</div><!-- end articulos -->
	</div><!-- end articleBusquedas -->
<?php
	}

if (!$vb_ajax) {	// !ajax
?>
		</div>
	</section>	
<div id="multiSearchResults" style="clear:both;"></div>	
	
<script type='text/javascript'>	
	jQuery(document).ready(function() {			
		jQuery('#multiSearchResults').load(
			'<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index', array('search' => $vs_search_text)); ?>'
		);
		return false;
	});
</script>
<?php
} //!ajax
?>