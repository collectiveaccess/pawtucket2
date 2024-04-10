<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 	$va_access_values = caGetUserAccessValues($this->request);
 	require_once(__CA_LIB_DIR__.'/Search/OccurrenceSearch.php');
?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<div class="container unit">	
	<div class="row">
		<div class="col-sm-5 fullWidthImg maxWidth text-center">
			<?php print caGetThemeGraphic($this->request, 'wordOfWeek.jpg', array("alt" => "Alutiiq Word of the Week")); ?>
		</div>
		<div class="col-sm-7">
			<h2 class="uk-h1">Lessons in Language and Culture</h2>
			{{{word_intro}}}
		</div>
	</div><!-- end row -->
<?php
 			$t_list_item = new ca_list_items();
			$t_list_item->load(array("idno" => "word"));
			$o_search = new OccurrenceSearch();
 		 	if(is_array($va_access_values) && sizeof($va_access_values)){
 		 		$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $va_access_values));
 		 		#$o_search->addResultFilter("ca_occurrences.type_id", "IN", array($t_list_item->get("item_id")));
			}
			$qr_res = $o_search->search("ca_occurrences.type_id:".$t_list_item->get("item_id")." AND ca_occurrences.feature_date:".date("m/d/Y"), array("sort" => "ca_occurrence_labels.name_sort"));
	
 			if($qr_res->numHits()){
 				while($qr_res->nextHit()){
 					$t_occurrence = new ca_occurrences($qr_res->get("ca_occurrences.occurrence_id"));
 ?>
 
			<div class="uk-card-default uk-card uk-card-body">    
				<hr class="uk-divider-small">
				<h3 class="uk-h2">This Week’s Lesson</h3>
			</div>
			<div class="wordFeaturedLesson">
				<div class="row">
					<div class="col-sm-6">
<?php						
						if($va_images = $t_occurrence->representationsWithMimeType(array('image/jpeg', 'image/tiff', 'image/png', 'image/x-dcraw', 'image/x-psd', 'image/x-dpx', 'image/jp2', 'image/x-adobe-dng', 'image/bmp', 'image/x-bmp'), array('versions' => array('large'), 'return_with_access' => $va_access_values))){
							foreach($va_images as $vn_rep_id => $va_image_info){
								$t_rep = new ca_object_representations($va_image_info["representation_id"]);
								print "<div class='unit fullWidthImg'>".$va_image_info["tags"]["large"];
								print $t_rep->getWithTemplate("<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-left unit'>^ca_object_representations.preferred_labels.name</div></if>");
								print "</div>";
							}
						}
						print $qr_res->getWithTemplate("<ifdef code='ca_occurrences.pronunciation_audio_clip'><span id='playPronunciation'><span class='uk-link el-image uk-icon' uk-icon='icon: microphone;'><svg width='20' height='20' viewBox='0 0 20 20'><line fill='none' stroke='#000' x1='10' x2='10' y1='16.44' y2='18.5'></line><line fill='none' stroke='#000' x1='7' x2='13' y1='18.5' y2='18.5'></line><path fill='none' stroke='#000' stroke-width='1.1' d='M13.5 4.89v5.87a3.5 3.5 0 0 1-7 0V4.89a3.5 3.5 0 0 1 7 0z'></path><path fill='none' stroke='#000' stroke-width='1.1' d='M15.5 10.36V11a5.5 5.5 0 0 1-11 0v-.6'></path></svg></span> <span class='uk-link uk-margin-remove-last-child'>Word &amp; Sentence</span></span></ifdef>");
													
?>
						
					</div>
					<div class='col-sm-6'>
						<div class='uk-h3'><?php print $qr_res->getWithTemplate("<l>^ca_occurrences.preferred_labels.name &mdash; ^ca_occurrences.alutiiq_word</l>"); ?>
						<?php print $qr_res->getWithTemplate("<ifdef code='ca_occurrences.sentence'><br/>^ca_occurrences.sentence</ifdef>"); ?></div>
					
						<?php print $qr_res->getWithTemplate("<ifdef code='ca_occurrences.description'><div class='uk-panel uk-margin'>^ca_occurrences.description%length=300&ellipsis=1</uk-panel uk-margin></ifdef>"); ?>
						<div class="unit text-center"><?php print caDetailLink($this->request, 'View Lesson ', 'uk-button uk-button-default', 'ca_occurrences', $qr_res->get("ca_occurrences.occurrence_id")); ?></div>
					
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-12">
						<div class="player"><iframe src="https://anchor.fm/alutiiqword/embed" scrolling="no" width="100%" frameborder="0"></iframe></div>
					</div>
				</div>
			</div> 					
 <?php					
 					if($vs_clip_url = $qr_res->get("ca_occurrences.pronunciation_audio_clip.original.url")){
 ?>
 						<script type='text/javascript'>
							$(document).ready(function() {
							var audioElement = document.createElement('audio');
							audioElement.setAttribute('src', '<?php print $vs_clip_url; ?>');
	
	
	
							$('#playPronunciation').click(function() {
								return audioElement.paused ? audioElement.play() : audioElement.pause();
							});
						});
						</script>
 <?php
 					}
					
 					break;
 				}
 			}
