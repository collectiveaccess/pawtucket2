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
<div class="container">
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
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<div class='objectBanner'>
<?php
					if ($vs_category = $t_object->get('ca_objects.ns_category', array('convertCodesToDisplayText' => false))) {
						print "<div class='category'>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_category, true), '', '', 'Browse', 'objects/facet/ca_facet/id/'.$vs_category)."</div>";
					}
					print "<div class='institution'>";
					if ($va_institution = $t_object->getWithTemplate('<unit relativeTo="ca_entities" restrictToTypes="member_inst"><div class="instName">^ca_entities.preferred_labels </div><div class="instLogo">^ca_entities.inst_images</div></unit>')) {
						$vs_inst_id = $t_object->get('ca_entities.entity_id', array('restrictToTypes' => array('member_inst')));
						print caNavLink($this->request, $va_institution, '', '', 'Detail', 'entities/'.$vs_inst_id );
					}		
					print "</div>";		
?>				
					<div class="width:100%;clear:both;"></div>
				</div>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
					if ($vs_object_type = $t_object->get('ca_objects.ns_objectType', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Object Type</span><span class='meta'>".$vs_object_type."</span></div>";
					}
					if ($vs_object_subtype = $t_object->get('ca_objects.ns_ns_objectSubType', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Object Sub-Type</span><span class='meta'>".$vs_object_subtype."</span></div>";
					}
					if ($vs_date = $t_object->get('ca_objects.date', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Date</span><span class='meta'>".$vs_date."</span></div>";
					}	
					if ($vs_desc = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Description</span><span class='meta'>".$vs_desc."</span></div>";
					}
					if ($vs_history_use = $t_object->get('ca_objects.historyUse', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>History of Use</span><span class='meta'>".$vs_history_use."</span></div>";
					}	
					if ($vs_origin = $t_object->get('ca_objects.originPlace', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Origin Place</span><span class='meta'>".$vs_origin."</span></div>";
					}
					if ($vs_mat = $t_object->get('ca_objects.materials', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Materials</span><span class='meta'>".$vs_mat."</span></div>";
					}
					if ($vs_numb = $t_object->get('ca_objects.numberOfComponents', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Number of Components</span><span class='meta'>".$vs_numb."</span></div>";
					}																																	
?>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
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
</div><!-- end container -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>