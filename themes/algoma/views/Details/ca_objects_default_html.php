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
	<div class="row">
		<div class="col text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
}
if($t_object->get("ca_objects.content_warning.check", array("convertCodesToDisplayText" => true)) == "Yes"){
	print '<div class="row">
				<div class="col"><div class="alert alert-danger text-center" role="alert">'.$t_object->get("ca_objects.content_warning.text").'</div>
			</div></div>';
}
?>
	<div class="row">
		<div class="col-md-12">
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.type_id|ca_objects.idno"><div class="fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef></div></ifdef>}}}
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
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

	
	<div class="row">
		<div class="col-md-6">
				{{{media_viewer}}}
		</div>
		<div class="col-md-6 mb-3">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->
				<div class="row">
					<div class="col">						
						{{{<dl class="mb-0">
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" restrict_to_relationship_types="part_of"><?= _t('Part of'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter="" restrict_to_relationship_types="part_of"><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
			<?php
								$this->setVar("restrict_to_relationship_types", array("contributor", "creator"));
								print $this->render("Details/snippets/related_entities_by_rel_type_html.php");
			?>
										
							<ifdef code="ca_objects.date.date_value">
								<dt><?= _t('Date'); ?></dt>
								<unit relativeTo="ca_objects.date" delimiter=" ">
									<dd>
										<ifdef code="ca_objects.date.date_value">^ca_objects.date.date_value</ifdef><ifdef code="ca_objects.date.date_value,ca_objects.date.date_note">, </ifdef><ifdef code="ca_objects.date.date_note">^ca_objects.date.date_note</ifdef>
									</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.phys_desc">
								<dt><?= _t('Physical Description'); ?></dt>
								<dd>
									^ca_objects.phys_desc
								</dd>
							</ifdef>
							<ifdef code="ca_objects.gmd">
								<dt><?= _t('General Material Designation'); ?></dt>
								<dd>
									^ca_objects.gmd%delimiter=,_
								</dd>
							</ifdef>
							<ifdef code="ca_objects.scope_content">
								<dt><?= _t('Scope and Content'); ?></dt>
								<dd>
									^ca_objects.scope_content
								</dd>
							</ifdef>
							<ifdef code="ca_objects.credit">
								<dt><?= _t('Credit'); ?></dt>
								<dd>
									^ca_objects.credit
								</dd>
							</ifdef>
							<ifdef code="ca_objects.desc_note">
								<dt><?= _t('Descriptive Notes'); ?></dt>
								<unit relativeTo="ca_objects.desc_note" delimiter=" ">
									<dd>
									^ca_objects.desc_note
									</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.language">
								<dt><?= _t('Language(s)'); ?></dt>
								<dd>
									^ca_objects.language%delimiter=,_
								</dd>
							</ifdef>
							<ifdef code="ca_objects.biblio">
								<dt><?= _t('Bibliographic Information'); ?></dt>
								<dd>
									<ifdef code="ca_objects.biblio.pub">^ca_objects.biblio.pub<ifdef code="ca_objects.biblio.volume|ca_objects.biblio.issue|ca_objects.biblio.standard">, </ifdef></ifdef>
									<ifdef code="ca_objects.biblio.volume">^ca_objects.biblio.volume<ifdef code="ca_objects.biblio.issue|ca_objects.biblio.standard">, </ifdef></ifdef>
									<ifdef code="ca_objects.biblio.issue">^ca_objects.biblio.issue<ifdef code="ca_objects.biblio.standard">, </ifdef></ifdef>
									<ifdef code="ca_objects.biblio.standard">^ca_objects.biblio.standard</ifdef>
								</dd>
							</ifdef>
							<ifdef code="ca_objects.rights.statement">
								<dt><?= _t('Rights Statement'); ?></dt>
								<dd>
									^ca_objects.rights.statement
								</dd>
							</ifdef>
							<ifdef code="ca_objects.rights.access_cond">
								<dt><?= _t('Access Conditions'); ?></dt>
								<dd>
									^ca_objects.rights.access_cond
								</dd>
							</ifdef>
							<ifdef code="ca_objects.rights.use_repro">
								<dt><?= _t('Use and Reproduction Conditions'); ?></dt>
								<dd>
									^ca_objects.rights.use_repro
								</dd>
							</ifdef>
							<ifdef code="ca_objects.rights.rights_note">
								<dt><?= _t('Additional Rights Notes'); ?></dt>
								<dd>
									^ca_objects.rights.rights_note
								</dd>
							</ifdef>
							
							<ifdef code="ca_objects.associated">
								<dt><?= _t('Associated Material'); ?></dt>
								<unit relativeTo="ca_objects.associated" delimiter=" ">
									<dd>
									^ca_objects.associated
									</dd>
								</unit>
							</ifdef>
							<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="subject">
								<dt><ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="subject"><?= _t('Subject'); ?></ifcount><ifcount code="ca_entities" min="2" restrictToRelationshipTypes="subject"><?= _t('Subjects'); ?></ifcount></dt>
								<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="subject"><dd><l>^ca_entities.preferred_labels</l></dd></unit>
							</ifcount>
							<ifcount code="ca_collections" min="1" restrictToRelationshipTypes="related">
								<dt><ifcount code="ca_collections" min="1" max="1" restrictToRelationshipTypes="related"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections" min="2" restrictToRelationshipTypes="related"><?= _t('Related Collections'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" restrictToRelationshipTypes="related" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
			
							<ifdef code="ca_objects.geographic_access">
								<dt><?= _t('Geographic Access'); ?></dt>
								<dd>
									^ca_objects.geographic_access%delimiter=,_
								</dd>
							</ifdef>
							<ifcount code="ca_places" min="1">
								<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
								<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l></dd></unit>
							</ifcount>
							
						</dl>}}}
						
					</div>
				</div>
			</div>
			<div id="map" class="map py-3">{{{map}}}</div>
		</div>
	</div>
