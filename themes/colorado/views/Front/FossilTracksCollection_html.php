<?php	
	$t_object = new ca_objects();
	$va_featured_ids = array_keys($t_object->getRandomItems(10, array('checkAccess' => caGetUserAccessValues($this->request), 'hasRepresentations' => 1, 'restrictToTypes' => array("tracks", "track_item", "tracing", "cast"))));
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
	<span class="hpIntroText">The University of Colorado Fossil Tracks Collection</span> has considerable temporal, taxonomic, and geographic breadth, and includes about 3,000 specimens and 1600 trackway tracings.  The bulk of this collection was built by Professor Martin Lockley, who has spent more than three decades studying ancient footprints and built a world-class collection of these trace fossils at the University of Colorado Denver.  In 2012, the collection was transferred from the UC Denver Dinosaur Tracks Museum at the University of Colorado Denver to the University of Colorado Museum of Natural History in Boulder.
	<p class="text-center">
		<?php print caNavLink($this->request, _t("Browse Fossil Tracks"), "btn btn-default", "", "Browse", "tracks"); ?>
	</p>
</div>