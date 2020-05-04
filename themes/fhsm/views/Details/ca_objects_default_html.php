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

	$t_object = 				$this->getVar("item");
	$va_comments = 				$this->getVar("comments");
	$va_tags = 					$this->getVar("tags_array");
	$vn_comments_enabled = 		$this->getVar("commentsEnabled");
	$vn_share_enabled = 		$this->getVar("shareEnabled");
	$va_add_to_set_link_info = 	caGetAddToSetInfo($this->request);

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
			<div class='col-sm-8 col-sm-offset-2'>
               	<div class="row">
               		<div class="col-sm-7">
						<!--HEADER SECTION-->
						<H4>
							{{{ca_objects.preferred_labels.name}}}<br/>
		<?php
		                $vn_taxonID = $t_object->get('ca_occurrences.occurrence_id', ['restrictToRelationshipTypes' => 'taxonomy']);
		                $vs_sci_name_display = '';
						$t_taxa = new ca_occurrences($vn_taxonID);
                        $vs_taxaName = $t_taxa->get("ca_occurrences.preferred_labels");
                        $vs_taxaType = $t_taxa->get("ca_occurrences.type_id", ['convertCodesToDisplayText' => true]);
                        if($vs_taxaType == 'Specific Epithet'){
                            $vs_genus = $t_taxa->get("ca_occurrences.parent.parent.preferred_labels");
                            $vs_sci_name_display = '<em>'.$vs_genus.' '.$vs_taxaName.'</em>';
                        } else {
                            $vs_sci_name_display = $vs_taxaName;
                            if($vs_taxaType == 'Genus'){
                                $vs_sci_name_display = '<em>'.$vs_sci_name_display.'</em>';
                            }
                        }
						$vs_sciNameAuthor = $t_taxa->get('ca_occurrences.authorship.taxaAuthor');
						$vs_yearPublished = $t_taxa->get('ca_occurrences.authorship.taxaYear');

						if($vs_sciNameAuthor){
							$vs_sci_name_display .= ' ('.$vs_sciNameAuthor;
							if($vs_yearPublished){
								$vs_sci_name_display .= ', '.$vs_yearPublished.")";
							} else {
								$vs_sci_name_display .= ')';
							}
						}elseif($vs_yearPublished){
							$vs_sci_name_display .= ' ('.$vs_yearPublished.')';
						}
						print $vs_sci_name_display;
?>
						</H4>
					</div>
					<div class="col-sm-5">
<?php
						print '<div id="detailTools">';
						# Comment and Share Tools
						if ($vn_comments_enabled | $vn_share_enabled) {
							if ($vn_comments_enabled) {
?>
								<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
								<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php
							}
							if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
								print "<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array('object_id' => $t_object->get("object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"].$va_add_to_set_link_info["link_text"]."</a></div><!-- end detailTool -->";
							}
							if ($vn_share_enabled) {
								print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
							}
							print '</div><!-- end detailTools -->';
						}
?>
					</div>
				</div>

                <!-- IMAGE SECTION-->
<?php 
				if($t_object->get('ca_object_representations')){ 
					print '<div class="detailDivider"></div>';
?>
					<div class="row">
						<div class="col-sm-9 col-xs-12 colBorderRight">
							{{{representationViewer}}}
							<div id="detailAnnotations"></div>
						</div>
						<div class="col-sm-3 col-xs-12">
							<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => " smallpadding col-xs-12")); ?>
						</div>
				   	</div>
<?php
				}
?>
				
				
				<div class="detailDivider"></div>
                <!-- DETAILS SECTION -->
