<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/listing_html : 
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 	$qr_collections = $this->getVar("collection_results");
 	$va_access_values = $this->getVar("access_values");
?>

	<div class="row tanBg exploreRow exploreRow exploreCommunityCollectionRow">
		<div class="col-sm-12">
			<H1>Community Collections</H1>
			<p>
				{{{community_collections_intro}}}
			</p>
		</div>
	</div>
<?php
		if($qr_collections->numHits()){
?>
		<div class='row'>
			<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php
			$i = 0;	
			while($qr_collections->nextHit()) {
				
				if($this->request->isLoggedIn()){
					if($i == 0){
						print "<div class='row'>";
					}

					print "<div class='col-sm-12'><div class='communityCollectionsListing'>";
					print caDetailLink($this->request, "<H2>".$qr_collections->get("ca_collections.preferred_labels.name")."</H2>", '', 'ca_collections', $qr_collections->get("ca_collections.collection_id"));
					print $qr_collections->getWithTemplate("<ifdef code='ca_collections.description_new.description_new_txt'><div class='exploreCommunityCollectionDesc'>^ca_collections.description_new.description_new_txt%ellipsis=1&truncate=500</div></ifdef>");
					print "<div class='text-center'>".caDetailLink($this->request, "Learn More", 'btn btn-default', 'ca_collections', $qr_collections->get("ca_collections.collection_id"))."</div>";
					print "</div></div>";

					$i++;
					if($i == 4){
						print "</div>";
						$i = 0;
					}
				}

			
			}
			if($i > 0){
				print "</div>";
			}
?>
			</div>
		</div>
<?php
	}
?>