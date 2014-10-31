<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{resultsLink}}}<div class='detailPrevLink'>{{{previousLink}}}</div>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
	
	</div>
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div>
<div class="row">
	<div class="container">
			<div class="artworkTitle">
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
<?php
				if ($t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author')))) {
					print '<h5>'.$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => '<br/>')).'</h5>';
				} else {
					print '<h5>'.$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'delimiter' => '<br/>')).'</h5>';				
				}
?>				
			</div>
			<div class='col-sm-6 col-md-6 col-lg-6'>
			
				{{{representationViewer}}}
				
<?php
		print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
?>				
	
			<div class='requestButton'>Request this item  &nbsp;<i class='fa fa-envelope'></i></div>			
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>


				<!-- library-->
				
				{{{<ifdef code="ca_objects.preferred_labels"><div class='unit'><span >^ca_objects.preferred_labels</span></div></ifdef>}}}				
<?php
				if ($va_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'returnAsLink' => true, 'delimiter' => '; '))) {
					print "<div class='unit'><span >".$va_author."</span></div>";
				} else {
					print "<div class='unit'><span >".$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'returnAsLink' => true, 'delimiter' => '; '))."</span></div>";
				}
?>
				{{{<ifdef code="ca_objects.publication_description"><div class='unit'><span>^ca_objects.publication_description</span></div></ifdef>}}}

				<h2>Availability</h2>
