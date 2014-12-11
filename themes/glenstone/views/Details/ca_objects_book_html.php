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
					print '<h5>'.$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => '; ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname')).'</h5>';
				} else {
					print '<h5>'.$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'delimiter' => '; ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname')).'</h5>';				
				}
?>				
			</div>
			<div class='col-sm-4 col-md-4 col-lg-4'>
			
				{{{representationViewer}}}
				
<?php
		print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
?>				
	
			<!--<div class='requestButton'>Request this item  &nbsp;<i class='fa fa-envelope'></i></div>	-->		
			</div><!-- end col -->
			<div class='col-sm-7 col-md-7 col-lg-7'>


				<!-- library-->
				
				{{{<ifdef code="ca_objects.preferred_labels"><div class='unit'><span >^ca_objects.preferred_labels</span></div></ifdef>}}}				
<?php
				if ($va_author = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'returnAsLink' => true, 'delimiter' => '; ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname'))) {
					print "<div class='unit'><span >".$va_author."</span></div>";
				} else {
					print "<div class='unit'><span >".$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'returnAsLink' => true, 'delimiter' => '; ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname'))."</span></div>";
				}
?>
				{{{<ifdef code="ca_objects.publication_description"><div class='unit'><span>^ca_objects.publication_description</span></div></ifdef>}}}
<?php
				$va_copies = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true));
?>
				<h2>Availability</h2>
				
				<?php print "<span class='copies'>".sizeof($va_copies)." copies </span>"; ?>
				<a href='#' class='availability' onclick='$("#availability").slideDown();$(".availability").hide();$(".hideAvailability").fadeIn();return false;'>click to view</a>
				<a href='#' class='hideAvailability' style='display:none;' onclick='$("#availability").slideUp();$(".hideAvailability").hide();$(".availability").fadeIn();return false;'>click to hide</a>				
<?php
				if (sizeof($va_copies)) {
					print "<div id='availability' style='display:none;'>";
					foreach ($va_copies as $vn_id => $va_copy) {
						$t_copy = new ca_objects($va_copy);
						print "<div class='unit'><span class='metaTitle'>Item: </span><span class='meta'>".$t_copy->get('ca_objects.copy_name')."</span></div>";
						if ($va_call_number = $t_copy->get('ca_objects.call_number')) {
							print "<div class='unit'><span class='metaTitle'>Call Number </span><span class='meta'>".$va_call_number."</span></div>";
						}
						if ($va_copy_location = $t_copy->get('ca_storage_locations.hierarchy.preferred_labels', array('delimiter' => ' > '))) {
							print "<div class='unit'><span class='metaTitle'>Location </span><span class='meta'>".caNavLink($this->request, substr($va_copy_location, 4), '', '', 'Search', 'copy/facet/storage_location/id/'.$t_copy->get('ca_storage_locations.location_id'))."</span></div>";
						}
						if ($va_status = $t_copy->get('ca_objects.purchase_status', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><span class='metaTitle'>Status </span><span class='meta'>".$va_status."</span></div>";
						}						
						print "<hr>";														
					}
					print "</div>";
				}
				
?>				


				<h2>More Information</h2>
				{{{<ifdef code="ca_objects.library_formats"><div class='unit'><span class='metaTitle'>Format </span><span class="meta">^ca_objects.library_formats%useSingular=1</span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.nonpreferred_labels"><div class='unit '><span class='metaTitle'>Variant Title </span><span class='meta'><unit delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></span></div></ifcount>}}}
				{{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="publisher" min="1" ><div class='unit '><span class='metaTitle'>Publisher </span><span class='meta'><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter="<br/>"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}

<?php
				if ($va_ISBN = $t_object->get('ca_objects.ISBN', array('returnAsArray' => true))) {
					print "<div class='unit '><span class='metaTitle'>ISBN </span><span class='meta'>";
					foreach ($va_ISBN as $va_isbn_no) {
						if(strlen($va_isbn_no['ISBN']) != 13) {
							print $va_isbn_no['ISBN'];
						}
					}
					print "</span></div>";
				}
?>
				<!-- {{{<ifdef code="ca_objects.altISBN"><div class='unit '><span class='metaTitle'>Alternate ISBN </span><span class='meta'>^ca_objects.altISBN</span></div></ifdef>}}} -->
				{{{<ifdef code="ca_objects.edition_statment"><div class='unit '><span class='metaTitle'>Edition Statement </span><span class='meta'>^ca_objects.edition_statment</span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.language"><div class='unit '><span class='metaTitle'>Languages </span><span class='meta'><unit delimiter="<br/>">^ca_objects.language</unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.copy_number"><div class='unit '><span class='metaTitle'>Copy Number </span><span class='meta'>^ca_objects.copy_number</span></div></ifdef>}}}

<?php	

#				if ($va_notes = $t_object->get('ca_objects.general_notes', array('convertCodesToDisplayText' => true))) {
#					print "<div class='unit'><span class='metaTitle'>Notes </span><span class='meta'>".$va_notes."</span></div>";
#				}	
# Reimplement after cleanup						
#				if ($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
#					print "<div class='unit '><span class='metaTitle'>Subjects</span><span class='meta'>";
#					foreach ($va_lcsh_terms as $k_lchs => $va_lcsh_term) {
#						$va_lcsh = explode("[", $va_lcsh_term['lcsh_terms']);
						
#						print caNavLink($this->request, $va_lcsh[0]."<br/>", '', '', 'MultiSearch', 'Index', array('search' => 'ca_objects.lcsh_terms:"'.preg_replace('/[^A-Za-z0-9]/', ' ', $va_lcsh[0]).'"'));
#					}
#					print "</span></div>"; 
#				}				
?>	
				{{{<ifdef code="ca_objects.physical_description"><div class='unit '><span class='metaTitle'>Physical Description </span><span class='meta'>^ca_objects.physical_description</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.library_summary"><div class='unit '><span class='metaTitle'>Summary </span><span class='meta'>^ca_objects.library_summary</span></div></ifdef>}}}				

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
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_object = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'archives/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'archives/'.$va_object_id)."</p>";
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