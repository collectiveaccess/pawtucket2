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

					{{{<ifdef code="ca_object_representations">^ca_object_representations.media.medium</ifdef>}}}

					{{{<ifdef code="ca_collections.parent_id">
						<div class="unit"><?= _t('Part of'); ?>:<unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">
							<l>^ca_collections.preferred_labels.name</l>
						</unit></div>
					</ifdef>}}}

					<!-- <?php					
						if ($vn_pdf_enabled) {
							print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
						}
					?> -->
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
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_objects" min="1" max="1"><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.large</l></unit></div></ifcount>}}}
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

				<div class='col-md-12 col-lg-12'>
					{{{<ifdef code="ca_collections.vhh_Note"><label><t>Notes</t></label><br/>^ca_collections.vhh_Note</ifdef>}}}
					<!-- 
						{{{<ifcount code="ca_entities" min="1"><label>Related people</label></ifcount>}}}
						{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}	
					 -->
				</div><!-- end col -->
			</div><!-- end row -->

			</br>
<?php
					if ($va_related = $t_item->get('ca_entities', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit'><H3>"._t("Related People & Organizations")."</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						foreach ($va_related as $va_related_info) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_related_info['displayname'], '', 'ca_entities', $va_related_info['entity_id'])."</div></div>";
							$i++;
							if($i == 3){
								print "</div><!-- end row -->";
								$i = 0;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
					}
					if ($va_related = $t_item->get('ca_occurrences', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit'><H3>"._t("Related Events")."</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						foreach ($va_related as $va_related_info) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_related_info['name'], '', 'ca_occurrences', $va_related_info['occurrence_id'])."</div></div>";
							$i++;
							if($i == 3){
								print "</div><!-- end row -->";
								$i = 0;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
					}
					if ($va_related = $t_item->get('ca_places', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit'><H3>"._t("Related Locations")."</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						foreach ($va_related as $va_related_info) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_related_info['name'], '', 'ca_places', $va_related_info['place_id'])."</div></div>";
							$i++;
							if($i == 3){
								print "</div><!-- end row -->";
								$i = 0;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
					}
?>
			{{{<ifcount code="ca_objects.related" min="1">
				<H1>Related Films</H1>
				<div class="row">
					<div id="browseResultsContainer">
						<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
					</div><!-- end browseResultsContainer -->
				</div><!-- end row -->
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'films', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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