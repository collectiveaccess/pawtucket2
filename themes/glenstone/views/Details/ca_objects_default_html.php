<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$t_set = new ca_sets();
	$va_sets = caExtractValuesByUserLocale($t_set->getSetsForItem("ca_objects", $t_object->get("object_id"), array("user_id" => $this->request->user->get("user_id"))));
	$va_lightbox_crumbs = array();
	foreach($va_sets as $vn_set_id => $va_set){
		$va_lightbox_crumbs[] = caNavLink($this->request, _t("Lightbox"), "", "", "Sets", "Index")." &#8594; ".caNavLink($this->request, $va_set["name"], "", "", "Sets", "SetDetail", array("set_id" => $vn_set_id))." &#8594; ".$t_object->get("ca_objects.preferred_labels.name");
	}
	$vs_lightbox_crumbs = "";
	if(sizeof($va_lightbox_crumbs)){
		$vs_lightbox_crumbs = join("<br/>", $va_lightbox_crumbs);
	}
	
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
<?php
			if($vs_lightbox_crumbs){
?>
			<div class="detailLightboxCrumb"><?php print $vs_lightbox_crumbs; ?></div>
<?php
			}
?>
			<div class="artworkTitle">
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<div style='height:24px; clear:both;'></div>

			</div>
			<div class='col-sm-6 col-md-6 col-lg-6 archives'>
		
				{{{representationViewer}}}
				
<?php
		#print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
		# --- get reps as thumbnails
		$va_reps = $t_object->getRepresentations(array("icon"), null, array("checkAccess" => caGetUserAccessValues($this->request)));
		if(sizeof($va_reps) > 1){		
			$va_links = array();
			$vn_primary_id = "";
			foreach($va_reps as $vn_rep_id => $va_rep){
				$vs_class = "";
				if($va_rep["is_primary"]){
					$vn_primary_id = $vn_rep_id;
				}
				if($vn_rep_id == $pn_rep_id){
					$vs_class = "active";
				}
				$vs_thumb = $va_rep["tags"]["icon"];
				$vs_icon = "";
				if(in_array($va_rep["mimetype"], array("video/mp4", "video/x-flv", "video/mpeg", "audio/x-realaudio", "video/quicktime", "video/x-ms-asf", "video/x-ms-wmv", "application/x-shockwave-flash", "video/x-matroska"))){
					$vs_icon = "<i class='glyphicon glyphicon-film'></i>";
				}
				if(in_array($va_rep["mimetype"], array("audio/mpeg", "audio/x-aiff", "audio/x-wav", "audio/mp4"))){
					$vs_icon = "<i class='glyphicon volume-up'></i>";
				}
				$va_links[$vn_rep_id] = "<a href='#' onclick='$(\".active\").removeClass(\"active\"); $(this).parent().addClass(\"active\"); $(this).addClass(\"active\"); $(\".jcarousel\").jcarousel(\"scroll\", $(\"#slide".$vn_rep_id."\"), false); return false;' ".(($vs_class) ? "class='".$vs_class."'" : "").">".$vs_icon.$vs_thumb."</a>\n";
			}
			# --- make sure the primary rep shows up first
			$va_primary_link = array($vn_primary_id => $va_links[$vn_primary_id]);
			unset($va_links[$vn_primary_id]);
			$va_links = $va_primary_link + $va_links;
			# --- formatting
			$vs_formatted_thumbs = "";
	
			$vs_formatted_thumbs = "<ul id='detailRepresentationThumbnails'>";
			foreach($va_links as $vn_rep_id => $vs_link){
				$vs_formatted_thumbs .= "<li id='detailRepresentationThumbnail".$vn_rep_id."'".(($vn_rep_id == $pn_rep_id) ? " class='active'" : "").">".$vs_link."</li>\n";
			}
			$vs_formatted_thumbs .= "</ul>";
			print "<div class='repIcons'>".$vs_formatted_thumbs."</div>";
		}
