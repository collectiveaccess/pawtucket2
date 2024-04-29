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
	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
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
			<div class='col-sm-12 col-md-9'>
				<div class="detailBg">
					<div class="row">
						<div class='col-sm-12 col-md-9'>
							{{{representationViewer}}}
<?php
							if(($t_object->get("ca_objects.allow_zoom", array("convertCodesToDisplayText" => true)) == "yes") && ($vn_representation_id = $this->getVar("representation_id"))){
								print "<div class='zoomButton'><a href='#' class='zoomButton' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => $this->request->getAction(), 'id' => $vn_id, 'representation_id' => $vn_representation_id, 'overlay' => 1))."\"); return false;' aria-label='"._t("Zoom")."'><span class='glyphicon glyphicon-zoom-in' aria-label='Zoom'></span></a></div>\n";
		
							}
?>
							<div id="detailAnnotations"></div>
				
							<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
						</div><!-- end col -->			
						<div class='col-sm-12 col-md-3'>
							{{{<ifdef code='ca_objects.preferred_labels|ca_objects.date'><H1><ifdef code='ca_objects.preferred_labels'><i>^ca_objects.preferred_labels</i>, </ifdef>^ca_objects.date</H1></ifdef>}}}
<?php
							$vs_idno_label = "";
							if (!preg_match("/[a-z]/i", strToLower($t_object->get("ca_objects.idno")))) {
								$vs_idno_label = "MAP # ";
							}
?>
							{{{<div class='unit'><ifdef code='ca_objects.idno'><?php print $vs_idno_label; ?>^ca_objects.idno<br/></ifdef><ifdef code='ca_objects.dimensions'>^ca_objects.dimensions inches<br/></ifdef><ifdef code='ca_objects.medium'>^ca_objects.medium</ifdef></div>}}}
<?php
							# copyright statement is set as global value
							if($vs_copyright = $this->getVar("copyright_notice")){
								print "<div class='unit small'>".$vs_copyright."</div>";
							}
							$t_list_item = new ca_list_items;
							if($va_keywords = $t_object->get("ca_objects.keywords", array("returnAsArray" => true))){
								print "<div class='unit'><label>Keywords</label>";
								$qr = caMakeSearchResult('ca_list_items', array_values($va_keywords), ['sort' => 'ca_list_items.preferred_labels.name_singular']);
								while($qr->nextHit()) {
									print caNavLink($this->request, $qr->get("ca_list_items.preferred_labels.name_singular"), "", "", "Browse", "artwork", array("facet" => "keyword_facet", "id" => $qr->getPrimaryKey()))."<br/>";
								}
								print "</div>";
							}
							if($t_object->get("ca_objects.related")){
								print "<div class='unit text-center'>".caNavLink($this->request, "Related Artwork", "btn btn-light btn-sm", "", "Browse",  "artwork", array('dontSetFind' => 1, 'facet' => 'related_object_facet', 'id' => $t_object->get("ca_objects.object_id")))."</div>";
							}
	?>						
						</div><!-- end col -->
					</div>
				</div>
			</div>
			<div class='col-sm-12 col-md-3'>
<?php
				print '<div id="detailTools">';
				if($this->getVar("representation_id") && (($t_object->get('ca_objects.download_for_artestar', ['convertCodesToIdno' => true]) === 'yes') && $this->request->user->hasRole('limited_access')) || $this->request->user->hasRole('full_access')){
					print "<div class='detailTool'><span class='glyphicon glyphicon-download' aria-label='"._t("Download Image")."'></span>".caNavLink($this->request, "Download Image", "", "", "Detail",  "DownloadMedia", array('context' => 'objects', 'object_id' => $vn_id, 'version' => 'original', 'download' => 1))."</div>";
				} else {
					print "<div class='detailTool' style='opacity: 0.5;'><span class='glyphicon glyphicon-download' aria-label='"._t("Download Image (disabled)")."'></span>Download Image</div>";
				}
				if ($vn_pdf_enabled) {
					print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download PDF")."'></span>".caDetailLink($this->request, "Download PDF Summary", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_fullpage'))."</div>";
				}
				print "<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array("object_id" => $t_object->get("object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]." ".$va_add_to_set_link_info["link_text"]."</a></div>";
				print "<div class='detailTool'><span class='glyphicon glyphicon-envelope' aria-label='"._t("Inquire")."'></span>".caNavLink($this->request, "Inquire", "", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
				print '</div><!-- end detailTools -->';
?>			
			</div>
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
		$(window).load(function() {
			$(".notificationMessage").fadeOut(4000);
		});
	});
</script>
