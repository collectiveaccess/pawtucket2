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
	$t_list = new ca_lists();
	$vn_obverse_type_id = $t_list->getItemIDFromList("object_representation_types", "obverse");
	$vn_reverse_type_id = $t_list->getItemIDFromList("object_representation_types", "reverse");
		
	# --- get representations
	$va_reps_obverse = $t_object->getRepresentations(array("large"), null, array("restrictToTypes" => array("obverse"), "checkAccess" => $va_access_values));
	$va_reps_reverse = $t_object->getRepresentations(array("large"), null, array("restrictToTypes" => array("reverse"), "checkAccess" => $va_access_values));
	$va_reps = array();
	if(is_array($va_reps_obverse) && sizeof($va_reps_obverse)){
		foreach($va_reps_obverse as $vn_rep_id => $va_rep_info){
			$va_reps[$vn_rep_id] = array("media" => $va_rep_info["tags"]["large"], "type" => "Obverse");
		}
	}
	if(is_array($va_reps_reverse) && sizeof($va_reps_reverse)){
		foreach($va_reps_reverse as $vn_rep_id => $va_rep_info){
			$va_reps[$vn_rep_id] = array("media" => $va_rep_info["tags"]["large"], "type" => "Reverse");
		}
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
		<div class="container detailMainArea">
			<div class="row">
				<div class='col-sm-12 col-md-8 col-lg-7 col-lg-offset-1'>
					<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				</div>
				<div class='col-sm-12 col-md-4 col-lg-3'>
<?php
					print '<div id="detailTools">';
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
					if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						print "<div class='detailTool'>".$va_add_to_set_link_info["icon"]."<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array('object_id' => $t_object->get("object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>Add to ".$va_add_to_set_link_info["name_singular"]."</a></div>";
					}
					print '</div><!-- end detailTools -->';			
?>					
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
					<HR>
				</div>
			</div>

<?php
		if(is_array($va_reps) && sizeof($va_reps)){
?>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>

<?php
					$t_rep = new ca_object_representations();
					$vn_col = 0;
					foreach($va_reps as $vn_rep_id => $va_rep){
						if($vn_col == 0){
							print "<div class='row detailMedia'>\n";
						}
						print "<div class='col-xs-12 col-sm-6'>";
						$t_rep->load($vn_rep_id);
						print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "Detail", "GetMediaOverlay", null, array("id" => $t_object->get("object_id"), "representation_id" => $vn_rep_id, "display" => "detail", "context" => "coins", "overlay" => 1))."\"); return false;'>".$va_rep["media"]."</a>";
						print "<div class='detailMediaCaption'>".$va_rep["type"]."</div>";
						print caRepToolbar($this->request, $t_rep, $t_object, array("display" => "detail", "context" => "coins"));
						print "</div>\n";
						if($vn_col == 2){
							$vn_col = 0;
							print "</div><!-- end row-->\n";
						}
						$vn_col++;
					}
					if($vn_col > 0){
						print "</div><!-- end row-->\n";
					}
?>				
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
					<hr></hr>
				</div>
			</div>
<?php
		}
?>
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
					<div class="row">
						<div class="col-sm-6">
							{{{<ifdef code="ca_objects.idno"><H6>Identifier</H6>^ca_objects.idno<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.material"><H6>Material</H6>^ca_objects.material<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.weight"><H6>Weight</H6>^ca_objects.weight<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.diameter"><H6>Diameter</H6>^ca_objects.diameter<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.measurements"><H6>Measurements</H6>^ca_objects.measurements<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.axis"><H6>Axis</H6>^ca_objects.axis<br/></ifdef>}}}
						</div>
						<div class="col-sm-6">
							{{{<ifdef code="ca_objects.region"><H6>Region</H6>^ca_objects.region<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.denomination"><H6>Denomination</H6>^ca_objects.denomination<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.obverse"><H6>Obverse</H6>^ca_objects.obverse<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.obverse_inscription"><H6>Obverse Inscription</H6>^ca_objects.obverse_inscription<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.obverse_symbol"><H6>Obverse Symbol</H6>^ca_objects.obverse_symbol<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.reverse"><H6>Reverse</H6>^ca_objects.reverse<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.reverse_inscription"><H6>Reverse Inscription</H6>^ca_objects.reverse_inscription<br/></ifdef>}}}
							{{{<ifdef code="ca_objects.reverse_symbol"><H6>Reverse Symbol</H6>^ca_objects.reverse_symbol<br/></ifdef>}}}
							{{{<ifcount code="ca_list_items" min="1"><H6>Iconographic Classification</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter=", "><unit relativeTo="ca_list_items">^ca_list_items.preferred_labels.name_plural</unit></unit>}}}
							
						</div>
					</div>
					
					
				
					{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdef>}}}
			
					
						<div class="row">
							<div class="col-sm-6">		
								{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
								{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
								{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
							
							
								{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
								{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
								{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
							
								
							</div><!-- end col -->				
							<div class="col-sm-6 colBorderLeft">
								{{{map}}}
							</div>
						</div><!-- end row -->
				</div>
			</div>
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