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

	<?= $this->render("Details/ca_objects_default_nav_top.php"); ?>

  <h3 class="record-number"><?= $type_idno; ?> {{{ca_objects.idno}}}</h3>

  <table class="record table table-striped table-responsive">
    <tbody>
      <tr>
        <th colspan="2"><H4>Title</H4></th>
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
        <th colspan="2"><H4>Description and Background</H4></th>
      </tr>

			{{{<ifdef code="ca_objects.STAT">
				<tr>
					<td>Current Status:</td>
					<td>^ca_objects.STAT</td>
				</tr>
			</ifdef>}}}

			<?php
				if($t_object->get("ca_objects.index")){
					if($links = caGetSearchLinks($t_object, 'ca_objects.index', ['template' => '^ca_objects.index', 'linkTemplate' => '^LINK'])) {
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
        <th colspan="2"><H4>Legislative History</H4></th>
      </tr>

			<?php
				if($t_object->get("ca_objects.SPON")){
					if($links = caGetSearchLinks($t_object, 'ca_objects.SPON', ['template' => '^ca_objects.SPON', 'linkTemplate' => '^LINK'])) {
			?>
					<tr>
						<td><?= _t('Sponsor:'); ?></td>
						<td><?= join(", ", $links); ?></td>
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

			{{{<ifdef code="ca_objects.DTCA">
				<tr>
					<td>City Council Action Date:</td>
					<td>^ca_objects.DTCA</td>
				</tr>
			</ifdef>}}}

			<?php
				if($t_object->get("ca_objects.COMM")){
					if($comm = caGetSearchLinks($t_object, 'ca_objects.COMM', ['template' => '^ca_objects.COMM', 'linkTemplate' => '^LINK'])) {
			?>
					<tr>
						<td><?= _t('Committee Referral:'); ?></td>
						<td><?= join(", ", $comm); ?></td>
					</tr>
			<?php
					}
				}
			?>

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
    </tbody>
  </table>

<?= $this->render("Details/attachments_html.php"); ?>
	
	{{{<ifdef code="ca_objects.TX">
		<table class="record table table-striped table-responsive">
			<tbody>
				<tr>
					<th colspan="2"><H4>Text</H4></th>
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
		<?php print $this->getVar("detail_text_not_online"); ?>
	<ifnotdef/>}}}

	
  <hr>

  <?= $this->render("Details/ca_objects_default_nav_bottom.php"); ?>

</div>
