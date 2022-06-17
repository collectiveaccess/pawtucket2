<?php
	$t_section = $this->getVar("section");
	$vs_title = $this->getVar("section_title");
	$vs_text = $this->getVar("section_text");
	$vs_current_section = $this->getVar("current_section");
	$r_illustrations = $this->getVar("illustrations_as_search_result");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$vn_illustration_id = $this->request->getParameter("illustration", pInteger);
	
	$vs_image_display = $t_section->get("ca_occurrences.image_display", array("convertCodesToDisplayText" => true));
	if($vs_image_display == "List"){
		# --- display images in right side column
?>
		<div class="page_title">
			<h1><?php print $vs_title; ?></h1>
			<div class="ornament">
<?php
				$ornaments = array(
					'head_ornament-10.svg',
					'head_ornament-11.svg',
					'head_ornament-12.svg',
				);
				$rand_ornament = array_rand($ornaments, 1);
				print caGetThemeGraphic($this->request, $ornaments[$rand_ornament], array("class" => "page_title_ornament", "alt" => "Header Ornament"));
?>
			</div>

		</div>

		<div class="text_content with_images_column">
			<div class="text">
				<p><?php print $vs_text; ?></p>
			</div>
   			<div class="images">
<?php
				if($r_illustrations->numHits()){
					while($r_illustrations->nextHit()){
						print $r_illustrations->get("ca_object_representations.media.large");
					}
				}
?>
   			</div>
   		</div>
<?php	
	}elseif($vs_image_display == "Grid"){
?>
		<div class="page_title">
			<h1><?php print $vs_title; ?></h1>
			<div class="ornament">
<?php
				$ornaments = array(
					'head_ornament-10.svg',
					'head_ornament-11.svg',
					'head_ornament-12.svg',
				);
				$rand_ornament = array_rand($ornaments, 1);
				print caGetThemeGraphic($this->request, $ornaments[$rand_ornament], array("class" => "page_title_ornament", "alt" => "Header Ornament"));
?>
			</div>

		</div>

		<div class="text_content">
			<div class="text_2_col">
				<div class="text">
					<p><?php print $vs_text; ?></p>
				</div>
			</div>
   		
			
<?php
			$r_illustrations->filterNonPrimaryRepresentations(false);
			if($r_illustrations->numHits()){
				while($r_illustrations->nextHit()){
					print "<div class='columns'><a name='Row".$r_illustrations->get("ca_objects.object_id")."'></a>";
					#print "<div class='grid_column_4'>".$r_illustrations->get("ca_object_representations.media.large")."</div>";
					$va_rep_ids = $r_illustrations->get("ca_object_representations.representation_id", array("filterNonPrimaryRepresentations" => 0, "returnAsArray" => true));
					if(is_array($va_rep_ids)){
						foreach($va_rep_ids as $vn_rep_id){
							$t_rep = new ca_object_representations($vn_rep_id);
							$vs_rep = $t_rep->get("ca_object_representations.media.large");
							print "<div class='grid_column_4'><a href='#Row".$r_illustrations->get("ca_objects.object_id")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $r_illustrations->get("ca_objects.object_id"), 'representation_id' => $vn_rep_id, 'item_id' => $r_illustrations->get("ca_objects.object_id"), 'overlay' => 1))."\"); return false;' >".$vs_rep."</a></div>";
						}
					}
					#<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $vn_representation_id, 'item_id' => $vn_item_id, 'overlay' => 1))."\"); return false;' ></a>
					#print $r_illustrations->getWithTemplate("<unit relativeTo='ca_object_representations' delimiter=' ' filterNonPrimaryRepresentations='0'><div class='grid_column_4'>^ca_object_representations.media.large</div></unit>");
					print "</div>";
					print "<div class='caption_col_4'>".$r_illustrations->get("ca_objects.preferred_labels.name")."</div>";
					print "<div style='clear:both;'></div>";
				}
				
			}
?>
			</div>
   		</div>
