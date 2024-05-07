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
<script type="text/javascript">
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>


<div id="detail">
  <a name="h0"></a>
  <h3>City of Seattle Combined Legislative Records Search</h3>
  <em>Information modified on May 2, 2024;</em> <em>retrieved on May 6, 2024 10:07 AM</em>
  <p></p>
  <hr />
  <div id="top-search-nav" class="d-flex inline-block justify-content-between">

		<div class="nav-icons">

			<a href="/search/">
				<i class="bi bi-house-door-fill"></i>
			</a>

			<a href="/search/combined">
				<i class="bi bi-search"></i>
			</a>

			<a href="/search/results?s1=parks&amp;l=200&amp;Sect1=IMAGE&amp;Sect2=THESON&amp;Sect3=PLURON&amp;Sect4=AND&amp;Sect5=LEGI2&amp;Sect6=HITOFF&amp;d=LEGC&amp;p=1&amp;u=%2Fsearch%2Fcombined&amp;r=1&amp;f=S">
				<i class="bi bi-justify-left"></i>
			</a>

			<a href="/search/results?s1=parks&amp;l=200&amp;Sect1=IMAGE&amp;Sect2=THESON&amp;Sect3=PLURON&amp;Sect4=AND&amp;Sect5=LEGI2&amp;Sect6=HITOFF&amp;d=LEGC&amp;p=2&amp;u=%2Fsearch%2Fcombined&amp;r=1&amp;f=S">
				<i class="bi bi-chevron-double-right"></i>
			</a>

			<a href="/search/results?s1=parks&amp;l=200&amp;Sect1=IMAGE&amp;Sect2=THESON&amp;Sect3=PLURON&amp;Sect4=AND&amp;Sect5=LEGI2&amp;Sect6=HITOFF&amp;d=LEGC&amp;p=1&amp;u=%2Fsearch%2Fcombined&amp;r=2&amp;f=G">
				<i class="bi bi-chevron-right"></i>
			</a>

			<a href="#hb">
				<i class="bi bi-chevron-double-down"></i>
			</a>

			<a href="/search/help/">
				<i class="bi bi-question-lg"></i>
			</a>

		</div>

		<div id="link-controls">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bi bi-link-45deg"></i> LINK <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="https://clerk.seattle.gov/search/clerk-files/323014">Visit Link</a></li>
					<li><a class="dropdown-item" href="#">Copy Link</a></li>
					<li><a class="dropdown-item" href="mailto:?subject=Clerk File 323014&amp;body=https://clerk.seattle.gov/search/clerk-files/323014">Email Link</a></li>
				</ul>
			</div>
		</div>

  </div>

  <hr />

  <h2 class="record-number">Clerk File 323014</h2>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><h3 style="margin: 5px 0 0;">Title</h3></th>
      </tr>
      <tr>
        <td class="empty"></td>
        <td>
          <span class="insert-related-links">
            Seattle Department of Parks and Recreation Designation of official names for park facilities: Hoa Mai Park (Mai Flower Park); Charleston Park; Wedgewood Park; Cedar Beach Park; Lake City Park, and Bill Wright Golf Complex at
            Jefferson Park.
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
      <tr>
        <td>Current Status:</td>
        <td>Filed</td>
      </tr>
    </tbody>
  </table>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><h3 style="margin: 5px 0 0;">Legislative History</h3></th>
      </tr>
      <tr>
        <td>Date Filed with Clerk:</td>
        <td>May 2, 2024</td>
      </tr>
      <tr>
        <td>PDF Copy:</td>
        <td><a href="/~CFS/CF_323014.pdf">Clerk File 323014</a></td>
      </tr>
    </tbody>
  </table>

  <em>
    A scanned (pdf) copy of this document is available using the above link. If you are unable to open the file, you may view this document at
    <a href="http://www.seattle.gov/cityclerk/legislation-and-research/research-assistance">the Office of the City Clerk</a>. If you are unable to visit the Clerk's Office, you may request a copy or scan be made for you by Clerk staff.
    Scans and copies provided by the Office of the City Clerk are subject to <a href="http://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services">copy fees</a>, and the timing of service is dependent on the
    availability of staff.
  </em>

  <!-- <table class="record table table-striped table-responsive" style="display: none;">
    <tbody>
      <tr>
        <th colspan="2"><h3 style="margin: 5px 0 0;">Text</h3></th>
      </tr>
    </tbody>
  </table>

  <table class="record table table-striped table-responsive" style="display: none;">
    <tbody>
      <tr>
        <th colspan="2"><h3 style="margin: 5px 0 0;">Attachments</h3></th>
      </tr>
    </tbody>
  </table> -->

  <hr />

  <p id="bottom-search-nav">
    <a href="/search/">
			<i class="bi bi-house-door-fill"></i>
    </a>
    <a href="/search/combined">
			<i class="bi bi-search"></i>
    </a>

    <a href="/search/results?s1=parks&amp;l=200&amp;Sect1=IMAGE&amp;Sect2=THESON&amp;Sect3=PLURON&amp;Sect4=AND&amp;Sect5=LEGI2&amp;Sect6=HITOFF&amp;d=LEGC&amp;p=1&amp;u=%2Fsearch%2Fcombined&amp;r=1&amp;f=S">
			<i class="bi bi-justify-left"></i>
    </a>

    <a href="/search/results?s1=parks&amp;l=200&amp;Sect1=IMAGE&amp;Sect2=THESON&amp;Sect3=PLURON&amp;Sect4=AND&amp;Sect5=LEGI2&amp;Sect6=HITOFF&amp;d=LEGC&amp;p=2&amp;u=%2Fsearch%2Fcombined&amp;r=1&amp;f=S">
			<i class="bi bi-chevron-double-right"></i>
    </a>

    <a href="/search/results?s1=parks&amp;l=200&amp;Sect1=IMAGE&amp;Sect2=THESON&amp;Sect3=PLURON&amp;Sect4=AND&amp;Sect5=LEGI2&amp;Sect6=HITOFF&amp;d=LEGC&amp;p=1&amp;u=%2Fsearch%2Fcombined&amp;r=2&amp;f=G">
			<i class="bi bi-chevron-right"></i>
    </a>

    <a href="#h0">
			<i class="bi bi-chevron-double-up"></i>
    </a>

    <a href="/search/help/">
			<i class="bi bi-question-lg"></i>
    </a>
  </p>
  <a name="hb"></a>
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
