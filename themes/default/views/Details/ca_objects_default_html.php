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
$va_comments = 			$this->getVar("comments");
$va_tags = 				$this->getVar("tags_array");
$vn_comments_enabled = 	$this->getVar("commentsEnabled");
$vn_share_enabled = 	$this->getVar("shareEnabled");
$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
$vn_id =				$t_object->get('ca_objects.object_id');
?>



<div class="container detail-container">

	<div class="row border-bottom">
		<div class="col">
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
		</div>
	</div>

	<div class="row row-cols-sm-1 row-cols-md-2">
		<?php
			if ($vn_share_enabled | $vn_pdf_enabled) {	
		?>
			<div class="col-sm-12 col-md-6">
				<div class="btn-group" role="group" aria-label="Detail Controls">
		<?php
				if ($vn_share_enabled) {
					print '<button type="button" class="btn btn-sm btn-light"><i class="bi bi-share me-1"></i> <?= _t("Share"); ?>'.$this->getVar("shareLink")."</button>";
				}
				if ($vn_pdf_enabled) {
					print "<button type='button' class='btn btn-sm btn-light'><i class='bi bi-download me-1'></i> <?= _t('Download'); ?>".caDetailLink($this->request, "Download as PDF", "", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</button>";
				}
		?>
					<button type="button" class="btn btn-sm btn-light"><i class="bi bi-copy"></i> <?= _t('Copy Link'); ?></button>
				</div>
			</div>
		<?php
			}				
		?>
		<div class="col-sm-12 col-md-6 d-flex justify-content-md-end">
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div>
	</div>

	<div class="row justify-content-center">
		<div class="col">
			{{{<ifdef code="ca_object_representations.media.large">
				<div class="unit img-fluid">
					^ca_object_representations.media.large
				</div>
			</ifdef>}}}
		</div>
	</div>

	<div class="row row-cols-sm-1 row-cols-md-2">
		<div class="col-sm-12 col-md-6">						
			{{{<dl>
				<ifdef code="ca_objects.type_id">
					<dt><?= _t('Type Id'); ?></dt>
					<dd>^ca_objects.type_id</dd>
				</ifdef>
			
				<ifdef code="ca_objects.idno">
					<dt><?= _t('Identifier'); ?></dt>
					<dd>^ca_objects.idno</dd>
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

		<div class="col-sm-12 col-md-6">

			{{{<dl>

				<ifcount code="ca_entities" min="1">
					<div class="unit">
						<ifcount code="ca_entities" min="1" max="1"><dt><?= _t('Related person'); ?></dt></ifcount>
						<ifcount code="ca_entities" min="2"><dt><?= _t('Related people'); ?></dt></ifcount>
						<unit relativeTo="ca_entities" delimiter="<br/>"><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
					</div>
				</ifcount>

				<ifcount code="ca_occurrences" min="1">
					<div class="unit">
						<ifcount code="ca_occurrences" min="1" max="1"><dt><?= _t('Related occurrence'); ?></dt></ifcount>
						<ifcount code="ca_occurrences" min="2"><dt><?= _t('Related occurrences'); ?></dt></ifcount>
						<unit relativeTo="ca_occurrences" delimiter="<br/>"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
					</div>
				</ifcount>

				<ifcount code="ca_places" min="1">
					<div class="unit">
						<ifcount code="ca_places" min="1" max="1"><dt><?= _t('Related place'); ?></dt></ifcount>
						<ifcount code="ca_places" min="2"><dt><?= _t('Related places'); ?></dt></ifcount>
						<unit relativeTo="ca_places" delimiter="<br/>"><dd><l>^ca_places.preferred_labels</l> (^relationship_typename)</dd></unit>
					</div>
				</ifcount>

				<ifcount code="ca_collections" min="1">
					<div class="unit">
						<ifcount code="ca_collections" min="1" max="1"><dt><?= _t('Related Collection'); ?></dt></ifcount>
						<ifcount code="ca_collections" min="2"><dt><?= _t('Related Collections'); ?></dt></ifcount>
						<unit relativeTo="ca_collections" delimiter="<br/>"><dd><l>^ca_collections.preferred_labels</l> (^relationship_typename)</dd></unit>
					</div>
				</ifcount>

			</dl>}}}

		</div>
	</div>

</div>

</div>
