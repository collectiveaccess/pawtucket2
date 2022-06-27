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
	}?>
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
<?php
				if ($t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author')))) {
					print '<h5>'.$t_object->getWithTemplate('<ifcount code="ca_entities" restrictToRelationshipTypes="author"><unit delimiter="; " relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname</unit></ifcount>').'</h5>';
				} else {
					print '<h5>'.$t_object->getWithTemplate('<ifcount code="ca_entities" restrictToRelationshipTypes="publisher"><unit delimiter="; " relativeTo="ca_entities" restrictToRelationshipTypes="publisher">^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname</unit></ifcount>').'</h5>';
				}
?>				
			</div>
			<div class='col-sm-4 col-md-4 col-lg-4'>
			
<?php
		print $t_object->get('ca_object_representations.media.medium', ['scaleCSSWidthTo' => '320px', 'scaleCSSHeightTo' => '320px']).'<br/>';

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
	
			if ($va_ISBN_link = $t_object->get('ca_objects.ISBN', array('returnAsArray' => true, 'returnWithStructure' => true))) {
				foreach ($va_ISBN_link as $va_isbn_no) {
					if(strlen($va_isbn_no['ISBN']) != 13) {
						$va_isbn_mail = $va_isbn_no['ISBN'];
					}
				}
			}		
			$va_book_title = explode(" ", $t_object->get('ca_objects.preferred_labels'));
			$va_book_authors = $t_object->getWithTemplate('<unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.surname</unit>', ['returnAsArray' => true]);
			
			$va_pub_info = explode(" ", $t_object->get('ca_objects.publication_description'));
			$va_book_title = join('%20',$va_book_title)."%0A".join('%20',$va_book_authors).($va_pub_info ? "%0A".join('%20',$va_pub_info) : "").($va_isbn_mail ? "%0AISBN:%20".$va_isbn_mail : ""); 
?>				
			<div class='requestButton'><a href='mailto:carly.davis@glenstone.org?Subject=Library%20Request&body=Hello,%0A%0APlease%20put%20a%20copy%20of%20the%20following%20item%20on%20hold%20for%20me:%0A%0A<?php print $va_book_title; ?>%0A%0AThank%20you%0A%0A%0A'>Request this item  &nbsp;<i class='fa fa-envelope'></i></a></div>			
			
			</div><!-- end col -->
			<div class='col-sm-7 col-md-7 col-lg-7'>


				<!-- library-->
				
				{{{<ifdef code="ca_objects.preferred_labels"><div class='unit'><span >^ca_objects.preferred_labels</span></div></ifdef>}}}				
<?php
				if ($vs_author = $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter="; " restrictToRelationshipTypes="author"><l>^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname</l></unit>', [])) { 
					print "<div class='unit'><span >{$vs_author}</span></div>";
				} else {
					print "<div class='unit'><span >".$t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter="; " restrictToRelationshipTypes="publisher"><l>^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname</l></unit>', [])."</span></div>";
				}
?>
				{{{<ifdef code="ca_objects.publication_description"><div class='unit'><span>^ca_objects.publication_description</span></div></ifdef>}}}
<?php
				$va_copies = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'returnWithStructure' => true));
?>
				<h2>Availability</h2>
				
				<?php print "<span class='copies'>".sizeof($va_copies)." copies </span>"; ?>
				<!--<a href='#' class='availability' onclick='$("#availability").slideDown();$(".availability").hide();$(".hideAvailability").fadeIn();return false;'>click to view</a>
				<a href='#' class='hideAvailability' style='display:none;' onclick='$("#availability").slideUp();$(".hideAvailability").hide();$(".availability").fadeIn();return false;'>click to hide</a>	-->			
