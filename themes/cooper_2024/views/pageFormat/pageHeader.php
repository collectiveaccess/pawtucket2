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
	$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$va_classroomDisplayName = caGetClassroomDisplayName();
	$vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	$va_access_values = 	caGetUserAccessValues($this->request);
	
	# Collect the user links: they are output twice, once for toggle menu and once for nav
	$va_user_links = array();
	if($this->request->isLoggedIn()){
		$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$va_user_links[] = '<li class="divider nav-divider"></li>';
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		if(caDisplayClassroom($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-PYCQPXB7QY"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-PYCQPXB7QY'); </script>
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

</head>
<body class="initial">
<?php


		$va_hero_images = array();
		$va_captions = array();
		if(strToLower($this->request->getController()) == "front"){
			$o_config = caGetFrontConfig();
			
			if($vs_set_code = $o_config->get("front_page_set_code")){
 				$t_set = new ca_sets();
 				$t_set->load(array('set_code' => $vs_set_code));
 				$vn_shuffle = 0;
 				if($o_config->get("front_page_set_random")){
 					$vn_shuffle = 1;
 				}
				# Enforce access control on set
				if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
					$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
					$qr_res = caMakeSearchResult('ca_objects', $va_featured_ids);
				}
 			}
			
			$vs_caption_template = $o_config->get("front_page_set_item_caption_template");
			if(!$vs_caption_template){
				$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
			}
			if($qr_res && $qr_res->numHits()){
				while($qr_res->nextHit()){
					if($vs_media = $qr_res->getWithTemplate('^ca_object_representations.media.hero', array("checkAccess" => $va_access_values))){
						$va_hero_images[$qr_res->get("ca_objects.object_id")] = $vs_media;
						$va_captions[$qr_res->get("ca_objects.object_id")] = $qr_res->getWithTemplate($vs_caption_template);
					}
				}
			}
		}
		if((strToLower($this->request->getAction()) == "courses") && ($pn_course_id = $this->request->getActionExtra())){		
			$t_course = new ca_occurrences($pn_course_id);
			$va_hero_images = $t_course->get("ca_object_representations.media.hero", array("checkAccess" => $va_access_values, "returnAsArray" => true));
			$va_captions = $t_course->get("ca_object_representations.preferred_labels", array("checkAccess" => $va_access_values, "returnAsArray" => true));
		
		}
		if(is_array($va_hero_images)){
			if(sizeof($va_hero_images) > 0){
?>
				<div class='container heroContainerContainer'>
					<div class='row'>
						<div class='heroContainer'>
							<div class='heroGradient'></div>
							<div class="jcarousel-wrapper">
							<!-- Carousel -->
								<div class="jcarousel heroSlideshow">
									<ul>
<?php					
										foreach($va_hero_images as $vn_key => $vs_hero){
											print "<li>".$vs_hero;
											$vs_caption = "";
											if($va_captions[$vn_key] && (strToLower($va_captions[$vn_key]) != "[blank]")){
												$vs_caption = $va_captions[$vn_key];
											}
											print "<div class='frontTopSlideCaption'>".(($vs_caption) ? $vs_caption : "&nbsp;")."</div>";
											print "</li>";
										}						
?>
									</ul>
								</div><!-- end jcarousel -->
							</div><!-- end jcarousel-wrapper -->
						</div><!-- end heroContainer -->
					</div><!-- end row -->
				</div><!-- end heroContainerContainer -->

				<script type='text/javascript'>
					setTimeout(function(){
						activateCarousel();
					}, 100);

					function activateCarousel() { 
						jQuery(document).ready(function() {
							/*
							Carousel initialization
							*/
<?php
							$vs_auto_start = "false";
							if(sizeof($va_hero_images) > 1){
								$vs_auto_start = "true";
							}
?>
							$('.heroSlideshow')
								.jcarousel({
									// Options go here
									wrap:'circular',
									auto: 1
								}).jcarouselAutoscroll({
									interval: 10000,
									target: '+=1',
									autostart: <?php print $vs_auto_start; ?>
								});

							/*
							 Pagination initialization
							 */
							$('.jcarousel-paginationHero')
								.on('jcarouselpagination:active', 'a', function() {
									$(this).addClass('active');
								})
								.on('jcarouselpagination:inactive', 'a', function() {
									$(this).removeClass('active');
								})
								.jcarouselPagination({
									// Options go here
								});
				
				
							$(".jcarousel-paginationHero").hover(function () {

								$('.heroSlideshow').jcarouselAutoscroll('stop');
							},function () {
								$('.heroSlideshow').jcarouselAutoscroll('start');
							});
							
							$(".frontTopSlideCaption").width($(".heroSlideshow").width() - 30);
							$(".heroSlideshow li").width($(".heroSlideshow").width());
							if($(".heroSlideshow img").height() > 400){
								$(".heroContainer").height($(".heroSlideshow img").height() + 45);
								$(".heroContainer .heroGradient").height($(".heroSlideshow img").height());
								$(".frontTopContainer").height($(".heroSlideshow img").height() + 45);
							}else{
								$(".heroContainer").height(445);
								$(".heroContainer .heroGradient").height(400);
								$(".frontTopContainer").height(445);
						  }
						});
					}
					$( window ).resize(function() {
					  $(".frontTopSlideCaption").width($(".heroSlideshow").width() - 30);
					  $(".heroSlideshow li").width($(".heroSlideshow").width());
					  if($(".heroSlideshow img").height() > 400){
							$(".heroContainer").height($(".heroSlideshow img").height() + 45);
					  		$(".heroContainer .heroGradient").height($(".heroSlideshow img").height());
					  		$(".frontTopContainer").height($(".heroSlideshow img").height() + 45);
					  }else{
					  		$(".heroContainer").height(445);
					  		$(".heroContainer .heroGradient").height(400);
					  		$(".frontTopContainer").height(445);
					  }
					});
				</script>

<?php
			}
		}
?>



	<nav class="navbar navbar-default navbar-fixed-top yamm <?php print (is_array($va_hero_images) && sizeof($va_hero_images)) ? "transparent" : ""; ?>" role="navigation">
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
<?php
	if ($vb_has_user_links) {
?>
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<span class="glyphicon glyphicon-user"></span>
				</button>
<?php
	}
?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'CU_Logo.png'), "navbar-brand initialLogo", "", "","");
				print caNavLink($this->request, "<strong>The Irwin S Chanin</strong><br>School of Architecture Archive<br/>of The Cooper Union", "headerText", "", "","");
