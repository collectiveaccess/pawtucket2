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
	<div class="row justify-content-center<?php print ($show_nav) ? " mt-2 mt-md-n3" : ""; ?>">
		<div class="col-sm-12 col-md-8">
			<H1 class="fs-2">
				{{{<ifdef code="ca_collections.type_id">
					^ca_collections.type_id: 
					</ifdef>
					^ca_collections.preferred_labels.name
				}}}
			</H1>
		</div>
		<hr class="mb-0">
	</div>
<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-8">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-0 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_collections", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_collections", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
				}
				if($copy_link_enabled){
?>
				<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium"><i class="bi bi-copy"></i> <?= _t('Copy Link'); ?></button>
<?php
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
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-8">				
			{{{<dl class="mb-0">
				<ifdef code="ca_collections.parent_id">
					<dt>Part of</dt>
					<dd><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></dd>
				</ifdef>

				<ifdef code="ca_collections.date">
					<dt><?= _t('Date'); ?></dt>
					<dd class="label">^ca_collections.date</dd>
				</ifcount>

				<ifdef code="ca_collections.description">
					<div class="collapse-text collapse" id="readMoreCollapse">
						<dt><?= _t('Description'); ?></dt>
						<dd>^ca_collections.description</dd>
					</div>
					
					<a class="btn btn-link btn-sm pb-2" data-bs-toggle="collapse" href="#readMoreCollapse" role="button" aria-expanded="false" aria-controls="readMoreCollapse">
						<span class="expand-text">+ Read more</span>
						<span class="collapse-text">- Read less</span>
					</a>
				</ifdef>
			</dl>}}}
			
			<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

			{{{<dl class="mb-0">
				<?php
					if($t_item->get("ca_collections.bio_regions")){
						if($bio_links = caGetBrowseLinks($t_item, 'ca_collections.bio_regions', ['template' => '<l>^ca_collections.bio_regions</l>', 'linkTemplate' => '^LINK'])) {
				?>
							<dt>
								<?= _t('Bio Regions'); ?>
								<a data-bs-toggle="collapse" href="#collapseBioRegions" role="button" aria-expanded="false" aria-controls="collapseBioRegions">
									<i class="bi bi-info-circle-fill"></i>
								</a>
							</dt>
							<dd>
								<div class="collapse" id="collapseBioRegions">
									<p>A region defined by characteristics of the natural environment rather than man-made division.</p>
								</div>
								<?= join(", ", $bio_links); ?>
							</dd>
				<?php
						}
					}
				?>

				<!-- <?php
					if($t_item->get("ca_collections.subject")){
						if($subs = caGetBrowseLinks($t_item, 'ca_collections.subject', ['template' => '<l>^ca_collections.subject</l>', 'linkTemplate' => '^LINK'])) {
				?>
							<dt><?= _t('Themes'); ?></dt>
							<dd><?= join(", ", $subs); ?></dd>
				<?php
						}
					}
				?> -->

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


{{{<ifcount code="ca_collections.subject" min="1">
	<div class="row"><div class="col"><h2>Themes</h2><hr/></div></div>
	<div class="row bg-light mb-5 pt-4">
		<?php
			if($t_item->get("ca_collections.subject")){
				if($subs = caGetBrowseLinks($t_item, 'ca_collections.subject', ['template' => '<div class="col-sm-6 col-md-3 pb-4"><div class="bg-info text-center py-2 text-uppercase"><l>^ca_collections.subject</l></div></div>', 'linkTemplate' => '^LINK'])) {
		?>
					<?= join("", $subs); ?>
		<?php
				}
			}
		?>
	</div>
</ifcount>}}}

<!-- {{{<ifcount code="ca_objects" min="1" restrictToTypes="album">
	<div class="row">
		<div class="col"><h2>Albums</h2><hr/></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}} -->
<!-- TODO: restrict to types by album -->

{{{<ifcount code="ca_objects" min="1">
	<div class="row">
		<div class="col"><h2>Assets</h2><hr/></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
</ifcount>}}}
