<?php
	$va_featured_artists = $this->getVar("featured_artists");
	
	if(is_array($va_featured_artists) && (sizeof($va_featured_artists) > 0)){
		print "<div id='featuredArtistSlideShow'>";
		foreach($va_featured_artists as $vn_entity_id => $va_featured_artist){
			print "<div class='ab_feature".(($va_featured_artist["vaga_class"] ? " ".$va_featured_artist["vaga_class"] : ""))."'>";
			print "<div class='ab_feature_img'>".caNavLink($this->request, $va_featured_artist["image"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_entity_id))."</div>";
			print "<p><span class='caption caps'>".caNavLink($this->request, $va_featured_artist["name"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_entity_id))." ".$va_featured_artist["lifespan"]."</span><br />";
			print "<span class='captionSmall'>".$va_featured_artist["indexing_notes"]."</span>";
			if($va_featured_artist["caption"]){
				print "<br/><br/><span class='captionSmall obl'>";
				if($va_featured_artist["vaga_class"]){
					print "<a href='http://www.vagarights.com' target='_blank'>";
					$vn_vaga_disclaimer_output = 1;
				}
				print $va_featured_artist["caption"];
				if($va_featured_artist["vaga_class"]){
					print "</a>";
				}
				print "</span>";
			}
			print "<br /></p></div><!--end ab_feature-->";
		}
		print "</div><!-- featuredArtistSlideShow -->";
	}
	if($vn_vaga_disclaimer_output){
		TooltipManager::add(
			".vagaDisclaimer", "<div style='width:250px;'>Reproduction of this image, including downloading, is prohibited without written authorization from VAGA, 350 Fifth Avenue, Suite 2820, New York, NY 10118. Tel: 212-736-6666; Fax: 212-736-6767; e-mail:info@vagarights.com; web: <a href='www.vagarights.com' target='_blank'>www.vagarights.com</a></div>"
		);
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