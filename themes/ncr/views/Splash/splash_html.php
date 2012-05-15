<?php
	JavascriptLoadManager::register("cycle");
?>
		<div id="hpFeatured">
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_2.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_3.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_5.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_1.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_7.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_6.jpg" width="500" height="625" border="0"></div>
		</div>
		<div id="hpText">			
			<i>The Isamu Noguchi Catalogue Raisonn&eacute;</i> is an ongoing project of The Isamu Noguchi Foundation and Garden Museum, New York, dedicated to documenting the complete oeuvre of Isamu Noguchi (1904&ndash;1988). 
			<br/><br/>Presented on this website, <i>The Isamu Noguchi Catalogue Raisonn&eacute;</i> includes complete and accurate information on Noguchi's sculptures, drawings, models, architectural spaces, stage sets, and manufactured designs. A chronology, bibliography, and exhibition history are also provided. All information is presented in a chronological and cross-referenced format to best showcase the interdisciplinary nature of Noguchi's life and work. 
			<br/><br/>This website will develop incrementally as research is completed, eventually providing a fully comprehensive document of Noguchi's career. Additional entries will be published here on an annual basis as new research is finalized.
			<br/><br/><?php print caNavLink($this->request, "Learn more &rsaquo;", "", "", "About", "Intro"); ?>
		</div><!-- end hpText -->
<script type="text/javascript">
$(document).ready(function() {
    $('#hpFeatured').cycle({
		fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		speed:  1000,
		timeout: 4000
	});
});
</script>
		

			
		