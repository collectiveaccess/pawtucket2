<?php
	$t_section = $this->getVar("section");
	$vs_title = $this->getVar("section_title");
	$vs_text = $this->getVar("section_text");
	$vs_current_section = $this->getVar("current_section");
	$r_illustrations = $this->getVar("illustrations_as_search_result");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$vn_illustration_id = $this->request->getParameter("illustration", pInteger);
	
	$va_paratext_exhibition_sections = $this->request->config->get("paratext_exhibition_sections");	
	$vn_case = 0;
	if(in_array($vs_current_section, $va_paratext_exhibition_sections)){
		foreach($va_paratext_exhibition_sections as $vs_idno){
			$vn_case++;
			if($vs_idno == $vs_current_section){
				break;
			}
	
		}
	}
	
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
<?php
				if($vn_case){
?>
					<H2 class="exhibitH2">Exhibit Case <?php print $vn_case; ?></H2>
<?php
				}
?>					
					<div>
						<p><?php print $vs_text; ?></p>
					</div>
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



		<div class="text_content individual_columns">
			<div class="columns">
				<div class="column left text">
<?php
				if($vn_case){
?>
					<H2>Exhibit Case <?php print $vn_case; ?></H2>
<?php
				}
?>					<div class="scroll">
						<p><?php print $vs_text; ?></p>
					</div>
				</div>
		
				<div class="column right image_gallery">


<?php
				if($vn_case){
?>

					<H2>
<?php
					print caNavLink($this->request, 'View Examples in Grid Layout', '', '', 'Section', $vs_current_section, array("view" => "grid"));
?>
					</H2>
<?php
				}
?>
					<div class="scroll">
					<div class="sidebar__inner">
<?php
					# ---------------------------------------------------------------
					### Loop through and output 10 sliders if necessary
					# ---------------------------------------------------------------
					$va_groups_output = array();
					$group = 1;
					while($group < 11){
						$rel_type = "depicts";
						if($group > 1){
							$rel_type = "depicts_group".$group;
						}
						$va_related_object_ids = $t_section->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("paratext_illustration"), "restrictToRelationshipTypes" => array($rel_type)));
						if(is_array($va_related_object_ids) && sizeof($va_related_object_ids)){
							$va_groups_output[] = $group;
	?>
							<div class="slider slider_group<?php print $group; ?>">
								<div class="swiper-container exhibition_swiper_group<?php print $group; ?>">
									<div class="swiper-wrapper">
	<?php
											$r_illustrations = caMakeSearchResult('ca_objects', $va_related_object_ids);
																			
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

							<div class="thumbnails thumbnails_group<?php print $group; ?>">
	<?php
								foreach($va_thumbs as $vs_thumb_url){
	?>
									<div class="thumbnail thumbnail_group<?php print $group; ?>" style="background: url('<?php print $vs_thumb_url; ?>') no-repeat center; background-size: cover;"></div>
	<?php
								}
	?>
							</div>
							
	<script type="text/javascript">
		/****************************************************
		**************** EXHIBITION SWIPER INIT loop through all groups that were output above *************
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
			carousel_group<?php print $group; ?> = new Swiper ('.exhibition_swiper_group<?php print $group; ?>', options); 
		<?php
			if($vn_cue_to){
		?>    
			carousel_group<?php print $group; ?>.slideTo(<?php print $vn_cue_to; ?>, 0, false);
		<?php
			}
		?>
		});

		// position the swiper above the thumbnail clicked
		jQuery ( document ).ready ( function($) {

			$(".thumbnails_group<?php print $group; ?> .thumbnail_group<?php print $group; ?>").click(function(event) {

				// calculate the index of the thumbnail that was clicked
				index = $('.thumbnail_group<?php print $group; ?>').index( $(this) );

				// slide carousel to clicked iamge
				carousel_group<?php print $group; ?>.slideTo(index, 0, false);

				// calculate the index of the first element in the row clicked
				row_first = ( ( Math.floor(index/3) ) * 3 ) + 1;

				// move the carousel to the right position
				$(".slider_group<?php print $group; ?>").insertBefore( $(".thumbnail_group<?php print $group; ?>:eq("+ (row_first-1)+")") );

			});

		});

	</script>
<?php
						}
						$group++;
					}
?>
						
						
						

						</div>
					</div>

				</div>

			</div>

		</div>

<?php
	}
?>