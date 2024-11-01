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
			<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
<?php
				print "<div class='pull-right'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
?>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR>
				
			</div>
		</div>
		<div class="row">
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
				$vs_copyright = $t_object->get("ca_objects.copyright", array("convertCodesToDisplayText" => true));
				if($vs_copyright){
					print "<div class='unit'><label>Copyright</label>";
					switch(strToLower($vs_copyright)){
						case "copyright undetermined":
							 if($vs_tmp = $this->getVar("copyright_undetermined")){
							 	print $vs_tmp;
							 }else{
							 	print $vs_copyright;
							 }
						break;
						# ------------
						case "in copyright":
							 if($vs_tmp = $this->getVar("in_copyright")){
							 	print $vs_tmp;
							 }else{
							 	print $vs_copyright;
							 }
						break;
						# ------------
						case "commodore license":
							 if($vs_tmp = $this->getVar("commodore_license")){
							 	print $vs_tmp;
							 }else{
							 	print $vs_copyright;
							 }
						break;
						# ------------
						case "crumpington license":
							 if($vs_tmp = $this->getVar("trumpington_license")){
							 	print $vs_tmp;
							 }else{
							 	print $vs_copyright;
							 }
						break;
						# ------------
						default:
							print $vs_copyright;
						break;
						# ------------
					}
					print "</div>";
				}
?>
				{{{<ifcount code="ca_objects.related" min="1">
					<hr/>
					<div class="unit"><label>See Also</label>
					<unit relativeTo="ca_objects.related" delimiter=" ">
						<div class="unit">
							<div class="row">
								<ifdef code="ca_object_representations.media.iconlarge"><div class="col-xs-2"><l>^ca_object_representations.media.iconlarge</l></div></ifdef>
								<div class="col-xs-10"><l>^ca_objects.preferred_labels.name</l></div>
							</div>
						</div>
					</unit>
					</div>
				</ifcount>}}}
<?php
					$t_set = new ca_sets();
					$va_sets = $t_set->getSetsForItem("ca_objects", $t_object->get("ca_objects.object_id"), array("setType" => "public_presentation", "checkAccess" => $va_access_values));
					if(is_array($va_sets) && sizeof($va_sets)){
						print "<HR/><div class='unit'><h6>Part of ".((sizeof($va_sets) > 1) ? "Galleries" : "gallery")."</h6>";
						foreach($va_sets as $va_set){
							$va_set = array_pop($va_set);
							print "<div>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $va_set["set_id"])."</div>";
						}
						print "</div>";
					}
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>				
				{{{<ifdef code="ca_objects.nonpreferred_labels"><div class="unit"><label>Alternate Title(s)</label>^ca_objects.nonpreferred_labels.name</div></ifdef>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.alt_id"><div class="unit"><label>Alternate Identifier(s)</label>^ca_objects.alt_id%delimiter=,_</div></ifdef>}}}
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Collection</label><unit relativeTo="ca_collections"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></unit></div></ifcount>}}}
				
<?php
				if ($va_entity_rels = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true, 'exclude_relationship_types' => array("partner_organization")))) {
					$va_entities_by_type = array();
					foreach ($va_entity_rels as $va_key => $va_entity_rel) {
						$t_rel = new ca_objects_x_entities($va_entity_rel);
						$vn_type_id = $t_rel->get('ca_relationship_types.preferred_labels');
						$va_entities_by_type[$vn_type_id][] = $t_rel->get('ca_entities.preferred_labels');
					}
					print "<div class='unit'>";
					foreach ($va_entities_by_type as $va_type => $va_entity_id) {
						print "<h6>".$va_type."(s)</h6>";
						foreach ($va_entity_id as $va_key => $va_entity_link) {
							print "<div>".caNavLink($this->request, $va_entity_link, '', '', 'browse', 'objects', array('facet' => 'entity_facet', 'id' => $t_rel->get('ca_entities.entity_id')))."</div>";
						} 
					}
					print "</div>";
				}				
