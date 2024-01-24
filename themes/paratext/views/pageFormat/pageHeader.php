<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
 #caGetThemeGraphic($this->request, 'ca_nav_logo300.png', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner"))
 
	# --- navigation --- idno => Title
	$va_paratext_intro_sections = $this->request->config->get("paratext_intro_sections");
	$va_paratext_exhibition_sections = $this->request->config->get("paratext_exhibition_sections");
	
	
	switch(strToLower($this->request->getController())){
		case "front":
			$body_class = "home";
		break;
		# ----------------------
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
<?php
	if(Debug::isEnabled()) {		
		//
		// Pull in JS and CSS for debug bar
		// 
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
</head>
<body class="<?php print $body_class; ?>">
<a href="#" name="top" class="topLinkAnchor"></a>
    
    <div id="site_bg">
        <div class="img_overlay" style="background: url(<?php print caGetThemeGraphicUrl($this->request, 'page_bg.jpg'); ?>) no-repeat center; background-size: cover;"></div>
    </div>
    <header>

        <!-- SEARCH ICON -->
        <?php print caGetThemeGraphic($this->request, 'search.svg', array("alt" => "Search icon", "class" => "search_icon open_search")); ?>
        <!-- MENU CONTAINER -->
        <div class="width">
            <?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'paratext_logo_full.svg', array("alt" => "Paratext Logo", "class" => "logo_full", "role" => "banner")), "", "", "", ""); ?>
            <?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'paratext_logo_short.svg', array("alt" => "Paratext Logo (small)", "class" => "logo_short", "role" => "banner")), "", "", "", ""); ?>
            <ul class="main_menu">
<?php
				foreach($va_paratext_intro_sections as $vs_idno => $vs_section_title){
					print "<li class='menu_item'>".caNavLink($this->request, $vs_section_title, '', '', 'Section', $vs_idno)."</li> ";
				}
?>               
                <li class="menu_item"><?php print caNavLink($this->request, _t("Exhibition"), "", "", "Section", "Exhibition"); ?></li> 
				<li class="menu_item"><?php print caNavLink($this->request, _t("Printers' addresses"), "", "", "Printers", "Index"); ?></li> 
                <li class="menu_item"><?php print caNavLink($this->request, _t("Gallery"), "", "", "ImageGallery", "Index"); ?></li> 
            </ul>
        </div>

        <!-- FONT SIZE -->
        <div class="font_size">
            <div class="font normal active">A</div>
            <div class="font big">A</div>
        </div>

        <!-- BURGER MENU START -->
        <div id="" class="burger">
            <span class=""></span>
            <span class=""></span>
            <span class=""></span>
            <span class=""></span>
        </div>

    </header>

    <div class="search_overlay">
        <div class="close"></div>
        <div class="img_overlay" style="background: url(<?php print caGetThemeGraphic($this->request, 'page_bg.jpg'); ?>) no-repeat center; background-size: cover;"></div>
        <div class="positioner">
            <?php print caGetThemeGraphic($this->request, 'search_brown.svg', array("alt" => "Search icon", "class" => "search_icon")); ?>
            <form id="search"  role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="Search">
                <div class="search_block">
                    <input type="text" name="search" placeholder="What would you like to searh for?">
                    <input type="submit" value="search"></input>
                </div>
            </form>
        </div>
    </div>
