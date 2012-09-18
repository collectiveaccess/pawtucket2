<?php
	$va_featured_artists = $this->getVar("featured_artists");
	
	if(is_array($va_featured_artists) && (sizeof($va_featured_artists) > 0)){
		print "<div id='featuredArtistSlideShow'>";
		foreach($va_featured_artists as $vn_entity_id => $va_featured_artist){
			print "<div class='ab_feature'>";
			print "<div class='ab_feature_img'>".caNavLink($this->request, $va_featured_artist["image"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_entity_id))."</div>";
			print "<p><span class='caption caps'>".caNavLink($this->request, $va_featured_artist["name"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_entity_id))." ".$va_featured_artist["lifespan"]."</span><br />";
			print "<span class='caption obl'>".$va_featured_artist["indexing_notes"]."</span>";
			print "<br /></p></div><!--end ab_feature-->";
		}
		print "</div><!-- featuredArtistSlideShow -->";
	}
?>



<script type="text/javascript">
$(document).ready(function() {
    $('#featuredArtistSlideShow').cycle({
		fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		speed:  500,
		timeout: 8000
	});
});
</script>