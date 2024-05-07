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
