<?php
/* ----------------------------------------------------------------------
 * themes/art21/views/Details/ca_collections_series_html.php : 
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

$result_desc =			$this->getVar('resultDesc');

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
			{{{<ifdef code="ca_collections.type_id|ca_collections.idno"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_collections.type_id">^ca_collections.type_id</ifdef><ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="toolbar" aria-label="Detail Controls">
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
	<div class="row justify-content-center mb-3">
		<div class="col-lg-8">
			<a name="viewerContainer"></a>
			<div>{{{media_viewer}}}</div>
		</div>
		<div class="col-lg-4" id="transcriptCol">
<?php
	# --- only display this div if there are results or a transcript
?>
			<div class="bg-light px-4 pt-3 pb-5 h-100 position-relative"><!-- height is to make the gray background of box same height as the containing row -->
				<dl class="position-relative h-100">
					<dt><?php print _t("Transcript"); ?></dt>
					<dd class="position-relative h-100">
						<div class="h-100 w-100 overflow-scroll position-absolute top-0 bottom-0">
<?php
	$resultDescWordList = $this->getVar('resultDescWordList');
	if(is_array($resultDescWordList) && sizeof($resultDescWordList)){
?>
							<div id="transcriptSearchResultList" class="fw-bolder mt-1 fs-5"><?= _t("Jump to Search Terms"); ?></div>
							<div class="list-group mb-3 mt-1" aria-labelledby="transcriptSearchResultList">		
<?php
		$tc = new TimecodeParser();
		foreach($resultDescWordList ?? [] as $w) {
			if((int)$w['start'] <= 0) { continue; }
			$tc->parse($w['start']);
			print "<a href='#viewerContainer' class='list-group-item list-group-item-action search-term-timecode' onclick='seek(this, {$w['representation_id']}, {$w['start']})'>".$w['text'].' ('.$tc->getText().')</a>';
		}
?>
							</div>
<?php
	}
?>			

							<div id="transcript"></div>
						</div>
					</dd>
				</dl>
			</div>
		</div>
	</div>
	<div class="bg-light py-3 px-4 mb-3">
		<div class="row row-cols-1 row-cols-md-3 gx-5">
			<div class="col">				
				{{{<dl class="mb-0">
					<ifdef code="ca_collections.work_date">
						<dt><?= _t('Date'); ?></dt>
						<dd>^ca_collections.work_date</dd>
					</ifdef>
					<ifdef code="ca_collections.tot_duration">
						<dt><?= _t('Total Duration'); ?></dt>
						<dd>^ca_collections.tot_duration</dd>
					</ifdef>
					<ifdef code="ca_collections.parent_id">
						<dt>Project</dt>
						<dd><unit relativeTo="ca_collections.parent"><l>^ca_collections.preferred_labels.name</l></unit></dd>
					</ifdef>
				</dl>}}}
			</div>
			<div class="col">
				{{{<dl class="mb-0">
					<ifcount code="ca_entities" restrictToRelationshipTypes="crew" min="1">
						<dt><?= _t('Crew'); ?></dt>
						<unit relativeTo="ca_entities_x_collections" restrictToRelationshipTypes="crew" delimiter=""><dd>^ca_entities.preferred_labels - ^ca_entities_x_collections.crew_role%delimiter=,_</dd></unit>
					</ifcount>
					<ifcount code="ca_places" min="1">
						<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Location'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Locations'); ?></ifcount></dt>
						<unit relativeTo="ca_places" delimiter=""><dd>^ca_places.preferred_labels
							<ifdef code='ca_places.address'><unit relativeTo='ca_places.address' delimiter='<br/>'>
								<ifdef code="ca_places.address.address1"><br/>^ca_places.address.address1</ifdef>
								<ifdef code="ca_places.address.city|ca_places.address.stateprovince|ca_places.address.postalcode|ca_places.address.country"><br/>^ca_places.address.city<ifdef code="ca_places.address.stateprovince,ca_places.address.city">, </ifdef>^ca_places.address.stateprovince<ifdef code="ca_places.address.postalcode"><ifdef code="ca_places.address.stateprovince|ca_places.address.city"> </ifdef>^ca_places.address.postalcode</ifdef><ifdef code="ca_places.address.country"><ifdef code="ca_places.address.stateprovince|ca_places.address.city|ca_places.address.postalcode">, </ifdef>^ca_places.address.country</ifdef>
							</ifdef>
						</unit></dd></unit>
					</ifcount>
				</dl>}}}
			</div>
			<div class="col">
				<div id="map" class="map py-3">{{{map}}}</div>
			</div>
		</div>
	</div>				

{{{<ifcount code="ca_objects" min="1">
	<div class="row mt-5">
		<div class="col"><h2>Footage</h2><hr/></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"), '_advanced' => 0, 'view' => 'list')); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}

<?php
if ($show_hierarchy_viewer) {	
?>
	<div class="row mt-5">
		<div class="col"><h2>Other Shoots in <?php print $t_item->getWithTemplate("<unit relativeTo='ca_collections.parent'><l>^ca_collections.preferred_labels.name</l></unit>"); ?></h2></div>
	</div>
		<div hx-trigger="load" hx-get="<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('ca_collections.parent.collection_id'))); ?>"  ></div>
<?php				
}									
?>

			
	<script>
		function seek(e, id, t) {
			document.querySelectorAll('.search-term-timecode').forEach(el => el.setAttribute('aria-current', 'false'));
			document.querySelectorAll('.search-term-timecode').forEach(el => el.classList.remove('active'));
			e.classList.add('active');
			const m = pawtucketUIApps['mediaViewerManager']['instance'];
			
			// Switch to video
			m.renderByID(id);
			if(!m) { return; }
			const v = m.getCurrentViewer();
			if(!v) { return; }
			
			// Seek to just before word
			v.seek(t-1);
			
			// Make sure video is now playing
			//v.play();
		}
	</script>