<?php	
	}else{
?>
		<div class="page_title">
			<h1><?php print $vs_title; ?></h1>
		</div>

		<div class="text_content">

			<div class="columns">

				<div class="column left text">
					<p><?php print $vs_text; ?></p>
				</div>

				<div class="column right image_gallery">
					<div class="image_nav">
<?php
					print caNavLink($this->request, 'View Grid', '', '', 'Section', $vs_current_section, array("view" => "grid"));
?>
					</div>
					<div class="sidebar__inner">
<?php
					# ---------------------------------------------------------------
					### Slider 1 - shows images linked with relationship type depicts
					# ---------------------------------------------------------------
					$va_related_object_ids = $t_section->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("paratext_illustration"), "restrictToRelationshipTypes" => array("depicts")));
					if(is_array($va_related_object_ids) && sizeof($va_related_object_ids)){
?>
						<div class="slider slider_group1">
							<div class="swiper-container exhibition_swiper">
								<div class="swiper-wrapper">
<?php
										$r_illustrations_group1 = caMakeSearchResult('ca_objects', $va_related_object_ids);
																			
										$va_thumbs = array();
										if($r_illustrations_group1->numHits()){
											$i = 0;
											while($r_illustrations_group1->nextHit()){
												$vs_see_also = $r_illustrations_group1->getWithTemplate("<ifcount code='ca_objects.related' restrictToTypes='book' min='1'><br/><br/>More Information: <unit relativeTo='ca_objects.related' restrictToTypes='book' delimiter='<br/>'><a href='http://www.comediassueltasusa.org/collection/Detail/objects/^ca_objects.object_id' target='_blank'>^ca_objects.CCSSUSA_Uniform <i class='fa fa-external-link' aria-hidden='true'></i></a></unit></ifcount>");
												print "<div class='swiper-slide'><img data-src='".$r_illustrations_group1->get("ca_object_representations.media.large.url")."' class='swiper-lazy'><div class='caption'>".$r_illustrations_group1->get("ca_objects.preferred_labels.name").$vs_see_also."</div></div>";
												$va_thumbs[] = $r_illustrations_group1->get("ca_object_representations.media.large.url");
												if($vn_illustration_id == $r_illustrations_group1->get("ca_objects.object_id")){
													$vn_cue_to = $i;
												}
												$i++;
											}
										}
?>                         
								</div>
								<div class="swiper-button-next"><div class="arrow"></div></div>
								<div class="swiper-button-prev"><div class="arrow"></div></div>
							</div>
						</div>

						<div class="thumbnails thumbnails_group1">
<?php
							foreach($va_thumbs as $vs_thumb_url){
?>
								<div class="thumbnail thumbnail_group1" style="background: url('<?php print $vs_thumb_url; ?>') no-repeat center; background-size: cover;"></div>
<?php
							}
?>
						</div>
<?php
					}
?>
<?php
					# ---------------------------------------------------------------
					### Slider 1 - shows images linked with relationship type depicts_group2
					# ---------------------------------------------------------------
					$va_related_object_ids = $t_section->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("paratext_illustration"), "restrictToRelationshipTypes" => array("depicts_group2")));
					if(is_array($va_related_object_ids) && sizeof($va_related_object_ids)){
?>
						<div class="slider slider_group2">
							<div class="swiper-container exhibition_swiper_group2">
								<div class="swiper-wrapper">
<?php
										$r_illustrations_group2 = caMakeSearchResult('ca_objects', $va_related_object_ids);
																			
										$va_thumbs = array();
										if($r_illustrations_group2->numHits()){
											$i = 0;
											while($r_illustrations_group2->nextHit()){
												$vs_see_also = $r_illustrations_group2->getWithTemplate("<ifcount code='ca_objects.related' restrictToTypes='book' min='1'><br/><br/>More Information: <unit relativeTo='ca_objects.related' restrictToTypes='book' delimiter='<br/>'><a href='http://www.comediassueltasusa.org/collection/Detail/objects/^ca_objects.object_id' target='_blank'>^ca_objects.CCSSUSA_Uniform <i class='fa fa-external-link' aria-hidden='true'></i></a></unit></ifcount>");
												print "<div class='swiper-slide'><img data-src='".$r_illustrations_group2->get("ca_object_representations.media.large.url")."' class='swiper-lazy'><div class='caption'>".$r_illustrations_group2->get("ca_objects.preferred_labels.name").$vs_see_also."</div></div>";
												$va_thumbs[] = $r_illustrations_group2->get("ca_object_representations.media.large.url");
												if($vn_illustration_id == $r_illustrations_group2->get("ca_objects.object_id")){
													$vn_cue_to = $i;
												}
												$i++;
											}
										}
?>                         
								</div>
								<div class="swiper-button-next"><div class="arrow"></div></div>
								<div class="swiper-button-prev"><div class="arrow"></div></div>
							</div>
						</div>

						<div class="thumbnails thumbnails_group2">
<?php
							foreach($va_thumbs as $vs_thumb_url){
?>
								<div class="thumbnail thumbnail_group2" style="background: url('<?php print $vs_thumb_url; ?>') no-repeat center; background-size: cover;"></div>
<?php
							}
?>
						</div>
<?php
					}
