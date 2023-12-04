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
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	
	$t_list = new ca_lists();
	$vn_pub_type_id = $t_list->getItemIDFromList("object_types", "publication");	
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
			<div class="col-sm-12">
				<h1><?php print ( $t_object->get('ca_objects.type_id') != $vn_pub_type_id ? "".$t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToRelationshipTypes' => array('artist'), 'delimiter' => ', ')) : "")."<br/>"; ?>			
				<span class='artist'>{{{ca_objects.preferred_labels.name}}}<?php print ( $t_object->get('ca_objects.date') ? "<small>, ".caNavLink($this->request, $t_object->get('ca_objects.date'), '', '', 'MultiSearch', 'Index', array('search' => "ca_objects.date:".$t_object->get('ca_objects.date'), 'label' => 'date'))."</small>" : "")."</span>"; ?></h1>
			</div>
			<div class='col-sm-7 col-md-7 col-lg-7'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
<?php 
				print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); 
?>				
			</div><!-- end col -->
			
			<div class='col-sm-5 col-md-5 col-lg-5'>
<?php	
				if ($va_dimensions = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true))) {		
					print "<div class='unit'><h6>Dimensions</h6>";
					foreach ($va_dimensions as $va_key => $va_dimension_t) {
						foreach ($va_dimension_t as $va_key => $va_dimension) {
							$va_dims = array();
							if ($va_dimension['dimensions_height']) {
								$va_dims[] = $va_dimension['dimensions_height']." H";
							}
							if ($va_dimension['dimensions_width']) {
								$va_dims[] = $va_dimension['dimensions_width']." W";
							}
							if ($va_dimension['dimensions_length']) {
								$va_dims[] = $va_dimension['dimensions_length']." L";
							}
							if ($va_dimension['dimensions_thickness']) {
								$va_dims[] = $va_dimension['dimensions_thickness']." thick";
							}	
							print join(' x ', $va_dims);
							if ($va_dimension['dimensions_weight']) {
								$va_dims[] = "<br/>".$va_dimension['dimensions_weight']." weight";
							}
							if ($va_dimension['measurement_notes']) {
								$va_dims[] = "<br/>".$va_dimension['measurement_notes'];
							}																																			
						}						
					}
					print "</div>";
				}
				if ($va_mediums = $t_object->get('ca_objects.medium', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Medium</h6>";
					foreach ($va_mediums as $va_key => $va_medium) {
						print caNavLink($this->request, caGetListItemByIDForDisplay($va_medium, false), '', 'Browse', 'artworks', 'facet/material_facet/id/'.$va_medium)."<br/>";
					}
					print "</div>";
				}	
				if ($vs_image_notes = $t_object->get('ca_objects.image_notes')) {
					print "<div class='unit'><h6>Image Notes</h6>".$vs_image_notes."</div>";
				}
				if ($vs_accession = $t_object->get('ca_objects.accession')) {
					print "<div class='unit'><h6>Catalogue Number</h6>".$vs_accession."</div>";
				}
				if ($vs_current_loc = $t_object->get('ca_objects.current_location')) {
					print "<div class='unit'><h6>Current Location</h6>".$vs_current_loc."</div>"; 
				}																		
#				if ($vs_info = $t_object->get('ca_objects.idno')) {
#					print "<div class='unit'><h6>Identifier</h6>".$vs_info."</div>";
#				}
#				if ($vs_location = $t_object->get('ca_objects.location')) {
#					print "<div class='unit'><h6>Location</h6>".$vs_location."</div>";
#				}				
#				if ($va_related_pub = $t_object->get('ca_objects.related.preferred_labels', array('restrictToTypes' => array('publication'), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
#					print "<div class='unit'><h6>Related Publications</h6>".$va_related_pub."</div>";
#				}
				if ($t_object->get('ca_objects.type_id') != $vn_pub_type_id) {
					print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
				}
#				if ($vs_condition = $t_object->get('ca_objects.image_notes')) {
#					print "<div class='unit'><h6>Condition</h6>".$vs_condition."</div>";
#				}	
#				if ($vs_available = $t_object->get('ca_objects.available')) {
#					print "<div class='unit'><h6>Available Prints and Publications</h6><a href='".$vs_available."' target='_blank'>".$vs_available."</a></div>";
#				}
																					
?>
			</div><!-- end col -->
		</div><!-- end row -->	
<?php
		if($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == "Publication") {
			print "<div><i>To subscribe or purchase back issues of Contact Sheet, please visit <a href='http://www.lightwork.org/shop' target='_blank'>www.lightwork.org/shop</a></i></div>"; 
		}	
?>		
		<hr></hr>
<?php
		if ($vs_description = $t_object->get('ca_objects.description')) {
			print "<div class='row'><div class='col-sm-12'><h2>Object Specific Text</h2><div class='unit trimText'>".$vs_description."</div></div><!-- end col --></div><!-- end row --><hr>";
		}
		if ($va_artist = $t_object->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('artist'), 'returnAsArray' => true))) {
			foreach ($va_artist as $va_key => $va_artist_id) {
				$t_entity = new ca_entities($va_artist_id);
				if (($t_entity) && ($t_object->get('ca_objects.type_id') != $vn_pub_type_id)) {		
?>				
		<div class="row" style="padding-bottom:20px;">
			<div class="col-sm-12 artist">
				<h2>About the Artist</h2>
				<div class="col-sm-12" style='padding-left:0px;'>
<?php
					print "<h2 class='artist'>".$t_entity->get('ca_entities.preferred_labels', array('returnAsLink' => true))."</h2>";
				
					if ($vs_birthdate = $t_entity->get('ca_entities.birthday')) {
						print "<div class='info'><span class='metaLabel'>Born</span><span class='data'>".$vs_birthdate."</span></div>";
					}
					if ($vs_deathdate = $t_entity->get('ca_entities.deathdate')) {
						print "<div class='info'><span class='metaLabel'>Died</span><span class='data'>".$vs_deathdate."</span></div>";
					}						
					if ($vs_birthplace = $t_entity->get('ca_entities.birthplace')) {
						print "<div class='info'><span class='metaLabel'>Birthplace</span><span class='data'>".$vs_birthplace."</span></div>";
					}
					if ($vs_gender = $t_entity->get('ca_entities.gender')) {
						print "<div class='info'><span class='metaLabel'>Gender</span><span class='data'>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_gender, true), '', 'Browse', 'artists', 'facet/gender_facet/id/'.$vs_gender)."</span></div>";
					}	
					if ($va_citizenship = $t_entity->get('ca_entities.citizenship', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Citizenship</span><span class='data'>";
						$va_ct = array();
						foreach ($va_citizenship as $va_key => $va_citizen) {
							$va_ct[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_citizen, true), '', 'Browse', 'artists', 'facet/citizenship_facet/id/'.$va_citizen);
						}
						print join(', ', $va_ct);
						print "</span></div>";
					}
					if ($va_cultural = $t_entity->get('ca_entities.cultural', array('returnAsArray' => true))) {
						print "<div class='info'><span class='metaLabel'>Cultural Heritage</span><span class='data'>";
						$va_cl = array();
						foreach ($va_cultural as $va_key => $va_culture) {
							$va_cl[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_culture, true), '', 'Browse', 'artists', 'facet/cultural_facet/id/'.$va_culture);
						}
						print join(', ', $va_cl);
						print "</span></div>";
					}					
#					if ($vs_nationality = $t_entity->get('ca_entities.nationality', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
#						print "<div class='info'><span class='metaLabel'>Nationality</span><span class='data'>".$vs_nationality."</span></div>";
#					}
	
					if ($vs_lw_relationship = $t_entity->get('ca_entities.lw_relationship', array('returnWithStructure' => true, 'sort' => 'ca_entities.lw_relationship.lwdate'))) {
						print "<div class='info'><span class='metaLabel'>Light Work Relationship</span><span class='data'>";
						foreach ($vs_lw_relationship as $vs_key => $vs_lw_relationships) {
							foreach ($vs_lw_relationships as $vs_key => $vs_lw_relationship) {
								if ($vs_lw_relationship['Relationship']) {
									//print caNavLink($this->request, caGetListItemByIDForDisplay($vs_lw_relationship['Relationship'], true), '', 'Browse', 'entities', 'facet/lw_relationship_facet/id/'.$vs_lw_relationship['Relationship']);
									print caNavLink($this->request, caGetListItemByIDForDisplay($vs_lw_relationship['Relationship'], true), '', 'Browse', 'artists', 'facets/lw_relationship_facet:'.$vs_lw_relationship['Relationship'].($vs_lw_relationship['lwdate'] ? ';lw_relationship_year_facet:'.(int)$vs_lw_relationship['lwdate'] : ''));
								}
								if ($vs_lw_relationship['lwdate']) {
									print ", ".$vs_lw_relationship['lwdate'];
								}
								if ($vs_lw_relationship['relationship_notes']) {
									print " (".$vs_lw_relationship['relationship_notes'].")";
								}	
								print "<br/>";														
							}
						}
						print "</span></div>";
					}	
					if ($vs_entity_pub = $t_entity->get('ca_objects.preferred_labels', array('restrictToTypes' => array('publication'), 'delimiter' => '<br/>', 'returnAsLink' => true, 'sort' => 'ca_objects.preferred_labels'))) {
						print "<div class='info'><span class='metaLabel'>Light Work Publications</span><span class='data'>".$vs_entity_pub."</span></div>";
					}
#					if ($vs_websites = $t_entity->get('ca_entities.website', array('returnAsArray' => true))) {
#						print "<div class='info'><span class='metaLabel'>Website</span><span class='data'>";
#						foreach ($vs_websites as $vs_key => $vs_website) {
#							print "<a href='".$vs_website."' target='_blank'>".$vs_website."</a><br/>";
#						}				
#						print "</span></div>";
#					}
					if ($vs_bio = $t_entity->get('ca_entities.biography', array('delimiter' => '<hr class="dark">'))) {
						print "<p class='trimText' style='margin-top:35px;'><h2 class='artist'>Biography</h2>".$vs_bio."</p>";
					}
					if ($va_essays = $t_entity->get('ca_entities.essays', array('returnAsArray' => true))) {
						$vs_essays = array();
						foreach ($va_essays as $va_key => $va_essay) {
							$vs_essays[] = "<div class='trimText'>".$va_essay."</div>";
						}
						print "<hr>";
						print "<div class='unit'><h2 class='artist'>Essays</h2>".join($vs_essays, "<hr class='dark'>")."</div>";
					}																																					
?>						
				</div>	<!-- end col-12 -->		
			</div><!-- end col-12 -->
		</div><!-- end row -->
<?php
				}
			}
		}

