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

	<div class="row tanBg exploreRow exploreRow exploreEduResRow">
		<div class="col-sm-12">
			<H1>Educational Resources</H1>
			<p>
				{{{edu_res_collections_intro}}}
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
				
				if(($this->request->isLoggedIn() && $this->request->user->hasRole("previewDigExh")) || (strToLower($qr_collections->get('ca_collections.preview_only', array("convertCodesToDisplayText" => true))) != "yes")){
					if($i == 0){
						print "<div class='row aligned-row'>";
					}

					$vs_image_url = $qr_collections->getWithTemplate("^ca_object_representations.media.large.url", array("checkAccess" => $va_access_values, "limit" => 1));
					
					print "<div class='col-sm-3'><div class='listingContainer listingContainerEduRes coverImg' style='background-image: url(\"".$vs_image_url."\");'>".caDetailLink($this->request, "<div class='listingContainerDesc'>
								<H2>".$qr_collections->get("ca_collections.preferred_labels.name")."</H2>
							</div>", 'listingEduResImageLink', 'ca_collections', $qr_collections->get("ca_collections.collection_id"))."</div></div>";

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