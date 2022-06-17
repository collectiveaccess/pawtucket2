<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>
<H1><?php print _t("About"); ?></H1>
<div class="row">
	<div class="col-sm-8">
		<p>AHL Foundation’s Archive of Korean Artists in America (AKAA) was established in 2013 and has collected and preserved crucial archival materials of over 150 artists of Korean heritage working in the United States. AKAA is a multi-year project to archive the achievements and contributions made by Korean or Korean-American Artists to the cultural landscape of America and the world at large. Launching AKAA’s digital archive in 2017, it aims to build and facilitate greater access to a rich collection of material about Korean or Korean-American Artists by curators, researchers, collectors, and the general public. </p>
		<p>AHL Foundation is a non-profit organization founded in 2003 and is dedicated to supporting Korean artists working in the United States and to promoting their work within the contemporary art world.</p>
	</div>
	<div class="col-sm-3 col-sm-offset-1">
<?php
		print "<div>".caGetThemeGraphic($this->request, 'AHL_LOGO.png')."</div>";
?>	
		<h6>&nbsp;</h6><address><b>AHL Foundation</b><br>			420 West 23rd Street, Suite 7A<br>			New York, New York 10011</address>
		
		<address><span class="info">Tel:</span> 212.675.1619<br><span class="info">Email:</span> <a href="mailto:archive@ahlfoundation.org">archive@ahlfoundation.org</a></address>
		<div>
			<b>Office Hours</b><br/>
			Tuesday – Thursday: 10am – 5pm and by appointment<br/>
		</div>
	</div>
</div>