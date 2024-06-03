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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<!-- <H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6> removes the "Object" that displays, everything is an object, aint nobody cares about it. -->
				<HR>
<?php
				if ($vs_series_title = $t_object->get('ca_objects.series_title', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Series Title</h6>".$vs_series_title."</div>";
				}
				if ($vs_artist = $t_object->getwithTemplate('<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist">
					<ifdef code="ca_entities.entity_date">^ca_entities.preferred_labels <ifdef code="ca_entities.nationality|ca_entities.entity_date">(</ifdef><ifdef code="ca_entities.nationality">^ca_entities.nationality</ifdef><ifdef code="ca_entities.nationality;ca_entities.entity_date">, </ifdef><ifdef code="ca_entities.entity_date">^ca_entities.entity_date</ifdef><ifdef code="ca_entities.nationality|ca_entities.entity_date">)</ifdef><br/></ifdef>
					<ifnotdef code="ca_entities.entity_date">^ca_entities.preferred_labels <ifdef code="ca_entities.nationality|ca_entities.entity_lifespan_display">(</ifdef><ifdef code="ca_entities.nationality">^ca_entities.nationality</ifdef><ifdef code="ca_entities.nationality;ca_entities.entity_lifespan_display">, </ifdef><ifdef code="ca_entities.entity_lifespan_display">^ca_entities.entity_lifespan_display</ifdef><ifdef code="ca_entities.nationality|ca_entities.entity_lifespan_display">)</ifdef><br/></ifnotdef>
					</unit>')) {
					//print "<div class='unit'><h6>Artist</h6>".$vs_artist;
				}
				if ($vs_additional_artist = $t_object->getwithTemplate('<unit relativeTo="ca_entities"  delimiter=" " restrictToRelationshipTypes="after,copy,manner,maker,publisher,attributed,distributer,painter,studio,carver,engraver,photographer,style,circle,follower,poem,co_creator,foundry,printer,contributor,probably,school">^relationship_typename : 
					<ifdef code="ca_entities.entity_date">^ca_entities.preferred_labels <ifdef code="ca_entities.nationality|ca_entities.entity_date">(</ifdef><ifdef code="ca_entities.nationality">^ca_entities.nationality</ifdef><ifdef code="ca_entities.nationality;ca_entities.entity_date">, </ifdef><ifdef code="ca_entities.entity_date">^ca_entities.entity_date</ifdef><ifdef code="ca_entities.nationality|ca_entities.entity_date">)</ifdef><br/></ifdef>
					<ifnotdef code="ca_entities.entity_date">^ca_entities.preferred_labels <ifdef code="ca_entities.nationality|ca_entities.entity_lifespan_display">(</ifdef><ifdef code="ca_entities.nationality">^ca_entities.nationality</ifdef><ifdef code="ca_entities.nationality;ca_entities.entity_lifespan_display">, </ifdef><ifdef code="ca_entities.entity_lifespan_display">^ca_entities.entity_lifespan_display</ifdef><ifdef code="ca_entities.nationality|ca_entities.entity_lifespan_display">)</ifdef><br/></ifnotdef>
					</unit>')) {
					//print $vs_additional_artist;
				}
				if ($vs_artist || $vs_additional_artist) {
					print "<div class='unit'><h6>Artist</h6>".$vs_artist.$vs_additional_artist."</div>";
				}
				if ($vs_date = $t_object->get('ca_objects.creation_date_display', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
				}
				if ($vs_medium = $t_object->get('ca_objects.medium_container.display_medium_support', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Medium</h6>".$vs_medium."</div>";
				}
				if ($vs_dimensions = $t_object->getWithTemplate('<unit relativeTo="ca_objects.dimensions" sort="ca_objects.dimensions.dimensions_height" delimiter="<br/>">^ca_objects.dimensions.Type%makeFirstUpper=1 : ^ca_objects.dimensions.display_dimensions</unit>')) {
					print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions."</div>";
				}	
				if ($vs_credit = $t_object->get('ca_objects.credit_line.credit_text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Credit Line</h6>".$vs_credit."</div>";
				}	
				if ($vs_number = $t_object->get('ca_objects.idno', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Object Number</h6>".$vs_number."</div>";
				}																						

				$vs_bufone = "";
				// if ($vs_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
// 					$vs_bufone.= "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
// 				}
				if ($va_labels = $t_object->get('ca_objects.label_copy', array('convertCodesToIdno' => true, 'returnWithStructure' => true))) {
				    foreach($va_labels as $l) {
				        foreach($l as $label) {
                            if (!in_array($label['label_copy_type'], ['current', 'dedication'])) { continue; }
                            $vs_bufone.= "<div class='unit'><h6>Label</h6>".$label['label_copy_text']."</div>";
                        }
					}
				}					
				if ($vs_bufone != "") {
					print "<hr/>".$vs_bufone;
				}
				$vs_buf = "";
				if ($va_objects = $t_object->get('ca_objects.related.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true))) {
					$vs_buf.= "<div class='unit'><h6>Related Objects</h6>".$vs_objects."</div>";
				}
				if ($t_object->get('ca_objects.aat') && ($va_aat = $t_object->get('ca_objects.aat', array('returnAsArray' => true)))) { //array('delimiter' => '<br/>'))) {
					$vs_buf.= "<div class='unit'><h6>Getty AAT</h6>";
					sort($va_aat);
					foreach ($va_aat as $va_key => $vs_id) {
						$vs_buf.= caNavLink($this->request, $vs_id, '', '', 'Search', 'objects', array('search' => 'ca_objects.aat:'.$vs_id))."<br/>";
					}
					$vs_buf.= "</div>";
				}
				if ($va_lcsh = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) { //array('delimiter' => '<br/>'))) {
					$vs_buf.= "<div class='unit'><h6>Library of Congress Subject Headings</h6>";
					sort($va_lcsh);
					foreach ($va_lcsh as $va_key => $vs_id) {
						$vs_buf.= caNavLink($this->request, $vs_id, '', '', 'Search', 'objects', array('search' => 'ca_objects.lcsh_terms:'.urlencode($vs_id)))."<br/>";
					}
					$vs_buf.= "</div>";
				}
				if ($va_primary_classification = $t_object->get('ca_objects.primary_classification', array('returnAsArray' => true))) {
					$t_list_item = new ca_list_items();
					$vs_buf.= "<div class='unit'><h6>Object Type</h6>";
					$va_links = array();
					foreach ($va_primary_classification as $vn_item_id) {
						$t_list_item->load($vn_item_id);
						$vs_term = $t_list_item->get("ca_list_item_labels.name_singular");
						$va_links[$vs_term] = caNavLink($this->request, $vs_term, '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $vn_item_id));
					}
					ksort($va_links);
					$vs_buf.= join("<br/>", $va_links);
					$vs_buf.= "</div>";
				}
				if ($va_academic_array = $t_object->get('ca_objects.academic_themes_1', array('returnAsArray' => true))) {
					$vs_buf.= "<div class='unit'><h6>Academic Themes</h6>";
					$va_links = array();
					foreach ($va_academic_array as $va_key => $va_academic_id) {
						$va_links[caGetListItemByIDForDisplay($va_academic_id, true)] = caNavLink($this->request, caGetListItemByIDForDisplay($va_academic_id, true), '', 'Browse', 'objects', 'facet/academic_themes/id/'.$va_academic_id);
					}
					ksort($va_links);
					$vs_buf.= join("<br/>", $va_links);
					$vs_buf.= "</div>";
				}				
				if ($vs_buf != "") {
					print "<hr/>".$vs_buf;
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
		  maxHeight: 120,
		  moreLink: '<a href="#">Read More <i class="fa fa-angle-down"></i></a>',
		  lessLink: '<a href="#">Read Less <i class="fa fa-angle-up"></i></a>'
		});
	});
</script>
