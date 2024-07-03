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
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-12 text-center'>
					<H2 class="uk-h1">{{{^ca_objects.preferred_labels.name}}}{{{<ifdef code="ca_objects.alutiiq_title"> - ^ca_objects.alutiiq_title</ifdef>}}}{{{<ifdef code="ca_objects.pronunciation_audio_clip"> <span id='playPronunciation'><span class='uk-link el-image uk-icon' uk-icon='icon: microphone;'><svg width='20' height='20' viewBox='0 0 20 20'><line fill='none' stroke='#000' x1='10' x2='10' y1='16.44' y2='18.5'></line><line fill='none' stroke='#000' x1='7' x2='13' y1='18.5' y2='18.5'></line><path fill='none' stroke='#000' stroke-width='1.1' d='M13.5 4.89v5.87a3.5 3.5 0 0 1-7 0V4.89a3.5 3.5 0 0 1 7 0z'></path><path fill='none' stroke='#000' stroke-width='1.1' d='M15.5 10.36V11a5.5 5.5 0 0 1-11 0v-.6'></path></svg></span></span></ifdef>}}}</H2>
					<hr/>
					
	
    				
					
					
					{{{<ifcount code="ca_collections" min="1"><div class="link"><unit relativeTo="ca_collections" delimiter="<br/>"><ifcount code="ca_entities" min="1"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l> > </unit></ifcount>^ca_collections.preferred_labels.name</unit></div></ifcount>}}}
					<HR>
				
				</div>
			</div>
			<div class="row">
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if($vs_rep_viewer = trim($this->getVar("representationViewer"))){
					print $vs_rep_viewer;
					print '<div id="detailAnnotations"></div>';
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
				}else{
					$o_icons_conf = caGetIconsConfig();
					$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
					if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
						$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x' aria-label='placeholder image'></i>";
					}
					$vs_default_placeholder_tag = "<div class='detailImgPlaceholder'>".$vs_default_placeholder."</div>";

					$t_list_item = new ca_list_items();
					$t_list_item->load($t_object->get("type_id"));
					$vs_typecode = $t_list_item->get("idno");
					if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
						$vs_thumbnail = "<div class='detailImgPlaceholder'>".$vs_type_placeholder."</div>";
					}else{
						$vs_thumbnail = $vs_default_placeholder_tag;
					}
					print $vs_thumbnail;
				}
?>				
				
				
				
				
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
			
			<div class='col-sm-6 col-md-6 col-lg-6'>				
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.material"><div class="unit"><label>Material</label>^ca_objects.material</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.measurement_type|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth|ca_objects.dimensions.dimensions_length|ca_objects.dimensions.dimensions_weight|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_circumference|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.measurement_notes"><div class="unit"><label>Dimensions</label>
					<unit relativeTo="ca_objects.dimensions" delimiter="<br/><br/>">
						<ifdef code="ca_objects.dimensions.measurement_type"><b>^ca_objects.dimensions.measurement_type: </b></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_height">Height: ^ca_objects.dimensions.dimensions_height </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_width">Width: ^ca_objects.dimensions.dimensions_width </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_depth">Depth: ^ca_objects.dimensions.dimensions_depth </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_length">Length: ^ca_objects.dimensions.dimensions_length </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_weight">Weight: ^ca_objects.dimensions.dimensions_weight </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_diameter">Diameter: ^ca_objects.dimensions.dimensions_diameter </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_circumference">Circumference: ^ca_objects.dimensions.dimensions_circumference </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_thickness">Thickness: ^ca_objects.dimensions.dimensions_thickness </ifdef>
						<ifdef code="ca_objects.dimensions.measurement_notes"><br/>^ca_objects.dimensions.measurement_notes</ifdef>
					</unit>
				</div></ifdef>}}}
				{{{<ifdef code="ca_objects.age_external_objects"><div class="unit"><label>Age</label>^ca_objects.age_external_objects</div></ifdef>}}}
				{{{<ifdef code="ca_objects.traditions"><div class="unit"><label>Traditions</label>^ca_objects.traditions%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_collections.credit_line"><div class="unit"><label>Credit</label>^ca_collections.credit_line</div></ifdef>}}}
				{{{<ifdef code="ca_objects.provenance"><div class="unit"><label>Provenance</label>^ca_objects.provenance</div></ifdef>}}}
				{{{<ifdef code="ca_objects.website"><div class="unit"><unit relativeTo="ca_objects.website" delimiter="<br/>"><a href="^ca_objects.website" target="_blank">^ca_objects.website <i class="fa fa-external-link" aria-hidden="true"></i></a></unit></div></ifdef>}}}
				
				
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
{{{<ifdef code="ca_objects.pronunciation_audio_clip">	
	$(document).ready(function() {
    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', '^ca_objects.pronunciation_audio_clip.original.url');
    
    
    
    $('#playPronunciation').click(function() {
        return audioElement.paused ? audioElement.play() : audioElement.pause();
    });
});
</ifdef>}}}
</script>