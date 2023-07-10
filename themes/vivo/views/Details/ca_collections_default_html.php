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

?>
<div class="container"><div class="row">
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
				<div class='col-md-9 col-lg-9'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
					
				</div>
				<div class='col-md-3'>
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'>".caDetailLink($this->request, "Download as PDF <span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
					print "<div class='browseAllCollection'>".caNavLink($this->request, "Browse Objects  →", "", "", "browse", "all_objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id")))."</div>";
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php
					if($t_item->get("ca_collections.idno") == "SVES"){
						print $t_item->getWithTemplate('<ifdef code="ca_object_representations.media.page"><div class="unit fullWidth">^ca_object_representations.media.page</div></ifdef>');
					}
?>
					{{{<ifdef code="ca_collections.title_note"><div class="unit"><label>Title Note</label>^ca_collections.title_note</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_scopecontent"><div class="unit"><label>Scope and Content</label><span class="trimText">^ca_collections.RAD_scopecontent</span></div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_admin_hist"><div class="unit"><label>Administrative/Biographical History</label><span class="trimText">^ca_collections.RAD_admin_hist</span></div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_material"><div class="unit"><label>Related Materials</label>^ca_collections.RAD_material</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_langMaterial"><div class="unit"><label>Language</label>^ca_collections.RAD_langMaterial</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1"><div class="unit"><label>Related people, organisations & indigenous communities</label><div class="trimTextShort"><unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit></div></div></ifcount>}}}
					{{{<ifcount code="ca_collections.related" min="1"><div class="unit"><label>Collection</label><unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="event"><div class="unit"><label>Related programs & events</label><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="subject_guide"><div class="unit"><label>Related Subject Guides</label><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="subject_guide"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
					
<?php
			if($t_item->get("ca_collections.idno") == "SVES"){
				$va_child_collections = $t_item->get("ca_collections.children.collection_id", array("returnAsArray" => true, "sort" => "ca_collections.idno"));
				if(is_array($va_child_collections) && sizeof($va_child_collections)){
					$q_child_collections = caMakeSearchResult('ca_collections', $va_child_collections);
					if($q_child_collections->numHits()){
						print '<div class="row"><div class="col-sm-12"><H3>Resources</H3></div></div>';
						
						$i = 0;
						while($q_child_collections->nextHit()){
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-3'>".$q_child_collections->getWithTemplate("<l><div class='collectionChildren'><ifdef code='ca_object_representations.media.iconlarge'>^ca_object_representations.media.iconlarge</ifdef><ifnotdef code='ca_object_representations.media.iconlarge'><unit relativeTo='ca_collections.parent'>^ca_object_representations.media.iconlarge</unit></ifnotdef><label>^ca_collections.preferred_labels</label></div></l>")."</div>";	
							$i++;
							if($i == 4){
								print "</div>";
								$i = 0;
							}
						}
						if($i > 0){
							print "</div>";
						}
						
					}
				}
			}else{

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
			}									
?>				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'all_objects', array('facet' => 'detail_collection', 'id' => '^ca_collections.collection_id', 'detailNav' => 'collection'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
</div><!-- end row --></div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 300,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>
