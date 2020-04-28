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
	if (!($this->request->isLoggedIn())) {
		print $this->render("LoginReg/form_login_html.php");
		
	}else{

	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				print '<div id="detailTools">';
				$t_rep = $this->getVar("t_representation");
				if($t_rep && $t_rep->get("representation_id")){
					$va_rep_info = $t_rep->getMediaInfo('media', 'original');
					print "<H6>Media information</H6>";
					print "Size: ".round($va_rep_info["PROPERTIES"]["filesize"]/1000000, 2)."MB<br/>";
					print "Format: ".$va_rep_info["MIMETYPE"]."<br/>";
					print "<hr></hr>";					
				}
				# Comment and Share Tools						
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {

					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
				}
				print '</div><!-- end detailTools -->';
				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator"><H6>Creator</H6><unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="author"><H6>Author</H6><unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="author"><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}
				{{{<ifdef code="ca_objects.date_created"><H6>Date created</H6>^ca_objects.date_created<br/></ifdev>}}}
			
				{{{<ifdef code="ca_objects.abstract">
					<div class='unit'><h6>Abstract</h6>
						<span class="text">^ca_objects.abstract</span>
					</div>
				</ifdef>}}}
				
				
				<hr></hr>		
				{{{<ifcount code="ca_entities" min="1" max="1" excludeRelationshipTypes="author,creator"><H6>Related entity</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2" excludeRelationshipTypes="author,creator"><H6>Related entities</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>" excludeRelationshipTypes="author,creator"><unit relativeTo="ca_entities" excludeRelationshipTypes="author,creator"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
				
				{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
				{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
				{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit>}}}
				
				
<?php
				$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true));
				if(sizeof($va_list_items)){
					print "<H6>Related term".((sizeof($va_list_items) > 1) ? "s" : "")."</H6>";
					$va_terms = array();
					foreach($va_list_items as $va_list_item){
						$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => urlencode($va_list_item["item_id"])));
					}
					print join($va_terms, "<br/>");
				}
?>
				
				{{{map}}}
						
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
		  maxHeight: 40
		});
	});
</script>
<?php
}
?>