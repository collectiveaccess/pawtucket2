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

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="title">
		<h1 class="title"><i>{{{<ifdef code="ca_objects.genus">^ca_objects.genus </ifdef><ifdef code="ca_objects.species">^ca_objects.species </ifdef>}}}<?php print ($vs_variety) ? $vs_variety." " : ""; ?></i>{{{<ifdef code="ca_objects.preferred_labels.name">- ^ca_objects.preferred_labels.name</ifdef>}}}</h1>
				<H6>{{{<ifdef code="ca_objects.synonym_genus"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.synonym_genus</unit>; </ifdef><ifdef code="ca_objects.synonym_species"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.synonym_species</unit>; </ifdef><ifdef code="ca_objects.variety_cultivar_synonym"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.variety_cultivar_synonym</unit>; </ifdef><ifdef code="ca_objects.nonpreferred_labels.name"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.nonpreferred_labels.name</unit>; </ifdef>}}}</H6>
				<H6>{{{<ifdef code="ca_objects.family_latin"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.family_latin</unit> </ifdef><ifdef code="ca_objects.family_common">(<unit relativeTo="ca_objects" delimiter=", ">^ca_objects.family_common</unit>)</ifdef>}}}</H6>
		<hr/>
	</div>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("small", "medium"));
	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print "<img src='".$va_rep['paths']['small']."'>\n";
		}else{
			# --- one rep - show medium rep
			print "<img src='".$va_rep['paths']['medium']."'>\n";
		}
	}
	$va_bloomtime_color_fields = array(
		"early_winter" => array("color" => "color", "part" => "part"),
		"mid_winter" => array("color" => "mwcolor", "part" => "mwpart"),
		"late_winter" => array("color" => "lwcolor", "part" => "lwpart"),
		"early_spring" => array("color" => "escolor", "part" => "espart"),
		"mid_spring" => array("color" => "mscolor", "part" => "mspart"),
		"late_spring" => array("color" => "lscolor", "part" => "lspart"),
		"early_summer" => array("color" => "esmcolor", "part" => "esmpart"),
		"mid_summer" => array("color" => "msmcolor", "part" => "msmpart"),
		"late_summer" => array("color" => "lsmcolor", "part" => "lsmpart"),
		"early_fall" => array("color" => "efcolor", "part" => "efpart"),
		"mid_fall" => array("color" => "mfcolor", "part" => "mfpart"),
		"late_fall" => array("color" => "lfcolor", "part" => "lfpart")
	);
	
?>
	</div>
	<hr/>
	<div style="text-align:center;">
	
	
				<div class="btccSeasonRow btccTitle noBtccLabel">Color Chart</div>
					<div class="btccRow border">					
<?php

						foreach($va_bloomtime_color_fields as $vs_bloomtime_color_field => $va_bloomtime_color_subfields){
?>
								<div class="btccCol" style="background-color:<?php print "#".$t_item->get("ca_objects.".$vs_bloomtime_color_field.".".$va_bloomtime_color_subfields["color"]); ?>;">
<?php 
									$vs_part = $t_item->get("ca_objects.".$vs_bloomtime_color_field.".".$va_bloomtime_color_subfields["part"], array("convertCodesToDisplayText" => true));
									$va_part = explode(";", $vs_part);
									$vs_part = $va_part[0];
									switch($vs_part){
										case "Bare/Nothing/Gone":
											# --- nothing
										break;
										case "Berry":
											print "<div class='flaticon flaticon-fruit' title='Berry'></div>";
										break;
										case "Bract":
											print "<div class='flaticon flaticon-sakura' title='Bract'></div>";
										break;
										case "Branches/Stems":
											print "<div class='flaticon flaticon-tree' title='Branches/Stems'></div>";
										break;
										case "Bud/new leaf":
											print "<div class='flaticon flaticon-orange' title='Bud/New Leaf'></div>";
										break;
										case "Flower":
											print "<div class='flaticon flaticon-flower' title='Flower'></div>";
										break;
										case "Leaf":
											print "<div class='flaticon flaticon-autumn' title='Leaf'></div>";
										break;
										case "Seedhead/Seedpod":
											print "<div class='flaticon flaticon-wheat' title='Seedhead/Seedpod'></div>";
										break;
										default:
											print "<div>".str_replace("/", ", ", $vs_part)."</div>";
										break;
									}
?>
								</div>
<?php
						}