?>				
				
			</div><!-- end col -->
			<div class='col-sm-5 col-md-5 col-lg-5'>
			
			<h2>Item Details</h2>

				{{{<ifdef min="1" code="ca_objects.idno"><div class="unit"><span class='metaTitle'>ID: </span><span class='meta'>^ca_objects.idno</span></div></ifdef>}}}				
<?php
	if(is_array($cur_loc = $t_object->getCurrentValue())) {
		print "<div class='unit'><span class='metaTitle'>Storage Location </span><span class='meta'>".strip_tags($cur_loc['display'])."</span></div>";
	}
?>			
				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="creator"><div class='unit'><span class='metaTitle'>Creator: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels</l></unit></span></div></ifcount>}}}
				{{{<ifcount min="1" relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="publisher"><div class='unit'><span class='metaTitle'>Publisher: </span><span class='meta'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="publisher"><l>^ca_entities.preferred_labels</l></unit></span></div></ifcount>}}}
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
				if ($va_rel_entities = $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
					print "<div class='unit'><span class='metaTitle'>Related Entities: </span><span class='meta'>".$va_rel_entities."</span></div>";
				}			 
				if ($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true, 'returnWithStructure' => true))) {
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
<div class="row" style="clear:both;">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
		
		<div id='archivesBlock'>
			<H6>Related Archive Items</H6>
			<div class='blockResults'><div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='archivesResults' class='scrollBlock'>
					<div class='blockResultsScroller'>
<?php
						$va_archive_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'returnWithStructure' => true, 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')));
						foreach ($va_archive_ids as $obj_key => $vn_object_id) { 
							$t_archive = new ca_objects($vn_object_id); 
							$vs_icon = "";
							if($t_archive->get("type_id") == 26){
								# --- moving image
								$vs_icon = "<i class='glyphicon glyphicon-film'></i>";	
							}
							if($t_archive->get("type_id") == 25){
								# --- audio
								$vs_icon = "<i class='glyphicon glyphicon-volume-up'></i>";	
							}
							print "<div class='archivesResult'>";
							$va_rep = $t_archive->getPrimaryRepresentation(array('widepreview'), null, array('return_with_access' => caGetUserAccessValues($this->request)));
							print "<div class='resultImg'>".caNavLink($this->request, $vs_icon.$va_rep['tags']['widepreview'], '', '', 'Detail', 'archives/'.$vn_object_id)."</div>";
							print "<p>".caNavLink($this->request, $t_archive->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'archives/'.$vn_object_id)."</p>";
							print "<p>".$t_archive->get('ca_objects.dc_date.dc_dates_value')."</p>";
							print "</div><!-- archivesResult -->";
						}
?>		
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#archivesResults').hscroll({
					name: 'archives',
					itemCount: <?php print sizeof($va_archive_ids); ?>,
					preloadCount: <?php print sizeof($va_archive_ids); ?>,
					itemWidth: jQuery('.archivesResult').outerWidth(true),
					itemsPerLoad: <?php print sizeof($va_archive_ids); ?>,
					itemLoadURL: '',
					itemContainerSelector: '.blockResultsScroller',
					scrollPreviousControlSelector: '#archivesscrollButtonPrevious',
					scrollNextControlSelector: '#archivesscrollButtonNext',
					scrollControlDisabledOpacity: 0,
					scrollControlEnabledOpacity: .5,						
					cacheKey: ''
				});
			});
		</script>
		
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}
		if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('artwork', 'incoming_artwork_loan')))) {
?>	
<div class="row" style="clear:both;">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
		
		<div id='artworksBlock'>
			<H6>Related Artworks</H6>
			<div class='blockResults'><div id="artworksscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="artworksscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='artworksResults' class='scrollBlock'>
					<div class='blockResultsScroller'>
<?php
					$va_artwork_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnWithStructure' => true, 'returnAsArray' => true, 'restrictToTypes' => array('artwork', 'incoming_artwork_loan')));
					foreach ($va_artwork_ids as $obj_key => $vn_object_id) {
						$t_artwork = new ca_objects($vn_object_id);
						print "<div class='artworksResult'>";
						$va_rep = $t_artwork->getPrimaryRepresentation(array('widepreview'), null, array('return_with_access' => caGetUserAccessValues($this->request)));
						print "<div class='resultImg'>".caNavLink($this->request, $va_rep['tags']['widepreview'], '', '', 'Detail', 'artworks/'.$vn_object_id)."</div>";
						print "<p class='artist'>".$t_artwork->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";						
						print "<p><i>".caNavLink($this->request, $t_artwork->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'artworks/'.$vn_object_id).", ".$t_artwork->get('ca_objects.creation_date')."</i></p>";
						print "</div><!-- artworksResult -->";
					}
?>		
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#artworksResults').hscroll({
					name: 'artworks',
					itemCount: <?php print sizeof($va_artwork_ids); ?>,
					preloadCount: <?php print sizeof($va_artwork_ids); ?>,
					itemWidth: jQuery('.artworksResult').outerWidth(true),
					itemsPerLoad: <?php print sizeof($va_artwork_ids); ?>,
					itemLoadURL: '',
					itemContainerSelector: '.blockResultsScroller',
					scrollPreviousControlSelector: '#artworksscrollButtonPrevious',
					scrollNextControlSelector: '#artworksscrollButtonNext',
					scrollControlDisabledOpacity: 0,
					scrollControlEnabledOpacity: .5,						
					cacheKey: ''
				});
			});
		</script>
		
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}
	
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('book')))) {
?>	
<div class="row" style="clear:both;">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
		
		<div id='libraryBlock'>
			<H6>Related Library Items</H6>
			<div class='blockResults'><div id="libraryscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="libraryscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='libraryResults' class='scrollBlock'>
					<div class='blockResultsScroller'>
<?php
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnWithStructure' => true, 'returnAsArray' => true, 'restrictToTypes' => array('book')));
			
			if (is_array($va_object_ids) && sizeof($va_object_ids)) {
				$qr_res = caMakeSearchResult('ca_objects', $va_object_ids);
				//foreach ($va_object_ids as $obj_key => $vn_object_id) {
				while($qr_res->nextHit()) {
					//$t_library = new ca_objects($vn_object_id);
					print "<div class='libraryResult'>";
					print "<div class='resultImg'>".caNavLink($this->request, $qr_res->get('ca_object_representations.media.library'), '', '', 'Detail', 'library/'.$qr_res->get('ca_objects.object_id'))."</div>";
					print "<p>".caNavLink($this->request, $qr_res->get('ca_objects.preferred_labels'), '', '', 'Detail', 'library/'.$qr_res->get('ca_objects.object_id'))."</p>";				
					print "<p>".caNavLink($this->request, $qr_res->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('author'))), '', '', 'Detail', 'library/'.$qr_res->get('ca_objects.object_id'))."</p>";
					print "<p>".$qr_res->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('publisher')))."</p>";
					print "</div><!-- libraryResult -->";
				}
			}
?>	
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#libraryResults').hscroll({
					name: 'library',
					itemCount: <?php print sizeof($va_object_ids); ?>,
					preloadCount: <?php print sizeof($va_object_ids); ?>,
					itemWidth: jQuery('.libraryResult').outerWidth(true),
					itemsPerLoad: <?php print sizeof($va_object_ids); ?>,
					itemLoadURL: '',
					itemContainerSelector: '.blockResultsScroller',
					scrollPreviousControlSelector: '#libraryscrollButtonPrevious',
					scrollNextControlSelector: '#libraryscrollButtonNext',
					scrollControlDisabledOpacity: 0,
					scrollControlEnabledOpacity: .5,						
					cacheKey: ''
				});
			});
		</script>
		
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
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