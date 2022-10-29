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
 * @name Object tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");
	$vn_representation_id = $this->request->getParameter('representation_id', pInteger);

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="title">
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
	</div>
<?php
	if($vn_representation_id){
 		$t_rep = new ca_object_representations($vn_representation_id);
 		if (!($vs_template = $va_detail_options['displayAnnotationTemplate'])) { $vs_template = '^ca_representation_annotations.preferred_labels.name'; }
 			
 			$va_annotation_list = array();
 			if (
				is_array($va_annotations = $t_rep->getAnnotations(array('idsOnly' => true))) //$t_rep->get('ca_representation_annotations.annotation_id', array('returnAsArray' => true))) 
				&& 
				sizeof($va_annotations)
				&&
				($qr_annotations = caMakeSearchResult('ca_representation_annotations', $va_annotations))
			) {
				while($qr_annotations->nextHit()) {
					if (!preg_match('!^TimeBased!', $qr_annotations->getAnnotationType())) { continue; }
					#$va_annotation_list[] = $qr_annotations->getWithTemplate($vs_template);
					$vs_tmp = $qr_annotations->getWithTemplate("<b>^ca_representation_annotations.preferred_labels.name</b> (");
					$vs_start = $qr_annotations->getWithTemplate("^ca_representation_annotations.start%asTimecode=delimited");
					if(strpos($vs_start, ".") !== false){
						$vs_start = substr($vs_start, 0, strpos($vs_start, "."));
					}
					$vs_tmp .= $vs_start;
					$vs_tmp .= $qr_annotations->getWithTemplate(")<ifdef code='ca_representation_annotations.description'><br/>^ca_representation_annotations.description</ifdef>");
					$va_annotation_list[] = $vs_tmp;
				}
			}
	}
	if (sizeof($va_annotation_list) > 0) {
?>
<div class="unit"><H6><?php print _t('Index (%1)', sizeof($va_annotation_list)); ?></H6>
<div class='detailAnnotationList'>
<?php
		foreach($va_annotation_list as $vs_annotation) {
			print "<div class='unit'>{$vs_annotation}<br/></div>\n";
		}

	}
	

?>
</div></div>
<?php	
	print $this->render("pdfEnd.php");