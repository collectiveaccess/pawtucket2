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
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H2>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					
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
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
					
					{{{<ifdef code="ca_entities.vhh_Date" min="1"><div class="unit"><label><t>Date</t></label>
						<unit relativeTo="ca_entities.vhh_Date" delimiter="<br/>">
						<l>^ca_entities.vhh_Date.date_Date</l> <ifdef code="ca_entities.vhh_Date.date_Type">(^date_Type)</ifdef>
					</unit></div></ifdef>}}}

					
					{{{<ifdef code="ca_entities.vhh_Sex"><div class='unit'><label><t>Gender</t></label>^ca_entities.vhh_Sex</div></ifdef>}}}
					
					{{{<ifdef code="ca_entities.vhh_TypeOfActivity2" >
						<div class="unit"><label><t>Type of Activity</t></label>
							<unit relativeTo="ca_entities.vhh_TypeOfActivity2" delimiter="<br/>"><ifdef code="ca_entities.vhh_TypeOfActivity2.ActivityList|ca_entities.vhh_TypeOfActivity2.ActivityText">
								<b>^ActivityList.preferred_labels.name_singular</b><ifdef code="ca_entities.vhh_TypeOfActivity2.ActivityList,ca_entities.vhh_TypeOfActivity2.ActivityText"> &mdash; </ifdef>^ca_entities.vhh_TypeOfActivity2.ActivityText
								<ifdef code="ca_entities.vhh_TypeOfActivity2.TOA_TempScope|ca_entities.vhh_TypeOfActivity2.__source__"><a href="#" class="entityInfoButton"><i class="fa fa-info-circle" aria-hidden="true"></i></a></ifdef>
								<div class="entityInfo" style="padding-left: 20px !important;display: none !important;">
									<ifdef code="ca_entities.vhh_TypeOfActivity2.TOA_TempScope">
										<br/>
										<small><t>Temporal Scope:</t></small>
										<small>^ca_entities.vhh_TypeOfActivity2.TOA_TempScope</small>
									</ifdef>
									<ifdef code="ca_entities.vhh_TypeOfActivity2.__source__">
										<br/>
										<small><t>Source:</t></small>
										<small>^ca_entities.vhh_TypeOfActivity2.__source__</small>
									</ifdef>
								</div>
							</ifdef></unit>
						</div>
					</ifdef>}}}
					
					{{{<ifdef code="ca_entities.vhh_Description"><div class='unit'><label><t>Description</t></label>^ca_entities.vhh_Description</div></ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_URL"><div class='unit'><label><t>URL</t></label><unit relativeTo="ca_entities.vhh_URL" delimiter="<br/>"><a href="^ca_entities.vhh_URL" target="_blank">^ca_entities.vhh_URL</a></unit></div></ifdef>}}}

					{{{<ifdef code="ca_entities.vhh_Note"><div class='unit'><label><t>Notes</t></label><span class="trimText">^ca_entities.vhh_Note%convertLineBreaks=1</span></div></ifdef>}}}
					
				</div><!-- end col -->

				<div class='col-sm-6 col-md-6 col-lg-6'>

				
					{{{<ifdef code="ca_entities.description"><div class='unit'><label><t>Biography</t></label>^ca_entities.description</div></ifdef>}}}
					
					{{{<ifcount code="ca_collections" min="1" max="1"><label><t>Related Case Study</t></label></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><label><t>Related Case Studies</t></label></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><label><t>Related Event</t></label></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><label><t>Related Events</t></label></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><label><t>Related Location</t></label></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><label><t>Related Locations</t></label></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>}}}

					{{{<ifcount code="ca_entities.related" min="1" max="1"><label><t>Related Person/Organization</t></label></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><label><t>Related People/Organizations</t></label></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit>}}}
					
					{{{map}}}
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects.related" min="1">
			<H1><t>Related Films, Texts and Images</t></H1>
			<div class="row">
				<div id="browseResultsContainer">
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
		  maxHeight: 120
		});
	});
</script>
