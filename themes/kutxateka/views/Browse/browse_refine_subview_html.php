<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
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
 
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_key 			= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vs_view			= $this->getVar('view');
	
	$vn_facet_count = 0;
	if(is_array($va_facets) && sizeof($va_facets)){
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
			if(!$vn_heading_output){
				$vn_heading_output = 1;
?>
	<section id="filtros">
		<div class="col1">
			<p class="pestana alignLeft"><?php print _t("Añade otros filtros"); ?>:</p>
			<div class="mascara" style="clear:left;">
				<div class="articulos">
<?php
			}
			
			print "<div class='filters scrollArea'><p>".$va_facet_info['label_singular']."</p><ul>"; 
			
			$vn_facet_size = sizeof($va_facet_info['content']);
			$vn_c = 0;
			foreach($va_facet_info['content'] as $va_item) {
				print "<li>".caNavLink($this->request, $va_item['label'], 'verde', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</li>";
			}
			print "</ul></div>";
			$vn_facet_count++;
		}
		if($vn_heading_output){
?>
				</div>
			</div>
<?php
			if($vn_facet_count > 4){
?>
			<a href="buscar.php#" class="items btnLeft botonIzq">left</a>
                    
			<a href="buscar.php#" class="items btnRight botonDer">right</a>
<?php
			}
?>
		</div>
	</section>
<?php
		}
	}
?>