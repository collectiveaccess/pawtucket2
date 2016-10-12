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
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
<?php
				$va_book_title = explode(" ", $t_object->get('ca_objects.preferred_labels'));
				$va_book_title = join('%20',$va_book_title);

?>				
				<div class='requestButton'><a href='mailto:contact@comediassueltasusa.com?Subject=Contribution%20to%20the%20Comedias%20Sueltas%20Project&body=Hi,%0A%0AI%20have%20more%20information%20about%20<?php print $va_book_title; ?>%0A%0AThank%20you%0A%0A%0A'>Have more information or a correction for this record? Contact a researcher by clicking here.</a></div>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6><?php print $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))?></H6>
				<HR>
<?php
				if ($vs_institution = $t_object->get('ca_objects.institution', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Holding Institution</h6>".$vs_institution."</div>";
				}
				if ($vs_call_no = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Call Number</h6>".$vs_call_no."</div>";
				}
				if ($vs_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Author</h6>".$vs_author."</div>";
				}
				if ($va_attribution = $t_object->get('ca_objects.attribution_issues', array('convertCodesToDisplayText' => true)) == "Yes") {
					print "<div class='unit warning'><i class='fa fa-warning'></i> Attribution issues<br/>";
					print $t_object->get('ca_objects.attribution_notes');
					print "</div>";
				}
				if ($vs_title = $t_object->get('ca_objects.preferred_labels')) {
					print "<div class='unit'><h6>Title</h6>".$vs_title."</div>";
				}
				if ($vs_subtitle = $t_object->get('ca_objects.subtitle')) {
					print "<div class='unit'><h6>Subtitle</h6>".$vs_subtitle."</div>";
				}
				if ($vs_added = $t_object->get('ca_objects.245c')) {
					print "<div class='unit'><h6>One Added Author, Translator or Responsible Person</h6>".$vs_added."</div>";
				}
				if ($vs_nonpreferred = $t_object->get('ca_objects.nonpreferred_labels')) {
					print "<div class='unit'><h6>Variation on a Title</h6>".$vs_nonpreferred."</div>";
				}
				if ($vs_caption_title = $t_object->get('ca_objects.caption_title')) {
					print "<div class='unit'><h6>Caption Title</h6>".$vs_caption_title."</div>";
				}
				if ($vs_place = $t_object->get('ca_places.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Place</h6>".$vs_place."</div>";
				}
				if ($vs_printer = $t_object->get('ca_objects.publication_description')) {
					print "<div class='unit'><h6>Printer, Publisher, Bookseller</h6>".$vs_printer."</div>";
				}
				if ($vs_date = $t_object->get('ca_objects.display_date', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
				}
				if ($vs_pagination = $t_object->get('ca_objects.pagination')) {
					print "<div class='unit'><h6>Pagination</h6>".$vs_pagination."</div>";
				}
				if ($vs_ornaments = $t_object->get('ca_objects.ornaments')) {
					print "<div class='unit'><h6>Illustration Ornaments</h6>".$vs_ornaments."</div>";
				}
				if ($vs_ornaments = $t_object->get('ca_objects.ornaments')) {
					print "<div class='unit'><h6>Illustration Ornaments</h6>".$vs_ornaments."</div>";
				}
				if ($vs_related_ornaments = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Related Ornaments</h6>".$vs_related_ornaments."</div>";
				}
				if ($vs_format = $t_object->get('ca_objects.format')) {
					print "<div class='unit'><h6>Format</h6>".$vs_format."</div>";
				}
				if ($vs_notes = $t_object->get('ca_objects.500_notes')) {
					print "<div class='unit'><h6>General Notes; Collation; Physical Description; Performance Date</h6>".$vs_notes."</div>";
				}
				if ($vs_citation = $t_object->get('ca_objects.510_citation_reference')) {
					print "<div class='unit'><h6>Citation Reference</h6>".$vs_citation."</div>";
				}
				if ($vs_printers_number = $t_object->get('ca_objects.515_printers_number')) {
					print "<div class='unit'><h6>Printer's Series Number</h6>".$vs_printers_number."</div>";
				}
				if ($vs_page_number = $t_object->get('ca_objects.page_number')) {
					print "<div class='unit'><h6>Page Number On Page 1</h6>".$vs_page_number."</div>";
				}	
				if ($vs_language = $t_object->get('ca_objects.546_language')) {
					print "<div class='unit'><h6>Language Note & Translation</h6>".$vs_language."</div>";
				}
				if ($vs_ownership = $t_object->get('ca_objects.561_ownership')) {
					print "<div class='unit'><h6>Ownership</h6>".$vs_ownership."</div>";
				}
				if ($vs_binding = $t_object->get('ca_objects.563_binding')) {
					print "<div class='unit'><h6>Binding</h6>".$vs_binding."</div>";
				}
				if ($vs_linking = $t_object->get('ca_objects.580_linking')) {
					print "<div class='unit'><h6>Linking</h6>".$vs_linking."</div>";
				}
				if ($vs_local_notes = $t_object->get('ca_objects.590_local')) {
					print "<div class='unit'><h6>Local Notes</h6>".$vs_local_notes."</div>";
				}
				if ($vs_subjects = $t_object->get('ca_objects.600_subjects')) {
					print "<div class='unit'><h6>Subjects</h6>".$vs_subjects."</div>";
				}
				if ($vs_themes = $t_object->get('ca_objects.650_themes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Themes</h6>".$vs_themes."</div>";
				}
				if ($vs_ownership = $t_object->get('ca_objects.700_ownership')) {
					print "<div class='unit'><h6>Ownership</h6>".$vs_ownership."</div>";
				}
				if ($vs_added_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author', 'contributer', 'editor', 'illustrator', 'translator'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Added Authors or Translators</h6>".$vs_added_author."</div>";
				}
				if ($vs_added_printer = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('printer'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Added Entry Printer</h6>".$vs_added_printer."</div>";
				}
				if ($vs_added_publisher = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Added Entry Publisher</h6>".$vs_added_publisher."</div>";
				}
				if ($vs_added_bookseller = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('bookseller'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Added Entry Bookseller</h6>".$vs_added_bookseller."</div>";
				}
				if ($vs_url = $t_object->get('ca_objects.856_url')) {
					print "<div class='unit'><h6>Permanent Link to URL</h6>".$vs_url."</div>";
				}																																																																																																																																	
?>

				
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}

							{{{<ifcount code="ca_collections" min="1"><H6>Locate This Copy</H6></ifcount>}}}
							{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
							{{{<unit relativeTo="ca_collections" delimiter="<br/>"><br/>^ca_collections.description</unit>}}}			
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->	
					</div>
					<div class='row'>				
						<div class="col-sm-12">
							<div style='margin-top:10px;'>{{{map}}}</div>
						</div>
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