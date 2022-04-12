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
		
		include_once(__CA_LIB_DIR__."/Search/CollectionSearch.php");		
		$va_access_values = $this->getVar("access_values");
		$qr_res = $this->getVar('featured_set_items_as_search_result');
	
		
?>
<div class="container">
	<div class='row'>
		<div class='col-sm-10 spotlight'>
			<div class='leaderText'>
				<h1>Fabric of Digital Life</h1>
				<p>Fabric of Digital Life is a cultural analytics database that tracks the emergence of embodied computing platforms.</p>
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
<?php
		print $this->render("Front/sidebar.php");
?>

				
	</div><!--end row-->
</div> <!--end container-->
