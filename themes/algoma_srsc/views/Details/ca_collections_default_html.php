<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2024 Whirl-i-Gig
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
$t_item = 				$this->getVar("item");
$access_values = 		$this->getVar("access_values");
$options = 				$this->getVar("config_options");
$comments = 			$this->getVar("comments");
$tags = 				$this->getVar("tags_array");
$comments_enabled = 	$this->getVar("commentsEnabled");
$pdf_enabled = 			$this->getVar("pdfEnabled");
$inquire_enabled = 		$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =					$t_item->get('ca_collections.collection_id');
$show_nav = 			($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = 			$this->getVar('mapOptions') ?? [];
$media_options = $this->getVar('media_options') ?? [];

$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);
# --- get collections configuration
$collections_config = caGetCollectionsConfig();
$show_hierarchy_viewer = true;
if($collections_config->get("do_not_display_collection_browser")){
	$show_hierarchy_viewer = false;	
}
# --- get the collection hierarchy parent to use for exportin finding aid
$top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
	pawtucketUIApps['mediaViewerManager'] = <?= json_encode($media_options); ?>;
</script>
<?php 
	if($show_nav){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
	if($t_item->get("ca_collections.content_warning.check", array("convertCodesToDisplayText" => true)) == "Yes"){
		print '<div class="row">
					<div class="col"><div class="alert alert-danger text-center" role="alert">'.$t_item->get("ca_collections.content_warning.text").'</div>
				</div></div>';
	}
?>
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_collections.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_collections.type_id|ca_collections.idno"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_collections.type_id">^ca_collections.type_id</ifdef><ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_collections", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_collections", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>
			</div>
		</div>
	</div>
<?php
	}
?>
{{{<ifcount code="ca_object_representations" min="1">
	<!--<div class="row justify-content-center mb-3 py-3 bg-light">
		<unit relativeTo="ca_object_representations" filterNonPrimaryRepresentations="0" delimiter=" ">
			<div class="col-sm-6 col-md-4 detailRepresentationGrid text-center">
				^ca_object_representations.media.large%class=object-fit-contain
			</div>
		</unit>
	</div>-->
</ifcount>}}}
{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3 py-3 bg-light">
		<div class="col-sm-12 col-md-6 bg-white">
			<div><?= $this->getVar("media_viewer"); ?></div>
		</div>
	</div>
</ifdef>}}}
	<div class="row row-cols-1 row-cols-md-2 mb-4">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifdef code="ca_collections.parent_id">
					<dt>Part of</dt>
					<dd><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></dd>
				</ifdef>
<?php
					$this->setVar("restrict_to_relationship_types", array("contributor", "creator"));
					print $this->render("Details/snippets/related_entities_by_rel_type_html.php");
