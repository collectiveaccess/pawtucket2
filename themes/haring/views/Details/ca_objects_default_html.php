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
				{{{representationViewer}}}
				
								
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<div class='typename'>{{{<unit>^ca_objects.type_id</unit>}}}</div>
				<HR>
<?php
				if ($va_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Identifier</h6>".$va_idno."</div>";
				}
				if ($va_date = $t_object->get('ca_objects.date')) {
					print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
				}				
				if ($va_medium_text = $t_object->get('ca_objects.medium_text')) {
					print "<div class='unit'><h6>Medium</h6>".$va_medium_text."</div>";
				}
				if ($va_dimensions = $t_object->get('ca_objects.dimensions.dimensions_display', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Dimensions</h6>".$va_dimensions."</div>";
				}
				if ($va_entities = $t_object->getWithTemplate('<unit relativeTo="ca_entities">^ca_entities.preferred_labels (^relationship_typename)</unit>')) {
					print "<div class='unit'><h6>Related Entities</h6>".$va_entities."</div>";
				}
				if ($va_getty = $t_object->get('ca_objects.AAT', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Getty Art & Architecture Thesaurus</h6>".$va_getty."</div>";
				}
				if ($va_lcsh = $t_object->get('ca_objects.lcsh', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Library Of Congress Subject Headings</h6>".$va_lcsh."</div>";
				}
				if ($va_lc_names = $t_object->get('ca_objects.lc_names', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>LC Name Authority File</h6>".$va_lc_names."</div>";
				}
				if ($va_marc_geo = $t_object->get('ca_objects.marc_geo', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>MARC Geographic Areas</h6>".$va_marc_geo."</div>";
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