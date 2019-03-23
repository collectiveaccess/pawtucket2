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
	$qr_res = $this->getVar('featured_set_items_as_search_result');
	$o_config = configuration::load('../../conf/gallery.conf');
	$vs_gallery_set_type = $o_config->get("gallery_set_type");
?>
			<div class="row">
				<div class="col-sm-12">
					<h3 class="specialCollectionHead">Special Collections</h3>
				</div>
			</div>
			<div class="row featuredSets">
<?php
			$vn_setTypesID = caGetListID('set_types');
			$vn_featuredID = ca_list_items::find(['idno' => $vs_gallery_set_type, 'list_id' => $vn_setTypesID], ['returnAs' => 'firstId']);
			$qr_featured = ca_sets::find(['type_id' => $vn_featuredID], ['returnAs' => 'searchResult']);
			while($qr_featured->nextHit()){
				$vn_setID = $qr_featured->get('set_id');
				$t_set = new ca_sets($vn_setID);
				$va_items = ca_set_items::find(['set_id' => $vn_setID], ['returnAs', 'ids']);
				foreach($va_items as $vn_itemID){
					$t_item = new ca_set_items($vn_itemID);
					if($t_item->getRepresentations(['medium'])){
						$va_rep = $t_item->getRepresentations(['medium']);
						$vs_rep_link = caNavLink($this->request, $va_rep[0]['tags']['medium'], "", "", "Gallery", $vn_setID);
					}	
				}
				$vs_label_link = caNavLink($this->request, $t_set->get('ca_sets.preferred_labels'), "", "", "Gallery", $vn_setID);
				
				print "<div class='col-xs-6 col-sm-4 col-md-3'>
						<div class='featuredSet'><div class='text-center featuredSetImg'>{$vs_rep_link}</div>
                            <hr/>
                            <div class='text-center'>
                            	<h3 class='collectionTitle'>{$vs_label_link}</h3>
                            </div><!-- end bResultItemText -->
                        </div><!-- end bResultItemContent -->
                	</div><!-- end col -->";
			}

?>
			</div>