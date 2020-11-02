<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Full page
 * @type page
 * @filename full_page_summary
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 *
 * @marginTop 0.75in
 * @marginLeft 0.25in
 * @marginBottom 0.5in
 * @marginRight 0.25in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	
	$va_bundle_displays = $this->getVar('bundle_displays');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
?>
	<br/>
	<div class="fullpageRepresentationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "mediumcontain"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['thumbnail']."\n";
		}else{
			# --- one rep - show medium rep
			print "<div class='fullpageRepresentationListLargeImage'>".$va_rep['tags']['mediumcontain']."</div>\n";
		}
	}
?>
	</div>
		
<?php
	print "<p class='fullpageTombstone'>".$t_item->getWithTemplate("<ifdef code='ca_objects.preferred_labels|ca_objects.date'><b><ifdef code='ca_objects.preferred_labels'><i>^ca_objects.preferred_labels</i>, </ifdef>^ca_objects.date</b><br/></ifdef><ifdef code='ca_objects.idno'>MAP # ^ca_objects.idno<br/></ifdef><ifdef code='ca_objects.dimensions'>^ca_objects.dimensions<br/></ifdef><ifdef code='ca_objects.medium'>^ca_objects.medium</ifdef>")."</p>";
	
	print $this->render("pdfEnd.php");
