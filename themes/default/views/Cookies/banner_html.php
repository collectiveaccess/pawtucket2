<?php
	if($this->request->getParameter("showCookieBanner", pString)){
?>
<div id="cookieNotice"  role="dialog" aria-labelledby="Cookie Window">
	<div class="row">
		<div class="col-sm-12 col-md-offset-3 col-md-6">
			<div class="cookieNoticeHeading">
				This website uses cookies
			</div>
			<div>
				We use cookies on our website to enhance your user experience, provide social media tools and to analyse our website traffic. You can update your preferences at any time, at the bottom of any page. Click <?php print caNavLink($this->request, _t("manage cookies"), "", "", "Cookies", "manage"); ?> to learn more.
			</div>
			<div class="text-center">
				<?php print caNavLink($this->request, _t("Manage"), "btn btn-default btn-inverse", "", "Cookies", "manage").caNavLink($this->request, _t("Accept"), "btn btn-default", "", "Cookies", "manage"); ?>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>