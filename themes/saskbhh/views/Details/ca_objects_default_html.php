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
if($t_object->get("ca_objects.culture_yn", array("convertCodesToDisplayText" => true)) == "Yes"){
	$generic_detail_cultaral_sensitivity_warning = $this->getVar("detail_cultural_sensitivity_warning");
	print '<div class="row">
				<div class="col"><div class="alert alert-danger text-center" role="alert">'.$generic_detail_cultaral_sensitivity_warning.'</div>
			</div></div>';
}

?>
	<div class="row">
		<div class="col-md-12">
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.idno"><div class="fw-medium mb-3">^ca_objects.idno</div></ifdef>}}}
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

	<div class="row">
		<div class="col-md-6">
				{{{media_viewer}}}
		</div>
		<div class="col-md-6 mb-4">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->
				<div class="row">
					<div class="col">				
						{{{<dl class="mb-0">
							<ifcount code="ca_entities" restrictToRelationshipTypes="repository" min="1">
								<dt><?= _t('Holding Repository'); ?></dt>
								<unit relativeTo="ca_entities" restrictToRelationshipTypes="repository" delimiter=" ">
									<dd><l>^ca_entities.preferred_labels</l></dd>
								</unit>
							</ifcount>
							<ifdef code="ca_objects.collector">
								<dt><?= _t('Collector'); ?></dt>
								<unit relativeTo="ca_objects.collector" delimiter=" ">
									<dd>^ca_objects.collector</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.accession_num">
								<dt><?= _t('Accession Number'); ?></dt>
								<dd>^ca_objects.accession_num</dd>
							</ifdef>
							<ifdef code="ca_objects.nonpreferred_labels">
								<dt><?= _t('Alternate Title(s)'); ?></dt>
								<dd>^ca_objects.nonpreferred_labels%delimiter=,_</dd>
							</ifdef>
<?php
							$this->setVar("restrict_to_relationship_types", array("creator", "designer", "author", "artist"));
							print $this->render("Details/snippets/related_entities_by_rel_type_html.php");
?>
							<ifdef code="ca_objects.description">
								<dt><?= _t('Description'); ?></dt>
								<dd>
									^ca_objects.description
								</dd>
							</ifdef>
							<ifdef code="ca_objects.materials">
								<dt><?= _t('Material(s)'); ?></dt>
								<dd>
									<ifdef code="ca_objects.materials">^ca_objects.materials</ifdef>
								</dd>
							</ifdef>
							<ifdef code="ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth">
								<dt><?= _t('Dimensions'); ?></dt>
								<unit relativeTo="ca_objects.dimensions" delimiter=" ">
									<dd>
										<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height<ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth"> x </ifdef></ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width<ifdef code="ca_objects.dimensions.dimensions_depth"> x </ifdef></ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth</ifdef>
									</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.date">
								<dt><?= _t('Date(s)'); ?></dt>
								<unit relativeTo="ca_objects.date" delimiter=" ">
									<dd>^ca_objects.date</dd>
								</unit>
							</ifdef>
							<ifcount code="ca_entities" restrictToRelationshipTypes="home" min="1">
								<dt><?= _t('Originating Home Community'); ?></dt>
								<unit relativeTo="ca_entities" restrictToRelationshipTypes="home" delimiter=" ">
									<dd><l>^ca_entities.preferred_labels</l></dd>
								</unit>
							</ifcount>
							<ifdef code="ca_objects.culture">
								<dt><?= _t('Cultural Affiliation'); ?></dt>
								<unit relativeTo="ca_objects.culture" delimiter=" ">
									<dd>^ca_objects.culture</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.place">
								<dt><?= _t('Geographic Place'); ?></dt>
								<unit relativeTo="ca_objects.place" delimiter=" ">
									<dd>^ca_objects.place</dd>
								</unit>
							</ifdef>
						</dl>}}}
						
					</div>
				</div>
			</div>
		
		</div>
	</div>
<?php
	if($disclaimer = $this->getVar("detail_disclaimer")){
?>
	<div class="row">
		<div class="col-md-6 offset-md-6">	
			<div class="alert alert-warning text-center mb-5" role="alert">
<?php	
		print $disclaimer;
?>
			</div>
		</div>
	</div>
<?php
	}
?>

