<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_id	= 				$t_object->get('ca_objects.object_id');
	$va_access_values = caGetUserAccessValues($this->request);
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
			<div class="col-sm-12 col-lg-10 col-lg-offset-1 text-left">
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<hr/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-center">
				{{{representationViewer}}}
				
				<div id="detailAnnotations"></div><!-- end detailAnnotations -->
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-lg-10 col-lg-offset-1 text-left">
				<hr/>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{<ifdef code="ca_objects.transcript.media.original.url"><div class="unit"><label><a href="^ca_objects.transcript.media.original.url"><span class='glyphicon glyphicon glyphicon-download' aria-hidden='true'></span> Interview Transcript</a></label></div></ifdef>}}}
				
			</div><!-- end col -->			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><div class="unit"><label>Interview With</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="interviewer" min="1"><div class="unit"><label>Interviewer</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="interviewer" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.date.dates_value"><div class="unit"><label>Date</label>^ca_objects.date.dates_value%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.rights.copyrightStatement"><div class="unit"><label>Copyright Statement</label>^ca_objects.rights.copyrightStatement</div></ifdef>}}}
				{{{<ifdef code="ca_objects.interview_location"><div class="unit"><label>Interview Location</label>^ca_objects.interview_location</div></ifdef>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="recorded" min="1"><div class="unit"><label>Recorded By</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="recorded" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
				
<?php
				if($vs_tmp = $this->getVar("access_reproduction")){
					print "<div class='unit'><label>Access and Reproduction</label>".$vs_tmp."</div>";
				}
?>
			</div><!-- end col -->
		</div><!-- end row -->
{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator"><ifcount code="ca_objects" restrictToRelationshipTypes="creator" restrictToTypes="image" min="1">
			<br/><br/><br/>
			<div class="row">
				<div class="col-sm-12">
					<H2>Featured Artworks</H2><HR/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'artworks', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount></unit></ifcount>}}}
		<div class="row">
<?php		
				$qr_res = ca_objects::find(['type_id' => 'interview'], ['returnAs' => 'searchResult', 'checkAccess' => $va_access_values]);			
				if ($qr_res) {
					print "<div class='col-sm-12'><h2 style='margin-top:45px;margin-bottom:10px;'>More Interviews</h2><hr/></div>";
					$vn_i = 0;
					$vn_c = 0;
					while ($qr_res->nextHit()) {
						if ($qr_res->get('access') == 0){ continue; }
						if ($qr_res->get('ca_objects.object_id') == $vn_id) { continue; }
						print "<div class='col-sm-3 relatedThumbs'>";
						print "<div>".caDetailLink($this->request, $qr_res->get('ca_object_representations.media.iconlarge'), '', 'ca_objects', $qr_res->get('ca_objects.object_id') )."</div>";
						print "<div style='padding-top:10px;'>".$qr_res->get('ca_objects.preferred_labels', array('returnAsLink' => true))."</div>";
						print "</div>";
						$vn_i++;
						if ($vn_i == 4) {
							print "<div style='clear:both;width:100%;'></div>";
							$vn_i = 0;
						}
						$vn_c++;
						if($vn_c == 12){
							break;
						}
					}
			}	
?>			
		</div><!-- end row -->
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
		  maxHeight: 333
		});
	});
</script>