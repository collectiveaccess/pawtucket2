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
	$t_representation = 	$this->getVar("t_representation");
	$va_comments = 			$this->getVar("comments");
	$va_options = 			$this->getVar("config_options");
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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
<?php
				switch($t_object->get("ca_objects.rights.image_rights")){
					case "788": #own/manage download
						$vs_display_type = "detail";
						$vs_download_link = "<a href='".$t_representation->getMediaUrl("ca_object_representations.media", "large")."'>Download Image</a>";
					break;
					# ------------------------------
					case "789": #own/manage no download
						$vs_display_type = "detail";
						$vs_download_link = null;
						
					break;
					# ------------------------------
					case "790": #public domain
						$vs_display_type = "detail";
						$vs_download_link = "<a href='".$t_representation->getMediaUrl("ca_object_representations.media", "large")."'>Download Large</a><br/><a href='".$t_representation->getMediaUrl("ca_object_representations.media", "small")."'>Download Small</a>";						
					break;
					# ------------------------------					
					case "791": #do not own
						$vs_display_type = "detailSmall";
						$vs_download_link = null;
					break;
					# ------------------------------										
					default:
						$vs_display_type = "detailSmall";
						$vs_download_link = null;
					break;
					# ------------------------------
				}
				print caObjectDetailMedia($this->request, $t_object->getPrimaryKey(), $t_representation, $t_object, array_merge(array("display" => $vs_display_type, "showAnnotations" => true, "primaryOnly" => caGetOption('representationViewerPrimaryOnly', $va_options, false), "dontShowPlaceholder" => caGetOption('representationViewerDontShowPlaceholder', $va_options, false), "captionTemplate" => caGetOption('representationViewerCaptionTemplate', $va_options, false))));
				if ($t_representation->getMediaInfo('media', 'original', 'MIMETYPE') != "application/pdf") {
					print $vs_download_link;
				}
