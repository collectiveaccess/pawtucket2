<?php
	$t_object = $this->getVar("item");
	$vn_object_id = $t_object->get('ca_objects.object_id');
	$va_comments = $this->getVar("comments");
	$pn_rep_id = $this->getVar("representation_id");
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
			
				{{{representationViewer}}}
<?php
		print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => true))."</div>";
?>	
			
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
			
				<div class='tabdiv'>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#artworkInfo').fadeIn(100);">Tombstone</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#factSheet').fadeIn(100);">Fact Sheet</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Location').fadeIn(100);">Location</a></div> 
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Financial').fadeIn(100);">Financials</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Condition').fadeIn(100);">Condition</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Description').fadeIn(100);">Description</a></div>
				</div>
				
					<hr>
				
				<div id="artworkInfo" class="infoBlock">
					{{{<div class='unit'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist|creator"><l>^ca_entities.preferred_labels.name</l></unit></div>}}}
					<div class='unit'><i>{{{ca_objects.preferred_labels.name}}}</i>, &nbsp;{{{ca_objects.creation_date}}}</div>
					{{{<ifdef code="ca_objects.medium"><div class='unit'>^ca_objects.medium</div></ifdef>}}}
					{{{<ifcount min="1" code="ca_objects.dimensions.display_dimensions"><div class='unit'><unit delimiter="<br/>">^ca_objects.dimensions.display_dimensions ^ca_objects.dimensions.Type</unit></div></ifcount>}}}
					{{{<ifdef code="ca_objects.edition.edition_number"><div class='unit'>Edition <ifdef code="ca_objects.edition.edition_number">^ca_objects.edition.edition_number / ^ca_objects.edition.edition_total </ifdef><ifdef code="ca_objects.edition.ap_number"><br/>^ca_objects.edition.ap_number / ^ca_objects.edition.other_info  AP</ifdef></div></ifdef>}}}
<?php
					if ($t_object->get('ca_objects.signed.signed_yn') == "No") {
						print "Signed, ".$t_object->get('ca_objects.signed.signature_details');
					}
?>					
					
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
						if ($va_source = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('source', 'advisor'), 'returnAsLink' => true))) {
							print "<div class='unit'><span class='metaTitle'>Source: </span><span class='meta'>".$va_source."</span></div>";
						}	
						if ($va_purchase = $t_object->get('ca_objects.purchase_date')) {
							print "<div class='unit'><span class='metaTitle'>Purchase Date: </span><span class='meta'>".$va_purchase."</span></div>";
						}										
						if ($va_cost = $t_object->get('ca_objects.object_cost')) {
							print "<div class='unit'><span class='metaTitle'>Cost: </span><span class='meta'>".$va_cost."</span></div>";
						}
						if ($t_object->get('ca_objects.gift_yn') == "Yes") {
							print "<div class='unit'><span class='metaTitle'>Gift: </span><span class='meta'>Yes</span></div>";
						}
						if ($va_market = $t_object->get('ca_objects.object_retail')) {
							print "<div class='unit'><span class='metaTitle'>Market Value: </span><span class='meta'>".$va_market."</span></div>";
						}
						if ($va_appraisal = $t_object->get('ca_objects.appraisal', array('delimiter' => '<hr>', 'template' => '<b>Value: </b>^appraisal_value <br/><b>Date:</b> ^appraisal_date <br/><b>Appraiser:</b> ^appraiser <br/><b>Notes:</b> ^appraisal_notes'))) {
							print "<div class='unit'><span class='metaTitle'>Appraisal: </span><span class='meta'>".$va_appraisal."</span></div>";
						}
						if ($va_payment = $t_object->get('ca_objects.payment_details', array('delimiter' => '<hr>', 'template' => '<b>Payment Amount: </b>^payment_amount <br/><b>Payment Date:</b> ^payment_date <br/><b>Payment Quarter:</b> ^payment_quarter <br/><b>Installment:</b> ^installment<br/><b>Notes:</b> ^payment_notes'))) {
							print "<div class='unit'><span class='metaTitle'>Payment Details: </span><span class='meta'>".$va_payment."</span></div>";
						}
						if ($va_object_lots = $t_object->get('ca_object_lots.preferred_labels', array('returnAsLink' => true))) {
							print "<div class='unit'><span class='metaTitle'>Related Accession</span><span class='meta'>".$va_object_lots."</span></div>";
						}
						
?>
<?php																		
					} else { 
						print "access restricted";
					}
