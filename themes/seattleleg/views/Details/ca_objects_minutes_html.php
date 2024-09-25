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

	<?= $this->render("Details/ca_objects_default_nav_top.php"); ?>
	
	
		{{{<ifcount code="ca_object_representations" min="1">
			<unit relativeTo="ca_object_representations" delimiter=""><p>
				<ifdef code="ca_object_representations.URL"><a href="^ca_object_representations.URL" target="_blank"><?php print caGetThemeGraphic($this->request, 'pdf.gif', array("alt" => "PDF Icon", "height" => "40px")); ?> <ifdef code="ca_object_representations.preferred_labels">^ca_object_representations.preferred_labels</ifdef><ifnotdef code="ca_object_representations.preferred_labels">Printable Version of this Agenda</ifnotdef></a>
				</ifdef>
			</p></unit>
		</ifcount>}}}

	<hr>

	{{{ca_objects.TX}}}

  <hr>

  <?= $this->render("Details/ca_objects_default_nav_bottom.php"); ?>

</div>
