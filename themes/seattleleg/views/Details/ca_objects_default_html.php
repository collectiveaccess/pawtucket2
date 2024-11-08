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
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>


<div id="detail">
  <a name="h0"></a>
  <h3>City of Seattle Combined Legislative Records Search</h3>
  <em>Information modified on May 2, 2024;</em> <em>retrieved on May 6, 2024 10:07 AM</em>
  <p></p>
  <hr />

	<?= $this->render("Details/ca_objects_default_nav_top.php"); ?>

  <hr />

  <h2 class="record-number">
		<!-- Clerk File 323014  -->
		{{{ca_objects.type_id}}} {{{ca_objects.CFN}}}
	</h2>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><h3 style="margin: 5px 0 0;">Title</h3></th>
      </tr>
      <tr>
        <td class="empty"></td>
        <td>
          <span class="insert-related-links">
						{{{ca_objects.preferred_labels}}}
          </span>
        </td>
      </tr>
    </tbody>
  </table>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><h3 style="margin: 5px 0 0;">Description and Background</h3></th>
      </tr>

			{{{<ifdef code="ca_objects.STAT">
				<tr>
					<td>Current Status:</td>
					<td>^ca_objects.STAT</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.INDX">
				<tr>
					<td>Index Terms:</td>
					<td>^ca_objects.INDX</td>
				</tr>
			</ifdef>}}}

    </tbody>
  </table>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><h3 style="margin: 5px 0 0;">Legislative History</h3></th>
      </tr>
			
			{{{<ifdef code="ca_objects.SPON">
				<tr>
					<td>Sponsor:</td>
					<td>^ca_objects.SPON</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.DTIR">
				<tr>
					<td>Date Introduced:</td>
					<td>^ca_objects.DTIR</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.COMM">
				<tr>
					<td>Committee Referral:</td>
					<td>^ca_objects.COMM</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.VOTE">
				<tr>
					<td>City Council Vote:</td>
					<td>^ca_objects.VOTE</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.DTF">
				<tr>
					<td>Date Filed with Clerk:</td>
					<td>^ca_objects.DTF</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_object_representations">
				<tr>
					<td>PDF Copy:</td>
					<!-- <td><a href="/~CFS/CF_323014.pdf">Clerk File 323014</a></td> -->
					<!-- TODO: link to pdf -->
				</tr>
			</ifdef>}}}
    </tbody>
  </table>


	{{{<ifdef code="ca_objects.TX">
		<table class="record table table-striped table-responsive">
			<tbody>
				<tr>
					<th colspan="2"><h3 style="margin: 5px 0 0;">Text</h3></th>
				</tr>
				<tr>
					<td class="empty"></td>
					<td>
						<div class="insert-related-links">
							^ca_objects.TX
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</ifdef>}}}

	<table class="record table table-striped table-responsive">
		<tbody>
			<tr><th colspan="2"><h3 style="margin: 5px 0 0;">Attachments</h3></th></tr>
			<tr>
				<td class="empty"></td>
				<td>
					<!-- <p><a href="https://legistar2.granicus.com/seattle/attachments/2ab35e1c-0097-45c0-aaf4-46c45392de7d.pdf">Att 1 - SIR Hostage Negotiation Throw Phone</a></p>
					<p><a href="https://legistar2.granicus.com/seattle/attachments/d8ea96a5-cce6-4765-a61c-caf2a2c195c2.pdf">Att 2 - SIR Hostage Negotiation Throw Phone Executive Overview</a></p> -->
					????????????
				</td>
			</tr>
		</tbody>
	</table>

  <hr />

  <?= $this->render("Details/ca_objects_default_nav_bottom.php"); ?>

</div>


<!-- <?php
if($show_nav){
?>
	<div class="row mt-3">
		<div class="col text-center text-md-end">
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div>
	</div>
<?php
}
?>
	<div class="row<?php print ($show_nav) ? " mt-2 mt-md-n3" : ""; ?>">
		<div class="col-md-12">
			<H1>{{{^ca_objects.preferred_labels.name}}} xxxxx</H1>
			{{{<ifdef code="ca_objects.type_id|ca_objects.idno"><div class="fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0"/>
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

		{{{<ifdef code="ca_object_representations.media.large">
				<div class="col-md-6 justify-content-center">
					<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
				</div>
		</ifdef>}}}

		<div class="col-md-6">
			<div class="bg-body-tertiary py-3 px-4 mb-3">
				<div class="row">
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
						
						<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

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
				</div>
			</div>
			<div id="map" class="py-3">{{{map}}}</div>
		</div>
	</div>

	{{{<ifcount code="ca_entities" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_entities" min="1" max="1"><?= _t('Related Person'); ?></ifcount><ifcount code="ca_entities" min="2"><?= _t('Related People'); ?></ifcount></dt>
			<unit relativeTo="ca_entities" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_entities.preferred_labels<br/>^relationship_typename</l></dd></unit>		
		</dl>
	</ifcount>}}}

	{{{<ifcount code="ca_occurrences" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences" min="1" max="1"><?= _t('Related Occurrence'); ?></ifcount><ifcount code="ca_occurrences" min="2"><?= _t('Related Occurrences'); ?></ifcount></dt>
			<unit relativeTo="ca_occurrences" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_occurrences.preferred_labels<br/>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}}

	{{{<ifcount code="ca_places" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
			<unit relativeTo="ca_places" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_places.preferred_labels<br/>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}} -->