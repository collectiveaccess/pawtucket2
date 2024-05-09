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

	<?= $this->render("/data/seattleleg/themes/seattleleg/views/Details/ca_objects_default_nav_top.php"); ?>

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

			{{{<ifdef code="ca_objects.STAT">
				<tr>
					<td>Notes:</td>
					<td><em>
						<span class="insert-related-links">Clerk's Office Note: PDF updated 4/30/2024.</span>
					</em></td>
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

  <?= $this->render("/data/seattleleg/themes/seattleleg/views/Details/ca_objects_default_nav_bottom.php"); ?>

</div>
