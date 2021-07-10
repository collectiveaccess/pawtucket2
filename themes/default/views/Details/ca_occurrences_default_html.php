<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
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
		<div class="container">
			<div class="row">
				<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>

					{{{<H3>^ca_occurrences.preferred_labels.name<ifdef code="ca_occurrences.label_eng"><br /><small>[^ca_occurrences.label_eng]</small></ifdef></H3>}}}

					{{{<ifdef code="ca_occurrences.visible"><p>^ca_occurrences.type_id</p></ifdef>}}}

					{{{<ifdef code="ca_occurrences.visible"><p>^ca_occurrences.year</p></ifdef>}}}

					{{{<ifdef code="ca_occurrences.bibliography_detail"><p><unit delimiter=", ">^ca_occurrences.language</unit></p><p><unit delimiter="<br />">^ca_occurrences.bibliography_detail</unit></p></ifdef>}}}
<!-- ca_occurrences.description -->
					{{{<ifdef code="ca_occurrences.description"><p><unit delimiter="<br />">^ca_occurrences.description</unit></p></ifdef>}}}

					{{{<ifcount code="ca_occurrences.author" min="1"><p><unit delimiter=", "><ifdef code="ca_occurrences.author">^ca_occurrences.author, </ifdef><unit/></p></ifcount>}}}

					{{{<ifcount code="ca_entities" min="1"><p><unit relativeTo="ca_entities" restrictToTypes="exhibition_solo, exhibition_group" delimiter="; ">^ca_entities.preferred_labels.displayname, <unit relativeTo="ca_places">^ca_places.preferred_labels</unit></unit></p></ifcount>}}}

					{{{<unit delimiter="<br />"<ifdef code="ca_occurrences.exhibition_detail"><p>^ca_occurrences.exhibition_detail</p></ifdef></unit>}}}

					{{{<ifdef code="ca_occurrences.text_content"><h6>&nbsp;</h6><p>^ca_occurrences.text_content</p></ifdef>}}}
<!-- Bibliigrafie - wenn ein Text mit dem Bibliografie Eintrag verknüpt ist erscheint der Text-->
						{{{<unit relativeTo="ca_occurrences_x_occurrences" restrictToTypes="text" restrictToRelationshipTypes="text"><h6>&nbsp;</h6><h6>&nbsp;</h6><H5>^ca_occurrences.preferred_labels.name</H5></unit>}}}

						{{{<unit relativeTo="ca_occurrences_x_occurrences" restrictToTypes="text" restrictToRelationshipTypes="text"><ifdef code='ca_occurrences.author'><p>Text: ^ca_occurrences.author, ^ca_occurrences.year</p></ifdef></unit>}}}

						{{{<unit relativeTo="ca_occurrences_x_occurrences" restrictToTypes="text" restrictToRelationshipTypes="text"><h6>&nbsp;</h6>^ca_occurrences.text_content</unit>}}}

					{{{<h6>&nbsp;</h6>}}}
<hr></hr>
<!-- Verbundene Werkgruppen	 -->
					{{{<ifcount code="ca_collections" min="1" excludeRelationshipTypes="vita"><h6>Related Series of Works</h6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" excludeRelationshipTypes="vita" sort="ca_collections.idno" sortDirection="ASC" delimiter=" "><p><l>^ca_collections.preferred_labels.name<unit delimiter=", "> (^ca_collections.year)</unit></l></p></unit>}}}
<!-- Einzelausstellungen -->
					{{{<ifcount code="ca_occurrences.related" min="1" max="1" restrictToTypes="exhibition_solo"><H6>Related solo show</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2" restrictToTypes="exhibition_solo"><H6>Related solo shows</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences_x_occurrences" restrictToTypes="exhibition_solo" sort="ca_occurrences.idno" sortDirection="DESC" delimiter=" "><unit relativeTo="ca_occurrences"><p><l>^ca_occurrences.displaye_exhibition</l></p></unit></unit>}}}
<!-- Gruppenausstellungen -->
					{{{<ifcount code="ca_occurrences.related" min="1" max="1" restrictToTypes="exhibition_group"><H6>Related group show</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2" restrictToTypes="exhibition_group"><H6>Related group shows</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences_x_occurrences" restrictToTypes="exhibition_group" sort="ca_occurrences.idno" sortDirection="DESC" delimiter=" "><unit relativeTo="ca_occurrences"><p><l>^ca_occurrences.displaye_exhibition</l></p></unit></unit>}}}
<!-- Zugehörige Literaturhinweise -->
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="article, leaflet, anthology, book, cat, dvd, self, web, periodical" min="1" max="1"><H6>Related bibliography</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="article, leaflet, anthology, book, cat, dvd, self, web, periodical" min="2"><H6>Related bibliography</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences_x_occurrences" restrictToTypes="article, leaflet, anthology, book, cat, dvd, self, web, periodical" sort="ca_occurrences.idno" sortDirection="DESC" delimiter=" "><unit relativeTo="ca_occurrences.displayed_bibliographies"><p><l>^ca_occurrences.displayed_bibliographies</l></p></unit></unit>}}}

				</div><!-- end col -->

				<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>

					{{{representationViewer}}}
					<div id="detailAnnotations"></div>
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>

				</div><!-- end col -->
			</div><!-- end row -->

			<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'></div><!-- end col -->

			<div class="row">
					<div class='col-md-12'>
						{{{<ifcount code="ca_objects_x_occurrences" min="1" max="1"><ifdef code="ca_occurrences.displaye_exhibition"><h6>Exhibited Artwork (^ca_objects._count)</h6></ifdef><ifdef code="ca_occurrences.displayed_bibliographies"><h6>Pictured Artwork (^ca_objects._count)</h6></ifdef></ifcount>}}}
						{{{<ifcount code="ca_objects_x_occurrences" min="2"><ifdef code="ca_occurrences.displaye_exhibition"><h6>Exhibited Artworks (^ca_objects._count)</h6></ifdef><ifdef code="ca_occurrences.displayed_bibliographies"><h6>Pictured Artworks (^ca_objects._count)</h6></ifdef></ifcount>}}}						
					</div>
				</div><!-- end row -->

			{{{<ifcount code="ca_objects" min="1">
				<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
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
	});
</script>
