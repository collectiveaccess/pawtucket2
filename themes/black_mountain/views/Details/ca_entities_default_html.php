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
				<div class='col-md-12 col-lg-12'>
					<H2>{{{^ca_entities.type_id<ifdef code="ca_entities.idno">: ^ca_entities.idno</ifdef>}}}</H2>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					{{{<ifdef code="ca_entities.index_date"><div class="unit">^ca_entities.index_date</div></ifdef>}}}
					<HR/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-12'>
					{{{<ifdef code="ca_entities.bmc_role.bmc_role_value|ca_entities.bmc_role.bmc_role_dates|ca_entities.bmc_role.bmc_notes"><div class="unit"><label>Dates at BMC</label><unit relativeTo="ca_entities.bmc_role" delimiter="<br/>"><ifdef code="ca_entities.bmc_role.bmc_role_value">^ca_entities.bmc_role.bmc_role_value<ifdef code="ca_entities.bmc_role.bmc_role_dates">, </ifdef></ifdef><ifdef code="ca_entities.bmc_role.bmc_role_dates"></ifdef>^ca_entities.bmc_role.bmc_role_dates%dateFormat=original<ifdef code="ca_entities.bmc_role.bmc_notes"><ifdef code="ca_entities.bmc_role.bmc_role_dates|ca_entities.bmc_role.bmc_role"><br/></ifdef>^ca_entities.bmc_role.bmc_notes</ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_entities.biography"><div class="unit"><span class="trimText">^ca_entities.biography</span></div></ifdef>}}}
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
				$va_places = $t_item->get("ca_places", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("born_at", "died_at", "was_active_at")));
				if(is_array($va_places) && sizeof($va_places)){
					$va_places_by_type = array();
					foreach($va_places as $va_place_info){
						$va_places_by_type[$va_place_info["relationship_typename"]][] = $va_place_info["name"];
					}
					foreach($va_places_by_type as $vs_type => $va_place){
						print "<div class='unit'><label>".$vs_type."</label>".join("<br/>", $va_place)."</div>";
					}
				}
				
				$va_entities = $t_item->get("ca_entities.related", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><label>".$vs_type."</label>".join("<br/>", $va_entity_links)."</div>";
					}
				}				
?>
					
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibitions" min="1"><div class="unit"><label>Related Exhibitions</label>
					<unit relativeTo="ca_occurrences" restrictToTypes="exhibitions" delimiter="<br/>" unique="1"><l>^ca_occurrences.preferred_labels</l></unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1"><div class="unit"><label>Related Events</label>
					<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter="<br/>" unique="1"><l>^ca_occurrences.preferred_labels</l></unit></div></ifcount>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1" restrictToTypes="artwork, oral_history, archival_object, publication">
			<div class="row">
				<div class="col-sm-12"><div class="unit"><label>Related Objects</label></div><HR/></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'person_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		  maxHeight: 120
		});
	});
</script>
