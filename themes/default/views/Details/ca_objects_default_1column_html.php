<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2023 Whirl-i-Gig
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
	$t_object = 			$this->getVar("item");
	$va_options = 			$this->getVar("config_options");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$vb_show_nav = ($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
?>


<?php
	if($vb_show_nav){
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div>
	</div>
<?php
	}
?>
	<div class="row<?php print ($vb_show_nav) ? " mt-2 mt-md-n3" : ""; ?>">
		<div class="col-md-12">
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.type_id|ca_objects.idno"><div class="fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0"/>
		</div>
	</div>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")));
				if ($vn_pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
				}
?>
				<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium"><i class="bi bi-copy"></i> <?= _t('Copy Link'); ?></button>
			</div>
		</div>
	</div>
{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col">
			<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
		</div>
	</div>
</ifdef>}}}
	<div class="row">
		<div class="col">
			<div class="bg-body-tertiary py-3 px-4 mb-3">
				<div class="row row-cols-1 row-cols-md-3 gx-5">
					<div class="col">				
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.date.dates_value (^ca_objects.date.dates_type)</dd>
							</ifdef>
		
							<ifdef code="ca_objects.colorType">
								<dt><?= _t('Color'); ?></dt>
								<dd>^ca_objects.colorType</dd>
							</ifdef>
							<ifdef code="ca_objects.inscription">
								<dt><?= _t('Inscription'); ?></dt>
								<dd>^ca_objects.inscription</dd>
							</ifdef>
							<ifdef code="ca_objects.work_description">
								<dt><?= _t('Description'); ?></dt>
								<dd>
									^ca_objects.work_description
								</dd>
							</ifdef>
						</dl>}}}
						<!-- {{{<ifdef code="ca_objects.work_description">
							<div class='unit'>
								<h6><?= _t('Description'); ?></h6>
								<div class="trim collapse" id="collapseExample">
									^ca_objects.work_description
								</div>
								<a class="btn btn-light btn-sm mt-2 read-more-btn" role="button" data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
					
								</a>
							</div>
						</ifdef>}}} -->
					</div>
					<div class="col">
<?php
						print $this->render("Details/snippets/related_entities_by_rel_type_html.php");
?>
						{{{<dl class="mb-0">
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collection'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
				
							<ifcount code="ca_entities" min="1">
								<dt><ifcount code="ca_entities" min="1" max="1"><?= _t('Related Person'); ?></ifcount><ifcount code="ca_entities" min="2"><?= _t('Related People'); ?></ifcount></dt>
								<unit relativeTo="ca_entities" delimiter=""><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>

							<ifcount code="ca_occurrences" min="1">
								<div class="unit">
									<dt><ifcount code="ca_occurrences" min="1" max="1"><?= _t('Related Occurrence'); ?></ifcount><ifcount code="ca_occurrences" min="2"><?= _t('Related Occurrences'); ?></ifcount></dt>
									<unit relativeTo="ca_occurrences" delimiter=""><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
								</div>
							</ifcount>

							<ifcount code="ca_places" min="1">
								<div class="unit">
									<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
									<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l> (^relationship_typename)</dd></unit>
								</div>
							</ifcount>
						</dl>}}}					
					</div>
					<div class="col">
						Map would go here {{{map}}}
					</div>
				</div>
			</div>
		</div>
	</div>
	{{{<dl class="row">
		<ifcount code="ca_entities" min="1">
			<dt class="col-12 mt-3 mb-2">These links need to be changed to have classes passed in l tags<ifcount code="ca_entities" min="1" max="1"><?= _t('Related person'); ?></ifcount><ifcount code="ca_entities" min="2"><?= _t('Related people'); ?></ifcount></dt>
			<unit relativeTo="ca_entities" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_entities.preferred_labels<br/>^relationship_typename</a></dd></unit>
		</ifcount>
	</dl>}}}
	<dl class="row">
		<dt class="col-12 mt-3 mb-2">Related People</dt>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person<br/>second link</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
		<dt class="col-12 mt-3 mb-2">Related People</dt>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person<br/>second link</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
			<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd> 	
	</dl>
