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
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
 <?php				
					}
					
					print '</div><!-- end detailTools -->';
				}				

?> 

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4><b>{{{ca_objects.preferred_labels.name}}}</b></H4>
				<HR>
				    
<?php

            	if ($vs_titleInfo = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.titleInfo.subTitle">Subtitle: ^ca_objects.titleInfo.subTitle<br/></ifdef></unit>')) {
					print "<div class='unit'><h6><b>Title Info</b></h6>".$vs_titleInfo."</div>";
				}
					
				if ($vs_idno = $t_object->get('ca_objects.identifier')) {
					print "<div class='unit'><h6><b>Identifier</b></h6>".$vs_idno."</div>";
				}
				if ($vs_abstract = $t_object->get('ca_objects.abstract')) {
					print "<div class='unit'><h6><b>Abstract</b></h6>".$vs_abstract."</div>";
				}
				if ($vs_name = $t_object->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_objects.name.namePartname">Name: '.caNavLink($this->request, '^ca_objects.name.namePartname', '', '', 'Search', 'objects', ['search' => '^ca_objects.name.namePartname'], [], ['dontURLEncodeParameters' => true]).'<br/></ifdef><ifdef code="ca_objects.name.role">Role: ^ca_objects.name.role<br/></ifdef><ifdef code="ca_objects.name.affiliation">Institutional Affiliation: ^ca_objects.name.affiliation<br/></ifdef><ifdef code="ca_objects.name.description">Description: ^ca_objects.name.description<br/></ifdef><ifdef code="ca_objects.name.displayForm">Display Form: ^ca_objects.name.displayForm<br/></ifdef><ifdef code="ca_objects.name.nameIdentifier">Name Identifier: ^ca_objects.name.nameIdentifier</ifdef></unit>')) {
					print "<div class='unit'><h6><b>Name</b></h6>".$vs_name."</div>";
				}
				if ($vs_type = $t_object->get('ca_objects.typeOfResource', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6><b>Type Of Resource</b></h6>".$vs_type."</div>";
				}
				if ($vs_language = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.language.languageTerm">^ca_objects.language.languageTerm<br/></ifdef><ifdef code="ca_objects.language.scriptTerm">scriptTerm: ^ca_objects.language.scriptTerm</ifdef></unit>')) {
					print  "" ;
				}		
				if ($vs_note = $t_object->get('ca_objects.note')) {
					print "<div class='unit'><h6><b>Note</b></h6>".$vs_note."</div>";
				}
				if ($vs_originInfo = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.originInfo.dateIssued">Date Issued: ^ca_objects.originInfo.dateIssued<br/></ifdef><ifdef code="ca_objects.originInfo.dateCreated">Date Created: ^ca_objects.originInfo.dateCreated<br/></ifdef></ifdef><ifdef code="ca_objects.originInfo.place">Place: ^ca_objects.originInfo.place<br/></ifdef><ifdef code="ca_objects.originInfo.publisher">publisher: ^ca_objects.originInfo.publisher<br/></ifdef><ifdef code="ca_objects.originInfo.copyrightDate">copyrightDate: ^ca_objects.originInfo.copyrightDate<br/></ifdef><ifdef code="ca_objects.originInfo.edition">edition: ^ca_objects.originInfo.edition<br/></ifdef><ifdef code="ca_objects.originInfo.issuance">issuance: ^ca_objects.originInfo.issuance<br/></ifdef><ifdef code="ca_objects.originInfo.frequency">frequency: ^ca_objects.originInfo.frequency<br/></ifdef><ifdef code="ca_objects.originInfo.dateOther">dateOther: ^ca_objects.originInfo.dateOther<br/></ifdef><ifdef code="ca_objects.originInfo.dateValid">dateValid: ^ca_objects.originInfo.dateValid<br/></ifdef><ifdef code="ca_objects.originInfo.dateModified">dateModified: ^ca_objects.originInfo.dateModified</ifdef></unit>')) {
					print "<div class='unit'><h6><b>Origin Info</b></h6>".$vs_originInfo."</div>";
				}
				if ($vs_genre = $t_object->get('ca_objects.genre', array('delimiter' => ', '))) {
					print "<div class='unit'><h6><b>Genre</b></h6>".$vs_genre."</div>";
				}	
				if ($vs_phys_desc = $t_object->getWithTemplate('<unit></ifdef><ifdef code="ca_objects.physicalDescription.extent">extent: ^ca_objects.physicalDescription.extent<br/></ifdef><ifdef code="ca_objects.physicalDescription.digitalOrigin">Digital Origin: ^ca_objects.physicalDescription.digitalOrigin<br/></ifdef><ifdef code="ca_objects.physicalDescription.modsnote">Note: ^ca_objects.physicalDescription.modsnote<br/></ifdef><ifdef code="ca_objects.physicalDescription.form">note: ^ca_objects.physicalDescription.form</ifdef></unit>')) {
					print "<div class='unit'><h6><b>Physical Description</b></h6>".$vs_phys_desc."</div>";
				}
				if ($vs_table_contents = $t_object->get('ca_objects.tableOfContents', array('delimiter' => ', '))) {
					print "<div class='unit'><h6><b>Table of Contents</b></h6>".$vs_table_contents."</div>";
				}	
				if ($va_accessCondition = $t_object->get('ca_objects.accessCondition', array('returnAsArray' => true))) {
					foreach ($va_accessCondition as $va_key => $va_accessCondition_list_item_id) {
						$t_list_item = new ca_list_items($va_accessCondition_list_item_id);
						print "<div class='unit'><h6><b>Access Condition</b></h6><a href='".$t_list_item->get('ca_list_items.web_link')."' target='_blank'>".$t_list_item->get('ca_list_items.preferred_labels')."</a></div>";
					}
				}	
				if ($vs_copyrightNote = $t_object->get('ca_objects.copyrightNote', array('delimiter' => ', '))) {
					print "<div class='unit'><h6><b>Copyright Note</b></h6>".$vs_copyrightNote."</div>";
				}
				$vs_subjects = "";	
				if ($va_subjects = $t_object->get('ca_objects.subject', array('returnWithStructure' => true))) {
					foreach ($va_subjects as $va_key => $va_subject){
						foreach ($va_subject as $va_thing => $va_subject_text) {
							foreach ($va_subject_text as $va_one => $va_two) {
							    $va_two = preg_replace("!\[.*$!", "", $va_two);    
								if ($va_two) {
									#$vs_subjects.= "  ".$va_two."<br/>";
									$vs_subjects .= caNavLink($this->request, $va_two, '', '', 'Search', 'objects', ['search' => $va_two]);
								}
							}
							$vs_subjects.=  "<br/>";
						}	
					}
				}	
				if ($vs_subjects != "") {
					print "<div class='unit'><h6><b>Subjects</b></h6>";
					print $vs_subjects;
					print "</div>";
				}																										
?>				
				<hr></hr>
				<div class="row">
					<div class="col-sm-12">		
<?php
						if ($vs_related_item = $t_object->get('ca_objects.relatedItem')) {
							print "<div class='unit'><h6><b>Related Item</b></h6>".$vs_related_item."</div>";
						}
						if ($vs_finding_aid = $t_object->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_objects.finding_aid"><a href="^ca_objects.finding_aid" target="_blank">^ca_objects.finding_aid</a></ifdef></unit>')) {
							print "<div class='unit'><H6><b>Finding Aid</b></h6>".$vs_finding_aid."</div>";
						}
						if ($vs_extension = $t_object->get('ca_objects.extension')) {
							print "<div class='unit'><h6><b>Extension</b></h6>".$vs_extension."</div>";
						}
						if ($vs_parts = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.part.detail">Detail: ^ca_objects.part.detail<br/></ifdef><ifdef code="ca_objects.part.partextent">Extent: ^ca_objects.part.partextent<br/></ifdef><ifdef code="ca_objects.part.date">date: ^ca_objects.part.date<br/></ifdef><ifdef code="ca_objects.part.text">Text: ^ca_objects.part.text<br/></ifdef></unit>')) {
							print "<div class='unit'><h6><b>Part</b></h6>".$vs_parts."</div>";
						}	
						if ($vs_related_objects = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
							print "<div class='unit'><h6><b>Related Objects</b></h6>".$vs_related_objects."</div>";
						}	
						if ($vs_related_object_lot = $t_object->get('ca_object_lots.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
							print "<div class='unit'><h6><b>Related Lots</b></h6>".$vs_related_object_lot."</div>";
						}	
						if ($vs_related_creator = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('creator')))) {
							print "<div class='unit'><h6><b>Creator(s)</b></h6>".$vs_related_creator."</div>";
						}	
						if ($vs_related_publisher = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('publisher')))) {
							print "<div class='unit'><h6><b>Publisher(s)</b></h6>".$vs_related_publisher."</div>";
						}
						if ($vs_related_source = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('source')))) {
							print "<div class='unit'><h6><b>Source</b></h6>".$vs_related_source."</div>";
						}
						if ($vs_related_events = $t_object->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
							print "<div class='unit'><h6><b>Related Events</b></h6>".$vs_related_events."</div>";
						}	
						if ($vs_related_places = $t_object->get('ca_places.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
							print "<div class='unit'><h6><b>Related Places</b></h6>".$vs_related_places."</div>";
						}
						if ($vs_related_collections = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
							print "<div class='unit'><h6><b>Related Collections</b></h6>".$vs_related_collections."</div>";
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