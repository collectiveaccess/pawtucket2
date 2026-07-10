<?php
/** ---------------------------------------------------------------------
 * themes/whha/Occupations/occupations_html : List of occupations to launch worker browses 
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
	$qr_results = $this->getVar("results");
	$facet = $this->getVar("facet");
	if($qr_results->numHits()){
?>
<div class="container">
	<div class="row justify-content-center text-center">
		<div class="col-md-10 hpExplore py-5">

			<div class="row justify-content-center">
<?php
		while($qr_results->nextHit()){
			if(!($img = $qr_results->get("ca_list_items.icon.original", array("class" => "object-fit-cover w-100 shadow")))){
				$img = caGetThemeGraphic($this->request, "explore_workers.jpg", array("alt" => "explore workers", "class" => "object-fit-cover w-100 shadow"));
			}
			print "<div class='col-md-6 col-lg-3 pb-5 pb-lg-0 mb-4'>".
					caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".$img."</div><div class='exploreItemLabel'>".$qr_results->get("ca_list_item_labels.name_plural")."</div></div>", "text-decoration-none h-100 bg-black d-block", "", "Browse", "workers", array("facet" => $facet, "id" => $qr_results->get("ca_list_items.item_id")))
				."</div>";
		}
?>
			</div>
		</div>
	</div>
</div>

<?php
	}
?>