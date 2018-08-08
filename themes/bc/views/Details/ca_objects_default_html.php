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
<?php
				if ($va_related_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true))) {
					print "<div class='unit row' style='border-top:1px solid #e6e6e6; margin-top:70px;padding-top:15px;'>";
					print "<div class='relObj'>Similar Items</div>";
					foreach ($va_related_objects as $va_key => $va_related_object) {
						$t_rel_object = new ca_objects($va_related_object);
						print "<div class='col-sm-4 relatedObjects' data-toggle='popover' data-trigger='hover' data-content='".$t_rel_object->get('ca_objects.preferred_labels')."'>".caNavLink($this->request, $t_rel_object->get('ca_object_representations.media.iconlarge'), '', '', 'Detail', 'objects/'.$va_related_object)."</div>";	
					}
					print "</div>";
				}
?>
<script>
	jQuery(document).ready(function() {
		$('.relatedObjects').popover(); 
	});
	
</script>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<table class='objectBanner'><tr>
<?php
                    if($vs_institution_code = caGetListItemIdno($t_object->get('source_id'))) {    
                        $t_member = ca_entities::find(['idno' => $vs_institution_code, 'type_id' => 'member_inst'], ['returnAs' => 'firstModelInstance']);
                        if ($t_member) {
                            $vs_institution_banner = $t_member->getWithTemplate('<td class="instName"><span class="fromThe">from the collection of</span> <l>^ca_entities.preferred_labels </l></td><td class="instLogo"><l>^ca_entities.inst_images</l></td>');
                            $vs_inst_id = $t_member->get('ca_entities.entity_id');
                            print caNavLink($this->request, $vs_institution_banner, '', '', 'Detail', 'entities/'.$vs_inst_id );
                        }
                    }		
?>				
					<div class="width:100%;clear:both;"></div>
				</tr></table>
				{{{<unit><p>^ca_objects.idno</p></unit>}}}
				{{{<unit relativeTo="ca_object_lots"><p>^ca_object_lots.idno</p></unit>}}}
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
					if ($vs_category = $t_object->get('ca_objects.ns_category', array('returnAsArray' => 'true'))) {
						print "<div class='unit'><span class='data'>Category</span><span class='meta'>";
						$va_categories = array();
						foreach ($vs_category as $va_key => $vs_categories) {
							$va_categories[] = caNavLink($this->request, caGetListItemByIDForDisplay($vs_categories, true), '', '', 'Browse', 'objects/facet/ca_facet/id/'.$vs_categories);
						}
						print join(', ', $va_categories);
						print "</span></div>";
					}
					if ($vs_entities = $t_object->getWithTemplate('<unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><span class='data'>Related Entities</span><span class='meta'>".$vs_entities."</span></div>";
					}
					if ($vs_title = $t_object->get('ca_objects.ns_title', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Title</span><span class='meta'>".$vs_title."</span></div>";
					}					
					if ($vs_desc = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Description</span><span class='meta'>".$vs_desc."</span></div>";
					}
					if ($vs_date = $t_object->get('ca_objects.date', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Date</span><span class='meta'>".$vs_date."</span></div>";
					}						
					if ($vs_history_use = $t_object->get('ca_objects.historyUse', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>History of Use</span><span class='meta'>".$vs_history_use."</span></div>";
					}
					if ($vs_measurements = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.measurements.dimensions_length">^ca_objects.measurements.dimensions_length L</ifdef><ifdef code="ca_objects.measurements.dimensions_length,ca_objects.measurements.dimensions_width"> x </ifdef><ifdef code="ca_objects.measurements.dimensions_width">^ca_objects.measurements.dimensions_width W</ifdef><ifdef code="ca_objects.measurements.dimensions_height,ca_objects.measurements.dimensions_width"> x </ifdef><ifdef code="ca_objects.measurements.dimensions_height">^ca_objects.measurements.dimensions_height H</ifdef><ifdef code="ca_objects.measurements.dimensions_height,ca_objects.measurements.dimensions_thick"> x </ifdef><ifdef code="ca_objects.measurements.dimensions_thick">^ca_objects.measurements.dimensions_thick Thick</ifdef><ifdef code="ca_objects.measurements.dimensions_diam,ca_objects.measurements.dimensions_thick"> x </ifdef><ifdef code="ca_objects.measurements.dimensions_diam">^ca_objects.measurements.dimensions_diam Diameter</ifdef><ifdef code="ca_objects.measurements.dimensions_diam,ca_objects.measurements.dimensions_depth"> x </ifdef><ifdef code="ca_objects.measurements.dimensions_depth">^ca_objects.measurements.dimensions_depth Deep</ifdef><ifdef code="ca_objects.measurements.dimensions_remarks"><br/>^ca_objects.measurements.dimensions_remarks<ifdef></unit>')) {
						print "<div class='unit'><span class='data'>Measurements</span><span class='meta'>".$vs_measurements."</span></div>";
					}
					if ($vs_mat = $t_object->get('ca_objects.materials', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Materials</span><span class='meta'>".$vs_mat."</span></div>";
					}	
					if ($vs_narrative = $t_object->get('ca_objects.narrative', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><span class='data'>Narrative</span><span class='meta'>".$vs_narrative."</span></div>";
					}	
					if ($vs_culture = $t_object->get('ca_objects.culture', array('returnAsArray' => 'true'))) {
						print "<div class='unit'><span class='data'>Culture</span><span class='meta'>";
						$va_cultures = array();
						foreach ($vs_culture as $va_key => $vs_cultures) {
							$va_cultures[] = caNavLink($this->request, caGetListItemByIDForDisplay($vs_cultures, true), '', '', 'Browse', 'objects/facet/culture_facet/id/'.$vs_cultures);
						}
						print join(', ', $va_cultures);
						print "</span></div>";
					}	
					if ($vs_subject = $t_object->get('ca_objects.subject', array('returnAsArray' => 'true'))) {	
						$va_subjects = array();
						foreach ($vs_subject as $va_key => $vs_subjects) {
							if ($vs_subjects != "") {
								$va_subjects[] = caNavLink($this->request, $vs_subjects, '', '', 'Browse', 'objects/facet/subject_facet/id/'.$vs_subjects);
							}
						}
						if (sizeof($va_subjects) > 0 ){
							print "<div class='unit'><span class='data'>Subject</span><span class='meta'>";
							print join(', ', $va_subjects);
							print "</span></div>";
						}
					}
					if ($vs_entities = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('member_inst')))) {
						print "<div class='unit'><span class='data'>From the collection of</span><span class='meta'>".$vs_entities."</span></div>";
					}
					if ($vs_occurrences = $t_object->getWithTemplate('<unit relativeTo="ca_occurrences">^ca_occurrences.preferred_labels <br/>^ca_occurrences.description</unit>')) {
						print "<div class='unit'><span class='data'>Related Event</span><span class='meta'>".$vs_occurrences."</span></div>";
					}																																											
																																						
?>
					{{{map}}}
					<hr>

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