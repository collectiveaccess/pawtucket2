<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
				
				<!-- # Comment and Share Tools -->
<?php
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div>
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div>
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
				
				{{{<ifdef code="ca_objects.idno">
					<div class="unit">HSF ^ca_objects.idno</div>
				</ifdef>}}}

				{{{<ifcount code="ca_entities" min="1">
					<div class="unit">
						<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator">
							^ca_entities.preferred_labels
							<!-- (^relationship_typename) -->
						</unit>
					</div>
				</ifcount>}}}

										
				{{{<ifdef code="ca_objects.preferred_labels.name" >
					<div class="unit">
						<!-- <label>Date</label> -->
						<unit relativeTo="ca_objects.preferred_labels.name" delimiter="<br/>">
							<h4>^ca_objects.preferred_labels.name</h4>
						</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.date" >
					<div class="unit">
						<!-- <label>Date</label> -->
						<unit relativeTo="ca_objects.date" delimiter="<br/>">
							^ca_objects.date.dates_value
						</unit>
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.displayMedium" >
					<div class="unit">			
						<!-- <label>Medium</label> -->
						<unit relativeTo="ca_objects.displayMedium" delimiter="<br/>">^ca_objects.displayMedium</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.dimensions">
					<div class="unit">
						<!-- <label>Dimensions</label> -->
						<unit relativeTo="ca_objects.dimensions" delimiter="<br/>">
							<ifdef code="ca_objects.dimensions.dimensionsType">
								<if rule='^ca_objects.dimensions.dimensionsType !~ /\-/'>
									^ca_objects.dimensions.dimensionsType: 
								</if>
							</ifdef>
							<ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions</ifdef>
						</unit>						
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.signaturesMarkings" >
					<div class="unit">			
						<!-- <label>Signed</label> -->
						<unit relativeTo="ca_objects.signaturesMarkings" delimiter="<br/>">
							^ca_objects.signaturesMarkings.sigMarkText
						</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.currentColl" >
					<div class="unit">			
						<!-- <label>Signed</label> -->
						<unit relativeTo="ca_objects.currentColl" delimiter="<br/>">
							^ca_objects.currentColl.creditLine
						</unit>
					</div>
				</ifdef>}}}	

				<?php
					if($this->request->user->hasRole("admin")){
				?>
						{{{<ifdef code="ca_objects.internalNotes.notes">
							<div class="unit">
								<label>Notes</label>
								<unit relativeTo="ca_objects" delimiter="<br/>">							
									<span class="trimText">^ca_objects.internalNotes.notes</span>
									<ifdef code="ca_objects.internalNotes.noteSource"><small><br/> - ^ca_objects.internalNotes.noteSource</small></ifdef>
									<ifdef code="ca_objects.internalNotes.noteDate"><small>, ^ca_objects.internalNotes.noteDate</small></ifdef>
								</unit>
							</div>
						</ifdef>}}}
				<?php
					}
				?>

				<div class="row">
					<div class="col-sm-12">		
						
						<!-- Exhibitions - type of occurrence -->

						{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition">
							<label>Exhibitions</label>
							<div class="unit">
								<unit relativeTo="ca_occurrences" delimiter="<br/><br/>" restrictToTypes="exhibition">
									<ifdef code="ca_occurrences.preferred_labels"><l><i>^ca_occurrences.preferred_labels</i>, </l></ifdef>	
									<ifdef code="ca_occurrences.PrimaryVenue.venueName">^ca_occurrences.PrimaryVenue.venueName</ifdef>	
									<ifdef code="ca_occurrences.DisplayDate">(^ca_occurrences.DisplayDate)</ifdef>	
								</unit>
							</div>
							<br/>
						</ifcount>}}}

						<!-- Publications - type of occurrence -->

						{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="bibliography">
							<label>Publications</label>
							<div class="unit">
								<unit relativeTo="ca_occurrences" delimiter="<br/><br/>" restrictToTypes="bibliography">
									<l>^ca_occurrences.formalCite</l> 
								</unit>
							</div>
							</br></br>
						</ifcount>}}}
						
						<!-- Archival Material - type of related object -->

						{{{<ifcount code="ca_objects.related" min="1" restrictToTypes="archivalObjects,archivalCorrespondence,archivalInterview,archivalPhotograph,archivalWriting">
							<label>Archival Material</label>
							<div class="unit">
								<unit relativeTo="ca_objects.related" delimiter="<br/><br/>" restrictToTypes="archivalObjects,archivalCorrespondence,archivalInterview,archivalPhotograph,archivalWriting">
									(^ca_objects.idno) <l>^ca_objects.preferred_labels</l>
								</unit>
							</div>
							</br></br>
						</ifcount>}}}
						
					</div><!-- end col -->				
					<!-- <div class="col-sm-6 colBorderLeft">
						{{{map}}}
					</div> -->
				</div><!-- end row -->
						
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->

	</div><!-- end col -->

	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<br/>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
