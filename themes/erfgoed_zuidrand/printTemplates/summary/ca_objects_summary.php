<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Object tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");
	$va_access_values = caGetUserAccessValues($this->request);

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="title">
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
	</div>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "small"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print "<img src='".$va_rep['paths']['thumbnail']."'>\n";
		}else{
			# --- one rep - show medium rep
			print "<img src='".$va_rep['paths']['small']."'>\n";
		}
	}
?>
	</div>
	<div class='tombstone'>
<?php
				if($vn_collection_id = $t_item->get("ca_objects.object_collection.collection_id", array("checkAccess" => $va_access_values))){
					print "<div class='unit'><H6>Collectie</H6>";
					print $t_item->get("ca_objects.object_collection.preferred_labels.name", array("checkAccess" => $va_access_values));
					print "</div>";
				}
				
?>
				{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Inventarisnummer</H6>^ca_objects.idno</div></ifdef>}}}
				<HR>
				{{{<ifdef code="ca_objects.content_description">
					<div class='unit'><H6>Beschrijving</H6>
						<span class="trimText"><unit relativeTo="ca_objects.content_description" delimiter="<br/><br/>">^ca_objects.content_description</unit></span>
					</div>
				</ifdef>}}}
<?php
				if($va_list_items = $t_item->get("ca_list_items", array("returnWithStructure" => true))){
					print '<div class="unit"><H6>Objecttype</H6>';
					$va_tmp = array();
					foreach($va_list_items as $va_list_item){
						$va_tmp[] = $va_list_item["label"];
					}
					print join(", ", $va_tmp);
					print '</div>';
				}
?>				
				
				{{{<ifdef code="ca_objects.dimensions"><div class="unit"><H6>Afmetingen</H6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.dimensions.dimensions_name">^ca_objects.dimensions.dimensions_name: </ifdef><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height</ifdef><ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth</ifdef><ifdef code="ca_objects.dimensions.dimensions_unit"> ^ca_objects.dimensions.dimensions_unit</ifdef><ifdef code="ca_objects.dimensions.weight"> ^ca_objects.dimensions.weight</ifdef><ifdef code="ca_objects.dimensions.weight,ca_objects.dimensions.weight_unit"> ^ca_objects.dimensions.weight_unit</ifdef></unit></div></ifdef>}}}
				{{{<ifcount code="ca_places" min="1"><div class="unit"><H6>Plaatsen</H6><unit relativeTo="ca_places" delimiter=", ">^ca_places.preferred_labels</unit></div></ifcount>}}}
				
<?php
				if($vs_date = $t_item->getWithTemplate('<ifdef code="ca_objects.production_dating.Style|ca_objects.production_dating.earliest_date|ca_objects.production_dating.production_period"><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.production_dating.Style">^ca_objects.production_dating.Style </ifdef><ifdef code="ca_objects.production_dating.earliest_date">^ca_objects.production_dating.earliest_date </ifdef><ifdef code="ca_objects.production_dating.production_period">^ca_objects.production_dating.production_period </ifdef></unit></ifdef>')){
					print '<div class="unit"><H6>Datering</H6>';
					print $vs_date;
					print '</div>';
				}
				if($va_object_keywords = $t_item->get("ca_objects.object_keywords", array("returnWithStructure" => true))){
					$va_object_keywords = array_pop($va_object_keywords);
					$va_tmp = array();
					foreach($va_object_keywords as $va_object_keyword){
						$va_tmp[] = $va_object_keyword["object_keywords"];
					}
						print '<div class="unit"><H6>Trefwoord</H6>';
						print join(", ", $va_tmp);
						print "</div>";
				}
				if($va_makers = $t_item->get("ca_objects.production_maker.maker", array("returnAsArray" => true, "convertCodesToDisplayText" => true, "checkAccess" => $va_access_values))){
					$va_makers_ids = $t_item->get("ca_objects.production_maker.maker", array("returnAsArray" => true, "checkAccess" => $va_access_values));
					if(sizeof($va_makers_ids)){
						$va_tmp = array();
						foreach($va_makers as $vn_i => $vs_maker){
							if($vs_maker){
								$va_tmp[] = $vs_maker;
							}
						}
						if(sizeof($va_tmp)){
							print '<div class="unit"><H6>Vervaardiger</H6>';
							print join(", ", $va_tmp);
							print '</div>';
						}
					}
				}
				#print $t_item->getWithTemplate('<ifdef code="ca_objects.production_maker.maker"><div class="unit"><H6>Vervaardiger</H6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.production_maker.maker">^ca_objects.production_maker.maker</ifdef><ifdef code="ca_objects.production_maker.maker_role">, ^ca_objects.production_maker.maker_role</ifdef><ifdef code="ca_objects.production_maker.maker_sureness">, ^ca_objects.production_maker.maker_sureness</ifdef></unit></div></ifdef>');
				print $t_item->getWithTemplate('<ifdef code="ca_objects.management_acquisition.acquisition_source|ca_objects.management_acquisition.acquisition_method_type|ca_objects.management_acquisition.acquisition_date|ca_objects.management_acquisition.acquisition_note"><div class="unit"><H6>Verwerving</H6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.management_acquisition.acquisition_source">^ca_objects.management_acquisition.acquisition_source</ifdef><ifdef code="ca_objects.management_acquisition.acquisition_method_type">, ^ca_objects.management_acquisition.acquisition_method_type</ifdef><ifdef code="ca_objects.management_acquisition.acquisition_date">, ^ca_objects.management_acquisition.acquisition_date</ifdef><ifdef code="ca_objects.management_acquisition.acquisition_note">, ^ca_objects.management_acquisition.acquisition_note</ifdef></unit></div></ifdef>');
?>
	</div>
<?php	
	print $this->render("pdfEnd.php");