?>
				</div>
				<div id="Condition" class="infoBlock">
					{{{<ifcount min="1" code="ca_objects.general_condition"><div class="unit wide"><span class='metaHeader'>General Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.general_condition.general_condition_value</u> (^ca_objects.general_condition.general_condition_date) Assessed by: ^ca_objects.general_condition.general_condition_person - ^ca_objects.general_condition.general_condition_specific</unit></span></div></ifcount>}}}																				
					{{{<ifcount min="1" code="ca_objects.frame_condition"><div class="unit wide"><span class='metaHeader'>Frame Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.frame_condition.frame_date</u> ^ca_objects.frame_condition.frame_value - ^ca_objects.frame_condition.frame_notes</unit></span></div></ifcount>}}}																
					{{{<ifcount min="1" code="ca_objects.glazing_condition.glazing_date|ca_objects.glazing_condition.glazing_notes"><div class="unit wide"><span class='metaHeader'>Glazing Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.glazing_condition.glazing_date</u> ^ca_objects.glazing_condition.glazing_value - ^ca_objects.glazing_condition.glazing_notes</unit></span></div></ifcount>}}}												
					{{{<ifcount min="1" code="ca_objects.support_condition"><div class="unit wide"><span class='metaHeader'>Support Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.support_condition.support_date</u> ^ca_objects.support_condition.support_value - ^ca_objects.support_condition.support_notes</unit></span></div></ifcount>}}}								
					{{{<ifcount min="1" code="ca_objects.vitrine_condition"><div class="unit wide"><span class='metaHeader'>Vitrine Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.vitrine_condition.vitrine_date</u> ^ca_objects.vitrine_condition.vitrine_value - ^ca_objects.vitrine_condition.vitrine_notes</unit></span></div></ifcount>}}}				
					{{{<ifcount min="1" code="ca_objects.mount_condition"><div class="unit wide"><span class='metaHeader'>Mount Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.mount_condition.mount_date</u> ^ca_objects.mount_condition.mount_value - ^ca_objects.mount_condition.mount_notes</unit></span></div></ifcount>}}}				
					{{{<ifcount min="1" code="ca_objects.surface_condition"><div class="unit wide"><span class='metaHeader'>Surface Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.surface_condition.surface_date</u> ^ca_objects.surface_condition.surface_value - ^ca_objects.surface_condition.surface_notes</unit></span></div></ifcount>}}}
					{{{<ifcount min="1" code="ca_objects.base_condition"><div class="unit wide"><span class='metaHeader'>Base Condition </span><span><unit delimiter="<br/>"><u>^ca_objects.base_condition.base_date</u> ^ca_objects.base_condition.base_value - ^ca_objects.base_condition.base_notes</unit></span></div></ifcount>}}}
<?php
					if ($t_object->get('ca_objects.condition_images.condition_images_media')){
						$va_condition_images = $t_object->get('ca_objects.condition_images', array('returnAsArray' => true)); 
						print '<div class="unit wide"><span class="metaHeader">Condition Images</span><span>';
						foreach ($va_condition_images as $va_condition_id => $va_condition_image) {
							if ($va_condition_image['condition_images_primary'] == "No") {
								print "<a href='#' onclick='caMediaPanel.showPanel(\"/discovery/index.php/Detail/GetRepresentationInfo/object_id/".$vn_object_id."/attribute_id/".$va_condition_id."\"); return false;'>".$va_condition_image['condition_images_media']."</a>";
							}
						}
						print "</span></div>";
					}
?>				
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