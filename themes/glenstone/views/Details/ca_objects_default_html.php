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
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H5>{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator">^ca_entities.preferred_labels.name</unit>}}}</H5>

			</div>
			<div class='col-sm-6 col-md-6 col-lg-6'>
		
				{{{representationViewer}}}
				
<?php
		print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
?>				
				
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
			
			<h2>Availability</h2>

				{{{<ifdef min="1" code="ca_objects.idno"><div class="unit"><span class='metaTitle'>ID: </span><span class='meta'>^ca_objects.idno</span></div></ifdef>}}}				
				{{{<ifcount min="1" code="ca_storage_locations.preferred_labels"><div class='unit'><span class='metaTitle'>Storage Location </span><span class='meta'><unit delimiter="<br/>"><l>^ca_storage_locations.preferred_labels</l></unit></span></div></ifcount>}}}

			<h2>More Information</h2>
			
				{{{<ifdef code="ca_objects.caption_annotation"><div class='unit'><span class='metaTitle'>Caption/ Annotation: </span><span class='meta'>^ca_objects.caption_annotation</span></div></ifdef>}}}
				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="creator"><div class='unit'><span class='metaTitle'>Creator: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="publisher"><div class='unit'><span class='metaTitle'>Publisher: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="publisher"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.object_dates.object_date"><div class='unit'><span class='metaTitle'>Date: </span><span class='meta'>^ca_objects.object_dates.object_date</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.dc_date.dc_dates_value"><div class='unit'><span class='metaTitle'>Date: </span><span class='meta'>^ca_objects.dc_date.dc_dates_value</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.moving_description"><div class='unit'><span class='metaTitle'>Description: </span><span class='meta'>^ca_objects.moving_description</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.format_moving"><div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>^ca_objects.format_moving</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.audio_format"><div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>^ca_objects.audio_format</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.format_ephemera"><div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>^ca_objects.format_ephemera</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.format_textual"><div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>^ca_objects.format_textual</span></div></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.language"><div class='unit'><span class='metaTitle'>Language: </span><span class='meta'>^ca_objects.language</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.use_restrictions"><div class='unit'><span class='metaTitle'>Use Restrictions: </span><span class='meta'>^ca_objects.use_restrictions</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.access_restrictions"><div class='unit'><span class='metaTitle'>Access Rights: </span><span class='meta'>^ca_objects.access_restrictions</span></div></ifdef>}}}				
				{{{<ifcount min="1" relativeTo="ca_collections" code="ca_collections.preferred_labels"><div class="unit"><span class="metaTitle">Parent Collection: </span><span class="meta"><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit></span></div></ifcount>}}}				
				{{{<ifcount min="1" relativeTo="ca_occurrences" code="ca_occurrences.preferred_labels"><div class="unit"><span class="metaTitle">Exhibition: </span><span class="meta"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></span></div></ifcount>}}}				
				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels"><div class='unit'><span class='metaTitle'>Related Entities: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
<?php				
				if ($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
					print "<div class='unit '><span class='metaTitle'>Library of Congress Subject Headings</span><span class='meta'>";
					foreach ($va_lcsh_terms as $k_lchs => $va_lcsh_term) {
						$va_lcsh = explode("[", $va_lcsh_term['lcsh_terms']);
						print caNavLink($this->request, $va_lcsh[0]."<br/>", '', '', 'MultiSearch', 'Index', array('search' => 'ca_objects.lcsh_terms:'.$va_lcsh[0]));
					}
					print "</span></div>"; 
				}				
?>							
			
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
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.archiveResults').hscroll({
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
		<div class="artworksBlock">
			<div class="blockResults">
				<div id="artworksscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="artworksscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="artworkResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('artwork')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_object = new ca_objects($va_object_id);
				print "<div class='artworksResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
				print "<p class='artist'>".$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";
				print "<p>".$t_object->get('ca_objects.object_dates')."</p>";
				print "</div><!-- artworksResult -->";
			}
			if (!$this->request->isAjax()) {		
?>	
					</div> <!-- blockResultsScroller -->
				</div> <!-- artworksResults -->
			</div> <!-- blockResults -->
		</div> <!-- artworksBlock -->
<?php
			}	
?>	
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.artworkResults').hscroll({
			name: 'artworks',
			itemWidth: jQuery('.artworksResult').outerWidth(true),
			itemsPerLoad: 10,
			itemContainerSelector: '.blockResultsScroller',
			scrollPreviousControlSelector: '#artworksscrollButtonPrevious',
			scrollNextControlSelector: '#artworksscrollButtonNext',
			scrollControlDisabledOpacity: 0,
			cacheKey: '{{{cacheKey}}}'
		});
	});
</script>
<?php
	}	
?>



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 65
		});
	});
</script>