?>
						<div style="clear:both;"></div>
					</div><!-- end btccRow -->
					<div class="btccSeasonRow noBtccLabel centerChart">
						<div class="btccMonthCol">Dec</div>
						<div class="btccMonthCol">Jan</div>
						<div class="btccMonthCol">Feb</div>
						<div class="btccMonthCol">March</div>
						<div class="btccMonthCol">April</div>
						<div class="btccMonthCol">May</div>
						<div class="btccMonthCol">June</div>
						<div class="btccMonthCol">July</div>
						<div class="btccMonthCol">Aug</div>
						<div class="btccMonthCol">Sept</div>
						<div class="btccMonthCol">Oct</div>
						<div class="btccMonthCol">Nov</div>
					</div>
					<div class="btccSeasonRow noBtccLabel centerChart">
						<div class="btccSeasonCol">WINTER</div>
						<div class="btccSeasonCol">SPRING</div>
						<div class="btccSeasonCol">SUMMER</div>
						<div class="btccSeasonCol">FALL</div>
					</div>
	</div>
	
	
	
	<div class='tombstone'>
				<HR/>
				
				<p>
						{{{<ifdef code="ca_objects.usda_zones"><div class="unit"><b>USDA Hardiness Zones: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.usda_zones</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.plant_type"><div class="unit"><b>Plant Type: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.plant_type</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.duration"><div class="unit"><b>Duration: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.duration</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.height|ca_objects.width"><div class="unit"><ifdef code="ca_objects.height"><b>Height: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.height</unit></ifdef><ifdef code="ca_objects.width"> <b>Width: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.width</unit></ifdef></div></ifdef>}}}
						{{{<ifdef code="ca_objects.spacing"><div class="unit"><b>Spacing: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.spacing</unit></div></ifdef>}}}
						<br/>
						{{{<ifdef code="ca_objects.light_needs"><div class="unit"><b>Exposure (light needs): </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.light_needs</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.water_use"><div class="unit"><b>Water Use: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.water_use</unit></div></ifdef>}}}
						<br/>
						{{{<ifdef code="ca_objects.soil_type_best|ca_objects.soil_type_tolerates"><div class="unit"><b>Soil Type: </b><ifdef code="ca_objects.soil_type_best"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.soil_type_best</unit> (best)</ifdef><ifdef code="ca_objects.soil_type_best|ca_objects.soil_type_tolerates">; </ifdef><ifdef code="ca_objects.soil_type_tolerates"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.soil_type_tolerates</unit> (tolerates);</ifdef></div></ifdef>}}}
						{{{<ifdef code="ca_objects.soil_ph"><div class="unit"><b>pH Range: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.soil_ph</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.salinity_tolerance"><div class="unit"><b>Soil Salinity Tolerance: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.salinity_tolerance</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.soil_type_description"><div class="unit"><b>Soil Description: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.soil_type_description</unit></div></ifdef>}}}
						
						
				</p>
				<p>
						{{{<ifdef code="ca_objects.resistance"><div class="unit"><b>Resistance: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.resistance</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.form_habit"><div class="unit"><b>Form/Habit: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.form_habit</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.height_weeks"><div class="unit"><b>Time to Ultimate Height: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.height_weeks</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.height_years"><div class="unit"><b>Time to Ultimate Height: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.height_years</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.growth_rate"><div class="unit"><b>Growth Rate: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.growth_rate</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.maintenance"><div class="unit"><b>Maintenance: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.maintenance</unit></div></ifdef>}}}
						<br/>
						{{{<ifdef code="ca_objects.usda_link"><div class="unit"><b>USDA Link: </b><unit relativeTo="ca_objects" delimiter=", "><a href="^ca_objects.usda_link" target="_blank">^ca_objects.usda_link</a></unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.native_state"><div class="unit"><b>Native to State: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.native_state</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.native_country"><div class="unit"><b>Native to Country: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.native_country</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.distribution_state"><div class="unit"><b>Distribution State: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.distribution_state</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.wetland_indicator_status"><div class="unit"><b>Wetland Indicator Status: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.wetland_indicator_status</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.native_habitat_type"><div class="unit"><b>Native Habitat Type: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.native_habitat_type</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.nativar"><div class="unit"><b>Nativar (Native cultivar): </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.nativar</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.found"><div class="unit"><b>Plant Community: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.found</unit></div></ifdef>}}}
						
				</p>
				<HR/>
				{{{<ifcount code="ca_entities" min="1" restrictToTypes="pollinator"><div class="unit"><b>Pollinators That Use This Plant: </b><unit relativeTo="ca_entities" restrictToTypes="pollinator" deliiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.wildlife_pollinator_benefits|ethnobotanical"><div class="unit"><b>Ecosystem Services: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.wildlife_pollinator_benefits</unit><ifdef code="ca_objects.wildlife_pollinator_benefits,ethnobotanical">, </ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.ethnobotanical</unit></div></ifdef>}}}
						

				<p>
						{{{<ifdef code="ca_objects.description"><div class="unit"><b>Plant Description: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.description</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.flower_description|flower_color_public"><div class="unit"><b>Flower Description & Color: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.flower_description</unit><ifdef code="ca_objects.flower_color_public,flower_description"><br/><br/></ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.flower_color_public</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.leaf_description"><div class="unit"><b>Leaf Description: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.leaf_description</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.fruit_description|fruit_color"><div class="unit"><b>Fruit Description & Color: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.fruit_description</unit><ifdef code="ca_objects.fruit_color,fruit_description"><br/><br/></ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.fruit_color</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.bark_description"><div class="unit"><b>Bark Description: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.bark_description</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.public_form_habit_text"><div class="unit"><b>Form Habit: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.public_form_habit_text</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.distribution_narrative"><div class="unit"><b>Distribution/Habitat: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.distribution_narrative</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.adaptation_narrative"><div class="unit"><b>Adaptation: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.adaptation_narrative</unit></div></ifdef>}}}
						
				</p>
				<p>
						{{{<ifdef code="ca_objects.toxic_part"><div class="unit"><b>Part of the Plant That is Toxic: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.toxic_part</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.edible_part"><div class="unit"><b>Part of the Plant That is Edible: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.edible_part</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.features"><div class="unit"><b>Features: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.features</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.notable_fall_color"><div class="unit"><b>Notable Fall Color: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.notable_fall_color</unit></div></ifdef>}}}
						<br/>
						{{{<ifdef code="ca_objects.persistance"><div class="unit"><b>Persistence: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.persistance</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.spreading_ability"><div class="unit"><b>Spreading Ability: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.spreading_ability</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.longevity"><div class="unit"><b>Longevity: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.longevity</unit></div></ifdef>}}}
						<br/>
						{{{<ifdef code="ca_objects.ethnobotanical_info"><div class="unit"><b>Ethnobotanical Info: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.ethnobotanical_info</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.public_disease_resistance_text"><div class="unit"><b>Disease Resistance: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.public_disease_resistance_text</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.public_insect_resistance_text"><div class="unit"><b>Insect Resistance: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.public_insect_resistance_text</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.liabilities"><div class="unit"><b>Liabilities: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.liabilities</unit></div></ifdef>}}}
				</p>
<?php	
	print $this->render("pdfEnd.php");