<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
	$t_lists = new ca_lists();
	$va_publication_types = array($t_lists->getItemIDFromList("object_types", "article"), $t_lists->getItemIDFromList("object_types", "book"), $t_lists->getItemIDFromList("object_types", "serial"), $t_lists->getItemIDFromList("object_types", "catalog"));

	if(!function_exists('_procKeyword')) {
		function _procKeyword($word) {
			//return preg_replace("![\-\(\)]!", " ", $word);
			#$word = trim(preg_replace("![\.]+!", "", $word));
			return $word; //trim(preg_replace("!\(.*$!", "", $word));
		}
	}
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6'>
					<div class="detailTool"><?= caNavLink($this->request, '<span class="glyphicon glyphicon-comment"></span> '._t('Contact us'), '', '', 'Help', 'Index'); ?></div><!-- end detailTool -->
				{{{representationViewer}}}
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
<?php if ($this->getVar('commentsEnabled')) { ?>
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
<?php } ?>
				</div><!-- end detailTools -->
<?php
				$vs_rights_buf = null;

				if (($va_rights_bundle = $t_object->get('ca_objects.rights', array('returnWithStructure' => true))) || ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes")) {
					foreach ($va_rights_bundle as $va_att_key => $va_rights_list) {
						foreach ($va_rights_list as $va_key => $va_rights) {
							if ($va_rights['rightsText']) {
								$vs_rights_buf.= "<div><label>Rights & Restrictions: </label>".$va_rights['rightsText']."</div>";
							}
							if ($va_rights['endRestriction']) {
								$vs_rights_buf.= "<div><b>End of restriction: </b>".$va_rights['endRestriction']."</div>";
							}
							if ($va_rights['endRestrictionNotes']) {
								$vs_rights_buf.= "<div><b>End of restriction notes: </b>".$va_rights['endRestrictionNotes']."</div>";
							}
							if ($va_rights['rightsHolder']) {
								$vs_rights_buf.= "<div><b>Rights Holder: </b>".$va_rights['rightsHolder']."</div>";
							}
							if ($va_rights['copyrightStatement']) {
								$vs_rights_buf.= "<div><b>Copyright statement: </b>".$va_rights['copyrightStatement']."</div>";
							}																																								
						}
					}
					print '<div class="mobileDisplayHide">';
					if ($vs_rights_buf  || ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes")) {
						print "<div class='unit'><label>Rights & User Restrictions</label>".$vs_rights_buf."</div>";
					}
					if ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes") {
						print "Public Domain";
					}	
					print "</div>";							
				}
				// if ($vs_copyright_statement = $t_object->get('ca_objects.rights.copyrightStatement')){
// 					print "<div class='unit'><label>Copyright</label>{$vs_copyright_statement}</div>";
// 				}
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				print "<div class='entity'>".$t_object->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('author', 'collected', 'creator', 'engraver', 'draftsmen_surveyor', 'lithographer', 'photographer')))."</div>";
?>			
				<H1><i>{{{ca_objects.preferred_labels.name}}}</i></H1> 
				<HR>
