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
 * @name Occurrences tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_occurrences
 * @marginTop 1in
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

	<div class='tombstone'>
<?php
		if ($vs_type = $t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true))) {
			print "<div class='unit'><b>Lesson Type: </b>".$vs_type."</div>";
		}	
		if ( $vn_current_type_id == $vn_exhibition_worksheet_type_id ) {
			#context
			if ($vs_context = $t_item->get('ca_occurrences.context')) {
				print "<div class='unit'><b>Historical Context: </b>".$vs_context."</div>";
			}
			#glossary
			if ($vs_glossary = $t_item->get('ca_occurrences.glossary')) {
				print "<div class='unit'><b>Glossary: </b>".$vs_glossary."</div>";
			}			
			#essential
			if ($vs_essential = $t_item->get('ca_occurrences.essential')) {
				print "<div class='unit'><b>Essential Question: </b>".$vs_essential."</div>";
			}			
			#check
			if ($vs_check = $t_item->get('ca_occurrences.check')) {
				print "<div class='unit'><b>Check for Understanding: </b>".$vs_check."</div>";
			}			
			#questions
			if ($va_questions_list = $t_item->get('ca_occurrences.questions', array('returnAsArray' => true))) {
				print "<div class='unit'><b>Questions: </b><ol>";
					foreach ($va_questions_list as $va_key => $vs_question) {
						print "<li>".$vs_question."</li>";
					}
				print "</ol></div>";
			}			
			#challenge
			if ($vs_challenge = $t_item->get('ca_occurrences.challenge')) {
				print "<div class='unit'><b>Historical Challenge: </b>".$vs_challenge."</div>";
			}			
			#connections
			if ($vs_connections = $t_item->get('ca_occurrences.connections')) {
				print "<div class='unit'><b>Interdisciplinary Connections: </b>".$vs_connections."</div>";
			}			
			#resources
			if ($va_resources_list = $t_item->get('ca_occurrences.resources', array('returnAsArray' => true))) {
				print "<div class='unit'><b>Resources: </b><ol>";
					foreach ($va_resources_list as $va_key => $va_resource) {
						print "<li>".$va_resource."</li>";
					}
				print "</ol></div>";
			}				
		
		} elseif ( $vn_current_type_id == $vn_exhibition_crq_type_id ) {
			#context
			if ($vs_context = $t_item->get('ca_occurrences.context')) {
				print "<div class='unit'><b>Historical Context: </b>".$vs_context."</div>";
			}
			#glossary
			if ($vs_glossary = $t_item->get('ca_occurrences.glossary')) {
				print "<div class='unit'><b>Glossary: </b>".$vs_glossary."</div>";
			}
			#questions
			if ($va_questions_list = $t_item->get('ca_occurrences.questions', array('returnAsArray' => true))) {
				print "<div class='unit'><b>Questions: </b><ol>";
					foreach ($va_questions_list as $va_key => $vs_question) {
						print "<li>".$vs_question."</li>";
					}
				print "</ol></div>";
			}		
		} elseif ( $vn_current_type_id == $vn_exhibition_dbq_type_id ) {
			#directions
			if ($vs_directions = $t_item->get('ca_occurrences.directions')) {
				print "<div class='unit'><b>Directions: </b>".$vs_directions."</div>";
			}
			#context
			if ($vs_context = $t_item->get('ca_occurrences.context')) {
				print "<div class='unit'><b>Historical Context: </b>".$vs_context."</div>";
			}
			#task
			if ($vs_task = $t_item->get('ca_occurrences.task')) {
				print "<div class='unit'><b>Task Description: </b>".$vs_task."</div>";
			}			
			#glossary
			if ($vs_glossary = $t_item->get('ca_occurrences.glossary')) {
				print "<div class='unit'><b>Glossary: </b>".$vs_glossary."</div>";
			}
			#instructions
			if ($vs_instructions = $t_item->get('ca_occurrences.instructions')) {
				print "<div class='unit'><b>Part A: Instructions: </b>".$vs_instructions."</div>";
			}			
			#essay
			if ($vs_essay = $t_item->get('ca_occurrences.Essay')) {
				print "<div class='unit'><b>Part B: Essay: </b>".$vs_essay."</div>";
			}			
		} elseif ( $vn_current_type_id == $vn_exhibition_docset_type_id ) {
			#context
			if ($vs_context = $t_item->get('ca_occurrences.context')) {
				print "<div class='unit'><b>Historical Context: </b>".$vs_context."</div>";
			}
			#glossary
			if ($vs_glossary = $t_item->get('ca_occurrences.glossary')) {
				print "<div class='unit'><b>Glossary: </b>".$vs_glossary."</div>";
			}
			#essential
			if ($vs_essential = $t_item->get('ca_occurrences.essential')) {
				print "<div class='unit'><b>Essential Question: </b>".$vs_essential."</div>";
			}
			#check
			if ($vs_check = $t_item->get('ca_occurrences.check')) {
				print "<div class='unit'><b>Check for Understanding: </b>".$vs_check."</div>";
			}
		} elseif ( $vn_current_type_id == $vn_exhibition_essay_type_id ) {
			#glossary
			if ($vs_glossary = $t_item->get('ca_occurrences.glossary')) {
				print "<div class='unit'><b>Glossary: </b>".$vs_glossary."</div>";
			}
			#task
			if ($vs_task = $t_item->get('ca_occurrences.task')) {
				print "<div class='unit'><b>Task Description: </b>".$vs_task."</div>";
			}
			#theme
			if ($vs_theme = $t_item->get('ca_occurrences.theme')) {
				print "<div class='unit'><b>Theme: </b>".$vs_theme."</div>";
			}			
			#guidelines
			if ($vs_guidelines = $t_item->get('ca_occurrences.guidelines')) {
				print "<div class='unit'><b>Guidelines: </b>".$vs_guidelines."</div>";
			}			
			#sure
			if ($vs_sure = $t_item->get('ca_occurrences.sure')) {
				print "<div class='unit'><b>Be Sure To: </b>".$vs_sure."</div>";
			}			
		}
		if ($va_related_objects = $t_item->get('ca_objects.object_id', array('returnAsArray' => true))) {
			foreach ($va_related_objects as $va_key => $va_related_object_id) {
				$t_object = new ca_objects($va_related_object_id);
				print "<hr><div class='unit'>";
				print "<div>".$t_object->get('ca_object_representations.media.medium')."</div>";
				print "<div>".$t_object->get('ca_objects.preferred_labels')."</div>";
				print "<div>".$t_object->get('ca_objects_x_occurrences.caption')."</div>";
				print "</div>";
			}
		}
?>
	</div>
<?php	
	print $this->render("pdfEnd.php");