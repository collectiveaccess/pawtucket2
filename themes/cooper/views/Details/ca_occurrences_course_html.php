<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = 	$this->getVar("access_values");
	$va_hero_images = $t_item->get("ca_object_representations.media.hero", array("checkAccess" => $va_access_values, "returnAsArray" => true))
?>
<div class="frontTopContainer">
	<div class="frontTop">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-7 col-sm-12 col-xs-12">
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<H2>{{{^ca_occurrences.idno}}}</H2>
					<p>{{{^ca_occurrences.course_description}}}</p>
<?php
					if(is_array($va_hero_images) && (sizeof($va_hero_images) > 1)){
						# --- hero slideshow nav
?>
						<div class="jcarousel-paginationHero jcarousel-pagination"><!-- Pagination items will be generated in here --></div>
<?php
					}
?>				
				</div><!-- end col -->
				<div class="col-lg-7 col-md-5 col-sm-12 col-xs-12">
<?php
					if(is_array($va_hero_images) && (sizeof($va_hero_images) == 0)){
						print caGetThemeGraphic($this->request, 'placeholder.jpg');
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
	</div>
</div><!-- end frontTopContainer -->
<div class="container"><div class="row"><div class="col-xs-12">
	<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
		<div class="container">


<?php
		#$va_faculty = $t_item->get("ca_entities", array("restrictToRelationshipTypes" => array("faculty"), "checkAccess" => $va_access_values, "returnWithStructure" => true));
		$vs_faculty_ids = $t_item->getWithTemplate("<unit relativeTo='ca_objects' delimiter=';'><unit relativeTo='ca_entities' restrictToRelationshipTypes='faculty' delimiter=';'>^ca_entities.entity_id</unit></unit>");
		$va_faculty_ids = array_unique(explode(";", $vs_faculty_ids));
		$qr_faculty = caMakeSearchResult("ca_entities", $va_faculty_ids, array("sort" => "ca_entities.preferred_labels.surname"));
		if($qr_faculty->numHits()){
?>
			<div class="row courseEntityList">
				<div class='col-sm-12'>
					<H5>Faculty <span class="grey"> / <?php print $qr_faculty->numHits()." ".(($qr_faculty->numHits() == 1) ? "person" : "people"); ?></span></H5>
				</div>
				<div class="col-sm-12">
					<div class="row courseEntityListOverflow">
<?php
			// foreach($va_faculty as $va_entity){
// 				$vs_surname = $va_entity["surname"];
// 				$vs_forename = $va_entity["forename"];
// 				#$vs_label_detail_link 	= caDetailLink($this->request, $vs_surname.(($vs_surname && $vs_forename) ? ", " : "").$vs_forename, '', $vs_table, $vn_id);
// 				print "<div class='col-sm-6 col-md-3'>";
// 				print caNavLink($this->request, $vs_surname.(($vs_surname && $vs_forename) ? ", " : "").$vs_forename, '', '', 'browse', 'projects', array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
// 				print "</div>";
// 			}
			while($qr_faculty->nextHit()){
				$vs_surname = $qr_faculty->get("ca_entities.preferred_labels.surname");
				$vs_forename = $qr_faculty->get("ca_entities.preferred_labels.forename");
				#$vs_label_detail_link 	= caDetailLink($this->request, $vs_surname.(($vs_surname && $vs_forename) ? ", " : "").$vs_forename, '', $vs_table, $vn_id);
				print "<div class='col-sm-6 col-md-3'>";
				print caNavLink($this->request, $vs_surname.(($vs_surname && $vs_forename) ? ", " : "").$vs_forename, '', '', 'browse', 'projects', array("facet" => "entity_facet", "id" => $qr_faculty->get("entity_id")));
				print "</div>";
			}
?>					
					</div>
				</div>
			</div><!-- end row -->
			<div class="container"><div class="row">
				<div class="col-xs-12 border"></div>
			</div></div>
<?php
		}
		$va_faculty_text_object_ids = $t_item->get("ca_objects.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true, "restrictToTypes" => array("faculty_course_document")));
		if(is_array($va_faculty_text_object_ids) && sizeof($va_faculty_text_object_ids)){
			$qr_faculty_texts = caMakeSearchResult('ca_objects', $va_faculty_text_object_ids);
			if($qr_faculty_texts->numHits()){

				$vs_texts_output = "";
				$vn_texts_c = 0;
				while($qr_faculty_texts->nextHit()){
					$vs_tmp = $vs_year = $vs_semester = $vs_course = $vn_rep_id = "";
					$vs_year = $qr_faculty_texts->get("ca_occurrences.preferred_labels", array("delimiter" => "; ", "checkAccess" => $va_access_values, "restrictToTypes" => array("academic_year")));
					$vs_semester = $qr_faculty_texts->get("ca_objects.semester", array("delimiter" => "; ", "convertCodesToDisplayText" => true));
					$vs_tmp .= $vs_year;
					if($vs_tmp && $vs_semester){
						$vs_tmp .= ", ";
					}
					$vs_tmp .= $vs_semester;
					$vs_course = $qr_faculty_texts->get("ca_occurrences.preferred_labels", array("delimiter" => "; ", "checkAccess" => $va_access_values, "restrictToTypes" => array("course")));
					if($vs_tmp && $vs_course){
						$vs_tmp .= " | ";
					}
					$vs_tmp .= $vs_course;
					
					if($vn_rep_id = $qr_faculty_texts->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values))){
						$vs_texts_output .= "<div class='col-sm-6 col-md-3'>";
						$vs_texts_output .= '<a href="#" onclick="caMediaPanel.showPanel(\''.caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('id' => $qr_faculty_texts->get("ca_objects.object_id"), 'context' => 'objects', 'overlay' => 1, 'representation_id' => $qr_faculty_texts->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values)))).'\'); return false;" title="View Document">'.$vs_tmp.'</a>';
						$vs_texts_output .= "</div>";
						$vn_texts_c++;
					}
					
				}
				if($vs_texts_output){
?>
					<div class="row textsList">
						<div class='col-sm-12'>
							<H5>Faculty Course Documents <span class="grey"> / <?php print $vn_texts_c." ".(($vn_texts_c == 1) ? "document" : "documents"); ?></span></H5>
						</div>
						<div class='col-sm-12'>
							<div class="row textsListScroll display-flex">
								<?php print $vs_texts_output; ?>
							</div>				
						</div>			
					</div><!-- end row -->
					<div class="container"><div class="row">
						<div class="col-xs-12 border"></div>
					</div></div>
<?php				
				}
			}
		
		}
		$va_rel_projects = $t_item->get("ca_objects", array("checkAccess" => $va_access_values, "restrictToTypes" => array("student_project"), "returnAsArray" => true));
		$vs_title = $t_item->get("ca_occurrences.preferred_labels.name");
		if(sizeof($va_rel_projects)){
?>
			<div class="row">
				<div class="col-md-10 col-sm-10">
					<H1 class="courseProjects">All <?php print $vs_title; ?> <span class='grey'>/ <?php print sizeof($va_rel_projects)." ".((sizeof($va_rel_projects) == 1) ? "project" : "projects"); ?></span></H1>
				</div>
				<div class="col-md-2 col-sm-12 text-right">
					<?php print caNavLink($this->request, _t("See All")." <i class='fa fa-caret-down'></i>", "btn-default", "", "Browse", "projects", array("facet" => "course_facet", "id" => $t_item->get("occurrence_id"))); ?>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'projects', array('search' => 'occurrence_id:'.$t_item->get("ca_occurrences.occurrence_id"), 'detailLoad' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery("#browseResultsContainer").jscroll({
							autoTrigger: true,
							loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
							padding: 20,
							nextSelector: "a.jscroll-next"
						});
					});
					
					
				});
			</script>
<?php
		}
?>
</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>