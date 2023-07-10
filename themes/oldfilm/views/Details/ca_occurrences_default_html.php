<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);

	$vs_video = "";
	# --- get the object related with "primary"
	if($vs_primary_video_object_id = $t_item->get("ca_objects.object_id", array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array("primary"), "limit" => 1))){
		$t_object_video = new ca_objects($vs_primary_video_object_id);
		$vs_video = $t_object_video->get('ca_object_representations.media.original', array("checkAccess" => $va_access_values));
	}
	if(!$vs_primary_video_object_id){
		$va_objects_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values, "excludeRelationshipTypes" => "primary"));
		$qr_hits = caMakeSearchResult("ca_objects", $va_objects_ids);
		if($qr_hits->numHits()){
			while($qr_hits->nextHit()){
				if($vs_video = $qr_hits->get('ca_object_representations.media.original', array("checkAccess" => $va_access_values))){
					break;	
				}
			}
		}
	
	}

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
					
					{{{<ifdef code="ca_occurrences.idno"><div class='unit'><label>Identifier</label>^ca_occurrences.idno</div></ifdef>}}}
<?php
					if($vs_video){
						print "<div class='unit'>".$vs_video."</div>";
					}
?>					
					{{{<ifcount code="ca_collections" min="1">
							<label>Collection<ifcount code="ca_collections.related" min="2">s</ifcount></label>
							<div class="unit"><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit></div>
					</ifcount>}}}

					<?php
						if($links = caGetSearchLinks($t_item, 'ca_occurrences.genre_terms', ['linkTemplate' => '<li>^LINK</li>'])) {
					?>
							
							<div class="unit">
								<label>Genre(s)</label>
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
						if($links = caGetBrowseLinks($t_item, 'ca_list_items', ['linkTemplate' => '<li>^LINK</li>', 'restrictToRelationshipTypes' => ['subject']])) {
					?>
							<div class="unit">
								<label>Subject(s)</label>
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
						if($vs_map = $this->getVar("map")){
	?>
							<ifdef code="ca_occurrences.georeference">
								<div class="unit"><label>Places</label><?php print $vs_map; ?></div>
							</ifdef>
	<?php
						}
					?>
					{{{<ifdef code="ca_occurrences.georeference_verbatim"><div class="unit"><unit reltaiveTo="ca_occurrences.georeference_verbatim" delimiter="<br/>">^ca_occurrences.georeference_verbatim</unit></div></ifdef>}}}
					
					
					{{{<ifdef code="ca_occurrences.RightsSummaryNHF.NHFRightsSummaryPub"><div class="unit"><label>Rights</label>^ca_occurrences.RightsSummaryNHF.NHFRightsSummaryPub</div></ifdef>}}}
					
				</div><!-- end col -->
				
				<div class='col-md-6 col-lg-6'>
					
					{{{<ifdef code="ca_occurrences.occ_date"><div class='unit'><label>Date</label>^ca_occurrences.occ_date</div></ifdef>}}}
<?php
					if(!$t_item->get("ca_occurrences.occ_date")){			
						# --- coverage
						$va_coverage = $t_item->get('ca_occurrences.pbcoreCoverage', array("returnWithStructure" => 1, 'convertCodesToDisplayText' => true));
						if(is_array($va_coverage) && sizeof($va_coverage)){
							$va_dates = array();
							$va_coverage = array_pop($va_coverage);
							foreach($va_coverage as $va_coverage_info){
								if($va_coverage_info["coverageType"] == "Temporal"){
									$va_dates[] = $va_coverage_info["coverage"];
								}
							}
							if(sizeof($va_dates)){
								print "\n<div class='unit'><label>"._t("Date(s)")."</label>".(implode(", ", $va_dates))."</div><!-- end unit -->";
							}
						}
					}
?>
					{{{<ifdef code="ca_occurrences.ic_stills.ic_stills_media">
						<div class='unit fullWidthImg'>^ca_occurrences.ic_stills.ic_stills_media.medium<ifdef code="ca_occurrences.ic_stills.ic_stills_credit"><b>Credit:</b> ^ca_occurrences.ic_stills.ic_stills_credit</ifdef>
					</ifdef>}}}
<?php
						# --- video clip
						if($vs_player = $t_item->get("ca_occurrences.ic_moving_images.ic_moving_images_media", array('version' => 'original', 'showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'))){
							
							print "\n<div class='unit fullWidthImg'>".$vs_player."";
							if($t_item->get("ca_occurrences.ic_moving_images.ic_moving_images_credit")){
								print "<div class='imageCaption'>"._t("Credit:")." ".$t_item->get("ca_occurrences.ic_moving_images.ic_moving_images_credit")."</div>";
							}
							print "</div><!-- end unit -->";
						}
?>
					{{{<unit relativeTo="ca_occurrences.pbcoreDescription" delimiter=""><ifdef code="ca_occurrences.pbcoreDescription.description_text"><div class='unit'><label>^ca_occurrences.pbcoreDescription.descriptionType</label>^ca_occurrences.pbcoreDescription.description_text</div></ifdef></unit>}}}
					
					<?php
						if($links = caGetSearchLinks($t_item, 'ca_entities', ['template' => '<l>^ca_entities.preferred_labels.displayname%restrictToRelationshipTypes=creator</l>', 'linkTemplate' => '<li>^LINK</li>', 'restrictToRelationshipTypes' => array('creator')])) {
					?>
							<div class="unit">
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1" max="1"><label>Creator</label></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="2"><label>Creators</label></ifcount>}}}
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
						if($links = caGetSearchLinks($t_item, 'ca_entities', ['template' => '<l>^ca_entities.preferred_labels.displayname</l>', 'linkTemplate' => '<li>^LINK</li>', 'restrictToRelationshipTypes' => array('contributor')])) {
					?>
							<div class="unit">
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="contributor" min="1" max="1"><label>Contributor</label></ifcount>}}}
							{{{<ifcount code="ca_entities" restrictToRelationshipTypes="contributor" min="2"><label>Contributors</label></ifcount>}}}
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
					?>
					<?php
						if($links = caGetSearchLinks($t_item, 'ca_occurrences.related', ['template' => '<l>^ca_occurrences.related.preferred_labels.name</l>', 'linkTemplate' => '<li>^LINK</li>'])) {
					?>
							<div class="unit">
							{{{<ifcount code="ca_occurrences.related" min="1" max="1"><label>Related work</label></ifcount>}}}
							{{{<ifcount code="ca_occurrences.related" min="2"><label>Related works</label></ifcount>}}}
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
						$va_entities = $t_item->get("ca_entities", array('checkAccess' => $va_access_values, "returnWithStructure" => 1, "excludeRelationshipTypes" => array("creator", "contributor")));
						if(is_array($va_entities) && sizeof($va_entities) > 0){
							$va_entity_by_type = array();
							foreach($va_entities as $va_entity){
								$va_entity_by_type[$va_entity["relationship_typename"]][] = array("entity_id" => $va_entity["entity_id"], "relationship_typename" => $va_entity["relationship_typename"], "label" => $va_entity["label"]);
							}
							foreach($va_entity_by_type as $vs_relationship_typename => $va_entities_by_type){
?>
								<div class="unit"><label><?php print caUcFirstUTF8Safe($vs_relationship_typename); ?></label><ul>
<?php
								$vn_i = 1;
								foreach($va_entities_by_type as $va_entity) {
									print "<li>".caNavLink($this->request, $va_entity["label"], '', '', 'Browse', 'collections', array('facet' => 'entity_facet', 'id' => $va_entity['entity_id']));
									if(sizeof($va_entities_by_type) > $vn_i){
										print ", ";
									}
									print "</li>";
									$vn_i++;
								}
?>
								</ul></div><!-- end unit --->
<?php					
							}
						}
						
						if($links = caGetBrowseLinks($t_item, 'ca_places', ['template' => '<l>^ca_places.preferred_labels.name</l>', 'linkTemplate' => '<li>^LINK</li>'])) {
?>
							<div class='unit'>
							{{{<ifcount code="ca_places" min="1">
								<label>Related place<ifcount code="ca_places" min="2">s</ifcount></label>
							</ifcount>}}}
	
								<ul><?= join("\n", $links); ?></ul>
							</div>
					<?php
						}
					?>
						
				</div><!-- end col -->

			</div><!-- end row -->
			
			{{{<ifcount code="ca_objects" min="1">

				<H2 style="margin: 35px 0px 20px 0px"><ifcount code="ca_objects" min="1" max="1">1 Copy</ifcount><ifcount code="ca_objects" min="2"><unit relativeTo="ca_objects" length='1'>^count</unit> Copies</ifcount></H2>
			
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