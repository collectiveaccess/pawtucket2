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
	$va_access_values = caGetUserAccessValues($this->request);
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

	# --- result context
	$va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_object_ids) && sizeof($va_object_ids)){
		$o_rel_context = new ResultContext($this->request, 'ca_objects', 'detailrelated', $this->request->getAction);
		#$o_rel_context->setParameter('key', $key);
		$o_rel_context->setAsLastFind(true);
		
		$o_rel_context->setResultList($va_object_ids);
		
		$o_rel_context->saveContext();
	}

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
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php
			if ($vb_show_hierarchy_viewer) {	
?>
				<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
				<script>
					$(document).ready(function(){
						$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
					})
				</script>
<?php				
			}									
?>				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-12'>
					{{{<ifdef code="ca_collections.date_container.date"><div class="unit"><H3>Date</H3>^ca_collections.date_container.date%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_scopecontent"><div class="unit"><H3>Scope and Content</H3>^ca_collections.RAD_scopecontent</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_admin_hist"><div class="unit"><H3>Administrative/Biographical History</H3>^ca_collections.RAD_admin_hist</div></ifdef>}}}					
					
					{{{<ifcount code="ca_collections.related" min="1"><div class="unit"><H3>Related Collections</H3><unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
<?php

				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>

				</div><!-- end col -->
			</div><!-- end row -->
<?php
	# --- what related content is there
	$vb_show_tabs = false;
	$vb_entities_curator = false;
	$vb_entities_artist = false;
	$vb_objects = false;
	$vb_programs = false;
	if($t_item->get("ca_entities.entity_id", array("checkAccess" => $va_access_values, "limit" => 1, "restrictToRelationshipTypes" => "Artist"))){
		$vb_entities_artist = true;
		$vb_show_tabs = true;
	}
	if($t_item->get("ca_entities.entity_id", array("checkAccess" => $va_access_values, "limit" => 1, "restrictToRelationshipTypes" => "Curator"))){
		$vb_entities_curator = true;
		$vb_show_tabs = true;
	}
	if($t_item->get("ca_objects.object_id", array("checkAccess" => $va_access_values, "limit" => 1))){
		$vb_objects = true;
		$vb_show_tabs = true;
	}
	if($t_item->get("ca_occurrences.occurrence_id", array("restrictToTypes" => array("program"), "checkAccess" => $va_access_values, "limit" => 1))){
		$vb_programs = true;
		$vb_show_tabs = true;
	}
	if($vb_show_tabs){
?>
			<div class="row">
				<div class="col-sm-12">
						<div class="relatedBlock">
							<div class="relatedBlockTabs">
<?php
								$vs_firstTab = "";
								if($vb_objects){
									print "<div id='relObjectsButton' class='relTabButton' onClick='toggleTag(\"relObjects\");'>Archive, Library & Publication Objects (".$t_item->getWithTemplate("<unit relativeTo='ca_objects' limit='1'>^count</unit>", array("checkAccess" => $va_access_values)).")</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relObjects";
									}
								}
								if($vb_programs){
									print "<div id='relProgramsButton' class='relTabButton' onClick='toggleTag(\"relPrograms\");'>Programs (".$t_item->getWithTemplate("<unit relativeTo='ca_occurrences' limit='1'>^count</unit>", array("checkAccess" => $va_access_values)).")</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relPrograms";
									}
								}
								if($vb_entities_artist){
									print "<div id='relEntitiesArtistButton' class='relTabButton' onClick='toggleTag(\"relEntitiesArtist\");'>Artists (".$t_item->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='Artist' limit='1'>^count</unit>", array("checkAccess" => $va_access_values)).")</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEntitiesArtist";
									}
								}
								if($vb_entities_curator){
									print "<div id='relEntitiesCuratorButton' class='relTabButton' onClick='toggleTag(\"relEntitiesCurator\");'>Curators (".$t_item->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='Curator' limit='1'>^count</unit>", array("checkAccess" => $va_access_values)).")</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEntitiesCurator";
									}
								}
?>
							</div>
							<div class="relatedBlockContent">							
								
								{{{<ifcount code="ca_objects" min="1">
										<div class="row relTab" id="relObjects">
											<div id="browseResultsContainerobjects">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerobjects").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'collection_facet', 'id' => '^ca_collections.collection_id', 'detailNav' => 'collection', 'dontSetFind' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerobjects').jscroll({
														autoTrigger: true,
														loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
								</ifcount>}}}
								{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="program">
										<div class="row relTab" id="relPrograms">
											<div id="browseResultsContainerprograms">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainerprograms").load("<?php print caNavUrl($this->request, '', 'Browse', 'programs', array('facet' => 'collection_facet', 'id' => '^ca_collections.collection_id', 'detailNav' => 'collection'), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainerprograms').jscroll({
														autoTrigger: true,
														loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
								</ifcount>}}}
								{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Artist">
										<div class="row relTab" id="relEntitiesArtist">
											<div id="browseResultsContainercollection_artists">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainercollection_artists").load("<?php print caNavUrl($this->request, '', 'Browse', 'collection_artists', array('facet' => 'collection_artist_facet', 'id' => '^ca_collections.collection_id', 'detailNav' => 'collection', 'l' => 'all'), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainercollection_artists').jscroll({
														autoTrigger: true,
														loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
								</ifcount>}}}
								{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Curator">
										<div class="row relTab" id="relEntitiesCurator">
											<div id="browseResultsContainercollection_curators">
												<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
											</div><!-- end browseResultsContainer -->
										</div><!-- end row -->
										<script type="text/javascript">
											jQuery(document).ready(function() {
												jQuery("#browseResultsContainercollection_curators").load("<?php print caNavUrl($this->request, '', 'Browse', 'collection_curators', array('facet' => 'collection_curator_facet', 'id' => '^ca_collections.collection_id', 'detailNav' => 'collection', 'l' => 'all'), array('dontURLEncodeParameters' => true)); ?>", function() {
													jQuery('#browseResultsContainercollection_curators').jscroll({
														autoTrigger: true,
														loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
														padding: 20,
														nextSelector: 'a.jscroll-next'
													});
												});
					
					
											});
										</script>
								</ifcount>}}}
								
								
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
				</div>
			</div>
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
		  maxHeight: 407,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>
