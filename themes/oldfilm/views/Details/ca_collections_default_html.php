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

	// $t_collection 		= $this->getVar('t_item');
	// $vn_collection_id 	= $t_collection->getPrimaryKey();
	// $vs_title 			= $this->getVar('label');
	// $t_rel_types 		= $this->getVar('t_relationship_types');
	// $va_comments 		= $this->getVar("comments");
	// $pn_numRankings 	= $this->getVar("numRankings");
	// $va_access_values = 			$this->getVar('access_values');

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

					<!-- <H2>{{{^ca_collections.type_id}}} {{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2> -->

					<!-- {{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}} -->

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

					<!-- {{{<ifdef code="ca_collections.description"><div class="unit"><label>About</label>^ca_collections.description</div></ifdef>}}} -->

					{{{<ifdef code="ca_collections.idno"><div class="unit"><label>Identifier:</label>^ca_collections.idno</unit></ifdef>}}}

					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="donated"><div class='unit'><label>Donor(s)</label>
						<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="donated">^ca_entities.preferred_labels.displayname</unit>
					</div></ifcount>}}}

					{{{<ifdef code="ca_collections.collection_primary_format"><div class="unit"><label>Primary Format and Extent</label>^ca_collections.collection_primary_format</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_datespan"><div class="unit"><label>Collection Date Range</label>^ca_collections.collection_datespan	</div></ifdef>}}}

					{{{<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>}}}

					<?php 

							$people = $t_item->get("ca_entities", array("returnAsArray" => true));

							print "<ul>";
							foreach($people as $p){
								print "<li>$p</li>";
							}
							print "</ul>";
					
					?>

					<!-- {{{<unit relativeTo="ca_entities_x_collections"><unit relativeTo="ca_entities" delimiter="\n"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit>}}} -->

					{{{<ifdef code="ca_collections.genre_terms">
						<div class="unit">
							<label>Genre(s)</label>
							<?php
								$genres = $t_item->get("ca_collections.genre_terms", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
								print "<ul>";
								foreach($genres as $g){print "<li>$g</li>";}
								print "</ul>";
							?>
						</div>
					</ifdef>}}}

					{{{<ifdef code="ca_list_items">
						<div class="unit">
							<label>Subjects</label>
							<?php
								$subjects = $t_item->get("ca_list_items", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
								print "<ul>";
								foreach($subjects as $s){print "<li>$s</li>";}
								print "</ul>";
							?>
						</div>
					</ifdef>}}}

					{{{<ifdef code="ca_collections.georeference"><div class="unit"><label>Places</label>
						<?php 
								$places = $t_item->get("ca_collections.georeference", array("returnAsArray" => true));
								print "<ul>";
								foreach($places as $pl){	print "<li>$pl</li>"; }
								print "</ul>";
						?>
					</div></ifdef>}}}

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
								<unit relativeTo="ca_collections.related" delimiter=", "><l>^ca_collections.related.preferred_labels.name</l></unit> (^relationship_typename)</unit>
							</div>
					</ifcount>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>}}}
					{{{<unit relativeTo="ca_places_x_collections"><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}					
		
					{{{<ifdef code="ca_collections.collection_summary"><div class="unit"><label>Summary</label>^ca_collections.collection_summary</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_biographical_notes"><div class="unit"><label>Biographical/Historical Notes</label>^ca_collections.collection_biographical_notes</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_access_repos"><div class="unit"><label>Repository</label>^ca_collections.collection_access_repos</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_access"><div class="unit"><label>Availability</label>^ca_collections.collection_access</div></ifdef>}}}

					{{{<ifdef code="ca_collections.collection_repro_cond"><div class="unit"><label>Conditions Governing Reproduction and Use	</label>^ca_collections.collection_repro_cond	</div></ifdef>}}}

					{{{<ifcount code="ca_objects" min="1" max="1">
						<div class='unit'>
							<unit relativeTo="ca_objects" delimiter=" ">
								<l>^ca_object_representations.media.large</l>
								<div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div>
							</unit>
						</div>
					</ifcount>}}}

				</div><!-- end col -->
			</div><!-- end row -->

			
			{{{<ifcount code="ca_objects" min="2">
				<H2 style="margin: 20px 0px">Related Occurences</H2>
					<div class="row">
						<div id="browseResultsContainer">
							<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
						</div><!-- end browseResultsContainer -->
					</div><!-- end row -->
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'occurrences', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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




<!-- Comment and Share Tools -->
<!-- <?php
	if ($vn_comments_enabled | $vn_share_enabled) {
			
		print '<div id="detailTools">';
		if ($vn_comments_enabled) {
?>				 -->

	<!-- <div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div> -->
	<!-- end detailTool -->
	<!-- <div id='detailComments'><?php print $this->getVar("itemComments");?></div> -->
	<!-- end itemComments -->

<!-- <?php				
			}
			if ($vn_share_enabled) {
				print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
			}
			print '</div><!-- end detailTools -->';
		}				
?> -->

<!-- 					
<?php
	# --- donor(s) 
	$va_donors = $t_item->get("ca_entities", array('restrict_to_relationship_types' => array('donated'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
	if(is_array($va_donors) && sizeof($va_donors) > 0){
?>
		<div class="unit"><label><?php print _t("Donor"); ?></label>
<?php
		$va_tmp = array();
		foreach($va_donors as $va_donor) {
			$va_tmp[] = caNavLink($this->request, $va_donor["label"], '', '', 'Browse', 'collections', array('facet' => 'entity_facet', 'id' => $va_donor['entity_id']));
			
		}
		print join(", ", $va_tmp);
?> -->
		<!-- </div> -->
		<!-- end unit --->
<!-- <?php

			}
?>
-->

<?php					
	// if ($vn_pdf_enabled) {
	// 	print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
	// }
?>