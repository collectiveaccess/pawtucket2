<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = $this->getVar("access_values");
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
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<HR>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-12'>
					{{{<ifdef code="ca_occurrences.parent_id"><div class="unit"><label>Part of</label><unit relativeTo="ca_occurrences.parent"><unit relativeTo="ca_occurrences.hierarchy" delimiter=" &gt; "><l>^ca_occurrences.preferred_labels.name</l></unit></unit></div></ifdef>}}}
					{{{<ifcount code="ca_occurrences.children" min="1"><div class="unit"><label>Contains</label><unit relativeTo="ca_occurrences.children" delimiter="<br>"><l>^ca_occurrences.preferred_labels.name</l></unit></div></ifcount>}}}
					{{{<ifdef code="ca_occurrences.idno"><div class="unit"><label>Identifier</label>^ca_occurrences.idno</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.nonpreferred_labels.displayname" min="1"><div class="unit"><label>Alternate Titles</label>^ca_occurrences.nonpreferred_labels.displayname%delimiter=,_</div></ifcount>}}}
					{{{<ifdef code="ca_occurrences.alt_ID_container.alt_ID"><div class="unit"><label>Alternate Identifier</label><unit relativeTo="ca_occurrences.alt_ID_container" delimiter="<br>">^ca_occurrences.alt_ID_container.alt_ID<ifdef code="ca_occurrences.alt_ID_container.alt_ID_source">, <i>(^ca_occurrences.alt_ID_container.alt_ID_source)</i></unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.creator"><div class="unit"><label>Creator</label><unit relativeTo="ca_occurrences.creator" delimiter="<br>">^ca_occurrences.creator</unit></div></ifdef>}}}
					{{{<if rule='^ca_occurrences.unknown =~ /Yes/'><div class="unit"><label>Creator</label>Unknown</div></if>}}}
					{{{<ifdef code="ca_occurrences.work_type"><div class="unit"><label>Work Type</label><unit relativeTo="ca_occurrences.work_type" delimiter="<br>">^ca_occurrences.work_type</unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.work_date.work_sort_date|ca_occurrences.work_date.work_display_date">
						<div class="unit"><label>Date</label>
							<unit relativeTo="ca_occurrences.work_date" delimiter="<br>">
								<ifdef code="ca_occurrences.work_date.work_date_display">^ca_occurrences.work_date.work_date_display</ifdef><ifnotdef code="ca_occurrences.work_date.work_date_display">^ca_occurrences.work_date.work_sort_date</ifnotdef><ifdef code="ca_occurrences.work_date.work_date_type">, ^ca_occurrences.work_date.work_date_type</ifdef>
								<ifdef code="ca_occurrences.work_date.work_date_note"><br>^ca_occurrences.work_date.work_date_note</ifdef>
							</unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_occurrences.period"><div class="unit"><label>Period</label>^ca_occurrences.period%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.culture"><div class="unit"><label>Culture</label>^ca_occurrences.culture%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.materials_techniques"><div class="unit"><label>Materials and Techniques</label>^ca_occurrences.materials_techniques%delimiter=,_</div></ifdef>}}}
					{{{<ifnotdef code="ca_occurrences.materials_techniques"><ifdef code="ca_occurrences.materials_techniques_AAT"><div class="unit"><label>Materials and Techniques</label>^ca_occurrences.materials_techniques_AAT%delimiter=,_</div></ifdef></ifnotdef>}}}
					{{{<ifdef code="ca_occurrences.dimensions_container.display_dimensions"><div class="unit"><label>Dimensions</label>^ca_occurrences.dimensions_container.display_dimensions</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.description"><div class="unit"><label>Description</label>^ca_occurrences.description</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.repository"><div class="unit"><label>Repository</label>^ca_occurrences.repository</div></ifdef>}}}
					{{{<ifcount code="ca_collections" min="1">
						<div class="unit"><label>Related Collection<ifcount code="ca_collections" min="2">s</ifcount></label><unit relativeTo="ca_collections" delimiter="<br>"><l>^ca_collections.preferred_labels.name</l></unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="work">
						<div class="unit"><label>Related Work<ifcount code="ca_occurrences.related" min="2" restrictToTypes="work">s</ifcount></label>
						<unit relativeTo="related.ca_occurrences" restrictToTypes="work" delimiter="<br>">
							<l>^ca_occurrences.preferred_labels.name</l>
						</unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_entities" min="1">
						<div class="unit"><label><ifcount code="ca_entities" max="1">Related Entity</ifcount><ifcount code="ca_entities" min="2">Entities</ifcount></label>
						<unit relativeTo="ca_entities" delimiter="<br>">
							<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)
						</unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_places" min="1">
						<div class="unit"><label>Related Place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br>"><l>^ca_places.preferred_labels.name</l></unit>
						</div>
					</ifcount>}}}

					{{{map}}}
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
			</div><!-- end row -->

<?php
		$va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("featured"), "limit" => 8));
		if(!$va_object_ids){
			$va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "limit" => 8));
		}
		if(is_array($va_object_ids) && sizeof($va_object_ids)){
			$qr_objects = caMakeSearchResult("ca_objects", $va_object_ids);
			if($qr_objects->numHits()){
?>
				<div class="row">
					<div class="col-sm-12">
						<br><H2>Featured Objects</H2>
						<hr>
					</div>
				</div>
				<div class="row featuredObjects">
<?php
				while($qr_objects->nextHit()){
					print "<div class='col-sm-3'>".$qr_objects->getWithTemplate("<l><div class='featuredObject'><div class='featuredObjectImage'>^ca_object_representations.media.medium</div><div class='featuredObjectsCaption'><small>^ca_objects.idno</small><br>^ca_objects.preferred_labels<ifdef code='ca_objects.date.date_display|ca_objects.date.sort_date'><br><ifdef code='ca_objects.date.date_display'>^ca_objects.date.date_display</ifdef><ifnotdef code='ca_objects.date.date_display'>^ca_objects.date.sort_date</ifnotdef></ifdef></div></l></div>")."</div>";
				}
?>					
				</div>
<?php
			}
		}
?>


{{{<ifcount code="ca_objects" min="9">
			<div class="row">
				<div class="col-sm-12 text-center">
					<?php print caNavLink($this->request, "Browse All Related Objects", "btn btn-default", "", "Browse", "objects", array("facet" => "occurrence_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
				</div>
			</div>
</ifcount>}}}

		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
