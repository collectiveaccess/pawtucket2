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
</script>
<?php 
	if($show_nav){
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
?>
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_collections.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_collections.collection_date.collection_dates_value"><div class="fw-medium mb-2 text-capitalize">^ca_collections.collection_date.collection_dates_value</div></ifdef>}}}
			{{{<ifdef code="ca_collections.type_id|ca_collections.idno"><div class="fw-medium mb-2 text-capitalize"><ifdef code="ca_collections.type_id">^ca_collections.type_id</ifdef><ifdef code="ca_collections.idno"> (^ca_collections.idno)</ifdef></div></ifdef>}}}
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
{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col">
			<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
		</div>
	</div>
</ifdef>}}}
	<div class="row row-cols-1 row-cols-md-2 mb-4">
		<div class="col">				
			<dl class="mb-0">
				{{{<ifdef code="ca_collections.extent.extent_amount">
					<dt>Extent</dt>		
					<unit relativeTo="ca_collections.extent.extent_amount" delimiter=""><dd>^ca_collections.extent.extent_amount ^ca_collections.extent.extent_type</dd></unit>
				</ifdef>
				<ifdef code="ca_collections.parent_id">
					<dt>Part of</dt>
					<dd><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></dd>
				</ifdef>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator">
					<dt>Creator</dt>
					<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="creator"><dd>^ca_entities.preferred_labels</dd></unit>
				</ifcount>
				<ifdef code="ca_collections.scope_contents">
					<dt><?= _t('Scope and Contents'); ?></dt>
					<dd>
						^ca_collections.scope_contents
					</dd>
				</ifdef>
				<ifdef code="ca_collections.abstract">
					<dt>Abstract</dt>
					<dd>^ca_collections.abstract</dd>
				</ifdef>
				<ifdef code="ca_collections.historical_note">
					<dt>Historical Note</dt>
					<dd>^ca_collections.historical_note</dd>
				</ifdef>
				<ifdef code="ca_collections.arrangement">
					<dt>Arrangement Note</dt>
					<dd>^ca_collections.arrangement</dd>
				</ifdef>
				<ifdef code="ca_collections.gen_physical_description">
					<dt>Physical Description</dt>
					<dd>^ca_collections.gen_physical_description</dd>
				</ifdef>}}}
<?php
				$va_list_items = $t_item->get("ca_list_items", array("returnWithStructure" => true));
				if(is_array($va_list_items) && sizeof($va_list_items)){
					$va_terms = array();
					foreach($va_list_items as $va_list_item){
						$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_list_item["item_id"]));
					}
					print "<dt>Subject".((sizeof($va_terms) > 1) ? "s" : "")."</dt><dd>".join(", ", $va_terms)."</dd>";	
				}
				if($va_lcsh = $t_item->get("ca_collections.lcsh_topical", array("returnAsArray" => true))){
					if(is_array($va_lcsh) && sizeof($va_lcsh)){
						print "<dt>Topics, Library of Congress Authority</dt>";
						print "<dd>";
						$i = 0;
						foreach($va_lcsh as $vs_lcsh){
							$va_tmp = explode(" [", $vs_lcsh);
							print $va_tmp[0];
							$i++;
							if($i < sizeof($va_lcsh)){
								print ", ";
							}
						}
						print "</dd>";
					}
				}
				if($va_lcsh_geo = $t_item->get("ca_collections.lcsh_geo", array("returnAsArray" => true))){
					if(is_array($va_lcsh_geo) && sizeof($va_lcsh_geo)){
						print "<dt>Geographical Areas, Library of Congress Authority</dt>";
						print "<dd>";
						$i = 0;
						foreach($va_lcsh_geo as $vs_lcsh_geo){
							$va_tmp = explode(" [", $vs_lcsh_geo);
							print $va_tmp[0];
							$i++;
							if($i < sizeof($va_lcsh_geo)){
								print ", ";
							}
						}
						print "</dd>";
					}
				}
?>
			</dl>
		</div>
		<div class="col">
			{{{<dl class="mb-0">
				<ifdef code="ca_collections.access_restrictions">
					<dt>Access Restrictions</dt>
					<dd>^ca_collections.access_restrictions</dd>
				</ifdef>
			    <ifdef code="ca_collections.user_restrictions">
					<dt>User Restrictions</dt>
					<dd>^ca_collections.user_restrictions</dd>
				</ifdef>
			    <ifdef code="ca_collections.preferred_citation">
					<dt>Preferred Citation</dt>
					<dd>^ca_collections.preferred_citation</dd>
				</ifdef>
			    <ifdef code="ca_collections.externalLink.url_entry">
					<dt>External Links</dt>
					<unit relativeTo="ca_collections" delimiter="">
						<dd><a href="^ca_collections.externalLink.url_entry" target="_blank">^ca_collections.externalLink.url_source</a></dd>
					</unit>
				</ifdef>		        
				<ifcount code="ca_collections.related" min="1">
					<dt><ifcount code="ca_collections.related" min="1" max="1"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections.related" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
					<unit relativeTo="ca_collections.related" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
				</ifcount>
				<ifcount code="ca_entities" min="1">
					<dt><ifcount code="ca_entities" min="1" max="1"><?= _t('Related Person'); ?></ifcount><ifcount code="ca_entities" min="2"><?= _t('Related People'); ?></ifcount></dt>
					<unit relativeTo="ca_entities" delimiter=""><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" min="1" restrictToTypes="work">
					<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="work"><?= _t('Related Work'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="work"><?= _t('Related Works'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="work"><dd><l>^ca_occurrences.preferred_labels</l></dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" min="1" restrictToTypes="project">
					<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="project"><?= _t('Related Project'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="project"><?= _t('Related Projects'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="project"><dd><l>^ca_occurrences.preferred_labels</l></dd></unit>
				</ifcount>
				<ifcount code="ca_places" min="1">
					<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
					<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>
				
				
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
{{{<ifcount code="ca_objects" min="1">
<div class="row">
	<div class="col"><h2>Related Objects</h2><hr/></div>
</div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</ifcount>}}}