<?php
					if ($vs_identifier = $t_object->get('ca_objects.idno')){
						print "<div class='unit'><label>Identifier</label>".$vs_identifier."</div>";
					}
					if ($vs_pub_description = $t_object->get('ca_objects.publication_description')){
						print "<div class='unit'><label>Publication Information</label>".$vs_pub_description."</div>";
					}
					$va_format_buf = null;
					if ($t_object->get('ca_objects.format')) {
						$va_format_buf .= "<div class='unit'><label>Format</label>".$t_object->get('ca_objects.format')."</div>";
					}
					if (($t_object->get('ca_objects.digitization_info.digital_status') != "-") && $t_object->get('ca_objects.digitization_info.digital_status')) {
						$va_format_buf .= "<div class='unit'><label>Digitization Status</label>".$t_object->get('ca_objects.digitization_info.digital_status', array('convertCodesToDisplayText' => true))."</div>";
					}
					if ($t_object->get('ca_objects.reproduction')) {
						$va_format_buf .= "<div class='unit'><label>Reproduction: </label>".$t_object->get('ca_objects.reproduction', array('convertCodesToDisplayText' => true, 'delimiter' => '<br/>'))."</div>";
					}
					$va_dims_buf = null;
					if ($t_object->get('ca_objects.dimensions')) {
						$va_dimensions_list = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true));
						
						foreach ($va_dimensions_list as $va_dims_key => $va_dimensions) {
							foreach ($va_dimensions as $va_dim => $va_dimension) {
								#if ($va_dimension['is_primary'] == 'yes'){
									$va_dims = array();
									if ($va_dimension['dimensions_length']) {
										$va_dims[] = $va_dimension['dimensions_length']." L";
									}
									if ($va_dimension['dimensions_width']) {
										$va_dims[] = $va_dimension['dimensions_width']." W";
									}
									if ($va_dimension['dimensions_height']) {
										$va_dims[] = $va_dimension['dimensions_height']." H";
									}
									if ($va_dimension['dimensions_weight']) {
										$va_dims[] = $va_dimension['dimensions_weight']." Weight";
									}
									$va_dims_buf .= join(' x ', $va_dims);
									#if ($va_dimension['measurement_notes']) {
									#	$va_dims_buf .= "<b>Notes: </b>".$va_dimension['measurement_notes']."<br/>";
									#}
									if ($va_dimension['measurement_type']) {
										$va_dims_buf .= " (".$va_dimension['measurement_type'].")";
									}
									$va_dims_buf .= "<br/>"; 
								#}																																								
							}
						}
						$va_format_buf .= "<div class='unit'><label>Dimensions</label>".$va_dims_buf."</div>";
					}
					if ($t_object->get('ca_objects.scale')) {
						 $va_format_buf .= "<div class='unit'><label>Scale</label>".$t_object->get('ca_objects.scale')."</div>";
					}
					if ($vs_extent = $t_object->get('ca_objects.extent_text')) {
						$va_format_buf .= "<div class='unit'><label>Extent</label>".$vs_extent."</div>";
					}																				
					if ($va_format_buf) {
						print "<div class='unit'>".$va_format_buf."</div>";
					}					
					#if ($vs_coll_identifier = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true))){
					#	print "<div class='unit'><label>Collection Identifier</label>".$vs_coll_identifier."</div>";
					#}					
					if ($t_object->get('ca_objects.type_id')) {
						print "<div class='unit'><label>Type</label>".$t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</div>";
					}								
					if ($vs_date = $t_object->get('ca_objects.date_created')){
						print "<div class='unit'><label>Date created</label>".$vs_date."</div>";
					}
					if ($vs_description = $t_object->get('ca_objects.description.description_text')){
						print "<div class='unit'><label>Description</label>".$vs_description."</div>";
					}
					if ($vs_appeared = $t_object->get('ca_objects.appeared_in')){
						print "<div class='unit'><label>Appeared In</label>".$vs_appeared."</div>";
					}
					if($va_links = $t_object->get('ca_objects.external_link', array("returnWithStructure" => true))){
						$va_formatted_links = array();
						foreach(array_pop($va_links) as $va_link){
							$vs_link_text = $va_link["url_source"];
							$vs_link = $va_link["url_entry"];
							if(!$vs_link_text){
								$vs_link_text = $vs_link;
							}
							if($vs_link){
								$va_formatted_links[] = "<a style='word-wrap: break-word;' href='".$vs_link."' target='_blank'>".$vs_link_text."</a>";
							}
						}
						if(sizeof($va_formatted_links)){
							print "<div class='unit'><label>URL".((sizeof($va_formatted_links) > 1) ? "s" : "")."</label>".join(", ", $va_formatted_links)."</div>";
						}
					}
					if(in_array($t_object->get("type_id"), $va_publication_types)){
						if($vs_tmp = $t_object->get('ca_objects.abstract')){
							print "<div class='unit'><label>Abstract</label>".$vs_tmp."</div>";
						}
						if($va_other_identifiers = $t_object->get('ca_objects.other_identifiers', array("returnWithStructure" => true, "convertCodesToDisplayText" => true))){
							$va_issn = array();
							$va_isbn = array();
							foreach(array_pop($va_other_identifiers) as $va_other_identifier){
								if($va_other_identifier["other_identifier_type"] == "ISBN number"){
									$va_isbn[] = $va_other_identifier["legacy_identifier"];
								}
								if($va_other_identifier["other_identifier_type"] == "ISSN number"){
									$va_issn[] = $va_other_identifier["legacy_identifier"];
								}
							}
							if(sizeof($va_isbn)){
								print "<div class='unit'><label>ISBN</label>".join(", ", $va_isbn)."</div>";
							}
							if(sizeof($va_issn)){
								print "<div class='unit'><label>ISSN</label>".join(", ", $va_issn)."</div>";
							}
						}			
						if($vs_tmp = $t_object->get("ca_objects.alternate_titles.altTitle", array("delimiter" => "<br/>"))){
							print "<div class='unit'><label>Alternate Title</label>".$vs_tmp."</div>";
						}
						$va_tmp = array();
						$va_tmp_title = array();
						if($vs_tmp = $t_object->get('ca_objects.volume')){
							$va_tmp[] = $vs_tmp;
							$va_tmp_title[] = "Volume";
						}
						if($vs_tmp = $t_object->get('ca_objects.issue')){
							$va_tmp[] = $vs_tmp;
							$va_tmp_title[] = "Issue";
						}
						if($vs_tmp = $t_object->get('ca_objects.page_number')){
							$va_tmp[] = $vs_tmp;
							$va_tmp_title[] = "Page Number";
						}
						if(sizeof($va_tmp)){
							print "<div class='unit'><label>".join(", ", $va_tmp_title)."</label>".join(", ", $va_tmp)."</div>";
						}

					}
					$va_subjects_list = array();
					if ($va_subject_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						foreach ($va_subject_terms as $va_term => $va_subject_term) {
							trim($va_subject_term);
							if (!$va_subject_term) { continue; }
							$va_subject_term_list = explode('[', $va_subject_term);
							$va_subjects_list[] = caNavLink($this->request, ucfirst($va_subject_term_list[0]), '', '', 'Search', 'objects', ['search' => 'ca_objects.lcsh_terms:"'._procKeyword($va_subject_term_list[0]).'"']);
						}
					}
					if ($va_subject_terms_text = $t_object->get('ca_objects.lcsh_terms_text', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						foreach ($va_subject_terms_text as $va_text => $va_subject_term_text) {
							trim($va_subject_term_text);
							if (!$va_subject_term_text) { continue; }
							$va_subjects_list[] = caNavLink($this->request, ucfirst($va_subject_term_text), '', '', 'Search', 'objects', ['search' => 'ca_objects.lcsh_terms_text:"'._procKeyword($va_subject_term_text).'"']);
						}
					}
					if ($va_subject_genres = $t_object->get('ca_objects.lcsh_genres', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						foreach ($va_subject_genres as $va_text => $va_subject_genre) {
							trim($va_subject_genre);
							if (!$va_subject_genre) { continue; }
							$va_subjects_list[] = caNavLink($this->request, ucfirst($va_subject_genre), '', '', 'Search', 'objects', ['search' => 'ca_objects.lcsh_genres:"'._procKeyword($va_subject_genre).'"']);
						}
					}
					if ($va_subject_keywords = $t_object->get('ca_list_items.preferred_labels', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						$idnos = $t_object->get('ca_list_items.idno', array('returnAsArray' => true, 'checkAccess' => $va_access_values));
						foreach ($va_subject_keywords as $i => $va_subject_keyword) {
							trim($va_subject_keyword);
							if (!$va_subject_keyword) { continue; }
							$va_subjects_list[] = caNavLink($this->request, ucfirst($va_subject_keyword), '', '', 'Search', 'objects', ['search' => 'termid:"'.$idnos[$i].'"']);
						}
					}																
					asort($va_subjects_list);
					if (sizeof($va_subjects_list) > 0) {
						print "<div class='unit'><label>Subject - keywords and LC headings</label>".join("<br/>", $va_subjects_list)."</div>";
					}																											
							if ($va_related_entities = $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="author,accession,collected,creator,donor,engraver,draftsmen_surveyor,lithographer,origin,photographer"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
								print "<div class='unit'><label>Related Entities</label>".$va_related_entities."</div>";
							}
							if ($va_related_objects = $t_object->get('ca_objects.related.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'excludeRelationshipTypes' => array('appears')))) {
								print "<div class='unit'><label>Related Objects</label>".$va_related_objects."</div>";
							}
							if ($va_related_collections = $t_object->get('ca_collections.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true))) {
								print "<div class='unit'><label>Related Collections</label>".$va_related_collections."</div>";
							}
							if ($t_object->get('ca_objects.coverageSpatial')) {
								print "<div class='unit'><label>Spatial Coverage</label>".$t_object->get('ca_objects.coverageSpatial')."</div>";
							}
							if ($t_object->get('ca_objects.coverageDates')) {
								print "<div class='unit'><label>Coverage dates</label>".$t_object->get('ca_objects.coverageDates')."</div>";
							}	
							if ($t_object->get('ca_objects.coverageNotes')) {
								print "<div class='unit'><label>Coverage notes</label>".$t_object->get('ca_objects.coverageNotes')."</div>";
							}					
							if ($vs_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
								print "<div class='unit'><label>Language</label>".$vs_language."</div>";
							}
							if ($vs_credit_line = $t_object->get('ca_objects.credit_line')) {
								print "<div class='unit'><label>Credit Line</label>".$vs_credit_line."</div>";
							}
							
							#if (($vs_appeared = $t_object->get('ca_objects.appeared_in')) | ($va_appears = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('appears'))))) {
							#	print "<div class='unit'><label>Appeared In</label>".$vs_appeared."<br/>".$va_appears."</div>";
							#}
?>
							{{{<ifdef code='ca_objects.georeference'><div class='unit'><label>Location</label></ifdef>}}}
							{{{map}}}
							{{{<ifdef code='ca_objects.georeference'></div></ifdef>}}}
					<div class="mobileDisplayShow">
<?php
					if ($vs_rights_buf  || ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes")) {
						print "<div class='unit'><label>Rights & User Restrictions</label>".$vs_rights_buf."</div>";
					}
					if ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes") {
						print "Public Domain";
					}
?>
					</div>
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
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