?>
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="partner_organization" min="1"><div class="unit"><label>Partner Organization<ifcount code="ca_entities" restrictToRelationshipTypes="partner_organization" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="partner_organization" delimiter="<br/>"><ifdef code="ca_entities.url"><a href="^ca_entities.url">^ca_entities.preferred_labels.displayname <i class="fa fa-external-link"></i></a></ifdef><ifnotdef code="ca_entities.url">^ca_entities.preferred_labels.displayname</ifnotdef></unit></div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.unitdate.dacs_date_text"><div class="unit"><label>Date</label><unit relativeTo="ca_objects.unitdate" delimiter="<br/>"><ifdef code="ca_objects.unitdate.dacs_dates_labels">^ca_objects.unitdate.dacs_dates_labels: </ifdef>^ca_objects.unitdate.dacs_date_text</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.material_type_av"><div class="unit"><label>Material Type</label>^ca_objects.material_type_av%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.material_type_photo"><div class="unit"><label>Material Type</label>^ca_objects.material_type_photo%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.material_type_artifact"><div class="unit"><label>Material Type</label>^ca_objects.material_type_artifact%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.material_type_map"><div class="unit"><label>Material Type</label>^ca_objects.material_type_map%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.material_type_arch_drawings"><div class="unit"><label>Material Type</label>^ca_objects.material_type_arch_drawings%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.material_type_arch_manuscript"><div class="unit"><label>Material Type</label>^ca_objects.material_type_manuscript%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.medium"><div class="unit"><label>Medium</label>^ca_objects.medium%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.duration"><div class="unit"><label>Duration</label>^ca_objects.duration%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.display_dimensions"><div class="unit"><label>Dimensions</label><unit relativeTo="ca_objects.dimensions" delimiter="<br/><br/>"><ifdef code="ca_objects.dimensions.dimension_types">^ca_objects.dimensions.dimension_types: </ifdef>^ca_objects.dimensions.display_dimensions</unit><ifdef code="ca_objects.dimensions.dimensions_notes"><br/>^ca_objects.dimensions.dimensions_notes</ifdef></div></ifdef>}}}
				{{{<ifdef code="ca_objects.preferCite"><div class="unit"><label>Preferred Citation</label>^ca_objects.preferCite</div></ifdef>}}}
				{{{<ifdef code="ca_objects.custodhist"><div class="unit"><label>Provenance</label>^ca_objects.custodhist</div></ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.geonames"><div class="unit"><label>Geonames</label>^ca_objects.geonames%delimiter=<br/></div></ifdef>}}}
				{{{<ifdef code="ca_objects.external_link.url_entry"><div class="unit"><label>External Links</label><unit relativeTo="ca_objects.external_link" delimiter="<br/>"><a href="^ca_objects.external_link.url_entry" target="_blank"><ifdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_source</ifdef><ifnotdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_entry</ifnotdef> <i class="fa fa-external-link"></i></a></unit></div></ifdef>}}}
				
<?php
				$va_all_subjects = array();
			
				foreach(array("local_subjects", "LcshSubjects", "LcshNames", "LcshGenre", "aat") as $vs_field){
					$va_lc = $t_object->get("ca_objects.".$vs_field, array("returnAsArray" => true, "convertCodesToDisplayText" => true));
					$va_lc_names_processed = array();
					if(is_array($va_lc) && sizeof($va_lc)){
						foreach($va_lc as $vs_lc_terms){
							if($vs_lc_terms){
								$vs_lc_term = "";
								if($vs_lc_terms && (strpos($vs_lc_terms, " [") !== false)){
									$vs_lc_term = mb_substr($vs_lc_terms, 0, strpos($vs_lc_terms, " ["));
								}else{
									$vs_lc_term = $vs_lc_terms;
								}
								$va_all_subjects[strToLower($vs_lc_term)] = caNavLink($this->request, $vs_lc_term, "", "", "Search", "objects", array("search" => $vs_lc_term));
							}
						}
					}
				}
				if(is_array($va_all_subjects) && sizeof($va_all_subjects)){
					print "<hr></hr>";

					ksort($va_all_subjects);
					print "<div class='unit'><label>Subject(s)</label>".join("<br/>", $va_all_subjects)."</div>";
				}
?>
				{{{map}}}						
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
