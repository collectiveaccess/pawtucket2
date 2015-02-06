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
				<div style='height:24px; clear:both;'></div>

			</div>
			<div class='col-sm-6 col-md-6 col-lg-6 archives'>
		
				{{{representationViewer}}}
				
<?php
		print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
?>				
				
			</div><!-- end col -->
			<div class='col-sm-5 col-md-5 col-lg-5'>
			
			<h2>Item Details</h2>

				{{{<ifdef min="1" code="ca_objects.idno"><div class="unit"><span class='metaTitle'>ID: </span><span class='meta'>^ca_objects.idno</span></div></ifdef>}}}				
				{{{<ifcount min="1" code="ca_storage_locations.preferred_labels"><div class='unit'><span class='metaTitle'>Storage Location </span><span class='meta'><unit delimiter="<br/>">^ca_storage_locations.preferred_labels</unit></span></div></ifcount>}}}
			
				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="creator"><div class='unit'><span class='metaTitle'>Creator: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="publisher"><div class='unit'><span class='metaTitle'>Publisher: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="publisher"><l>^ca_entities.preferred_labels.name</l></unit></span></div></ifcount>}}}
				{{{<ifdef code="ca_objects.object_dates.object_date"><div class='unit'><span class='metaTitle'>Date: </span><span class='meta'>^ca_objects.object_dates.object_date</span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.dc_date.dc_dates_value"><div class='unit'><span class='metaTitle'>Date: </span><span class='meta'><unit delimiter='; '>^ca_objects.dc_date.dc_dates_value</unit></span></div></ifcount>}}}				
				{{{<ifdef code="ca_objects.archival_description"><div class='unit'><span class='metaTitle'>Item Description: </span><span class='meta'>^ca_objects.archival_description</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.arch_inscription.arch_inscriptionText"><div class='unit'><span class='metaTitle'>Inscription: </span><span class='meta'>^ca_objects.arch_inscription.arch_inscriptionText <ifdef code="ca_objects.arch_inscription.arch_inscriptionText,ca_objects.arch_inscription.arch_position">-</ifdef> ^ca_objects.arch_inscription.arch_position</span></div></ifdef>}}}

				{{{<ifdef code="ca_objects.moving_description"><div class='unit'><span class='metaTitle'>Description: </span><span class='meta'>^ca_objects.moving_description</span></div></ifdef>}}}
<?php
				if (($t_object->get('ca_objects.format_moving')) && ($t_object->get('ca_objects.format_moving') != 340)) {
					print "<div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>".$t_object->get('ca_objects.format_moving', array('delimiter' => '; ', 'convertCodesToDisplayText' => true))."</span></div>";
				}
				if (($t_object->get('ca_objects.format_image')) && ($t_object->get('ca_objects.format_image') != 973)) {
					print "<div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>".$t_object->get('ca_objects.format_image', array('delimiter' => '; ', 'convertCodesToDisplayText' => true))."</span></div>";
				}
				if (($t_object->get('ca_objects.audio_format')) && ($t_object->get('ca_objects.audio_format') != 1221)) {
					print "<div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>".$t_object->get('ca_objects.audio_format', array('delimiter' => '; ', 'convertCodesToDisplayText' => true))."</span></div>";
				}	
				if (($t_object->get('ca_objects.format_ephemera')) && ($t_object->get('ca_objects.format_ephemera') != 334)) {
					print "<div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>".$t_object->get('ca_objects.format_ephemera', array('delimiter' => '; ', 'convertCodesToDisplayText' => true))."</span></div>";
				}
				if (($t_object->get('ca_objects.format_textual')) && ($t_object->get('ca_objects.format_textual') != 316)) {
					print "<div class='unit'><span class='metaTitle'>Format: </span><span class='meta'>".$t_object->get('ca_objects.format_textual', array('delimiter' => '; ', 'convertCodesToDisplayText' => true))."</span></div>";
				}															
?>				
				{{{<ifdef code="ca_objects.copyright_statement"><div class='unit'><span class='metaTitle'>Copyright Statement: </span><span class='meta'>^ca_objects.copyright_statement</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><div class='unit'><span class='metaTitle'>Language: </span><span class='meta'>^ca_objects.language</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.use_restrictions"><div class='unit'><span class='metaTitle'>Use Restrictions: </span><span class='meta'>^ca_objects.use_restrictions</span></div></ifdef>}}}				
				{{{<ifdef code="ca_objects.access_restrictions"><div class='unit'><span class='metaTitle'>Access Restrictions: </span><span class='meta'>^ca_objects.access_restrictions</span></div></ifdef>}}}				
<?php
				if ($va_collection_hierarchy = $t_object->get('ca_collections.hierarchy.preferred_labels', array('delimiter' => ' > '))) {
					print '<div class="unit"><span class="metaTitle">Parent Collection: </span><span class="meta">';
					$va_collection_id = $t_object->get('ca_collections.collection_id');
					$t_collection = new ca_collections($va_collection_id);
					$vn_parent_ids = $t_collection->getHierarchyAncestors($va_collection_id, array('idsOnly' => true));
					$vn_highest_level = end($vn_parent_ids);
					print caNavLink($this->request, $va_collection_hierarchy, '', 'Detail', 'collections', $vn_highest_level);
					print "</span></div>";
				}

?>				
				{{{<ifcount min="1" relativeTo="ca_occurrences" code="ca_occurrences.preferred_labels"><div class="unit"><span class="metaTitle">Exhibition: </span><span class="meta"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></span></div></ifcount>}}}				
<?php	
				if ($va_rel_entities = $t_object->get('ca_entities', array('template' => '<l>^ca_entities.preferred_labels (^relationship_typename)</l>', 'delimiter' => '<br/>', 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><span class='metaTitle'>Related Entities: </span><span class='meta'>".$va_rel_entities."</span></div>";
				}			 
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
			<div class='col-sm-1 col-md-1 col-lg-1'>
			</div>
		</div><!-- end row -->
	</div><!-- end container -->
<?php
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
?>		<hr>
		<H6>Related Archive Items </H6>
		<div class="archivesBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_archive_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')));
			foreach ($va_archive_ids as $obj_key => $vn_object_id) { 
				$t_archive = new ca_objects($vn_object_id); 
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_archive->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'archives/'.$vn_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_archive->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'archives/'.$vn_object_id)."</p>";
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
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('artwork')))) {
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
			$va_artwork_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('artwork')));
			foreach ($va_artwork_ids as $obj_key => $vn_object_id) {
				$t_artwork = new ca_objects($vn_object_id);
				print "<div class='artworksResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_artwork->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'artworks/'.$vn_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_artwork->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'artworks/'.$vn_object_id)."</p>";
				print "<p class='artist'>".$t_artwork->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";
				print "<p>".$t_artwork->get('ca_objects.object_dates')."</p>";
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