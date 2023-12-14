<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entites_default_html.php : 
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
	$va_access_values = caGetUserAccessValues($this->request);	
	
	
	$vs_image = $t_item->getWithTemplate("<ifcount code='ca_objects' max='1'><unit relativeTo='ca_objects'><l>^ca_object_representations.media.large</l><div><l>^ca_objects.preferred_labels.name</l></div></unit></ifcount>");
	$vb_bottom_box = false;
	if($t_item->get("ca_entities.related.entity_id", array("checkAccess" => $va_access_values))){
		$vb_bottom_box = true;
	}
	if($t_item->get("ca_occurrences.occurrence_id", array("checkAccess" => $va_access_values))){
		$vb_bottom_box = true;
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
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-10'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{<ifdef code="ca_entities.life_dates_container.life_dates">^ca_entities.life_dates_container.life_dates</ifdef><ifdef code="ca_entities.life_dates_container.life_dates_note">, ^ca_entities.life_dates_container.life_dates_note</ifdef>}}}</H2>
				</div>
				<div class='col-sm-12 col-md-2 inquireCol'>
					<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_entities", "id" => $t_item->get("ca_entities.entity_id"))); ?>
				</div>
			</div>
			<div class="row">
<?php
				if($vs_image){
?>					
					<div class='col-md-3'><div class="occFeaturedImage"><?php print $vs_image; ?></div></div>
					<div class='col-md-9'>
<?php
				}else{
?>
					<div class='col-md-12'>
<?php				
				}
?>				
						{{{<ifdef code="ca_entities.relationship"><div class="unit"><label>Relationship To Dave Brubeck</label>^ca_entities.relationship%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_entities.bio_history_container.bio_history"><div class="unit">^ca_entities.bio_history_container.bio_history<ifdef code="ca_entities.bio_history_container.bio_history_source"><br><b>Source: </b>^ca_entities.bio_history_container.bio_history_source</ifdef><ifdef code="ca_entities.bio_history_container.bio_history_notes"><br><b>Notes: </b>^ca_entities.bio_history_container.bio_history_notes</ifdef></div></ifdef>}}}
						
						
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			if($vb_bottom_box){
?>
				<div class="bgLightGray container"><div class="row">
<?php
			}
?>
				{{{<ifcount code="ca_occurrences" restrictToTypes="song" min="1">
					<div class="col-sm-12 col-md-4">
						<div class="unit trimText"><label>Song<ifcount code="ca_occurrences" restrictToTypes="song" min="2">s</ifcount></label>
							<unit relativeTo="ca_occurrences" restrictToTypes="song" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit>
						</div>
					</div>
				</ifcount>}}}
<?php
				$va_entities = $t_item->get("ca_entities.related", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					print "<div class='col-sm-12 col-md-4'>";
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><label>".$vs_type."</label>".join(", ", $va_entity_links)."</div>";
					}
					print "</div>";
				}
?>
				{{{<ifcount code="ca_occurrences"  min="1"><div class="col-sm-12 col-md-4">
					<ifcount code="ca_occurrences" restrictToTypes="tour" min="1"><div class="unit"><label>Tour<ifcount code="ca_occurrences" restrictToTypes="tour" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="tour" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="album" min="1"><div class="unit"><label>Album<ifcount code="ca_occurrences" restrictToTypes="album" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="album" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="1"><div class="unit"><label>Studio Session<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="studio_session" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="appearance" min="1"><div class="unit"><label>Related Appearance<ifcount code="ca_occurrences" restrictToTypes="appearance" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="appearance" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l><ifcount code="ca_occurrences.related" restrictToTypes="tour" restrictToRelationshipTypes="included" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="tour" restrictToRelationshipTypes="included" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>: </ifcount>^ca_occurrences.preferred_labels.name<ifdef code="ca_occurrences.date_occurrence_container.date_occurrence">, ^ca_occurrences.date_occurrence_container.date_occurrence<ifdef code="ca_occurrences.date_occurrence_container.date_note_occurrence"> (^ca_occurrences.date_occurrence_container.date_note_occurrence)</ifdef></ifdef></l></unit></div>
					</ifcount>
					</div>
				</ifcount>}}}
<?php
			if($vb_bottom_box){
?>
				</div></div>
<?php
			}


				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
								
					print '<div class="row"><div class="col-sm-12"><div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools --></div></div>';
				}				
?>

				
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class='col-sm-12'>
					<H3>Selected Archival Items</H3>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer" class="ca_objects">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
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
		  maxHeight: 200
		});
	});
</script>
