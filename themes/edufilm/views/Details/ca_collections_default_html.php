<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	$va_access_values = caGetUserAccessValues($this->request);
	
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
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>

					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>

					{{{<ifdef code="ca_collections.parent_id">
						<div class="unit"><?= _t('Part of'); ?>:<unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">
							<l>^ca_collections.preferred_labels.name</l>
						</unit></div>
					</ifdef>}}}
<hr/>
					<!-- <?php					
						if ($vn_pdf_enabled) {
							print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
						}
					?> -->
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">			
<?php
			if(trim($this->getVar("representationViewer"))){
?>
				<div class='col-md-6 col-lg-6'>
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>

<?php
				if($t_item->get("ca_collections.collection_id") == 4){
?>
					<div class="row">
						<div class="col-sm-6 col-md-4 fullWidthImg">
							<br/><br/><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'map.png', array("alt" => "map")), '', '', 'Browse', 'Places', array('sort' => 'default', 'view' => 'map')); ?>
							<br/><label><?php print caNavLink($this->request, _t("Locations")." <i class='fa fa-external-link'></i>", '', '', 'Browse', 'Places', array('sort' => 'default', 'view' => 'map')); ?></label>
							
						</div>
					</div>
<?php
				}
?>
				</div><!-- end col -->

				<div class='col-md-6'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					{{{<ifdef code="ca_collections.vhh_Note.vhh_NoteText"><div class="unit"><label><t>Notes</t></label><unit relativeTo="ca_collections.vhh_Note" delimiter="<br/><br/>">^ca_collections.vhh_Note.vhh_NoteText%convertLineBreaks=1</unit></div></ifdef>}}}
					<!-- 
						{{{<ifcount code="ca_entities" min="1"><label>Related people</label></ifcount>}}}
						{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}	
					 -->
				</div><!-- end col -->
			</div><!-- end row -->

			</br>

<?php
	$vb_show_tabs = $vb_people = $vb_organizations = $vb_locations = $vb_films = $vb_texts = $vb_images = $vb_events = false;
	
	$va_related_people_ids = $t_item->get("ca_entities.entity_id", array("restrictToTypes" => array("person"), "returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_related_people_ids) && sizeof($va_related_people_ids)){
		$vb_people = true;
		$vb_show_tabs = true;
	}
	$va_related_org_ids = $t_item->get("ca_entities.entity_id", array("restrictToTypes" => array("organization"), "returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_related_org_ids) && sizeof($va_related_org_ids)){
		$vb_organizations = true;
		$vb_show_tabs = true;
	}
	$va_related_locations_ids = $t_item->get("ca_places.place_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_related_locations_ids) && sizeof($va_related_locations_ids)){
		$vb_locations = true;
		$vb_show_tabs = true;
	}
	$va_related_event_ids = $t_item->get("ca_occurrences.occurrence_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_related_event_ids) && sizeof($va_related_event_ids)){
		$vb_events = true;
		$vb_show_tabs = true;
	}
	$va_related_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	
	$o_related_object = caMakeSearchResult("ca_objects", $va_related_object_ids, array("checkAccess" => $va_access_values));
	if($o_related_object){
		while($o_related_object->nextHit()){
			switch($o_related_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))){
				case "AVCreation":
					$vb_films = true;
					$vb_show_tabs = true;
				break;
				# -----------------------
				case "NonAVManifestation":
					switch($o_related_object->get("ca_objects.vhh_MediaType.MT_List", array("convertCodesToDisplayText" => true))){
						case "still image (photographic)":
						case "still image (other)":
							$vb_images = true;
							$vb_show_tabs = true;
						break;
						# ------------------
						case "text":
						case "imagetext":
							$vb_texts = true;
							$vb_show_tabs = true;
						break;
						# ------------------
					}
				break;
				# -----------------------
				
			}
			if($vb_films && $vb_texts && $vb_images){
				break;
			}
		}
	}
		if($vb_show_tabs){
?>
			<div class="row">
				<div class="col-sm-12">
						<div class="relatedBlock">
							<div class="relatedBlockTabs">
<?php
								$vs_firstTab = "";
								if($vb_people){
									print "<div id='relPeopleButton' class='relTabButton' onClick='toggleTag(\"relPeople\");'>"._t("People")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relPeople";
									}
								}
								if($vb_organizations){
									print "<div id='relOrganizationsButton' class='relTabButton' onClick='toggleTag(\"relOrganizations\");'>"._t("Organizations")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relOrganizations";
									}
								}
								if($vb_locations){
									print "<div id='relLocationsButton' class='relTabButton' onClick='toggleTag(\"relLocations\");'>"._t("Locations")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relLocations";
									}
								}
								
								if($vb_films){
									print "<div id='relFilmsButton' class='relTabButton' onClick='toggleTag(\"relFilms\");'>"._t("Films")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relFilms";
									}
								}
								if($vb_images){
									print "<div id='relImagesButton' class='relTabButton' onClick='toggleTag(\"relImages\");'>"._t("Images")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relImages";
									}
								}
								if($vb_texts){
									print "<div id='relTextsButton' class='relTabButton' onClick='toggleTag(\"relTexts\");'>"._t("Texts")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relTexts";
									}
								}
								if($vb_events){
									print "<div id='relEventsButton' class='relTabButton' onClick='toggleTag(\"relEvents\");'>"._t("Events")."</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEvents";
									}
								}
