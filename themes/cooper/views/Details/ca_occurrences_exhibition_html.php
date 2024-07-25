<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 
	$t_item = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_item->get('ca_occurrences.occurrence_id');
	$va_access_values = 	$this->getVar("access_values");
	$vb_ajax			= (bool)$this->request->isAjax();
	
	# --- use a browse with no criteria to get all facets
	$o_browse_all = caGetBrowseInstance("ca_objects");
	$o_browse_all->setTypeRestrictions(array("exhibition_item"), array('dontExpandHierarchically' => false));
	$o_browse_all->addCriteria("exhibition_facet", $vn_id);
	$o_browse_all->addCriteria("has_media_facet", 1);
	$o_browse_all->execute(array('checkAccess' => $va_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => false));
	$va_facets = array();
	$va_available_facets = $o_browse_all->getInfoForAvailableFacets(['checkAccess' => $va_access_values, 'request' => $this->request]);
	foreach($va_available_facets as $vs_facet_name => $va_facet_info) {
		if(in_array($vs_facet_name, array("exh_item_type_facet", "exhibition_item_course_facet"))){
			$va_facets[$vs_facet_name] = $va_available_facets[$vs_facet_name];
			$va_facets[$vs_facet_name]['content'] = $o_browse_all->getFacet($vs_facet_name, array('checkAccess' => $va_access_values, 'request' => $this->request, 'checkAvailabilityOnly' => false));
		
		}
	}

	$vb_display_faculty = false;
	$va_faculty_by_course = array();
	$o_browse = caGetBrowseInstance("ca_objects");

	if ($ps_cache_key = $this->request->getParameter('key', pString, ['forcePurify' => true])) {
		$o_browse->reload($ps_cache_key);
	}
	$o_browse->setTypeRestrictions(array("exhibition_item"), array('dontExpandHierarchically' => false));
	$o_browse->addCriteria("exhibition_facet", $vn_id);
	$o_browse->addCriteria("has_media_facet", 1);
		
	if ($vs_remove_criterion = $this->request->getParameter('removeCriterion', pString, ['forcePurify' => true])) {
		$o_browse->removeCriteria($vs_remove_criterion, array($this->request->getParameter('removeID', pString, ['forcePurify' => true])));
	}
	if (($vs_facet = $this->request->getParameter('facet', pString, ['forcePurify' => true])) && is_array($p = array_filter(explode('|', trim($this->request->getParameter('id', pString, ['forcePurify' => true]))), function($v) { return strlen($v); })) && sizeof($p)) {
		$p = array_map('urldecode', $p);
		$o_browse->addCriteria($vs_facet, $p);
	}
	$o_browse->execute(array('checkAccess' => $va_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => false));
	
	$qr_objects = $o_browse->getResults(array('sort' => 'ca_objects.idno', 'sort_direction' => 'asc'));
	$vs_key = $o_browse->getBrowseID();
	
	$va_criteria = $o_browse->getCriteriaWithLabels();
	$va_criteria_for_display = $va_criteria_for_display_by_facet = array();
	foreach($va_criteria as $vs_facet_name => $va_criterion) {
		if($vs_facet_name == "exhibition_item_course_facet"){
			$vb_display_faculty = true;
		}
		if($vs_facet_name != "exhibition_facet"){
			$va_facet_info = $o_browse->getInfoForFacet($vs_facet_name);
			foreach($va_criterion as $vn_criterion_id => $vs_criterion) {
				$va_criteria_for_display[] = array('facet' => $va_facet_info['label_singular'], 'facet_name' => $vs_facet_name, 'value' => $vs_criterion, 'id' => $vn_criterion_id);
				$va_criteria_for_display_by_facet[$vs_facet_name][] = $vn_criterion_id;
			}
		}
	}
	$va_multiple_selection_facet_list = array();		
#if($vb_ajax){
	# --- display media for child record on ajax load
#	print $this->getVar("representationViewer");
#}else{

