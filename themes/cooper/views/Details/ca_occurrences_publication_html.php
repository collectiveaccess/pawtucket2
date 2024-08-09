<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_publication_html.php : 
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
	
	# --- get content category list item ids for Text and Transcript so can separate from images
	$t_list = new ca_lists();
	$vn_content_category_text = $t_list->getItemIDFromList("content_categories", "Text");
	$vn_content_category_transcript = $t_list->getItemIDFromList("content_categories", "Transcript");
	
	require_once(__CA_LIB_DIR__.'/Search/ObjectSearch.php');
if($vb_ajax){
	# --- display media for child record on ajax load
	print $this->getVar("representationViewer");
}else{

?>
<div class="continer">
	<div class="row">
		<div class="col-sm-12" id="imageHere"></div>
	</div>
</div>
		<div class="container">
			<div class="row">
				<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
					{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
			<div class="row">
				<div class='col-sm-12 col-md-offset-2 col-md-8'>
{{{representationViewer}}}
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-md-offset-2 col-md-8'>
					<div class="row topRow">
						<div class='col-md-4'>
							<H6>Description</H6><div class='unitAbstract'>{{{<ifdef code="ca_occurrences.Pub_DESC">^ca_occurrences.Pub_DESC</ifdef>}}}{{{<ifnotdef code="ca_occurrences.Pub_DESC">N/A</ifnotdef>}}}</div>
						</div>
						<div class='col-md-8'>
							<div class="row">
								<div class="col-md-5">
									<H6>Title</H6><div class='unitTop'>{{{<ifdef code="ca_occurrences.preferred_labels.name">^ca_occurrences.preferred_labels.name</ifdef>}}}{{{<ifnotdef code="ca_occurrences.preferred_labels.name">N/A</ifnotdef>}}}</div>
									<H6>Author(s)</H6><div class='unitTop'>
<?php
									$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("author")));
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
									<H6>Contributor(s)</H6><div class='unitTop'>
<?php									$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("contributor")));
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
									<H6>Editor(s)</H6><div class='unitTop'>
<?php									$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("editor")));
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
									<H6>Funder(s)</H6><div class='unitTop'>
<?php									$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("funder")));
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
								<div class="col-md-7">
									<H6>Publisher(s)</H6><div class='unitTop'>
<?php									$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("publisher")));
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
									<H6>Publication Date</H6>
									<div class='unitTop'>
										{{{<ifdef code="ca_occurrences.publication_date">^ca_occurrences.publication_date</ifdef><ifnotdef code="ca_occurrences.publication_date">N/A</ifnotdef>}}}
									</div>
									<H6>Place of Publication</H6>
									<div class='unitTop'>
										{{{<ifdef code="ca_occurrences.publication_place">^ca_occurrences.publication_place</ifdef><ifnotdef code="ca_occurrences.publication_place">N/A</ifnotdef>}}}
									</div>
									<H6>Related Exhibition</H6>
									<div class='unitTop'>
										{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="exhibition">
											<unit relativeTo="ca_occurrences.related" restrictToTypes="exhibition" delimiter="<br/>">
												<l>^ca_occurrences.preferred_labels.name</l>
											</unit>
										</ifcount>
										<ifcount code="ca_occurrences" max="0" restrictToTypes="exhibition">N/A</ifcount>}}}
									</div>
									<H6>Identifier</H6>
									<div class='unitTop'>
										{{{<ifdef code="ca_occurrences.idno">^ca_occurrences.idno</ifdef><ifnotdef code="ca_occurrences.idno">N/A</ifnotdef>}}}
									</div>
								</div>
							</div><!-- end row -->
						</div>
					</div><!-- end toprow -->
					
					
					
				</div>
			</div>

		</div><!-- end container -->
<?php
}
?>