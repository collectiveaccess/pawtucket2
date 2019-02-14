<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-4'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				
				$vs_variety = $t_object->get("ca_objects.variety");
?>

			</div><!-- end col -->
			
			<div class='col-sm-8'>
				<H4><i>{{{<ifdef code="ca_objects.genus">^ca_objects.genus </ifdef><ifdef code="ca_objects.species">^ca_objects.species </ifdef>}}}<?php print ($vs_variety) ? $vs_variety." " : ""; ?></i>{{{<ifdef code="ca_objects.preferred_labels.name">- ^ca_objects.preferred_labels.name</ifdef>}}}</H4>
				<H6>{{{<ifdef code="ca_objects.synonym_genus"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.synonym_genus</unit>; </ifdef><ifdef code="ca_objects.synonym_species"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.synonym_species</unit>; </ifdef><ifdef code="ca_objects.variety_cultivar_synonym"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.variety_cultivar_synonym</unit>; </ifdef><ifdef code="ca_objects.nonpreferred_labels.name"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.nonpreferred_labels.name</unit>; </ifdef>}}}</H6>
				<H6>{{{<ifdef code="ca_objects.family_latin"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.family_latin</unit> </ifdef><ifdef code="ca_objects.family_common">(<unit relativeTo="ca_objects" delimiter=", ">^ca_objects.family_common</unit>)</ifdef>}}}</H6>
				<HR/>
				
				<div class="row">
					<div class="col-sm-6">
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
						
						
					</div>
					<div class="col-sm-6">
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
						{{{<ifdef code="ca_objects.found"><div class="unit"><b>Plant Community: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.found</unit></div></ifdef>}}}
						
					</div>
				</div>
				<HR/>
				{{{<ifcount code="ca_entities" min="1" restrictToTypes="pollinator"><div class="unit"><b>Pollinators That Use This Plant: </b><unit relativeTo="ca_entities" restrictToTypes="pollinator" deliiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.wildlife_pollinator_benefits|ethnobotanical"><div class="unit"><b>Ecosystem Services: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.wildlife_pollinator_benefits</unit><ifdef code="ca_objects.wildlife_pollinator_benefits,ethnobotanical">, </ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.ethnobotanical</unit></div></ifdef>}}}
						

				<div class="row">
					<div class="col-sm-6">
						{{{<ifdef code="ca_objects.description"><div class="unit"><b>Plant Description: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.description</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.flower_description|flower_color_public"><div class="unit"><b>Flower Description & Color: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.flower_description</unit><ifdef code="ca_objects.flower_color_public,flower_description"><br/><br/></ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.flower_color_public</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.leaf_description"><div class="unit"><b>Leaf Description: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.leaf_description</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.fruit_description|fruit_color"><div class="unit"><b>Fruit Description & Color: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.fruit_description</unit><ifdef code="ca_objects.fruit_color,fruit_description"><br/><br/></ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.fruit_color</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.bark_description"><div class="unit"><b>Bark Description: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.bark_description</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.public_form_habit_text"><div class="unit"><b>Form Habit: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.public_form_habit_text</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.distribution_narrative"><div class="unit"><b>Distribution/Habitat: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.distribution_narrative</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.adaptation_narrative"><div class="unit"><b>Adaptation: </b><unit relativeTo="ca_objects" delimiter="<br/><br/>">^ca_objects.adaptation_narrative</unit></div></ifdef>}}}
						
					</div>
					<div class="col-sm-6">
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
						
					</div>	
				</div>					
							
						
			</div><!-- end col -->
		</div><!-- end row -->
		<?php
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
				if($t_object->get("ca_objects.early_winter") || $t_object->get("ca_objects.mid_winter") || $t_object->get("ca_objects.late_winter") || $t_object->get("ca_objects.early_spring") || $t_object->get("ca_objects.mid_spring") || $t_object->get("ca_objects.late_spring") || $t_object->get("ca_objects.early_summer") || $t_object->get("ca_objects.late_summer") || $t_object->get("ca_objects.early_fall") || $t_object->get("ca_objects.") || $t_object->get("ca_objects.mid_fall") || $t_object->get("ca_objects.late_fall")){
?>

				<div class="row">
					<div class="col-sm-12"><hr/><br/><div class="unit"><H2 class="text-center">Bloomtime Color Chart</H2>
						<div class="row"><div class="col-sm-12">
							<div class="container">
								
								<div class="row btccRow">
<?php
						foreach($va_bloomtime_color_fields as $vs_bloomtime_color_field => $va_bloomtime_color_subfields){
?>
								<div class="col-sm-1 btccCol" style="background-color:<?php print "#".$t_object->get("ca_objects.".$vs_bloomtime_color_field.".".$va_bloomtime_color_subfields["color"]); ?>;">
				<?php 
									$vs_part = $t_object->get("ca_objects.".$vs_bloomtime_color_field.".".$va_bloomtime_color_subfields["part"], array("convertCodesToDisplayText" => true));
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
								</div>
								<div class="row btccSeason">
									<div class="col-sm-1 small">Dec</div>
									<div class="col-sm-1 small">Jan</div>
									<div class="col-sm-1 small">Feb</div>
									<div class="col-sm-1 small">March</div>
									<div class="col-sm-1 small">April</div>
									<div class="col-sm-1 small">May</div>
									<div class="col-sm-1 small">June</div>
									<div class="col-sm-1 small">July</div>
									<div class="col-sm-1 small">Aug</div>
									<div class="col-sm-1 small">Sept</div>
									<div class="col-sm-1 small">Oct</div>
									<div class="col-sm-1 small">Nov</div>
								</div>
								<div class="row btccSeason">
									<div class="col-sm-3 small">WINTER</div>
									<div class="col-sm-3 small">SPRING</div>
									<div class="col-sm-3 small">SUMMER</div>
									<div class="col-sm-3 small">FALL</div>
								</div>
							</div><!-- end container -->
						</div></div>
					</div></div>
				</div>
<?php
			}
?>
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>