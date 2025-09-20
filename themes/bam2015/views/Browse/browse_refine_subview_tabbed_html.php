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
	$vs_browse_type		= $this->getVar('browse_type');
	$o_browse			= $this->getVar('browse');
	
	$vn_facet_display_length_initial = 7;
	$vn_facet_display_length_maximum = 60;
?>
	<div class="container" style="position:relative;">
	<div class="row" id="bRefineContainer">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-3 borderTop"></div>
				<div class="col-xs-12 col-sm-2"></div>
				<div class="col-xs-12 col-sm-7 borderTop"></div>
			</div>
			
<?php
	if(is_array($va_facets) && sizeof($va_facets)){
		#print "<div id='bMorePanel'><!-- long lists of facets are loaded here --></div>";
?>
		<!-- Nav tabs -->
 		 <ul class="nav nav-tabs" role="tablist">
<?php	 
		 $i = 1;
		 foreach($va_facets as $vs_facet_name => $va_facet_info) {
	 		if (is_array($va_facet_info['content']) && sizeof($va_facet_info['content'])) {
	 			print "<li role='presentation' ".(($i == 1) ? "class='active'" : "")."><a href='#".$vs_facet_name."' aria-controls='".$vs_facet_name."' role='tab' data-toggle='tab'>".$va_facet_info['label_singular']."</a></li>";
		 		$i++;
		 	}
		 }
?>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
<?php	 
		 $i = 1;
		 foreach($va_facets as $vs_facet_name => $va_facet_info) {	 		
	 		if (is_array($va_facet_info['content']) && sizeof($va_facet_info['content'])) {
	 			print "<div role='tabpanel' class='tab-pane ".(($i == 1) ? "active" : "")."' id='".$vs_facet_name."'><div class='row'>";
				switch($va_facet_info["group_mode"]){
					case "alphabetical":
					case "list":
					default:
						$vn_facet_size = sizeof($va_facet_info['content']);
						$vn_c = 0;
						foreach($va_facet_info['content'] as $va_item) {
							print "<div class='col-xs-12 col-sm-3 bFacetItem'>".caNavLink($this->request, $va_item['label'], '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
							$vn_c++;
						}
					break;
					# ---------------------------------------------
				}
				print "</div></div>";
	 			$i++;
			}
		 }
?>		
		</div>

<?php
	}
?>
		</div>
	</div><!-- end row -->
</div><!-- end container -->