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
	$va_access_values = caGetUserAccessValues($this->request);	
?>
<div class="container">
	<div class="row">
		<div class='col-sm-12'>
			<div class="bgLightGrayDetail">
				<H1>{{{^ca_occurrences.preferred_labels}}}</H1>
				<H2>{{{^ca_occurrences.type_id}}}</H2>
					{{{<ifdef code="ca_occurrences.content_description"><div class="unit"><label>Description</label><div class="trimText">^ca_occurrences.content_description</div></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.acknowledgements"><div class="unit"><label>Acknowledgements</label><div class="trimText">^ca_occurrences.acknowledgements</div></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.funding_acknowl"><div class="unit"><label>Funding Acknowledgements</label><div class="trimText">^ca_occurrences.funding_acknowl</div></div></ifdef>}}}
<?php
		if($this->request->isLoggedIn()){
?>
						{{{<ifdef code="ca_occurrences.catalogue_control.catalogued_by|ca_occurrences.catalogue_control.catalogued_date"><div class="unit"><label>Descriptive Control</label>^ca_occurrences.catalogue_control.catalogued_by<ifdef cde="ca_occurrences.catalogue_control.catalogued_date"> (^ca_occurrences.catalogue_control.catalogued_date)</ifdef></div></ifdef>}}}
<?php
		}
		$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
		if(is_array($va_entities) && sizeof($va_entities)){
			$va_entities_by_type = array();
			foreach($va_entities as $va_entity_info){
				$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
			}
			foreach($va_entities_by_type as $vs_type => $va_entity_links){
				print "<div class='unit'><label>".$vs_type."</label>".join(", ", $va_entity_links)."</div>";
			}
		}

?>					
				
				{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="subject_guide"><div class="unit"><label>Related Subject Guides</label><div class="trimTextShort"><unit relativeTo="ca_occurrences.related" delimiter=", " restrictToTypes="subject_guide"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
			</div>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 text-center">
			{{{previousLink}}}
		</div>
		<div class="col-sm-4 text-center">
			{{{resultsLink}}}
		</div>
		<div class="col-sm-4 text-center">
			{{{nextLink}}}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">

<?php
					print "<div id='detailTools'>";
					print "<div class='detailTool'>".caNavLink($this->request, "Inquire <span class='material-symbols-outlined'>chat</span>", "btn btn-default", "", "Contact", "Form", array("table" => "ca_occurrences", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
					print "<div class='detailTool'>".caNavLink($this->request, "Feedback <span class='material-symbols-outlined'>add_comment</span>", "btn btn-default", "", "Contact", "Form", array("contactType" => "Feedback", "table" => "ca_occurrences", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div>";
					print "</div>";
?>					
		</div><!-- end col -->
	</div><!-- end row -->
<?php
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
	if($x && is_array($va_entities) && sizeof($va_entities)){
		$va_entities_by_type = array();
		foreach($va_entities as $va_entity_info){
			$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
		}
?>
		<div class="row">
			<div class="col-sm-12">
				<H3>People & Organizations</H3>
<?php
				foreach($va_entities_by_type as $vs_type => $va_entity_links){
					print "<H4>".$vs_type."</H4>";
					$col = 0;
					foreach($va_entity_links as $va_entity_link){
						if($col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-3'>".$va_entity_link."</div>";
						$col++;
						if($col == 4){
							$col = 0;
							print "</div>";
						}
					}
					if($col > 0){
						print "</div>";
					}
				}
?>			
			
			</div>
		</div>
<?php
	}
	$va_events = $t_item->get("ca_occurrences.related", array("restrictToTypes" => array("event"), "returnWithStructure" => 1, "checkAccess" => $va_access_values));
	if(is_array($va_events) && sizeof($va_events)){
		$va_rel_events = array();
		$i = 0;
		foreach($va_events as $va_event_info){
			$va_rel_events[$va_event_info["occurrence_id"]] = array("name" => $va_event_info["name"], "relationship_type" => $va_event_info["relationship_typename"]);
			$i++;
			if($i == 24){
				break;
			}
		}
		$qr_events = caMakeSearchResult("ca_occurrences", array_keys($va_rel_events));
?>
		<div class="row">
			<div class="col-sm-12">
				<H3>Related Programs & Events</H3>
<?php

				$i = 0;
				$col = 0;
				while($qr_events->nextHit()){
					if($col == 0){
						print "<div class='row'>";
					}
					print "<div class='col-sm-3'>".caDetailLink($this->request, "<div class='bgDarkGray text-center'>".$va_rel_events[$qr_events->get("ca_occurrences.occurrence_id")]["name"]."<br/><small>".$qr_events->getWithTemplate("^ca_occurrences.occurrence_date")."</small></div>", "", "ca_occurrences", $qr_events->get("ca_occurrences.occurrence_id"))."</div>";
					$col++;
					if($col == 4){
						$col = 0;
						print "</div>";
					}
					$i++;
					if($i == 24){
						if(sizeof($va_events) > 24){
							print "<div class='row'><div class='col-sm-12 text-center'>".caNavLink($this->request, "View All →", "btn btn-default", "", "Browse", "Events", array("facet" => "occurrence_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div></div>";
						}
						break;
					}
				}
				if($col > 0){
					print "</div>";
				}
?>			
			
			</div>
		</div>
<?php
	}


	$va_collections = $t_item->get("ca_collections", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
	if(is_array($va_collections) && sizeof($va_collections)){
		$va_rel_collections = array();
		$i = 0;
		foreach($va_collections as $va_collection_info){
			$va_rel_collections[$va_collection_info["collection_id"]] = array("name" => $va_collection_info["name"], "relationship_type" => $va_collection_info["relationship_typename"]);
			$i++;
			if($i == 24){
				break;
			}
		}
		$qr_collections = caMakeSearchResult("ca_collections", array_keys($va_rel_collections));
?>
		<div class="row">
			<div class="col-sm-12">
				<H3>Related Collections, Series & Files</H3>
<?php

				$i = 0;
				$col = 0;
				while($qr_collections->nextHit()){
					if($col == 0){
						print "<div class='row'>";
					}
					print "<div class='col-sm-3'>".caDetailLink($this->request, "<div class='bgDarkGray text-center'>".$qr_collections->getWithTemplate("<ifdef code='ca_collections.parent_id'><unit relativeTo='ca_collections.hierarchy' delimiter=' &gt; '><if rule='^ca_collections.type_id =~ /Fond/'>^ca_collections.preferred_labels.name &gt; </if></unit></ifdef>").$va_rel_collections[$qr_collections->get("ca_collections.collection_id")]["name"]."<br/><small>(".$qr_collections->getWithTemplate("^ca_collections.type_id").")</small></div>", "", "ca_collections", $qr_collections->get("ca_collections.collection_id"))."</div>";
					$col++;
					if($col == 4){
						$col = 0;
						print "</div>";
					}
					$i++;
					if($i == 24){
						if(sizeof($va_collections) > 24){
							print "<div class='row'><div class='col-sm-12 text-center'>".caNavLink($this->request, "View All →", "btn btn-default", "", "Browse", "Collections", array("facet" => "subject_guide_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div></div>";
						}
						break;
					}
				}
				if($col > 0){
					print "</div>";
				}
?>			
			
			</div>
		</div>
<?php
	}

?>

{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12"><H3>Related Objects</H3></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'all_objects', array('facet' => 'detail_occurrence', 'id' => '^ca_occurrences.occurrence_id', 'detailNav' => 'occurrence'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		</div><!-- end container -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 400,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>

