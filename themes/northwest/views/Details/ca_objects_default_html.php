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
	<div class='col-xs-12 navButtons'><!--- only shown at small screen size -->
		{{{nextLink}}} {{{previousLink}}}<span class='spacer'></span>{{{resultsLink}}} 
	</div><!-- end detailTop -->

	<div class='col-xs-12 '>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				$vb_citation_special_collection = false;
				$vs_citation_collection = "";
				$t_list_item = new ca_list_items();
				if ($va_collection_paths = $t_object->get('ca_collections.hierarchy.preferred_labels', array('returnWithStructure' => true, 'restrictToRelationshipTypes' => array("part_of")))) {
					$va_collections_array = array();
					foreach ($va_collection_paths as $va_key => $va_collection_path_t) {
						$va_collection_array = array();
						foreach ($va_collection_path_t as $vn_collection_id => $va_collection_path) {
							if(!$vs_citation_collection){
								$t_collection = new ca_collections($vn_collection_id);
								$t_list_item->load($t_collection->get("type_id"));
								$vs_coll_type_idno = $t_list_item->get("idno");
								if($vs_coll_type_idno == "collection"){
									# --- this is part of a "Special Collection"
									$vb_citation_special_collection = true;
									$vs_citation_collection = $va_collection_path[$vn_collection_id]['name'];
									# --- add a link to Special Collections landing page since is not part of the hierarchy
									$va_collection_array[] = caNavLink($this->request, "Special Collections of The Northwest School", "", "",  "Collections", "SpecialCollectionsList");
								}elseif($vs_coll_type_idno != "archive_collection"){
									# --- this is part of the NWS Archive collection
									$vs_citation_collection = $va_collection_path[$vn_collection_id]['name'];
									$vb_citation_special_collection = false;
								}
							}
							$va_collection_array[] = caDetailLink($this->request, $va_collection_path[$vn_collection_id]['name'], '', 'ca_collections', $vn_collection_id);
						}
						$va_collections_array[] = $va_collection_array;
					}
					foreach($va_collections_array as $va_collection_trail){
						print "<div class='detailCollectionPath'>".join(' <i class="fa fa-chevron-right"></i> ', $va_collection_trail)."</div>";
					}
				}
?>				
				<H4 style='padding-bottom:0px;'>{{{ca_objects.preferred_labels.name}}}</H4>
				{{{<ifcount min="1" code="ca_objects.date"><h6 style='padding:0px 0px 30px 0px; margin-top:5px;'><unit delimiter="<br/>">^ca_objects.date</unit></h6></ifcount>}}}
				
				<div class='unit'><span class='metaLabel'>Description</span><span class='metaData'>{{{<ifdef code="ca_objects.description">^ca_objects.description</ifdef>}}}</span></div>
