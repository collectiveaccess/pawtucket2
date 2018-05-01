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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
			
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($va_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', '))) {
					print "<div class='unit'><h6>Author</h6>".$va_author."</div>";
				}
				if ($va_title = $t_object->get('ca_objects.preferred_labels')) {
					print "<div class='unit'><h6>Manuscript Cookbooks Survey Title</h6>".$va_title."</div>";
				}	
				if ($va_date = $t_object->get('ca_objects.date_composition')) {
					print "<div class='unit'><h6>Date of Composition</h6>".$va_date."</div>";
				}
				if ($va_place = $t_object->get('ca_places.preferred_labels', array('delimiter' => ', '))) {
					print "<div class='unit'><h6>Place of Origin</h6>".$va_place."</div>";
				}
				if ($va_notes = $t_object->get('ca_objects.general_notes')) {
					print "<div class='unit'><h6>General Notes</h6>".$va_notes."</div>";
				}
				if ($va_library = $t_object->get('ca_objects.library_location')) {
					print "<div class='unit'><h6>Library Location</h6>".$va_library."</div>";
				}	
				if ($t_object->get('ca_objects.viewable', array('convertCodesToDisplayText' => true)) == "yes (see library record)") {
					if ($va_link = $t_object->get('ca_objects.institution_link')) {
						print "<div class='unit'><h6>Viewable Online</h6><a href='".$va_link."' target='_blank'>yes (see library record)</a></div>";
					}
				} else {
					print "<div class='unit'><h6>Viewable Online</h6>".$t_object->get('ca_objects.viewable', array('convertCodesToDisplayText' => true))."</div>";
				}

				if ($va_collections = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Institutional Collection</h6>".$va_collections."</div>";
				}
				if ($va_pages = $t_object->get('ca_objects.number_pages')) {
					print "<div class='unit'><h6>Number of Pages</h6>".$va_pages."</div>";
				}
				if ($va_provenance = $t_object->get('ca_objects.provenance')) {
					print "<div class='unit'><h6>Provenance</h6>".$va_provenance."</div>";
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