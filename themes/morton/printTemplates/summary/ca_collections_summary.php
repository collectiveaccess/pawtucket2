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
	</div>
<?php	
					if ($t_item->get('ca_collections.repository.repositoryName')) {
						if ($vs_repository = $t_item->get('ca_collections.repository', array('template' => '<ifdef code="ca_collections.repository.repositoryName"><b>Repository Name: </b></ifdef> ^ca_collections.repository.repositoryName <ifdef code="ca_collections.repository.repositoryLocation"><br/><b>Repository Location: </b></ifdef> ^ca_collections.repository.repositoryLocation', 'delimiter' => '<br/>'))) {
							$vs_finding_aid= "<div class='unit'><H6>Repository</H6>".$vs_repository."</div>";
						}
					}
					if ($vs_desc = $t_item->get('ca_collections.description.description_text', array('delimiter' => '<br/>'))) {
						$vs_finding_aid.= "<div class='unit'><H6>Description</H6>".$vs_desc."</div>";
					}	
					if ($t_item->get('ca_collections.date.date_value')) {
						if ($vs_date = $t_item->get('ca_collections.date', array('delimiter' => '<br/>', 'template' => '<unit>^ca_collections.date.date_value ^ca_collections.date.date_types <ifdef code="ca_collections.date.date_notes"><br/>^ca_collections.date.date_notes</ifdef></unit>', 'convertCodesToDisplayText' => true))) {
							$vs_finding_aid.= "<div class='unit'><H6>Date</H6>".$vs_date."</div>";
						}
					}
					if ($vs_extent = $t_item->get('ca_collections.extent_text')) {
						$vs_finding_aid.= "<div class='unit'><H6>Extent</H6>".$vs_extent."</div>";
					}
					if ($vs_creator = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> ^relationship_type</unit>')) {
						$vs_finding_aid.= "<div class='unit'><H6>Creator</H6>".$vs_creator."</div>";
					}
					if ($vs_agency = $t_item->get('ca_collections.agencyHistory')) {
						$vs_finding_aid.= "<div class='unit'><H6><a href='agency'>Agency History</H6>".$vs_agency."</div>";
					}
					if ($vs_abstract = $t_item->get('ca_collections.abstract')) {
						$vs_finding_aid.= "<div class='unit'><H6>Abstract</H6>".$vs_abstract."</div>";
					}
					if ($vs_citation = $t_item->get('ca_collections.preferCite')) {
						$vs_finding_aid.= "<div class='unit'><H6>Preferred Citation</H6>".$vs_citation."</div>";
					}
					if ($vs_custodhist = $t_item->get('ca_collections.custodhist')) {
						$vs_finding_aid.= "<div class='unit'><H6>Custodial history</H6>".$vs_custodhist."</div>";
					}
					if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo')) {
						$vs_finding_aid.= "<div class='unit'><H6>Immediate Source of Acquisition</H6>".$vs_acqinfo."</div>";
					}
					if ($vs_accruals = $t_item->get('ca_collections.accruals')) {
						$vs_finding_aid.= "<div class='unit'><H6>Accruals</H6>".$vs_accruals."</div>";
					}	
					if ($vs_provenance = $t_item->get('ca_collections.provenance')) {
						$vs_finding_aid.= "<div class='unit'><H6>Provenance</H6>".$vs_provenance."</div>";
					}
					if ($vs_origin = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('origin')))) {
						$vs_finding_aid.= "<div class='unit'><H6>Origin of Acquisition</H6>".$vs_origin."</div>";
					}					
					if ($vs_accessioned = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('accession')))) {
						$vs_finding_aid.= "<div class='unit'><H6>Accessioned by</H6>".$vs_accessioned."</div>";
					}	
					if ($va_acc_method = $t_item->get('ca_collections.acquisition_method', array('convertCodesToDisplayText' => true))){
						$vs_finding_aid.= "<div class='unit'><H6>Acquisition method</H6>".$va_acc_method."</div>";
					}
					if ($vs_scopecontent = $t_item->get('ca_collections.scopecontent')) {
						$vs_finding_aid.= "<div class='unit'><H6>Scope and content</H6>".$vs_scopecontent."</div>";
					}	
					if ($vs_arrangement = $t_item->get('ca_collections.arrangement')) {
						$vs_finding_aid.= "<div class='unit'><H6>System of arrangement</H6>".$vs_arrangement."</div>";
					}
					if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict')) {
						$vs_finding_aid.= "<div class='unit'><H6>Conditions governing access</H6>".$vs_accessrestrict."</div>";
					}
					if ($vs_physaccessrestrict = $t_item->get('ca_collections.physaccessrestrict')) {
						$vs_finding_aid.= "<div class='unit'><H6>Physical access</H6>".$vs_physaccessrestrict."</div>";
					}
					if ($vs_techaccessrestrict = $t_item->get('ca_collections.techaccessrestrict')) {
						$vs_finding_aid.= "<div class='unit'><H6>Technical access</H6>".$vs_techaccessrestrict."</div>";
					}
					if ($vs_reproduction_conditions = $t_item->get('ca_collections.reproduction_conditions')) {
						$vs_finding_aid.= "<div class='unit'><H6>Conditions governing reproduction</H6>".$vs_reproduction_conditions."</div>";
					}
					if ($vs_langmaterial = $t_item->getWithTemplate('<unit delimiter="<br/>">^ca_collections.langmaterial.material ^ca_collections.langmaterial.language1</unit>')) {
						$vs_finding_aid.= "<div class='unit'><H6>Languages and scripts on the material</H6>".$vs_langmaterial."</div>";
					}	
					if ($vs_otherfindingaid = $t_item->get('ca_collections.otherfindingaid')) {
						$vs_finding_aid.= "<div class='unit'><H6>Other finding aids</H6>".$vs_otherfindingaid."</div>";
					}
					if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc')) {
						$vs_finding_aid.= "<div class='unit'><H6>Existence and location of originals</H6>".$vs_originalsloc."</div>";
					}	
					if ($vs_altformavail = $t_item->get('ca_collections.altformavail')) {
						$vs_finding_aid.= "<div class='unit'><H6>Existence and location of copies</H6>".$vs_altformavail."</div>";
					}
					if ($vs_relatedmaterial = $t_item->get('ca_collections.relatedmaterial')) {
						$vs_finding_aid.= "<div class='unit'><H6>Related archival materials</H6>".$vs_relatedmaterial."</div>";
					}
					if ($vs_bibliography = $t_item->get('ca_collections.bibliography')) {
						$vs_finding_aid.= "<div class='unit'><H6>Publication note</H6>".$vs_bibliography."</div>";
					}
					$va_subjects_list = array();
					if ($va_subject_terms = $t_item->get('ca_collections.lcsh_terms', array('returnAsArray' => true))) {
						foreach ($va_subject_terms as $va_term => $va_subject_term) {
							if(trim($va_subject_term)){
								$va_subject_term_list = explode('[', $va_subject_term);
								$va_subjects_list[] = ucfirst($va_subject_term_list[0]);
							}
						}
					}
					if ($va_subject_terms_text = $t_item->get('ca_collections.lcsh_terms_text', array('returnAsArray' => true))) {
						foreach ($va_subject_terms_text as $va_text => $va_subject_term_text) {
							if(trim($va_subject_term_text)){
								$va_subjects_list[] = ucfirst($va_subject_term_text);
							}
						}
					}
					if ($va_subject_genres = $t_item->get('ca_collections.lcsh_genres', array('returnAsArray' => true))) {
						foreach ($va_subject_genres as $va_text => $va_subject_genre) {
							if(trim($va_subject_genre)){
								$va_subjects_list[] = ucfirst($va_subject_genre);
							}
						}
					}											
					asort($va_subjects_list);
					if ($va_subjects_list) {
						$vs_finding_aid.= "<div class='unit'><H6>Subject - keywords and LC headings</H6>".join("<br/>", $va_subjects_list)."</div>";
					}
					print $vs_finding_aid;
						
	

	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
