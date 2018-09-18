<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_displayname = ucFirst($va_lightboxDisplayName["singular"]);
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];

	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$vs_user_links = "";
	if($this->request->isLoggedIn()){
		$vs_user_links .= '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$vs_user_links .= '<li class="divider nav-divider"></li>';
		if(!$this->request->config->get("disable_lightbox")){
			$vs_user_links .= "<li>".caNavLink($this->request, $vs_lightbox_displayname, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		$vs_user_links .= "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Log In")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<meta name="google-translate-customization" content="6598f6e8856112f-6736157c5190a299-gae5b7c4a187f7a41-13">
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	<link rel="shortcut icon" href="https://www.911memorial.org/sites/all/themes/national911/favicon.ico" type="image/x-icon" />
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#advancedSearch-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
<?php
	//
	// Pull in JS and CSS for debug bar
	// 
	if(Debug::isEnabled()) {
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
</head>
<body>
	<nav class="navbar navbar-default navbarTop" role="navigation">
		<div class="container subTitleSmall">
			<div class="subTitle"><?php print caNavLink($this->request, _t("Inside the Collection"), "", "", "",""); ?></div>
		</div>
		<div class="container" id="topSubNavBar">
			<ul class="nav navbar-nav navbar-left">
				<li><a href="https://membership.911memorial.org/user?destination=user">Log In</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="https://www.911memorial.org/dashboard">Members</a></li>
				<li><a href="https://www.911memorial.org/national-september-11-memorial-museum">About</a></li>
				<li><a href="https://www.911memorial.org/faq/general">FAQ</a></li>
				<li><a href="https://www.911memorial.org/blog">Blog</a></li>
				<li><a href="https://www.911memorial.org/media-center">Newsroom</a></li>
				<li><a href="https://www.911memorial.org/interact">Interact</a></li>
				<li><a href="https://www.911memorial.org/catalog">Museum Shop</a></li>
				<li>
					<div class="header-translate"><div id="google_translate_element"></div></div>
        <script type="text/javascript">
          function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
          }
          $( document ).ready(function() {
            function changeLanguageText() {
              var text = $('.goog-te-menu-value span:first-child').text();
              if (text && text != "Translate") {
                $('.goog-te-menu-value span:first-child').html('Translate');
                $('#google_translate_element').fadeIn('slow');
              } else {
                setTimeout(changeLanguageText, 200);
              }
            }
            changeLanguageText();
          });
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

				</li>
			</ul>	
		</div>
	</nav>
	<nav class="navbar navbar-default navbarMain" role="navigation">
		<div class="container">

			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				print "<a href='http://www.911memorial.org/' class='navbar-brand'>".caGetThemeGraphic($this->request, 'logo.png', array('alt' => '911 Memorial'))."</a>";
?>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class='visitLink'><a href="https://www.911memorial.org/visit">Visit</a><div class="triangle"><?php print caGetThemeGraphic($this->request, 'triangle.png'); ?></div></li>
					<li class='memorialLink'><a href="https://www.911memorial.org/memorial">Memorial</a><div class="triangle"><?php print caGetThemeGraphic($this->request, 'triangle.png'); ?></div></li>
					<li class='museumLink'><a href="https://www.911memorial.org/museum">Museum</a><div class="triangle"><?php print caGetThemeGraphic($this->request, 'triangle.png'); ?></div></li>
					<li class='learnLink'><a href="https://www.911memorial.org/teach-learn">Teach + Learn</a><div class="triangle"><?php print caGetThemeGraphic($this->request, 'triangle.png'); ?></div></li>
					<li class='involvedLink'><a href="https://www.911memorial.org/get-involved">Get Involved</a><div class="triangle"><?php print caGetThemeGraphic($this->request, 'triangle.png'); ?></div></li>
					<li><a href="https://www.911memorial.org/make-monetary-donation-now">Donate</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
		<div class="container" style="position:relative;">
			<div class="navOverlay visitLink" id="visitPanel">
				<div class="imgSide">
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/911-memorial-museum-store-vesey"><?php print caGetThemeGraphic($this->request, 'model_0.jpg'); ?><h3>9/11 Memorial Museum Store at Vesey »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/911-family-member-visit-information"><?php print caGetThemeGraphic($this->request, 'Picture1a.jpg'); ?><h3>9/11 Family Member Visit Information »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/our-city-our-story-0"><?php print caGetThemeGraphic($this->request, 'deniro3.jpg'); ?><h3>Our City. Our Story. »</h3></a>
						</div>
					</div>
				</div>
				<div class="textCol">
					<div>
						<h3>Visit the Museum</h3>
						<a href="https://www.911memorial.org/visit-museum-1">Tickets and Info<span> »</span></a><br/>
						<a href="https://www.911memorial.org/tours">Tours<span> »</span></a><br/>
						<a href="https://www.911memorial.org/groups-0">Groups<span> »</span></a><br/>
						<a href="https://www.911memorial.org/education-programs">Education Programs<span> »</span></a><br/>
						<a href="https://membership.911memorial.org/">Museum Members<span> »</span></a>
					</div>
					<div>
						<h3>Visitor<br/>Information</h3>
						<a href="https://www.911memorial.org/what-expect-your-museum-visit">What to Expect<span> »</span></a><br/>
						<a href="https://www.911memorial.org/you-arrive">Before Arrival<span> »</span></a><br/>
						<a href="https://www.911memorial.org/getting-here">Getting Here<span> »</span></a><br/>
						<a href="https://www.911memorial.org/hours-operation">Hours of Operation<span> »</span></a><br/>
						<a href="https://www.911memorial.org/accessibility-information">Accessibility<span> »</span></a>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="navOverlay memorialLink" id="memorialPanel">
				<div class="imgSide">
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/1993-wtc-bombing-victims"><?php print caGetThemeGraphic($this->request, '1993panel.jpg'); ?><h3>1993 WTC Bombing Victims »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://goo.gl/pQXcB"><?php print caGetThemeGraphic($this->request, 'For_GoogleStreetView.jpg'); ?><h3>360-Degree View of the Memorial »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/memorial"><?php print caGetThemeGraphic($this->request, '8V7A3776_0.gif'); ?><h3>Visit the 9/11 Memorial »</h3></a>
						</div>
					</div>
				</div>
				<div class="textCol">
					<div>
						<h3>Design</h3>
						<a href="https://www.911memorial.org/about-memorial">About The Memorial<span> »</span></a><br/>
						<a href="https://www.911memorial.org/survivor-tree">Survivor Tree<span> »</span></a><br/>
						<a href="https://www.911memorial.org/design-overview">Design Overview<span> »</span></a><br/>
						<a href="https://www.911memorial.org/memorial-architects">Architects<span> »</span></a>
					</div>
					<div>
						<h3>Explore</h3>
						<a href="https://www.911memorial.org/names-memorial">Find a Name<span> »</span></a><br/>
						<a href="https://www.911memorial.org/explore-memorial">View the Memorial<span> »</span></a><br/>
						<a href="https://www.911memorial.org/911-memorial-walking-tours">Walking Tours<span> »</span></a>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="navOverlay museumLink" id="museumPanel">
				<div class="imgSide">
					<div class="imgCol">
						<div class="imgBox">
							<a href=""><?php print caGetThemeGraphic($this->request, 'JL_911MUSEUM_COMM_13large.jpg'); ?><h3>360-Degree View of the Museum »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href=""><?php print caGetThemeGraphic($this->request, 'MEMEX2_13crop.jpg'); ?><h3>Contribute to the Memorial Exhibition »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href=""><?php print caGetThemeGraphic($this->request, 'JL_THINC_03HPCROP.jpg'); ?><h3>Visit the 9/11 Memorial Museum »</h3></a>
						</div>
					</div>
				</div>
				<div class="textCol">
					<div>
						<h3>Overview</h3>
						<a href="https://www.911memorial.org/about-museum">About the Museum<span> »</span></a><br/>
						<a href="https://www.911memorial.org/museum-exhibitions">Exhibitions<span> »</span></a><br/>
						<a href="https://www.911memorial.org/message-museum-director">Director's Message<span> »</span></a><br/>
						<a href="https://www.911memorial.org/museum-architects">The Architects<span> »</span></a><br/>
						<a href="https://www.911memorial.org/collection">About the Collection<span> »</span></a>
					</div>
					<div>
						<h3>Contribute</h3>
						<a href="https://www.911memorial.org/help-build-collection">Help Build the Collection<span> »</span></a><br/>
						<a href="https://www.911memorial.org/registries">Registries<span> »</span></a><br/>
						<a href="https://www.911memorial.org/registry">Artists Registry<span> »</span></a><br/>
						<a href="https://www.911memorial.org/oral-remembrances">Oral Remembrances<span> »</span></a>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="navOverlay learnLink" id="learnPanel">
				<div class="imgSide">
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/lesson-plans"><?php print caGetThemeGraphic($this->request, 'BeforeandAfter9-11-01-MasterJohnHarrattan.jpg'); ?><h3>Lesson Plans »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/public-programs"><?php print caGetThemeGraphic($this->request, '_78Q3965_0.jpg'); ?><h3>Public<br/>Programs »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/education-programs"><?php print caGetThemeGraphic($this->request, '_78Q9183.jpg'); ?><h3>Education Programs »</h3></a>
						</div>
					</div>
				</div>
				<div class="textCol">
					<div>
						<h3>Teach</h3>
						<a href="https://www.911memorial.org/education-programs">Education Programs<span> »</span></a><br/>
						<a href="https://www.911memorial.org/youth-and-families">Youth and Families<span> »</span></a><br/>
						<a href="https://www.911memorial.org/lesson-plans">Lesson Plans<span> »</span></a><br/>
						<a href="https://www.911memorial.org/teaching-911">Teaching Guides<span> »</span></a><br/>
						<div class='multiline'><a href="https://www.911memorial.org/talk-children-about-911">Talking to Children about 9/11<span> »</span></a></div>
						<a href="https://www.911memorial.org/911-primary-sources">9/11 Primary Sources<span> »</span></a>
					</div>
					<div>
						<h3>Learn</h3>
						<a href="https://www.911memorial.org/faq-about-911">9/11 FAQ<span> »</span></a><br/>
						<a href="https://www.911memorial.org/interactive-911-timelines">Interactive Timelines<span> »</span></a><br/>
						<div class='multiline'><a href="https://www.911memorial.org/world-trade-center-history">World Trade Center History<span> »</span></a></div>
						<a href="https://www.911memorial.org/rescue-recovery">Rescue & Recovery<span> »</span></a><br/>
						<a href="https://www.911memorial.org/911-related-terror">9/11 Related Terror<span> »</span></a><br/>
						<a href="https://www.911memorial.org/webcasts-exploring-911">View Webcasts<span> »</span></a>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="navOverlay involvedLink" id="involvedPanel">
				<div class="imgSide">
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/volunteer"><?php print caGetThemeGraphic($this->request, 'MuseumDocent.jpg'); ?><h3>Volunteer »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="http://www.911memorial.org/become-911-memorial-museum-member"><?php print caGetThemeGraphic($this->request, '_O9A2023.jpg'); ?><h3>Become a<br/>Museum<br/>Member »</h3></a>
						</div>
					</div>
					<div class="imgCol">
						<div class="imgBox">
							<a href="https://www.911memorial.org/commemorate-911-0"><?php print caGetThemeGraphic($this->request, 'nightshot.jpg'); ?><h3>Commemorate 9/11 »</h3></a>
						</div>
					</div>
				</div>
				<div class="textCol">
					<div>
						<h3>Donate</h3>
						<a href="https://www.911memorial.org/make-monetary-donation-now">Donate Now<span> »</span></a><br/>
						<a href="https://www.911memorial.org/sponsor-cobblestone-0">Sponsor a Cobblestone<span> »</span></a><br/>
						<a href="https://www.911memorial.org/take-seat">Take a Seat<span> »</span></a><br/>
						<a href="https://www.911memorial.org/our-donors">Our Donors<span> »</span></a>
					</div>
					<div>
						<h3>Get Involved</h3>
						<a href="https://www.911memorial.org/volunteer">Volunteer<span> »</span></a><br/>
						<a href="https://www.911memorial.org/become-911-memorial-museum-member">Become a Member<span> »</span></a><br/>
						<a href="https://www.911memorial.org/ocos">Our City Our Story<span> »</span></a><br/>
						<a href="https://www.911memorial.org/commemorate-911-0">Commemorate 9/11<span> »</span></a>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div><!-- end container -->
<script type="text/javascript">
	 $(document).ready(function() {
			$(".visitLink").hover(function(){
				$("#visitPanel").show();
				$(".visitLink .triangle").show();
			},function(){
				$("#visitPanel").hide();
				$(".visitLink .triangle").hide();
			});
			$(".memorialLink").hover(function(){
				$("#memorialPanel").show();
				$(".memorialLink .triangle").show();
			},function(){
				$("#memorialPanel").hide();
				$(".memorialLink .triangle").hide();
			});
			$(".museumLink").hover(function(){
				$("#museumPanel").show();
				$(".museumLink .triangle").show();
			},function(){
				$("#museumPanel").hide();
				$(".museumLink .triangle").hide();
			});
			$(".learnLink").hover(function(){
				$("#learnPanel").show();
				$(".learnLink .triangle").show();
			},function(){
				$("#learnPanel").hide();
				$(".learnLink .triangle").hide();
			});
			$(".involvedLink").hover(function(){
				$("#involvedPanel").show();
				$(".involvedLink .triangle").show();
			},function(){
				$("#involvedPanel").hide();
				$(".involvedLink .triangle").hide();
			});
	});
</script>


	
	<nav class="navbar navbar-default navbarSub yamm" role="navigation">
		<div class="container">
			<div class="breadcrumbs">
				<a href="https://www.911memorial.org/museum"><span>«</span>Museum</a><span>/</span><a href="https://www.911memorial.org/collection">Collections</a><span>/</span><?php print caNavLink($this->request, _("Inside the Collection"), "breadcrumbHome", "", "", ""); ?>
			</div>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'Objects'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li <?php print ($this->request->getController() == "Front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Home")."<span>/</span>", "", "", "", ""); ?></li>
<?php
						print $this->render("pageFormat/browseMenu.php");
						#print $this->render("pageFormat/advancedSearchMenu.php");
?>	
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Features")."<span>/</span>", "", "", "Gallery", "Index"); ?></li>
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print _t('My Collection'); ?></a>
						<ul class="dropdown-menu">
<?php
							print $vs_user_links;
?>
						</ul>
					</li>
					<!--<li class="navBarExtras<?php print ($this->request->getController() == "FAQ") ? ' active' : ''; ?>"><?php print caNavLink($this->request, _t("FAQ"), "", "", "FAQ", "Index"); ?></li>
					<li class="navBarExtras<?php print ($this->request->getController() == "Contact") ? ' active' : ''; ?>"><?php print caNavLink($this->request, _t("Ask a Reference Question"), "", "", "Contact", "Form"); ?></li>-->
					<li class="navBarExtras"><a href="#">Museum Home</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>





	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
			<div class="header-social">
				<a class="fb" href="https://www.facebook.com/911memorial" target="_blank"></a>
				<a class="twit" href="https://twitter.com/sept11memorial" target="_blank"></a>
				<a class="instagram" href="https://instagram.com/911memorial/" target="_blank"></a>
				<a class="gplus" href="https://plus.google.com/+911Memorial/posts" target="_blank"></a>
        	</div>
