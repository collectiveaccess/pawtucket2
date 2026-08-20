<?php
	global $g_ui_locale;
	if($g_ui_locale == "de_DE"){
		$vs_lang = "_de";
	}else{
		$vs_lang = "_en";
	}
	//if($this->request->getParameter("showCookieBanner", pString)){
	if(CookieOptionsManager::showBanner()) {
		$config = caGetCookiesConfig();
		$text = "";
		if(!($config->get("cookiesBannerGlobalValue") && $text = $this->getVar($config->get("cookiesBannerGlobalValue").$vs_lang))){
			$text = $config->get("cookiesBannerText");
		}
?>
<div id="cookieNotice" role="dialog" aria-labelledby="Cookie Window">
	<div class="row">
		<div class="col-sm-12 col-md-offset-3 col-md-6">
			<div class="cookieNoticeHeading">
				<?= 'This website uses cookies'; ?>
			</div>
			<div>
				<?= $text; ?>
			</div>
			<div class="text-center">
				<?php print caNavLink($this->request, "Manage", "btn btn-default btn-inverse", "", "Cookies", "manage").caNavLink($this->request, "Accept", "btn btn-default", "", "Cookies", "manage", ['accept' => 1]); ?>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