?>
</div>
<div class="uk-section-primary uk-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<hr class="uk-divider-small">
				<div class="uk-h2">Word of the Week Archive</div>
				<div class="fullWidthImg text-center">
					<?php print caGetThemeGraphic($this->request, 'archive.jpg', array("alt" => "Word of the week voices and advisors")); ?>			
					<div class="small unit">From left, April Counceller, Florence Pestrikof, Sophie Shepherd, and Nick Alokli, word of the week voices and advisors, sign copies of the Alutiiq Word of the Week book, 2012.</div>
				</div>
				<div class="unit">{{{word_archive_home}}}</div>
				<div class="text-center">
					<?php print caNavLink($this->request, _t("Visit the Archive")." <span class='uk-margin-small-left uk-icon' uk-icon='arrow-right'><svg width='20' height='20' viewBox='0 0 20 20'><polyline fill='none' stroke='#000' points='10 5 15 9.5 10 14'></polyline><line fill='none' stroke='#000' x1='4' y1='9.5' x2='15' y2='9.5'></line></svg></span>", "uk-button uk-button-default", "", "browse", "words"); ?>
					&nbsp;&nbsp;<a href="https://alutiiqmuseumstore.org/search?q=Word+of+the+Week+book&options%5Bprefix%5D=last" class="uk-button uk-button-default"><span class="uk-margin-small-right uk-icon" uk-icon="cart"><svg width="20" height="20" viewBox="0 0 20 20"><circle cx="7.3" cy="17.3" r="1.4"></circle><circle cx="13.3" cy="17.3" r="1.4"></circle><polyline fill="none" stroke="#000" points="0 2 3.2 4 5.3 12.5 16 12.5 18 6.5 8 6.5"></polyline></svg></span> Word of the Week Book</a>
				</div>
			</div>		
		</div>
	</div>
</div>
<div class="container">
	<div class="row unitLarge">
		<div class="col-sm-12 col-md-6 fullWidthImg text-center">
			<?php print caGetThemeGraphic($this->request, 'podcast.png', array("alt" => "Recording the Podcast")); ?>
			<div class="small unit">Dehrich Chya records a podcast at the Alutiiq Museum.</div>
		</div>
		<div class="col-sm-12 col-md-6">
			<hr class="uk-divider-small">
				<div class="uk-h2">{{{word_signup_title}}}</div>
				{{{word_signup}}}
				<div class="unit"><a href="https://publ.maillist-manage.com/ua/Optin?od=11287ecad08ab5&zx=12e31dbf&lD=16b23678355481cf&n=11699f74cec564d&sD=16b236783555c601" target="_blank" class="uk-button uk-button-default"><span class="uk-margin-small-right uk-icon" uk-icon="mail"><svg width="20" height="20" viewBox="0 0 20 20"><polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5"></polyline><path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z"></path></svg></span> Sign Me Up!</a></div>
		</div>
	</div>
	<div class="row unitLarge">
		<div class="col-sm-12 col-md-6 fullWidthImg text-center">
			<?php print caGetThemeGraphic($this->request, 'askUs.png', array("alt" => "Ask Us - Ap'skikut")); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<hr class="uk-divider-small">
				<div class="uk-h2">{{{cultural_question_title}}}</div>
				{{{cultural_question_title_text}}}
				<div class="unit"><a href="https://alutiiqmuseum.org/cultural-questions-portal/" target="_blank" class="uk-button uk-button-default">Ap’skikut.—Ask Us.</a></div>
		</div>
	</div>
</div>

	