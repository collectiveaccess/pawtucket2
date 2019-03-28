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
 	$va_access_values = caGetUserAccessValues($this->request);
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	
	$vs_representationViewer = trim($this->getVar("representationViewer"));
	
	$vs_detail_tools = "<div id='detailTools'>
						<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask A Curator", "", "", "Contact",  "form", array('id' => $vn_id, 'table' => 'ca_objects'))."</div><!-- end detailTool -->
						<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Order Reproduction", "", "", "ImageLicensing",  "form", array('id' => $vn_id, 'table' => 'ca_objects'))."</div><!-- end detailTool -->
						<div class='detailTool'><a href='#' onclick='jQuery(\"#detailComments\").slideToggle(); return false;'><span class='glyphicon glyphicon-comment'></span>Comments and Tags (".(sizeof($va_comments) + sizeof($va_tags)).")</a></div><!-- end detailTool -->
						<div id='detailComments'>".$this->getVar("itemComments")."</div><!-- end itemComments -->
					</div><!-- end detailTools -->";

	$vs_back_url = $this->getVar("resultsURL");
	
	$va_breadcrumb = array(caNavLink($this->request, _t("Home"), "", "", "", ""));
	if(strpos(strToLower($vs_back_url), "detail") === false){
		if(strpos(strToLower($vs_back_url), "gallery") !== false){
			$va_breadcrumb[] = "<a href='".$vs_back_url."'>Highlights</a>";
		}else{
			$va_breadcrumb[] = "<a href='".$vs_back_url."'>Find: Artifacts</a>";
		}
		$va_breadcrumb[] = $t_object->get("ca_objects.preferred_labels");
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
<?php
	if(sizeof($va_breadcrumb) > 1){
		print "<div class='breadcrumb'>".join(" > ", $va_breadcrumb)."</div>";
	}
?>

		<div class="container"><div class="row">
<?php
		if($vs_representationViewer){
?>
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				<?php print $vs_representationViewer; ?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				<?php print $vs_detail_tools; ?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
<?php
		}else{
?>
			<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
<?php		
		}
?>								
				<H4>{{{^ca_objects.preferred_labels<ifdef code="ca_objects.object_type">, ^ca_objects.object_type</ifdef>}}}</H4>
				{{{<ifdef code="ca_objects.nonpreferred_labels"><div class="unit"><H6>Title</H6><unit relatiecTo="ca_objects" delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Object ID</H6>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.categories.main_categories|ca_objects.categories.subcategories"><div class="unit"><H6>Category</H6>^ca_objects.categories.main_categories<ifdef code="ca_objects.categories.subcategories">, ^ca_objects.categories.subcategories</ifdef></div></ifdef>}}}
				{{{<ifdef code="ca_objects.date.dates_value"><unit relativeTo="ca_objects.date"><if rule="^ca_objects.date.dc_dates_types =~ /Date made/"><div class="unit"><H6>Date Made</H6>^ca_objects.date.dates_value</div></if></unit></ifdef>}}}
				{{{<ifdef code="ca_objects.materials"><div class="unit"><H6>Materials</H6>^ca_objects.materials</div></ifdef>}}}
				{{{<ifdef code="ca_objects.artist_note"><div class="unit"><H6>Artist/Maker/Manufacturer</H6>^ca_objects.artist_note</div></ifdef>}}}
				{{{<ifdef code="ca_objects.place_made"><div class="unit"><H6>Place Made</H6>^ca_objects.place_made</div></ifdef>}}}
				{{{<ifdef code="ca_objects.description"><div class="unit"><H6>Description</H6>^ca_objects.description</div></ifdef>}}}
				
				{{{<ifcount code="ca_occurrences" restrictToTypes="vessel" min="1">
					<div class="unit">
						<H6>Related vessels</H6>
						<unit relativeTo="ca_occurrences" restrictToTypes="vessel" delimiter="<br/>"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><l><i>^ca_occurrences.preferred_labels</i></l> ^ca_occurrences.vessuffix</unit>
					</div>
				</ifcount>}}}
				{{{<ifcount code="ca_entities" min="1">
						<div class="unit">
							<H6><ifcount code="ca_entities" min="1" max="1">Related person/organization</ifcount><ifcount code="ca_entities" min="2">Related people/organizations</ifcount></H6>
							<unit relativeTo="ca_entities" delimiter="<br/>"><b>^relationship_typename</b>: <l>^ca_entities.preferred_labels</l></unit>
						</div>
				</ifcount>}}}
				
				{{{<ifdef code="ca_objects.use_history"><div class="unit"><H6>History of Use</H6>^ca_objects.use_history</div></ifdef>}}}

<?php			
			if(!$vs_representationViewer){
				print $vs_detail_tools;
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