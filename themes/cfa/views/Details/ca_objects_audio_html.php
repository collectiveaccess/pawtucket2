<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');

	$media = $t_object->get('ca_object_representations.media.small', ['returnAsArray' => true]);
?>
<div class="row">
	
	<main class="flush">
	<section class="hero-single-collection wrap">
		<div class="eyebrow text__eyebrow color__gray">
			<div class="detailNavigation">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div><br>
			<div class="row">
				<div class="col-10">
					 {{{<unit relativeTo="ca_collections"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">
						<l>^ca_collections.preferred_labels<l>
					</unit></unit>}}}
				</div>

				<div class="col-2 text-end">
					<a href="#" id="sharelink" class="text__eyebrow share-link" onclick="Copy();">
						Share Link 
						<span class="icon">
							<svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.96534 7.52607L10.8531 5.63834C11.1996 5.29178 11.5429 4.95189 11.7448 4.4976C12.1317 3.62608 12.0881 2.58968 11.553 1.78543C11.028 0.994675 10.1398 0.5 9.18752 0.5C8.41353 0.5 7.69352 0.826368 7.15168 1.36812C6.47875 2.04105 5.80568 2.71412 5.13275 3.38705C4.69534 3.82446 4.34199 4.32253 4.21746 4.94159C4.02898 5.87364 4.30161 6.8529 4.97793 7.52925C5.16301 7.71433 5.37836 7.87581 5.60721 8.00374C5.84615 8.13835 6.15903 8.06089 6.29705 7.82206C6.43506 7.58992 6.3542 7.26685 6.11537 7.13222C5.76542 6.93365 5.54664 6.71161 5.36839 6.37514C5.3448 6.33477 5.32462 6.291 5.30443 6.24722C5.24047 6.11261 5.32802 6.33466 5.28424 6.19335C5.25737 6.10592 5.22709 6.01837 5.2035 5.92753C5.19341 5.88376 5.18672 5.8367 5.17662 5.79292C5.14635 5.64822 5.17662 5.89045 5.16994 5.74245C5.16325 5.63472 5.15984 5.5271 5.16324 5.41936C5.16665 5.3723 5.16994 5.32853 5.17334 5.28134C5.16325 5.39577 5.18003 5.24766 5.18343 5.23428C5.20021 5.14345 5.2238 5.05261 5.25068 4.96506C5.26417 4.92129 5.28096 4.87763 5.29774 4.83385C5.26077 4.93138 5.31793 4.79008 5.32133 4.78339C5.3617 4.69924 5.40876 4.61509 5.46263 4.53435C5.4895 4.49398 5.5165 4.45361 5.54337 4.41652C5.48282 4.49386 5.58375 4.36946 5.58715 4.36606C5.62083 4.32909 5.65439 4.292 5.69148 4.25503L7.90218 2.04434C7.95933 1.98718 8.02001 1.92991 8.08385 1.87944C8.00651 1.94 8.13432 1.84576 8.13772 1.84248C8.1781 1.8156 8.21847 1.78861 8.25884 1.76514C8.33958 1.71807 8.42373 1.6709 8.51116 1.63721C8.41363 1.67759 8.55493 1.62372 8.56503 1.62043C8.62218 1.60025 8.68286 1.58346 8.74341 1.56656C8.78719 1.55647 8.83425 1.54638 8.87802 1.53628C8.89152 1.53288 9.04292 1.5161 8.92509 1.52619C9.01592 1.5161 9.11016 1.5127 9.201 1.5127C9.24806 1.5127 9.29183 1.5161 9.33901 1.51939C9.35251 1.51939 9.5039 1.53957 9.38948 1.52279C9.49721 1.53957 9.60143 1.56316 9.70575 1.59344C9.74953 1.60694 9.79319 1.62372 9.83696 1.63721C9.97826 1.68099 9.75622 1.59344 9.89083 1.6574C9.97498 1.69777 10.0591 1.74155 10.1399 1.79201C10.1802 1.81889 10.2206 1.84588 10.261 1.87276C10.3417 1.92662 10.2913 1.89634 10.2745 1.88285C10.3518 1.94341 10.4226 2.01077 10.4932 2.08142C10.7322 2.33046 10.8802 2.61305 10.9576 2.97652C10.9677 3.0203 10.9744 3.06736 10.9812 3.11454C10.9644 3.00011 10.9812 3.15151 10.9846 3.165C10.9913 3.25584 10.9913 3.35008 10.988 3.44092C10.9846 3.48798 10.9813 3.53175 10.9779 3.57893C10.988 3.46451 10.9712 3.61262 10.9678 3.62599C10.9476 3.73373 10.9208 3.83795 10.8837 3.93887C10.8803 3.94897 10.8265 4.09027 10.8669 3.99274C10.8501 4.03652 10.8265 4.08018 10.8063 4.12066C10.7626 4.20481 10.7155 4.28896 10.6616 4.3663C10.6683 4.3562 10.5742 4.48413 10.6146 4.43354C10.655 4.37968 10.554 4.5042 10.5607 4.4941C10.527 4.53447 10.4901 4.57144 10.453 4.60853L8.24556 6.81595C8.05379 7.00772 8.05379 7.33749 8.24556 7.52926C8.44378 7.72126 8.77015 7.72126 8.96532 7.52609L8.96534 7.52607Z" fill="#767676" class="color-fill"></path>
								<path d="M3.04367 5.47349L1.14924 7.36792C0.792589 7.72457 0.449306 8.07113 0.24744 8.54561C-0.126127 9.41043 -0.0654384 10.4468 0.472888 11.2342C1.00794 12.025 1.90971 12.5196 2.87205 12.4994C3.63595 12.4859 4.33246 12.1596 4.87079 11.6245L6.89982 9.5955C7.35072 9.1446 7.71076 8.61297 7.81171 7.97018C7.96311 7.0347 7.6737 6.06896 6.97048 5.4162C6.76862 5.22772 6.54316 5.06964 6.29413 4.94511C6.04849 4.82399 5.74898 4.88115 5.60429 5.12678C5.47308 5.34882 5.54033 5.69551 5.78596 5.81662C5.98782 5.91755 6.13934 6.01519 6.27724 6.14642C6.3378 6.20357 6.39507 6.26753 6.45222 6.33149C6.55315 6.44251 6.40845 6.25744 6.4926 6.38196C6.52957 6.43583 6.56325 6.48629 6.59693 6.54344C6.64399 6.62419 6.69117 6.70833 6.72485 6.79577C6.68448 6.69824 6.73835 6.83954 6.74163 6.84963C6.75513 6.89341 6.77191 6.93707 6.78201 6.98425C6.8056 7.07508 6.82578 7.16592 6.83916 7.25676C6.82238 7.14233 6.83916 7.29372 6.84256 7.30722C6.84597 7.36778 6.84925 7.43174 6.84925 7.4923C6.84925 7.53936 6.84585 7.58313 6.84256 7.63031C6.84256 7.64381 6.82238 7.7952 6.83916 7.68078C6.82566 7.77161 6.80548 7.86245 6.78201 7.95329C6.76851 7.99706 6.75513 8.04412 6.74163 8.0879C6.73823 8.09799 6.68448 8.23929 6.72485 8.14177C6.68108 8.2427 6.63061 8.34034 6.57006 8.43446C6.47582 8.58586 6.39507 8.67 6.24696 8.8214C5.5975 9.47086 4.95143 10.1169 4.30209 10.7663C4.23484 10.8335 4.17088 10.9009 4.10352 10.9648C4.05646 11.0119 4.00599 11.0557 3.95541 11.0995C3.84439 11.2004 4.02946 11.0557 3.90495 11.1398C3.86457 11.1667 3.82761 11.1937 3.78383 11.2206C3.70309 11.271 3.61894 11.3148 3.53479 11.3552C3.40018 11.4191 3.62223 11.3316 3.48093 11.3754C3.42037 11.3956 3.3631 11.4157 3.30254 11.4325C2.96935 11.5234 2.66996 11.5234 2.33677 11.4325C2.293 11.419 2.24594 11.4056 2.20216 11.3921C2.19207 11.3887 2.05077 11.335 2.14829 11.3754C2.06086 11.3384 1.97671 11.2946 1.89597 11.2474C1.8556 11.2239 1.81523 11.197 1.77486 11.1701C1.77145 11.1667 1.64694 11.0726 1.72099 11.1331C1.64365 11.0726 1.57288 11.0052 1.50223 10.9346C1.28019 10.7024 1.12866 10.4164 1.04794 10.0832C1.03784 10.0395 1.03115 9.9924 1.02106 9.94862C0.990783 9.80392 1.02106 10.0462 1.01437 9.89816C1.01097 9.80732 1.00428 9.71308 1.00768 9.62225C1.00768 9.57519 1.01437 9.53141 1.01437 9.48423C1.02106 9.33612 0.990782 9.57847 1.02106 9.43377C1.04125 9.32603 1.06483 9.22181 1.0984 9.11749C1.17245 8.88535 1.34403 8.60605 1.5426 8.40419L1.78154 8.16524C2.43771 7.50908 3.09387 6.85292 3.75003 6.19676C3.94179 6.00499 3.94179 5.67522 3.75003 5.48345C3.56519 5.27831 3.2388 5.27831 3.04363 5.47348L3.04367 5.47349Z" fill="#767676" class="color-fill"></path>
							</svg>
						</span>
					</a>
				</div>	
			</div>
		</div>

		<h1 class="text-align-center color__white text__headline-1 block-sm mt-3">{{{^ca_objects.preferred_labels}}}</h1>
		
		<div class="layout grid-flex">
			
			<div class="item color__white">
				<div id="carouselIndicators" class="carousel slide collection-carousel" data-bs-interval="false">
					<div class="carousel-inner">
						<?php
							$active = true;
							foreach($media as $m) {
						?>
								<div class="carousel-item <?= ($active ? 'active' : ''); ?>" style="height: auto;">
									<?= $m; ?>
								</div>
						<?php
								$active = false;
							}
						?>

						<?php
							if(count($media) == 0 ){
						?>
							<div class="d-flex align-items-center p-5" style="height: 400px;">
								<p>Digitized media for this item is not currently available, please email info@chicagofilmarchives.org to inquire.</p>
							</div>
						<?php
							}
						?>
					</div>
					<div class="carousel-indicators collection-indicators">
						<?php
							$active = true;
							$index = 0;
							foreach($media as $m) {
								if(count($media) > 1 ){
						?>
									<button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="<?= $index; ?>" class="<?= ($active ? 'active' : ''); ?>" <?= ($active ? 'aria-current="true"' : ''); ?> aria-label="Media <?= $index+ 1; ?>"></button>
						<?php
								}
								$index++;
								$active = false;
							}
						?>
					</div>

					<?php
						if(count($media) > 1 ){
					?>
							<button type="button" class="carousel-control-prev" data-bs-target="#carouselIndicators" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>
							</button>
							<button type="button" class="carousel-control-next" data-bs-target="#carouselIndicators" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>
							</button>
					<?php
						}
					?>

					{{{<ifdef code="ca_object_representations.caption">
						<div class="max__640 text__body-3 color__white block-sm text-center">^ca_object_representations.caption</div>
					</ifdef>}}}
				</div>   
			</div>

			<div class="item">
				<div class="container-scroll" style="overflow-y: auto;">
					<div class="content-scroll">
						<div class="size-column">

							<?php
								$metadata = array(
									"^ca_occurrences.cfaDateProduced" => "Date Of Production",
									"^ca_occurrences.cfaAbstract" => "Abstract",
									"^ca_occurrences.cfaDescription" => "Description",
									"^ca_objects.cfaRunTime" => "Run Time",	
									"^ca_objects.cfaAudioFormatHierachical" => "Format/Extent",
									"^ca_objects.idno" => "Identifier",
									"^ca_occurrences.cfaShotLog" => "Log",
									"^ca_occurrences.cfaLanguageMaterials" => "Language Of Materials",	
									"^ca_objects.cfaPublicObjectNotes" => "Notes",
									"^ca_objects.cfaYNTransferred" => "Transferred",	
								);
								foreach($metadata as $field => $fieldLabel){
							?>
									{{{<ifdef code="<?php print $field; ?>">
										<div class="max__640 text__eyebrow color__light_gray block-xxxs"><?php print $fieldLabel; ?></div>
										<div class="max__640 text__body-3 color__white block-sm"><?php print $field; ?></div>
									</ifdef>}}}
							<?php
								}

								$list_metadata = [
									"Genre" => [
										"relationshipType" => "genre"
									],
									"Form" => [
										"relationshipType" => "form"
									],
									"Subject" => [
										"relationshipType" => "subject"
									]
								];
								
								foreach($list_metadata as $fieldLabel => $field_info){
							?>
									{{{<unit relativeTo='ca_occurrences'>
										<ifcount code="ca_list_items" restrictToRelationshipTypes="<?= $field_info['relationshipType']; ?>" min="1">
											<div class="max__640 text__eyebrow color__light_gray block-xxxs"><?= $fieldLabel; ?></div>
											<div class="max__640 text__body-3 color__white block-sm">
												<unit relativeTo='ca_list_items' delimiter="<br>" restrictToRelationshipTypes='<?= $field_info['relationshipType']; ?>'>
													^ca_list_items.preferred_labels.name_plural
												</unit>
											</div>
										</ifcount>
									</unit>}}}
							<?php
								}
							?>

							{{{<ifcount code="ca_collections" min="1">
									<div class="max__640 text__eyebrow color__light_gray block-xxxs">Related Collections</div>
									<unit relativeTo="ca_collections"delimiter="">
										<div class="max__640 text__body-3 color__white">^ca_collections.preferred_labels</div>
									</unit>
								<br>
							</ifcount>}}}

							{{{<ifcount code="ca_occurrences" min="1">
								<unit relativeTo="ca_occurrences">
									<ifcount code="ca_places" min="1" >
										<div class="max__640 text__eyebrow color__light_gray block-xxxs">Related Places</div>
										<unit relativeTo="ca_places" delimiter="">
											<div class="max__640 text__body-3 color__white">^ca_places.preferred_labels</div>
										</unit>
										<br>
									</ifcount>
								</unit>
							</ifcount>}}}

							{{{<ifcount code="ca_occurrences" min="1">
								<unit relativeTo="ca_occurrences">
									<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="distributor">
										<div class="max__640 text__eyebrow color__light_gray block-xxxs">Distributor</div>
										<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="distributor">
											<div class="max__640 text__body-3 color__white">^ca_entities.preferred_labels.displayname</div>
										</unit>
										<br>
									</ifcount>
								</unit>
							</ifcount>}}}

							{{{<ifcount code="ca_occurrences" min="1">
								<unit relativeTo="ca_occurrences">
									<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="corporate">
										<div class="max__640 text__eyebrow color__light_gray block-xxxs">Sponsor/client</div>
										<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="corporate">
											<div class="max__640 text__body-3 color__white">^ca_entities.preferred_labels.displayname</div>
										</unit>
										<br>
									</ifcount>
								</unit>
							</ifcount>}}}

							{{{<ifcount code="ca_occurrences" min="1">
								<unit relativeTo="ca_occurrences">
									<ifcount code="ca_entities" min="1" 
										restrictToRelationshipTypes="director, producer, exec_producer, co_producer, production_co, filmmaker, videomaker">
										<div class="max__640 text__eyebrow color__light_gray block-xxxs">Main Credits</div>
										<unit relativeTo="ca_entities" delimiter="" 
											restrictToRelationshipTypes="director, producer, exec_producer, co_producer, production_co, filmmaker, videomaker">
											<div class="max__640 text__body-3 color__white">^ca_entities.preferred_labels.displayname</div>
										</unit>
										<br>
									</ifcount>
								</unit>
							</ifcount>}}}

							{{{<ifcount code="ca_occurrences" min="1">
								<unit relativeTo="ca_occurrences">
									<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="animator, writer, editor, composer, sound, music, translator, choreographer, lighting_director, casting, cinematographer, post_prod, contributor, scenic designer, costume designer, camera, asst_director, associate_director, prod_asst, wild_camera">
										<div class="max__640 text__eyebrow color__light_gray block-xxxs">Additional Credits</div>
										<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="animator, writer, editor, composer, sound, music, translator, choreographer, lighting_director, casting, cinematographer, post_prod, contributor, scenic designer, costume designer, camera, asst_director, associate_director, prod_asst, wild_camera">
											<div class="max__640 text__body-3 color__white">^ca_entities.preferred_labels.displayname</div>
										</unit>
										<br>
									</ifcount>
								</unit>
							</ifcount>}}}

							{{{<ifcount code="ca_occurrences" min="1">
								<unit relativeTo="ca_occurrences">
									<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="participant, performer, actor, narrator, commentator, interviewer, interviewee, musician, vocalist, announcer, panelist, host, moderator, reporter, performing_group">
										<div class="max__640 text__eyebrow color__light_gray block-xxxs">Participants And Performers</div>
										<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="participant, performer, actor, narrator, commentator, interviewer, interviewee, musician, vocalist, announcer, panelist, host, moderator, reporter, performing_group">
											<div class="max__640 text__body-3 color__white">^ca_entities.preferred_labels.displayname</div>
										</unit>
										<br>
									</ifcount>
								</unit>
							</ifcount>}}}

						</div>
					</div><!-- content-scroll -->
				</div><!-- container-scroll -->
			</div><!-- item -->
		</div><!-- layout -->
	</section>
	<section class="section-more-about-item">
		<div class="int wrap text-align-center">
		<div class="text__nav block-xxs">Do you know more about this item?</div>
		<div class="color__gray text__body-3">If you have more information about this item please contact us at <a href="mailto:info@chicagofilmarchives.com" class="color-link-inverted-orange">info@chicagofilmarchives.com</a>. </div>
		</div>
	</section>

	{{{<ifcount code="ca_objects.related" min="1">

		<section class="section-slideshow-related ">
			<div class="wrap"><div class="line"></div></div>
			<div class="int wrap-not-mobile">
				
			<h4 class="text-align-center text__headline-4 block-small ">Related Items</h4>
			<div class="slider-container module_slideshow slideshow-related manual-init slideshow-ctrl-init">
				<div class="slick-initialized slick-slider">
					<div class="slick-list draggable">
						<div class="slick-track" style="opacity: 1; width: 990px; transform: translate3d(0px, 0px, 0px); margin:0;">
							<div class="unit">
								<unit relativeTo="ca_objects.related" delimiter="">
									<div class="slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false">
										<div class="sizer" style="width: 100%; display: inline-block;">
											<div class="item-related item" style="max-width: 250px">
												<a href="" tabindex="0">
													<div class="related-items-img"><l>^ca_object_representations.media.medium<l></div>
												</a>
												<div class="text-align-center info">
													<div class="text__eyebrow color__gray block-xxxs"><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit></div>
													<div class="title text__promo-4"><l>^ca_objects.preferred_labels</l></div>
													<div class="text__eyebrow color__gray block-xxxs"><small>^ca_occurrences.cfaDateProduced<small></div>
												</div>
											</div>
										</div>
									</div>
								</unit>
							</div>
						</div>
					</div>
				</div>

				<div class="arrows">
				<div class="arrow arrow-left left reveal slick-arrow slick-hidden" style="visibility: visible;" aria-disabled="true" tabindex="-1">
					<svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g opacity="0.5" class="color-opacity">
						<circle cx="15.373" cy="15" r="14.5" transform="rotate(-180 15.373 15)" stroke="#222222" class="color-stroke"></circle>
						<g clip-path="url(#clip0_854_22844)">
						<path d="M16.0647 14.9999L18.459 18.9999L11.2866 14.9999L18.459 10.9999L16.0647 14.9999Z" fill="#222222" class="color-fill"></path>
						</g>
					</g>
					<defs>
						<clipPath id="clip0_854_22844">
						<rect width="7.17241" height="8" fill="white" transform="translate(18.459 18.9999) rotate(-180)"></rect>
						</clipPath>
					</defs>
					</svg>
				</div>
				<div class="arrow arrow-right right slick-arrow slick-hidden" style="visibility: visible;" aria-disabled="true" tabindex="-1">
					<svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g opacity="0.5" class="color-opacity">
						<circle cx="15.373" cy="15" r="14.5" stroke="#222222" class="color-stroke"></circle>
						<g clip-path="url(#clip0_854_22839)">
						<path d="M14.6813 15L12.2871 11L19.4595 15L12.2871 19L14.6813 15Z" fill="#222222" class="color-fill"></path>
						</g>
					</g>
					<defs>
						<clipPath id="clip0_854_22839">
						<rect width="7.17241" height="8" fill="white" transform="translate(12.2871 11)"></rect>
						</clipPath>
					</defs>
					</svg>
				</div>
				</div>
			</div>
			</div>
		</section>
	</ifcount>}}}

	</main>

</div><!-- end row -->

<script type='text/javascript'>
	function Copy() {
		var getUrl = document.createElement('input'),
		text = window.location.href;
		document.body.appendChild(getUrl);
		getUrl.value = text;
		getUrl.select();
		document.execCommand('copy');
		document.body.removeChild(getUrl);
		$.jGrowl("Link Copied!", { life: 2000 });
	}
</script>