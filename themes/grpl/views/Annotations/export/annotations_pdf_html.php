<?php
/* ----------------------------------------------------------------------
 * /views/Sets/exportTemplates/ca_objects_sets_pdf_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
$annotations = $this->getVar("annotations");
?>
<HTML>
	<HEAD>
		<style type="text/css">
			<!--
			.pageHeader { 
				background-color: #FFFFFF; 
				margin: 0px 10px 20px 10px; padding: 
				0px 5px 20px 5px; width: 100%; 
				height: 45px; 
				font-family: Helvetica, sans-serif; 
			}
			
			.pageHeader img{ 
				vertical-align:middle;  
			}
			
			.headerText { 
				text-align:right; c
				olor: #000; 
				margin: -50px 0px 10px 20px; 
				font-family: Helvetica, sans-serif; 
				font-size: 11px; 
			}
			
			.objectLabel {
				font-size: 14px; 
				font-style: italic;
				font-family: Helvetica, sans-serif;
			}
			
			.annotationLabel {
				font-size: 12px; 
				font-style: normal;
				font-family: Helvetica, sans-serif;
			}
			
			.pageBreak { 
				page-break-before: always; height:1px;
			}
			
			.sourceInfo {
				position: absolute;
				left: 0in;
				top: 0in;
			}
			
			.annotationImage {
				position: absolute;
				left: 0in;
				top: 0.5in;
				width: 7in;
				height: 9in;
				object-fit: contain;
			}
			
			.annotationImageTall img {
				object-fit: contain;
				width: auto;
				height: auto;
				max-width: 90%;
				max-height: 90%;
			}
			
			.annotationImageWide img {
				object-fit: contain;
				width: auto;
				height: auto;
				max-width: 90%;
				max-height: 90%;
			}
			-->
		</style>
	</HEAD>
	<BODY>
<?php
		$i = 0;
		foreach($annotations as $anno){
			$i++;
			
			$aspect = ($anno['original_width'] >= $anno['original_height']) ? 'Wide' : 'Tall';
?>
		<div style="position: relative; width: 100%; border: 1px solid white;">
			<div class="annotationImage annotationImage<?= $aspect; ?>"><?= $anno['original']; ?></div></td>

			<div class="sourceInfo">
				<div class='objectLabel'><?= _t('From <em>%1</em>, page %2', $anno['object_label'], $anno['page']); ?></div>
				<div class='annotationLabel'><?= $anno['label']; ?></div>
				<div class='annotationLabel'><?= $anno['created'] ? _t('Created %1', $anno['created']) : ''; ?></div>
			</div>
		</div>
<?php
			if($i < sizeof($annotations)) { 
?>
				<div class="pageBreak"></div>
<?php	
			}
		}
?>

	</BODY>
</HTML>
