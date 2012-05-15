<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/bookmarks.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
	</script>
</head>
<body>
		<div id="topBar">
    		<div class="header-top">
      			<div class="wrapper clearfix">
        			<h2 class="element-invisible"></h2>
        			<ul>
        				<li class="menu-2997 first"><a href="/newsroom" title="Newsroom">Newsroom</a></li>
						<li class="menu-29386"><a href="/about-us-0" title="">About Us</a></li>
						<li class="menu-29391"><a href="/information-911-family-members" title="">For 9/11 Families</a></li>
						<li class="menu-29396"><a href="/images-videos/features" title="">Images + Video</a></li>
						<li class="menu-23191"><a href="/blog" title="">The Memo Blog</a></li>
						<li class="menu-29406"><a href="/catalog" title="">Museum Shop </a></li>
						<li class="menu-29411 last"><a href="/faq/general" title="">FAQ</a></li>
					</ul>
				</div><!-- end wrapper -->
    		</div><!-- end header-top -->
<?php
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					if(!$this->request->config->get('disable_my_collections')){
						print caNavLink($this->request, _t("My Collections"), "", "", "Sets", "Index");
					}
					if($this->request->config->get('enable_bookmarks')){
						print caNavLink($this->request, _t("My Bookmarks"), "", "", "Bookmarks", "Index");
					}
					print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
				}else{
					print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form");
				}
			}
			
			# Locale selection
			global $g_ui_locale;
			$vs_base_url = $this->request->getRequestUrl();
			$vs_base_url = ((substr($vs_base_url, 0, 1) == '/') ? $vs_base_url : '/'.$vs_base_url);
			$vs_base_url = str_replace("/lang/[A-Za-z_]+", "", $vs_base_url);
			
			if (is_array($va_ui_locales = $this->request->config->getList('ui_locales')) && (sizeof($va_ui_locales) > 1)) {
				print caFormTag($this->request, $this->request->getAction(), 'caLocaleSelectorForm', null, 'get', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
			
				$va_locale_options = array();
				foreach($va_ui_locales as $vs_locale) {
					$va_parts = explode('_', $vs_locale);
					$vs_lang_name = Zend_Locale::getTranslation(strtolower($va_parts[0]), 'language', strtolower($va_parts[0]));
					$va_locale_options[$vs_lang_name] = $vs_locale;
				}
				print caHTMLSelect('lang', $va_locale_options, array('id' => 'caLocaleSelectorSelect', 'onchange' => 'window.location = \''.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => '')).'\' + jQuery(\'#caLocaleSelectorSelect\').val();'), array('value' => $g_ui_locale, 'dontConvertAttributeQuotesToEntities' => true));
				print "</form>\n";
			
			}
?>
		</div><!-- end topbar -->
		<div class="header-nav">
			<div class="wrapper">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/logo.png' border='0'>", "navLogo", "", "", "");
