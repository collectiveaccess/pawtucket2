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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = 	$this->getVar("access_values");
	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 navLeftRight'>
		<small>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</small>
	</div>
	<div class='col-xs-12'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				print '<div id="detailTools">';
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $this->request->user->hasRole("frontendDownload")) {
					if($this->request->user->hasRole("frontendDownload")){
						print '<div class="detailTool"><span class="glyphicon glyphicon-download"></span>'.caNavLink($this->request, _t("Download High Resolution Media"), "", "", "Detail", "DownloadMedia", array("object_id" => $t_object->get("object_id"), "download" => 1, "version" => "original")).'</div><!-- end detailTool -->';
					}		 				
					print '<div class="detailTool"><span class="glyphicon glyphicon-book"></span>'.caNavLink($this->request, _t("Ask an Archivist"), "", "", "Contact", "Form", array("object_id" => $t_object->get("object_id"), "contactType" => "askArchivist")).'</div><!-- end detailTool -->';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print (sizeof($va_comments) + sizeof($va_tags)); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					
				}
				if($this->request->isLoggedIn()){
					print '<div class="detailTool"><span class="glyphicon glyphicon-upload"></span>'.caNavLink($this->request, _t("Contribute content"), "", "", "Contribute", "objects", array("ref_table" => "ca_objects", "ref_row_id" => $t_object->get("object_id"))).'</div><!-- end detailTool -->';
					#print "<div class='detailTool'><span class='glyphicon glyphicon-upload'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Contribute', 'objects', array("ref_table" => "ca_objects", "ref_row_id" => $t_object->get("object_id")))."\"); return false;' >"._t("Contribute content")."</a></div><!-- end detailTool -->";
				}else{
					print "<div class='detailTool'><span class='glyphicon glyphicon-upload'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm')."\"); return false;' >"._t("Login to contribute content")."</a></div><!-- end detailTool -->";
				}
				print '</div><!-- end detailTools -->';					
				if($this->getVar("representation_id")){
?>
					<div class='unit restriction'>{{{rights_text}}}</div>
<?php
				}
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR></HR>
				{{{<ifdef code="ca_objects.idno"><H6>Identifer</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.overall_date"><H6>Date</H6>^ca_objects.overall_date<br/></ifdev>}}}
				{{{<ifdef code="ca_objects.cdwa_indexingMeasurementsSet.dimensions_height|ca_objects.cdwa_indexingMeasurementsSet.dimensions_width|ca_objects.cdwa_indexingMeasurementsSet.dimensions_depth|ca_objects.cdwa_indexingMeasurementsSet.dimensions_diameter"><H6>Dimensions</H6><unit delimiter="<br/>">^ca_objects.cdwa_indexingMeasurementsSet.dimensions_height<ifdef code="ca_objects.cdwa_indexingMeasurementsSet.dimensions_height,ca_objects.cdwa_indexingMeasurementsSet.dimensions_width"> x </ifdef><ifdef code="ca_objects.cdwa_indexingMeasurementsSet.dimensions_width">^ca_objects.cdwa_indexingMeasurementsSet.dimensions_width</ifdef><ifdef code="ca_objects.cdwa_indexingMeasurementsSet.dimensions_depth"> x ^ca_objects.cdwa_indexingMeasurementsSet.dimensions_depth</ifdef><ifdef code="ca_objects.cdwa_indexingMeasurementsSet.dimensions_diameter"> x ^ca_objects.cdwa_indexingMeasurementsSet.dimensions_diameter</ifdef></unit></ifdef>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1" max="1"><H6>Creator</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="2"><H6>Creators</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
				
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="author" min="1" max="1"><H6>Author</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="author" min="2"><H6>Authors</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
				
				{{{<ifdef code="ca_objects.description|ca_objects.content_description"><HR></HR></ifdef>}}}
				{{{<ifdef code="ca_objects.description"><H6>Physical Description</H6><span class="trimText">^ca_objects.description</span></ifdef>}}}
				{{{<ifdef code="ca_objects.content_description"><H6>Content</H6><span class="trimText">^ca_objects.content_description</span></ifdef>}}}

				
<?php
				if($vs_access = trim($t_object->get("ca_objects.accessrestrict"))){
					print "<div class='unit'><H6>Conditions Governing Access and Use</H6>";
					print $vs_access;
					print "</div>";
				}
?>
				{{{<ifdef code="ca_objects.transcription"><H6>Transcription</H6><span class="trimText">^ca_objects.transcription</span></ifdef>}}}

				{{{<case>
						 <ifcount code="ca_entities.related" min="1"><hr></hr></ifcount>
						 <ifcount code="ca_collections.related" min="1"><hr></hr></ifcount>
						 <ifcount code="ca_list_items.related" min="1"><hr></hr></ifcount>
					</case>}}}
				{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related Collection</H6></ifcount>}}}
				{{{<ifcount code="ca_collections" min="2"><H6>Related Collections</H6></ifcount>}}}
				{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
				
				{{{<ifcount code="ca_entities" excludeRelationshipTypes="author,creator" min="1" max="1"><H6>Related Person</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" excludeRelationshipTypes="author,creator" min="2"><H6>Related People</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" excludeRelationshipTypes="author,creator" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit>}}}
				
		<?php
				$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true));
				if(sizeof($va_list_items)){
					print "<H6>Related Subject".((sizeof($va_list_items) > 1) ? "s" : "")."</H6>";
					$va_terms = array();
					foreach($va_list_items as $va_list_item){
						$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => urlencode($va_list_item["item_id"])));
					}
					print join($va_terms, "<br/>");
				}

				$va_lcsh_terms = $t_object->get("ca_objects.lcsh_terms", array("returnAsArray" => true));
 				if(sizeof($va_lcsh_terms)){
 					print "<H6>Library of Congress Subjects</H6>";
 					$va_terms = array();
 					foreach($va_lcsh_terms as $vs_lcsh_term){
 						$vn_chop = stripos($vs_lcsh_term, "[");
 						$va_terms[] = caNavLink($this->request, ($vn_chop) ? substr($vs_lcsh_term, 0, $vn_chop) : $vs_lcsh_term, "", "", "Browse", "objects", array("facet" => "lcsh_facet", "id" => urlencode($vs_lcsh_term)));
 						#$va_terms[] = ($vn_chop) ? substr($vs_lcsh_term, 0, $vn_chop) : $vs_lcsh_term;
 					}
 					print join($va_terms, "<br/>");
 				}
				if ($va_related_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					print "<hr></hr><div class='container relatedObjects' style='padding-left:0px;'><h6>Related objects</h6>";
					foreach ($va_related_object_ids as $va_key => $va_related_object_id) {
						$t_rel_object = new ca_objects($va_related_object_id);
						print "<div class='unit row'><div class='col-sm-6'>";
						print caNavLink($this->request, $t_rel_object->get('ca_object_representations.media.iconlarge'), '', '', 'Detail', 'objects/'.$va_related_object_id)."</div>";
						print "<div class='col-sm-6'><div class='caption'>".$t_rel_object->get('ca_objects.preferred_labels', array('returnAsLink' => true))."</div>";
						print "</div></div>";
					}
					print "</div>";
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
		  maxHeight: 130
		});
		$(function () {
		  $('[data-toggle="popover"]').popover()
		})
	});
</script>