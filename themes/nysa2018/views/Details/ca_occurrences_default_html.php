<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_id = 	$t_item->get('ca_occurrences.occurrence_id');
	
	$t_list = new ca_lists();
	$vn_exhibition_worksheet_type_id = $t_list->getItemIDFromList("occurrence_types", "worksheet");	
	$vn_exhibition_crq_type_id = $t_list->getItemIDFromList("occurrence_types", "CRQ");	
	$vn_exhibition_dbq_type_id = $t_list->getItemIDFromList("occurrence_types", "DBQ");
	$vn_exhibition_docset_type_id = $t_list->getItemIDFromList("occurrence_types", "docset");
	$vn_exhibition_essay_type_id = $t_list->getItemIDFromList("occurrence_types", "essay");	
	
	$vn_current_type_id = $t_item->get('ca_occurrences.type_id');		
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
</div>
<div class="row">	
	<div class='col-xs-12'>
		<H2>{{{^ca_occurrences.preferred_labels.name}}}</H2>
	</div>
</div>	
<div class="row">
	<div class="col-sm-12">
<?php
		print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_occurrences",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</div>";

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

/*		
		if ($vs_grade_level = $t_item->get('ca_occurrences.gradelevel', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
			print "<div class='unit'><b>Grade Level: </b>".$vs_grade_level."</div>";
		}
		if ($vs_lesson_topic = $t_item->get('ca_occurrences.lessonTopic', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
			print "<div class='unit'><b>Lesson Topic: </b>".$vs_lesson_topic."</div>";
		}
		if ($vs_learning_standard = $t_item->get('ca_occurrences.learning_standard', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
			print "<div class='unit'><b>Learning Standard: </b>".$vs_learning_standard."</div>";
		}
		if ($vs_commonCore = $t_item->get('ca_occurrences.commonCore', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
			print "<div class='unit'><b>Common Core: </b>".$vs_commonCore."</div>";
		}	
		if ($vs_skills = $t_item->get('ca_occurrences.skills', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
			print "<div class='unit'><b>21st Century Skills: </b>".$vs_skills."</div>";
		}	
*/								
?>				
	</div>
</div>


{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		

</div><!-- end container -->
	</div><!-- end col -->

</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>