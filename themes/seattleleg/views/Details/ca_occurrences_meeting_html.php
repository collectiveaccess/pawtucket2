<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
$t_item = 			$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_occurrences.occurrence_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
?>

<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

<div id="detail">

	<?= $this->render("Details/ca_objects_default_nav_top.php"); ?>

	<H3>{{{^ca_occurrences.preferred_labels}}}</H3>
<table class="record table table-striped table-responsive">
    <tbody>
	{{{<ifdef code="ca_occurrences.DATE|ca_occurrences.STRTTIME">
		<tr>
			<td>Meeting date:</td>
			<td><ifdef code="ca_occurrences.DATE">^ca_occurrences.DATE </ifdef><ifdef code="ca_occurrences.STRTTIME">^ca_occurrences.STRTTIME</ifdef></td>
		</tr>
	</ifdef>}}}

	{{{<ifdef code="ca_occurrences.location">
		<tr>
			<td>Meeting location:</td>
			<td>^ca_occurrences.location</td>
		</tr>
	</ifdef>}}}

	{{{<ifcount code="ca_entities" min="1">
		<tr><td>
			<ifcount code="ca_entities" min="1" max="1"><?= _t('Committee'); ?></ifcount>
			<ifcount code="ca_entities" min="2"><?= _t('Committees'); ?></ifcount>
			</td>
			<td><unit relativeTo="ca_entities" delimiter="<br>"><l>^ca_entities.preferred_labels</l></unit>
		</td></tr>
	</ifcount>}}}

	{{{<ifdef code="ca_occurrences.note">
		<tr>
			<td>Meeting notes:</td>
			<td><unit relativeTo="ca_occurrences.note" delimiter="<br><br/>">^ca_occurrences.note</unit></td>
		</tr>
	</ifdef>}}}


	{{{<ifcount code="ca_objects" min="1" restrictToTypes="minutes">
		<tr><td><?= _t('Minutes'); ?></td>
			<td>
				<unit relativeTo="ca_objects" delimiter="<br>" restrictToTypes="minutes"><l>^ca_objects.preferred_labels</l></unit>
		</td></tr>
	</ifcount>}}}

	{{{<ifdef code="ca_occurrences.media_link">
		<tr>
			<td>Media:</td>
			<td><unit relativeTo="ca_occurrences.media_link" delimetr="<br/><br/>"><a href="^ca_occurrences.media_link">^ca_occurrences.media_link</a></unit></td>
		</tr>
	</ifdef>}}}
	{{{<ifcount code="ca_objects" min="1" restrictToTypes="agenda">
		<tr><td>
			<ifcount code="ca_objects" min="1" max="1" restrictToTypes="agenda"><?= _t('Agenda'); ?></ifcount>
			<ifcount code="ca_objects" min="2" restrictToTypes="agenda"><?= _t('Agendas'); ?></ifcount>
			</td>
			<td><unit relativeTo="ca_objects" delimiter="<br>" restrictToTypes="agenda"><ifdef code="ca_object_representations.media"><div class="mb-2"><a href="^ca_object_representations.media.original.url"><i class='bi bi-file-earmark-arrow-down-fill' aria-label='Download' title='Download'></i> ^ca_objects.preferred_labels</a></div></ifdef>
					^ca_objects.TX
				</unit>
		</td></tr>
	</ifcount>}}}
</tbody>
</table>
  <?= $this->render("Details/ca_objects_default_nav_bottom.php"); ?>

</div>