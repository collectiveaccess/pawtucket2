<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>


<div class="row" style="margin-bottom: 20px">

	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->

	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->

	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10' style="padding: 0px">
		<div class="container">

			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
				</div><!-- end col -->
			</div><!-- end row -->
			
			<div class="row">
				
				<div class='col-sm-6 col-md-6 col-lg-6'>
					
					{{{<ifdef code="ca_occurrences.idno"><label>Identifier</label>^ca_occurrences.idno<br/></ifdef>}}}
					
					<?php
						if($links = caGetSearchLinks($t_item, 'ca_collections', ['template' => '<l>^ca_collections.preferred_labels.name</l>', 'linkTemplate' => '<li>^LINK</li>'])) {
					?>
							{{{<ifcount code="ca_collections.related" min="1">
								<label>Related collection<ifcount code="ca_collections.related" min="2">s</ifcount></label>
							</ifcount>}}}
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
					?>

					<?php
						if($links = caGetSearchLinks($t_item, 'ca_occurrences.genre_terms', ['linkTemplate' => '<li>^LINK</li>'])) {
					?>
							<label>Genre(s)</label>
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
						if($links = caGetBrowseLinks($t_item, 'ca_list_items', ['linkTemplate' => '<li>^LINK</li>'])) {
					?>
							<label>Subject(s)</label>
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
					?>
					
					{{{<ifdef code="ca_occurrences.georeference">
						<label>Places</label>
						<div class="unit"></div>
					</ifdef>}}}
					{{{map}}}
					
					{{{<ifdef code="ca_occurrences.RightsSummaryNHF.NHFRightsSummaryPub"><label>Rights</label>^ca_occurrences.RightsSummaryNHF.NHFRightsSummaryPub<br/></ifdef>}}}
					
				</div><!-- end col -->
				
				<div class='col-md-6 col-lg-6'>
					
					{{{<ifdef code="ca_occurrences.occ_date"><label>Date</label>^ca_occurrences.occ_date<br/></ifdef>}}}
					
					{{{<unit relativeTo="ca_occurrences.pbcoreDescription" delimiter=""><ifdef code="ca_occurrences.pbcoreDescription.description_text"><label>^ca_occurrences.pbcoreDescription.descriptionType</label>^ca_occurrences.pbcoreDescription.description_text<br/></ifdef></unit>}}}
					
					<?php
						if($links = caGetSearchLinks($t_item, 'ca_entities', ['template' => '<l>^ca_entities.preferred_labels.displayname</l>', 'linkTemplate' => '<li>^LINK</li>'])) {
					?>
							{{{<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>}}}
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
					?>

					<?php
						if($links = caGetSearchLinks($t_item, 'ca_occurrences.related', ['template' => '<l>^ca_occurrences.related.preferred_labels.name</l>', 'linkTemplate' => '<li>^LINK</li>'])) {
					?>
							{{{<ifcount code="ca_occurrences.related" min="1" max="1"><label>Related occurrence</label></ifcount>}}}
							{{{<ifcount code="ca_occurrences.related" min="2"><label>Related occurrences</label></ifcount>}}}
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
					?>

					<?php
						if($links = caGetBrowseLinks($t_item, 'ca_places', ['template' => '<l>^ca_places.preferred_labels.name</l>', 'linkTemplate' => '<li>^LINK</li>'])) {
					?>
							{{{<ifcount code="ca_places" min="1">
								<label>Related place<ifcount code="ca_places" min="2">s</ifcount></label>
							</ifcount>}}}
	
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
					?>
					
				</div><!-- end col -->

			</div><!-- end row -->
			
			{{{<ifcount code="ca_objects" min="1">

				<H2 style="margin: 35px 0px 20px 0px">Copies</H2>

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

			</ifcount>}}}		

		</div><!-- end container -->
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
					
<!-- <H2>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H2> -->

<!-- {{{<ifcount code="ca_collections" min="1" max="1"><label>Related collection</label></ifcount>}}}
{{{<ifcount code="ca_collections" min="2"><label>Related collections</label></ifcount>}}}
{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}} -->

<!-- {{{<ifdef code="ca_occurrences.description"><label>About</label>^ca_occurrences.description<br/></ifdef>}}} -->

<!-- {{{<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}} -->

<!-- {{{<ifcount code="ca_occurrences.related" min="1" max="1"><label>Related occurrence</label></ifcount>}}}
{{{<ifcount code="ca_occurrences.related" min="2"><label>Related occurrences</label></ifcount>}}}
{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}} -->

<!-- {{{<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>}}}
{{{<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>}}}
{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}} -->

<!-- {{{<ifdef code="ca_occurrences.genre_terms">
	<div class="unit">
		<label>Genre(s)</label>
		<ul>
			<unit relativeTo="ca_list_items">
				<li> 
					<l>^ca_collections.genre_terms</l>
				</li>
			</unit>
		</ul>

		<?php
			$genres = $t_item->get("ca_occurrences.genre_terms", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
			print "<ul>";
			foreach($genres as $g){print "<li>$g</li>";}
			print "</ul>";
		?>
	</div>
</ifdef>}}} -->

<!-- {{{<ifdef code="ca_list_items">
	<div class="unit">
		<label>Subjects</label>

		<ul>
		<unit relativeTo="ca_list_items">
				<li><a href="/collection/index.php/Browse/collections/facet/term_facet/id/^ca_list_items.item_id">^ca_list_items.preferred_labels</a></li>
			</unit>
		</ul>

		<?php
			$subjects = $t_item->get("ca_list_items", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
			print "<ul>";
			foreach($subjects as $s){print "<li>$s</li>";}
			print "</ul>";
		?>
	</div>
</ifdef>}}} -->

<!-- {{{<ifcount code="ca_objects" min="1" max="1">
	<div class='unit'>
		<unit relativeTo="ca_objects" delimiter=" ">
			<l>^ca_object_representations.media.large</l>
			<label>Related Object</label> <l>^ca_objects.preferred_labels.name</l>
		</unit>
	</div>
</ifcount>}}} -->