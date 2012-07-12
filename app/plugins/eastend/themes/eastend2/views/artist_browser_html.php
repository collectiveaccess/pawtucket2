<?php
	$va_featured_artists = $this->getVar("featured_artists");
	print "<div id='contentBox' style='float:right; width:635px; border:2px solid #EDEDED; height:410px; margin-left:20px;'>";
	if(is_array($va_featured_artists) && (sizeof($va_featured_artists) > 0)){
		print "<div id='featuredArtistSlideShow'>";
		foreach($va_featured_artists as $vn_entity_id => $va_featured_artist){
			print "<div style='padding:5px;'><div style='float:left; width:400px; height:400px; border:0px; margin-right:25px; text-align:center;'>";
			print $va_featured_artist["image"];
			print "</div>";
			print "<div style='float:left; width:200px;'><h2 style='margin-top:10px;'>".$va_featured_artist["name"]."</H2>";
			print "<div>".$va_featured_artist["lifespan"]."</div>";
			print "<p>".$va_featured_artist["indexing_notes"]."</p>";
			print "<p style='text-align:right;'>".caNavLink($this->request, _t("More"), "", "Detail", "Entity", "Show", array("entity_id" => $vn_entity_id))." &rsaquo;</p>";
			print "</div></div>";
		}
		print "</div><!-- featuredArtistSlideShow -->";
	}
?>
	</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#featuredArtistSlideShow').cycle({
		fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		speed:  500,
		timeout: 4000
	});
});
</script>

<H1><?php print _t("Artists"); ?></H1>
<p><?php print _t("Since the 1870s, over 600 artists have lived, worked or vacationed on the East End of Long Island."); ?></p>
<?php
			$va_facets = $this->getVar('available_facets');
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
				<!--<div class="link"><a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a></div> -->
				<div>
					<a href="#" onclick='jQuery(".facetBoxes").html(""); jQuery("#facetBox<?php print $vs_facet_name; ?>").load("<?php print caNavUrl($this->request, 'eastend', 'ArtistBrowser', 'getFacet', array('target' => 'ca_entities', 'facet' => $vs_facet_name, 'view' => 'simple_list')); ?>"); return false;'><?php print $va_facet_info['label_singular']; ?></a>
					<div id="facetBox<?php print $vs_facet_name; ?>" class="facetBoxes"></div>
				</div>
<?php
			}
?>

<div style="clear:both;"><!-- empty --></div>