<?php
				$va_copies = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true));
				if (sizeof($va_copies)) {
					foreach ($va_copies as $vn_id => $va_copy) {
						$t_copy = new ca_objects($va_copy);
						print "<div class='unit'><span class='metaTitle'>Copy: </span><span class='meta'>".$t_copy->get('ca_objects.preferred_labels')."</span></div>";
						if ($va_call_number = $t_copy->get('ca_objects.call_number')) {
							print "<div class='unit'><span class='metaTitle'>Call Number </span><span class='meta'>".$va_call_number."</span></div>";
						}
						if ($va_copy_location = $t_copy->get('ca_storage_locations.hierarchy.preferred_labels', array('delimiter' => ' > '))) {
							print "<div class='unit'><span class='metaTitle'>Location </span><span class='meta'>".substr($va_copy_location, 4)."</span></div>";
						}
						if ($va_status = $t_copy->get('ca_objects.purchase_status', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><span class='metaTitle'>Status </span><span class='meta'>".$va_status."</span></div>";
						}
						if ($va_notes = $t_copy->get('ca_objects.general_notes', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><span class='metaTitle'>Notes </span><span class='meta'>".$va_notes."</span></div>";
						}						
						print "<hr>";														
					}
				}
				
?>				


				<h2>More Information</h2>
				{{{<ifdef code="ca_objects.library_formats"><div class='unit'><span class='metaTitle'>Format </span><span class="meta">^ca_objects.library_formats%useSingular=1</span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.nonpreferred_labels"><div class='unit '><span class='metaTitle'>Variant Title </span><span class='meta'><unit delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></span></div></ifcount>}}}
				{{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="publisher" min="1" ><div class='unit '><span class='metaTitle'>Publisher </span><span class='meta'><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter="<br/>"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}

				{{{<ifcount min="1" code="ca_objects.ISBN"><div class='unit '><span class='metaTitle'>ISBN </span><span class='meta'><unit delimiter='<br/>'>^ca_objects.ISBN</unit></span></div></ifcount>}}}

				{{{<ifdef code="ca_objects.altISBN"><div class='unit '><span class='metaTitle'>Alternate ISBN </span><span class='meta'>^ca_objects.altISBN</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.edition_statment"><div class='unit '><span class='metaTitle'>Edition Statement </span><span class='meta'>^ca_objects.edition_statment</span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.language"><div class='unit '><span class='metaTitle'>Languages </span><span class='meta'><unit delimiter="<br/>">^ca_objects.language</unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.copy_number"><div class='unit '><span class='metaTitle'>Copy Number </span><span class='meta'>^ca_objects.copy_number</span></div></ifdef>}}}

<?php				
				if ($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
					print "<div class='unit '><span class='metaTitle'>Library of Congress Subject Headings</span><span class='meta'>";
					foreach ($va_lcsh_terms as $k_lchs => $va_lcsh_term) {
						$va_lcsh = explode("[", $va_lcsh_term['lcsh_terms']);
						
						print caNavLink($this->request, $va_lcsh[0]."<br/>", '', '', 'MultiSearch', 'Index', array('search' => 'ca_objects.lcsh_terms:"'.preg_replace('/[^A-Za-z0-9]/', ' ', $va_lcsh[0]).'"'));
					}
					print "</span></div>"; 
				}				
?>	
				{{{<ifdef code="ca_objects.general_notes"><div class='unit '><span class='metaTitle'>General Notes </span><span class='meta'>^ca_objects.general_notes</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.library_summary"><div class='unit '><span class='metaTitle'>Summary </span><span class='meta'>^ca_objects.library_summary</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.physical_description"><div class='unit '><span class='metaTitle'>Physical Description </span><span class='meta'>^ca_objects.physical_description</span></div></ifdef>}}}

<!--				
				{{{<ifdef code="ca_objects.preferred_labels"><div class='unit wide'><span class='metaHeader'>Title </span><span >^ca_objects.preferred_labels</span></div></ifdef>}}}				
				{{{<ifcount min="1" code="ca_objects.nonpreferred_labels"><div class='unit wide'><span class='metaHeader'>Variant Title </span><span><unit delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.call_number"><div class='unit wide'><span class='metaHeader'>Call Number </span><span>^ca_objects.call_number</span></div></ifdef>}}}
				{{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="author" min="1" ><div class='unit wide'><span class='metaHeader'>Author</span><span ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter="<br/>"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
				{{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="publisher" min="1" ><div class='unit wide'><span class='metaHeader'>Publisher </span><span ><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter="<br/>"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.publication_description"><div class='unit wide'><span class='metaHeader'>Publication and Distribution Information </span><span>^ca_objects.publication_description</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.ISBN"><div class='unit wide'><span class='metaHeader'>ISBN </span><span>^ca_objects.ISBN</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.altISBN"><div class='unit wide'><span class='metaHeader'>Alternate ISBN </span><span>^ca_objects.altISBN</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.physical_description"><div class='unit wide'><span class='metaHeader'>Physical Description </span><span>^ca_objects.physical_description</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.edition_statment"><div class='unit wide'><span class='metaHeader'>Edition Statement </span><span>^ca_objects.edition_statment</span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.language"><div class='unit wide'><span class='metaHeader'>Languages </span><span><unit delimiter="<br/>">^ca_objects.language</unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.general_notes"><div class='unit wide'><span class='metaHeader'>General Notes </span><span>^ca_objects.general_notes</span></div></ifdef>}}}
-->
<?php				
#				if ($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
#					print "<div class='unit wide'><span class='metaHeader'>Library of Congress Subject Headings</span><span>";
#					foreach ($va_lcsh_terms as $k_lchs => $va_lcsh_term) {
#						$va_lcsh = explode("[", $va_lcsh_term['lcsh_terms']);
#						print caNavLink($this->request, $va_lcsh[0]."<br/>", '', '', 'MultiSearch', 'Index', array('search' => 'ca_objects.lcsh_terms:'.$va_lcsh[0]));
#					}
#					print "</span></div>";
#				}				
?>	
<!--			
				{{{<ifdef code="ca_objects.copy_number"><div class='unit wide'><span class='metaHeader'>Copy Number </span><span>^ca_objects.copy_number</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.purchase_status"><div class='unit wide'><span class='metaHeader'>Status </span><span>^ca_objects.purchase_status</span></div></ifdef>}}}
	
				<hr>
				
				{{{<ifcount min="1" relativeTo="ca_objects.related"  restrictToTypes="book"><div class='unit wide'><span class='metaHeader'>Library </span><span ><unit relativeTo="ca_objects.related" restrictToTypes="book" delimiter="<br/>"><l>^ca_objects.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" code="ca_occurrences.preferred_labels" restrictToTypes="exhibition"><div class='unit wide'><span class='metaHeader'>Exhibition </span><span ><unit delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" min="1" ><div class='unit wide'><span class='metaHeader'>Related Entities</span><span ><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.name (^ca_entities.typename)</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" code="ca_storage_locations.preferred_labels"><div class='unit wide'><span class='metaHeader'>Storage Location </span><span ><unit delimiter="<br/>"><l>^ca_storage_locations.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" relativeTo="ca_loans" code="ca_loans.preferred_labels" restrictToTypes="collection"><div class='unit wide'><span class='metaHeader'>Related Artwork Loans </span><span ><unit relativeTo="ca_loans" restrictToTypes="collection" delimiter="<br/>"><l>^ca_loans.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" relativeTo="ca_loans"  restrictToTypes="archive"><div class='unit wide'><span class='metaHeader'>Related Archival Loans </span><span ><unit relativeTo="ca_loans" restrictToTypes="archive" delimiter="<br/>"><l>^ca_loans.preferred_labels</l></unit></span></div></ifcount>}}}

							
				{{{<ifcount min="1" code="ca_object_lots.preferred_labels"><div class='unit wide'><span class='metaHeader'>Related Accession </span><span ><unit delimiter="<br/>"><l>^ca_object_lots.preferred_labels</l></unit></span></div></ifcount>}}}
-->

			
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
<?php
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
?>		<hr>
		<H6>Related Archive Items</H6>
		<div class="archivesBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_object = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'artworks/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'artworks/'.$va_object_id)."</p>";
				print "<p>".$t_object->get('ca_objects.dc_date.dc_dates_value')."</p>";
				print "</div><!-- archivesResult -->";
			}
			if (!$this->request->isAjax()) {		
?>	
					</div> <!-- blockResultsScroller -->
				</div> <!-- archivesResults -->
			</div> <!-- blockResults -->
		</div> <!-- archivesBlock -->
<?php
			}	
?>	
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('artwork')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
?>		<hr>
		<H6>Related Artworks</H6>
		<div class="archivesBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('artwork')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_object = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'artworks/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'artworks/'.$va_object_id)."</p>";
				print "<p class='artist'>".$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";
				print "<p>".$t_object->get('ca_objects.object_dates')."</p>";
				print "</div><!-- archivesResult -->";
			}
			if (!$this->request->isAjax()) {		
?>	
					</div> <!-- blockResultsScroller -->
				</div> <!-- archivesResults -->
			</div> <!-- blockResults -->
		</div> <!-- archivesBlock -->
<?php
			}	
?>	
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}	
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.archivesResults').hscroll({
			name: 'archives',
			itemWidth: jQuery('.archivesResult').outerWidth(true),
			itemsPerLoad: 10,
			itemContainerSelector: '.blockResultsScroller',
			sortParameter: 'archivesSort',
			sortControlSelector: '#archives_sort',
			scrollPreviousControlSelector: '#archivesscrollButtonPrevious',
			scrollNextControlSelector: '#archivesscrollButtonNext',
			scrollControlDisabledOpacity: 0,
			cacheKey: '{{{cacheKey}}}'
		});
	});
</script>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 65
		});
	});
</script>