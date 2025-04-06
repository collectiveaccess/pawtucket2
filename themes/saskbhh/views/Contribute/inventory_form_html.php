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
 # --- pass class to media upload input
 
$t_subject = $this->getVar('t_subject');
$form_info = $this->getVar('form_info');
?>
		<div class="contributeForm">
			<h1><div class="float-start pe-3">
				<?= caNavLink($this->request, '<i class="bi bi-chevron-left"></i>', 'btn btn-secondary btn-sm', '*', '*', 'Index', null, array("aria-label" => _t('Back to list'), "title" => _t('Back to list')));?>
			</div><?= _t("Contribute"); ?></h1>
			
			<div class="py-3">
				<?= _t("Submit a spreadsheet of artefact records using the form below. <b>Please ensure your spreadsheet follows the structure defined in our <a href='%1'>"._t("Artefact Inventory Template")."</a>.</b> Your records will be made visible on the site once reviewed and imported.", caGetThemeGraphicUrl($this->request, 'MAS_Repatriation_object_import_template.xlsx')); ?>
			</div>
			
			{{{<ifdef code="errors"><div class="notificationMessage">^errors</div></ifdef>}}}
			<div class="bg-light px-4 py-4 mb-4">
				<h2><?= $form_info["formTitle"]; ?></h2>
				{{{form}}}
					<div class='row mt-3'>
						<div class="col-sm-12 mb-3">
							{{{ca_occurrences.repository:error}}}
							<label class='form-label' for=''><?= _t("Name of Holding Institution / Repository"); ?></label><br/>
							{{{ca_occurrences.repository%class=form-control w-100}}}
						</div>
					</div>
					<div class='row mt-3'>									
						<div class="col-sm-12 col-md-6 mb-3">
							{{{ca_occurrences.submitted_data:error}}}
							<label class='form-label' for=''><?= _t("Inventory Spreadsheet"); ?></label>
							{{{ca_occurrences.submitted_data%class=form-control w-100}}}
							<div class="form-text">Please follow the structure defined in our <a href="<?= caGetThemeGraphicUrl($this->request, 'MAS_Repatriation_object_import_template.xlsx'); ?>"><?= _t("Artefact Inventory Template"); ?></a></div>
						</div>
						<div class="col-sm-12 col-md-6 mb-3">
							{{{ca_occurrences.submitted_media:error}}}
							<label class='form-label' for=''><?= _t("Accompanying Media"); ?></label>
							{{{ca_occurrences.submitted_media%class=form-control w-100}}}
						</div>
					</div>
					<div class='row mt-3'>
						<div class="col-sm-12">
							{{{ca_occurrences.add_records:error}}}
							<label class='form-label' for=''><?= _t("Do you have additional records you would like to submit?"); ?></label>
							{{{ca_occurrences.add_records%class=form-control w-100}}}
						</div>
					</div>
					<div class='row mt-3'>										
						<div class="col-sm-12">
							{{{ca_occurrences.add_media:error}}}
							<label class='form-label' for=''><?= _t("Do you have additional media to contribute?"); ?></label><br/>
							{{{ca_occurrences.add_media%class=form-control w-100}}}
						</div>
					</div>
					<div class='row mt-3'>
						<div class="col-sm-12">
							{{{ca_occurrences.contributor_notes:error}}}
							<label class='form-label' for=''><?= _t("Please provide any additional information to help us understand your data."); ?></label><br/>
							{{{ca_occurrences.contributor_notes%class=form-control w-100}}}
						</div>
					</div>
				</div>
				<div class="row mb-4 ">
					<div class="col text-end">
						<div class='submitButtons'>
							{{{submit%label=Save&class=btn btn-primary me-2}}}
							{{{reset%label=Reset&class=btn btn-primary}}} 
						</div>
					</div>
				</div>
			{{{/form}}}
		</div><!-- end contributeForm -->
		
