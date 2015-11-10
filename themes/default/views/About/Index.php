<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>
<H1><?php print _t("About"); ?></H1>
<div class="row">
	<div class="col-sm-8">
		<h6>Your archive information goes here</h6>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non leo id odio congue tempor laoreet vitae justo. Nulla arcu nisl, cursus ac pharetra id, aliquam vel est. Pellentesque nec augue ac nibh sagittis dapibus. Sed id tempor tellus, lobortis pretium nunc. Proin sed odio a nulla gravida euismod sit amet nec urna. Cras at arcu eget nibh aliquet vestibulum sed nec sem. Nulla facilisi. Donec rhoncus dolor et dui hendrerit, sit amet sollicitudin est posuere.</p></p>
	</div>
	<div class="col-sm-3 col-sm-offset-1">
		<h6>Your contact info goes here</h6>
		<address>Ted Taylor, Archivist<br/>
		<span class="info">Phone</span> — 212 555.1111<br>			
		<span class="info">Email</span> — ted@nodomain.org
	</div>
</div>