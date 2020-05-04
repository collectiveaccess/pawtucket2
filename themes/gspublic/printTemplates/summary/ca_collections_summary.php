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

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="title">
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
	</div>
		
	<div class="unit"><H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6></div>
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	{{{<ifdef code="ca_collections.label">^ca_collections.label<br/></ifdev>}}}
	</div>
<?php
		$vs_tmp = "";
		if ($vs_repository = $t_item->getWithTemplate('<ifcount code="ca_collections.repository.repositoryName" min="1"><unit>^ca_collections.repository.repositoryName ^ca_collections.repository.repositoryLocation</unit></ifcount>')) {
			if ($vs_repository != " ") {
				$vs_tmp .= "<div class='unit'><h6>Repository</h6>".$vs_repository."</div>";
			}
		}
		if ($vs_date = trim($t_item->getWithTemplate('<ifcount code="ca_collections.unitdate.dacs_date_value" min="1"><unit>^ca_collections.unitdate.dacs_date_value <ifdef code="ca_collections.unitdate.dacs_dates_types">(^ca_collections.unitdate.dacs_dates_types)</ifdef></unit></ifcount>'))) {
			if (($vs_date != " ()") && ($vs_date != " (-)")) {
				$vs_tmp .= "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
			}
		}	
		if ($vs_extent = $t_item->getWithTemplate('<unit>^ca_collections.extentDACS</unit>')) {
			$vs_tmp .= "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
		}
		if ($vs_creator = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
			$vs_tmp .= "<div class='unit'><h6>Creators</h6>".$vs_creator."</div>";
		}
		if ($vs_adminbio = $t_item->get('ca_collections.adminbiohist')) {
			$vs_tmp .= "<div class='unit'><h6>Administrative/Biographical History Element</h6>".$vs_adminbio."</div>";
		}
		if ($vs_scope = $t_item->get('ca_collections.scopecontent')) {
			$vs_tmp .= "<div class='unit'><h6>Scope and Content</h6>".$vs_scope."</div>";
		}
		if ($vs_arrangement = $t_item->get('ca_collections.arrangement', array("convertHTMLBreaks" => true))) {
			$vs_tmp .= "<div class='unit'><h6>System of Arrangement</h6>".$vs_arrangement."</div>";
		}
		if ($vs_use = $t_item->get('ca_collections.accessrestrict')) {
			$vs_tmp .= "<div class='unit'><h6>Conditions Governing Access and Use</h6>".$vs_use."</div>";
		}
		if ($vs_physical = $t_item->get('ca_collections.physaccessrestrict')) {
			$vs_tmp .= "<div class='unit'><h6>Physical Access</h6>".$vs_physical."</div>";
		}
		if ($vs_tech = $t_item->get('ca_collections.techaccessrestrict')) {
			$vs_tmp .= "<div class='unit'><h6>Technical Access</h6>".$vs_tech."</div>";
		}
		if ($vs_repro = $t_item->get('ca_collections.reproduction')) {
			$vs_tmp .= "<div class='unit'><h6>Conditions Governing Reproduction and Use</h6>".$vs_repro."</div>";
		}
		if ($vs_lang = $t_item->get('ca_collections.langmaterial')) {
			$vs_tmp .= "<div class='unit'><h6>Languages and Scripts on the Material</h6>".$vs_lang."</div>";
		}
		if ($vs_other = $t_item->get('ca_collections.otherfindingaid')) {
			$vs_tmp .= "<div class='unit'><h6>Other Finding Aids</h6>".$vs_other."</div>";
		}	
		if ($vs_cust = $t_item->get('ca_collections.custodhist')) {
			$vs_tmp .= "<div class='unit'><h6>Custodial History</h6>".$vs_cust."</div>";
		}
		if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
			$vs_tmp .= "<div class='unit'><h6>Immediate Source of Acquisition</h6>".$vs_acqinfo."</div>";
		}
		if ($vs_appraisal = $t_item->get('ca_collections.appraisal')) {
			$vs_tmp .= "<div class='unit'><h6>Appraisal, Destruction, and Scheduling Information</h6>".$vs_appraisal."</div>";
		}
		if ($vs_accruals = $t_item->get('ca_collections.accruals')) {
			$vs_tmp .= "<div class='unit'><h6>Accruals</h6>".$vs_accruals."</div>";
		}
		if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc')) {
			$vs_tmp .= "<div class='unit'><h6>Existence and Location of Originals</h6>".$vs_originalsloc."</div>";
		}
		if ($vs_altformavail = $t_item->get('ca_collections.altformavail')) {
			$vs_tmp .= "<div class='unit'><h6>Existence and Location of Copies</h6>".$vs_altformavail."</div>";
		}	
		if ($vs_relation = $t_item->get('ca_collections.relation')) {
			$vs_tmp .= "<div class='unit'><h6>Related Archival Materials</h6>".$vs_relation."</div>";
		}
		if ($vs_publication_note = $t_item->get('ca_collections.publication_note')) {
			$vs_tmp .= "<div class='unit'><h6>Publication Note</h6>".$vs_publication_note."</div>";
		}
		if ($vs_general_note = $t_item->get('ca_collections.general_notes')) {
			$vs_tmp .= "<div class='unit'><h6>General Notes</h6>".$vs_general_note."</div>";
		}
		if ($vs_conservation_note = $t_item->get('ca_collections.conservation_notes')) {
			$vs_tmp .= "<div class='unit'><h6>Conservation Notes</h6>".$vs_convservation_note."</div>";
		}	
		if ($vs_processInfo = $t_item->get('ca_collections.processInfo')) {
			$vs_tmp .= "<div class='unit'><h6>Processing Information</h6>".$vs_processInfo."</div>";
		}
		if ($vs_citation = $t_item->get('ca_collections.preferCite')) {
			$vs_tmp .= "<div class='unit'><h6>Preferred Citation</h6>".$vs_citation."</div>";
		}
		if($vs_tmp){
			print "<h2>".ucFirst($t_item->get("ca_collections.type_id", array('convertCodesToDisplayText' => true)))." Information</H2>";		
			print $vs_tmp;
		}	


	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><h2>Collection Contents</h2>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>