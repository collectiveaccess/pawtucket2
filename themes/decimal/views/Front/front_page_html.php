<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
		#print $this->render("Front/featured_set_slideshow_html.php");
		
		include_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");		
		$va_access_values = $this->getVar("access_values");
		$qr_res = $this->getVar('featured_set_items_as_search_result');
	
		
?>
<div class="container">
	<div class='row'>
		<div class='col-sm-10 spotlight'>
			<div class='leaderText'>
				<h1>Fabric of Digital Life</h1>
				<p>Fabric of Digital Life is a digital humanities archive that tracks the emergence of human-computer interaction platforms.</p>
				<!--<div class="cycle-prev" id="prev"><i class="fa fa-angle-left"></i></div>
				<div class="cycle-next" id="next"><i class="fa fa-angle-right"></i></div>-->
			</div>	
			<div style="height:25px;"></div>
			<div class="cycle-slideshow" 
				data-cycle-fx=fade
				data-cycle-speed="400"
				data-cycle-pager=".example-pager"
				data-cycle-slides="> div"
				data-cycle-prev="#prev"
				data-cycle-next="#next"
				>
<?php	
				if ($qr_res) {
					while($qr_res->nextHit()) {		
						print "<div class='slide'>".caNavLink($this->request, $qr_res->get('ca_object_representations.media.slideshow'), '', '', 'Detail', 'objects/'.$qr_res->get('ca_objects.object_id'));
						print "<div class='slideCaption'>".caNavLink($this->request, $qr_res->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$qr_res->get('ca_objects.object_id'))."</div>"; 
						print "</div>";
					}
				}
?>
				</div>
			<div class="example-pager"></div>		
		</div>
		<div class='col-sm-2 platforms'>
			<h2>HCI Platforms</h2>
<?php
			print "<div>".caNavLink($this->request, 'Carryable', 'platformLink', '', 'Search', 'objects/search/ca_objects.use:carryable')."</div>";
			print "<div>".caNavLink($this->request, 'Wearable', 'platformLink', '', 'Search', 'objects/search/ca_objects.use:wearable')."</div>";
			print "<div>".caNavLink($this->request, 'Implantable', 'platformLink', '', 'Search', 'objects/search/ca_objects.use:implantable')."</div>";
			print "<div>".caNavLink($this->request, 'Ingestible', 'platformLink', '', 'Search', 'objects/search/ca_objects.use:ingestible')."</div>";
			print "<div>".caNavLink($this->request, 'Bionic', 'platformLink', '', 'Search', 'objects/search/ca_objects.use:bionic')."</div>";

			print "<h2>Curated Collections</h2>";
			$o_collection_search = new CollectionSearch();
			$qr_collections = ca_collections::find(['display_homepage' => 'yes', 'access' => 1], ['returnAs' => 'searchResult']); //$o_collection_search->search("ca_collections.display_homepage:yes", array("checkAccess" => $va_access_values));
			$vn_i = 0;
			while ($qr_collections->nextHit()) {
				print "<div>".caNavLink($this->request, $qr_collections->get('ca_collections.preferred_labels'), 'platformLink', '', 'Browse', 'objects/facet/collection_facet/id/'.$qr_collections->get('ca_collections.collection_id'))."</div>";
				$vn_i++;
				if ($vn_i == 5) {
					break;
				}
			}
?>
			<div style="clear:both; height:1px;"><!-- empty --></div>
		</div>

				
	</div><!--end row-->
</div> <!--end container-->
