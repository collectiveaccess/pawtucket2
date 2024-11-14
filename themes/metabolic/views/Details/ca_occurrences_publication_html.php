<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
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
 
$t_item = 			$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_occurrences.occurrence_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
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
	<div class="row justify-content-center"">
		<div class="col-sm-12 col-md-8">
			<H1 class="fs-2">
				{{{<span class="text-capitalize">^ca_occurrences.type_id</span>: ^ca_occurrences.preferred_labels.name}}}
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

	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-8">
			<div class="row row-cols-1 row-cols-md-2 justify-content-center mt-3">
				<div class="col">				
					{{{<dl class="mb-0">
						<ifdef code="ca_occurrences.idno">
							<dt><?= _t('Identifier'); ?></dt>
							<dd>^ca_occurrences.idno</dd>
						</ifdef>
						<ifdef code="ca_occurrences.description">
							<dt><?= _t('About'); ?></dt>
							<dd>^ca_occurrences.description</dd>
						</ifdef>
					</dl>}}}
				</div>
				<div class="col">
					{{{<dl class="mb-0">
						<ifcount code="ca_collections" min="1">
							<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
							<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
						</ifcount>

						<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

						<ifcount code="ca_occurrences" min="1">
							<dt><ifcount code="ca_occurrences.related" min="1" max="1" restrictToTypes="action"><?= _t('Event'); ?></ifcount><ifcount code="ca_occurrences.related" min="2" restrictToTypes="action"><?= _t('Events'); ?></ifcount></dt>
							<unit relativeTo="ca_occurrences.related" delimiter="" restrictToTypes="action"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
						</ifcount>
						
						<ifcount code="ca_occurrences" min="1">
							<dt><ifcount code="ca_occurrences.related" min="1" max="1" restrictToTypes="exhibition"><?= _t('Exhibition'); ?></ifcount><ifcount code="ca_occurrences.related" min="2" restrictToTypes="exhibition"><?= _t('Exhibitions'); ?></ifcount></dt>
							<unit relativeTo="ca_occurrences.related" delimiter="" restrictToTypes="exhibition"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
						</ifcount>

						<ifcount code="ca_places" min="1">
							<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
							<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l> (^relationship_typename)</dd></unit>
						</ifcount>
					</dl>}}}					
				</div>
			</div>
		</div>
	</div>

	{{{<ifcount code="ca_objects" min="1">
		<div class="row">
			<div class="col"><h2>Related Assets</h2><hr></div>
		</div>
		<div class="row" id="browseResultsContainer">	
			<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_occurrences.occurrence_id:'.$t_item->get("ca_occurrences.occurrence_id"))); ?>">
				<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
			</div>
		</div>
	</ifcount>}}}