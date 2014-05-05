<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
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
				<H4>{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist|creator"><l>^ca_entities.preferred_labels.name</l></unit>}}}</H4>
				<H5><i>{{{ca_objects.preferred_labels.name}}}</i>, {{{ca_objects.creation_date}}}</H5> 
			</div>
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
	if (sizeof($t_object->get('ca_object_representations.media', array('returnAsArray' => true))) > 0) {
?>			
				{{{representationViewer}}}
<?php
	} else {
		print "<div class='mediaPlaceholder'><i class='fa fa-picture-o'></i></div>";
	}	
?>	
			
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
			
				<div class='tabdiv'>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#artworkInfo').fadeIn(100);">Artwork</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#factSheet').fadeIn(100);">Fact Sheet</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Location').fadeIn(100);">Location</a></div> 
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Financial').fadeIn(100);">Financials</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Condition').fadeIn(100);">Condition</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Description').fadeIn(100);">Description</a></div>
				</div>
				
					<hr>
				
				<div id="artworkInfo" class="infoBlock">
					{{{<div class='unit'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist|creator"><b><l>^ca_entities.preferred_labels.name</l></b></unit></div>}}}
					<div class='unit'><b>{{{ca_objects.preferred_labels.name}}}</i>, &nbsp;{{{ca_objects.creation_date}}}</b></div>
					{{{<ifdef code="ca_objects.medium"><div class='unit'>^ca_objects.medium</div></ifdef>}}}
					{{{<ifcount min="1" code="ca_objects.dimensions.display_dimensions"><div class='unit'><unit delimiter="<br/>">^ca_objects.dimensions.display_dimensions ^ca_objects.dimensions.Type</unit></div></ifcount>}}}
					{{{<ifdef code="ca_objects.edition.edition_number"><div class='unit'>Edition <ifdef code="ca_objects.edition.edition_number">^ca_objects.edition.edition_number / ^ca_objects.edition.edition_total </ifdef><ifdef code="ca_objects.edition.ap_number"><br/>^ca_objects.edition.ap_number / ^ca_objects.edition.other_info  AP</ifdef></div></ifdef>}}}
					{{{<ifdef code="ca_objects.signed.signed_yn"><div class='unit'>Signature ^ca_objects.signed.signed_yn<ifdef code="ca_objects.signed.signature_details">, ^ca_objects.signed.signature_details</ifdef></div></ifdef>}}}
					{{{<ifcount min="1" code="ca_objects.idno"><div class="unit">^ca_objects.idno</div></ifcount>}}}				
				</div>
				
				<div id="factSheet" class="infoBlock">	
					{{{<ifdef code="ca_objects.artwork_provenance"><div class='unit wide'><span class='metaHeader'>Provenance</span><span>^ca_objects.artwork_provenance</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.exhibition_history"><div class='unit wide'><span class='metaHeader'>Exhibition History</span><span >^ca_objects.exhibition_history</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.literature"><div class='unit wide'><span class='metaHeader'>Literature </span><span >^ca_objects.literature</span></div></ifdef>}}}
				</div>
				
				<div id="Location" class="infoBlock">
					{{{<ifcount min="1" code="ca_objects.legacy_locations.legacy_location"><div class='unit wide'><span class='metaHeader'>Locations</span><unit delimiter="<br/>">^ca_objects.legacy_locations.legacy_location <ifdef code="ca_objects.legacy_locations.sublocation">- ^ca_objects.legacy_locations.sublocation</ifdef> <ifdef code="ca_objects.legacy_locations.via">(via ^ca_objects.legacy_locations.via)</ifdef><ifdef code="ca_objects.legacy_locations.legacy_location_date"> as of ^ca_objects.legacy_locations.legacy_location_date</ifdef></unit></div></ifcount>}}}

				</div>
				
				<div id="Financial" class="infoBlock">
<?php
					if ($this->request->user->hasUserRole("collection")){
				
					print "{{{<div class='unit'><span class='metaTitle'>Acquired: </span><span class='meta'>^ca_objects.acquired</span></div>}}}
					{{{<div class='unit'><span class='metaTitle'>Gift: </span><span class='meta'>^ca_objects.gift_yn</span></div>}}}			
					{{{<ifcount min='1' relativeTo='ca_entities' code='ca_entities' restrictToRelationshipTypes='source'><div class='unit'><span class='metaTitle'>Seller: </span><span class='meta'><unit relativeTo='ca_entities' delimiter='<br/>' restrictToRelationshipTypes='source'><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
					{{{<ifcount min='1' relativeTo='ca_entities' code='ca_entities' restrictToRelationshipTypes='advisor'><div class='unit'><span class='metaTitle'>Advisor: </span><span class='meta'><unit relativeTo='ca_entities' delimiter='<br/>' restrictToRelationshipTypes='advisor'><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}";

					} else {
						print "access restricted";
					}
?>
				</div>
				<div id="Condition" class="infoBlock">
					Condition information is forthcoming
				</div>
				<div id="Description" class="infoBlock">
					{{{<ifcount min="1" code="ca_objects.object_dates.object_date"><div class='unit'><span class='metaTitle'>Date: </span><span class='meta'><unit delimiter="<br/>">^ca_objects.object_dates.object_date <ifdef code="ca_objects.object_dates.date_note">(^ca_objects.object_dates.date_note)</ifdef</unit></span></div></ifcount>}}}
					{{{<ifdef code="ca_objects.sticker_label"><div class='unit'><span class='metaTitle'>Label Details </span><span class='meta'>^ca_objects.sticker_label</span></div></ifdef>}}}
					{{{<ifcount min="1" code="ca_objects.child.preferred_labels"><div class='unit wide'><span class='metaHeader'>Elements </span><span ><unit delimiter="<br/>"><l>^ca_objects.child.preferred_labels</l></unit></span></div></ifcount>}}}
					{{{<ifdef code="ca_objects.element_notes"><div class='unit'><span class='metaTitle'>Element Notes: </span><span class='meta'>^ca_objects.element_notes</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.category"><div class='unit'><span class='metaTitle'>Category: </span><span class='meta'>^ca_objects.category</span></div></ifdef>}}}


					<!--
					{{{<ifdef code="ca_objects.framed_yn"><div class='unit'><span class='metaTitle'>Framed: </span><span class='meta'>^ca_objects.framed_yn</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.artwork_description"><div class='unit'><span class='metaTitle'>Description: </span><span class='meta'>^ca_objects.artwork_description</span></div></ifdef>}}}
					{{{<ifcount min="1" code="ca_object_lots.preferred_labels"><div class='unit wide'><span class='metaHeader'>Related Accession </span><span ><unit delimiter="<br/>"><l>^ca_object_lots.preferred_labels</l></unit></span></div></ifcount>}}}
					-->
				</div>				
			
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
<?php
	if ($t_object->get('ca_objects.related', array('restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')))) {
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
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_archive = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_archive->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_archive->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
				print "<p>".$t_archive->get('ca_objects.dc_date.dc_dates_value')."</p>";
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
	
	if ($t_object->get('ca_objects.related', array('restrictToTypes' => array('book')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
?>		<hr>
		<H6>Related Library Items</H6>
		<div class="libraryBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('book')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_library = new ca_objects($va_object_id);
				print "<div class='libraryResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_library->get('ca_object_representations.media.library'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_library->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";				
				print "<p>".caNavLink($this->request, $t_library->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('author'))), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
				print "<p>".$t_library->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('publisher')))."</p>";
				print "</div><!-- libraryResult -->";
			}
			if (!$this->request->isAjax()) {		
?>	
					</div> <!-- blockResultsScroller -->
				</div> <!-- libraryResults -->
			</div> <!-- blockResults -->
		</div> <!-- libraryBlock -->
<?php
			}	
?>	
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}	
	
	if ($t_object->get('ca_objects.related', array('restrictToTypes' => array('artwork')))) {
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
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('artwork')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_object = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
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