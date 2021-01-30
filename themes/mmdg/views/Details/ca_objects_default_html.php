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
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_rep_viewer = trim($this->getVar("representationViewer"));
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
			<div class="row">
				<div class='col-md-12 col-lg-12 text-center'>
					<H1>{{{^ca_objects.type_id}}}</H1>
					<H2>{{{^ca_objects.preferred_labels.name}}}</H2>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					
					<?php print $vs_rep_viewer; ?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					{{{<ifdef code="ca_objects.recording_date"><div class='unit trimText'><label>Recording Date</label>^ca_objects.recording_date</div></ifdef>}}}
					{{{<ifdef code="ca_objects.eventDate"><div class='unit trimText'><label>Event Date</label>^ca_objects.eventDate</div></ifdef>}}}
					{{{<ifdef code="ca_objects.sourceDate"><div class='unit trimText'><label>Creation Date</label>^ca_objects.sourceDate</div></ifdef>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="depicts" min="1"><div class='unit trimText'><label>Depicts</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="depicts" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="described" min="1"><div class='unit trimText'><label>Describes</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="described" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifdef code="ca_objects.av_camera_angle_type"><div class='unit trimText'><label>Camera Angle</label>^ca_objects.av_camera_angle_type</div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="photographer" min="1"><div class='unit trimText'><label>Photographer</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="videographer" min="1"><div class='unit trimText'><label>Videographer</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="videographer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
										
					{{{<ifdef code="ca_objects.idno"><div class='unit trimText'><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_object->get('ca_occurrences', array('restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_works as $va_work) {
							$va_related_list[$va_work['relationship_typename']][] = caDetailLink($this->request, $va_work['name'], '', 'ca_occurrences', $va_work['occurrence_id']);
						}
						print "<div class='unit'><H3>Works</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							$c = 0;
							if(sizeof($va_links) > 12){
								$vb_show_view_all = true;
							}
							foreach($va_links as $vs_link){
								if($i == 0){
									print "<div class='row'>";
								}
								print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".$vs_link."</div></div>";
								$i++;
								$c++;
								if($i == 3){
									print "</div>";
									$i = 0;
								}
								if($c == 12){
									break;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Works", "btn btn-default", "", "Browse", "works", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
						}
					}
					
					if ($va_events = $t_object->get('ca_occurrences', array('restrictToTypes' => array('event'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$va_related_list = array();
						$vb_show_view_all = false;
						foreach ($va_events as $va_event) {
							$va_related_list[$va_event['relationship_typename']][] = caDetailLink($this->request, $va_event['name'], '', 'ca_occurrences', $va_event['occurrence_id']);
						}
						print "<div class='unit'><H3>Performances & Events</H3>";
						foreach ($va_related_list as $vs_role => $va_links) {
							print "<div class='unit detailLinksGrid'><label>".ucfirst($vs_role)."</label>";
							$i = 0;
							$c = 0;
							if(sizeof($va_links) > 12){
								$vb_show_view_all = true;
							}
							foreach($va_links as $vs_link){
								if($i == 0){
									print "<div class='row'>";
								}
								print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".$vs_link."</div></div>";
								$i++;
								$c++;
								if($i == 3){
									print "</div>";
									$i = 0;
								}
								if($c == 12){
									break;
								}
							}
							if($i > 0){
								print "</div>";
							}
							print "</div><!-- end unit -->";
						}
						print "</div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Performances & Events", "btn btn-default", "", "Browse", "events", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
						}
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects.related" min="1">
			<div class="row">
				<div class="col-sm-12">
					<H3>Object<ifcount code="ca_objects.related" min="2">s</ifcount></H3>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
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
		  maxHeight: 400
		});
	});
</script>