?>
<?php
					# ---------------------------------------------------------------
					### Slider 1 - shows images linked with relationship type depicts_group3
					# ---------------------------------------------------------------
					$va_related_object_ids = $t_section->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("paratext_illustration"), "restrictToRelationshipTypes" => array("depicts_group3")));
					if(is_array($va_related_object_ids) && sizeof($va_related_object_ids)){
?>
						<div class="slider slider_group3">
							<div class="swiper-container exhibition_swiper_group3">
								<div class="swiper-wrapper">
<?php
										$r_illustrations_group3 = caMakeSearchResult('ca_objects', $va_related_object_ids);
																			
										$va_thumbs = array();
										if($r_illustrations_group3->numHits()){
											$i = 0;
											while($r_illustrations_group3->nextHit()){
												$vs_see_also = $r_illustrations_group3->getWithTemplate("<ifcount code='ca_objects.related' restrictToTypes='book' min='1'><br/><br/>More Information: <unit relativeTo='ca_objects.related' restrictToTypes='book' delimiter='<br/>'><a href='http://www.comediassueltasusa.org/collection/Detail/objects/^ca_objects.object_id' target='_blank'>^ca_objects.CCSSUSA_Uniform <i class='fa fa-external-link' aria-hidden='true'></i></a></unit></ifcount>");
												print "<div class='swiper-slide'><img data-src='".$r_illustrations_group3->get("ca_object_representations.media.large.url")."' class='swiper-lazy'><div class='caption'>".$r_illustrations_group3->get("ca_objects.preferred_labels.name").$vs_see_also."</div></div>";
												$va_thumbs[] = $r_illustrations_group3->get("ca_object_representations.media.large.url");
												if($vn_illustration_id == $r_illustrations_group3->get("ca_objects.object_id")){
													$vn_cue_to = $i;
												}
												$i++;
											}
										}
?>                         
								</div>
								<div class="swiper-button-next"><div class="arrow"></div></div>
								<div class="swiper-button-prev"><div class="arrow"></div></div>
							</div>
						</div>

						<div class="thumbnails thumbnails_group3">
<?php
							foreach($va_thumbs as $vs_thumb_url){
?>
								<div class="thumbnail thumbnail_group3" style="background: url('<?php print $vs_thumb_url; ?>') no-repeat center; background-size: cover;"></div>
<?php
							}
?>
						</div>
<?php
					}
