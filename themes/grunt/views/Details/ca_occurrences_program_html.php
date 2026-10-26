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
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					{{{<ifdef code="ca_occurrences.occurrence_date|ca_occurrences.program_type"><H2>^ca_occurrences.occurrence_date<ifdef code="ca_occurrences.program_type"><br/>^ca_occurrences.program_type%delimiter=,_</ifdef></H2></ifdef>}}}					
				</div>
				<div class='col-md-2'>
<?php
					print "<div id='detailTools'><div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "", "", "Contact", "Form", array("table" => "ca_occurrences", "id" => $t_item->get("ca_occurrences.occurrence_id")))."</div></div>";
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
$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
$vb_2_col = false;
if($t_item->get("ca_occurrences.content_description") || $t_item->get("ca_occurrences.credits") || sizeof($va_entities)){
	$vb_2_col = true;
}
if($vb_2_col){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.content_description"><div class="unit"><H3>About the Program</H3><span class="trimText">^ca_occurrences.content_description</span></div></ifdef>}}}
<?php
				if(is_array($va_entities) && sizeof($va_entities)){
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><H3>".$vs_type."</H3>".join(", ", $va_entity_links)."</div>";
					}
				}

?>				

					{{{<ifdef code="ca_occurrences.credits"><div class="unit"><H3>Credits</H3><span class="trimText">^ca_occurrences.credits</span></div></ifdef>}}}
					
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
				<div class='col-md-6 col-lg-6'>
<?php
}else{
?>
				<div class='col-sm-12'>
<?php
}
?>
					{{{<ifdef code="ca_occurrences.idno"><div class="unit"><H3>Identifier</H3>^ca_occurrences.idno</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.parent_id"><div class="unit"><H3>Part of the series</H3><unit relativeTo="ca_occurrences.parent" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.children.occurrence_id"><div class="unit"><H3>Programs in this series</H3><span class="trimTextShort"><unit relativeTo="ca_occurrences.children" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></span></div></ifdef>}}}
					
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><H3>Collection</H3><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					
					{{{<ifdef code="ca_occurrences.language"><div class="unit"><H3>Language</H3>^ca_occurrences.language</div></ifdef>}}}

					{{{<ifcount code="ca_occurrences.related" min="1" restrictToTypes="program"><div class="unit"><H3>Related program<ifcount code="ca_occurrences.related" min="2" restrictToTypes="program">s</ifcount></H3><span class="trimTextShort"><unit relativeTo="ca_occurrences.related" delimiter="<br/>" restrictToTypes="program"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></span></div></ifcount>}}}
					
					{{{<ifdef code="ca_occurrences.program_location"><div class="unit"><H3>Location</H3><span class="trimTextShort"><unit relativeTo="ca_occurrences.program_location" delimiter="<br/><br/>">^ca_occurrences.program_location<unit></span></div></ifdef>}}}
					
					{{{<ifdef code="ca_occurrences.rightsSummary_asset"><div class="unit"><i>^ca_occurrences.rightsSummary_asset</i></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.content_notice"><div class="unit"><i>^ca_occurrences.content_notice</i></div></ifdef>}}}
					
					
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
					jQuery("#browseResultsContainerobjects").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'detail_occurrence', 'id' => '^ca_occurrences.occurrence_id', 'detailNav' => 'occurrence', 'dontSetFind' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainerobjects').jscroll({
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
