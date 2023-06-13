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

	$col_width = $t_item->getRepresentationCount() ? 6 : 12;
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
				<!-- <div class='col-sm-6 col-md-6 col-lg-6'> -->
				<div class='col-sm-<?= $col_width; ?> col-md-<?= $col_width; ?> col-lg-<?= $col_width; ?>'>
					
					{{{representationViewer}}}

					<div id="detailAnnotations"></div>

					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>

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

					{{{<ifdef code="ca_occurrences.idno">
						<div class="unit">^ca_occurrences.idno</div>
					</ifdef>}}}

					{{{<ifdef code="ca_occurrences.formalCite">
						<div class="unit">
							<h4>^ca_occurrences.formalCite</h4>
						</div>
					</ifdef>}}}

					{{{<ifdef code="ca_occurrences.cataloguingNotes.cat_notes">
						<hr/>
					</ifdef>}}}

					<?php
						if($this->request->user->hasRole("admin")){
					?>
							{{{<ifdef code="ca_occurrences.cataloguingNotes.cat_notes">
								<div class="unit">
									<label>Notes</label>
									<unit relativeTo="ca_occurrences" delimiter="<br/>">							
										<span class="trimText">^ca_occurrences.cataloguingNotes.cat_notes</span>
										<ifdef code="ca_occurrences.cataloguingNotes.Cat_noteSource"><small><br/> - ^ca_occurrences.cataloguingNotes.Cat_noteSource</small></ifdef>
										<ifdef code="ca_occurrences.cataloguingNotes.Cat_noteDate"><small>, ^ca_occurrences.cataloguingNotes.Cat_noteDate</small></ifdef>
									</unit>
								</div>
							</ifdef>}}}
					<?php
						}
					?>

					{{{<ifcount code="ca_objects" min="1">
						<hr/>
					</ifcount>}}}	

					{{{<ifcount code="ca_objects" min="1">
						<label>Artworks</label>
						<div class="row">
							<div id="browseResultsContainer">
								<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
							</div><!-- end browseResultsContainer -->
						</div><!-- end row -->

						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

					{{{<ifcount code="ca_occurrences.related" min="1" restrictToRelationshipTypes="included">
						<hr/>
					</ifcount>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1" restrictToRelationshipTypes="included">
						<br/>
						<label>Exhibitions</label>
						<div class="unit">
							<unit relativeTo="ca_occurrences.related" delimiter="<br/><br/>" restrictToRelationshipTypes="included">
								<ifdef code="ca_occurrences.preferred_labels"><l><i>^ca_occurrences.preferred_labels</i>,</l></ifdef>	
								<ifdef code="ca_occurrences.PrimaryVenue.venueName">^ca_occurrences.PrimaryVenue.venueName</ifdef>	
								<ifdef code="ca_occurrences.DisplayDate">(^ca_occurrences.DisplayDate)</ifdef>	
							</unit>
						</div>
					</ifcount>}}}

					{{{<ifcount code="ca_objects" min="1" restrictToTypes="archivalObjects,archivalCorrespondence,archivalInterview,archivalPhotograph,archivalWriting">
						<hr/>
					</ifcount>}}}

					{{{<ifcount code="ca_objects" min="1" restrictToTypes="archivalObjects,archivalCorrespondence,archivalInterview,archivalPhotograph,archivalWriting">
						<label>Archival Material</label>
						<div class="unit">
							<unit relativeTo="ca_objects" delimiter="<br/>" restrictToTypes="archivalObjects,archivalCorrespondence,archivalInterview,archivalPhotograph,archivalWriting">
								(^ca_objects.idno) <l>^ca_objects.preferred_labels</l>
							</unit>
						</div>
					</ifcount>}}}

				</div><!-- end col -->
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
		  maxHeight: 120
		});
	});
</script>