?>
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
			
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>				
<?php
				if(($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Moving image') | ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Photograph')) {
					print "<div class='unit'><h6>Identifier</h6>".$t_object->get('ca_objects.idno')."</div>";
				}
				if ($va_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Author</h6>".$va_author."</div>";
				}
				if ($va_videographer = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('videographer'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Videographer/Filmmaker</h6>".$va_videographer."</div>";
				}				

				if ($va_date = $t_object->get('ca_objects.date')) {
					print "<div class='unit'><H6>Date:</H6>".$va_date."</div>";
				}

				if ($va_publisher = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Publisher</h6>".$va_publisher."</div>";
				}
?>					
				{{{<ifdef code="ca_objects.venue"><div class='unit'><H6>Venue:</H6><unit delimiter='<br/>'>^ca_objects.venue</unit></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.coverage"><div class='unit'><H6>Coverage:</H6><unit delimiter='<br/>'>^ca_objects.coverage</unit></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.isbn"><div class='unit'><H6>ISBN:</H6><unit delimiter='<br/>'>^ca_objects.isbn</unit></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.book_format"><div class='unit'><H6>Format:</H6><unit delimiter=', '>^ca_objects.book_format</unit></div></ifdef>}}}				

				{{{<ifdef code="ca_objects.description">
					<div class='unit'><H6>Description:</H6>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.summary">
					<div class='unit'><H6>Summary:</H6>
						<span class="trimText">^ca_objects.summary</span>
					</div>
				</ifdef>}}}	
				{{{<ifdef code="ca_objects.extentDACS"><div class='unit'><H6>Extent:</H6><unit delimiter=', '>^ca_objects.extentDACS</unit></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.medium"><div class='unit'><H6>Medium:</H6><unit delimiter=', '>^ca_objects.medium</unit></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.dimensions.height|ca_objects.dimensions.dwidth|ca_objects.dimensions.length|ca_objects.dimensions.diameter|ca_objects.dimensions.weight|ca_objects.dimensions.measurement_notes"><h6>Dimensions</H6></ifdef>
					<ifdef code="ca_objects.dimensions.height">^ca_objects.dimensions.height H</ifdef>
					<ifdef code="ca_objects.dimensions.height,ca_objects.dimensions.dwidth"> X </ifdef>
					<ifdef code="ca_objects.dimensions.dwidth">^ca_objects.dimensions.dwidth W</ifdef>
					<ifdef code="ca_objects.dimensions.dwidth,ca_objects.dimensions.length"> X </ifdef>
					<ifdef code="ca_objects.dimensions.length">^ca_objects.dimensions.length L</ifdef>
					<ifdef code="ca_objects.dimensions.length,ca_objects.dimensions.diameter"> X </ifdef>
					<ifdef code="ca_objects.dimensions.diameter">^ca_objects.dimensions.diameter Diameter</ifdef>
					<ifdef code="ca_objects.dimensions.weight">, ^ca_objects.dimensions.weight Weight</ifdef>
					<ifdef code="ca_objects.dimensions.measurement_notes"><br/>Notes: ^ca_objects.dimensions.measurement_notes </ifdef>
				}}}		
<?php
				if ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Photograph') {
					if ($vs_taken = $t_object->get('ca_objects.at_pillow', array('convertCodesToDisplayText' => true))) {
						if ($vs_taken == 'yes') {
							print "<div class='unit'><h6>Taken at Jacob's Pillow</h6></div>";
						}
					}
				}
				if ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Periodical') {
					if ($vs_arrangement = $t_object->get('ca_objects.arrangement')) {
						print "<div class='unit'><h6>System of Arrangement</h6>".$vs_arrangement."</div>";
					}
					if ($vs_holdings = $t_object->get('ca_objects.holdings')) {
						print "<div class='unit'><h6>Holdings</h6>".$vs_holdings."</div>";
					}															
				}
				if (($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Periodical')|($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Costumes')) {
					if ($vs_provenance = $t_object->get('ca_objects.provenance')) {
						print "<div class='unit'><h6>Provenance</h6>".$vs_provenance."</div>";
					}				
				}	
				if ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == "Moving image") {
					if ($vs_access = $t_object->get('ca_objects.access_format')) {
						print "<div class='unit'><h6>Access Format</h6>".$vs_access."</div>";
					}
					if ($vs_master = $t_object->get('ca_objects.master_format')) {
						print "<div class='unit'><h6>Master Format</h6>".$vs_master."</div>";
					}
					if ($vs_duration = $t_object->get('ca_objects.duration')) {
						if ($vs_duration != "0.0s") {
							print "<div class='unit'><h6>Duration</h6>".$vs_duration."</div>";
						}
					}

					if (($va_camera = $t_object->get('ca_objects.camera', array('convertCodesToDisplayText' => true)))&&($va_camera != "-")) {
						print "<div class='unit'><h6>Camera</h6>".$va_camera."</div>";
					}
						
					if ($vs_tech_notes = $t_object->get('ca_objects.technical_notes')) {
						print "<div class='unit'><h6>Technical Notes</h6>".$vs_tech_notes."</div>";
					}																				
				}			
?>				
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">		
							{{{<ifcount code="ca_entities.preferred_labels" excludeRelationshipTypes="author,videographer" min="1">
								<h6>Related Entities</h6>
								<unit relativeTo="ca_entities" delimiter='<br/>' excludeRelationshipTypes="author,videographer"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
							</ifcount>}}}

<?php

							if ($va_related_occurrences = $t_object->get('ca_occurrences.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToTypes' => array('production'), 'checkAccess' => $va_access_values))) {
								print "<h6>Related productions</h6>".$va_related_occurrences;
							}
							if ($va_related_works = $t_object->get('ca_occurrences.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToTypes' => array('work'), 'checkAccess' => $va_access_values))) {
								print "<h6>Related works</h6>".$va_related_works;
							}
							if ($va_related_events = $t_object->get('ca_occurrences.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToTypes' => array('event'), 'checkAccess' => $va_access_values))) {
								print "<h6>Related events</h6>".$va_related_events;
							}
							if ($va_related_objects = $t_object->get('ca_objects.related.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
								print "<h6>Related Objects</h6>".$va_related_objects;
							}							
							if ($va_related_collections = $t_object->get('ca_collections.hierarchy.preferred_labels', array('delimiter' => '<br/> > ', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
								print "<h6>Related collections</h6>".$va_related_collections;
							}	
							if ($va_related_storage = $t_object->get('ca_storage_locations.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
								print "<h6>Related Storage Locations</h6>".caNavLink($this->request, $va_related_storage, '', '', 'Search', 'objects', array('search' =>'ca_storage_locations:'.$va_related_storage));
							}
							if (($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) != 'Book') && ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) != 'Periodical')) {							
								if ($va_rights = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.rights.rightsStatement"><b>Statement:</b> ^ca_objects.rights.rightsStatement</ifdef><ifdef code="ca_objects.rights.rightsHolder"><br/><b>Rights Holder:</b> ^ca_objects.rights.rightsHolder</ifdef><ifdef code="ca_objects.rights.rightsNotes"><br/><b>Rights Notes:</b> ^ca_objects.rights.rightsNotes</ifdef></unit>')) {
									print "<div class='unit'><h6>Rights</h6>".$va_rights."</div>";
								}	
							}																

							if ($va_terms = $t_object->get('ca_list_items.preferred_labels', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
								print "<div class='unit'><h6>Related Terms</h6>";
								foreach ($va_terms as $va_key => $va_term) {
									print "<p>".caNavLink($this->request, $va_term, '', '', 'MultiSearch', 'Index', array('search' => 'ca_list_items.preferred_labels:"'.$va_term.'"'))."</p>";
								}
								print "</div>";
							}
							
							if ($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
								print "<div class='unit'><h6>LCSH Terms</h6>";
								foreach ($va_lcsh_terms as $va_key => $va_lcsh_term) {
									$va_lcsh_term_name = explode('[',$va_lcsh_term);
									print "<p>".caNavLink($this->request, $va_lcsh_term_name[0], '', '', 'MultiSearch', 'Index', array('search' => "ca_objects.lcsh_terms:".$va_lcsh_term_name[0]))."</p>";
								}
								print "</div>";
							}
							if ($t_object->get('ca_objects.external_link.url_entry')) {
								$va_external_links = $t_object->get('ca_objects.external_link', array('returnWithStructure' => true));
								print "<div class='unit'><h6>Links</h6>";
								foreach ($va_external_links as $va_key => $va_external_link_t) {
									foreach ($va_external_link_t as $va_key => $va_external_link) {
										if ($va_external_link['url_source'] && $va_external_link['url_entry']) {
											print "<a href='".$va_external_link['url_entry']."' target='_blank'>".$va_external_link['url_source']."</a><br/>";
										} elseif ($va_external_link['url_entry']) {
											print "<a href='".$va_external_link['url_entry']."' target='_blank'>".$va_external_link['url_entry']."</a><br/>";
										}
									}
								}
								print "</div>";
							}
?>							
						</div><!-- end col -->				
					</div><!-- end row -->
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