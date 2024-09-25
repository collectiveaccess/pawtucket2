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

	<p class="fs-3">Name: {{{^ca_occurrences.preferred_labels}}}</p>

	{{{<ifdef code="ca_occurrences.DATE">
		<tr>
			<td>Meeting date:</td>
			<td>^ca_occurrences.DATE</td>
		</tr>
		<br><br>
	</ifdef>}}}

	{{{<ifdef code="ca_occurrences.STRTTIME">
		<tr>
			<td>Start time:</td>
			<td>^ca_occurrences.STRTTIME</td>
		</tr>
		<br><br>
	</ifdef>}}}

	{{{<ifdef code="ca_occurrences.location">
		<tr>
			<td>Meeting location:</td>
			<td>^ca_occurrences.location</td>
		</tr>
		<br><br>
	</ifdef>}}}

	{{{<ifdef code="ca_occurrences.note">
		<tr>
			<td>Meeting Notes:</td>
			<td>^ca_occurrences.note</td>
		</tr>
		<br><br>
	</ifdef>}}}

	{{{<ifdef code="ca_occurrences.media_link">
		<tr>
			<td>Meeting Notes:</td>
			<td>^ca_occurrences.media_link</td>
		</tr>
		<br><br>
	</ifdef>}}}

	{{{<ifcount code="ca_entities" min="1">
		<dt>
			<ifcount code="ca_entities" min="1" max="1"><?= _t('Related Committee'); ?></ifcount>
			<ifcount code="ca_entities" min="2"><?= _t('Related Committees'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_entities" delimiter="<br>"><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}

	{{{<ifcount code="ca_objects" min="1" restrictToTypes="agenda">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Agenda'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Agendas'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_objects" delimiter="<br>"><dd><l>^ca_objects.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}


	{{{<ifcount code="ca_objects" min="1" restrictToTypes="minutes">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Minute'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Minutes'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_objects" delimiter="<br>"><dd><l>^ca_objects.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}

  <?= $this->render("Details/ca_objects_default_nav_bottom.php"); ?>

</div>