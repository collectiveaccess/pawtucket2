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
$id =				$t_object->getPrimaryKey();
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
$media_options = $this->getVar('media_options') ?? [];

$lightboxes = $this->getVar('lightboxes') ?? [];
$in_lightboxes = $this->getVar('inLightboxes') ?? [];

$metadata_access = $this->getVar('metadataAccess');

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
	<div class="row">
		<div class="col-md-12">
			{{{<ifdef code="ca_objects.type_id|ca_objects.idno">
				<H1 class="fs-5 fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.bm_number">, ^ca_objects.bm_number</ifdef></H1>
			</ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if(caDisplayLightbox($this->request) || $inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>				
			</div>
			<?= $this->render('Details/snippets/lightbox_list_html.php'); ?>
		</div>
	</div>
<?php
	}
?>

	<div class="row my-4">
		<div class="col-md-7">
			{{{media_viewer}}}
		</div>
		<div class="col-md-5">
			<div class="bg-light py-3 px-4 h-100"><!-- height is to make the gray background of box same height as the containing row -->				
				<div class="mb-3">
					{{{
						<dl class="mb-0">
							<ifdef code="ca_objects.preferred_labels">
								<dd><i>^ca_objects.preferred_labels</i></dd>
							</ifdef>

							<ifdef code="ca_objects.print_date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.print_date</dd>
							</ifdef>
							
							<ifdef code="ca_objects.medium.medium_notes_text">
								<dt><?= _t('Medium'); ?></dt>
								<dd>^ca_objects.medium.medium_notes_text</dd>
							</ifdef>

							<ifdef code="ca_objects.master_dimensions">
								<dt><?= _t('Master Dimensions'); ?></dt>
								<dd>^ca_objects.master_dimensions</dd>
							</ifdef>

							<!-- TODO: Admin Only -->
<?php if(in_array('extended', $metadata_access)) { ?>

							<ifdef code="ca_objects.sort_number">
								<dt><?= _t('Number in CR'); ?></dt>
								<dd>^ca_objects.sort_number</dd>
							</ifdef>

							<ifdef code="ca_objects.inscription_text">
								<dt><?= _t('Inscription'); ?></dt>
								<dd>^ca_objects.inscription_text</dd>
							</ifdef>

							<ifcount code="ca_objects_x_entities" restrictToRelationshipTypes="provenance"  min="1">
								<dt><?= _t('Provenance'); ?></dt>
							</ifdef>
							<dd>
								<unit relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="provenance" sort="ca_objects_x_entities.rank" sortDirection="ASC" delimiter="">
									<div style="margin-bottom: 10px;"><ifdef code="ca_objects_x_entities.interstitial_notes">^ca_objects_x_entities.interstitial_notes</ifdef><ifnotdef code="ca_objects_x_entities.interstitial_notes"><ifdef code="ca_entities.preferred_labels">[^ca_entities.preferred_labels]</ifdef></ifnotdef></div></unit>
							</dd>

							<ifcount code="ca_objects_x_occurrences"  restrictToTypes="exhibition" skipIfExpression="^ca_occurrences.solo_group !~ /solo/" min="1">
								<dt><?= _t('Solo Exhibitions'); ?></dt>
								<dd>
									<unit relativeTo="ca_objects_x_occurrences" restrictToTypes="exhibition" skipIfExpression="^ca_occurrences.solo_group !~ /solo/" delimiter="<br>" >
										<unit relativeTo="ca_occurrences">
												<unit relativeTo="ca_entities_x_occurrences" delimiter="/" restrictToRelationshipTypes="venue" sort="ca_entities_x_occurrences.common_date" sortDirection="ASC">
														<l relativeTo='ca_occurrences'>^ca_entities.preferred_labels</l><if rule="(^ca_entities.location_display.city_display =~ /yes/)">, ^ca_entities.address.city</if><if rule="(^ca_entities.location_display.state_display =~ /yes/)">, ^ca_entities.address.stateprovince</if><if rule="(^ca_entities.location_display.country_display =~ /yes/)">, ^ca_entities.address.country</if></unit>, ^ca_occurrences.exhibition_year</unit><ifdef code="ca_objects_x_occurrences.interstitial_notes"> [^ca_objects_x_occurrences.interstitial_notes]</ifdef></unit>
								</dd>
							</ifcount>

							<ifcount code="ca_objects_x_occurrences"  restrictToTypes="exhibition" skipIfExpression="^ca_occurrences.solo_group !~ /group/" min="1">
								<dt><?= _t('Group Exhibitions'); ?></dt>
								<dd>
									<unit relativeTo="ca_objects_x_occurrences" restrictToTypes="exhibition" skipIfExpression="^ca_occurrences.solo_group !~ /group/" delimiter="<br>">
										<unit relativeTo="ca_occurrences"><unit relativeTo="ca_entities_x_occurrences" delimiter="/" restrictToRelationshipTypes="venue" sort="ca_entities_x_occurrences.common_date" sortDirection="ASC">
													<l relativeTo='ca_occurrences'>^ca_entities.preferred_labels</l><if rule="(^ca_entities.location_display.city_display =~ /yes/)">, ^ca_entities.address.city</if><if rule="(^ca_entities.location_display.state_display =~ /yes/)">, ^ca_entities.address.stateprovince</if><if rule="(^ca_entities.location_display.country_display =~ /yes/)">, ^ca_entities.address.country</if></unit>, ^ca_occurrences.exhibition_year</unit><ifdef code="ca_objects_x_occurrences.interstitial_notes"> [^ca_objects_x_occurrences.interstitial_notes]</ifdef></unit>
								</dd>
							</ifcount>

							<if rule="^ca_occurrences.status !~ /not for publication/i">
								<ifcount code="ca_objects_x_occurrences"  restrictToTypes="literature" min="1">
									<dt><?= _t('Literature'); ?></dt>
									<dd>
										<unit relativeTo="ca_objects_x_occurrences" sort="ca_occurrences.pub_date" sortDirection="ASC" restrictToTypes="literature" delimiter="<br>">
											<unit relativeTo="ca_occurrences"><l>
												<ifnotdef code="ca_occurrences.citation_abbreviated">[^ca_occurrences.preferred_labels]</ifnotdef>^ca_occurrences.citation_abbreviated%stripEnclosingParagraphTags=1</l></unit><ifdef code="ca_objects_x_occurrences.citation">: ^ca_objects_x_occurrences.citation%stripEnclosingParagraphTags=1</ifdef><ifdef code="ca_objects.citation_abbreviated">: ^ca_objects_x_occurrences.citation%stripEnclosingParagraphTags=1</ifdef><if rule="^ca_objects_x_occurrences.illustrated =~ /yes/i"> (illustrated)</if><ifdef code="ca_objects_x_occurrences.bib_notes">.  [^ca_objects_x_occurrences.bib_notes%stripEnclosingParagraphTags=1]</ifdef>
											<ifdef code="ca_objects_x_occurrences.bib_notes">]</ifdef>
										</unit>
									</dd>
								</ifcount>
							</if>

							<ifdef code="ca_objects.nonpreferred_labels">
								<dt><?= _t('Alternate Title'); ?></dt>
								<dd>^ca_objects.nonpreferred_labels</dd>
							</ifdef>

							<ifdef code="ca_objects.creation_location">
								<dt><?= _t('Studio'); ?></dt>
								<dd>^ca_objects.creation_location</dd>
							</ifdef>

							<ifdef code="ca_objects.notes">
								<dt><?= _t('Notes'); ?></dt>
								<dd>^ca_objects.notes</dd>
							</ifdef>
<?php } ?>
						</dl>
					}}}
				</div>
			</div>
		</div>
	</div>