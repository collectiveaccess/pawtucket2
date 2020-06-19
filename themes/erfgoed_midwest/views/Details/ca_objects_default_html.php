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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	
	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"));
	MetaTagManager::addMetaProperty("og:title", $t_object->get("ca_objects.preferred_labels.name"));
	MetaTagManager::addMetaProperty("og:type", "website");
	if($vs_tmp = $t_object->getWithTemplate($t_object->get("ca_objects.content_description"))){
		MetaTagManager::addMetaProperty("og:description", htmlentities(strip_tags($vs_tmp)));
	}
	#if($vs_tmp = $va_config_options["fb_app_id"]){
	#	MetaTagManager::addMetaProperty("fb:app_id", $vs_tmp);
	#}
	if($vs_rep = $t_object->get("ca_object_representations.media.page.url", array("checkAccess" => $va_access_values))){
		MetaTagManager::addMetaProperty("og:image", $vs_rep);
		MetaTagManager::addMetaProperty("og:image:width", $t_object->get("ca_object_representations.media.page.width"));
		MetaTagManager::addMetaProperty("og:image:height", $t_object->get("ca_object_representations.media.page.height"));
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
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				#if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
?>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=2210553328991338&autoLogAppEvents=1"></script>
					<div class='detailTool'>
						<div class="fb-share-button" data-href="<?php print $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" data-layout="button" data-size="small"><a target="_blank" href="<?php print $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" class="fb-xfbml-parse-ignore">Share</a></div>
					</div>
<?php
					
					print "<div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> "._t("Inquire About This Item"), "", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
					
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span><?php print _t("Comments and Tags"); ?> (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
<?php
						if($this->request->isLoggedIn()){
?>
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php					
						}else{
							print "<div id='detailComments'><button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."/"._t("Register")."</button></div>";

						}								
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				#}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<H4>{{{^ca_objects.preferred_labels.name}}}</H4>
				<HR>
				
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="owner" min="1"><div class="unit"><H6>Collectie</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="owner" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Objectnummer</H6>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.object_names"><div class="unit"><H6>Object Name</H6>^ca_objects.object_names%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.object_keywords"><div class="unit"><H6>Keywords</H6>^ca_objects.object_keywords%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.object_tags"><div class="unit"><H6>Tags</H6>^ca_objects.object_tags%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Descriptive Note</h6>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><div class="unit"><H6>Vervaardiger</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
<?php
				if($t_object->get("type_id", array("convertCodesToDisplayText" => true)) != "Publication"){
					$t_object->getWithTemplate('<ifdef code="ca_objects.object_creation_date"><div class="unit"><H6>Creation Date</H6>^ca_objects.object_creation_date%delimiter=,_</div></ifdef>');
				}
?>
				{{{<ifdef code="ca_objects.object_creation_period"><div class="unit"><H6>Creation Period</H6>^ca_objects.object_creation_period%delimiter=,_</div></ifdef>}}}
<!-- publication fields -->
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="author" min="1"><div class="unit"><H6>Author</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.nonpreferred_labels"><div class="unit"><H6>Alternate Title</H6>^ca_objects.nonpreferred_labels%delimiter=,_</div></ifdef>}}}
<?php
				if($t_object->get("type_id", array("convertCodesToDisplayText" => true)) == "Publication"){
					$t_object->getWithTemplate('<ifdef code="ca_objects.object_creation_date"><div class="unit"><H6>Publication Date</H6>^ca_objects.object_creation_date%delimiter=,_</div></ifdef>');
				}
?>
				{{{<ifdef code="ca_objects.publication_medium"><div class="unit"><H6>Medium / Type of Resource</H6>^ca_objects.publication_medium%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.publication_edition"><div class="unit"><H6>Edition</H6>^ca_objects.publication_edition%delimiter=,_</div></ifdef>}}}
				{{{<ifcount code="ca_places" restrictToRelationshipTypes="published" min="1"><div class="unit"><H6>Publication Place</H6><unit relativeTo="ca_places" restrictToRelationshipTypes="published" delimiter=", ">^ca_places.preferred_labels</unit></div></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="publisher" min="1"><div class="unit"><H6>Publisher</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
				
<!-- END publication fields -->				
				{{{<ifdef code="ca_objects.content_description">
					<div class='unit'><h6>Content Description</h6>
						<span class="trimText">^ca_objects.content_description</span>
					</div>
				</ifdef>}}}
				
				
							
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="depicts" min="1" max="1"><H6>Person</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="depicts" min="2"><H6>People</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="depicts" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>}}}
				{{{<ifcount code="ca_places" min="1" max="1"><H6>Place</H6></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><H6>Places</H6></ifcount>}}}
				{{{<unit relativeTo="ca_places" delimiter="<br/>"><unit relativeTo="ca_places.hierarchy" delimiter=" &gt; "><l>^ca_places.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
				{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Event</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><H6>Events</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>">^ca_occurrences.preferred_labels (^relationship_typename)</unit>}}}
				{{{<ifcount code="ca_objects.related" min="1" max="1"><H6>Object</H6></ifcount>}}}
				{{{<ifcount code="ca_objects.related" min="2"><H6>Objects</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels</l> (^relationship_typename)</unit>}}}
				
				
				<br/><br/><div class="unit">{{{map}}}</div>
						
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