?>
							</div>
							<div class="relatedBlockContent">							
<?php
									if($vb_people){
?>							
										<div class="row relTab" id="relPeople">
											<div id="browseResultsContainerPeople">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerPeople").load("<?php print caNavUrl($this->request, '', 'Browse', 'people', array('facet' => 'collection_facet', 'id' => $t_item->get('ca_collections.collection_id'), 'view' => 'images', 'sort' => 'CollectionSort', 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerPeople').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_organizations){
?>							
										<div class="row relTab" id="relOrganizations">
											<div id="browseResultsContainerOrganizations">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerOrganizations").load("<?php print caNavUrl($this->request, '', 'Browse', 'organization', array('facet' => 'collection_facet', 'id' => $t_item->get('ca_collections.collection_id'), 'view' => 'images', 'sort' => 'CollectionSort', 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerOrganizations').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_locations){
?>							
										<div class="row relTab" id="relLocations">
											<div id="browseResultsContainerLocations">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerLocations").load("<?php print caNavUrl($this->request, '', 'Browse', 'places', array('facet' => 'collection_facet', 'id' => $t_item->get('ca_collections.collection_id'), 'view' => 'list', 'sort' => 'CollectionSort', 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerLocations').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_films){
?>							
										<div class="row relTab" id="relFilms">
											<div id="browseResultsContainerFilms">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerFilms").load("<?php print caNavUrl($this->request, '', 'Browse', 'films', array('facet' => 'collection_facet', 'id' => $t_item->get('ca_collections.collection_id'), 'view' => 'images', 'sort' => 'CollectionSort', 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerFilms').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_images){
?>
										<div class="row relTab" id="relImages">
											<div id="browseResultsContainerImages">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerImages").load("<?php print caNavUrl($this->request, '', 'Search', 'images', array('search' => 'collection_id:'.$t_item->get('ca_collections.collection_id'), 'view' => 'images', 'sort' => 'CollectionSort', 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerImages').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_texts){
?>										
										<div class="row relTab" id="relTexts">
											<div id="browseResultsContainerTexts">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerTexts").load("<?php print caNavUrl($this->request, '', 'Search', 'texts', array('search' => 'collection_id:'.$t_item->get('ca_collections.collection_id'), 'view' => 'images', 'sort' => 'CollectionSort', 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerTexts').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
									if($vb_events){
?>							
										<div class="row relTab" id="relEvents">
											<div id="browseResultsContainerEvents">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerEvents").load("<?php print caNavUrl($this->request, '', 'Browse', 'occurrences', array('facet' => 'collection_facet', 'id' => $t_item->get('ca_collections.collection_id'), 'view' => 'list', 'sort' => 'CollectionSort', 'dontSetFind' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerEvents').jscroll({
														autoTrigger: true,
														loadingHtml: '',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
<?php
									}
?>

								
								
							</div>
						</div>
				</div>
			</div>


						<script type="text/javascript">
							function toggleTag(ID){
								$('.relTab').css('display', 'none');
								$('#' + ID).css('display', 'block');
								$('.relTabButton').removeClass('selected');
								$('#' + ID + 'Button').addClass('selected');
							}
							jQuery(document).ready(function() {
								toggleTag("<?php print $vs_firstTab; ?>");
							});
						</script>


<?php
			}
?>	
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
