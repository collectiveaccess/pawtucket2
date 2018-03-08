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
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if($va_media = $t_object->get("ca_object_representations")){
?>
				
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>

<?php
				} else {
					print "<div class='mediaPlaceholder text-center'><i class='fa fa-photo fa-5x'></i></div>";
				}
?>
	
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
<?php
				if ($va_type = $t_object->get('ca_objects.utensil_type', array('convertCodesToDisplayText' => true))) {
					if($va_type != '-'){
						print "Type: ".ucfirst($va_type);
					}
				}
?>
				</H6>
				<HR>
<?php
				if ($va_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('manufacturer'), 'delimiter' => ', '))) {
					print "<div class='unit'><h6>Manufacturer</h6>".$va_author."</div>";
				}
				if ($va_material = $t_object->get('ca_objects.materials', array('convertCodesToDisplayText' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Material</h6>".$va_material."</div>";
				}
				if ($va_dimensions = $t_object->get('ca_objects.dimensions')) {
					print "<div class='unit'><h6>Dimensions</h6>".$va_dimensions."</div>";
				}
				if ($va_purpose = $t_object->get('ca_objects.purpose')) {
					print "<div class='unit'><h6>Purpose</h6>".$va_purpose."</div>";
				}
				if ($va_date = $t_object->get('ca_objects.utensil_date')) {
					print "<div class='unit'><h6>Creation Date</h6>".$va_date."</div>";
				}
				if ($va_date_info = $t_object->get('ca_objects.date_info')) {
					print "<div class='unit'><h6>Date Details</h6>".$va_date_info."</div>";
				}
				if ($va_utensil_description = $t_object->get('ca_objects.utensil_description')) {
					print "<div class='unit'><h6>Description</h6>".$va_utensil_description."</div>";
				}
				if ($va_marks_inscription = $t_object->get('ca_objects.marks_inscription')) {
					print "<div class='unit'><h6>Marks/Inscription</h6>".$va_marks_inscription."</div>";
				}
				if ($va_patent_date = $t_object->get('ca_places.patent_date')) {
					print "<div class='unit'><h6>Patent Date</h6>".$va_patent_date."</div>";
				}
				if ($va_patent_link = $t_object->get('ca_places.patent_link')) {
					print "<div class='unit'><h6><a href='".$va_patent_link."' target='_blank'>View Patent Online</a></div>";
				}
				if ($va_provenance = $t_object->get('ca_objects.provenance')) {
					print "<div class='unit'><h6>Provenance</h6>".$va_provenance."</div>";
				}
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Kitchen Artifact ID</h6>".$vs_idno."</div>";
				}
				if ($va_collections = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Institutional Collection</h6>".$va_collections."</div>";
				}
				if ($va_collection_link = $t_object->get('ca_objects.institution_link')) {
					$vs_link_institution = $t_object->get('ca_objects.link_institution', array('convertCodesToDisplayText' => true));
					$vs_link_text = $t_object->get('ca_objects.link_text', array('convertCodesToDisplayText' => true));
					if(!$vs_link_text){
						$vs_link_text = "View Original Kitchen Utensil Catalog Record";
					}
					$vs_link_text .= " <span class='glyphicon glyphicon-new-window' aria-hidden='true'></span>";
					print "<div class='unit'><a href='".$va_collection_link."' target='_blank'>".$vs_link_text."</a></div>";
				}
?>								
			
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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
