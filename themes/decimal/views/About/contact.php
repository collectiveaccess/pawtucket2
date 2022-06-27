<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

<div class="row contact">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="pull-right detailTool generalToolSocial">
			<a href='https://twitter.com/home?status=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'About', 'contact'); ?>'><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
			<a href='https://www.facebook.com/sharer/sharer.php?u=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'About', 'contact'); ?>'><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
			<a href='https://plus.google.com/share?url=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'About', 'contact'); ?>'><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
		</div><!-- end detailTool -->
		<H1 ><?php print _t("Contact"); ?></H1>
		<p>The Fabric of Digital Life Archive is a continually evolving resource that is both publicly available and influenced by its audience. If you would like to contribute materials that you feel could benefit our archive, please feel free to contact us at <a href='mailto:decimal.lab.uoit@gmail.com'>decimal.lab.uoit@gmail.com</a></p>
		<p>We look forward to your submissions.</p>
		</div>
	<div class="col-sm-1"></div>
</div>