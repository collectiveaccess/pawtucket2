<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
$t_list = new ca_lists(); 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="row">
	<div class='col-xs-12 '><!--- only shown at small screen size -->
		<div class='pageNav'>
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div>
	</div><!-- end detailTop -->
</div>
<div class="row">	
	<div class='col-xs-12 col-lg-10 col-lg-offset-1'>
		<div class="container"><div class="row">
			<div class='col-sm-12'>
<?php
				print "<h2>".$t_object->get('ca_objects.preferred_labels')."</h2>";
?>
			</div>
			<div class='col-sm-7 detailMediaCol'>
				<div class="btn-group" id="detailDD">
					<a href="#" data-toggle="dropdown" class="detailDDLink">Download <i class="fa fa-download"></i></a>
					<ul class="dropdown-menu" role="menu">
<?php
					$vs_download_label = "Download Description";
					if(trim($this->getVar("representationViewer"))){
						print "<li>".caNavLink($this->request, "Download Image", "", "", "Detail", "DownloadMedia", array('object_id' => $vn_id, 'download' => 1))."</li>";
						$vs_download_label = "Download Image and Description";
					}
					print "<li>".caDetailLink($this->request, $vs_download_label, "", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</li>";
?>					
					</ul>
				</div>
				
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
<?php
				$vb_show_thumbs_paging = true;
				$vn_image_count = $t_object->numberOfRepresentationsOfClass('image');
				$vn_rep_count = $t_object->getRepresentationCount();
				#$va_object_ids = $t_object->getRepresentationIDs(array("checkAccess" => $va_access_values));
				if(($vn_rep_count > 6) && ($vn_image_count == $vn_rep_count)){
					$vb_show_thumbs_paging = false;
				}
				if($vb_show_thumbs_paging){
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding  col-xs-4 col-sm-3 col-md-2", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
				}else{
?>
					<script type='text/javascript'>
						jQuery(document).ready(function() {
							$("#detailRepNav").hide();
						});
						
					</script>
<?php					
				}
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-5 rightCol'>
<?php
			if ($vs_description = $t_object->get('ca_objects.description', ['delimiter' => '<br/><br/>'])) {
				print "<div class='unit'>".$vs_description."</div>";
			}			
			# --- identifier

			if($vs_collection_idno = $t_object->get('ca_collections.idno')){
				#print_r(@get_headers("http://iarchives.nysed.gov/xtf/view?docId=tei/".$vs_collection_idno."/".$t_object->get('idno').".xml"));
				# get transcript y/n
				$t_list = new ca_lists();
				$vn_yes_value = $t_list->getItemIDFromList("transcript", "transcript_yes");
					
				if($t_object->get('ca_objects.transcript') == $vn_yes_value) {
					print "<div class='unit'><a href='http://iarchives.nysed.gov/xtf/view?docId=tei/".$vs_collection_idno."/".$t_object->get('idno').".xml' target='_blank' class='btn btn-default'>"._t("Transcript / Translation")."</a></div>";
				}
						
			}
			if($vs_idno = $t_object->get('idno')){
				print "<div class='unit'><b>"._t("Identifier")."</b><br/>".$vs_idno."</div><!-- end unit -->";
			}
			/* JB edit: Turned off date_original display.  Turned on multi-date display. */
			// if ($va_date_array = $t_object->get('ca_objects.date', array('returnWithStructure' => true))) {
				// $t_list = new ca_lists();
				// $vn_original_date_id = $t_list->getItemIDFromList("date_types", "dateOriginal");
				// foreach ($va_date_array as $va_key => $va_date_array_t) {
					// foreach ($va_date_array_t as $va_key => $va_date_array) {
						// if ($va_date_array['dc_dates_types'] == $vn_original_date_id) {
							// print "<div class='unit'><b>Date</b><br/>".$va_date_array['dates_value']."</div>";
						// }
					// }
				// }
				
			// }
			// if($vs_tmp = $t_object->get('date_original')){
				// print "<div class='unit'><b>"._t("Date")."</b><br/>".$vs_tmp."</div><!-- end unit -->";
			// }
			if ($va_date_array = $t_object->get('ca_objects.object_date', array('returnWithStructure' => true))) {
				$t_list = new ca_lists();
				/* Get all list items for date types, in sort order */
				$va_date_type_array = $t_list->getItemsForList("date_types");
				foreach($va_date_type_array as $va_key => $va_date_type) {
					$vs_date_type_idno = $va_date_type[1]['idno'];
					$vs_date_type_label = $va_date_type[1]['name_singular'];
					$vn_date_type_id = $t_list->getItemIDFromList("date_types", $vs_date_type_idno);
					foreach ($va_date_array as $va_key => $va_date_array_t) {
						$vs_date_string = null;
						foreach ($va_date_array_t as $va_key => $va_date_array_v) {
							if ($va_date_array_v['date_type'] == $vn_date_type_id) {
								$vs_date_string .= $va_date_array_v['date_expression']."<br/>";
								// print "<div class='unit'><b>".$vs_date_type_label."</b><br/>".$va_date_array_v['date_expression']."</div>";
							}
						}
						if ($vs_date_string) {
							$vs_date_string = rtrim($vs_date_string, "<br/>");
							print "<div class='unit'><b>".$vs_date_type_label."</b><br/>".$vs_date_string."</div>";
						}
					}
				}
			}
			if ($va_contributor = $t_object->get('ca_objects.contributor', array('convertCodesToDisplayText' => true, 'returnWithStructure' => 'true'))) {
				$va_contributor = array_pop($va_contributor);
				$va_tmp = array();
				foreach($va_contributor as $va_contributor_info){
					$vs_tmp = "";
					$vs_tmp = $va_contributor_info["contributor"];
					if($vs_ctype = $va_contributor_info["contributorType"]){
						$vs_tmp .= " (".$vs_ctype.")";
					}
					if(trim($vs_tmp)){
						$va_tmp[] = $vs_tmp;
					}
				}
				if(sizeof($va_tmp)){
					print "<div class='unit'><b>Contributor</b><br/>";
					print join(", ", $va_tmp);
					print "</div>";
				}
			}
			if ($va_person_names = $t_object->get('ca_objects.person_name2', array('convertCodesToDisplayText' => true, 'returnWithStructure' => 'true'))) {
				$va_person_names = array_pop($va_person_names);
				$va_tmp = array();
				foreach ($va_person_names as $va_person_info) {
					$vs_tmp = "";
					$vs_tmp = $va_person_info['person_name2'];
					if(trim($vs_tmp)){
						$va_tmp[] = $vs_tmp;
					}
				}
				if(sizeof($va_tmp)){
					print "<div class='unit'><b>Names</b><br/>";
					$vs_names_entry = null;
					foreach($va_tmp as $name) {
						$vs_names_entry .= $name."<br/>";
					}
					$vs_names_entry = rtrim($vs_names_entry, "<br/>");
					print $vs_names_entry."</div>";
				}
			}
			if ($va_organizations = $t_object->get('ca_objects.organization_name', array('convertCodesToDisplayText' => true, 'returnWithStructure' => 'true'))) {
				$va_organizations = array_pop($va_organizations);
				$va_tmp = array();
				foreach ($va_organizations as $va_org_info) {
					$vs_tmp = "";
					$vs_tmp = $va_org_info['organization_name'];
					if(trim($vs_tmp)){
						$va_tmp[] = $vs_tmp;
					}
				}
				if(sizeof($va_tmp)){
					print "<div class='unit'><b>Organizations</b><br/>";
					$vs_orgs_entry = null;
					foreach($va_tmp as $name) {
						$vs_orgs_entry .= $name."<br/>";
					}
					$vs_orgs_entry = rtrim($vs_orgs_entry, "<br/>");
					print $vs_orgs_entry."</div>";
				}
			}
			if ($va_document_types = $t_object->get('ca_objects.genreOAG', array('convertCodesToDisplayText' => true, 'returnWithStructure' => 'true'))) {
				$va_document_types = array_pop($va_document_types);
				$va_tmp = array();
				foreach ($va_document_types as $va_org_info) {
					$vs_tmp = "";
					$vs_tmp = $va_org_info['genreOAG'];
					if(trim($vs_tmp)){
						$va_tmp[] = $vs_tmp;
					}
				}
				if(sizeof($va_tmp)){
					print "<div class='unit'><b>Document Types</b><br/>";
					$vs_doctype_entry = null;
					foreach($va_tmp as $name) {
						$vs_doctype_entry .= $name."<br/>";
					}
					$vs_doctype_entry = rtrim($vs_doctype_entry, "<br/>");
					print $vs_doctype_entry."</div>";
				}
			}
			if ($vs_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Language</b><br/>".$vs_language."</div>";
			}			
			#if ($vs_repository = $t_object->get('ca_objects.repository', array('convertCodesToDisplayText' => true))) {
			#	print "<div class='unit'><b>Repository</b><br/>".$vs_repository."</div>";
			#}
			
			if ($vs_source = $t_object->get('ca_objects.source')) {
				print "<div class='unit'><b>Source</b><br/>".$vs_source."</div>";
			}						
			if ($va_rights_array = $t_object->get('ca_objects.rightsList', array('returnWithStructure' => true))) {
				$t_rights_list = new ca_lists();
				$vn_nysa_id = $t_list->getItemIDFromList("rightsType", "NYSArights");
				$vn_nonnysa_id = $t_list->getItemIDFromList("rightsType", "nonNYSArights");
				foreach ($va_rights_array as $va_key => $va_rights_array_t) {
					foreach ($va_rights_array_t as $va_key => $va_rights_array) {
						if ($va_rights_array['rightsList'] == $vn_nysa_id) {
							print "<div class='unit'><b>Rights</b><br/>This image is provided for education and research purposes. Rights may be reserved. Responsibility for securing permissions to distribute, publish, reproduce or other use rest with the user. For additional information see our ".caNavLink($this->request, "Copyright and Use Statement", "", "", "About", "Copyright")."</div>";
						} else if ($va_rights_array['rightsList'] == $vn_nonnysa_id) {
							print "<div class='unit'><b>Rights</b><br/>This record is not part of the New York State Archives' collection and is presented on our project partner's behalf for educational use only.  Please contact the home repository for information on copyright and reproductions.</div>";
						}
					}
				}
				
			}	
			if ($vs_special = $t_object->get('ca_objects.SpecialProject', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Special Project</b><br/>".$vs_special."</div>";
			}					
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b><br/>".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
			}

			# --- Relation
				
			# --- collections
			if ($vs_collections = $t_object->getWithTemplate("<ifcount code='ca_collections' min='1'><unit relativeTo='ca_collections'><l>^ca_collections.preferred_labels</l></unit></ifcount>")){	
				print "<div class='unit'><h3>"._t("More From This Series")."</h3>";
				print $vs_collections;
				print "</div><!-- end unit -->";
			}			
			# --- entities
			if ($vs_entities = $t_object->getWithTemplate("<ifcount code='ca_entities' min='1'><unit relativeTo='ca_entities'><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>")){	
				print "<div class='unit'><h3>"._t("Related entities")."</h3>";
				print $vs_entities;
				print "</div><!-- end unit -->";
			}
			
			# --- places
			$va_places = $t_object->get("ca_places", array("checkAccess" => $va_access_values, "returnWithStructure" => true));
			if(is_array($va_places)){
				$va_place_links = array();
				foreach($va_places as $va_place){
					$va_place_links[] = caNavLink($this->request, $va_place['name'], '', '', 'Browse', 'objects', array('facet' => 'place_facet', 'id' => $va_place['place_id']));
				}
				
				if(sizeof($va_place_links)){
					print "<div class='unit'><h3>"._t("Geographic Locations")."</h3>";
					print join("<br/>", $va_place_links);
					print "</div><!-- end unit -->";
				}
			}
			
			#$vs_places = $t_object->getWithTemplate("<unit relativeTo='ca_places' delimiter='<br/>'><l>^ca_places.preferred_labels.name</l></unit>");
			#if($vs_places){
			#	print "<div class='unit'><h3>"._t("Geographic Locations")."</h3>";
			#	print $vs_places;
			#	print "</div><!-- end unit -->";
			#}
			
			# --- lots
			$vs_object_lots = $t_object->getWithTemplate("<ifcount code='ca_lots' min='1'><unit relativeTo='ca_lots'>^ca_lots.preferred_labels.name (^ca_lots.idno_stub)</unit></ifcount>");
			if($vs_object_lots){
				print "<div class='unit'><h3>"._t("Related lot")."</h3>";
				print $vs_object_lots;
				print "</div><!-- end unit -->";
			}
			
			# --- vocabulary terms
			$vs_terms = $t_object->getWithTemplate("<ifcount code='ca_list_items' min='1'><unit relativeTo='ca_list_items'>^ca_list_items.preferred_labels.name_plural</unit></ifcount>");
			if($vs_terms){
				print "<div class='unit'><h3>"._t("Subjects")."</h3>";
				print $vs_terms;
				print "</div><!-- end unit -->";
			}
			
					
			# --- output related object images as links
			if ($va_related_objects = $t_object->get("ca_objects.related.preferred_labels", array("returnAsLink" => true, 'checkAccess' => $va_access_values, 'delimiter' => '<br/>'))){
				print "<div class='unit'><h3>Related Objects</h3>".$va_related_objects."</div>";
			}
?>
				
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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