?>

		<div class="container">
			<div class="row">
				<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
					{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
			<div class="row">
				<div class="col-sm-3 detailRefine browse">
					<div id="bRefine">
						<h3>Filter Results By:</h3>
			
<?php
					
						#if (sizeof($va_criteria_for_display) > 0) {
						#	foreach($va_criteria_for_display as $va_criterion) {
						#		print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span>'.$va_criterion['value'].' </button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'key' => $vs_key));
						#	}
						#}
						if(is_array($va_facets) && sizeof($va_facets)){
							foreach($va_facets as $vs_facet_name => $va_facet_info) {
								$va_multiple_selection_facet_list[$vs_facet_name] = caGetOption('multiple', $va_facet_info, false, ['castTo' => 'boolean']);
			
								if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
								print "<div class='bRefineFacet'  id='{$vs_facet_name}_facet_container'>";
									
									print "<H5>".$va_facet_info['label_singular']."</H5>"; 
									switch($va_facet_info["group_mode"]){
										case "alphabetical":
										case "list":
										default:
											$vn_facet_size = sizeof($va_facet_info['content']);
											$vn_c = 0;
											foreach($va_facet_info['content'] as $va_item) {
												$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? $va_item['content_count'] : "";
												$vs_label = $va_item['label'];
												if(is_array($va_criteria_for_display_by_facet[$vs_facet_name]) && in_array($va_item['id'], $va_criteria_for_display_by_facet[$vs_facet_name])){
													print '<div>'.caNavLink($this->request, '<span>'.$vs_content_count.'</span><i class="far fa-check-square"></i> '.$vs_label, 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $vs_facet_name, 'removeID' => $va_item['id'], 'key' => $vs_key)).'</div>';
							
												}else{
													#print "<div class='facetItem' data-facet='".$vs_facet_name."' data-facet_item_id='".$va_item['id']."'>".caNavLink($this->request, "<span>".$vs_content_count."</span>".$vs_label, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id']))."</div>";
													print "<div>".caNavLink($this->request, "<span>".$vs_content_count."</span><i class='far fa-square'></i> ".$vs_label, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id']))."</div>";
												}
												$vn_c++;
											}
										break;
										# ---------------------------------------------
									}
								if ($va_multiple_selection_facet_list[$vs_facet_name]) {
?>
									<!--<a href="#" id="<?php print $vs_facet_name; ?>_facet_apply" data-facet="<?php print $vs_facet_name; ?>" class="facetApply">Apply</a>-->
<?php
								}
				
								
								print "</div><!-- end bRefineFacet -->";
							}	
						}
?>
<script type="text/javascript">
		jQuery(document).ready(function() {
            var multiple_selection_facet_list = <?php print json_encode($va_multiple_selection_facet_list); ?>;
            
            jQuery(".facetApply").hide();
            
            jQuery(".facetItem").on('click', function(e) { 
            	if (!multiple_selection_facet_list[jQuery(this).data('facet')]) { return; }
            	if (jQuery(this).attr('facet_item_selected') == '1') {
            		jQuery(this).attr('facet_item_selected', '');
            	} else {
            		jQuery(this).attr('facet_item_selected', '1');
            	}
            	
            	if (jQuery("div.facetItem[facet_item_selected='1']").length > 0) {
            		jQuery("#" + jQuery(this).data('facet') + "_facet_apply").show();
            	} else {
            		jQuery("#" + jQuery(this).data('facet') + "_facet_apply").hide();
            	}
            	
            	e.preventDefault();
            	return false;
            });
            
            jQuery(".facetApply").on('click', function(e) { 
            	var facet = jQuery(this).data('facet');
            	
            	var ids = [];
            	jQuery.each(jQuery("#" + facet + "_facet_container").find("[facet_item_selected=1]"), function(k,v) {
            		ids.push(jQuery(v).data('facet_item_id'));
            	});
				window.location = '<?php print caNavUrl($this->request, '*', '*','*', array('key' => $vs_key)); ?>/facet/' + facet + '/id/' + ids.join('|');
            	e.preventDefault();
            });
	});
</script>
					</div>
				</div>
				<div class="col-sm-9 exhibitionRightCol">
					<div class="row">
						<div class='col-sm-12'>
<?php
						$va_all_object_ids = array();
						
						if($qr_objects->numHits() > 0){
?>
							<div class="container">
								<div class="row detailImages detailImagesGrid">
<?php
		
								if($qr_objects->numHits()){
									while($qr_objects->nextHit()){
										$vs_icon = "";
										if($va_icon = $qr_objects->get("ca_object_representations.media.widepreview", array("checkAccess" => $va_access_values, "returnAsArray" => true))){
											$vs_icon = $va_icon[0];
											#$va_objects[$qr_objects->get("object_id")] = array("icon" => $vs_icon);
											print "<div class='col-sm-6 col-md-3'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "", "Detail", "GetMediaOverlay", array("context" => "objects", "id" => $qr_objects->get("ca_objects.object_id"), "representation_id" => $qr_objects->get("ca_object_representations.representation_id"), "overlay" => 1, "exhibition_id" => $vn_id))."\"); return false;'>".$vs_icon."</a></div>";
											$va_all_object_ids[] = $qr_objects->get("ca_objects.object_id");
											if($vb_display_faculty && $qr_objects->get("ca_objects.EOYS_Course") && !$va_faculty_by_course[$qr_objects->getWithTemplate("^ca_objects.EOYS_Course")]){
												
												# --- check if there is faculty on the sub exhibition record this object is linked under
												# --- is there a sub exhibit
												if($tmp_faculty = $qr_objects->getWithTemplate("<unit relativeTo='ca_occurrences'><unit relativeTo='ca_occurrences.hierarchy' restrictToTypes='sub_exhibition'><unit relativeTo='ca_entities' restrictToRelationshipTypes='faculty' delimiter=', '>^ca_entities.preferred_labels.displayname</unit></unit></unit>")){
													$va_faculty_by_course[$qr_objects->getWithTemplate("^ca_objects.EOYS_Course")] = $tmp_faculty;
												}
												
											}
										}
									}
								}
?>
								</div>
							</div>
<?php
						}
		$o_context = new ResultContext($this->request, 'ca_objects', 'detailrelated');
		$o_context->setAsLastFind();
		$o_context->setResultList($va_all_object_ids);
		$o_context->saveContext();


?>			
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class='col-sm-12'>
							<div class="container">
								<div class="row topRow">
									<div class='col-md-4'>
										<H6>Description</H6><div class='unitAbstract'>{{{<ifdef code="ca_occurrences.description">^ca_occurrences.description</ifdef>}}}{{{<ifnotdef code="ca_occurrences.description">N/A</ifnotdef>}}}</div>
<?php
												if(is_array($va_faculty_by_course) && sizeof($va_faculty_by_course)){
?>
													<H6>Faculty</H6>
														<div class='unitTop'>
<?php
													foreach($va_faculty_by_course as $vs_course => $vs_faculty){
														print "<div>".$vs_course.": ".$vs_faculty."</div>";
													}
?>
														</div>
<?php
												}
?>

									</div>
									<div class='col-md-8'>
										<div class="row">
											<div class="col-md-5">
												<H6>Title</H6><div class='unitTop'>{{{<ifdef code="ca_occurrences.preferred_labels.name">^ca_occurrences.preferred_labels.name</ifdef>}}}{{{<ifnotdef code="ca_occurrences.preferred_labels.name">N/A</ifnotdef>}}}</div>
												<H6>Opening Date</H6><div class='unitTop'>{{{<ifdef code="ca_occurrences.exh_date.date_opening">^ca_occurrences.exh_date.date_opening</ifdef>}}}{{{<ifnotdef code="ca_occurrences.exh_date.date_opening">N/A</ifnotdef>}}}</div>
												<H6>Closing Date</H6><div class='unitTop'>{{{<ifdef code="ca_occurrences.exh_date.date_closing">^ca_occurrences.exh_date.date_closing</ifdef>}}}{{{<ifnotdef code="ca_occurrences.exh_date.date_closing">N/A</ifnotdef>}}}</div>
											</div>
											<div class="col-md-7">
												<H6>Academic Year</H6>
												<div class='unitTop'>
			<?php
												$vn_year_filter = "";
												$va_years = $t_item->get("ca_occurrences.related", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("academic_year")));
												if(sizeof($va_years)){
													$va_year_display = array();
													foreach($va_years as $va_year){
														if(!$vn_year_filter){
															$vn_year_filter = $va_year["occurrence_id"];
														}
														$va_year_display[] = caNavLink($this->request, $va_year["name"], "", "", "Browse", "exhibitions", array("facet" => "year_facet", "id" => $va_year["occurrence_id"]));
													}
													print join($va_year_display, "; ");
												}else{
													print "N/A";
												}
			?>
												</div>
												<H6>Semester</H6><div class='unitTop'>{{{<ifdef code="ca_occurrences.semester">^ca_occurrences.semester</ifdef>}}}{{{<ifnotdef code="ca_occurrences.semester">N/A</ifnotdef>}}}</div>
												<H6>Exhibition Space</H6><div class='unitTop'>{{{<ifdef code="ca_occurrences.exh_space">^ca_occurrences.exh_space%delimiter,_</ifdef>}}}{{{<ifnotdef code="ca_occurrences.exh_space">N/A</ifnotdef>}}}</div>
												<H6>Additional Exhibition Space</H6><div class='unitTop'>{{{<ifdef code="ca_occurrences.additional_exh_space">^ca_occurrences.additional_exh_space%delimiter,_</ifdef>}}}{{{<ifnotdef code="ca_occurrences.additional_exh_space">N/A</ifnotdef>}}}</div>
											
											</div>
										</div><!-- end row -->
									</div>
								</div><!-- end toprow -->
								
								
								
								<div class="row bottomRow">
									<div class='col-md-8 col-md-offset-4'>
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active tabBorderRight"><a href="#md" aria-controls="md" role="tab" data-toggle="tab">Additional Metadata</a></li>
										</ul>
			
										<!-- Tab panes -->
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane active" id="md">
												<div class="row">
													<div class="col-sm-4">
			<?php
														$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("curator")));
			?>
														<H7>Curator<?php print (sizeof($va_entities) > 1) ? "s" : ""; ?></H7><div class='unitBottom'>
			<?php
														if(sizeof($va_entities)){
															$va_entity_display = array();
															foreach($va_entities as $va_entity){
																$vs_ent_name = $va_entity["displayname"];
																$va_entity_display[$vs_ent_name] = caNavLink($this->request, $vs_ent_name, "", "", "Browse", "projects", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
															}
															ksort($va_entity_display);
															print join($va_entity_display, "<br/>");
														}else{
															print "N/A";
														}
			?>
														</div>
														
														<H7>Subjects</H7><div class='unitBottom'>
					<?php
															$va_list_items = $t_item->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("student_project_subjects")));
															$va_lcsh_terms = $t_item->get("ca_occurrences.subject_lcsh", array("returnWithStructure" => true));
															$va_aat_terms = $t_item->get("ca_occurrences.subject_aat", array("returnWithStructure" => true));
				
												
															if((is_array($va_list_items) && sizeof($va_list_items)) || (is_array($va_lcsh_terms) && sizeof($va_lcsh_terms))){
																$va_terms = array();
																if(is_array($va_list_items) && sizeof($va_list_items)){
																	foreach($va_list_items as $va_list_item){
																		$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Search", "exhibitions", array("search" => $va_list_item["name_singular"]));
																	}
																}
																if(is_array($va_lcsh_terms) && sizeof($va_lcsh_terms)){
																	$va_lcsh_terms = array_pop($va_lcsh_terms);
																	foreach($va_lcsh_terms as $vn_term_id => $va_lcsh_term){
																		$vs_tmp = substr($va_lcsh_term["subject_lcsh"], 0, strpos($va_lcsh_term["subject_lcsh"], " ["));
																		$va_terms[] = caNavLink($this->request, $vs_tmp, "", "", "Search", "exhibitions", array("search" => $vs_tmp));
																	}
																}
																if(is_array($va_aat_terms) && sizeof($va_aat_terms)){
																	$va_aat_terms = array_pop($va_aat_terms);
																	foreach($va_aat_terms as $vn_term_id => $va_aat_term){
																		$vs_tmp = substr($va_aat_term["subject_aat"], 0, strpos($va_aat_term["subject_aat"], " ["));
																		$va_terms[] = caNavLink($this->request, $va_aat_term["aat"], "", "", "Search", "exhibitions", array("search" => $va_aat_term["aat"]));
																	}
																}
																
																print join($va_terms, "<br/>");
															}else{
																print "N/A";
															}
			?>
														</div>
			<?php
														$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("funder")));
			?>
														<H7>Funder<?php print (sizeof($va_entities) > 1) ? "s" : ""; ?></H7><div class='unitBottom'>
			<?php
														if(sizeof($va_entities)){
															$va_entity_display = array();
															foreach($va_entities as $va_entity){
																$vs_ent_name = $va_entity["displayname"];
																$va_entity_display[$vs_ent_name] = caNavLink($this->request, $vs_ent_name, "", "", "Browse", "projects", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
															}
															ksort($va_entity_display);
															print join($va_entity_display, "<br/>");
														}else{
															print "N/A";
														}
			?>
														</div>
													</div>
													<div class="col-sm-4">
			<?php
														$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("author")));
			?>
														<H6>Author<?php print (sizeof($va_entities) > 1) ? "s" : ""; ?></H6><div class='unitBottom'>
			<?php
														if(sizeof($va_entities)){
															$va_entity_display = array();
															foreach($va_entities as $va_entity){
																$vs_ent_name = $va_entity["displayname"];
																$va_entity_display[$vs_ent_name] = caNavLink($this->request, $vs_ent_name, "", "", "Browse", "projects", array("facet" => "entity_facet", "id" => $va_entity["entity_id"]));
															}
															ksort($va_entity_display);
															print join($va_entity_display, "<br/>");
														}else{
															print "N/A";
														}
					?>
														</div>											
														<H7>Related Publications</H7><div class='unitBottom'>
															{{{<ifcount code="ca_occurrences.related" restrictToTypes="publication" min="1">
														
																<unit relativeTo="ca_occurrences.related" restrictToTypes="publication" delimiter="<br/>">
																	<l>^ca_occurrences.preferred_labels.name</l>
																</unit>
															</ifcount>
															<ifcount code="ca_occurrences.related" restrictToTypes="publication" max="0">
															N/A
															</ifcount>}}}
														</div>
													</div>
													<div class="col-sm-4">
														<H7>Rights</H7><div class='unitBottom'>{{{<ifdef code="ca_occurrences.rights">^ca_occurrences.rights</ifdef><ifnotdef code="ca_occurrences.rights">N/A</ifnotdef>}}}</div>
														<H7>Note</H7><div class='unitBottom'>{{{<ifdef code="ca_occurrences.note_public">^ca_occurrences.note_public</ifdef><ifnotdef code="ca_occurrences.note_public">N/A</ifnotdef>}}}</div>
													</div>
												</div><!-- end row -->
											</div>
										</div><!-- end tab-content -->
								
								
								
								
								
									</div>
								</div><!-- end row -->
							</div><!-- end container -->
						</div><!-- end col -->	
					</div><!-- end row -->				
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 frontGalleries">
<?php
			
			if($vn_year_filter){
				$o_browse_occ = caGetBrowseInstance("ca_occurrences");
				$o_browse_occ->setTypeRestrictions(array("exhibition"), array('dontExpandHierarchically' => true));
				$o_browse_occ->addCriteria("academic_year_facet", $vn_year_filter);
				$o_browse_occ->execute(array('checkAccess' => $va_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => false));
	
				$qr_res = $o_browse_occ->getResults(array('sort' => 'ca_occurrences.idno', 'sort_direction' => 'asc'));
				$i = 0;
				if($qr_res->numHits() > 1){
?>
						<div class="frontGallerySlideLabel"><?php print caNavLink($this->request, _t("See All")." <i class='fa fa-caret-down'></i>", "btn-default", "", "Browse", "exhibitions", array("facet" => "academic_year_facet", "id" => $vn_year_filter)); ?>Related Exhibitions <span class='frontGallerySlideLabelSub'><span class="black">(by academic year)</span> / <?php print $qr_res->numHits() - 1; ?> exhibitions</span></div>
						<div class="jcarousel-wrapper">
							<!-- Carousel -->
							<div class="jcarousel relatedItems">
								<ul>
<?php
									while($qr_res->nextHit()){
										if($qr_res->get("ca_occurrences.occurrence_id") != $t_item->get("ca_occurrences.occurrence_id")){
											$vs_image = $qr_res->getWithTemplate("<unit relativeTo='ca_occurrences.children' sort='ca_occurrences.idno'><unit relativeTo='ca_objects' sort='ca_objects.idno'><if rule='^ca_objects.primary_item =~ /Yes/'>^ca_object_representations.media.widepreview</if></unit></unit>", array("checkAccess" => $va_access_values));
											if(!$vs_image){
												$vs_image = $qr_res->getWithTemplate("<unit relativeTo='ca_occurrences.children' sort='ca_occurrences.idno' limit='1'><unit relativeTo='ca_objects' sort='ca_objects.idno' limit='1' delimiter='|'>^ca_object_representations.media.widepreview</unit></unit>", array("checkAccess" => $va_access_values));
											}
											if($vn_p = strpos($vs_image, "|")){
												$vs_image = substr($vs_thumbnail, 0, $vn_p);
											}
											if(!$vs_image){
												$vs_image = caGetThemeGraphic($this->request, 'placeholder.jpg', array("style" => "opacity:.5;"));
											}
											print "<li><div class='slide'>".caDetailLink($this->request, $vs_image, "", "ca_occurrences", $qr_res->get("ca_occurrences.occurrence_id"))."<div class='slideCaption'>".caDetailLink($this->request, $qr_res->get("ca_occurrences.preferred_labels.name"), "", "ca_occurrences", $qr_res->get("ca_occurrences.occurrence_id"))."</div></div></li>";
											$i++;
											if($i > 25){
												break;
											}
										}
									}
?>
								</ul>
							</div><!-- end jcarousel -->
							<!-- Prev/next controls -->
							<a href="#" class="jcarousel-control-prev previousRelated"><i class="fa fa-caret-left"></i></a>
							<a href="#" class="jcarousel-control-next nextRelated"><i class="fa fa-caret-right"></i></a>
						</div><!-- end jcarousel-wrapper -->
						<script type='text/javascript'>
							jQuery(document).ready(function() {
								/*
								Carousel initialization
								*/
								$('.relatedItems')
									.jcarousel({
										// Options go here
										auto: 1,
										wrap: "circular",
										animation:"slow"
									}).jcarouselAutoscroll({
										interval: 0,
										target: '+=1',
										autostart: false
									});
									
									$('.relatedItems').jcarousel({
										animation: {
											duration: 1500, /* lower = faster animation */
											easing:   'linear',
											complete: function() {
											}
										}
									});
								/*
								 Prev control initialization
								 */
								$('.previousRelated')
									.on('jcarouselcontrol:active', function() {
										$(this).removeClass('inactive');
									})
									.on('jcarouselcontrol:inactive', function() {
										$(this).addClass('inactive');
									})
									.jcarouselControl({
										// Options go here
										target: '-=1'
									});

								/*
								 Next control initialization
								 */
								$('.nextRelated')
									.on('jcarouselcontrol:active', function() {
										$(this).removeClass('inactive');
									})
									.on('jcarouselcontrol:inactive', function() {
										$(this).addClass('inactive');
									})
									.jcarouselControl({
										// Options go here
										target: '+=1'
									});
							
								$(".previousRelated").hover(function () {
									$('.relatedItems').jcarouselAutoscroll('reload', {
										interval: 0,
										target: '-=1',
										autostart: false
									});
									$(".relatedItems").jcarouselAutoscroll('start');
								},function () {
									$(".relatedItems").jcarouselAutoscroll('stop');
								});
								$(".nextRelated").hover(function () {
									$('.relatedItems').jcarouselAutoscroll('reload', {
										interval: 0,
										target: '+=1',
										autostart: false
									});
									$(".relatedItems").jcarouselAutoscroll('start');
								},function () {
									$(".relatedItems").jcarouselAutoscroll('stop');
								});
					
							});
						</script>
		<?php
					}
				
			} 			
?>
				</div>
			</div>
		</div><!-- end container -->
<?php
#}
?>