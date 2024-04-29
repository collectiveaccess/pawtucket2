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
	
	
	$vs_image = $t_item->getWithTemplate("<ifcount code='ca_objects' max='1'><unit relativeTo='ca_objects'><l>^ca_object_representations.media.large</l><l>^ca_objects.preferred_labels.name</l></unit></ifcount>");
	$vb_bottom_box = false;
	if($t_item->get("ca_occurrences.related.occurrence_id", array("checkAccess" => $va_access_values))){
		$vb_bottom_box = true;
	}
	if($t_item->get("ca_occurrences.georeference")){
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
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<H2>{{{^ca_occurrences.type_id}}}</H2>
				</div>
				<div class='col-sm-12 col-md-2 inquireCol'>
					<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
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
						{{{<ifdef code="ca_occurrences.description"><div class="unit">^ca_occurrences.description</div></ifdef>}}}
						
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			if($vb_bottom_box){
?>
				<div class="bgLightGray container"><div class="row">
<?php
			}
?>
				{{{<ifcount code="ca_occurrences.related" restrictToTypes="studio_session,appearance" min="1">
					<div class="col-sm-12 col-md-6">
						<ifcount code="ca_occurrences.related" restrictToTypes="studio_session" min="1"><div class="unit"><label>Studio Session<ifcount code="ca_occurrences.related" restrictToTypes="studio_session" min="2">s</ifcount></label>
							<unit relativeTo="ca_occurrences.related" restrictToTypes="studio_session" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
						</ifcount>
						<ifcount code="ca_occurrences.related" restrictToTypes="appearance" min="1"><div class="unit"><label>Related Appearance<ifcount code="ca_occurrences.related" restrictToTypes="appearance" min="2">s</ifcount></label>
							<unit relativeTo="ca_occurrences.related" restrictToTypes="appearance" delimiter="<br/>"><l><ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="tour" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>: </ifcount><ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>, </ifcount><ifdef code="ca_occurrences.date_occurrence_container.date_occurrence">^ca_occurrences.date_occurrence_container.date_occurrence<ifdef code="ca_occurrences.date_occurrence_container.date_note_occurrence"> (^ca_occurrences.date_occurrence_container.date_note_occurrence)</ifdef></ifdef></l></unit></div>
						</ifcount>
					</div>
				</ifcount>}}}
<?php
				if($vs_map = trim($this->getVar("map"))){
					print '<div class="col-sm-12 col-md-6">
									<br/><div class="unit">'.$vs_map.'</div>
								</div>';
				}
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

				
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div class='col-sm-12'>
					<label>Related Archival Items</label>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