?>				
				<div class="header-search">
					<form action="/wtc-history"  accept-charset="UTF-8" method="post" id="search-theme-form">
						<div>
							<div id="search" class="container-inline">
								<div class="form-item" id="edit-search-theme-form-1-wrapper">
									<input type="text" maxlength="128" name="search_theme_form" id="edit-search-theme-form-1" size="15" value="Search..." title="Enter the terms you wish to search for." class="form-text" style="padding-top:8px; color:#888888;"/>
								</div>
								<input type="submit" name="op" id="edit-submit-1" value="Search"  class="form-submit" />
								<input type="hidden" name="form_build_id" id="form-7ed203c20bcfaee9dab929bd224ba9db" value="form-7ed203c20bcfaee9dab929bd224ba9db"  />
								<input type="hidden" name="form_id" id="edit-search-theme-form" value="search_theme_form"  />
							</div>
	
						</div>
					</form>
				</div>
				<div class="header-social">
					<a href="http://www.facebook.com/911memorial#!/pages/National-September-11-Memorial-Museum/109812364025" target="_blank"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/ico-fb.png" alt="" /></a> <a href="http://twitter.com/sept11memorial" target="_blank"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/ico-tw.png" alt="" /></a>
				</div>
				<div class="header-login"><a href="/user">log in</a></div>
				<div class="header-menu">
					<ul class="menu">
						<li class="leaf primary-links-1551 primary-links-item first"><a href="/visit" title="Visit"><span style="background-image: url('<?php print $this->request->getThemeUrlPath()?>/graphics/plan-your-visit.png');">Plan Your Visit</span></a>
							<ul class="dropdownmenu" id="dropdownmenu1551">
								<li class="smallchips">
								<div class="item-list">
									<ul>
										<li class="first"><a href="/visitor-passes"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/nightaerial615x380.jpg" title="Visitor Passes" alt="Visitor Passes" /><span>Visitor Passes&nbsp;&raquo;</span></a></li>
										<li><a href="/911-family-member-visitor-passes"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/aerialsite.jpg" title="9/11 Family Member Visitor Passes" alt="9/11 Family Member Visitor Passes" /><span>9/11 Family Member Visitor Passes&nbsp;&raquo;</span></a></li>
										<li class="last"><a href="/explore-downtown"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/911_Decal.jpg" title="While you are Downtown" alt="While you are Downtown" /><span>While you are Downtown&nbsp;&raquo;</span></a></li>
									</ul>
								</div>
								</li>
								<li><h3>Visitor Information</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/visitor-passes" title="Reserve a Free Pass">Reserve Passes</a></li>
										<li class="leaf"><a href="/groups" title="Groups">Groups</a></li>
										<li class="leaf"><a href="/you-arrive" title="Before You Arrive">Before You Arrive</a></li>
										<li class="leaf last"><a href="/getting-here" title="Getting Here">Getting Here</a></li>
									</ul>
								</li>
								<li><h3>Visitor Resources</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/locating-name-0" title="Locating a Name">Locating a Name</a></li>
										<li class="leaf"><a href="/visitor-center" title="Visitor Center">Visitor Center</a></li>
										<li class="leaf"><a href="/preview-site" title="Preview Site">Preview Site</a></li>
										<li class="leaf"><a href="/places-visit-0" title="Nearby 9/11 Tributes">Explore downtown</a></li>
										<li class="leaf last"><a href="/apps" title="Mobile Apps">Mobile Apps</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li class="leaf primary-links-360 primary-links-item"><a href="/memorial" title=""><span style="background-image: url(<?php print $this->request->getThemeUrlPath()?>/graphics/memorial.png);">Memorial</span></a>
							<ul class="dropdownmenu" id="dropdownmenu360">
								<li class="smallchips">
								<div class="item-list">
									<ul>
										<li class="first"><a href="/faq/general"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/199509%5B1%5D.jpg" title="Memorial Opening " alt="Memorial Opening " /><span>Memorial Opening &nbsp;&raquo;</span></a></li>
										<li><a href="/take-virtual-visit1"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/Google_Earth.PNG" title="Take a Virtual Visit" alt="Take a Virtual Visit" /><span>Take a Virtual Visit&nbsp;&raquo;</span></a></li>
										<li class="last"><a href="/preview-site"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/model_0.jpg" title="Preview Site" alt="Preview Site" /><span>Preview Site&nbsp;&raquo;</span></a></li>
									</ul>
								</div>
								</li>
								<li><h3>Design</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/about-memorial" title="Design Overview">About The Memorial</a></li>
										<li class="leaf"><a href="/design-overview" title="Design Competition">Design Overview</a></li>
										<li class="leaf"><a href="/architects" title="">The Architects</a></li>
										<li class="leaf"><a href="/design-competition" title="">Design Competition</a></li>
										<li class="leaf last"><a href="/names-memorial" title="Names Arrangement">Names Arrangement</a></li>
									</ul>
								</li>
								<li><h3>Explore</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/explore-memorial" title="Explore The Memorial">Explore the Memorial</a></li>
										<li class="leaf"><a href="/take-virtual-visit1" title="Take A Virtual Visit">Take A Virtual Visit</a></li>
										<li class="leaf"><a href="/photo-albums/911-memorial-renderings" title="">Renderings</a></li>
										<li class="leaf last"><a href="/contribute-memorial-exhibition" title="">Memorial Exhibition</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li class="leaf primary-links-361 primary-links-item"><a href="/museum" title=""><span style="background-image: url(<?php print $this->request->getThemeUrlPath()?>/graphics/museum.png);">Museum</span></a>
							<ul class="dropdownmenu" id="dropdownmenu361">
								<li class="smallchips">
								<div class="item-list">
									<ul>
										<li class="first"><a href="http://newmuseumme.national911memorial.org/preview.php"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/memorial-exhibition-wall-faces.png" title="The Memorial Exhibition" alt="The Memorial Exhibition" /><span>The Memorial Exhibition&nbsp;&raquo;</span></a></li>
										<li class="last"><a href="/photo-albums/exhibition-design"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/lowes_vigils.png" title="View Exhibition Design Studies" alt="View Exhibition Design Studies" /><span>View Exhibition Design Studies&nbsp;&raquo;</span></a></li>
									</ul>
								</div>
								</li>
								<li><h3>Overview</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/mission" title="The Mission">Mission</a></li>
										<li class="leaf"><a href="/message-museum-director" title="Message">Director&#039;s Message</a></li>
										<li class="leaf"><a href="/design" title="Museum Overview">The Design</a></li>
										<li class="leaf"><a href="/museum-exhibition-design-0" title="Exhibitions Overview">Exhibitions Plans</a></li>
										<li class="leaf"><a href="/our-partnerships" title="Our Partnerships">Our Partners</a></li>
										<li class="leaf"><a href="/museum-planning-conversation-series" title="Conversation Series">Museum Planning</a></li>
										<li class="leaf last"><a href="/museum-architects" title="Museum Architects">The Architects</a></li>
									</ul>
								</li>
								<li><h3>Collections</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/collection" title="Collection">About</a></li>
										<li class="leaf"><a href="/wtc-history" title="WTC History" class="active">The Original WTC</a></li>
										<li class="leaf"><a href="/911-events-day" title="9/11: Events of the Day">9/11: Events of the Day</a></li>
										<li class="leaf"><a href="/rescue-recovery" title="Rescue &amp; Recovery">Rescue &amp; Recovery</a></li>
										<li class="leaf"><a href="/tribute" title="Tribute">Tribute</a></li>
										<li class="leaf last"><a href="/oral-histories-0" title="Oral Histories">Oral Histories</a></li>
									</ul>
								</li>
								<li><h3>Contribute</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/contribute-memorial-exhibition" title="Memorial Exhibition">Memorial Exhibition</a></li>
										<li class="leaf"><a href="http://registry.national911memorial.org" title="">Artists Registry</a></li>
										<li class="leaf"><a href="http://makehistory.national911memorial.org" title="">Make History</a></li>
										<li class="leaf"><a href="/help-build-collection" title="">Donate Material</a></li>
										<li class="leaf last"><a href="/share-your-story" title="">Share Your Story</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li class="leaf primary-links-921 primary-links-item"><a href="/teach-learn" title=""><span style="background-image: url(<?php print $this->request->getThemeUrlPath()?>/graphics/teach---learn.png);">Teach + Learn</span></a>
							<ul class="dropdownmenu" id="dropdownmenu921">
								<li class="smallchips">
								<div class="item-list">
									<ul>
										<li class="first"><a href="http://ladyliberty.national911memorial.org"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/lady_liberty.PNG" title="Interactive Lady Liberty" alt="Interactive Lady Liberty" /><span>Interactive Lady Liberty&nbsp;&raquo;</span></a></li>
										<li><a href="/interactive-911-timeline"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/199522%5B1%5D.jpg" title="Interactive 9/11 Timeline" alt="Interactive 9/11 Timeline" /><span>Interactive 9/11 Timeline&nbsp;&raquo;</span></a></li>
										<li class="last"><a href="/visit"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/memorial_image.png" title="Visiting the Memorial" alt="Visiting the Memorial" /><span>Visiting the Memorial&nbsp;&raquo;</span></a></li>
									</ul>
								</div>
								</li>
								<li><h3>Teach</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/education-goals-and-key-questions" title="">Education Goals and Key Questions</a></li>
										<li class="leaf"><a href="/teaching-guides-0" title="Teaching 9/11">Teaching Guides</a></li>
										<li class="leaf"><a href="/talking-your-children-about-911" title="Talking to your Children about 9/11">Talking to Children about 9/11</a></li>
										<li class="leaf last"><a href="/webcasts-exploring-911" title="Webcasts: Exploring 9/11">Webcasts: Exploring 9/11</a></li>
									</ul>
								</li>
								<li><h3>Learn</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/interactive-911-timeline" title="Interactive Timeline">Interactive Timeline</a></li>
										<li class="leaf"><a href="/world-trade-center-history" title="The World Trade Center">World Trade Center History</a></li>
										<li class="leaf"><a href="/rescue-and-recovery" title="Rescue, Recovery, and Rebuilding">Rescue and Recovery</a></li>
										<li class="leaf last"><a href="/911-related-terror" title="Origins &amp; Impact">9/11 Related Terror</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li class="leaf primary-links-362 primary-links-item last"><a href="/donate" title=""><span style="background-image: url(<?php print $this->request->getThemeUrlPath()?>/graphics/donate---get-involved.png);">Donate + Get Involved</span></a>
							<ul class="dropdownmenu" id="dropdownmenu362">
								<li class="smallchips">
								<div class="item-list">
									<ul>
										<li class="first"><a href="/join-signs-support"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/SOS.jpg" title="Join the Signs of Support" alt="Join the Signs of Support" /><span>Join the Signs of Support&nbsp;&raquo;</span></a></li>
										<li class="last"><a href="/donations/become-charter-member"><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/flag%20lapel%20pin%20for%20web.jpg" title="Become a Charter Member " alt="Become a Charter Member " /><span>Become a Charter Member &nbsp;&raquo;</span></a></li>
									</ul>
								</div>
								</li>
								<li><h3>Donate</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/donations" title="Donate Now">Donate Now</a></li>
										<li class="leaf last"><a href="/sponsor-cobblestone" title="Sponsor A Cobblestone">Sponsor a Cobblestone</a></li>
									</ul>
								</li>
								<li><h3>Get Involved</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/volunteer" title="Volunteer">Volunteer</a></li>
										<li class="leaf"><a href="/join-signs-support" title="Signs of Support">Signs of Support</a></li>
										<li class="leaf last"><a href="/become-visionary" title="">Become a Visionary</a></li>
									</ul>
								</li>
								<li><h3>Giving</h3>
									<ul class="menu">
										<li class="leaf first"><a href="/our-donors" title="Our Donors">Our Donors</a></li>
										<li class="leaf last"><a href="/commemorative-medal" title="Commemorative Medal">Commemorative Medal</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul><!-- end ulMenu -->        
				</div><!-- end header-menu --> 
			</div><!-- end headerContent -->
		</div><!-- end header -->
		<div class="wrapper"><div class="breadcrumb"><a href="/"><span>&laquo; </span>Home</a>&nbsp/&nbsp;<a href="/museum" title="">Museum</a>&nbsp/&nbsp;<a href="/museum" title="Collections">Collections</a>&nbsp/&nbsp;Search the Collection</div></div> 
		<div id="pageArea">
		<div id="pageContent">

<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div id="nav">
<?php
			print caNavLink($this->request, "Home", '', '', '','')."<br/>";
			print join("<br/>", $this->getVar('nav')->getHTMLMenuBarAsLinkArray());
?>			
				<div id="search" class="header-search">
					<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
							<a href="#" name="searchButtonSubmit" class="form-submit" onclick="document.forms.header_search.submit(); return false;"><?php print _t("Search"); ?></a>
							<input type="text" name="search" value="Search Objects..." onfocus="this.value='';" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
					</form>
				</div>
			</div><!-- end nav -->

