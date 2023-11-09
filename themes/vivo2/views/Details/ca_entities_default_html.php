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
	$vs_alt_labels = $t_item->getWithTemplate("^ca_entities.nonpreferred_labels<ifdef code='ca_entities.nonpreferred_labels.type_id'> (^ca_entities.nonpreferred_labels.type_id)</ifdef><ifdef code='ca_entities.nonpreferred_labels.effective_date'>, ^ca_entities.nonpreferred_labels.effective_date</ifdef><ifdef code='ca_entities.nonpreferred_labels.source_info'>, ^ca_entities.nonpreferred_labels.source_info</ifdef>", array("checkAccess" => $va_access_values, "delimiter" => "<br/>"));

	$vb_2_col = false;
	if($t_item->get("ca_entities.biography.biography_text") || $t_item->get("ca_entities.group_desc.org_desc_text")){
		$vb_2_col = true;
	}

?>
<div class="container">
	<div class="row">
		<div class='col-sm-12'>
			<div class="bgLightGrayDetail">
				<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<div class="typeInfo">{{{^ca_entities.type_id<if rule='^ca_entities.video_out =~ /Yes/'> / Video Out Artist</if>}}}</div>
<?php
					if($vs_alt_labels){
						print "<div class='unit'><H2>Alternate Names</H2>".$vs_alt_labels."</div>";
					}

			if($vb_2_col){
?>
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<!-- group or community -->
						{{{<ifdef code="ca_entities.group_desc.org_desc_text"><div class="unit"><H2>About</H2><span class="trimText"><div>^ca_entities.group_desc.org_desc_text<ifdef code="ca_entities.group_desc.org_desc_source"><br/><br/><i>^ca_entities.group_desc.org_desc_source<ifdef code="ca_entities.group_desc.org_desc_date">, ^ca_entities.group_desc.org_desc_date</ifdef></i></div><span></div></ifdef>}}}
						<!-- Ind -->
						{{{<ifdef code="ca_entities.biography.biography_text"><div class="unit"><H2>Biography</H2><span class="trimTextShort"><div>^ca_entities.biography.biography_text<ifdef code="ca_entities.biography.biography_source"><br/><br/><i>^ca_entities.biography.biography_source<ifdef code="ca_entities.biography.biography_date">, ^ca_entities.biography.biography_date</ifdef></i></div></span></div></ifdef>}}}		
					</div>
					<div class="col-sm-12 col-md-6">
<?php
			}else{
				if($t_item->getWithTemplate("^ca_entities.type_id") == "Individual"){
?>
				<div class="unit">{{{^ca_entities.preferred_labels.displayname}}} {{{entity_description_placeholder}}}</div>
<?php
				}
			}
?>

					<!-- group -->
					{{{<ifdef code="ca_entities.org_gen_role"><div class="unit"><H2>Type of Group</H2>^ca_entities.org_gen_role%delimiter=,_</div></ifdef>}}}
					<!-- group or community -->
					{{{<ifdef code="ca_entities.vital_dates_org.vital_date_value_org"><unit relativeTo="ca_entities.vital_dates_org" delimiter=" "><div class="unit"><ifdef code="ca_entities.vital_dates_org.entity_date_types_org"><H2>^ca_entities.vital_dates_org.entity_date_types_org</H2></ifdef>^ca_entities.vital_dates_org.vital_date_value_org</div></unit></ifdef>}}}
					<!-- end group -->
					
					<!-- Ind -->
					{{{<ifdef code="ca_entities.vital_dates_ind.vital_date_value_ind"><unit relativeTo="ca_entities.vital_dates_ind" delimiter=" "><div class="unit"><ifdef code="ca_entities.vital_dates_ind.entity_date_types_ind"><H2>^ca_entities.vital_dates_ind.entity_date_types_ind</H2></ifdef>^ca_entities.vital_dates_ind.vital_date_value_ind<ifdef code="ca_entities.vital_dates_ind.vital_date_location_ind">, ^ca_entities.vital_dates_ind.vital_date_location_ind</ifdef></div></unit></ifdef>}}}
					<!-- end Ind -->
					
<?php
		if($this->request->isLoggedIn() && $this->request->user->hasRole("frontendRestricted")){
?>						
					{{{<ifdef code="ca_entities.identity.gender|ca_entities.identity.affiliation_descriptor"><div class="unit"><H2>Identity</H2><ifdef code="ca_entities.identity.gender">^ca_entities.identity.gender</ifdef><ifdef code="ca_entities.identity.gender,ca_entities.identity.affiliation_descriptor">, </ifdef><ifdef code="ca_entities.identity.affiliation_descriptor">^ca_entities.identity.affiliation_descriptor</ifdef><ifdef code="ca_entities.identity.source_desc"><br/><i>^ca_entities.identity.source_desc</i></ifdef></div></ifdef>}}}
					{{{<ifdef code="ca_entities.entity_notes"><div class="unit"><H2>Notes</H2>^ca_entities.entity_notes</div></ifdef>}}}
<?php
		}