?>
				
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">
					<?php print join("\n", $va_user_links); ?>
				</ul>
			</div>
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Keyword" name="search" id="searchFormHeader">
						</div>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right menuItems">
					<li><?php print caNavLink($this->request, _t("Exhibitions"), "", "", "Browse", "exhibitions"); ?></li>
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Student Work</span></a>
						<ul class="dropdown-menu">
							<li><?php print caNavLink($this->request, _t("Projects"), "", "", "Browse", "projects"); ?></li>
							<li><?php print caNavLink($this->request, _t("Courses"), "", "", "Listing", "Courses"); ?></li>
							<li><?php print caNavLink($this->request, _t("Locations"), "", "", "Browse", "location"); ?></li>
						</ul>
					</li>
					<li class="navSpace"><?php print caNavLink($this->request, _t("People"), "", "", "Browse", "people"); ?></li>
				</ul>
				





			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<script type="text/javascript">
		$(window).scroll(function(){ 
			var scrollLimit = 100;
			var pos = $(window).scrollTop();
			if(pos > scrollLimit) {
				$("body").removeClass("initial");
				$(".navbar-brand").removeClass("initialLogo");
				//$(".headerText").hide();
			}else {
				if(!$("body").hasClass("initial")){
					$("body").addClass("initial");
				}
				if(!$(".navbar-brand").hasClass("initialLogo")){
					$(".navbar-brand").addClass("initialLogo");
					//$(".headerText").show();
				}
			}
		});
	</script>
<?php
	# --- front page output these divs later, after top slideshow
	if((strtolower($this->request->getController()) != "front") && !((strtolower($this->request->getController()) == "detail") && (strtolower($this->request->getAction()) == "courses"))){
?>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
<?php
	}
?>