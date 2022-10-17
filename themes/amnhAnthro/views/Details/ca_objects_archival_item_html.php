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

	$vs_rep_viewer =		trim($this->getVar('representationViewer'));

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x' aria-label='placeholder image'></i>";
	}
	$t_list_item = new ca_list_items();
	$t_list_item->load($t_object->get("type_id"));
	$vs_typecode = $t_list_item->get("idno");
	$vs_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon");
	if(!$vs_placeholder){
		$vs_placeholder = $vs_default_placeholder_tag;
	}
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
<?php
				if($vs_rep_viewer){
					print $vs_rep_viewer;
					print '<div id="detailAnnotations"></div>';
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
				}else{
?>
					<div class="detailImgPlaceholder"><?php print $vs_placeholder; ?></div>
<?php
				}

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
				<?php
					$vs_collection_area = $t_object->get("ca_objects.collection_area", array("convertCodesToDisplayText" => 1));
					if(in_array(strToLower($vs_collection_area), array("central america", "north america", "south america", "africa", "asia"))){
						$vs_collection_area .= "n";
					}
					if(strToLower($vs_collection_area) == "europe"){
						$vs_collection_area .= "ean";
					}
					$vs_collection_type = strToLower($t_object->get("ca_objects.subtype", array("convertCodesToDisplayText" => 1)));
					switch($vs_collection_type){
						case "ethnology":
							$vs_collection_type = "ethnographic";
						break;
						case "archaeology":
							$vs_collection_type = "archeological";
						break;
					}
					// print "<H2>".$vs_collection_area." ".$vs_collection_type." Collection</H2>";
				?>	
							
				<HR>

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.subtype", ['linkTemplate' => '<a>^LINK</a>']) ?? []) { ?>
						<label>Collection</label><div class="unit"><?= join("\n", $links); ?></div>
				<?php } ?>	

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.culture_display", ['linkTemplate' => '<a>^LINK</a>']) ?? []) { ?>
						<label>Culture</label><div class="unit"><?= join("\n", $links); ?></div>
				<?php } ?>	

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.natterm", ['linkTemplate' => '<a>^LINK</a>']) ?? []) { ?>
						<label>Native Term</label><div class="unit"><?= join("\n", $links); ?></div>
				<?php } ?>	

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.country_display", ['linkTemplate' => '<a>^LINK</a>']) ?? []) { ?>
					<label>Country</label><div class="unit"><?= join("\n", $links); ?></div>
				<?php } ?>	

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.locale_display", ['linkTemplate' => '<a>^LINK</a>']) ?? []) { ?>
					<label>Locale</label><div class="unit"><?= join("\n", $links); ?></div>
				<?php } ?>	

				{{{<ifdef code='ca_objects.site'><div class="unit"><label>Site</label>^ca_objects.site%delimiter=,_</div></ifdef>}}}
				
				{{{<ifdef code='ca_objects.site_details'><div class="unit"><label>Provenience</label>^ca_objects.site_details%delimiter=,_</div></ifdef>}}}

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.period_display", ['linkTemplate' => '<a>^LINK</a>']) ?? []) { ?>
					<label>Period</label><div class="unit"><?= join("\n", $links); ?></div>
				<?php } ?>	

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.materials", ['linkTemplate' => '<li>^LINK</li>']) ?? []) { ?>
					<label>Materials</label><div class="unit"><ul><?= join("\n", $links); ?></ul></div>
				<?php } ?>

				<?php if($links = caGetSearchLinks($t_object, "ca_objects.technique", ['linkTemplate' => '<li>^LINK</li>']) ?? []) { ?>
					<label>Technique</label><div class="unit"><ul><?= join("\n", $links); ?></ul></div>
				<?php } ?>

				{{{<ifdef code='ca_objects.dimensions.display_dimensions'><div class="unit"><label>Dimensions</label><unit relativeTo="ca_objects.dimensions" delimiter=", ">^ca_objects.dimensions.display_dimensions</unit></div></ifdef>}}}
				
				{{{<unit relativeTo="ca_object_lots">
					<ifcount code="ca_entities" restrictToRelationshipTypes="donor" min="1">
						<div class="unit"><label>Donor</label>
						<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="donor">^ca_entities.preferred_labels.displayname</unit>
						</div>
					</ifcount>
					<ifdef code='ca_object_lots.idno_stub'><div class="unit"><label>Acquisition Year</label>
						<?php print substr($t_object->get("ca_object_lots.idno_stub"), 0, 4); ?>
					</div></ifdef>
				</unit>}}}

				<!-- {{{<ifcount code="ca_objects.related" restrictToTypes="page" min="1">
						<div class="unit"><label>Manuscript Catalog</label>
						<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToTypes="page">
							<unit relativeTo="ca_objects.parent">
								<ifdef code="ca_objects.preferred_labels.name">^ca_objects.preferred_labels.name > </ifdef>
							</unit>
							^ca_objects.preferred_labels.name
						</unit>
				</div></ifcount>}}} -->

				{{{<ifdef code='ca_objects.curatorial_notes'><div class="unit"><label>Curatorial Notes</label>^ca_objects.curatorial_notes</div><hr/></ifdef>}}}

				{{{<ifdef code='ca_objects.related.preferred_labels'><unit relativeTo="ca_objects.related"><div class="unit"><label>Artifact Card</label>Volume ^ca_objects.parent.preferred_labels.name &gt; <l> Page ^ca_objects.preferred_labels.name</l></div></unit><hr/></ifdef>}}}

				<!-- {{{<ifdef code='ca_objects.subject'><div class="unit"><label>Subject</label>^ca_objects.subject%delimiter=,_</div></ifdef>}}} -->
				<?php if($links = caGetSearchLinks($t_object, "ca_objects.subject", ['linkTemplate' => '<li>^LINK</li>']) ?? []) { ?>
					<label>Subject</label><div class="unit"><ul><?= join("\n", $links); ?></ul></div>
				<?php } ?>
				
				<!-- {{{<ifdef code='ca_objects.keywords'><div class="unit"><label>Keywords</label>^ca_objects.keywords%delimiter=,_</div></ifdef>}}} -->
				<?php if($links = caGetSearchLinks($t_object, "ca_objects.keywords", ['linkTemplate' => '<li>^LINK</li>']) ?? []) { ?>
					<label>Keywords</label><div class="unit"><ul><?= join("\n", $links); ?></ul></div>
				<?php } ?>

				{{{<ifcount code="ca_objects.related" min="1" restrictToRelationshipTypes="component" restrictToTypes="full_record">
					<div class="unit">
						<label>Part of</label>
						<unit relativeTo="ca_objects.related" restrictToRelationshipTypes="component" restrictToTypes="full_record" delimiter="<br/>">
							<ifdef code="ca_object_representations.media.icon"><div class='componentIcon'><l>^ca_object_representations.media.icon</l></div></ifdef><l>^ca_objects.preferred_labels (^ca_objects.idno)</l>
						</unit>
				</div></ifcount>}}}

				{{{<ifdef code='field_notes'><div class="unit"><label>Field Notes</label>^field_notes</div></ifdef>}}}

