<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
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
 
$t_item = 		$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_entities.entity_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

<div id="detail">

	<?= $this->render("Details/ca_objects_default_nav_top.php"); ?>

	<H3>{{{^ca_entities.preferred_labels}}}</H3>

<table class="record table table-striped table-responsive">
    <tbody>
	{{{<ifdef code="ca_entities.comm_date">
		<tr>
			<td>Dates:</td>
			<td>^ca_entities.comm_date</td>
		</tr>
	</ifdef>}}}
	{{{<ifdef code="ca_entities.SCOP">
		<tr>
			<td>Scope:</td>
			<td>^ca_entities.SCOP</td>
		</tr>
	</ifdef>}}}

	{{{<ifdef code="ca_entities.CHR">
		<tr>
			<td>Chair:</td>
			<td>^ca_entities.CHR</td>
		</tr>
	</ifdef>}}}

	{{{<ifdef code="ca_entities.VCHR">
		<tr>
			<td>Vice-Chair:</td>
			<td>^ca_entities.VCHR</td>
		</tr>
	</ifdef>}}}

	{{{<ifdef code="ca_entities.MEM">
		<tr>
			<td>Members:</td>
			<td>^ca_entities.MEM</td>
		</tr>
	</ifdef>}}}

	{{{<ifdef code="ca_entities.AUTH">
		<tr>
			<td>Established by:</td>
			<td>^ca_entities.AUTH</td>
		</tr>
	</ifdef>}}}	
</tbody>
</table>
<!--
	{{{<ifcount code="ca_objects" min="1" restrictToTypes="agenda">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Agenda'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Agendas'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_objects" delimiter="<br>"><dd><l>^ca_objects.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}

	{{{<ifcount code="ca_objects" min="1" restrictToTypes="clerk_file">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Clerk File'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Clerk Files'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_objects" delimiter="<br>"><dd><l>^ca_objects.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}

	{{{<ifcount code="ca_objects" min="1" restrictToTypes="comptroller_file">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Comtroller File'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Comptroller Files'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_objects" delimiter="<br>"><dd><l>^ca_objects.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}

	{{{<ifcount code="ca_objects" min="1" restrictToTypes="council_bill">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Council Bill'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Council Bills'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_objects" delimiter="<br>"><dd><l>^ca_objects.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}

	{{{<ifcount code="ca_objects" min="1" restrictToTypes="ordinance">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Ordinance'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Ordinances'); ?></ifcount>
		</dt>
		<unit relativeTo="ca_objects" delimiter="<br>"><dd><l>^ca_objects.preferred_labels</l> (^relationship_typename)</dd></unit>
		<br>
	</ifcount>}}}

	{{{<ifcount code="ca_objects" min="1" restrictToTypes="resolution">
		<dt>
			<ifcount code="ca_objects" min="1" max="1"><?= _t('Related Resolution'); ?></ifcount>
			<ifcount code="ca_objects" min="2"><?= _t('Related Resolutions'); ?></ifcount>
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
-->
  <?= $this->render("Details/ca_objects_default_nav_bottom.php"); ?>

</div>