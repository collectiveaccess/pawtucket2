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
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");

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
			<div class='col-sm-6 col-md-6 col-lg-6' style='padding-bottom:50px;'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($vs_source = $t_object->get('ca_objects.object_source', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Object Source</h6>".$vs_source."</div>";
				}
				if ($vs_identifier = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Identifier</h6>".$vs_identifier."</div>";
				}
				if ($vs_rbs_no = $t_object->get('ca_object_lots.preferred_labels')) {
					print "<div class='unit'><h6>RBS number</h6>".$vs_rbs_no." (".$t_object->get('ca_object_lots.idno_stub').")</div>";
				}
				if ($vs_call = $t_object->get('ca_objects.call_number')) {
					print "<div class='unit'><h6>Call Number</h6>".$vs_call."</div>";
				}
				if ($vs_author = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('author')))) {
					print "<div class='unit'><h6>Author</h6>".$vs_author."</div>";
				}
				if ($vs_date = $t_object->get('ca_objects.date')) {
					print "<div class='unit'><h6>Date of Publication</h6>".$vs_date."</div>";
				}	
				if ($vs_date_comments = $t_object->get('ca_objects.date_comments')) {
					print "<div class='unit'><h6>Date Comments</h6>".$vs_date_comments."</div>";
				}	
				if ($sequential_designation = $t_object->get('ca_objects.sequential_designation')) {
					print "<div class='unit'><h6>Sequential Designation/Dates of Publication</h6>".$sequential_designation."</div>";
				}	
				
				if ($vs_publisher = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('publisher')))) {
					print "<div class='unit'><h6>Publisher</h6>".$vs_publisher."</div>";
				}	
				if ($vs_pub_statement = $t_object->get('ca_objects.pub_dist')) {
					print "<div class='unit'><h6>Publication/Distribution statement</h6>".$vs_pub_statement."</div>";
				}
				if ($vs_place = $t_object->get('ca_objects.place')) {
					print "<div class='unit'><h6>Place</h6>".$vs_place."</div>";
				}
				if ($vs_place_notes = $t_object->get('ca_objects.place_notes')) {
					print "<div class='unit'><h6>Place Notes</h6>".$vs_place_notes."</div>";
				}	
				if ($vs_series = $t_object->get('ca_objects.series')) {
					print "<div class='unit'><h6>Series</h6>".$vs_series."</div>";
				}
				if ($vs_description = $t_object->get('ca_objects.description')) {
					print "<div class='unit'><h6>Physical Description</h6>".$vs_description."</div>";
				}
				if ($vs_edition_note = $t_object->get('ca_objects.edition_note')) {
					print "<div class='unit'><h6>Edition Note</h6>".$vs_edition_note."</div>";
				}
				if ($vs_volume = $t_object->get('ca_objects.volume')) {
					print "<div class='unit'><h6>Volume</h6>".$vs_volume."</div>";
				}
				if ($vs_dimensions = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length L</ifdef><ifdef code="ca_objects.dimensions.dimensions_length,ca_objects.dimensions.dimensions_width"> x </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_width,ca_objects.dimensions.dimensions_height"> x </ifdef><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_height,ca_objects.dimensions.dimensions_depth"> x </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth D</ifdef></unit>')) {
					print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions."</div>";
				}
				if ($vs_dimensions_legacy = $t_object->get('ca_objects.dimensions_legacy')) {
					print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions_legacy."</div>";
				}
				if ($vs_format = $t_object->get('ca_objects.format', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Format</h6>".$vs_format."</div>";
				}
				if ($vs_article = $t_object->get('ca_objects.article_title')) {
					print "<div class='unit'><h6>Title of Article</h6>".$vs_article."</div>";
				}
				if ($vs_pagination = $t_object->get('ca_objects.pagination')) {
					print "<div class='unit'><h6>Pagination</h6>".$vs_pagination."</div>";
				}
				if ($vs_copies = $t_object->get('ca_objects.copies')) {
					print "<div class='unit'><h6>Copies</h6>".$vs_copies."</div>";
				}	
				if ($vs_notes = $t_object->getWithTemplate('<unit delimiter="<br/>">^ca_objects.notes</unit>')) {
					print "<div class='unit notes'><h6>Notes</h6><p>".$vs_notes."</p></div>";
				}	
				if ($summary_holdings = $t_object->get('ca_objects.summary_holdings')) {
					print "<div class='unit'><h6>Summary Holdings</h6>".$summary_holdings."</div>";
				}

?>

				{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="author,publisher,artist,craftsperson">
					<div class='unit'>
						<h6>Related Entities</h6>
						<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="author,publisher,artist,craftsperson">
							^ca_entities.preferred_labels (^relationship_typename)
						</unit>
					</div>
				</ifcount>}}}

