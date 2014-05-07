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
				<H4>{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist|creator">^ca_entities.preferred_labels.name</unit>}}}</H4>
				<H5>{{{ca_objects.preferred_labels.name}}}</H5>
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

				{{{<ifdef min="1" code="ca_objects.idno"><div class="unit"><span class='metaTitle'>ID: </span><span class='meta'>^ca_objects.idno</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.object_dates.object_date"><div class='unit'>^ca_objects.object_dates.object_date</div></ifdef>}}}
				{{{<ifdef code="ca_objects.medium"><div class='unit'>^ca_objects.medium</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.display_dimensions"><div class='unit'>^ca_objects.dimensions.display_dimensions ^ca_objects.dimensions.Type</div></ifdef>}}}
				
				<!-- archives -->
<?php
			if ($t_object->get('ca_objects.type_id') == 25 | $t_object->get('ca_objects.type_id') == 26) {		
				print '{{{<ifcount min="1" relativeTo="ca_collections" code="ca_collections.preferred_labels"><div class="unit"><span class="metaTitle">Parent Collection: </span><span class="meta"><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit></span></div></ifcount>}}}';				
			}
?>				 
				{{{<ifdef code="ca_objects.image_technique"><div class='unit'><span class='metaTitle'>Technique: </span><span class='meta'>^ca_objects.image_technique</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.photographic_materials"><div class='unit'><span class='metaTitle'>Materials: </span><span class='meta'>^ca_objects.photographic_materials</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.caption_annotation"><div class='unit'><span class='metaTitle'>Caption/Annotation: </span><span class='meta'>^ca_objects.caption_annotation</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.format_moving"><div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>^ca_objects.format_moving</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.audio_format"><div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>^ca_objects.audio_format</span></div></ifdef>}}}

				{{{<ifdef code="ca_objects.format_ephemera"><div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>^ca_objects.format_ephemera</span></div></ifdef>}}}

				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="creator"><div class='unit'><span class='metaTitle'>Creator: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels</l></unit></span></div></ifcount>}}}				
				{{{<ifcount min="1" code="ca_entities" restrictToRelationshipTypes="publisher"><div class='unit'><span class='metaTitle'>Publisher: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="publisher"><l>^ca_entities.preferred_labels</l></unit></span></div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.dc_date.dc_dates_value"><div class='unit'><span class='metaTitle'>Date: </span><span class='meta'>^ca_objects.dc_date.dc_dates_value</span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.rights"><div class='unit'><span class='metaTitle'>Rights: </span><span class='meta'><unit delimiter="<br/>">^ca_objects.rights</unit></span></div></ifcount>}}}
						
				<hr>
				
				{{{<ifdef code="ca_objects.acquired"><div class='unit'><span class='metaTitle'>Acquired: </span><span class='meta'>^ca_objects.acquired</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.signed.signed_yn"><div class='unit'><span class='metaTitle'>Signed: </span><span class='meta'>^ca_objects.signed.signed_yn<ifdef code="ca_objects.signed.signature_details">, ^ca_objects.signed.signature_details</ifdef></span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.category"><div class='unit'><span class='metaTitle'>Category: </span><span class='meta'>^ca_objects.category</span></div></ifdef>}}}

				{{{<ifdef code="ca_objects.gift_yn"><div class='unit'><span class='metaTitle'>Gift: </span><span class='meta'>^ca_objects.gift_yn</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.framed_yn"><div class='unit'><span class='metaTitle'>Framed: </span><span class='meta'>^ca_objects.framed_yn</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.edition"><div class='unit'><span class='metaTitle'>Edition: </span><span class='meta'><ifdef code="ca_objects.edition.edition_number">^ca_objects.edition.edition_number / ^ca_objects.edition.edition_total </ifdef><ifdef code="ca_objects.edition.ap_number"><br/>^ca_objects.edition.ap_number / ^ca_objects.edition.other_info  AP</ifdef></span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.artwork_description"><div class='unit'><span class='metaTitle'>Description: </span><span class='meta'>^ca_objects.artwork_description</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.sticker_label"><div class='unit wide'><span class='metaHeader'>Label Details </span><span >^ca_objects.sticker_label</span></div></ifdef>}}}
				{{{<ifcount min="1" relativeTo="ca_objects.related"  restrictToTypes="book"><div class='unit wide'><span class='metaHeader'>Library </span><span ><unit relativeTo="ca_objects.related" restrictToTypes="book" delimiter="<br/>"><l>^ca_objects.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" code="ca_occurrences.preferred_labels" restrictToTypes="exhibition"><div class='unit wide'><span class='metaHeader'>Exhibition </span><span ><unit delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.literature"><div class='unit wide'><span class='metaHeader'>Literature </span><span >^ca_objects.literature</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.exhibition_history"><div class='unit wide'><span class='metaHeader'>Exhibition History</span><span >^ca_objects.exhibition_history</span></div></ifdef>}}}
				
				<!-- archives -->
				
				{{{<ifdef code="ca_objects.moving_description"><div class='unit wide'><span class='metaHeader'>Description: </span><span>^ca_objects.moving_description</span></div></ifdef>}}}
	
<?php
				
				/*  library */
				
				if ($t_object->get('ca_objects.type_id') == 30) {
?>
				{{{<ifcount min="1" code="ca_storage_locations.preferred_labels"><div class='unit wide'><span class='metaHeader'>Storage Location </span><span ><unit delimiter="<br/>"><l>^ca_storage_locations.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" relativeTo="ca_loans" code="ca_loans.preferred_labels" restrictToTypes="collection"><div class='unit wide'><span class='metaHeader'>Related Artwork Loans </span><span ><unit relativeTo="ca_loans" restrictToTypes="collection" delimiter="<br/>"><l>^ca_loans.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" relativeTo="ca_loans" code="ca_loans.preferred_labels" restrictToTypes="archive"><div class='unit wide'><span class='metaHeader'>Related Archival Loans </span><span ><unit relativeTo="ca_loans" restrictToTypes="archive" delimiter="<br/>"><l>^ca_loans.preferred_labels</l></unit></span></div></ifcount>}}}

<?php
				}					
?>								
				{{{<ifcount min="1" code="ca_object_lots.preferred_labels"><div class='unit wide'><span class='metaHeader'>Related Accession </span><span ><unit delimiter="<br/>"><l>^ca_object_lots.preferred_labels</l></unit></span></div></ifcount>}}}

			
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
				$t_object = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
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