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
						<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask An Archivist", "", "", "Contact",  "form", array('id' => $vn_id, 'table' => 'ca_objects'))."</div><!-- end detailTool -->
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
			$va_breadcrumb[] = "<a href='".$vs_back_url."'>Find: Archival Items</a>";
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
				<H5>{{{<unit>^ca_objects.type_id</unit>}}}</H5><!--- she did not ask for type -->
				<H4>{{{^ca_objects.preferred_labels<ifdef code="ca_objects.GMD"> [<unit relativeTo="ca_objects.GMD" delimiter=", ">^ca_objects.GMD</unit>]</ifdef><ifdef code="OtherTitle"> :  </ifdef> ^OtherTitle <ifdef code="nonpreferred_labels"> =  </ifdef>  ^nonpreferred_labels <ifdef code="creator_name"> / </ifdef>^creator_name}}}</H4>
				{{{<ifdef code="ca_objects.continue_title"><div class="unit"><H6>Continuation of title</H6>...^ca_objects.continue_title</div></ifdef>}}}
				{{{<ifdef code="ca_objects.suptitlnote"><div class="unit"><H6>Supplied title note</H6>^ca_objects.suptitlnote</div></ifdef>}}}
				{{{<ifdef code="ca_objects.alt_title_note"><div class="unit"><H6>Parallel title note</H6>^ca_objects.alt_title_note</div></ifdef>}}}
				{{{<ifcount min="1" code="ca_collections"><div class="unit"><H6>Part of</H6><unit relativeTo="ca_collections"><l>^ca_collections.hierarchy.preferred_labels%delimiter=_»_</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Item number</H6>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.previous_number"><div class="unit"><H6>Previous number(s)</H6>^ca_objects.previous_number%delimeter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.archive_dates.archive_display"><div class="unit"><H6>Date</H6>^ca_objects.archive_dates.archive_display</div></ifdef>}}}
				{{{<ifdef code="ca_objects.pub"><div class="unit"><H6>Publisher</H6>^ca_objects.pub</div></ifdef>}}}
				{{{<ifdef code="ca_objects.physical_description|ca_objects.measurements.height|ca_objects.measurements.width|ca_objects.measurements.depth|ca_objects.measurements.diameter"><div class="unit"><H6>Physical Description</H6>^ca_objects.physical_description<ifdef code="ca_objects.measurements.height"> ; </ifdef>^ca_objects.measurements.height<ifdef code="ca_objects.measurements.width"> x </ifdef>^ca_objects.measurements.width <ifdef code="ca_objects.measurements.depth"> x </ifdef>^ca_objects.measurements.depth <ifdef code="ca_objects.measurements.diameter"> ; </ifdef>^ca_objects.measurements.diameter<ifdef code="ca_objects.measurements.diameter"> (diam.)</ifdef></div></ifdef>}}}
				{{{<ifdef code="ca_objects.history_bio"><div class="unit"><H6>Administrative History / Biographical Sketch</H6>^ca_objects.history_bio</div></ifdef>}}}
				{{{<ifdef code="ca_objects.scope_content"><div class="unit"><H6>Scope & Content</H6>^ca_objects.scope_content</div></ifdef>}}}
				{{{<ifdef code="ca_objects.arrangement"><div class="unit"><H6>Arrangement</H6>^ca_objects.arrangement</div></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><div class="unit"><H6>Languages</H6>^ca_objects.language%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.related_material"><div class="unit"><H6>Related materials</H6>^ca_objects.related_material</div></ifdef>}}}
				{{{<ifdef code="ca_objects.reproRestrictions.reproduction|ca_objects.reproRestrictions.access_restrictions"><div class="unit"><H6>Restrictions</H6><ifdef code="ca_objects.reproRestrictions.reproduction"><b>Reproduction</b>: ^ca_objects.reproRestrictions.reproduction<br/></ifdef><ifdef code="ca_objects.reproRestrictions.access_restrictions"><b>Access: </b>^ca_objects.reproRestrictions.access_restrictions</ifdef></div></ifdef>}}}
				{{{<if rule='^ca_objects.type_id IN ["Archival Item"]'><ifcount code="ca_entities" min="1">
						<div class="unit">
							<H6><ifcount code="ca_entities" min="1" max="1">Related person/organization</ifcount><ifcount code="ca_entities" min="2">Related people/organizations</ifcount></H6>
							<unit relativeTo="ca_entities" delimiter="<br/>"><b>^relationship_typename</b>: <l>^ca_entities.preferred_labels</l></unit>
						</div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="vessel" min="1">
						<div class="unit">
							<H6>Related vessels</H6>
							<unit relativeTo="ca_occurrences" restrictToTypes="vessel" delimiter="<br/>"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><l><i>^ca_occurrences.preferred_labels</i></l> ^ca_occurrences.vessuffix</unit>
						</div>
					</ifcount>
				</if>}}}
				
<?php
				$va_lcsh = $t_object->get("ca_objects.lcsh_terms", array("returnAsArray" => true));
				if(is_array($va_lcsh) && sizeof($va_lcsh)){
					print '<div class="unit"><H6>LC Subject Headings</H6>';
					$va_terms = array();
					foreach($va_lcsh as $vs_term){
						$vn_pos = strpos($vs_term, "[");
						if ($vn_pos !== false) {
     						$vs_term = trim(substr($vs_term, 0, $vn_pos));
						}
						$va_terms[] = caNavLink($this->request, $vs_term, "", "", "MultiSearch", "Index", array("search" => $vs_term));
						
					}
					print join("<br/>", $va_terms);
					print '</div>';
				}
?>
				
				{{{<if rule='^ca_objects.type_id IN ["Map", "Chart", "Ship plan"]'>
					<ifdef code="ca_objects.scale"><div class="unit"><H6>Scale</H6>^ca_objects.scale</div></ifdef>
				</if>}}}
				{{{<if rule='^ca_objects.type_id IN ["Map", "Chart"]'>
					<ifdef code="ca_objects.correct">
						<div class="unit">
							<H6>Corrections</H6>
							<ifdef code="ca_objects.correct.newed"><b>New editions: </b>^ca_objects.correct.newed<br/></ifdef>
							<ifdef code="ca_objects.correct.largecor"><b>Large corrections: </b>^ca_objects.correct.largecor<br/></ifdef>
							<ifdef code="ca_objects.correct.smallcor"><b>Small corrections: </b>^ca_objects.correct.smallcor</ifdef>
						</div>
					</ifdef>
					
					<ifdef code="ca_objects.stateproj"><div class="unit"><H6>Statement of projection</H6>^ca_objects.stateproj</div></ifdef>
					<ifdef code="ca_objects.coord"><div class="unit"><H6>Statement of coordinates</H6>^ca_objects.coord</div></ifdef>
					<ifcount code="ca_entities" restrictToRelationshipTypes="publish" min="1"><div class="unit"><H6>Published by</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="publish"><l>^ca_entities.preferred_labels</l></unit></div></ifdef>
					<ifdef code="ca_objects.artist_note"><div class="unit"><H6>Artist/maker/manufacturer note</H6>^ca_objects.artist_note</div></ifdef>
					<ifdef code="ca_objects.dist"><div class="unit"><H6>Distributor</H6>^ca_objects.dist</div></ifdef>					
				</if>}}}
				{{{<if rule='^ca_objects.type_id IN ["Map", "Chart", "Ship plan"]'><ifdef code="ca_objects.pub_date"><div class="unit"><H6>Original publication date</H6>^ca_objects.pub_date</div></ifdef></if>}}}
				{{{<if rule='^ca_objects.type_id IN ["Chart"]'>
					<ifdef code="ca_objects.chartno"><div class="unit"><H6>Chart number</H6>^ca_objects.chartno</div></ifdef>
					<ifdef code="ca_objects.chartnotes">
						<div class="unit"><H6>Cartographic notes</H6>
							<ifdef code="ca_objects.chartnotes.stateresp"><b>Statement of responsibility: </b>^ca_objects.chartnotes.stateresp<br/></ifdef>
							<ifdef code="ca_objects.chartnotes.sigs"><b>Signatures: </b>^ca_objects.chartnotes.sigs<br/></ifdef>
							<ifdef code="ca_objects.chartnotes.edition_note"><b>Edition note: </b>^ca_objects.chartnotes.edition_note<br/></ifdef>
							<ifdef code="ca_objects.chartnotes.math"><b>Mathematics: </b>^ca_objects.chartnotes.math<br/></ifdef>
							<ifdef code="ca_objects.chartnotes.date_note"><b>Date note: </b>^ca_objects.chartnotes.date_note<br/></ifdef>
							<ifdef code="ca_objects.chartnotes.physdes"><b>Physical description: </b>^ca_objects.chartnotes.physdes
						</div>
					</ifdef>
				</if>}}}
				{{{<if rule='^ca_objects.type_id IN ["Map", "Chart", "Ship plan"]'>
					<ifdef code="ca_objects.ship_plan_note"><div class="unit"><H6>Notes</H6>^ca_objects.ship_plan_note</div></ifdef>
				</if>}}}
				{{{<if rule='^ca_objects.type_id IN ["Map", "Chart"]'>
					<ifcount code="ca_occurrences" restrictToTypes="vessel" min="1">
						<div class="unit">
							<H6>Related vessels</H6>
							<unit relativeTo="ca_occurrences" restrictToTypes="vessel" delimiter="<br/>"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><l><i>^ca_occurrences.preferred_labels</i></l> ^ca_occurrences.vessuffix</unit>
						</div>
					</ifcount>
					<ifcount code="ca_entities" excludeRelationshipTypes="publish" min="1">
						<div class="unit">
							<H6><ifcount code="ca_entities" min="1" max="1" excludeRelationshipTypes="publish">Related person/organization</ifcount><ifcount code="ca_entities" min="2" excludeRelationshipTypes="publish">Related people/organizations</ifcount></H6>
							<unit relativeTo="ca_entities" excludeRelationshipTypes="publish" delimiter="<br/>"><b>^relationship_typename</b>: <l>^ca_entities.preferred_labels</l></unit>
						</div>
					</ifcount>
				</if>}}}
				
				{{{<if rule='^ca_objects.type_id IN ["Ship plan"]'>
					<ifcount code="ca_occurrences" restrictToTypes="vessel" min="1">
						<div class="unit">
							<H6>Vessel portrayed</H6>
							<unit relativeTo="ca_occurrences" restrictToTypes="vessel" delimiter="<br/>"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><l><i>^ca_occurrences.preferred_labels</i></l> ^ca_occurrences.vessuffix</unit>
						</div>
					</ifcount>
					<ifdef code="ca_objects.shipyard"><div class="unit"><H6>Ship yard</H6>^ca_objects.shipyard</div></ifdef>
					<ifdef code="ca_objects.drawing_no"><div class="unit"><H6>Drawing number</H6>^ca_objects.drawing_no</div></ifdef>
					<ifdef code="ca_objects.hullyard_no"><div class="unit"><H6>Hull yard number</H6>^ca_objects.hullyard_no</div></ifdef>
					<ifdef code="ca_objects.measurements.dimension_remarks"><div class="unit"><H6>Physical description note</H6>^ca_objects.measurements.dimension_remarks</div></ifdef>
					<ifdef code="ca_objects.archtechnote.staterespship|ca_objects.archtechnote.sigsship|ca_objects.archtechnote.edition_note_ship|ca_objects.archtechnote.date_note_ship"><div class="unit"><H6>Notes</H6>
						<ifdef code="ca_objects.archtechnote.staterespship"><b>Statement of responsibility: </b>^ca_objects.archtechnote.staterespship<br/></ifdef>
						<ifdef code="ca_objects.archtechnote.sigsship"><b>Signatures: </b>^ca_objects.archtechnote.sigsship<br/></ifdef>
						<ifdef code="ca_objects.archtechnote.edition_note_ship"><b>Edition note: </b>^ca_objects.archtechnote.edition_note_ship<br/></ifdef>
						<ifdef code="ca_objects.archtechnote.date_note_ship"><b>Date note: </b>^ca_objects.archtechnote.date_note_ship<br/></ifdef>
					</div></ifdef>
					<ifcount code="ca_entities" min="1">
						<div class="unit">
							<H6><ifcount code="ca_entities" min="1" max="1">Related person/organization</ifcount><ifcount code="ca_entities" min="2">Related people/organizations</ifcount></H6>
							<unit relativeTo="ca_entities" delimiter="<br/>"><b>^relationship_typename</b>: <l>^ca_entities.preferred_labels</l></unit>
						</div>
					</ifcount>
				</if>}}}
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