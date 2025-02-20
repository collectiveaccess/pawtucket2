<?php
/* ----------------------------------------------------------------------
 * themes/decimal/views/Contribute/students_html.php : sample Contribute form
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2025 Whirl-i-Gig
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
 # --- look up: need to style; width being passed is not set - prob don't need that anyway
 # --- errors - no fields are required - we should - when there is an erorr like bad date, general error appears at top, but not above the field
 # --- how put multiple - like Materials if I want multiple dropdowns isn't working
 # --- pass class to media upload input
 
$t_subject = $this->getVar('t_subject');
$form_info = $this->getVar('form_info');
?>
		<div class="contributeForm">
			<h1><div class="float-start pe-3">
				<?= caNavLink($this->request, '<i class="bi bi-chevron-left"></i>', 'btn btn-secondary btn-sm', '*', '*', 'Index', null, array("aria-label" => _t('Back to list'), "title" => _t('Back to list')));?>
			</div><?= _t("Contribute"); ?></h1>
			
			<div class="py-3">
				Submit metadata for your artifact using the form below. 
				It will be made visible on the site once it's been reviewed and edited.
			</div>
			
			{{{<ifdef code="errors"><div class="notificationMessage">^errors</div></ifdef>}}}
			<div class="bg-light px-4 py-4 mb-4">
				<h2><?= $form_info["formTitle"]; ?></h2>
				{{{form}}}
					<div class='row mt-3'>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_entities:error}}}
							<label class='form-label' for=''>Repository name</label><br/>
							{{{ca_entities%autocomplete=1&width=350px&relationshipType=repository&index=0&placeholder=Search+for+repository}}}
						</div>										
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.accession_num:error}}}
							<label class='form-label' for='ca_objects_accession_num'>Repository accession number</label>
							{{{ca_objects.accession_num%&class=form-control w-100}}}
						</div>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.storage:error}}}
							<label class='form-label' for='ca_objects_accession_num'>Repository storage location</label>
							{{{ca_objects.storage%&class=form-control w-100}}}
						</div>
					</div>
					<div class='row'>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.preferred_labels:error}}}
							<label class='form-label' for='ca_objects_preferred_labels_name'>Title</label>
							{{{ca_objects.preferred_labels.name%&class=form-control w-100}}}
						</div>										
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.collector:error}}}
							<label class='form-label' for=''>Original collector</label><br/>
							{{{ca_objects.collector%&class=form-control w-100}}}
						</div>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_entities:error}}}
							<label class='form-label' for=''>Creator(s)</label><br/>
							{{{ca_entities%autocomplete=1&width=200px&relationshipType=creator&index=0&placeholder=Search+for+creator}}}
						</div>
					</div>
					<div class='row'>										
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.material.material_generated:error}}}
							<label class='form-label' for=''>Material(s)</label>
							<div class="mb-2">{{{ca_objects.material.material_generated%class=form-select w-100}}}</div>
							<div class="mb-2">{{{ca_objects.material.material_generated%class=form-select w-100}}}</div>
						</div>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.dimensions.measurement_notes:error}}}
							<label class='form-label' for=''>Measurements</label>
							{{{ca_objects.dimensions.measurement_notes%class=form-control w-100}}}
						</div>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.marksLabel:error}}}
							<label class='form-label' for=''>Marks, labels, or inscriptions</label>
							{{{ca_objects.marksLabel%class=form-control w-100}}}
						</div>
					</div>
					<div class='row'>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.culture_notes:error}}}
							<label class='form-label' for=''>Associated Indigenous culture</label>
							{{{ca_objects.culture_notes%class=form-control w-100}}}
						</div>										
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.sensitive.yn:error}}}
							<label class='form-label' for=''>Is the object culturally sensitive?</label>
							{{{ca_objects.sensitive.yn%class=form-select w-100}}}
						</div>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.sensitive.details:error}}}
							<label class='form-label' for=''>Details about cultural sensitivity</label>
							{{{ca_objects.sensitive.details%class=form-control w-100}}}
						</div>
					</div>
					<div class='row'>
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.date.range:error}}}
							<label class='form-label' for=''>Estimated date created</label>
							{{{ca_objects.date.range%class=form-control w-100}}}
						</div>										
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.description:error}}}
							<label class='form-label' for=''>Description</label>
							{{{ca_objects.description%class=form-control w-100}}}
						</div>										
						<div class="col-sm-12 col-md-4 mb-3">
							{{{ca_objects.place_notes:error}}}
							<label class='form-label' for=''>Associated geographic place</label>
							<div class="mb-2">{{{ca_objects.place_notes%class=form-control w-100}}}</div>
						</div>
					</div>
					
					<div class='row'>
						<div class="col-12 mb-3">
							{{{ca_objects.contributor_notes:error}}}
							<label class='form-label' for=''>Other notes</label>
							{{{ca_objects.contributor_notes%class=form-control w-100}}}
						</div>
					</div>
					<div class='row'>
						<div class="col-12 mb-3">
							{{{ca_object_representations.media:error}}}
							
							<label class='form-label'>Image</label>
							{{{ca_object_representations.media%autocomplete=0&class=form-control}}} 
							{{{<ifcount code='ca_object_representations.media' min='1'><div class="pt-2">^ca_object_representations.media%previewExistingValues=1&delimiter=-</div></ifcount>}}}
							
						</div>
					</div><!-- end row -->
				</div>
				<div class="row mb-4">
					<div class="col text-end">
						<div class='submitButtons'>
							{{{submit%label=Save&class=btn btn-primary me-2}}}
							{{{reset%label=Reset&class=btn btn-primary}}} 
						</div>
					</div>
				</div>
			{{{/form}}}
		</div><!-- end contributeForm -->
		
