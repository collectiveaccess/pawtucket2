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
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");

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

				
				<?php #print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				if ($va_embed = $t_object->get('ca_objects.embed_code')) {
					print "<div class='unit videoContainer'><h6>Watch</h6>".$va_embed."</div>";
				}
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
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
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>  
				<HR>
<?php
				if (($va_alt_title = $t_object->get('ca_objects.nonpreferred_labels', array('delimiter' => ', '))) != "[BLANK]") {
					print "<div class='unit'><h6>subtitle</h6>".$va_alt_title."</div>";
				}
?>				
				{{{<ifdef code="ca_objects.idno"><div class='unit'><H6>Identifer</H6>^ca_objects.idno</unit></ifdef>}}} 
<?php
				if ($va_series = $t_object->get('ca_objects.related.preferred_labels', array('restrictToTypes' => array('series'), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Series</h6>".$va_series."</div>";
				}
				if ($va_program = $t_object->get('ca_objects.related.preferred_labels', array('restrictToTypes' => array('program'), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Related Programs</h6>".$va_program."</div>";
				}				
				if ($va_date = $t_object->get('ca_objects.productionDate', array('delimiter' => ', '))) {
					print "<div class='unit'><h6>Production Year</h6>".$va_date."</div>";
				}
				if (($va_project = $t_object->get('ca_objects.project', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) != '-') {
					print "<div class='unit'><h6>Project</h6>".$va_project."</div>";
				}
				if ($va_collection = $t_object->get('ca_collections.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Collection</h6>".$va_collection."</div>";
				}
				if ($va_runtime = $t_object->get('ca_objects.runtime', array('delimiter' => ', '))) {
					print "<div class='unit'><h6>Runtime</h6>".$va_runtime."</div>";
				}
				if ($va_description = $t_object->get('ca_objects.description', array('delimiter' => ', '))) {
					print "<div class='unit trimText'><h6>Description</h6>".$va_description."</div>";
				}
				if ($va_location = $t_object->get('ca_objects.location', array('delimiter' => ', '))) {
					print "<div class='unit trimText'><h6>Location</h6>".$va_location."</div>";
				}
				if (($va_language = $t_object->get('ca_objects.pbcoreLanguage', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) != "") {
					print "<div class='unit'><h6>Language</h6>".$va_language."</div>";
				}
				if ($va_subtitles = $t_object->get('ca_objects.subtitles', array('delimiter' => ', '))) {
					print "<div class='unit trimText'><h6>Subtitles</h6>".$va_subtitles."</div>";
				}	
				if ($va_keywords = $t_object->get('ca_objects.keywords', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Keywords</h6>".$va_keywords."</div>";
				}
				if ($t_object->get('ca_objects.forSale', array('convertCodesToDisplayText' => true)) == "yes") {
					print "<div class='unit'><h6>For Sale</h6>";
					if ($va_ind = $t_object->get('ca_objects.individualPrice')) {
						print "<div><b>Individual Price: </b>".$va_ind."</div>";
					}
					if ($va_inst = $t_object->get('ca_objects.institutionalPrice')) {
						print "<div><b>Institutional Price: </b>".$va_inst."</div>";
					}					
					print "</div>";
				}
																															
?>				
				
								
				<hr></hr>
					<div class="row">
						<div class="col-sm-12 related">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-12 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
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