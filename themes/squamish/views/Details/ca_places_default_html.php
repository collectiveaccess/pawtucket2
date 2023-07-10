<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_placess_default_html.php : 
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
					<H1>{{{^ca_places.preferred_labels.name}}}</H1>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>

					
<?php
					$vs_clip_url = $t_item->get("ca_places.pronunciation_container.pronunciation_upload.mp3.url");
					$vs_clip_notes = $t_item->get("ca_places.pronunciation_container.pronunciation_note");
					if($vs_clip_url){				
						print "<div class='unit'><i id='playPronunciation".$vs_rep_id."' class='fa fa-play-circle-o audioButton' aria-hidden='true'></i>";
						if($vs_clip_notes){
							print "<br/>".$vs_clip_notes;
						}
						print "</div>";				
?>
						<script type='text/javascript'>
							$(document).ready(function() {
								var audioElement<?php print $vs_rep_id; ?> = document.createElement('audio');
								audioElement<?php print $vs_rep_id; ?>.setAttribute('src', '<?php print $vs_clip_url; ?>');
								$('#playPronunciation<?php print $vs_rep_id; ?>').click(function() {
									//return audioElement<?php print $vs_rep_id; ?>.paused ? audioElement<?php print $vs_rep_id; ?>.play() : audioElement<?php print $vs_rep_id; ?>.pause();
							
									if(audioElement<?php print $vs_rep_id; ?>.paused){
										$('#playPronunciation<?php print $vs_rep_id; ?>').removeClass('fa-play-circle-o');
										$('#playPronunciation<?php print $vs_rep_id; ?>').addClass('fa-pause-circle-o');
										return audioElement<?php print $vs_rep_id; ?>.play();
									}else{
										$('#playPronunciation<?php print $vs_rep_id; ?>').removeClass('fa-pause-circle-o');
										$('#playPronunciation<?php print $vs_rep_id; ?>').addClass('fa-play-circle-o');
										return audioElement<?php print $vs_rep_id; ?>.pause();
									}
								});
							});
						</script>
<?php
					}
?>
					{{{<ifdef code="ca_places.description"><div class="unit"><label>Description</label>^ca_places.description</div></ifdef>}}}
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Related Collection<ifcount code="ca_collections" min="2">s</ifcount></label>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div>
					</ifcount>}}}

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
					{{{map}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<label>Related Records</label><hr/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
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
</ifcount>}}}		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