?>
<?php
					# ---------------------------------------------------------------
					### Slider 1 - shows images linked with relationship type depicts_group4
					# ---------------------------------------------------------------
					$va_related_object_ids = $t_section->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("paratext_illustration"), "restrictToRelationshipTypes" => array("depicts_group4")));
					if(is_array($va_related_object_ids) && sizeof($va_related_object_ids)){
?>
						<div class="slider slider_group4">
							<div class="swiper-container exhibition_swiper_group4">
								<div class="swiper-wrapper">
<?php
										$r_illustrations_group4 = caMakeSearchResult('ca_objects', $va_related_object_ids);
																			
										$va_thumbs = array();
										if($r_illustrations_group4->numHits()){
											$i = 0;
											while($r_illustrations_group4->nextHit()){
												$vs_see_also = $r_illustrations_group4->getWithTemplate("<ifcount code='ca_objects.related' restrictToTypes='book' min='1'><br/><br/>More Information: <unit relativeTo='ca_objects.related' restrictToTypes='book' delimiter='<br/>'><a href='http://www.comediassueltasusa.org/collection/Detail/objects/^ca_objects.object_id' target='_blank'>^ca_objects.CCSSUSA_Uniform <i class='fa fa-external-link' aria-hidden='true'></i></a></unit></ifcount>");
												print "<div class='swiper-slide'><img data-src='".$r_illustrations_group4->get("ca_object_representations.media.large.url")."' class='swiper-lazy'><div class='caption'>".$r_illustrations_group4->get("ca_objects.preferred_labels.name").$vs_see_also."</div></div>";
												$va_thumbs[] = $r_illustrations_group4->get("ca_object_representations.media.large.url");
												if($vn_illustration_id == $r_illustrations_group4->get("ca_objects.object_id")){
													$vn_cue_to = $i;
												}
												$i++;
											}
										}
?>                         
								</div>
								<div class="swiper-button-next"><div class="arrow"></div></div>
								<div class="swiper-button-prev"><div class="arrow"></div></div>
							</div>
						</div>

						<div class="thumbnails thumbnails_group4">
<?php
							foreach($va_thumbs as $vs_thumb_url){
?>
								<div class="thumbnail thumbnail_group4" style="background: url('<?php print $vs_thumb_url; ?>') no-repeat center; background-size: cover;"></div>
<?php
							}
?>
						</div>
<?php
					}
