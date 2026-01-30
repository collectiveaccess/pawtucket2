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

?>
<div class="container">
	<div class="row">
		<div class='col-sm-12'>
			<div class="bgLightGrayDetail">
				<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id<if rule='^ca_entities.video_out =~ /Yes/'> / Video Out Artist</if>}}}</H2>
<?php
					if($vs_alt_labels){
						print "<div class='unit'><label>Alternate Names</label>".$vs_alt_labels."</div>";
					}
?>
					<!-- group -->
					{{{<ifdef code="ca_entities.org_gen_role"><div class="unit"><label>Type of Group</label>^ca_entities.org_gen_role%delimiter=,_</div></ifdef>}}}
					<!-- also community -->{{{<ifdef code="ca_entities.group_desc.org_desc_text"><div class="unit"><label>About</label><div class="trimText">^ca_entities.group_desc.org_desc_text<ifdef code="ca_entities.group_desc.org_desc_source"><br/><br/><i>^ca_entities.group_desc.org_desc_source<ifdef code="ca_entities.group_desc.org_desc_date">, ^ca_entities.group_desc.org_desc_date</ifdef></i></div></div></ifdef>}}}
					{{{<ifdef code="ca_entities.vital_dates_org.vital_date_value_org"><unit relativeTo="ca_entities.vital_dates_org" delimiter=" "><div class="unit"><ifdef code="ca_entities.vital_dates_org.entity_date_types_org"><label>^ca_entities.vital_dates_org.entity_date_types_org</label></ifdef>^ca_entities.vital_dates_org.vital_date_value_org</div></unit></ifdef>}}}
					<!-- end group -->
					
					<!-- Ind -->
					{{{<ifdef code="ca_entities.biography.biography_text"><div class="unit"><label>Biography</label><div class="trimText">^ca_entities.biography.biography_text<ifdef code="ca_entities.biography.biography_source"><br/><br/><i>^ca_entities.biography.biography_source<ifdef code="ca_entities.biography.biography_date">, ^ca_entities.biography.biography_date</ifdef></i></div></div></ifdef>}}}
					{{{<ifdef code="ca_entities.vital_dates_ind.vital_date_value_ind"><unit relativeTo="ca_entities.vital_dates_ind" delimiter=" "><div class="unit"><ifdef code="ca_entities.vital_dates_ind.entity_date_types_ind"><label>^ca_entities.vital_dates_ind.entity_date_types_ind</label></ifdef>^ca_entities.vital_dates_ind.vital_date_value_ind<ifdef code="ca_entities.vital_dates_ind.vital_date_location_ind">, ^ca_entities.vital_dates_ind.vital_date_location_ind</ifdef></div></unit></ifdef>}}}
					<!-- end Ind -->
					
					{{{<ifdef code="ca_entities.entity_notes"><div class="unit"><label>Notes</label>^ca_entities.entity_notes</div></ifdef>}}}
					
					{{{<ifdef code="ca_entities.vivo_role.VIVO_role_gen"><div class="unit"><label>Roles at VIVO</label><unit relativeTo='ca_entities.vivo_role' delimiter='<br/>'>^ca_entities.vivo_role.VIVO_role_gen%useSingular=1<ifdef code='ca_entities.vivo_role.VIVO_role_date'> (^ca_entities.vivo_role.VIVO_role_date)</ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_entities.identity.gender|ca_entities.identity.affiliation_descriptor"><div class="unit"><label>Identity</label><ifdef code="ca_entities.identity.gender">^ca_entities.identity.gender</ifdef><ifdef code="ca_entities.identity.gender,ca_entities.identity.affiliation_descriptor">, </ifdef><ifdef code="ca_entities.identity.affiliation_descriptor">^ca_entities.identity.affiliation_descriptor</ifdef><ifdef code="ca_entities.identity.source_desc"><br/><i>^ca_entities.identity.source_desc</i></ifdef></div></ifdef>}}}
					{{{<ifdef code="ca_entities.website"><div class="unit"><label>Website</label><unit relativeTo="ca_entities.website" delimiter="<br/>"><a href="^ca_entities.website" target="_blank">^ca_entities.website</a></unit></div></ifdef>}}}
					
					
<!-- Ind -->
					
					
					
<?php
		if($this->request->isLoggedIn()){
?>
						{{{<ifdef code="ca_entities.catalogue_control.catalogued_by|ca_entities.catalogue_control.catalogued_date"><div class="unit"><label>Descriptive Control</label>^ca_entities.catalogue_control.catalogued_by<ifdef cde="ca_entities.catalogue_control.catalogued_date"> (^ca_entities.catalogue_control.catalogued_date)</ifdef></div></ifdef>}}}
<?php
		}
					$va_entities = $t_item->get("ca_entities.related", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
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
				
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Collection<ifcount code="ca_collections" min="2">s</ifcount></label><unit relativeTo="ca_collections" delimiter=", "><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
			
				{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="event"><div class="unit"><label>Related programs & events</label><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="event"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="subject_guide"><div class="unit"><label>Related Subject Guides</label><div class="trimTextShort"><unit relativeTo="ca_occurrences.related" delimiter=", " restrictToTypes="subject_guide"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></div></div></ifcount>}}}
				{{{<ifdef code="ca_entities.places"><div class="unit"><label>Related Places</label><unit relativeTo="ca_entities.places" delimiter=", ">^ca_entities.places</unit></div></ifdef>}}}

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
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>