/*		if ($va_related_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('artwork')))) {
			$qr_related_objects = caMakeSearchResult('ca_objects', $va_related_objects);
			$va_entity_ids = array();
			while($qr_related_objects->nextHit()) {
				$va_entity_ids[] = $qr_related_objects->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('artist')));
			}
			print "<div class='row'><div class='browseResultsContainer relatedArtists'><h2 style='margin-left:15px;padding-bottom:15px;'>Related Artists</h2>";
			$qr_related_artists = caMakeSearchResult('ca_entities', array_unique($va_entity_ids));
			while($qr_related_artists->nextHit()) {
				print "<div class='bResultItemCol col-xs- col-sm-4 col-md-4'><div class='bResultItem'><div class='bResultItemContent'>";
				print "<div class='text-center bResultItemImg'>".caDetailLink($this->request, $qr_related_artists->getWithTemplate('<unit relativeTo="ca_objects" length="1"><unit relativeTo="ca_object_representations" length="1">^ca_object_representations.media.small</unit><ifnotdef code="ca_object_representations.media.small"><div class="bResultItemImgPlaceholder"><i class="fa fa-picture-o fa-2x"></i></div></ifnotdef></unit>'), '', 'ca_entities', $qr_related_artists->get('ca_entities.entity_id'))."</div>";
				print "<div class='bResultItemText'>";
				print caDetailLink($this->request, $qr_related_artists->get('ca_entities.preferred_labels'), '', 'ca_entities', $qr_related_artists->get('ca_entities.entity_id'));			
				print "</div>";
				print "</div><!-- end bResultItemContent --></div><!-- end bResultItem --></div><!-- end col-sm-4 -->";		 		
			}
			print "</div></div>";				

		}
*/
		if($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == "Publication") {
			$va_entity_ids = $t_object->get('ca_entities.entity_id', array('returnAsArray' => true, 'sort' => 'ca_entities.preferred_labels.surname'));
			print "<div class='row'><div class='browseResultsContainer relatedArtists'><h2 style='margin-left:15px;padding-bottom:15px;'>Related Artists</h2>";
			$qr_related_artists = caMakeSearchResult('ca_entities', array_unique($va_entity_ids));
			while($qr_related_artists->nextHit()) {
				print "<div class='bResultItemCol col-xs- col-sm-4 col-md-4'><div class='bResultItem'><div class='bResultItemContent'>";
				print "<div class='text-center bResultItemImg'>".caDetailLink($this->request, $qr_related_artists->getWithTemplate('<unit relativeTo="ca_objects" length="1"><unit relativeTo="ca_object_representations" length="1">^ca_object_representations.media.small</unit><ifnotdef code="ca_object_representations.media.small"><div class="bResultItemImgPlaceholder"><i class="fa fa-picture-o fa-2x"></i></div></ifnotdef></unit>'), '', 'ca_entities', $qr_related_artists->get('ca_entities.entity_id'))."</div>";
				print "<div class='bResultItemText'>";
				print caDetailLink($this->request, $qr_related_artists->get('ca_entities.preferred_labels'), '', 'ca_entities', $qr_related_artists->get('ca_entities.entity_id'));			
				print "</div>";
				print "</div><!-- end bResultItemContent --></div><!-- end bResultItem --></div><!-- end col-sm-4 -->";		 		
			}
			print "</div></div>";			
		}
	