?>
						
						
						

					</div>

				</div>

			</div>

		</div>

		<script type="text/javascript">
		/****************************************************
		**************** EXHIBITION SWIPER INIT *************
		****************************************************/
		jQuery ( document ).ready ( function($) {
			var options = {
				// Optional parameters
				slidesPerView: 1,
				//centeredSlides: true,
				spaceBetween: 0,
				// loop: true,
				// initialSlide: 0,

				// observer: true,
				// observeParents: true,

				preloadImages: false,
				lazy: true,
				lazy: {
					threshold: 50,
					loadPrevNext: true,
					loadPrevNextAmount: 2,
				},

				// autoplay: {
				//     delay: 5000,
				//     disableOnInteraction: true,
				// },

				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
		
			};
			// Inicio el slider con las opciones
			carousel = new Swiper ('.exhibition_swiper', options); 
		<?php
			if($vn_cue_to){
		?>    
			carousel.slideTo(<?php print $vn_cue_to; ?>, 0, false);
		<?php
			}
		?>
		});

		// position the swiper above the thumbnail clicked
		jQuery ( document ).ready ( function($) {

			$(".thumbnails_group1 .thumbnail_group1").click(function(event) {

				// calculate the index of the thumbnail that was clicked
				index = $('.thumbnail_group1').index( $(this) );

				// slide carousel to clicked iamge
				carousel.slideTo(index, 0, false);

				// calculate the index of the first element in the row clicked
				row_first = ( ( Math.floor(index/3) ) * 3 ) + 1;

				// move the carousel to the right position
				$(".slider_group1").insertBefore( $(".thumbnail_group1:eq("+ (row_first-1)+")") );

			});

		});






		/****************************************************
		**************** EXHIBITION SWIPER INIT GROUP 2*************
		****************************************************/
		jQuery ( document ).ready ( function($) {
			var options = {
				// Optional parameters
				slidesPerView: 1,
				//centeredSlides: true,
				spaceBetween: 0,
				// loop: true,
				// initialSlide: 0,

				// observer: true,
				// observeParents: true,

				preloadImages: false,
				lazy: true,
				lazy: {
					threshold: 50,
					loadPrevNext: true,
					loadPrevNextAmount: 2,
				},

				// autoplay: {
				//     delay: 5000,
				//     disableOnInteraction: true,
				// },

				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
		
			};
			// Inicio el slider con las opciones
			carousel_group2 = new Swiper ('.exhibition_swiper_group2', options); 
		<?php
			if($vn_cue_to){
		?>    
			carousel_group2.slideTo(<?php print $vn_cue_to; ?>, 0, false);
		<?php
			}
		?>
		});

		// position the swiper above the thumbnail clicked
		jQuery ( document ).ready ( function($) {

			$(".thumbnails_group2 .thumbnail_group2").click(function(event) {

				// calculate the index of the thumbnail that was clicked
				index = $('.thumbnail_group2').index( $(this) );

				// slide carousel to clicked iamge
				carousel_group2.slideTo(index, 0, false);

				// calculate the index of the first element in the row clicked
				row_first = ( ( Math.floor(index/3) ) * 3 ) + 1;

				// move the carousel to the right position
				$(".slider_group2").insertBefore( $(".thumbnail_group2:eq("+ (row_first-1)+")") );

			});

		});
		
		
		
		
		/****************************************************
		**************** EXHIBITION SWIPER INIT GROUP 3*************
		****************************************************/
		jQuery ( document ).ready ( function($) {
			var options = {
				// Optional parameters
				slidesPerView: 1,
				//centeredSlides: true,
				spaceBetween: 0,
				// loop: true,
				// initialSlide: 0,

				// observer: true,
				// observeParents: true,

				preloadImages: false,
				lazy: true,
				lazy: {
					threshold: 50,
					loadPrevNext: true,
					loadPrevNextAmount: 2,
				},

				// autoplay: {
				//     delay: 5000,
				//     disableOnInteraction: true,
				// },

				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
		
			};
			// Inicio el slider con las opciones
			carousel_group3 = new Swiper ('.exhibition_swiper_group3', options); 
		<?php
			if($vn_cue_to){
		?>    
			carousel_group3.slideTo(<?php print $vn_cue_to; ?>, 0, false);
		<?php
			}
		?>
		});

		// position the swiper above the thumbnail clicked
		jQuery ( document ).ready ( function($) {

			$(".thumbnails_group3 .thumbnail_group3").click(function(event) {

				// calculate the index of the thumbnail that was clicked
				index = $('.thumbnail_group3').index( $(this) );

				// slide carousel to clicked iamge
				carousel_group3.slideTo(index, 0, false);

				// calculate the index of the first element in the row clicked
				row_first = ( ( Math.floor(index/3) ) * 3 ) + 1;

				// move the carousel to the right position
				$(".slider_group3").insertBefore( $(".thumbnail_group3:eq("+ (row_first-1)+")") );

			});

		});

		
		
		
		
		/****************************************************
		**************** EXHIBITION SWIPER INIT GROUP 4*************
		****************************************************/
		jQuery ( document ).ready ( function($) {
			var options = {
				// Optional parameters
				slidesPerView: 1,
				//centeredSlides: true,
				spaceBetween: 0,
				// loop: true,
				// initialSlide: 0,

				// observer: true,
				// observeParents: true,

				preloadImages: false,
				lazy: true,
				lazy: {
					threshold: 50,
					loadPrevNext: true,
					loadPrevNextAmount: 2,
				},

				// autoplay: {
				//     delay: 5000,
				//     disableOnInteraction: true,
				// },

				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
		
			};
			// Inicio el slider con las opciones
			carousel_group4 = new Swiper ('.exhibition_swiper_group4', options); 
		<?php
			if($vn_cue_to){
		?>    
			carousel_group4.slideTo(<?php print $vn_cue_to; ?>, 0, false);
		<?php
			}
		?>
		});

		// position the swiper above the thumbnail clicked
		jQuery ( document ).ready ( function($) {

			$(".thumbnails_group4 .thumbnail_group4").click(function(event) {

				// calculate the index of the thumbnail that was clicked
				index = $('.thumbnail_group4').index( $(this) );

				// slide carousel to clicked iamge
				carousel_group4.slideTo(index, 0, false);

				// calculate the index of the first element in the row clicked
				row_first = ( ( Math.floor(index/3) ) * 3 ) + 1;

				// move the carousel to the right position
				$(".slider_group4").insertBefore( $(".thumbnail_group4:eq("+ (row_first-1)+")") );

			});

		});

		</script>
<?php
	}
?>