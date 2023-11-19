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
	$vn_id = $t_item->get('ca_collections.collection_id');
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
<?php
					#$vs_finding_aid = array();
					$va_anchors = array();
					if ($t_item->get('ca_collections.repository.repositoryName')) {
						if ($vs_repository = $t_item->get('ca_collections.repository', array('template' => '<ifdef code="ca_collections.repository.repositoryName"><b>Repository Name: </b></ifdef> ^ca_collections.repository.repositoryName <ifdef code="ca_collections.repository.repositoryLocation"><br/><b>Repository Location: </b></ifdef> ^ca_collections.repository.repositoryLocation', 'delimiter' => '<br/>'))) {
							$va_anchors[] = "<a href='#repository'>Repository</a>";
							$vs_finding_aid= "<div class='unit'><label><a name='repository'>Repository</a></label>".$vs_repository."</div>";
						}
					}
					if ($vs_desc = $t_item->get('ca_collections.description.description_text', array('delimiter' => '<br/>'))) {
						$vs_finding_aid.= "<div class='unit'><label>Description</label>".$vs_desc."</div>";
					}	
					if ($t_item->get('ca_collections.date.date_value')) {
						if ($vs_date = $t_item->get('ca_collections.date', array('delimiter' => '<br/>', 'template' => '<unit>^ca_collections.date.date_value ^ca_collections.date.date_types <ifdef code="ca_collections.date.date_notes"><br/>^ca_collections.date.date_notes</ifdef></unit>', 'convertCodesToDisplayText' => true))) {
							$va_anchors[] = "<a href='#date'>Date</a>";
							$vs_finding_aid.= "<div class='unit'><label><a name='date'>Date</a></label>".$vs_date."</div>";
						}
					}
					if ($vs_extent = $t_item->get('ca_collections.extent_text')) {
						$va_anchors[] = "<a href='#extent'>Extent</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='extent'>Extent</a></label>".$vs_extent."</div>";
					}
					if ($vs_creator = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> ^relationship_type</unit>')) {
						$va_anchors[] = "<a href='#creator'>Creator</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='creator'>Creator</a></label>".$vs_creator."</div>";
					}
					if ($vs_agency = $t_item->get('ca_collections.agencyHistory')) {
						$va_anchors[] = "<a href='#history'>Agency History</a>";
						$vs_finding_aid.= "<div class='unit'><label><a href='agency'>Agency History</a></label>".$vs_agency."</div>";
					}
					if ($vs_abstract = $t_item->get('ca_collections.abstract')) {
						$va_anchors[] = "<a href='#abstract'>Abstract</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='abstract'>Abstract</a></label>".$vs_abstract."</div>";
					}
					if ($vs_citation = $t_item->get('ca_collections.preferCite')) {
						$va_anchors[] = "<a href='#citation'>Preferred Citation</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='citation'>Preferred Citation</a></label>".$vs_citation."</div>";
					}
					if ($vs_custodhist = $t_item->get('ca_collections.custodhist')) {
						$va_anchors[] = "<a href='#custodhist'>Custodial history</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='custodhist'>Custodial history</a></label>".$vs_custodhist."</div>";
					}
					if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
						$va_anchors[] = "<a href='#acqinfo'>Immediate Source of Acquisition</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='acqinfo'>Immediate Source of Acquisition</a></label>".$vs_acqinfo."</div>";
					}
					if ($vs_accruals = $t_item->get('ca_collections.accruals')) {
						$va_anchors[] = "<a href='#accruals'>Accruals</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='accruals'>Accruals</a></label>".$vs_accruals."</div>";
					}	
					if ($vs_provenance = $t_item->get('ca_collections.provenance')) {
						$va_anchors[] = "<a href='#provenance'>Provenance</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='provenance'>Provenance</a></label>".$vs_provenance."</div>";
					}
					if ($vs_origin = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('origin')))) {
						$va_anchors[] = "<a href='#origin'>Origin of Acquisition</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='origin'>Origin of Acquisition</a></label>".$vs_origin."</div>";
					}					
					if ($vs_accessioned = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('accession')))) {
						$va_anchors[] = "<a href='#accessioned'>Accessioned by</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='accessioned'>Accessioned by</a></label>".$vs_accessioned."</div>";
					}	
					if ($va_acc_method = $t_item->get('ca_collections.acquisition_method', array('convertCodesToDisplayText' => true))){
						$va_anchors[] = "<a href='#acquisition'>Acquisition method</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='acquisition'>Acquisition method</a></label>".$va_acc_method."</div>";
					}
					if ($vs_scopecontent = $t_item->get('ca_collections.scopecontent')) {
						$va_anchors[] = "<a href='#scope'>Scope and content</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='scope'>Scope and content</a></label>".$vs_scopecontent."</div>";
					}	
					if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
						$va_anchors[] = "<a href='#arrangement'>System of arrangement</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='arrangement'>System of arrangement</a></label>".$vs_arrangement."</div>";
					}
					if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict')) {
						$va_anchors[] = "<a href='#accessrestrict'>Conditions governing access</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='accessrestrict'>Conditions governing access</a></label>".$vs_accessrestrict."</div>";
					}
					if ($vs_physaccessrestrict = $t_item->get('ca_collections.physaccessrestrict')) {
						$va_anchors[] = "<a href='#physaccessrestrict'>Physical access</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='physaccessrestrict'>Physical access</a></label>".$vs_physaccessrestrict."</div>";
					}
					if ($vs_techaccessrestrict = $t_item->get('ca_collections.techaccessrestrict')) {
						$va_anchors[] = "<a href='#techaccessrestrict'>Technical access</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='techaccessrestrict'>Technical access</a></label>".$vs_techaccessrestrict."</div>";
					}
					if ($vs_reproduction_conditions = $t_item->get('ca_collections.reproduction_conditions')) {
						$va_anchors[] = "<a href='#reprocon'>Conditions governing reproduction</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='reprocon'>Conditions governing reproduction</a></label>".$vs_reproduction_conditions."</div>";
					}
					if ($vs_langmaterial = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_collections.langmaterial.material ^ca_collections.langmaterial.language1</unit>')) {
						$va_anchors[] = "<a href='#langmaterial'>Languages and scripts on the material</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='langmaterial'>Languages and scripts on the material</a></label>".$vs_langmaterial."</div>";
					}	
					if ($vs_otherfindingaid = $t_item->get('ca_collections.otherfindingaid')) {
						$va_anchors[] = "<a href='#otherfindingaid'>Other finding aids</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='otherfindingaid'>Other finding aids</a></label>".$vs_otherfindingaid."</div>";
					}
					if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc')) {
						$va_anchors[] = "<a href='#originalsloc'>Existence and location of originals</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='originalsloc'>Existence and location of originals</a></label>".$vs_originalsloc."</div>";
					}	
					if ($vs_altformavail = $t_item->get('ca_collections.altformavail')) {
						$va_anchors[] = "<a href='#altformavail'>Existence and location of copies</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='altformavail'>Existence and location of copies</a></label>".$vs_altformavail."</div>";
					}
					if ($vs_relatedmaterial = $t_item->get('ca_collections.relatedmaterial')) {
						$va_anchors[] = "<a href='#relatedmaterial'>Related archival materials</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='relatedmaterial'>Related archival materials</a></label>".$vs_relatedmaterial."</div>";
					}
					if ($vs_bibliography = $t_item->get('ca_collections.bibliography')) {
						$va_anchors[] = "<a href='#bibliography'>Publication note</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='bibliography'>Publication note</a></label>".$vs_bibliography."</div>";
					}
					$va_subjects_list = array();
					if ($va_subject_terms = $t_item->get('ca_collections.lcsh_terms', array('returnAsArray' => true))) {
						foreach ($va_subject_terms as $va_term => $va_subject_term) {
							if(trim($va_subject_term)){
								$va_subject_term_list = explode('[', $va_subject_term);
								$va_subjects_list[] = ucfirst($va_subject_term_list[0]);
							}
						}
					}
					if ($va_subject_terms_text = $t_item->get('ca_collections.lcsh_terms_text', array('returnAsArray' => true))) {
						foreach ($va_subject_terms_text as $va_text => $va_subject_term_text) {
							if(trim($va_subject_term_text)){
								$va_subjects_list[] = ucfirst($va_subject_term_text);
							}
						}
					}
					if ($va_subject_genres = $t_item->get('ca_collections.lcsh_genres', array('returnAsArray' => true))) {
						foreach ($va_subject_genres as $va_text => $va_subject_genre) {
							if(trim($va_subject_genre)){
								$va_subjects_list[] = ucfirst($va_subject_genre);
							}
						}
					}											
					asort($va_subjects_list);
					if ($va_subjects_list) {
						$va_anchors[] = "<a href='#subjects'>Subject - keywords and LC headings</a>";
						$vs_finding_aid.= "<div class='unit'><label><a name='subjects'>Subject - keywords and LC headings</a></label>".join("<br/>", $va_subjects_list)."</div>";
					}
					$vs_finding_aid.= $vs_buf;	
					if($t_item->get('ca_collections.children.collection_id')){
						$va_anchors[] = "<a href='#contents'>Collection Contents</a>";
						
					}
			if(is_array($va_anchors) && sizeof($va_anchors)){																																																																																																																																	
?>
				<div class='col-sm-3 col-md-3 col-lg-3'>
					<div class='contentsTable'>
						<H3>Table of Contents</H3>
<?php
					print join('<br/>', $va_anchors);
?>
					</div><!-- end contentsTable-->
				</div><!-- end col -->
				<div class='col-sm-9 col-md-9 col-lg-9'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php			
			}
					print caNavLink($this->request, 'Download Finding Aid <i class="fa fa-chevron-right"></i>', 'faDownload', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary');

?>				
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<h2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.collection_number">, ^ca_collections.collection_number</ifdef>}}}</h2>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}

<?php					
						print $vs_finding_aid;
?>	
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print is_array($va_comments) ? sizeof($va_comments) : 0; ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					</div><!-- end detailTools -->				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php
			if ($vb_show_hierarchy_viewer) {	
?>
				<a name="contents"></a><div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
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
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<label>Loading</label>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id', 'sort' => 'Rank'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<label>Loading</label>',
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