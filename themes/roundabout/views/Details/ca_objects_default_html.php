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
	$va_access_values =		caGetUserAccessValues($this->request);
	$vn_id = $t_object->get('ca_objects.object_id');
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
				
				
				<div id="detailAnnotations"></div>
				
				<!--
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div>
					<div id='detailComments'>{{{itemComments}}}</div>
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div>
				</div>
				
				-->
			
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php			
				print caNavLink($this->request, '<i class="fa fa-download"></i> Download PDF', 'objDownload', 'Detail', 'objects', $vn_id.'/view/pdf/export_format/_pdf_ca_objects_summary');
?>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
<?php
				if ($va_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit identifier'>Identifier: ".$va_idno."</div>";
				}
				if ($va_description = $t_object->get('ca_objects.description')) {
					print "<div class='unit'><h6>Description</h6>".$va_description."</div>";
				}
?>
				<hr></hr>
<?php

					$va_occurrence_list = array();
					if ($va_occurrences = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						foreach ($va_occurrences as $va_key => $va_occurrence) {
							$t_occurrence = new ca_occurrences($va_occurrence);
							$vs_type = $t_occurrence->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true));
							$va_occurrence_list[$vs_type][] = caNavLink($this->request, $t_occurrence->get('ca_occurrences.preferred_labels'), '', '', 'Detail', 'occurrences/'.$va_occurrence);
						}
					}
					foreach ($va_occurrence_list as $va_type => $va_occurrence_list_object) {
						print "<div class='unit'><h4>Related ".$va_type."</h4>";
						foreach ($va_occurrence_list_object as $va_key => $va_occurrence_list_object_link) {
							print $va_occurrence_list_object_link."<br/>";
						}
						print "</div>";
					}

				if ($va_related_entities = $t_object->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h4>Related Entities</h4>".$va_related_entities."</div>";
				}
				if ($va_related_collections = $t_object->get('ca_collections.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h4>Related Collections</h4>".$va_related_collections."</div>";
				}								
				if ($va_terms = $t_object->get('ca_list_items.preferred_labels', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h4>Subjects</h4>";
						foreach ($va_terms as $va_key => $va_term) {
							print caNavLink($this->request, $va_term, '', '', 'Search', 'objects', array('search' => "ca_list_items.preferred_labels:'".$va_term."'"));
						}
					print "</div>";
				}
				$va_images = false;
				$vs_text = "";
				if ($va_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					foreach ($va_objects as $va_key => $va_object) {
						$t_rel_object = new ca_objects($va_object);
						if ($va_rep = $t_rel_object->get('ca_object_representations.media.icon', array('checkAccess' => $va_access_values))) {
							$vs_text.= "<div class='relImage'>".caNavLink($this->request, $va_rep, '', '', 'Detail', 'objects/'.$t_rel_object->get('ca_objects.object_id'))."</div>";
							$vs_images = true;
						}
					}
				}
				if ($vs_images == true) {
					print "<div class='unit trimText'><h4>Related Objects</h4>";
					print $vs_text;
					print "<div class='clearfix'></div>";
					print "</div>";
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
		  maxHeight: 200,
		  moreLink: '<a href="#">See More</a>',
		  lessLink: '<a href="#">See Less</a>',
		});
	});
</script>