<?=


				$vs_teaching = $t_object->get('ca_objects.teaching_points', array('delimiter' => ', '));
				print "<div class='unit'><h6>Teaching Points";
				if($this->request->isLoggedIn()){
?>
					&nbsp;<span class='teachingpoint' data-toggle="popover" data-trigger="hover" data-content="Click to add or edit teaching points."><i class="fa fa-pencil-square-o" aria-hidden="true" onClick="$('#teachingPointsText').toggle(); $('#teachingPointsForm').toggle(); return false;"></i></span>
<?php
				}
				print "</h6><span id='teachingPointsText'>".$vs_teaching."</span>";
				if($this->request->isLoggedIn()){
?>
					<form id="teachingPointsForm" style="display:none;">
						<input type="text" class="form-control" name="teaching_points" value="<?php print $vs_teaching; ?>" autocomplete="off" style="width:90%; float:left;">&nbsp;&nbsp;<button type="submit" class="btn" style="background-color:#FFF; padding-left:0px; padding-right:0px;"><i class="fa fa-arrow-circle-right" style="font-size:20px;"></i></button>
						<input type="hidden" name="object_id" value="<?php print $t_object->get('ca_objects.object_id'); ?>">
						<input type="hidden" name="field" value="teaching_points">
						
						<div style="clear:left;"></div>
					</form>
					<script type='text/javascript'>
						jQuery(document).ready(function() {
							jQuery('#teachingPointsForm').submit(function(e){		
								jQuery('#teachingPointsText').load(
									'<?php print caNavUrl($this->request, '', 'UpdateObjectMd', 'ajaxSave', null); ?>',
									jQuery('#teachingPointsForm').serialize(),
									function(){
										$('#teachingPointsText').toggle();
										$('#teachingPointsForm').toggle();
									}
								);
								
								e.preventDefault();
								return false;
							});
						});
					</script>
<?php
				}					
				print "</div>";
			
				if ($vs_collections = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Related Collections</h6>".$vs_collections."</div>";
				}
 
				$vs_enriched = "";
				if ($va_artist = $t_object->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('artist')))) {
					$vs_enriched.= "<div class='unit'><h6>Artist</h6>".$va_artist."</div>";
				}
				if ($va_craftsperson = $t_object->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('craftsperson')))) {
					$vs_enriched.= "<div class='unit'><h6>Craftsperson</h6>".$va_craftsperson."</div>";
				}
				if ($vs_prov_notes = $t_object->get('ca_objects.provenance')) {
					$vs_enriched.=  "<div class='unit'><h6>Provenance Notes</h6>".$vs_prov_notes."</div>";
				}
				if ($vs_isbn = $t_object->get('ca_objects.isbn')) {
					$vs_enriched.=  "<div class='unit'><h6>ISBN</h6>".$vs_isbn."</div>";
				}
				if ($vs_leafno = $t_object->get('ca_objects.leafno')) {
					$vs_enriched.=  "<div class='unit'><h6>Leaf Number</h6>".$vs_leafno."</div>";
				}
				if ($vs_leafsize = $t_object->get('ca_objects.leafsize')) {
					$vs_enriched.=  "<div class='unit'><h6>Leaf Size</h6>".$vs_leafsize."</div>";
				}
				if ($vs_checkbook = $t_object->get('ca_objects.checkbook')) {
					$vs_enriched.=  "<div class='unit'><h6>Checkbook</h6>".$vs_checkbook."</div>";
				}	
				if ($vs_format = $t_object->get('ca_objects.format', array('convertCodesToDisplayText' => true))) {
					$vs_enriched.=  "<div class='unit'><h6>Format</h6>".$vs_format."</div>";
				}
				if ($vs_collation = $t_object->get('ca_objects.collation')) {
					$vs_enriched.=  "<div class='unit'><h6>Collation</h6>".$vs_collation."</div>";
				}	
				if ($vs_signings = $t_object->get('ca_objects.signings')) {
					$vs_enriched.=  "<div class='unit'><h6>Signings</h6>".$vs_signings."</div>";
				}	
				if ($vs_dcrb = $t_object->get('ca_objects.dcrb_pag')) {
					$vs_enriched.=  "<div class='unit'><h6>DCRB pag</h6>".$vs_dcrb."</div>";
				}	
				if ($vs_code = $t_object->get('ca_objects.code')) {
					$vs_enriched.=  "<div class='unit'><h6>Code</h6>".$vs_code."</div>";
				}
				if ($vs_cohort = $t_object->get('ca_objects.cohort')) {
					$vs_enriched.=  "<div class='unit'><h6>Cohort</h6>".$vs_cohort."</div>";
				}
				if ($vs_day_legacy = $t_object->get('ca_objects.day_legacy')) {
					$vs_enriched.=  "<div class='unit'><h6>Day</h6>".$vs_day_legacy."</div>";
				}	
				if ($vs_difficulty = $t_object->get('ca_objects.difficulty', array('convertCodesToDisplayText' => true))) {
					$vs_enriched.=  "<div class='unit'><h6>Difficulty</h6>".$vs_difficulty."</div>";
				}
				if ($vs_conservation = $t_object->get('ca_objects.conservation')) {
					$vs_enriched.=  "<div class='unit'><h6>Conservation</h6>".$vs_conservation."</div>";
				}
				if ($vs_bindings = $t_object->get('ca_objects.bindings')) {
					$vs_enriched.=  "<div class='unit'><h6>Bindings</h6>".$vs_bindings."</div>";
				}
				if ($vs_instructor_remarks = $t_object->get('ca_objects.instructor_remarks')) {
					$vs_enriched.=  "<div class='unit'><h6>Instructor Remarks</h6>".$vs_instructor_remarks."</div>";
				}
				if ($vs_enriched != "") {
					print "<a href='#' onclick='$(\"#enriched\").toggle(200); return false;'><h4>Enriched Data <i class='fa fa-chevron-down'></i></h4></a>";
					print "<div id='enriched' class='drawer'>";
					print $vs_enriched;																																																																							
					print "</div>";	
				}
				$vs_vocab = "";
				if ($vs_photographic = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'photographic_processes', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Photographic Processes</h6>".$vs_photographic."</div>";
				}
				if ($vs_binding = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'bindings', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Binding</h6>".$vs_binding."</div>";
				}	
				if ($vs_genre = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'genres', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Genre</h6>".$vs_genre."</div>";
				}	
				if ($vs_paper = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'paper', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Paper</h6>".$vs_paper."</div>";
				}
				if ($vs_print_pub = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'print_pub', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Printing and Publishing Evidence</h6>".$vs_print_pub."</div>";
				}
				if ($vs_prov_ev = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'provenance_evidence', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Provenance Evidence</h6>".$vs_prov_ev."</div>";
				}
				if ($vs_type_ev = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'type_evidence', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Type Evidence</h6>".$vs_type_ev."</div>";
				}	
				if ($vs_gasc = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'gascoigne_complete', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Gascoigne Numbers and Processes</h6>".$vs_gasc."</div>";
				}
				if ($vs_gasc_red = $t_object->get('ca_list_items.preferred_labels', array('convertCodesToDisplayText' => true, 'list' => 'gascoigne_reduced', 'delimiter' => '; '))) {
					$vs_vocab.= "<div class='unit'><h6>Gascoigne Numbers and Processes</h6>".$vs_gasc_red."</div>";
				}																																
				if ($vs_vocab != "") {
					print "<a href='#' onclick='$(\"#vocab\").toggle(200); return false;'><h4>Vocabularies <i class='fa fa-chevron-down'></i></h4></a>";
					print "<div id='vocab' class='drawer'>";
					print $vs_vocab;																																																																							
					print "</div>";	
				}
				$vs_location = "";	
				if ($vs_storage = $t_object->get('ca_storage_locations.preferred_labels', array('delimiter' => '<br/>'))) {
					$vs_location.= "<div class='unit'><h6>Storage Location</h6>".$vs_storage."</div>";
				}
				if ($vs_location_notes = $t_object->get('ca_objects.location_notes', array('delimiter' => '<br/>'))) {
					$vs_location.= "<div class='unit'><h6>Location Notes</h6>".$vs_location_notes."</div>";
				}				
				if ($vs_location != "") {
					print "<a href='#' onclick='$(\"#location\").toggle(200); return false;'><h4>Location <i class='fa fa-chevron-down'></i></h4></a>";
					print "<div id='location' class='drawer'>";
					print $vs_location;																																																																							
					print "</div>";	
				}	
				$vs_usage = "";
				if ($vs_usage_instructions = $t_object->get('ca_objects.usage_instructions', array('delimiter' => '<br/>', 'delimiter' => '<br/>'))) {
					$vs_usage.= "<div class='unit'><h6>Usage Instructions</h6>".$vs_usage_instructions."</div>";
				}
				if ($vs_usage_history = $t_object->get('ca_objects.usage_history', array('delimiter' => '<br/>', 'delimiter' => '<br/>'))) {
					$vs_usage.= "<div class='unit'><h6>Usage History</h6>".$vs_usage_history."</div>";
				}	
				if ($vs_related_course = $t_object->getWithTemplate('
					<unit relativeTo="ca_objects_x_occurrences" delimiter="<br>">
						<unit delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l>
							<br/>^ca_occurrences.idno<br/></unit>
							<ifdef code="ca_objects_x_occurrences.usage.day"><b>Day:</b> ^ca_objects_x_occurrences.usage.day<br/></ifdef>
							<ifdef code="ca_objects_x_occurrences.usage.period"><b>Period:</b> ^ca_objects_x_occurrences.usage.period<br/></ifdef>
							<ifdef code="ca_objects_x_occurrences.usage.show_order"><b>Show Order:</b> ^ca_objects_x_occurrences.usage.show_order<br/></ifdef>
							<ifdef code="ca_objects_x_occurrences.usage.usage_comments"><b>Comments:</b> ^ca_objects_x_occurrences.usage.usage_comments<br/></ifdef>
							<ifdef code="ca_objects_x_occurrences.usage_history"><b>Usage History:</b> ^ca_objects_x_occurrences.usage_history<br/></ifdef>
					</unit>')) {
					$vs_usage.= "<div class='unit'><h6>Related Courses</h6>".$vs_related_course."</div>";
				}								
				if ($vs_usage != "") {
					print "<a href='#' onclick='$(\"#usage\").toggle(200); return false;'><h4>Usage <i class='fa fa-chevron-down'></i></h4></a>";
					print "<div id='usage' class='drawer'>";
					print $vs_usage;																																																																							
					print "</div>";	
				}																																																																																																																																																													
?>				 
				
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6 '>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
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
<script>
	jQuery(document).ready(function() {
		$('.teachingpoint').popover(); 
	});
	
</script>
