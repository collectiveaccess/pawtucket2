<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="pull-right detailTool generalToolSocial">
			<a href='https://twitter.com/home?status=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'About', 'Index'); ?>'><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
			<a href='https://www.facebook.com/sharer/sharer.php?u=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'About', 'Index'); ?>'><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
			<a href='https://plus.google.com/share?url=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'About', 'Index'); ?>'><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
		</div><!-- end detailTool -->
		<H1><?php print _t("About"); ?></H1>
		
		<p>Fabric of Digital Life or 'Fabric' is a research database and archive created by Dr. Isabel Pedersen and members of Decimal Lab at the University of Ontario Institute of Technology in Canada. Fabric uses digital humanities, digital rhetoric, and popular culture theories and methodologies to inspire its collection.  Through a customized metadata scheme, international researchers and curators collect and catalogue digital artifacts surrounding the emergence of very personal technologies that promise to alter everyday life.</p>

<p>Fabric of Digital Life Archive is inspired by a famous prediction made by Chief Scientist at Xerox Parc, Mark Weiser, in 1991: “The most profound technologies are those that disappear. They weave themselves into the fabric of everyday life until they are indistinguishable from it”. We are beginning to see a critical mass of early inventions working toward this end and one goal for Fabric is to reflect this phenomenon.</p>

<p>Since 2013, Fabric of Digital Life has provided a means to track the emergence of platforms of human-computer interaction (HCI), also called personal technologies, through the language of invention: inventors’ concepts, entrepreneurial adventures, science fiction films, art, events, military innovation, video games, government ambitions, patents, news broadcasts, blogs, and advertising.</p>

<p>Fabric lets you explore the nature of emergence, the discourses that surround it, the ways we participate with it, and the rhetoric that helps engender it.</p>

<p>Use the Browse menu to explore items. Or, click on curated collections or HCI platforms on the right-hand menu. Search provides full-text search access to the corpus. </p>
		
		<p><b><a href="#" class='copyright' onclick="$('#copyright').toggle(300);return false;">Statement on Copyright</a></b></p>
		<div id="copyright" style="display:none;">
			<p>The Fabric of Digital Life hosts digital materials for private study, academic research, and education in Canada, and makes all attempts to satisfy Canadian copyright law. If you are a copyright holder and believe the Fabric of Digital Life is hosting infringing material, please contact us to have the item(s) removed from this website.</p>
			<p>In Canada, fair dealing exceptions are part of the <a href="http://laws-lois.justice.gc.ca/eng/acts/c-42/" target="_blank">Canadian Copyright Act</a>. The Act explicitly permits exceptions for “the purpose of research, private study, education, parody or satire” (§29). Determination of the thresholds for fair dealings exceptions were clarified by the Supreme Court in CCH Canadian Ltd v Law Society of Upper Canada. In this case, the Court established six principal criteria to determine fairness: 1) The purpose of the dealing; 2) The character of the dealing; 3) The amount of the dealing; 4) Alternatives to the dealing; 5) The nature of the work; 6) The effect of the dealing on the work. The Fabric of Digital Life has a tiered access system in order to limit the purposes, conditions, and amount of materials accessible, and to minimize the effect of accessing such materials. If you are an academic researcher or individual conducting private study, please sign up for the Fabric of Digital Life to access the full content of the archive.</p>		
		</div>
	</div>
	<div class="col-sm-1"></div>
<?php
		print $this->render("Front/sidebar.php");
?>
</div>