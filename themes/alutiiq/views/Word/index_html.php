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
	<div class="row">
		<div class="col-sm-12">
			<h1>Alutiiq Word of the Week</h1>
		</div>
	</div>
	<div class="row flex">
		<div class="col-sm-3 fullWidthImg maxWidth unit text-center">
			<?php print caGetThemeGraphic($this->request, 'AWOTWlogo.jpg', array("alt" => "Alutiiq Word of the Week")); ?>
		</div>
		<div class="col-sm-9 wordCallout">
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
?>
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2>Featured Lesson</h2>	
				</div>
			</div>

<?php
 				while($qr_res->nextHit()){
 					$t_occurrence = new ca_occurrences($qr_res->get("ca_occurrences.occurrence_id"));
 ?>
 
			<div class="wordFeaturedLesson">
				<div class="row flex">
					<div class="col-sm-5">
<?php						
						if($va_images = $t_occurrence->representationsWithMimeType(array('image/jpeg', 'image/tiff', 'image/png', 'image/x-dcraw', 'image/x-psd', 'image/x-dpx', 'image/jp2', 'image/x-adobe-dng', 'image/bmp', 'image/x-bmp'), array('versions' => array('large'), 'return_with_access' => $va_access_values))){
							foreach($va_images as $vn_rep_id => $va_image_info){
								$t_rep = new ca_object_representations($va_image_info["representation_id"]);
								print "<div class='unit fullWidthImg'>".$va_image_info["tags"]["large"];
								print $t_rep->getWithTemplate("<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-left'>^ca_object_representations.preferred_labels.name</div></if>");
								print "</div>";
							}
						}							
?>
						<?php #print $qr_res->getWithTemplate("<unit relativeTo='ca_object_representations' filterNonPrimaryRepresentations='1' length='1' sort='is_primary' sortDirection='desc' delimiter='<br/>'><ifdef code='ca_object_representations.media.large'><div class='unit fullWidthImg'>^ca_object_representations.media.large<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-left'>^ca_object_representations.preferred_labels.name</div></if></div></ifdef><unit>"); ?>
					</div>
					<div class='col-sm-7'>
						<div class='wordFeaturedLessonTitle'><?php print $qr_res->getWithTemplate("<l>^ca_occurrences.preferred_labels.name &mdash; ^ca_occurrences.alutiiq_word</l> <ifdef code='ca_occurrences.pronunciation_audio_clip'> <i id='playPronunciation' class='fa fa-volume-up' aria-hidden='true'></i></ifdef>"); ?></div>
						<?php print $qr_res->getWithTemplate("<ifdef code='ca_occurrences.sentence'><div class='unit'>^ca_occurrences.sentence</div></ifdef>"); ?>
					
						<?php print $qr_res->getWithTemplate("<ifdef code='ca_occurrences.description'><div class='unit'>^ca_occurrences.description%length=300&ellipsis=1</div></ifdef>"); ?>
						<div class="unit text-center"><?php print caDetailLink($this->request, 'View Lesson ', 'btn btn-default', 'ca_occurrences', $qr_res->get("ca_occurrences.occurrence_id")); ?></div>
					
					</div><!-- end col -->
				</div><!-- end row -->
			</div>
			
				<div class="row">
					<div class="col-sm-12">
						<div class="unit"><iframe src="https://anchor.fm/alutiiqword/embed" scrolling="no" width="100%" frameborder="0"></iframe></div>
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
	<div class="row">
		<div class="col-sm-12 text-center">
			<H3>Word of the Week Archive</H3>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
					<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'words'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="Search the Archive" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form>
				</div>
			</div>
			<div class="wordCallout">{{{word_archive_home}}}</div>
			<?php print caNavLink($this->request, "<div class='wordFindBox'>"._t("Browse the Archive")."</div>", "", "", "browse", "words"); ?>
		</div>		
	</div>
	<div class="container">
		<div class="row hpIntroTop flex bg_gray">
			<div class="col-sm-12 col-md-4 col-lg-4 fullWidthImg maxWidth text-center">
				<?php print caGetThemeGraphic($this->request, 'AWOTWlogo.jpg', array("alt" => "Alutiiq Word of the Week")); ?>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 col-md-offset-1">
			
				<div class="hpIntroTopDesc">
					<div class="hpIntroTopDescTitle">{{{word_signup_title}}}</div>{{{word_signup}}}
					<div class="text-center"><a href="https://publ.maillist-manage.com/ua/Optin?od=11287ecad08ab5&zx=12e31dbf&lD=16b23678355481cf&n=11699f74cec564d&sD=16b236783555c601" target="_blank" class="btn btn-default">Subscribe</a></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row wordResources">
		<div class="col-sm-4">
			<?php print caNavLink($this->request, "<div class='wordFindBox'>"._t("About the Archive")."</div>", "", "", "About", ""); ?>
		</div>
		<div class="col-sm-4">
			<a href="https://alutiiqmuseum.org/files/AWOTW Sounds/References.pdf"><div class='wordFindBox'>Archive References</div></a>
		</div>
		<div class="col-sm-4">
			<a href="https://alutiiqmuseum.org/files/AWOTW%20Sounds/AGLConceller.pdf"><div class='wordFindBox'>Alutiiq Language</div></a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center hpCallOut">
			<h4>Contact Us</h4>
			{{{word_contact}}}
			<p><a href="https://forms.zohopublic.com/alutiiqm/form/CultureQuestionsPortal/formperma/Jiz_tPrg-f9KaE1ngmbZCQ0cVMakqBd6GcVxxY2a4k8" class="btn btn-default">Ap'skikut—Ask Us</a></p>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-sm-12 text-center">
			<b>{{{word_funder}}}</b><br/><br/>
			<div class="row">
				<div class="col-sm-3 col-sm-offset-3 funderImg">
					<a href="https://www.koniag.com" target="_blank"><?php print caGetThemeGraphic($this->request, 'Koniag-Logo.jpg', array("alt" => "Koniag Inc")); ?></a>
				</div>
				<div class="col-sm-3 funderImg">
					<a href="https://www.imls.gov" target="_blank"><?php print caGetThemeGraphic($this->request, 'IMLS.png', array("alt" => "IMLS")); ?></a>
				</div>
			</div>
		</div>
	</div>
	<hr/>

	