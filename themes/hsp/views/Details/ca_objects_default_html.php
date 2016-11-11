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
	$vn_object_id = 		$t_object->get("ca_objects.object_id");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
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
		<div class="container">
			<div class="row">	
				<div class='col-sm-12'>
					<h1>{{{<unit>^ca_objects.type_id</unit>}}}: {{{ca_objects.preferred_labels.name}}}</h1>
				</div>
			</div>
			<div class="row">	
			<div class='col-sm-6 col-md-6 col-lg-4'>
				<!-- AddThis Button BEGIN -->
				<div class="unit"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
				<!-- AddThis Button END -->
				
				
				{{{<ifdef code="ca_objects.idno"><h6>Record Number</h6>^ca_objects.idno<br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.call_number"><h6>Call Number</h6>^ca_objects.call_number<br/><hr/></ifdef>}}}
				
				{{{<unit relativeTo="ca_collections" delimiter="<br/>"><h6>Collections</h6> <l>^ca_collections.preferred_labels.name</l> [^ca_collections.idno]<br/><hr/></unit>}}}
				
				{{{<ifdef code="ca_objects.box_number"><h6>Box/Case</h6>^ca_objects.Box_number<br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.folder_number"><h6>Folder</h6>^ca_objects.folder_number<br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.volume_number"><h6>Volume</h6>^ca_objects.volume_number<br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.page_number"><h6>Page</h6>^ca_objects.page_number<br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.reproduction_restrictions"><h6>Reproduction Restrictions</h6>^ca_objects.reproduction_restrictions<br/><hr/></ifdef>}}}
				
				<?php
					# This code will group entities by their relationship to the current object
					$t_entities = $t_object->get('ca_entities', array('template' => '<unit relativeTo="ca_entities">^relationship_typename|^ca_entities.preferred_labels</unit>', excludeRelationshipTypes => array('mrk', 'trc')));
					if($t_entities){
						$t_entities = explode(';', $t_entities);
						$entity_array = array();
						foreach($t_entities as $entity){
							$ent_parts = [];
							$ent_parts = explode('|', $entity);
							$ent_type = trim(strtolower($ent_parts[0]));
							$entity_array[$ent_type][] = $ent_parts[1];
						}
						foreach($entity_array as $type => $names){
							print "<h6>$type";
							if ((count($names) > 1) && ($type !== "relates to" && $type !== "depicted")){
								print "s</h6>";
							} else {
								print "</h6>";
							}
							foreach($names as $name){
								print $name."<br/>";
							}
							print "<hr/>";
						}
					}
				?>
				<!--{{{<ifcount code="ca_entities" min="1"><unit relativeTo="ca_entities" delimiter="<hr/>"><h6>^relationship_typename</h6>^ca_entities.preferred_labels</unit><hr/></ifcount>}}}-->
				
				{{{<unit relativeTo="ca_objects.address"><ifdef code="ca_objects.address"><h6>Address</h6><ifdef code="ca_objects.address.address1">^ca_objects.address.address1<br/></ifdef><ifdef code="ca_objects.address.address2">^ca_objects.address.address2<br/></ifdef><ifdef code="ca_objects.address.city">^ca_objects.address.city, </ifdef><ifdef code="ca_objects.address.stateprovince">^ca_objects.address.stateprovince </ifdef><ifdef code="ca_objects.address.postalcode">^ca_objects.address.postalcode, </ifdef><ifdef code="ca_objects.address.country">^ca_objects.address.country</ifdef><hr/></ifdef></unit>}}}
				
				{{{<ifdef code="ca_objects.date_view"><h6>Date of Original</h6>^ca_objects.date_view<br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.date_item"><h6>Date of Reproduction</h6>^ca_objects.date_item<br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.view_format"><h6>Original Format</h6><unit relativeTo="ca_objects.view_format" delimiter=', '>^ca_objects.view_format</unit><br/><hr/></ifdef>}}}
				<?php print_r($t_object->get('ca_objects.hierarchy.view_format', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))); ?>
				{{{<ifdef code="ca_objects.item_format"><h6>Reproduction Format</h6><unit relativeTo="ca_objects.item_format" delimiter=", ">^ca_objects.item_format</unit><br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_depth"><h6>Dimensions</h6><ifdef code="ca_objects.dimensions.dimensions_phys">^ca_objects.dimensions.dimensions_phys: </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width</ifdef><ifdef code="ca_objects.dimensions.dimensions_height"> x ^ca_objects.dimensions.dimensions_height</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> x ^ca_objects.dimensions.dimensions_depth</ifdef><ifdef code="ca_objects.dimensions.dimensions_unit"> ^ca_objects.dimensions.dimensions_unit</ifdef><br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.inscription.inscription_text|ca_objects.inscription.inscription_location"><h6>Inscription</h6><ifdef code="ca_objects.inscription.inscription_text"><strong>Text: </strong>^ca_objects.inscription.inscription_text<br/></ifdef><ifdef code="ca_objects.inscription.inscription_location"><strong>Location: </strong>^ca_objects.inscription.inscription_location</ifdef><br/><hr/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.image_description"><h6>Description</h6><span class="trimText">^ca_objects.image_description</span><hr/></ifdef>}}}
				
				{{{<h6>Part of</h6><unit relativeTo="ca_objects.parent">^ca_objects.parent.preferred_labels</unit><br/><hr/>}}}
				
				{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Subject</H6></ifcount>}}}
				{{{<ifcount code="ca_list_items" min="2"><H6>Subjects</H6></ifcount>}}}
				{{{<unit relativeTo="ca_list_items" delimiter="<br/>"><?php print caNavLink($this->request, '^ca_list_items.preferred_labels.name_plural', '', '', 'Search', 'objects', array('search' => $t_object->get('ca_list_items.preferred_labels.name_plural'))); ?></unit>}}}
				{{{<ifcount code="ca_list_items" min="1"><br/><hr/></ifcount>}}}
				
				{{{<ifcount min="1" code="ca_objects.related">
					<h6>Related Objects</h6><br/><unit relativeTo="ca_objects.related" delimiter=" ">
					<!-- Enable bootstrap popovers for displaying related objects -->
					<script>
						$(function () {
							$('#popoverView_^ca_objects.idno').popover({
								html: true,
								trigger: 'hover',
								placement: 'top',
								content: function () {
									return $('#popoverContent_^ca_objects.idno').html();
								}
							});
						});
					</script>
					<div class="row">
						<div id="popoverView_^ca_objects.idno" class="col-sm-4"><unit relativeTo="ca_object_representations.related" limit="1" length="1">^ca_object_representations.media.icon</unit>
						</div>
						<div class="col-sm-8">
							<l>^ca_objects.preferred_labels</l>
						</div>
					</div>
					<!-- This hidden div contains popover content -->
					<div id="popoverContent_^ca_objects.idno" class="obj_popover" style="display: none">
						<unit relativeTo='ca_object_representations.related' limit='1'>^ca_object_representations.media.medium</unit><br/><strong>Title: </strong>^ca_objects.preferred_labels<br/><strong>ID: </strong>^ca_objects.idno
					</div>
					<hr/>
				</unit></ifcount>}}}
				
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
					<div class="row">
						<div class="col-sm-6">		
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-7 col-lg-offset-1'>
				<div class="purchaseLink">
					<p>If you would like to purchase this image, please contact <a href="mailto:rnr@hsp.org">RNR@hsp.org</a></p>
				</div>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
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