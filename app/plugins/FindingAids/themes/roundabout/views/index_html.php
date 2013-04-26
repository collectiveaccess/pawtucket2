<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_collections_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
 	$qr_results 				= $this->getVar('results');
	#$t_collection 			= $this->getVar('t_item');
	#$vn_collection_id 		= $t_collection->getPrimaryKey();
	
	#$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');


?>
	<div id="detailBody" class="findingAid">

		<h1><?php print _t('Finding Aid'); ?></h1>
		
		<div id="leftCol">	
<?php
		print "<div class='header'>"._t("About the Collection")."</div>";
		print "<div style='padding:10px 0px 10px 0px;'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc non erat a arcu dictum placerat sit amet et nibh. Vestibulum ut diam at mauris eleifend porta in non mauris. Nunc congue justo tincidunt nisl viverra gravida. Quisque quis erat quis ante euismod molestie. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>";
		
		print "<div class='header'>"._t("Scope and Content")."</div>";
		print "<div style='padding:10px 0px 10px 0px;'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc non erat a arcu dictum placerat sit amet et nibh. Vestibulum ut diam at mauris eleifend porta in non mauris. Nunc congue justo tincidunt nisl viverra gravida. Quisque quis erat quis ante euismod molestie. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>";
		while ($qr_results->nextHit()) {
			if ($qr_results->get('ca_collections.type_id') == 33919) {
				$va_col_id = $qr_results->get('ca_collections.collection_id');
				print caNavLink($this->request, $qr_results->get('ca_collections.preferred_labels'), '', 'FindingAids', 'Collection', 'Show', array('collection_id' => $va_col_id))."<br/>";
			}
		}
?>
	</div><!-- end leftCol -->
	<div id="rightCol" class="promo-block">
		<div class="shadow"></div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
	</div>		
<!-- 	<div id="rightCol">
		<div id="resultBox">
<?php
		// set parameters for paging controls view
#		$this->setVar('other_paging_parameters', array(
#			'collection_id' => $vn_collection_id
#		));
#		print $this->render('related_objects_grid.php');
?>
		</div>


	</div>end rightCol -->
</div><!-- end detailBody -->
