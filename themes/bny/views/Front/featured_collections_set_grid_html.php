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
	$va_access_values = $this->getVar("access_values");
	$featured_ids = $this->getVar('featured_set_item_ids');
	if(is_array($featured_ids) && sizeof($featured_ids)){
		$qr_res = caMakeSearchResult('ca_collections', $featured_ids);
		if($qr_res && $qr_res->numHits()){
?>
<div class="container">	
	<div class="row justify-content-center text-center">
		<div class="col-md-10 hpExplore my-5 py-5">
			<H2 class="mb-3">Explore The Collections</H2>
			<div class="row">
<?php
			$i = $vn_col = 0;
			while($qr_res->nextHit()){
				if(!($vs_thumbnail = $qr_res->get("ca_object_representations.media.medium", array("checkAccess" => $va_access_values, "class" => "object-fit-cover w-100 shadow")))){
					$vs_thumbnail = $qr_res->getWithTemplate("<unit relativeTo='ca_objects' length='1'><ifdef code='ca_object_representations.media.medium'>^ca_object_representations.media.medium</ifdef></unit>", array("checkAccess" => $va_access_values, "class" => "object-fit-cover w-100 shadow"));
				}
				print "<div class='col-md-4'>".$qr_res->getWithTemplate("<l class='text-decoration-none'>".$vs_thumbnail."<div class='pt-2 pb-5 text-start fw-medium display-6'>^ca_collections.preferred_labels.name</div></l>")."</div>";
				$i++;
				if($i == 6){
					break;
				}
			}
?>
			</div>
			<?= caNavLink($this->request, "All Collections", "btn btn-primary w-auto", "", "Browse", "collections"); ?>
		</div>
	</div>
</div>
<?php
		}
	}
?>