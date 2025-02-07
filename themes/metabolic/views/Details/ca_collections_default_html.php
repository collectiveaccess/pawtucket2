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
			<H1 class="fs-1">
				{{{<ifdef code="ca_collections.type_id">
					^ca_collections.type_id: 
					</ifdef>
					^ca_collections.preferred_labels.name
				}}}
			</H1>
		</div>
		<hr class="mb-0">
	</div>

	{{{<ifdef code="ca_object_representations.media.large">
		<div class="row justify-content-center mb-3">
			<div class="col">
				<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
			</div>
		</div>
	</ifdef>}}}

	<div class="row justify-content-center mt-2">
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
		<div class="row mt-5"><div class="col"><h1>Themes</h1></div></div>
		<div class="row bg-light mb-5 pt-4">
			<?php
				if($t_item->get("ca_collections.subject")){
					if($subs = caGetBrowseLinks($t_item, 'ca_collections.subject', ['template' => '<div class="col-sm-6 col-md-3 pb-4"><div class="bg-info text-center py-2 text-uppercase"><l class="text-decoration-none">^ca_collections.subject</l></div></div>', 'linkTemplate' => '^LINK'])) {
			?>
						<?= join("", $subs); ?>
			<?php
					}
				}
			?>
		</div>
	</ifcount>}}}

	<?php		
		$va_tmp_ids = array();
		$va_related_album_ids = $t_item->get("ca_objects.object_id", array("restrictToTypes" => array("album"), "restrictToRelationshipTypes" => array("featured"), "returnAsArray" => true, "checkAccess" => $va_access_values));
		if(sizeof($va_related_album_ids)){	
			# --- related_items
			shuffle($va_related_album_ids);
			$q_objects = caMakeSearchResult("ca_objects", array_slice($va_related_album_ids,0,400));
	?>
			<div class="row mt-3">
				<div class="col-7 mt-5">
					<H1>Albums</H1>
				</div>
				<div class="col-5 mt-5 text-end">
					<?php print caNavLink($this->request, _t("View All"), "btn btn-primary", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"))); ?>
				</div>
			</div>

			<div class="row mb-3 detailRelated">
	<?php
				$i = 0;
				while($q_objects->nextHit()){
						print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
						print $q_objects->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
						$vs_idno = substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30);
						if($q_objects->get("ca_objects.preferred_labels.name")){
							$vs_title = "<br/>".$q_objects->get("ca_objects.preferred_labels.name");
						}
						print "<div class='pt-2'>".caDetailLink($this->request, $vs_idno.$vs_title, '', 'ca_objects', $q_objects->get("ca_objects.object_id"))."</div>";
						print "</div>";
						$i++;
						$va_tmp_ids[] = $q_objects->get("ca_objects.object_id");
					if($i == 12){
						break;
					}
				}
	?>
			</div>
	<?php		
		}
	?>

<?php		
	$va_related_item_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_related_item_ids)){	
		# --- related_items
		shuffle($va_related_item_ids);
		$q_objects = caMakeSearchResult("ca_objects", array_slice($va_related_item_ids,0,400));
?>
		<div class="row mt-3">
			<div class="col-7 mt-5">
				<H1>Assets</H1>
			</div>
			<div class="col-5 mt-5 text-end">
				<?php print caNavLink($this->request, "View All", "btn btn-primary", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"))); ?>
			</div>
		</div>
		<div class="row mb-3 detailRelated">
<?php
			$i = 0;
			while($q_objects->nextHit()){
				if($q_objects->get("ca_object_representations.media.widepreview")){
					print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
					print $q_objects->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
					print "<div class='pt-2'>".caDetailLink($this->request, substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30), '', 'ca_objects', $q_objects->get("ca_objects.object_id"))."</div>";
					print "</div>";
					$i++;
					$va_tmp_ids[] = $q_objects->get("ca_objects.object_id");
				}
				if($i == 12){
					break;
				}
			}
?>
		</div>
<?php		
	}
?>

<!-- {{{<ifcount code="ca_objects" min="1">
	<div class="row">
		<div class="col"><h2>Assets</h2><hr/></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
</ifcount>}}} -->
