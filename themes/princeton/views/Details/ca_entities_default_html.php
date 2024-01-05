<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
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
	$vs_rep_viewer = 	trim($this->getVar("representationViewer"));
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
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<HR/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
					{{{representationViewer}}}
				</div>
				<div class='col-sm-6 col-md-6 col-lg-5'>
				
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
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
					
					
					{{{<ifdef code="ca_entities.life_dates_container.entity_display_date"><div class="unit">^ca_entities.life_dates_container.entity_display_date</div></ifdef>}}}
					{{{<ifdef code="ca_entities.nonpreferred_labels.displayname" min="1"><div class="unit"><label>Alternate Names</label>^ca_entities.nonpreferred_labels.displayname%delimiter=,_</div></ifcount>}}}
					{{{<ifdef code="ca_entities.bio_history_container.bio_history">
						<div class='unit'><label>Biography</label>
							<span class="trimText">^ca_entities.bio_history_container.bio_history<ifdef code="ca_entities.bio_history_container.bio_history_source"><br/><i>(^ca_entities.bio_history_container.bio_history_source)</i></ifdef></span>
						</div>
					</ifdef>}}}
				
					{{{<ifcount code="ca_collections" min="1">
						<div class="unit"><label>Related Collection<ifcount code="ca_collections" min="2">s</ifcount></label><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="work">
						<div class="unit"><label>Related Work<ifcount code="ca_occurrences" min="2" restrictToTypes="work">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="work" delimiter="<br/>">
							<l>^ca_occurrences.preferred_labels.name</l>
						</unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="1">
						<div class="unit"><label>Related <ifcount code="ca_entities.related" max="1">Entity</ifcount><ifcount code="ca_entities.related" min="2">Entities</ifcount></label>
						<unit relativeTo="ca_entities.related" delimiter="<br/>">
							<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)
						</unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_places" min="1">
						<div class="unit"><label>Related Place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>
						</div>
					</ifcount>}}}
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
						<br/><H2>Featured Object<ifcount code="ca_objects" min="2">s</ifcount></H2>
						<hr/>
					</div>
				</div>
				<div class="row featuredObjects">
<?php
				while($qr_objects->nextHit()){
					print "<div class='col-sm-3'>".$qr_objects->getWithTemplate("<l><div class='featuredObject'><div class='featuredObjectImage'>^ca_object_representations.media.medium</div><div class='featuredObjectsCaption'><small>^ca_objects.idno</small><br/>^ca_objects.preferred_labels<ifdef code='ca_objects.date.date_display|ca_objects.date.sort_date'><br/><ifdef code='ca_objects.date.date_display'>^ca_objects.date.date_display</ifdef><ifnotdef code='ca_objects.date.date_display'>^ca_objects.date.sort_date</ifnotdef></ifdef></div></l></div>")."</div>";
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
					<?php print caNavLink($this->request, "Browse All Related Objects", "btn btn-default", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id"))); ?>
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 130
		});
	});
</script>
