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

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
<?php
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Object ID</h6>".$vs_idno."</div>";
				}
				if ($vs_call = $t_object->get('ca_objects.call_number')) {
					print "<div class='unit'><h6>Call Number</h6>".$vs_call."</div>";
				}
				if ($vs_name = $t_object->get('ca_objects.preferred_labels')) {
					print "<div class='unit'><h6>Object Name</h6>".$vs_name."</div>";
				}	
				if ($vs_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Object Description</h6>".$vs_description."</div>";
				}	
				if ($va_collection = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Object Collection</h6>".$va_collection."</div>";
				}
				if ($vs_date = $t_object->get('ca_objects.date_created', array('delimiter' => '; '))) {
					print "<div class='unit'><h6>Date Created</h6>".$vs_date."</div>";
				}
				if ($vs_alt_name = $t_object->get('ca_objects.alternate_object_name', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Alternative Name</h6>".$vs_alt_name."</div>";
				}	
				if ($vs_credit_line = $t_object->get('ca_objects.credit_line', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Donor</h6>".$vs_credit_line."</div>";
				}	
				if ($vs_prov = $t_object->get('ca_objects.provenance', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Origin</h6>".$vs_prov."</div>";
				}			
				if ($vs_medium = $t_object->get('ca_objects.medium', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Medium</h6>".$vs_medium."</div>";
				}
				if ($vs_material = $t_object->get('ca_objects.material', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Material</h6>".$vs_material."</div>";
				}
				if ($va_entities = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</l> (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Object Entities</h6>".$va_entities."</div>";
				}
				if ($va_collection = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Related Collections</h6>".$va_collection."</div>";
				}	
				if ($va_object = $t_object->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_objects.related"><l>^ca_objects.preferred_labels, ^ca_objects.idno</l></unit></unit>')) {
					print "<div class='unit'><h6>Related Items</h6>".$va_object."</div>";
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