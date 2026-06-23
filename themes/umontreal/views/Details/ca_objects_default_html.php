<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
				<h6>Numéro d'inventaire</h6>
				{{{^ca_objects.idno}}}
{{{<ifdef code='ca_objects.nonpreferred_labels'><h6>Autres noms de l’objet</h6></ifdef>}}}
{{{^ca_objects.nonpreferred_labels}}}

{{{<ifcount code="ca_entities" restrictToRelationshipTypes="Artiste,Artisan" min="1" max="1"><H6>Artiste/Artisan</H6></ifcount>}}}
{{{<ifcount code="ca_entities" restrictToRelationshipTypes="Artiste,Artisan" min="2"><H6>Artiste/Artisan</H6></ifcount>}}}
{{{<unit relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="Artiste,Artisan" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit></unit>}}}

{{{<ifdef code='ca_objects.culture'><h6>Culture</h6></ifdef>}}}
{{{^ca_objects.culture}}}

{{{<ifcount code="ca_places" min="1" max="1"><H6>Lieu lié</H6></ifcount>}}}
{{{<ifcount code="ca_places" min="2"><H6>Lieux liés</H6></ifcount>}}}
{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places">^ca_places.hierarchy.preferred_labels%delimiter=_➔_&filterTypes=country,neighborhood,préfecture,province,region,reserve,site,territory,village,site,city</unit>&nbsp;(^relationship_typename)</unit>}}}

{{{<ifdef code='ca_objects.objectProductionDateC.objectProductionDate'><h6>Date de production de l’objet</h6></ifdef>}}}
{{{^ca_objects.objectProductionDateC.objectProductionDate}}}


date de début de production
{{{<ifdef code='ca_objects.dateperiod'><h6>Période</h6></ifdef>}}}
{{{^ca_objects.dateperiod}}}

{{{<ifdef code='ca_objects.work_mat_tech'><h6>Matériaux</h6></ifdef>}}}
{{{<unit relativeTo="ca_objects.work_mat_tech" delimiter=" • ">^ca_objects.work_mat_tech.materiau_liste</unit>}}}
<?php
$dim = [];	
$height = $t_object->get("ca_objects.dimensions.dimensions_height", array("returnAsDecimalMetric"=>true)); 
if($height) {
	$dim[]=  "H. ".($height*100)." cm";
}
$length = $t_object->get("ca_objects.dimensions.dimensions_length", array("returnAsDecimalMetric"=>true)); 
if($length) {
	$dim[]= "L. ".($length*100)." cm";
}
$width = $t_object->get("ca_objects.dimensions.dimensions_width", array("returnAsDecimalMetric"=>true)); 
if($width) {
	$dim[]=  "l. ".($width*100)." cm";
}
$depth = $t_object->get("ca_objects.dimensions.dimensions_depth", array("returnAsDecimalMetric"=>true)); 
if($depth) {
	$dim[]=  "P. ".($depth*100)." cm";
}
if(sizeof($dim) > 0){ 
	print "<h6>Dimensions</h6>";
	print implode(" x ", $dim);
}
?>

{{{<ifdef code='ca_objects.description'><h6>Description</h6></ifdef>}}}
{{{^ca_objects.description}}}
{{{<ifdef code='ca_objects.fonctions'><h6>Usage</h6></ifdef>}}}
{{{^ca_objects.fonctions}}}
{{{<ifdef code='ca_objects.comments'><h6>Commentaires</h6></ifdef>}}}
{{{^ca_objects.comments}}}

{{{<ifcount code="ca_entities" restrictToRelationshipTypes="Collecteur" min="1" max="1"><H6>Collecteur</H6></ifcount>}}}
{{{<ifcount code="ca_entities" restrictToRelationshipTypes="Collecteur" min="2"><H6>Collecteurs</H6></ifcount>}}}
{{{<unit relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="Collecteur" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit></unit>}}}

{{{<unit relativeTo='ca_objects.usedate'>
	<ifdef code='ca_objects.usedate.useDate_date'><h6>^ca_objects.usedate.useDate_type</h6></ifdef>
^ca_objects.usedate.useDate_date
</unit>}}}

{{{<ifcount code="ca_entities" restrictToRelationshipTypes="origine_donateur,origine_vendeur" min="1"><H6>Source</H6></ifcount>}}}
{{{<unit relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="origine_donateur,origine_vendeur" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit>&nbsp;(^relationship_typename)</unit>}}}

<!--
<h6>Date d’acquisition</h6>
{{{^ca_objects.date_ref_acteAcquisition.date_acteAcquisition}}} -->

<!-- <h6>Mode d’acquisition</h6>	acq_mode-->
{{{<ifdef code='ca_objects.mention_source'><h6>Mention de source</h6></ifdef>}}}
{{{^ca_objects.mention_source}}}
<hr/>
<em>
Veuillez noter que la base de données contient des données et des termes qui peuvent être désuets, inexacts et/ou incomplets. Nous travaillons à les mettre à jour. Si vous avez des questions ou des informations à propos d’un objet, n’hésitez pas à <a mailo:v.debailleul@umontreal.ca>nous contacter</a>.</em><HR/>
					<div class="row">
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->
		
{{{<ifcount code="ca_objects.related" min="1">
		<div class="row">
			<div class="col-md-12">
						<ifcount code="ca_objects.related" min="1" max="1">
							<label>Related Object</label>
						</ifcount>
						<ifcount code="ca_objects.related" min="2">
							<label>Related Objects</label>
						</ifcount>
			</div>
		</div>
		<div class="row">
						<unit relativeTo="ca_objects.related" delimiter=" ">
							<div class="col-md-2">
								<l><div class="grayBg paddingTop">
									<div class="unit">
											<ifdef code="ca_object_representations.media.small">
												<div class="col-xs-12">
													^ca_object_representations.media.small
													<br/>
													^ca_objects.preferred_labels.name
												</div>
											</ifdef>
											<ifnotdef code="ca_object_representations.media.small">
												<div class="col-xs-12">
													<ifdef code='ca_objects.Object_KressCatalogNumber'><small>^ca_objects.Object_KressCatalogNumber</small><br/></ifdef><ifdef code="ca_objects.Object_ArtistExpression">^ca_objects.Object_ArtistExpression<br/></ifdef><ifnotdef code="ca_objects.Object_ArtistExpression"><ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist"><ifdef code="ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.forename </ifdef><ifdef code="ca_entities.preferred_labels.surname">^ca_entities.preferred_labels.surname</ifdef><ifnotdef code="ca_entities.preferred_labels.surname,ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.displayname</ifnotdef><br/></unit></ifcount></ifnotdef><i>^ca_objects.preferred_labels.name</i><ifcount code="ca_entities" restrictToRelationshipTypes="location"><br/><unit relativeTo="ca_entities" restrictToRelationshipTypes="location" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></ifcount>
												</div>
											</ifnotdef>
										</div>
									</div>
								</div></l>
							</div>
						</unit>
			</div>
</ifcount>}}}
		
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