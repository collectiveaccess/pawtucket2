<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="no-js">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	<!--Old css: GET RID OF AS SOON AS POSSIBLE-->
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/reset.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/styles.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/utils.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	
	<!--[if IE 7]><link rel="stylesheet" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/ie7.css" /><![endif]-->
	<!--[if IE 8]><link rel="stylesheet" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/ie8.css" /><![endif]-->
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-tileviewer/jquery.tileviewer.css" type="text/css" media="screen" />
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<!--Fonts-->
	<script src="<?php print $this->request->getThemeUrlPath(); ?>/js/libs/cufon-yui.js"></script>
	<script src="<?php print $this->request->getThemeUrlPath(); ?>/js/fonts/Helvetica_Neue_LT_Std_900.font.js"></script>
	<!--END Fonts-->
	
	<script src="<?php print $this->request->getThemeUrlPath(); ?>/js/scripts.js"></script>
	
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 2, limitPerCategory: 3});
			POP.runCufon();
			var showMore = new POP.showMore('.related-objects');
			var toggleInputText = new POP.ToggleInputText('#quickSearch');
		});
		
	</script>
</head>
<body>
		<div id="pageArea">
			<div id="header" <?php print ($this->request->getController() == "Splash") ? 'class="page-home"' : ''; ?>>
				<div class="header-top">
					<a href="http://www.roundabouttheatre.org" class="roundabout-link">Visit www.roundabouttheatre.org for show tickets and information</a>
				</div>
				<a href="<?php print caNavUrl($this->request, '', 'Splash', 'Index'); ?>" class="header-logo ir">Roundabout Theatre Archive Home</a>
				<?php
					// get last search ('basic_search' is the find type used by the SearchController)
					$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
					$vs_search = $o_result_context->getSearchExpression();
				?>
					<div id="nav">
						<div id="search">
							<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
								<a href="#" class="ir" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><?php print _t("Search"); ?></a>
								<input type="text" name="search" placeholder="Search Archive" onclick='jQuery("#quickSearch").select();' id="quickSearch" autocomplete="off" />
							</form>
						</div>

						<ul>
							<li class='first<?php print ($this->request->getController() == "Splash") ? " nav-on" : ""; ?>'><?php print caNavLink($this->request, "<span class='ir'>Home</span><span class='rollover'></span>", "", "", "", ""); ?></li>
							<li class='second<?php print ($this->request->getController() == "Browse") ? " nav-on" : ""; ?>'><?php print caNavLink($this->request, "<span class='ir'>Browse</span><span class='rollover'></span>", "", "", "Browse", "clearCriteria"); ?></li>
							<li class='third<?php print ($this->request->getController() == "AdvancedSearch") ? " nav-on" : ""; ?>'><?php print caNavLink($this->request, "<span class='ir'>Advanced Search</span><span class='rollover'></span>", "", "", "AdvancedSearch", "Index"); ?></li>
							<li class='fourth<?php print ($this->request->getController() == "About") ? " nav-on" : ""; ?>'><?php print caNavLink($this->request, "<span class='ir'>About</span><span class='rollover'></span>", "", "", "About", "Index"); ?></li>
						</ul>
					</div><!-- end nav -->
<?php
				//print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/".$this->request->config->get('header_img')."' border='0'>", "", "", "", "");
				
?>				
<?php 
		
				if($this->request->getController() == "Splash") {
?>
					<div class="header-img">
						<img src="<?php echo $this->request->getThemeUrlPath(); ?>/img/<?php echo $this->request->config->get('header_img'); ?>" />
						<div class="header-callout">
							<div class="header-callout-top">
								<p><?php echo $this->request->config->get('header_text'); ?></p>
								<p class="link"><a href="<?php print caNavUrl($this->request, '', 'About', 'Index'); ?>">Learn More &raquo;</a></p>
							</div>
							<div class="header-callout-btm">
							</div>
						</div>
					</div> 
<?php
				} // end if
?>
				<h2 class="ir">Roundabout Archives</h2>
			<!-- end #header -->
			</div>
			
			<div id="main" role="main">





















