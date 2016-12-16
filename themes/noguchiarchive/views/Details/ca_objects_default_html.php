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
	$va_access_values = 	caGetUserAccessValues($this->request);

?>
<div id="page-name">
	<h1 id="archives" class="title">Archival Item</h1>
</div>
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
				{{{representationViewer}}}
				
<?php
				if ($va_image_credit = $t_object->get('ca_objects.image_credit_line')) {
					print "<div>Credit: ".$va_image_credit."</div>";
				}

				print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-4")); 
			
?>
				<hr>
				{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}

				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1" max="1"><H6>Related exhibition</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="2"><H6>Related exhibitions</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="exhibition"><l>^ca_occurrences.preferred_labels</l></unit>}}}

				{{{<ifcount code="ca_occurrences" restrictToTypes="bibliography" min="1" max="1"><H6>Related bibliography</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" restrictToTypes="bibliography" min="2"><H6>Related bibliography</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="bibliography"><l>^ca_occurrences.preferred_labels</l></unit>}}}
										
				{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
				
				{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
				{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter="<br/>"><unit relativeTo="ca_list_items"><l>^ca_list_items.preferred_labels.name_plural</l></unit></unit>}}}
				
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Identifier</h6>".$vs_idno."</div>";
				}
				if ($va_category = $t_object->get('ca_objects.archive_category', array('convertCodesToDisplayText' => true))){
					print "<div class='unit'><h6>Archive Category</h6>".$va_category."</div>";
				}
				if ($va_doc_type = $t_object->get('ca_objects.document_type', array('convertCodesToDisplayText' => true))){
					print "<div class='unit'><h6>Document Type</h6>".$va_doc_type."</div>";
				}				
				if ($va_alt_title = $t_object->get('ca_objects.nonpreferred_labels', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Alternate Titles</h6>".$va_alt_title."</div>";
				}
				if ($va_dates = $t_object->get('ca_objects.date.display_date', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Date</h6>".$va_dates."</div>";
				}	
				if ($va_photographer = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('photographer')))) {
					print "<div class='unit'><h6>Photographer</h6>".$va_photographer."</div>";
				}			
				if ($va_technique = $t_object->get('ca_objects.technique', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Technique</h6>".$va_technique."</div>";
				}
				if ($va_dims = $t_object->get('ca_objects.display_dimensions', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Dimensions</h6>".$va_dims."</div>";
				}
				if ($va_insc = $t_object->get('ca_objects.inscriptions', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Inscriptions</h6>".$va_insc."</div>";
				}
				if ($va_num = $t_object->get('ca_objects.num_of_elements', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Number of Elements</h6>".$va_num."</div>";
				}
				if ($va_base = $t_object->get('ca_objects.base', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Base</h6>".$va_base."</div>";
				}
				if ($va_edition = $t_object->get('ca_objects.edition', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Edition</h6>".$va_edition."</div>";
				}	
				if ($va_desc = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Description</h6>".$va_desc."</div>";
				}	
				if ($va_catno = $t_object->get('ca_objects.catalogue_notes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Catalogue raisonné notes</h6>".$va_catno."</div>";
				}
				if ($va_coll = $t_object->get('ca_objects.current_collection', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Current Collection</h6>".$va_coll."</div>";
				}
				if ($va_prov = $t_object->get('ca_objects.provenance', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Provenance</h6>".$va_prov."</div>";
				}
				if ($va_image_id = $t_object->get('ca_objects.image_id', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Image Identifier</h6>".$va_image_id."</div>";
				}					
				if ($va_published = $t_object->get('ca_objects.published_on_text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Published On</h6>".$va_published."</div>";
				}
				if ($va_last = $t_object->get('ca_objects.last_updated_on_text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Last Updated</h6>".$va_last."</div>";
				}
				if ($va_status = $t_object->get('ca_objects.status', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Status</h6>".$va_status."</div>";
				}
																																																	
?>				
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">	
<?php							
						if ($va_related_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
							print "<div class='unit relatedObjects'><h6>Related Objects</h6><div class='row'>";
							$vn_i = 0;
							foreach ($va_related_objects as $va_key => $va_related_object) {
								$t_rel = new ca_objects($va_related_object);
								print "<div class='col-sm-4'><span class='relatedObj' data-toggle='popover' data-trigger='hover' data-content='".$t_rel->get('ca_objects.preferred_labels').", ".$t_rel->get('ca_objects.date.display_date')."'>".caNavLink($this->request, $t_rel->get('ca_object_representations.media.icon'), '', '', 'Detail', 'objects/'.$va_related_object)."</span></div>";
								$vn_i++;
								if ($vn_i == 3) {
									print "<div class='clearfix'></div>";
									$vn_i = 0;
								}
							}
							print "</div></div>";
						}
?>					
						</div><!-- end col -->				
					</div><!-- end row -->
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
<script>
	jQuery(document).ready(function() {
		$('.relatedObj').popover(); 
	});
	
</script>