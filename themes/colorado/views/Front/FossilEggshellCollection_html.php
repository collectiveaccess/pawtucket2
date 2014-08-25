<?php	
	$t_object = new ca_objects();
	$va_featured_ids = array_keys($t_object->getRandomItems(10, array('checkAccess' => caGetUserAccessValues($this->request), 'hasRepresentations' => 1, 'restrictToTypes' => array("eggshell", "fossil", "recent", "pseudo", "associated"))));
	if(sizeof($va_featured_ids)){
		$q_featured_items = caMakeSearchResult('ca_objects', $va_featured_ids);
		if($q_featured_items->numHits()){
?>
			<div class="jcarousel-wrapper hpCarousel">
				<!-- Carousel -->
				<div class="jcarousel">
					<ul>
<?php
						while($q_featured_items->nextHit()){
							if($vs_media = $q_featured_items->getWithTemplate('<l>^ca_object_representations.media.mediumlarge</l>', array("checkAccess" => caGetUserAccessValues($this->request)))){
								print "<li>".$vs_media."</li>";
							}
						}
?>
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
<?php
		}
	}
?>

<div class="hpText">
	<div class="hpIntroText">The University of Colorado Museum of Natural History is home to the Karl Hirsh Eggshell Collection, one of the world’s finest collections of fossil eggshells.</div>
	Museum researcher Karl Hirsh spent decades collecting fossil and modern amniote eggshell through extensive fieldwork, donations, and collaborations with other researchers, amassing what is now known as the Hirsch Eggshell Collection. This large and diverse eggshell collection was acquired by the Paleontology Section of the University of Colorado Museum of Natural History after his death in 1996, and continues to be utilized by eggshell researchers today. <br><br>	
	<p class="text-center">
		<?php print caNavLink($this->request, _t("Browse Fossil Eggshells"), "btn btn-default", "", "Browse", "eggshell"); ?>
	</p>
</div>