<?php
                $va_taxa = ['Kingdom' => '', 'Phylum' => '', 'Class' => '', 'Order' => '', 'Family' => '', 'Genus' => '', 'Specific Epithet' => ''];
                $vs_taxaHierarchy = $t_object->get('ca_occurrences.hierarchy.idno');
				$va_taxaHierarchy = explode(';', $vs_taxaHierarchy);
				
				foreach($va_taxaHierarchy as $vn_taxaIdno){
				    $vo_taxa = ca_occurrences::find(['idno' => $vn_taxaIdno], ['returnAs' => 'firstModelInstance']);
				    $vs_type = $vo_taxa->get('ca_occurrences.type_id', ['convertCodesToDisplayText' => true]);
				    if(array_key_exists($vs_type, $va_taxa)){
				        $vs_label = $vo_taxa->get('ca_occurrences.preferred_labels');
				        $va_taxa[$vs_type] = $vs_label;
				    }
				}
?>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h4>Taxonomy</h4>
					</div>
					<div class="col-sm-6 col-xs-12">
						<h4>Specimen Info</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-xs-12 colBorderRight">
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Kingdom</h6>
								<?php print $va_taxa['Kingdom']; ?>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Genus</h6>
								<?php print $va_taxa['Genus']; ?>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Phylum</h6>
								<?php print $va_taxa['Phylum']; ?>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Species</h6>
								<?php print $va_taxa['Specific Epithet']; ?>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Class</h6>
								<?php print $va_taxa['Class']; ?>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Author</h6>
								<?php print $vs_sciNameAuthor; ?>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Order</h6>
								<?php print $va_taxa['Order']; ?>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Year</h6>
								<?php print $vs_yearPublished; ?>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Family</h6>
								<?php print $va_taxa['Family']; ?>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12 ">
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Collected by</h6>
								<?php print $t_object->get('ca_entities', array('restrictToRelationshipTypes' => 'collected')); ?>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Date Collected</h6>
								{{{ca_objects.collectedDate}}}
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Identified By</h6>
								<?php print $t_object->get('ca_entities', array('restrictToRelationshipTypes' => 'identified')); ?>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Date Identified</h6>
								{{{ca_objects.identifiedDate}}}
							</div>
						</div>

						<div class="row detailRow">
							<div class="col-xs-10 detailFeild">
								<h6>Type</h6>
								<?php print $t_object->get('ca_objects.typeStatus', array('convertCodesToDisplayText' => true)); ?>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-10 detailFeild">
								<h6>Number of Pieces</h6>
								{{{ca_objects.numberPieces}}}
							</div>
						</div>
<?php
						
						$va_fullDescription = $t_object->get('ca_objects.fullDescription');
						if($va_fullDescription){
							$va_displayElement = $va_fullDescription;
						} else {
							$va_displayElement = $t_object->get('ca_objects.verbatimElement').', '.$t_object->get('ca_objects.verbatimRemarks');
						}
?>
						<div class="row detailRow">
							<div class="col-xs-10 detailFeild">
								<h6>Description</h6>
								<?php print $va_displayElement; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="detailDivider"></div>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h4>Locality</h4>
					</div>
					<div class="col-sm-6 col-xs-12">
						<h4>Lithostratigraphy</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="row detailRow">
<?php
							$vs_place_hierarchy = $t_object->get('ca_places.hierarchy.preferred_labels');
							$va_place_hierarchy = explode(';', $vs_place_hierarchy);
							$vn_level = sizeof($va_place_hierarchy);
							for($i = 0; $i < $vn_level; $i++){
								switch($i){
									case 0:
										break;
									case 1:
										$vs_country = $va_place_hierarchy[$i];
										break;
									case 2:
										$vs_stateProvince = $va_place_hierarchy[$i];
										break;
									case 3:
										$vs_county = $va_place_hierarchy[$i];
										break;
									case 4:
										break;
								}
							}
?>
							<div class="col-sm-6 detailFeild">
								<h6>Country</h6>
								<?php print $vs_country; ?>
							</div>
							
							<div class="col-sm-6 detailFeild">
								<h6>State/Province</h6>
								<?php print $vs_stateProvince; ?>
							</div>
						</div>
						<div class="row detailRow">	
							<div class="col-sm-6 detailFeild">
								<h6>County</h6>
								<?php print $vs_county; ?>
							</div>
							<div class="col-xs-6">
								<h6>Remarks</h6>