{{{<unit relativeTo="ca_object_lots">
	<unit relativeTo="ca_objects.related" restrictToTypes="archival_item" delimiter=" ">
		<if rule="^ca_objects.archives_type =~ /FIELD NOTES/"><l>^ca_objects.preferred_labels.name</l><br/></if>
	</unit>
</unit>}}}

				{{{<ifdef code='ca_objects.use'><div class="unit"><label>Use</label>^ca_objects.use%delimiter=,_</div></ifdef>}}}

				<!-- {{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><div class="unit"><label>Creator</label>
					<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator">^ca_entities.preferred_labels.displayname</unit>
				</div></ifcount>}}}

				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="collector" min="1"><div class="unit"><label>Collector</label>
					<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="collector">^ca_entities.preferred_labels.displayname</unit>
				</div></ifcount>}}}
				
				{{{<ifcount code="ca_objects.related" min="1" restrictToRelationshipTypes="component" restrictToTypes="component_record"><div class="unit"><label>Components</label>
					<unit relativeTo="ca_objects.related" restrictToRelationshipTypes="component" restrictToTypes="component_record" delimiter="<br/>"><ifdef code="ca_object_representations.media.icon"><div class='componentIcon'><l>^ca_object_representations.media.icon</l></div></ifdef><l>^ca_objects.preferred_labels (^ca_objects.idno)</l></unit>
				</div></ifcount>}}} -->
				
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
