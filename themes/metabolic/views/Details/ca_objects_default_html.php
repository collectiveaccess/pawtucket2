<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
$t_object = 		$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_object->get('ca_objects.object_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
$media_options = $this->getVar('media_options') ?? [];

$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);
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
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-8">
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
		</div>
		<hr class="mb-0">
	</div>

	<?= $this->render('Details/snippets/detail_controls_html.php'); ?>

	<div class="row justify-content-center">

		<div class="col-sm-12 col-md-8">
			{{{media_viewer}}}
			<hr>
			<div class="bg-light py-3 px-4 mb-3"><!-- height is to make the gray background of box same height as the containing row -->
				<div class="row row-cols-1 row-cols-md-2">
					<div class="col">
										
						{{{<dl class="mb-0">

							<ifdef code="ca_objects.parent_id"><unit relativeTo="ca_objects.parent">
								<dt><?= _t('Part of Album'); ?></dt>
								<dd><l>^ca_objects.preferred_labels.name</l></dd>
							</unit></ifdef>

							<ifdef code="ca_objects.date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.date%delimiter=,_</dd>
							</ifdef>

							<ifdef code="ca_objects.idno">
								<dt><?= _t('Identifier'); ?></dt>
								<dd>^ca_objects.idno</dd>
							</ifdef>

							<ifdef code="ca_objects.altID">
								<dt><?= _t('Alternate Identifier'); ?></dt>
								<dd>^ca_objects.altID</dd>
							</ifdef>

							<ifdef code="ca_objects.description">
								<dt><?= _t('Description'); ?></dt>
								<dd>^ca_objects.description</dd>
							</ifdef>

							<ifdef code="ca_objects.url">
								<dd>
									<unit relativeTo="ca_objects.url" delimiter="<br/>">
										<a href="^ca_objects.url" target="_blank" rel="noopener">^ca_objects.url</a> 
									</unit>
								</dd>
							</ifdef>

							<ifdef code="ca_objects.dimensions.dim_width|ca_objects.dimensions.dim_height|ca_objects.dimensions.dim_depth">
								<dt><?= _t('Dimensions'); ?></dt>
								<dd>
									<unit relativeTo="ca_objects.dimensions" delimiter="; ">^dim_width
										<ifdef code='ca_objects.dimensions.dim_width,ca_objects.dimensions.dim_height'> x </ifdef>^dim_height
										<ifdef code='ca_objects.dimensions.dim_depth'> x ^dim_depth</ifdef>
										<ifdef code='ca_objects.dimensions.note'> (^note)</ifdef>
									</unit>
								</dd>
							</ifdef>

						</dl>}}}

					</div>
					<div class="col">
						{{{<dl class="mb-0">

							<?php
								if($t_object->get("ca_objects.bio_regions")){
									if($bio_links = caGetBrowseLinks($t_object, 'ca_objects.bio_regions', ['template' => '<l>^ca_objects.bio_regions</l>', 'linkTemplate' => '^LINK'])) {
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

							<?php
								if($t_object->get("ca_objects.subject")){
									if($subs = caGetBrowseLinks($t_object, 'ca_objects.subject', ['template' => '<l>^ca_objects.subject</l>', 'linkTemplate' => '^LINK'])) {
							?>
										<dt><?= _t('Themes'); ?></dt>
										<dd><?= join(", ", $subs); ?></dd>
							<?php
									}
								}
							?>
				
							<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Actions'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Actions'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>

							<ifcount code="ca_occurrences" min="1" restrictToTypes="action">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="action"><?= _t('Event'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="action"><?= _t('Events'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="action"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="exhibition"><?= _t('Exhibition'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="exhibition"><?= _t('Exhibitions'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibition"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="lecture_presentation">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="lecture_presentation"><?= _t('Lecture/Presentation'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="lecture_presentation"><?= _t('Lectures/Presentations'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="lecture_presentation"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="publication">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="publication"><?= _t('Publication'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="publication"><?= _t('Publications'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="publication"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
						</dl>}}}
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		$vs_related_title = "";
		# --- related_items - if item is part of an album, show the other siblings otherwise show some other items from the current object's action(ca_collection)
		$va_related_item_ids = array();
		if($vn_parent_id = $t_object->get("ca_objects.parent_id")){
			$t_parent = new ca_objects($vn_parent_id);
			$va_related_item_ids = $t_parent->get("ca_objects.children.object_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
			$vs_related_title = $t_parent->get("ca_objects.preferred_labels.name");
		}
		# --- remove current item
		if(in_array($vn_id, $va_related_item_ids)){
			$vn_key = array_search($vn_id, $va_related_item_ids);
			unset($va_related_item_ids[$vn_key]);
		}
		$va_related_items = array();
		if(sizeof($va_related_item_ids)){
			shuffle($va_related_item_ids);
			$q_objects = caMakeSearchResult("ca_objects", $va_related_item_ids);
	?>
			<div class="row mt-3">
				<div class="col-7 mt-5">
					<H1><?= $vs_related_title; ?></H1>
				</div>
				<div class="col-5 mt-5 text-end">
					<?php
						if($t_object->get("ca_objects.parent_id")){
							print caDetailLink($this->request, "View Album", "btn btn-primary", "ca_objects", $t_object->get("ca_objects.parent_id"));			
						}
					?>
				</div>
			</div>
			<div class="row mb-5">
		<?php
			$va_tmp_ids = array();
			$i = 0;
			while($q_objects->nextHit()){
				if($q_objects->get("ca_object_representations.media.widepreview")){
					print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
					print $q_objects->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
					print "<div class='pt-2'>".$q_objects->getWithTemplate("<if rule='^ca_objects.type_id =~ /Album/'>Album: </if>").substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30);
					
					if($alt_id = $q_objects->get('ca_objects.altID')) {
						print " (".substr(strip_tags($alt_id), 0, 30).")";
					}
					if($album_title = $q_objects->getWithTemplate("<if rule='^ca_objects.type_id =~ /Album/'><br/><l>^ca_objects.preferred_labels.name</l></if>")){
						print $album_title;
					}
					
					print "</div>";
					
					
					print "</div>";
					$i++;
					$va_tmp_ids[] = $q_objects->get("ca_objects.object_id");
				}
				if($i == 12){
					break;
				}
			}
		}
		?>
			</div>

	<!-- {{{<ifdef code="ca_objects.parent_id">
		<unit relativeTo="ca_objects.parent">
			<ifcount code="ca_objects.children" min="2"> 
				<div class="row">
					<div class="col">
						<h2>^ca_objects.type_id: ^ca_objects.preferred_labels.name</h2>
					</div>
					<div class="col text-end">
						<l class="btn btn-primary text-white" role="button">View ^ca_objects.type_id</l>
					</div>
					<hr>
				</div>
				<div class="row" id="browseResultsContainer">	
					<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_objects.parent_id:'.$t_object->get("ca_objects.parent_id"))); ?>">
						<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
					</div>
				</div>
			</ifcount>
		</unit>
	</ifdef>}}} -->