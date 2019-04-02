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
	$va_access_values = caGetUserAccessValues($this->request);
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
<?php
		$vs_rep_viewer = trim($this->getvar("representationViewer"));

		$vs_tools = "";
		# Comment and Share Tools
		if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
				
			$vs_tools .= '<div id="detailTools">';
			if ($vn_pdf_enabled) {
				$vs_tools .= "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download Printable PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
			}
			$vs_tools .= '</div><!-- end detailTools -->';
		}				

		if($vs_rep_viewer){
?>

			<div class='col-sm-6'>
				<?php print $vs_rep_viewer; ?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>				
<?php
				print $vs_tools;
?>				
			</div>
			<div class='col-sm-6'>
<?php
		}else{
?>
			<div class='col-sm-12'>
<?php
		}
?>
				{{{<ifdef code="ca_objects.preferred_labels"><div class="unit"><H6>Title</H6>^ca_objects.preferred_labels</div></ifdef>}}}
				{{{<ifdef code="ca_objects.author.author_name"><div class="unit"><H6>Author</H6>^ca_objects.author.author_name</div></ifdef>}}}
<?php
				$vs_pub = $t_object->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='publisher' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
				if(!$vs_pub){
					$vs_pub = $t_object->get("ca_objects.publisher", array("delimiter" => ", "));
				}
				if($vs_pub){
					print "<div class='unit'><H6>Publisher</H6>".$vs_pub."</div>";
				}
?>
				{{{<ifdef code="ca_objects.common_date"><div class="unit"><H6>Year</H6>^ca_objects.common_date%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.library"><div class="unit"><H6>Library</H6>^ca_objects.library%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.book_category"><div class="unit"><H6>Media Type</H6>^ca_objects.book_category%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.call_number"><div class="unit"><H6>Call Number</H6>^ca_objects.call_number%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.artwork_status"><div class="unit"><H6>Tags</H6>^ca_objects.artwork_status%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.remarks"><div class="unit"><H6>Notes</H6>^ca_objects.remarks%delimiter=,_</div></ifdef>}}}
				
<?php
				if(!$vs_rep_viewer){
					print $vs_tools;
				}
?>						
			</div><!-- end col -->
		</div><!-- end row -->
		
<?php
				$va_rel_artworks = $t_object->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("references"), "returnAsArray" => true));
				if(is_array($va_rel_artworks) && sizeof($va_rel_artworks)){
					$qr_res = caMakeSearchResult("ca_objects", $va_rel_artworks);
					$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";
?>
					<div class="row">
						<div class="col-sm-12">
							<br/><hr/><br/><H5>Works Referenced</H5>
						</div>
					</div>
					<div class='row'>
<?php
					while($qr_res->nextHit()){
						$vn_id = $qr_res->get("ca_objects.object_id");
						$vs_idno_detail_link 	= "<small>".caDetailLink($this->request, $qr_res->get("ca_objects.idno"), '', 'ca_objects', $vn_id)."</small><br/>";
						$vs_label_detail_link 	= caDetailLink($this->request, italicizeTitle($qr_res->get("ca_objects.preferred_labels")), '', 'ca_objects', $vn_id).(($qr_res->get("ca_objects.common_date")) ? ", ".$qr_res->get("ca_objects.common_date") : "");
						if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
						$vs_info = null;
						$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);				

						print "<div class='bResultItemCol col-xs-12 col-sm-6 col-md-3'>
			<div class='bResultItem' id='row{$vn_id}' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
				<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
				<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
					<div class='bResultItemText'>
						{$vs_idno_detail_link}{$vs_label_detail_link}
					</div><!-- end bResultItemText -->
				</div><!-- end bResultItemContent -->
			</div><!-- end bResultItem -->
		</div><!-- end col -->";

						
					}
					print "</div><!-- end row -->";
					
				}
?>		
		</div><!-- end container -->
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