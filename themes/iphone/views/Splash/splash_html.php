		<div id="hpFeatured">
			<?php print caNavLink($this->request, $this->getVar("featured_content_medium"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?>
		</div>
		<div id="featuredLabel">
				<?php print _t("Above: Detail from")." ".$this->getVar("featured_content_label"); ?>
		</div><!-- end featuredLabel -->
		<div id="hpSearch"><form name="splash_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get"><input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" autocomplete="off" size="20"/><a href="#" name="searchButtonSubmit" onclick="document.forms.splash_search.submit(); return false;"> <?php print _t("SEARCH"); ?></a></form></div>
		<div id="splashNav" class="listItems">
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div class="item" id="searchLink"><a href="#" onclick='$("#searchLink").hide(); $("#hpSearch").slideDown(250); return false;'>Search</a></div>
			<div class="item"><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "clearCriteria"); ?></div>
			<div class="item"><?php print caNavLink($this->request, _t("Gallery"), "", "simpleGallery", "Show", "Index"); ?></div>
			<div class="item"><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></div>
<?php
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print "<div class='item'>".caNavLink($this->request, _t("My Collections"), "", "", "Sets", "Index")."</div>";
					print "<div class='item'>".caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout")."</div>";
				}else{
					print "<div class='item'>".caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form")."</div>";
				}
			}
			
			global $g_ui_locale;
			# Locale selection
			if (is_array($va_ui_locales = $this->request->config->getList('ui_locales')) && (sizeof($va_ui_locales) > 1)) {
				foreach($va_ui_locales as $vs_locale) {
					if($g_ui_locale != $vs_locale){
						$va_parts = explode('_', $vs_locale);
						$vs_lang_name = Zend_Locale::getTranslation(strtolower($va_parts[0]), 'language', strtolower($va_parts[0]));
						print "<div class='item'>".caNavLink($this->request, $vs_lang_name, "", "", $this->request->getController(), $this->request->getAction(), array("lang" => $vs_locale))."</div>";
					}
				}
			
			}
?>
		</div>