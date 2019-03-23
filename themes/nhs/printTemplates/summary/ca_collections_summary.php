<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_collections_summary.php
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
 * @name Collection Finding Aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_collections
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
	$va_access_values = caGetUserAccessValues($this->request);
	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
	#wkhtmltopdf
?>
	<div class="logo">
<?php
		print '<img src="'.$this->request->getThemeDirectoryPath().'/assets/pawtucket/graphics/Horz_NHS.png"/>';
?>
	</div>
	
	<div class="title">
		Guide to the <?php print $t_item->getLabelForDisplay().(($vs_tmp = $t_item->get("ca_collections.collection_date2.collection_date_inclusive")) ? ", <span class='nowrap'>".$vs_tmp."</span>" : "");?>
	</div>
	<div class="contact">
		Newport Historical Society
		<br/>82 Touro Street
		<br/>Newport, Rhode Island 02840
		<br/>(401) 846-0813
		<br/><a href="www.newporthistory.org">www.newporthistory.org</a>
	</div>
	<div class="sectionLabel">
		Descriptive Summary
	</div>
	<div class="unit">
		<div class="unitLabel">Collection Identifier</div>
		<div class="unitContent"><?php print $t_item->get("ca_collections.idno"); ?></div>
		<div class="clear"></div>
	</div>
	<div class="unit">
		<div class="unitLabel">Title</div>
		<div class="unitContent"><?php print $t_item->getLabelForDisplay(); ?></div>
		<div class="clear"></div>
	</div>
