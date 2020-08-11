<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");

	$item_rep_id = $this->getVar("representation_id");
	$item_obj_id = $t_object->get('ca_objects.object_id');
	$item_format = $t_object->get('ca_objects.format_text');
	$show_pdf_dl_link = ($item_format === 'PDF') ? TRUE : FALSE;
	$t_rep = new ca_object_representations($item_rep_id);
	$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
	$vs_download_version = $va_download_display_info['display_version'];
	$pdf_dl_link = caNavLink($this->request, "Download <span class='glyphicon glyphicon-download-alt'></span>", 'dlButton', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $item_rep_id, "object_id" => $item_obj_id, "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));

?>
<!-- start views\Details\ca_objects_default_html -->
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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
				<?php if ($show_pdf_dl_link) { ?>
					<div style="background:yellow;">
					<p>Tip: <?php print $pdf_dl_link; ?> this file and open it in a <a href="https://get.adobe.com/reader/">PDF reader</a> to search and highlight specific words within the text, or for greater zoom function.</p>
					</div>
				<?php } ?>

				<div id="detailTools">
					<!-- hide comments <div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div> --><!-- end detailTool -->
					<!-- hide comments <div id='detailComments'>{{{itemComments}}}</div> --><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}</H4>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno">
					<h6 class="metadata-label">Identifier:</h6>
					^ca_objects.idno<br/>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.containerID">
					<h6 class="metadata-label">Box/series:</h6>
					^ca_objects.containerID<br/>
				</ifdef>}}}				
				
				{{{<ifdef code="ca_objects.description">
					<h6 class="metadata-label">Description:</h6>
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.creator">
					<h6 class="metadata-label">Creator:</h6><span class="trimText">^ca_objects.creator</span>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.date">
					<h6 class="metadata-label">Date:</h6><span class="trimText">^ca_objects.date</span>
				</ifdef>}}}
				
				{{{<ifcount code="ca_objects.format_text" min="1"><h6 class="metadata-label">Format:</h6></ifcount>}}}
				{{{<unit delimiter="; ">^ca_objects.format_text</unit>}}}
 
				{{{<ifcount code="ca_objects.subject" min="1" max="1"><h6 class="metadata-label">Subject:</h6></ifcount>}}}
				{{{<ifcount code="ca_objects.subject" min="2"><h6 class="metadata-label">Subjects:</h6></ifcount>}}}
				{{{<unit delimiter="; ">^ca_objects.subject</unit>}}}

				{{{<ifdef code="ca_objects.lcsh_terms">
					<h6 class="metadata-label">Library of Congress Subject Headings:</h6><span class="trimText">^ca_objects.lcsh_terms%asText=1&delimiter=;_</span>
				</ifdef>}}}

				{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
                {{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}

				{{{<ifdef code="ca_objects.rights">
					<h6 class="metadata-label">Rights:</h6><span class="trimText">^ca_objects.rights</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.source">
					<h6 class="metadata-label">Source:</h6><span class="trimText">^ca_objects.source</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.spatial_coverage">
					<h6 class="metadata-label">Location:</h6><span class="trimText">^ca_objects.spatial_coverage%delimiter=;_</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.temporal_coverage">
					<h6 class="metadata-label">Temporal Coverage:</h6><span class="trimText">^ca_objects.temporal_coverage</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.dc_type">
					<h6 class="metadata-label">Type:</h6><span class="trimText">^ca_objects.dc_type</span>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.publisher">
					<h6 class="metadata-label">Publisher:</h6><span class="trimText">^ca_objects.publisher%delimiter=;_</span>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
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
		$( ".truncate" ).click(function() {
			$( this ).toggleClass( "expanded" );
		});
	});
</script>
<!-- end views\Details\ca_objects_default_html -->

<?php 
	// $va_entities = $t_object->get("ca_entities", array("returnAsArray" => true));
	// http://lib-digarct-s1/index.php/Detail/objects/858
?>