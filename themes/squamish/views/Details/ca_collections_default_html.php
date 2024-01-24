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
					<div class="row">
						<div class='col-md-10'>
							<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
							<H2>{{{^ca_collections.type_id}}}</H2>
							{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
						</div>
						<div class='col-md-2'>
<?php
							print "<div id='detailTools'><div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Ask / Comment", "", "", "Contact", "Form", array("table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id")))."</div>";
					
							if ($vn_pdf_enabled) {
								print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
							}
							print "</div>";
?>
						</div><!-- end col -->
					</div>
					<hr/>
					{{{<ifdef code="ca_collections.idno"><div class="unit"><label>Identifier</label>^ca_collections.idno</div></ifdef>}}}
					{{{<ifdef code="ca_collections.display_date"><div class="unit"><label>Date</label>^ca_collections.display_date%delimiter=,_</div></ifdef>}}}
					{{{<ifnotdef code="ca_collections.display_date"><ifdef code="ca_collections.date"><div class="unit"><label>Date</label>^ca_collections.date%delimiter=,_</div></ifdef></ifnotdef>}}}
					{{{<ifdef code="ca_collections.date_note"><div class="unit"><label>Date Note</label><unit relativeTo="ca_collections.date_note" delimiter="<br/>">^ca_collections.date_note</unit></div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.phys_desc"><div class="unit"><label>Physical Description</label>^ca_collections.phys_desc</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator,contributor"><div class="unit"><label>Creator<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="creator,contributor">s</ifcount></label>
						<unit relativeTo="ca_entities_x_collections" restrictToRelationshipTypes="creator,contributor" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l><if rule='^ca_collections.type_id =~ /Collection/'><ifdef code="ca_entities.bio_history_container.bio_history"><br/>^ca_entities.bio_history_container.bio_history</ifdef></if></unit>
					</div></ifcount>}}}
					
					{{{<ifdef code="ca_collections.description"><div class="unit"><label>Scope & Content</label>^ca_collections.description</div></ifdef>}}}
					{{{<ifdef code="ca_collections.provenance"><div class="unit"><label>Provenance</label>^ca_collections.provenance</div></ifdef>}}}
					{{{<ifdef code="ca_collections.language"><div class="unit"><label>Language</label>^ca_collections.language%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.arrangement"><div class="unit"><label>System of Arrangement</label>^ca_collections.arrangement</div></ifdef>}}}
					{{{<ifdef code="ca_collections.accruals"><div class="unit"><label>Accruals</label>^ca_collections.accruals</div></ifdef>}}}
					{{{<ifdef code="ca_collections.descriptive_note"><div class="unit"><label>Descriptive Notes</label><unit relativeTo="ca_collections.descriptive_note" delimiter="<br/><br/>">^ca_collections.descriptive_note</unit></div></ifdef>}}}
					{{{<ifdef code="ca_collections.rights_container.access_conditions"><div class="unit"><label>Access Conditions</label>^ca_collections.rights_container.access_conditions</div></ifdef>}}}
					{{{<ifdef code="ca_collections.rights_container.use_reproduction"><div class="unit"><label>Use and Reproduction Conditions</label>^ca_collections.rights_container.use_reproduction</div></ifdef>}}}					
					{{{<if rule='^ca_collections.type_id =~ /File/'><ifcount code="ca_storage_locations" min="1"><div class="unit"><label>Location / Box-Folder</label>
						<unit relativeTo="ca_storage_locations" delimiter="<br/>">^ca_storage_locations.preferred_labels.name</unit>
					</div></ifcount></if>}}}
<?php
				if($vn_parent_collection_id = $t_item->get("ca_collections.parent.collection_id")){
					print "<div class='unit'>".caDetailLink($this->request, "More from this ".$t_item->get("ca_collections.parent.type_id", array("convertCodesToDisplayText" => true)), "btn btn-default", "ca_collections", $vn_parent_collection_id)."</div>";
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
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
