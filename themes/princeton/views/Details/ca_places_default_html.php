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
					<H1>{{{^ca_places.preferred_labels.name}}}</H1>
					{{{<ifdef code="ca_places.parent_id"><div class="unit"><unit relativeTo="ca_places.hierarchy" delimiter=" &gt; "><l>^ca_places.preferred_labels.name</l></unit></div></ifdef>}}}
					
					<hr>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-5'>
					{{{representationViewer}}}
				</div>
				<div class='col-sm-6 col-md-6 col-lg-7'>
				
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
					
					
					{{{<ifcount code="ca_places.nonpreferred_labels" min="1" restrictToTypes="display_variant,butler"><div class="unit"><label>Alternate Name<ifcount code="ca_places.nonpreferred_labels" min="2">s</ifcount></label><unit relativeTo="ca_places.nonpreferred_labels" restrictToTypes="display_variant,butler" delimiter="<br>">^ca_places_labels.name</unit></div></ifcount>}}}

					{{{<ifdef code="ca_places.description">
						<div class='unit'><label>Description</label>
							<span class="trimText">^ca_places.description</span>
						</div>
					</ifdef>}}}
					
					{{{<ifcount code="ca_places.children" min="1">
						<div class="unit"><label>Contains</label><span class="trimText"><unit relativeTo="ca_places.children" delimiter="<br>"><l>^ca_places.preferred_labels.name</l></unit></span>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_collections" min="1">
						<div class="unit"><label>Related Collection<ifcount code="ca_collections" min="2">s</ifcount></label><unit relativeTo="ca_collections" delimiter="<br>"><l>^ca_collections.preferred_labels.name</l></unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="work">
						<div class="unit"><label>Related Work<ifcount code="ca_occurrences" min="2" restrictToTypes="work">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="work" delimiter="<br>">
							<l>^ca_occurrences.preferred_labels.name</l>
						</unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_entities" min="1">
						<div class="unit"><label>Related <ifcount code="ca_entities" max="1">Entity</ifcount><ifcount code="ca_entities" min="2">Entities</ifcount></label>
						<unit relativeTo="ca_entities" delimiter="<br>">
							<l>^ca_entities.preferred_labels.displayname</l>
						</unit>
					</div></ifcount>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			
		{{{<ifcount code="ca_objects" min="1">
			<br>
			<div class="row">	
				<div class="col-sm-6"><H2>Related Object<ifcount code="ca_objects" min="2">s</ifcount></H2></div>
				<ifcount code="ca_objects" min="9">
					<div class="col-sm-6 text-right">
						<?php print caNavLink($this->request, "Browse All Related Objects", "btn btn-default", "", "Browse", "objects", array("facet" => "place_facet", "id" => $t_item->get("ca_places.place_id"))); ?>
					</div>
				</ifcount>
			</div>
			<div class="row">	
				<div class="col-sm-12"><HR></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script>
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'place_facet', 'id' => '^ca_places.place_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
<script>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 130
		});
	});
</script>