?>
							
				<ifdef code="ca_collections.date.date_value">
					<dt><?= _t('Date'); ?></dt>
					<unit relativeTo="ca_collections.date" delimiter=" ">
						<dd>
							<ifdef code="ca_collections.date.date_value">^ca_collections.date.date_value</ifdef><ifdef code="ca_collections.date.date_value,ca_collections.date.date_note">, </ifdef><ifdef code="ca_collections.date.date_note">^ca_collections.date.date_note</ifdef>
						</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_collections.gmd">
					<dt><?= _t('General Material Designation'); ?></dt>
					<dd>
						^ca_collections.gmd%delimiter=,_
					</dd>
				</ifdef>
				<ifdef code="ca_collections.phys_desc">
					<dt><?= _t('Physical Description'); ?></dt>
					<dd>
						^ca_collections.phys_desc
					</dd>
				</ifdef>
				<ifdef code="ca_collections.arrangement">
					<dt><?= _t('Arrangement'); ?></dt>
					<unit relativeTo="ca_collections.arrangement" delimiter=" ">
						<dd>
							^ca_collections.arrangement
						</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_collections.language">
					<dt><?= _t('Language(s)'); ?></dt>
					<dd>
						^ca_collections.language%delimiter=,_
					</dd>
				</ifdef>
				<ifdef code="ca_collections.biblio">
					<dt><?= _t('Bibliographic Information'); ?></dt>
					<dd>
						<ifdef code="ca_collections.biblio.pub">^ca_collections.biblio.pub<ifdef code="ca_collections.biblio.volume|ca_collections.biblio.issue|ca_collections.biblio.standard">, </ifdef></ifdef>
						<ifdef code="ca_collections.biblio.volume">^ca_collections.biblio.volume<ifdef code="ca_collections.biblio.issue|ca_collections.biblio.standard">, </ifdef></ifdef>
						<ifdef code="ca_collections.biblio.issue">^ca_collections.biblio.issue<ifdef code="ca_collections.biblio.standard">, </ifdef></ifdef>
						<ifdef code="ca_collections.biblio.standard">^ca_collections.biblio.standard</ifdef>
					</dd>
				</ifdef>
				<ifdef code="ca_collections.geographic_access">
					<dt><?= _t('Geographic Access'); ?></dt>
					<dd>
						^ca_collections.geographic_access%delimiter=,_
					</dd>
				</ifdef>
				<ifdef code="ca_collections.rights.statement">
					<dt><?= _t('Rights Statement'); ?></dt>
					<dd>
						^ca_collections.rights.statement
					</dd>
				</ifdef>
				<ifdef code="ca_collections.rights.access_cond">
					<dt><?= _t('Access Conditions'); ?></dt>
					<dd>
						^ca_collections.rights.access_cond
					</dd>
				</ifdef>
				<ifdef code="ca_collections.rights.use_repro">
					<dt><?= _t('Use and Reproduction Conditions'); ?></dt>
					<dd>
						^ca_collections.rights.use_repro
					</dd>
				</ifdef>
				<ifdef code="ca_collections.rights.rights_note">
					<dt><?= _t('Additional Rights Notes'); ?></dt>
					<dd>
						^ca_collections.rights.rights_note
					</dd>
				</ifdef>
				
			</dl>}}}
		</div>
		<div class="col">
			{{{<dl class="mb-0">
				
				<ifdef code="ca_collections.scope_content">
					<dt><?= _t('Scope and Content'); ?></dt>
					<dd>
						^ca_collections.scope_content
					</dd>
				</ifdef>
				<ifdef code="ca_collections.credit">
					<dt><?= _t('Credit'); ?></dt>
					<dd>
						^ca_collections.credit
					</dd>
				</ifdef>
				<ifdef code="ca_collections.desc_note">
					<dt><?= _t('Descriptive Notes'); ?></dt>
					<unit relativeTo="ca_collections.desc_note" delimiter=" ">
						<dd>
						^ca_collections.desc_note
						</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_collections.associated">
					<dt><?= _t('Associated Material'); ?></dt>
					<unit relativeTo="ca_collections.associated" delimiter=" ">
						<dd>
						^ca_collections.associated
						</dd>
					</unit>
				</ifdef>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="subject">
					<dt><ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="subject"><?= _t('Subject'); ?></ifcount><ifcount code="ca_entities" min="2" restrictToRelationshipTypes="subject"><?= _t('Subjects'); ?></ifcount></dt>
					<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="subject"><dd><l>^ca_entities.preferred_labels</l></dd></unit>
				</ifcount>
				<ifcount code="ca_collections.related" min="1" restrictToRelationshipTypes="related">
					<dt><ifcount code="ca_collections.related" min="1" max="1" restrictToRelationshipTypes="related"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections.related" min="2" restrictToRelationshipTypes="related"><?= _t('Related Collections'); ?></ifcount></dt>
					<unit relativeTo="ca_collections.related" restrictToRelationshipTypes="related" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
				</ifcount>

				<ifcount code="ca_places" min="1">
					<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
					<unit relativeTo="ca_places" delimiter=""><dd>^ca_places.preferred_labels</dd></unit>
				</ifcount>
				<ifdef code="ca_collections.ex_pub">
					<dt><?= _t('Exhibition and Publication History'); ?></dt>
					<unit relativeTo="ca_collections.ex_pub" delimiter=" ">
						<dd>
						^ca_collections.ex_pub
						</dd>
					</unit>
				</ifdef>
				
			</dl>}}}					
		</div>
	</div>
<?php
	if ($show_hierarchy_viewer) {	
?>
		<div hx-trigger="load" hx-get="<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"  ></div>
<?php				
	}									
?>				

{{{<ifcount code="ca_collections.children" restrictToTypes="file" min="1">
<div class="row mt-5">
	<div class="col"><h2>Files in this ^ca_collections.type_id</h2><hr/></div>
</div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'files', array('search' => 'ca_collections.parent_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</ifcount>}}}
