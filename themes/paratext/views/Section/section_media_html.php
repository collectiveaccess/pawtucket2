<?php
	$t_section = $this->getVar("section");
	$vs_title = $this->getVar("section_title");
	$vs_text = $this->getVar("section_text");
	$vs_current_section = $this->getVar("current_section");
	$r_illustrations = $this->getVar("illustrations_as_search_result");
	
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

						<div class="slider">
							<div class="swiper-container exhibition_swiper">
								<div class="swiper-wrapper">
<?php
									$va_thumbs = array();
									if($r_illustrations->numHits()){
										$i = 0;
										while($r_illustrations->nextHit()){
											$vs_see_also = $r_illustrations->getWithTemplate("<ifcount code='ca_objects.related' restrictToTypes='book' min='1'><br/><br/>More Information: <unit relativeTo='ca_objects.related' restrictToTypes='book' delimiter='<br/>'><a href='http://www.comediassueltasusa.org/collection/Detail/objects/^ca_objects.object_id' target='_blank'>^ca_objects.CCSSUSA_Uniform <i class='fa fa-external-link' aria-hidden='true'></i></a></unit></ifcount>");
											print "<div class='swiper-slide'><img data-src='".$r_illustrations->get("ca_object_representations.media.large.url")."' class='swiper-lazy'><div class='caption'>".$r_illustrations->get("ca_objects.preferred_labels.name").$vs_see_also."</div></div>";
											$va_thumbs[] = $r_illustrations->get("ca_object_representations.media.large.url");
											if($vn_illustration_id == $r_illustrations->get("ca_objects.object_id")){
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

						<div class="thumbnails">
<?php
							foreach($va_thumbs as $vs_thumb_url){
?>
								<div class="thumbnail" style="background: url('<?php print $vs_thumb_url; ?>') no-repeat center; background-size: cover;"></div>
<?php
							}
?>
						</div>

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

			$(".thumbnails .thumbnail").click(function(event) {

				// calculate the index of the thumbnail that was clicked
				index = $('.thumbnail').index( $(this) );

				// slide carousel to clicked iamge
				carousel.slideTo(index, 0, false);

				// calculate the index of the first element in the row clicked
				row_first = ( ( Math.floor(index/3) ) * 3 ) + 1;

				// move the carousel to the right position
				$(".slider").insertBefore( $(".thumbnail:eq("+ (row_first-1)+")") );

			});

		});


		</script>
<?php
	}
?>