/*		
		if ($va_related_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('publication'), 'sort' => 'ca_objects.preferred_labels'))) {
			$qr_related_objects = caMakeSearchResult('ca_objects', $va_related_objects);
			print "<hr><div class='row'><div class='browseResultsContainer'><h2 style='margin-left:15px;padding-bottom:15px;'>Related Publications</h2>";
			while($qr_related_objects->nextHit()) {
				print "<div class='bResultItemCol col-xs- col-sm-4 col-md-4'><div class='bResultItem'><div class='bResultItemContent'>";
				print "<div class='text-center bResultItemImg'>".($qr_related_objects->get('ca_object_representations.media.widepreview') ? $qr_related_objects->get('ca_object_representations.media.widepreview') : '<div class="bResultItemImgPlaceholder"><i class="fa fa-picture-o fa-2x"></i></div>')."</div>";
				print "<div class='bResultItemText'>";
				print caNavLink($this->request, $qr_related_objects->get('ca_objects.preferred_labels').($qr_related_objects->get('ca_objects.date') ? ", ".$qr_related_objects->get('ca_objects.date') : "" ), '', '', 'Detail', 'objects/'.$qr_related_objects->get('ca_objects.object_id'));
				if ($va_medium = $qr_related_objects->get('ca_objects.medium', array('convertCodesToDisplayText' => true))) {
					print "<p>".$va_medium."</p>";
				} else { $va_artist = null; }				
				print "</div>";
				print "</div><!-- end bResultItemContent --></div><!-- end bResultItem --></div><!-- end col-sm-4 -->";
			}
			print "</div></div>";
		}
		*/		
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
		  maxHeight: 235
		});
	});
</script>