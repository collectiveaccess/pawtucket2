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
 
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	$va_access_values = caGetUserAccessValues($this->request);
?>
	<div class="row artistList">
		<div class="col-sm-12">
			<div class="leader ltGrayBg">
				<H1>THE KENTLER FLATFILES</H1>
				<p>
					The Kentler Flatfiles have been an essential element of Kentler International Drawing Space since its founding in 1990. The archive contains more than 2,500 artworks by artists from around the world, representing the incredible variety of contemporary drawing and works on paper. Flatfiles artworks are housed in our showroom and are exhibited regularly. The holdings are available for onsite viewing and purchase; 65% of each sale goes to the artist with 35% supporting Kentler’s nonprofit mission. Please <a href="mailto:info@kentlergallery.org?subject=Kentler Flatfiles Inquiry." style="text-decoration:underline;">contact</a> the gallery to schedule an appointment or inquire about pricing.
				</p>
				<H2>FLATFILES DIGITAL ARCHIVE</H2>
				<p>
					The Flatfiles Digital Archive, providing full online access to the Flatfiles collection, was made possible by an ArtWorks grant from the National Endowment for the Arts in 2015. The Digital Archive is a critical piece of Kentler’s mission to promote drawings and works on paper, educate the public and support working artists. Thank you for your patience as we work towards a complete representation of all current and historic holdings.
				</p>
			</div>
		</div>
	</div>
<?php
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		$va_ids = array();
		$va_letters = array();
		while($qr_list->nextHit()) {
			$va_ids[] = $qr_list->get("entity_id");
			$va_letters[strtoupper(mb_substr($qr_list->get("ca_entities.preferred_labels.surname"),0,1))] = strtoupper(mb_substr($qr_list->get("ca_entities.preferred_labels.surname"),0,1));	
		}
		if(is_array($va_letters) && sizeof($va_letters)){
			print "<div class='row'><div class='col-sm-12 artistListLetterBar'>";
			foreach($va_letters as $vs_letter){
				print "<a href='#artistLetter".$vs_letter."' class='openSansBold'>".$vs_letter."</a>";
			}
			print "</div></div>";
		}
		print "<div class='row artistList'>";
		$qr_list->seek(0);
		#$va_images = caGetDisplayImagesForAuthorityItems("ca_entities", $va_ids, array('version' => 'thumbnail300', 'relationshipTypes' => array("creator_website"), 'checkAccess' => $va_access_values));
		while($qr_list->nextHit()) {
			$vs_letter = strtoupper(mb_substr($qr_list->get("ca_entities.preferred_labels.surname"),0,1));
			if($vs_letter != $vs_last_letter){
				print "<div class='col-sm-12 artistListLetterSection'><a name='artistLetter".$vs_letter."' ></a><span class='artistListLetter redBg openSansBold'>".$vs_letter."</span></div>";
			}
			print "<div class='col-sm-3 artistListing'>".caDetailLink($this->request, $va_images[$qr_list->get("entity_id")], '', 'ca_entities', $qr_list->get("entity_id"))."<h2>".$qr_list->getWithTemplate('<l>^ca_entities.preferred_labels.displayname</l>', null, null, array("type_id" => $qr_list->get("type_id")))."</h2></div>\n";	
			$vs_last_letter = $vs_letter;
		}
		print "</div><!-- end row -->\n";
	}
?>