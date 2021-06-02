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
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				if($vs_representationViewer){
					print $vs_representationViewer;
				}else{
					print "<div class='detailPlaceholder'><i class='fa fa-book fa-5x'></i><div class='placeholderMessage'>Image missing.  We would appreciate if<br/>someone on campus could take a photo<br/>of first and last page and send it to us.</div></div>";
				}
?>				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
<?php
				if ($vs_object_id = $t_object->get('ca_objects.object_id')) {
					print "<div class='unit'><h6>Database ID#</h6>".$vs_object_id."</div>";
				}
?>
				<div style='margin-top:10px;'>{{{map}}}</div>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				
				if ($vs_description = $t_object->get("ca_objects.description")) {
					print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
				}
				if ($vs_notes = $t_object->get('ca_objects.500_notes', array("delimiter" => "<br/>"))) {
					print "<div class='unit'><h6>General Notes</h6>".$vs_notes."</div>";
				}
				
				if ($vs_year = $t_object->get('ca_objects.type_date', array("delimiter" => "<br/>"))) {
					print "<div class='unit'><h6>Years</h6>".$vs_year."</div>";
				}
				if ($vs_author = $t_object->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='author'><ifdef code='ca_entities.variant_names.display_name'><span class='authorPopover' data-toggle='popover' data-trigger='hover' data-content='^ca_entities.variant_names.display_name%delimiter=;_'><l>^ca_entities.preferred_labels</l></span></ifdef><ifnotdef code='ca_entities.variant_names.display_name'><l>^ca_entities.preferred_labels</l></ifdef></unit>")) {
					print "<div class='unit'><h6>Author</h6>".$vs_author."</div>";
				}
				if ($vs_added_entries = $t_object->getWithTemplate("<unit relativeTo='ca_entities' excludeRelationshipTypes='author' delimiter='<br/>'><ifdef code='ca_entities.variant_names.display_name'><span class='authorPopover' data-toggle='popover' data-trigger='hover' data-content='^ca_entities.variant_names.display_name%delimiter=;_'><l>^ca_entities.preferred_labels</l>  (^relationship_typename)</span></ifdef><ifnotdef code='ca_entities.variant_names.display_name'><l>^ca_entities.preferred_labels</l>  (^relationship_typename)</ifdef></unit>")) {
					print "<div class='unit'><h6>Added Entries</h6>".$vs_added_entries."</div>";
				}

				if ($vs_related_ornaments = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToTypes' => array("ornament")))) {
					print "<div class='unit'><h6>Related Ornaments</h6>".$vs_related_ornaments."</div>";
				}
				if ($vs_related_suelta = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToTypes' => array("book")))) {
					print "<div class='unit'><h6>Related Comedias Sueltas</h6>".$vs_related_suelta."</div>";
				}
				if ($vs_related_places = $t_object->get('ca_places.preferred_labels.name', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Related Places</h6>".$vs_related_places."</div>";
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
	jQuery(document).ready(function() {
		$('.authorPopover').popover(); 
	});
	
</script>