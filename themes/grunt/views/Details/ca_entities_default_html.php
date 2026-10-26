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
	
	# --- result context
	$va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_object_ids) && sizeof($va_object_ids)){
		$o_rel_context = new ResultContext($this->request, 'ca_objects', 'detailrelated', $this->request->getAction);
		#$o_rel_context->setParameter('key', $key);
		$o_rel_context->setAsLastFind(true);
		
		$o_rel_context->setResultList($va_object_ids);
		
		$o_rel_context->saveContext();
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
				<div class='col-md-10'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}</H2>
					
				</div><!-- end col -->
				<div class='col-md-2'>
<?php
					print "<div id='detailTools'><div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "", "", "Contact", "Form", array("table" => "ca_entities", "id" => $t_item->get("ca_entities.entity_id")))."</div></div>";
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-md-12'>
					<HR/>
				</div>
			</div>
			<div class="row">			
<?php
$vb_2_col = false;
$vs_alt_labels = $t_item->getWithTemplate("^ca_entities.nonpreferred_labels", array("checkAccess" => $va_access_values, "delimiter" => "<br/>"));
if($vs_alt_labels || $t_item->get("ca_entities.vital_dates_org.vital_date_value_org") || $t_item->get("ca_entities.ind_gen_role") || $t_item->get("ca_entities.org_gen_role") || $t_item->get("ca_entities.grunt_role.grunt_role_gen") || $t_item->get("ca_entities.biography.biography_text") || $t_item->get("ca_entities.org_desc.org_desc_text")){
	$vb_2_col = true;
}
if($vb_2_col){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if($vs_alt_labels){
						print "<div class='unit'><H3>Alternate Names</H3>".$vs_alt_labels."</div>";
					}
?>
					{{{<ifdef code="ca_entities.ind_gen_role"><div class="unit"><H3>Roles</H3>^ca_entities.ind_gen_role%delimiter=,_&%useSingular=1</div></ifdef>}}}
					{{{<ifdef code="ca_entities.org_gen_role"><div class="unit"><H3>Type</H3>^ca_entities.org_gen_role%delimiter=,_&%useSingular=1</div></ifdef>}}}
					{{{<ifdef code="ca_entities.grunt_role.grunt_role_gen"><div class="unit"><H3>Roles at grunt</H3><unit relativeTo='ca_entities.grunt_role' delimiter=', '>^ca_entities.grunt_role.grunt_role_gen%useSingular=1<ifdef code='ca_entities.grunt_role.grunt_role_date'> (^ca_entities.grunt_role.grunt_role_date)</ifdef></unit></div></ifdef>}}}
					
					{{{<ifdef code="ca_entities.vital_dates_org.vital_date_value_org"><unit relativeTo="ca_entities.vital_dates_org" delimiter=" "><div class="unit"><ifdef code="ca_entities.vital_dates_org.entity_date_types_org"><H3>^ca_entities.vital_dates_org.entity_date_types_org</H3></ifdef>^ca_entities.vital_dates_org.vital_date_value_org<ifdef code="ca_entities.vital_dates_org.vital_date_location_org"><br/>^ca_entities.vital_dates_org.vital_date_location_org</ifdef></div></unit></ifdef>}}}
					
					{{{<ifdef code="ca_entities.biography.biography_text"><div class="unit"><H3>Biography</H3><span class="trimText">^ca_entities.biography.biography_text</span></div></ifdef>}}}
					{{{<ifdef code="ca_entities.org_desc.org_desc_text"><div class="unit"><H3>About</H3><span class="trimTextShort">^ca_entities.org_desc.org_desc_text</span></div></ifdef>}}}
					
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
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
}else{
?>
				<div class='col-sm-12'>
<?php
}
?>
					{{{<ifdef code="ca_entities.website"><div class="unit"><H3>Website</H3><unit relativeTo="ca_entities.website" delimiter=", "><a href="^ca_entities.website" target="_blank">^ca_entities.website</a></unit></div></ifdef>}}}
					{{{<if rule='^ca_entities.type_id =~ /Organization/'><ifdef code="ca_entities.address"><div class="unit"><H3>Address</H3><unit relativeTo="ca_entities.address" delimiter="<br/><br/>"></unit><ifdef code="ca_entities.address.address1">^ca_entities.address.address1<br/></ifdef><ifdef code="ca_entities.address.address2">^ca_entities.address.address2<br/></ifdef><ifdef code="ca_entities.address.city">^ca_entities.address.city, </ifdef><ifdef code="ca_entities.address.stateprovince">^ca_entities.address.stateprovince </ifdef><ifdef code="ca_entities.address.country">^ca_entities.address.country</ifdef></div></ifdef></if>}}}
					
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><H3>Collection</H3><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="program"><div class="unit"><H3>Related program<ifcount code="ca_occurrences" min="2" restrictToTypes="program">s</ifcount></H3><span class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="program"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></span></div></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="1"><div class="unit"><H3>Related people & organizations</H3><span class="trimTextShort"><unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit></span></div></ifcount>}}}
					{{{<ifcount code="ca_places" min="1"><div class="unit"><H3>Related place</H3><unit relativeTo="ca_places" delimiter=", ">^ca_places.preferred_labels.name</unit></div></ifcount>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12"><H3>Related Archive, Library & Publication Objects</H3><HR/></div>
			</div>
			<div class="row">
				<div id="browseResultsContainerobjects">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainerobjects").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'detail_entity', 'id' => '^ca_entities.entity_id', 'detailNav' => 'entity', 'dontSetFind' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainerobjects').jscroll({
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
		  maxHeight: 407,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>