<?php
	if($vs_tmp = $t_item->get("ca_entities.preferred_labels.displayname", array("checkAcces" => $va_access_values, "restrictToRelationshipTypes" => array("creator"), "delimiter" => "<br/>"))){
?>
	<div class="unit">
		<div class="unitLabel">Creator</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
	if($vs_tmp = $t_item->get("ca_collections.collection_date2.collection_date_inclusive").(($t_item->get("ca_collections.collection_date2.collection_date_bulk")) ? " (bulk ".$t_item->get("ca_collections.collection_date2.collection_date_bulk").")" : "")){
?>
	<div class="unit">
		<div class="unitLabel">Date</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
	if($vs_tmp = $t_item->get("ca_collections.extent_nhs.extent_details")){
?>
	<div class="unit">
		<div class="unitLabel">Extent</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
	if($vs_tmp = $t_item->get("language_note")){
?>
	<div class="unit">
		<div class="unitLabel">Language</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
	if($vs_tmp = $t_item->get("abstract")){
?>
	<div class="unit">
		<div class="unitLabel">Abstract</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
?>
	<div class="new-page"></div>
<?php
	if($vs_tmp = $t_item->get("ca_collections.historical_note")){
?>
	<div class="sectionLabel">
		Historical Note
	</div>
	<div class="unit">
		<?php print $vs_tmp; ?>
	</div>
<?php
	}
	if($vs_tmp = $t_item->get("ca_collections.scope_content")){
?>
	<div class="sectionLabel">
		Scope and Content
	</div>
	<div class="unit">
		<?php print $vs_tmp; ?>
	</div>
<?php
	}
	if($vs_tmp = caConvertLineBreaks($t_item->get("ca_collections.arrangement"))){
?>
	<div class="sectionLabel">
		Organization
	</div>
	<div class="unit">
		<?php print $vs_tmp; ?>
	</div>
<?php
	}
?>

	<div class="sectionLabel">
		Subject Access
	</div>
<?php
	if($vs_tmp = $t_item->get("ca_entities.preferred_labels.displayname", array("checkAcces" => $va_access_values, "restrictToTypes" => array("ind"), "restrictToRelationshipTypes" => array("creator", "subject", "contributor"), "delimiter" => "<br/>", "sort" => "ca_entities.preferred_labels.displayname"))){
?>
	<div class="unit">
		<div class="unitLabel">People</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear spacer"></div>
	</div>
<?php
	}
	if($vs_tmp = $t_item->get("ca_entities.preferred_labels.displayname", array("checkAcces" => $va_access_values, "restrictToTypes" => array("org"), "restrictToRelationshipTypes" => array("creator", "subject", "contributor"), "delimiter" => "<br/>", "sort" => "ca_entities.preferred_labels.displayname"))){
?>

	<div class="unit">
		<div class="unitLabel">Organizations</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear spacer"></div>
	</div>
<?php
	}
	if($va_tmp = $t_item->get("ca_collections.lcsh_terms", array("returnAsArray" => true))){
		ksort($va_tmp);
		$va_clean = array();
		foreach($va_tmp as $vs_term){
			$vn_c = strpos($vs_term, "[");
			$vs_term = substr($vs_term, 0, $vn_c);
			$va_clean[] = $vs_term;
		}
?>
	<div class="unit">
		<div class="unitLabel">Subjects</div>
		<div class="unitContent"><?php print join("<br/>", $va_clean); ?></div>
		<div class="clear spacer"></div>
	</div>
<?php
	}
	if($va_tmp = $t_item->get("ca_collections.aat", array("returnAsArray" => true))){
		ksort($va_tmp);
?>
	<div class="unit">
		<div class="unitLabel">Form/Genre</div>
		<div class="unitContent"><?php print join("<br/>", $va_tmp); ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
?>	
	<div class="spacer"></div>
<?php
	if($vs_tmp = $t_item->get("ca_collections.separated")){
?>	
	<div class="unit">
		<div class="unitLabelLarge">Separated Material</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
?>
	
	<div class="sectionLabel">
		Access and Use
	</div>
<?php
	if($vs_tmp = $t_item->get("ca_collections.physical_access")){
?>
	<div class="unit">
		<div class="unitLabel">Physical Access</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
	if($vs_tmp = caConvertLineBreaks($t_item->get("ca_collections.reproduction_and_use"))){
?>
	<div class="unit">
		<div class="unitLabel">Reproduction & Use</div>
		<div class="unitContent">
			<?php print $vs_tmp; ?>
		</div>
		<div class="clear"></div>
	</div>
<?php
	}
?>
	<div class="unit">
		<div class="unitLabel">Citation</div>
		<div class="unitContent"><?php print $t_item->getLabelForDisplay().", ".$t_item->get("ca_collections.idno"); ?>, Newport Historical Society, Newport, Rhode Island</div>
		<div class="clear"></div>
	</div>
		
	<div class="sectionLabel">
		Administrative Information
	</div>
<?php
	if($vs_tmp = $t_item->getWithTemplate("<unit delimiter='; and '><ifdef code='ca_collections.cataloguer.cataloguers'>^ca_collections.cataloguer.cataloguers</ifdef><ifdef code='ca_collections.cataloguer.dates_catalogued'>, ^ca_collections.cataloguer.dates_catalogued</ifdef></unit>")){
?>	
	<div class="unit">
		<div class="unitLabel">Processor</div>
		<div class="unitContent">Processed by <?php print $vs_tmp; ?>.</div>
		<div class="clear"></div>
	</div>
<?php
	}
?>	
	<div class="unit">
		<div class="unitLabel">Descriptive Rules</div>
		<div class="unitContent">Finding aid based on <i>Describing Archives: A Content Standard</i> (DACS)</div>
		<div class="clear"></div>
	</div>
<?php
	$va_tmp = explode(";", $t_item->get("ca_collections.processing_note"));
	if($vs_tmp = $va_tmp[0]){
?>	
	<div class="unit">
		<div class="unitLabel">Processing Note</div>
		<div class="unitContent"><?php print $vs_tmp; ?></div>
		<div class="clear"></div>
	</div>
<?php
	}
	$vs_tmp = $t_item->get("ca_collections.credit_line");
	$vs_tmp2 = $t_item->getWithTemplate("<unit relativeTo='ca_object_lots' restrictToTypes='accession'>^ca_object_lots.idno_stub");
	
	if($vs_tmp || $vs_tmp2){
?>
	<div class="unit">
		<div class="unitLabel">Accession Info</div>
		<div class="unitContent">
			<?php print $vs_tmp.(($vs_tmp && $vs_tmp2) ? "<br/><br/>Accession Number: " : "").$vs_tmp2; ?>
		</div>
		<div class="clear"></div>
	</div>
<?php
	}

	if ($t_item->get("ca_collections.children.collection_id")){
?>
		<div class="sectionLabel">
			Inventory
		</div> 	
<?php
		if ($t_item->get('ca_collections.collection_id')) {
			print caNewportGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 0);
		}
	}
	print $this->render("pdfEnd.php");
?>