?>
					{{{<ifdef code="ca_entities.website"><div class="unit"><H2>Website</H2><unit relativeTo="ca_entities.website" delimiter="<br/>"><a href="^ca_entities.website" target="_blank">^ca_entities.website</a></unit></div></ifdef>}}}
					
					
<!-- Ind -->
					
					
					
<?php
		if($this->request->isLoggedIn()){
?>
						{{{<ifdef code="ca_entities.vivo_role.VIVO_role_gen"><div class="unit"><H2>Roles at VIVO</H2><unit relativeTo='ca_entities.vivo_role' delimiter='<br/>'>^ca_entities.vivo_role.VIVO_role_gen%useSingular=1<ifdef code='ca_entities.vivo_role.VIVO_role_date'> (^ca_entities.vivo_role.VIVO_role_date)</ifdef></unit></div></ifdef>}}}
						{{{<ifdef code="ca_entities.catalogue_control.catalogued_by|ca_entities.catalogue_control.catalogued_date"><div class="unit"><H2>Descriptive Control</H2>^ca_entities.catalogue_control.catalogued_by<ifdef cde="ca_entities.catalogue_control.catalogued_date"> (^ca_entities.catalogue_control.catalogued_date)</ifdef></div></ifdef>}}}
<?php
		}
					$va_entities = $t_item->get("ca_entities.related", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
					if(is_array($va_entities) && sizeof($va_entities)){
						$va_entities_by_type = array();
						foreach($va_entities as $va_entity_info){
							$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
						}
						foreach($va_entities_by_type as $vs_type => $va_entity_links){
							print "<div class='unit'><H2>".$vs_type."</H2>".join(", ", $va_entity_links)."</div>";
						}
					}
?>					
				
				{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="subject_guide"><div class="unit"><H2>Related Subject Guides</H2><div class="trimTextShort"><unit relativeTo="ca_occurrences.related" delimiter=", " restrictToTypes="subject_guide"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
				{{{<ifdef code="ca_entities.places"><div class="unit"><H2>Related Places</H2><unit relativeTo="ca_entities.places" delimiter=", ">^ca_entities.places</unit></div></ifdef>}}}
<?php
		if($vb_2_col){
?>


			</div>
		</div>
<?php
		}
?>

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
					print "<div class='detailTool'>".caNavLink($this->request, "Inquire <span class='material-symbols-outlined'>chat</span>", "btn btn-default", "", "Contact", "Form", array("table" => "ca_entities", "id" => $t_item->get("ca_entities.entity_id")))."</div>";
					print "<div class='detailTool'>".caNavLink($this->request, "Feedback <span class='material-symbols-outlined'>add_comment</span>", "btn btn-default", "", "Contact", "Form", array("contactType" => "Feedback", "table" => "ca_entities", "id" => $t_item->get("ca_entities.entity_id")))."</div>";
					if($t_item->get("ca_entities.video_out", array("convertCodesToDisplayText" => true)) == "Yes"){
						print "<div class='detailTool'>".caNavLink($this->request, "Search Video Out <span class='material-symbols-outlined'>arrow_outward</span>", "btn btn-default", "", "Browse", "videoout", array("facet" => "artist_facet", "id" => $t_item->get("ca_entities.entity_id")))."</div>";
					}
					print "</div>";
?>					
		</div><!-- end col -->
	</div><!-- end row -->
<?php
	$va_events = $t_item->get("ca_occurrences", array("restrictToTypes" => array("event"), "returnWithStructure" => 1, "checkAccess" => $va_access_values));
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
							print "<div class='row'><div class='col-sm-12 text-center'>".caNavLink($this->request, "View All →", "btn btn-default", "", "Browse", "Events", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id")))."</div></div>";
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
					print "<div class='col-sm-3'>".caDetailLink($this->request, "<div class='bgDarkGray text-center'>".$qr_collections->getWithTemplate("<ifdef code='ca_collections.parent_id'><unit relativeTo='ca_collections.hierarchy' delimiter=' &gt; '><if rule='^ca_collections.type_id =~ /Fond/'>^ca_collections.preferred_labels.name &gt; </if></unit></ifdef>").$va_rel_collections[$qr_collections->get("ca_collections.collection_id")]["name"]."<br/><small>(".$qr_collections->getWithTemplate("^ca_collections.type_id").") (".$va_rel_collections[$qr_collections->get("ca_collections.collection_id")]["relationship_type"].")</small></div>", "", "ca_collections", $qr_collections->get("ca_collections.collection_id"))."</div>";
					$col++;
					if($col == 4){
						$col = 0;
						print "</div>";
					}
					$i++;
					if($i == 24){
						if(sizeof($va_collections) > 24){
							print "<div class='row'><div class='col-sm-12 text-center'>".caNavLink($this->request, "View All →", "btn btn-default", "", "Browse", "Collections", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id")))."</div></div>";
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'all_objects', array('facet' => 'detail_entity', 'id' => '^ca_entities.entity_id', 'detailNav' => 'entity'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		  maxHeight: 118,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>
