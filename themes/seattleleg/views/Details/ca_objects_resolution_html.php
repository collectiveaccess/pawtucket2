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

$type_idno = $t_object->get("type_id", ['convertCodesToDisplayText' => true]);

?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>


<div id="detail">

	<?= $this->render("/data/seattleleg/themes/seattleleg/views/Details/ca_objects_default_nav_top.php"); ?>

  <h2 class="record-number">
		<?= $type_idno; ?> {{{ca_objects.RESN}}}
	</h2>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><span style="font-size: 23px; margin: 5px 0 0;">Title</span></th>
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
        <th colspan="2"><span style="font-size: 23px; margin: 5px 0 0;">Description and Background</span></th>
      </tr>

			{{{<ifdef code="ca_objects.STAT">
				<tr>
					<td>Current Status:</td>
					<td>^ca_objects.STAT</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.fiscal.fiscal_link">
				<tr>
					<td>Fiscal Note</td>
					<td><a href="^ca_objects.fiscal.fiscal_link" target="_blank">^ca_objects.fiscal.fiscal_link</a></td>
				</tr>
			</ifdef>}}}

			<?php
				if($t_object->get("ca_objects.index")){
					if($links = caGetBrowseLinks($t_object, 'ca_objects.index', ['template' => '<l>^ca_objects.index</l>', 'linkTemplate' => '^LINK'])) {
			?>
					<tr>
						<td><?= _t('Index Terms:'); ?></td>
						<td><?= join(", ", $links); ?></td>
					</tr>
			<?php
					}
				}
			?>

			{{{<ifdef code="ca_objects.REF">
				<tr>
					<td>References:</td>
					<td>^ca_objects.REF</td>
				</tr>
			</ifdef>}}}

    </tbody>
  </table>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><span style="font-size: 23px; margin: 5px 0 0;">Legislative History</span></th>
      </tr>
			
			<!-- {{{<ifdef code="ca_objects.SPON">
				<tr>
					<td>Sponsor:</td>
					<td>^ca_objects.SPON</td>
				</tr>
			</ifdef>}}} -->

			<?php
				if($t_object->get("ca_objects.SPON")){
					if($links = caGetBrowseLinks($t_object, 'ca_objects.SPON', ['template' => '<l>^ca_objects.SPON</l>', 'linkTemplate' => '^LINK'])) {
			?>
					<tr>
						<td><?= _t('Sponsor:'); ?></td>
						<td><?= join(",", $links); ?></td>
					</tr>
			<?php
					}
				}
			?>

			{{{<ifdef code="ca_objects.DTIR">
				<tr>
					<td>Date Introduced:</td>
					<td>^ca_objects.DTIR</td>
				</tr>
			</ifdef>}}}

			<!-- {{{<ifdef code="ca_objects.COMM">
				<tr>
					<td>Committee Referral:</td>
					<td>^ca_objects.COMM</td>
				</tr>
			</ifdef>}}} -->

			<?php
				if($t_object->get("ca_objects.COMM")){
					if($links = caGetBrowseLinks($t_object, 'ca_objects.COMM', ['template' => '<l>^ca_objects.COMM</l>', 'linkTemplate' => '^LINK'])) {
			?>
					<tr>
						<td><?= _t('Committee Referral:'); ?></td>
						<td><?= join(",", $links); ?></td>
					</tr>
			<?php
					}
				}
			?>

			{{{<ifdef code="ca_objects.DTSI">
				<tr>
					<td>City Council Action Date:</td>
					<td>^ca_objects.DTSI</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.DCMR">
				<tr>
					<td>Committee Action Date:</td>
					<td>^ca_objects.DCMR</td>
				</tr>
			</ifdef>}}}

			{{{<ifdef code="ca_objects.STAT">
				<tr>
					<td>Committee Action:</td>
					<td>^ca_objects.STAT</td>
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

			{{{<ifdef code="ca_objects.document.doc_link">
				<tr>
					<td>Signed Copy:</td>
					<td><a href="^ca_objects.document.doc_link" target="_blank">^ca_objects.document.doc_link</a></td>
				</tr>
			</ifdef>}}}

    </tbody>
  </table>


	{{{<ifdef code="ca_objects.TX">
		<table class="record table table-striped table-responsive">
			<tbody>
				<tr>
					<th colspan="2"><span style="font-size: 23px; margin: 5px 0 0;">Text</span></th>
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

	{{{<ifnotdef code="ca_objects.TX">
		<em>No text for this document is available online. You may view this document at
			<a href="http://www.seattle.gov/cityclerk/legislation-and-research/research-assistance">the Office of the City Clerk</a>.	If you are unable to visit the Clerk's Office, you may request a copy or scan be made for you by Clerk staff.	Scans and copies provided by the Office of the City Clerk are subject to <a href="http://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services">copy fees</a>, and the timing of service
			is dependent on the availability of staff.
		</em>
	<ifnotdef/>}}}

	{{{<ifdef code="ca_object_representations.media.small">
		<unit filterNonPrimaryRepresentations="0">
			<table class="record table table-striped table-responsive">
				<tbody>
					<tr><th colspan="2"><span style="font-size: 23px; margin: 5px 0 0;">Attachments</span></th></tr>
					<tr>
						<td class="empty"></td>
						<td>
							<a href="^ca_object_representations.URL" target="_blank">^ca_object_representations.media.small</a>
						</td>
					</tr>
				</tbody>
			</table>
		</unit>
	</ifdef>}}}

  <hr>

  <?= $this->render("/data/seattleleg/themes/seattleleg/views/Details/ca_objects_default_nav_bottom.php"); ?>

</div>
