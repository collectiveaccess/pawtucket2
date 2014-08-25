	<div class="jcarousel-wrapper hpCarousel">
		<!-- Carousel -->
		<div class="jcarousel">
			<ul>
				<li><?php print caGetThemeGraphic($this->request, 'vertebrateSlideShow/vertSlide1.jpg'); ?></li>
				<li><?php print caGetThemeGraphic($this->request, 'vertebrateSlideShow/vertSlide2.jpg'); ?></li>
				<li><?php print caGetThemeGraphic($this->request, 'vertebrateSlideShow/vertSlide3.jpg'); ?></li>
				<li><?php print caGetThemeGraphic($this->request, 'vertebrateSlideShow/vertSlide4.jpg'); ?></li>
				<li><?php print caGetThemeGraphic($this->request, 'vertebrateSlideShow/vertSlide5.jpg'); ?></li>
				<li><?php print caGetThemeGraphic($this->request, 'vertebrateSlideShow/vertSlide6.jpg'); ?></li>
			</ul>
		</div><!-- end jcarousel -->
	</div><!-- end jcarousel-wrapper -->
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			/*
			Carousel initialization
			*/
			$('.jcarousel')
				.jcarousel({
					animation: {
						duration: 0 // make changing image immediately
					},
					wrap: 'circular'
				});
			$('.jcarousel').jcarouselAutoscroll({
				interval: 3000
			});

			// make fadeIn effect
			$('.jcarousel').on('jcarousel:animate', function (event, carousel) {
				$(carousel._element.context).find('li').hide().fadeIn(1000);
			});
		});
	</script>
<div class="hpText">
	<span class="hpIntroText">The Fossil Vertebrate Collection at the University of Colorado Museum of Natural History</span> is among the largest in the Western Interior. While it represents the culmination of several decades of collecting and spans most of the Phanerozoic Eon, the collection’s strengths are in mammals from the Cenozoic Era (66 Ma – present), and especially those that lived during the Paleogene Period (ca. 66 – 23 Ma).  The collection is both a federal- and state-recognized repository for fossils collected on BLM, USDA Forest Service, and state lands. We also maintain extensive teaching and cast collections.  
	<br/><br/>For inquiries regarding visits to the collection or specimen loans, please contact the paleontology collections manager Toni Culver (<a href="mailto:Toni.Culver@Colorado.edu">Toni.Culver@Colorado.edu</a>). 
	<p class="text-center">
		<?php print caNavLink($this->request, _t("Browse Fossil Verterates"), "btn btn-default", "", "Browse", "vertebrate"); ?>
	</p>
</div>