<?php
				if (sizeof($va_copies)) {
					print "<div id='availability' >";
					foreach ($va_copies as $vn_id => $va_copy) {
						$t_copy = new ca_objects($va_copy);
						print "<div class='unit'><span class='metaTitle'>Item </span><span class='meta'>".$t_copy->get('ca_objects.copy_name')."</span></div>";
						if ($va_call_number = $t_copy->get('ca_objects.call_number')) {
							print "<div class='unit'><span class='metaTitle'>Call Number </span><span class='meta'>".$va_call_number."</span></div>";
						}
						if ($va_copy_location = $t_copy->get('ca_storage_locations.hierarchy.preferred_labels', array('delimiter' => ' > '))) {
							print "<div class='unit'><span class='metaTitle'>Location </span><span class='meta'>".caNavLink($this->request, substr($va_copy_location, 4), '', '', 'Browse', 'copy/facet/current_location/id/'.$t_copy->get('ca_storage_locations.location_id'))."</span></div>";
						}
						//if ($va_status = $t_copy->get('ca_objects.purchase_status', array('convertCodesToDisplayText' => true))) {
						if ($va_status = $t_copy->getCheckoutStatus(['returnAsText' => true])) {
							print "<div class='unit'><span class='metaTitle'>Status </span><span class='meta'>".$va_status."</span></div>";
						}						
						print "<hr>";														
					}
					print "</div>";
				}
			if ($va_documents = $t_object->representationsOfClass('document', array('original'))){
				foreach ($va_documents as $doc_id => $va_document) {
					print "<div class='bookLink'><a href='".$va_document['urls']['original']."' class='downloadButton' target='_blank'>Download Ebook</a></div>";
				}
			}				
?>				


				<h2>More Information</h2>
				{{{<ifdef code="ca_objects.library_formats"><div class='unit'><span class='metaTitle'>Format </span><span class="meta">^ca_objects.library_formats%useSingular=1 </span></div></ifdef>}}}
				{{{<ifcount min="1" code="ca_objects.nonpreferred_labels"><div class='unit '><span class='metaTitle'>Variant Title </span><span class='meta'><unit delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></span></div></ifcount>}}}
				{{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" restrictToRelationshipTypes="publisher" min="1" ><div class='unit '><span class='metaTitle'>Publisher </span><span class='meta'><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></span></div></ifcount>}}}

<?php
				if ($va_ISBN = $t_object->get('ca_objects.ISBN', array('returnAsArray' => true))) {
					$vs_isbn = "";
					foreach ($va_ISBN as $va_isbn_no) {
						if(strlen($va_isbn_no) != 13) {
							$vs_isbn.= $va_isbn_no;
						}
					}
					if ($vs_isbn != "") {
						print "<div class='unit '><span class='metaTitle'>ISBN </span><span class='meta'>";	
						print $vs_isbn;
						print "</span></div>";
					}
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
#				if ($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true, 'returnWithStructure' => true))) {
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
	$va_archives = $t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'returnWithStructure' => true, 'returnAsArray' => true, 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')));
	if (sizeof($va_archives) > 0) {
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
			$va_archive_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnWithStructure' => true, 'returnAsArray' => true, 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')));
			foreach ($va_archive_ids as $obj_key => $va_object_id) {
				$t_archive = new ca_objects($va_object_id);
				$vs_icon = "";
				if($t_archive->get("ca_objects.type_id") == 26){
					# --- moving image
					$vs_icon = "<i class='glyphicon glyphicon-film'></i>";	
				}
				if($t_archive->get("ca_objects.type_id") == 25){
					# --- audio
					$vs_icon = "<i class='glyphicon glyphicon-volume-up'></i>";	
				}
				print "<div class='archivesResult'>";
				$va_rep = $t_archive->getPrimaryRepresentation(array('widepreview'), null, array('return_with_access' => caGetUserAccessValues($this->request)));
				print "<div class='resultImg'>".caNavLink($this->request, $vs_icon.$va_rep['tags']['widepreview'], '', '', 'Detail', 'archives/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_archive->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'archives/'.$va_object_id)."</p>";
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
			foreach ($va_artwork_ids as $obj_key => $va_object_id) {
				$t_artwork = new ca_objects($va_object_id);
				print "<div class='artworksResult'>";
				$va_rep = $t_artwork->getPrimaryRepresentation(array('widepreview'), null, array('return_with_access' => caGetUserAccessValues($this->request)));
				print "<div class='resultImg'>".caNavLink($this->request, $va_rep['tags']['widepreview'], '', '', 'Detail', 'artworks/'.$va_object_id)."</div>";
				print "<p class='artist'>".$t_artwork->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";				
				print "<p>".caNavLink($this->request, "<i>".$t_artwork->get('ca_objects.preferred_labels.name')."</i>", '', '', 'Detail', 'artworks/'.$va_object_id).", ".$t_artwork->get('ca_objects.creation_date_display')."</p>";
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