<?php
				if ($vs_medium = $t_object->get('ca_objects.medium', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='metaLabel'>Medium</span><span class='metaData'>".$vs_medium."</span></div>";
				}
				if($t_rep = $this->getVar("t_representation")){
					$va_media_info = $t_rep->getMediaInfo("media");
					print "<div class='unit'><span class='metaLabel'>Format</span><span class='metaData'>".$va_media_info["INPUT"]["MIMETYPE"]."</span></div>";
				}
				#if ($vs_format_notes = $t_object->get('ca_objects.format_notes', array('delimiter' => '<br/>'))) {
				#	print "<div class='unit'><span class='metaLabel'>Format</span><span class='metaData'>".$vs_format_notes."</span></div>";
				#}				
?>
				<div class='unit'><span class='metaLabel'>Identifier</span><span class='metaData'>{{{<ifdef code="ca_objects.idno">^ca_objects.idno</ifdef>}}}</span></div>
<?php
				if ($vs_rights = $t_object->get('ca_objects.rights', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='metaLabel'>Use Restrictions</span><span class='metaData'>".$vs_rights."</span></div>";
				}
				# --- citation
				print "<div class='unit'><span class='metaLabel'>Citation</span><span class='metaData'><i>".$t_object->get("ca_objects.preferred_labels.name")."</i>";
				if($t_object->get("ca_objects.date")){
					print ", ".$t_object->get("ca_objects.date", array("delimiter" => ", ")).". ";
				}
				if($vs_citation_collection){
					print $vs_citation_collection.". ";
				}
				if($vb_citation_special_collection){
					print "Special Collections of The Northwest School. ";
				}elseif($vs_citation_collection){
					print "The Northwest School Archive. ";
				}
				
				print "Retrieved from The Northwest School. ".date("n/j/Y")."</span></div>";
				
				if ($va_related_entities = $t_object->get('ca_entities.entity_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><span class='metaLabel'>Related Entities</span><span class='metaData'>";
					foreach ($va_related_entities as $va_key => $va_related_entity_id) {
						$t_rel_ent = new ca_entities($va_related_entity_id);
						print "<div >".caDetailLink($this->request, $t_rel_ent->get('ca_entities.preferred_labels'), '', 'ca_entities', $t_rel_ent->get('ca_entities.entity_id'))."</div>";
					}
					print "</span></div>";		  
				}				
/*				
				if ($vs_language = $t_object->get('ca_objects.language', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><span class='metaLabel'>Language</span><span class='metaData'>".$vs_language."</span></div>";
				}	
				if ($vs_publications = $t_object->get('ca_objects.publications', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='metaLabel'>Publications</span><span class='metaData'>".$vs_publications."</span></div>";
				}	


				if ($va_dims = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true))) {
					$vs_dim = "";
					$va_dims_array = array();
					foreach ($va_dims as $va_key => $va_dims_t) {
						foreach ($va_dims_t as $va_key => $va_dim) {
							if ($va_dim['dimensions_length']) {
								$va_dims_array[] = $va_dim['dimensions_length']." L ";
							}
							if ($va_dim['dimensions_width']) {
								$va_dims_array[] = $va_dim['dimensions_width']." W ";
							}
							if ($va_dim['dimensions_height']) {
								$va_dims_array[] = $va_dim['dimensions_height']." H ";
							}
							if ($va_dim['dimensions_thickness']) {
								$va_dims_array[] = $va_dim['dimensions_thickness']." Thick ";
							}	
							$vs_dim.= join(' x ', $va_dims_array);
							if ($va_dim['dimensions_diameter']) {
								$vs_dim.= "<div>".$va_dim['dimensions_diameter']." Diameter </div>";
							}
							if ($va_dim['dimensions_weight']) {
								$vs_dim.= "<div>".$va_dim['dimensions_weight']." Weight </div>";
							}
							if ($va_dim['measurement_notes']) {
								$vs_dim.= "<div>".$va_dim['measurement_notes']." Measurement Notes </div>";
							}																																								
						}
					}
					if ($vs_dim != "") {
						print "<div class='unit'><span class='metaLabel'>Dimensions</span><span class='metaData'>".$vs_dim."</span></div>";
					}
				}

				if ($vs_lcsh = $t_object->get('ca_objects.lcsh_terms', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='metaLabel'>Library of Congress Subject Headings</span><span class='metaData'>".$vs_lcsh."</span></div>";
				}
				if ($vs_aat = $t_object->get('ca_objects.aat', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='metaLabel'>Getty Art and Architecture Thesarus</span><span class='metaData'>".$vs_aat."</span></div>";
				}
				if ($vs_subjects = $t_object->get('ca_list_items.preferred_labels', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='metaLabel'>Subjects</span><span class='metaData'>".$vs_subjects."</span></div>";
				}
*/
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
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
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>																																						
				<div>There’s more! What you see here is only what is viewable online; in most cases it is only a small portion of what is available. Please visit our comprehensive guide to the collection to find out more.</div>

						
			</div><!-- end col -->
		</div><!-- end row -->
<?php	
		if ($va_related_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {	
			print '<div class="row">';
				print "<div class='col-sm-10 col-sm-offset-1'><hr/><h4>Related Objects</h4></div>";
				print "<div class='col-sm-10 col-sm-offset-1'>";
				print "<div class='row'>";
				$vn_obj_count = 0;
				foreach ($va_related_objects as $va_key => $va_related_object) {
					$t_rel_obj = new ca_objects($va_related_object);
					print "<div class='col-sm-3'>";
					print caDetailLink($this->request, $t_rel_obj->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'));
					print "<div class='objCaption'>".caDetailLink($this->request, $t_rel_obj->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'))."</div>";
					print "</div>";
					$vn_obj_count++;
					if ($vn_obj_count == 4) {
						print "</div><div class='row'>";
					}
				}
				print "</div><!-- end row -->";	
				print "</div>";			
			print '</div><!-- end row -->';
		}
		
/*

		$vs_exhibition_text = null;
		if ($va_related_exhibitions = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			$vs_exhibition_text = "<h4>Related Exhibitions</h4>";
			foreach ($va_related_exhibitions as $va_key => $va_related_exhibition_id) {
				$t_rel_ex = new ca_occurrences($va_related_exhibition_id);
				$vs_exhibition_text.= "<div class='relTitle'>".caDetailLink($this->request, $t_rel_ex->get('ca_occurrences.preferred_labels'), '', 'ca_occurrences', $t_rel_ex->get('ca_occurrences.occurrence_id'))."</div>";
			}			
		}
		
		$vs_collection_text = null;
		if ($va_related_collections = $t_object->get('ca_collections.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			$vs_collection_text = "<h4>Related Collections</h4>";
			foreach ($va_related_collections as $va_key => $va_related_collection_id) {
				$t_rel_col = new ca_collections($va_related_collection_id);
				$vs_collection_text.= "<div class='relTitle'>".caDetailLink($this->request, $t_rel_col->get('ca_collections.preferred_labels'), '', 'ca_collections', $t_rel_col->get('ca_collections.collection_id'))."</div>";
			}				
		}
		
		if ( $vs_entity_text || $vs_exhibition_text || $vs_collection_text ) {
			print "<div class='row lowerRow'><div class='col-sm-10 col-sm-offset-1'><hr>";
			if ($vs_entity_text) {
				print "<div class='col-sm-4 section'>".$vs_entity_text."</div>";
			}
			if ($vs_exhibition_text) {
				print "<div class='col-sm-4 section'>".$vs_exhibition_text."</div>";
			}
			if ($vs_collection_text) {
				print "<div class='col-sm-4 section'>".$vs_collection_text."</div>";
			}						
			print "</div></div>";
		}	
*/					
?>		
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
		
		$('.glyphicon-zoom-in').addClass('glyphicon-fullscreen');
		$('.glyphicon-zoom-in').removeClass('glyphicon-zoom-in');
		$( document ).ajaxComplete(function() {
		  $('.glyphicon-zoom-in').addClass('glyphicon-fullscreen');
			$('.glyphicon-zoom-in').removeClass('glyphicon-zoom-in');
		});
	});
</script>