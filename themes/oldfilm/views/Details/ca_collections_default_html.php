<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = $this->getVar("access_values");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

	// $terms = $t_item->get("ca_collections.genre_terms", array("returnAsArray" => true, "convertCodesToDisplayText" => true));

	// $terms = $t_item->get("ca_entities_x_collections", array("returnAsArray" => true));
	// print $terms

	// print "<ul>";
	// foreach($terms as $t){
	// 	print "<li>$t</li>";
	// }
	// print "</ul>";

	// $terms = $t_item->get("ca_entities_x_collections", array("returnAsArray" => true));
	// print $terms

	// $length_of_items = count(
	// 	caNavUrl($this->request, '', 'Search', 'works', array('search' => 'ca_collections.collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true))
	// );

	// print $length_of_items;

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
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">
				<div class='col-sm-6'>
					
					<?php
						# --- image
						if($t_item->get('ca_collections.collection_still')){
							print "\n<div class='unit'><div>".$t_item->get('ca_collections.collection_still', array('version' => "medium", "showMediaInfo" => false))."</div>";
							if($t_item->get('ca_collections.collection_still_credit')){
								print "<div class='imageCaption'>"._t("Credit:")." ".$t_item->get('ca_collections.collection_still_credit')."</div>";
							}
							print "</div><!-- end unit -->";
						}
					?>

					<!-- {{{<ifdef code="ca_collections.idno"><div class="unit"><label>Identifier:</label>^ca_collections.idno</unit></ifdef>}}} -->
					{{{<ifcount code="ca_object_lots" min="1"><div class="unit"><label>Collection Identifier(s)</label><unit relativeTo="ca_object_lots" delimiter="<br/>">^ca_object_lots.preferred_labels, ^ca_object_lots.idno_stub</unit></div></ifcount>}}}
					{{{<ifcount code="ca_entities"  restrictToRelationshipTypes='created_by' min="1">
						<label>Creator(s)</label>
					</ifcount>}}}
					<ul><?= join("\n", caGetBrowseLinks($t_item, 'ca_entities', ['restrictToRelationshipTypes' => 'created_by', 'linkTemplate' => '<li>^LINK</li>']) ?? []); ?></ul>

					{{{<ifcount code="ca_entities" restrictToRelationshipTypes='donated' min="1">
						<label>Donor(s)</label>
					</ifcount>}}}
					<ul><?= join("\n", caGetBrowseLinks($t_item, 'ca_entities', ['restrictToRelationshipTypes' => 'donated', 'linkTemplate' => '<li>^LINK</li>']) ?? []); ?></ul>
					
					{{{<ifdef code="ca_collections.collection_primary_format"><div class="unit"><label>Primary Format and Extent</label>^ca_collections.collection_primary_format</div></ifdef>}}}
					{{{<ifdef code="ca_collections.secondary_format"><div class="unit"><label>Secondary Format and Extent</label>^ca_collections.secondary_format</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_datespan"><div class="unit"><label>Collection Date Range</label>^ca_collections.collection_datespan	</div></ifdef>}}}

					<?php
						if($links = caGetSearchLinks($t_item, 'ca_collections.genre_terms', ['linkTemplate' => '<li>^LINK</li>'])) {
					?>
							<label>Genre(s)</label>
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
						if($links = caGetBrowseLinks($t_item, 'ca_list_items', ['linkTemplate' => '<li>^LINK</li>', 'restrictToRelationshipTypes' => ['subject']])) {
					?>
							<label>Subject(s)</label>
							<div class="unit">
								<ul><?= join("\n", $links); ?></ul>
							</div>
<?php
						}
					if($va_geoferences = $t_item->get('georeference', array("returnAsArray" => true))){
?>

						<div class="unit"><label>Places</label>
				  			{{{map}}}
<?php
				  
				  		foreach($va_geoferences as $vs_georeference) {
							$vs_georeference_short = mb_substr($vs_georeference, 0, strpos($vs_georeference, "["));
							print caNavLink($this->request, $vs_georeference_short, '', '', 'Search', 'Collections', array('search' => $vs_georeference_short));
							print "<br/>";
						}
?>
						</div>
<?php
					}
?>
				</div>	<!-- end col -->

				<div class='col-md-6 col-lg-6'>
					<?php
						# --- video clip
						if($vs_player = $t_item->get("ca_collections.collection_moving_image_media", array('version' => 'original', 'showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'))){
							
							print "\n<div class='unit'>".$vs_player."";
							if($t_item->get("ca_collections.collection_moving_image_credit")){
								print "<div class='imageCaption'>"._t("Credit:")." ".$t_item->get("ca_collections.collection_moving_image_credit")."</div>";
							}
							print "</div><!-- end unit -->";
						}
					?>

					{{{<ifcount code="ca_collections.related" min="1">
						<div class='unit'>
							<label>Related collection<ifcount code="ca_collections.related" min="2">s</ifcount></label>
								<ul>
									<unit relativeTo="ca_collections.related" delimiter="">
										<li> 
											<l>^ca_collections.preferred_labels.name</l>(^relationship_typename)
										</li>
									</unit>
								</ul>
						</div>
					</ifcount>}}}

					<?php
						if($links = caGetBrowseLinks($t_item, 'ca_places', ['template' => '<l>^ca_places.preferred_labels.name</l> (^relationship_typename)', 'linkTemplate' => '<li>^LINK</li>'])) {
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
					
					{{{<ifdef code="ca_collections.collection_summary"><div class="unit"><label>Summary</label>^ca_collections.collection_summary</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_biographical_notes"><div class="unit"><label>Biographical/Historical Notes</label>^ca_collections.collection_biographical_notes</div></ifdef>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes='depicts'  min="1">
						<label>Depicts</label>
					</ifcount>}}}
					<ul><?= join("\n", caGetBrowseLinks($t_item, 'ca_entities', ['restrictToRelationshipTypes' => 'depicts', 'linkTemplate' => '<li>^LINK</li>']) ?? []); ?></ul>

					
					{{{<ifdef code="ca_collections.collection_access_repos"><div class="unit"><label>Repository</label>^ca_collections.collection_access_repos</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_access"><div class="unit"><label>Availability</label>^ca_collections.collection_access</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_repro_cond"><div class="unit"><label>Conditions Governing Reproduction and Use</label>^ca_collections.collection_repro_cond</div></ifdef>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->

			
			
			<H2 style="margin: 35px 0px 20px 0px">
				{{{<ifcount code="ca_occurrences" min="1"><unit relativeTo="ca_occurrences" length='1'>^count Items in this collection</unit></ifcount>}}}
			</H2>

			{{{<ifcount code="ca_objects" min="1">
					<div class="row">
						<div id="browseResultsContainer">
							<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
						</div><!-- end browseResultsContainer -->
					</div><!-- end row -->

					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'works', array('search' => 'ca_collections.collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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