<?php 
								$va_geoRemarks = $t_object->get('ca_places.georeferenceRemarks');
								print $va_geoRemarks ? $va_geoRemarks : 'Information withheld. Please contact FHSM for detailed locality information';
?>
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
					<div class="col-sm-6 col-xs-12 colBorderLeft">
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Group</h6>
								{{{ca_objects.lithostratigraphy.group}}}
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Formation</h6>
								{{{ca_objects.lithostratigraphy.formation}}}
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Member</h6>
								{{{ca_objects.lithostratigraphy.member}}}
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Zone</h6>
								{{{ca_objects.lithostratigraphy.Zone}}}
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-10 detailFeild">
								<h6>Bed</h6>
								{{{ca_objects.lithostratigraphy.bed}}}
							</div>
						</div>
						<div class="row detailRow">	
							<div class="col-xs-12">
								<h6>Local Fauna</h6>
								<?php print $t_object->get('ca_objects.localFauna'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="detailDivider"></div>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h4>Chronostratigraphy</h4>
					</div>
					<div class="col-sm-6 col-xs-12">
						<h4>Biostratigraphy</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-xs-12 colBorderRight">
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Earliest Era</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.earliestEra}}}">{{{ca_objects.chronostratigraphy.earliestEra}}}</a>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Latest Era</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.latestEra}}}">{{{ca_objects.chronostratigraphy.latestEra}}}</a>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Earliest Period</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.earliestPeriod}}}">{{{ca_objects.chronostratigraphy.earliestPeriod}}}</a>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Latest Period</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.latestPeriod}}}">{{{ca_objects.chronostratigraphy.latestPeriod}}}</a>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Earliest Epoch</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.earliestEpoch}}}">{{{ca_objects.chronostratigraphy.earliestEpoch}}}</a>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Latest Epoch</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.latestEpoch}}}">{{{ca_objects.chronostratigraphy.latestEpoch}}}</a>
							</div>
						</div>
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Earliest Age</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.earliestAge}}}">{{{ca_objects.chronostratigraphy.earliestAge}}}</a>
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Latest Age</h6>
								<a href="../../Search/objects?search={{{ca_objects.chronostratigraphy.latestAge}}}">{{{ca_objects.chronostratigraphy.latestAge}}}</a>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="row detailRow">
							<div class="col-xs-6 detailFeild">
								<h6>Lowest Zone</h6>
								{{{ca_objects.biostratigraphy.lowestBiostratigraphicZone}}}
							</div>
							<div class="col-xs-6 detailFeild">
								<h6>Highest Zone</h6>
								{{{ca_objects.biostratigraphy.highestBiostratigraphicZone}}}
							</div>
						</div>
					</div>
				</div>
				<div class="detailDivider"></div>
				<div class="row">
					<div class="col-xs-12">
<?php
						$va_publications = $t_object->get('ca_occurrences.citation', array('returnAsArray' => true, 'restrictToTypes' => 'publication'));
						if(sizeof($va_publications) > 0){
							$vs_pub_count_display = sizeof($va_publications) >= 3 ? '3' : sizeof($va_publications);
?>
							<h4>Publications <small>(<span id="pubViewCount"><?php print $vs_pub_count_display; ?></span> of <?php print sizeof($va_publications); ?>) <button id="appendPublications">View All</button></small></h4>
							<div class="specimenPublicationList">
<?php
								for($i = 0; $i < 3; $i++){
									print '<div class="row detailRow"><div class="col-xs-12">';
									print $va_publications[$i];
									print '</div></div>';
								}
?>
							</div>
						<div class="additionalPublications">
<?php
							for($j = 3; $j < sizeof($va_publications); $j++){
								print '<div class="row detailRow"><div class="col-xs-12">';
								print $va_publications[$j];
								print '</div></div>';
							}
							print '</div>';
						}		
?>
						
					</div>
				</div>
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
		$('#appendPublications').on('click', function(){
			$('.additionalPublications').fadeIn();
			$('#appendPublications').fadeOut();
			$('#pubViewCount').html('<?php print sizeof($va_publications); ?>');
		});
	});
</script>
