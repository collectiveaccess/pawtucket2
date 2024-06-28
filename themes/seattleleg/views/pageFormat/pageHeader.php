<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2024 Whirl-i-Gig
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
$lightboxDisplayName = caGetLightboxDisplayName();
$lightbox_sectionHeading = ucFirst($lightboxDisplayName["section_heading"]);

# Collect the user links
$user_links = "";
if($this->request->isLoggedIn()){
	$user_links .= "<li class='nav-item dropdown'><a class='nav-link".(($this->request->getController() == 'LoginReg') ? ' active' : '')."' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle' aria-label='"._t('User Options')."'></i></a>
						<ul class='dropdown-menu'>";
	
	$user_links .= '<li><div class="dropdown-header fw-medium">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'<br>'.$this->request->user->get("email").'</div></li>';
	$user_links .= "<li><hr class='dropdown-divider'></li>";
	if(caDisplayLightbox($this->request)){
		$user_links .= "<li>".caNavLink($this->request, $lightbox_sectionHeading, 'dropdown-item', '', 'Lightbox', 'Index', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('User Profile'), 'dropdown-item', '', 'LoginReg', 'profileForm', array())."</li>";
	
	if ($this->request->config->get('use_submission_interface')) {
		$user_links .= "<li>".caNavLink($this->request, _t('Submit content'), 'dropdown-item', '', 'Contribute', 'List', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('Logout'), 'dropdown-item', '', 'LoginReg', 'Logout', array())."</li>";
	$user_links .= "</ul></li>";
} else {	
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links = "<li class='nav-item'>".caNavlink($this->request, _t('Login'), "nav-link".((strToLower($this->request->getController()) == "loginreg") ? " active" : ""), "", "LoginReg", "LoginForm", "", ((strToLower($this->request->getController()) == "loginreg") ? array("aria-current" => "page") : null))."</li>"; }
}

?><!DOCTYPE html>
<html lang="en" class="h-100">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<?= MetaTagManager::getHTML(); ?>
	<?= AssetLoadManager::getLoadHTML($this->request); ?>
	
	<title><?= (MetaTagManager::getWindowTitle()) ?: $this->request->config->get("app_display_name"); ?></title>

  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>

	<script>
		let pawtucketUIApps = {};
	</script>
</head>
<body id="pawtucketApp" class="d-flex flex-column h-100">


<nav class="navbar sticky-top">
  <div class="container p-0">

		<div class="navbar-brand">
				<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'logoHome.png', array("alt" => "Logo", "role" => "banner")), "logohome", "", "", ""); ?>
				<a class="logo-text text-decoration-none" href="//www.seattle.gov">Seattle.gov</a>
		</div>
   
    <div>
			<!-- Button trigger modal -->
			<button class="btn text-white" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="search" tabindex='0'>
        <span class="visually-hidden">search</span>
				<i class="bi bi-search"></i>
			</button>

			<!-- Modal -->
			<div class="modal fade" id="searchModal" aria-hidden="true">
				<div class="modal-dialog" style="width: 100%; height: 100%; margin: 60px 0 0 0; max-width: unset">
					<div class="modal-content" style="height: 100%; border-radius: 0; opacity: 1; background-color: rgba(0, 0, 0, 0.6);">
            <div class="modal-header border-0 p-0 justify-content-end" style="height: 52px">
              <button class="btn text-white" data-bs-dismiss="modal" aria-label="Close" tabindex='0'>
								<i class="bi bi-x" style="font-size: 55px"></i>
							</button>
            </div>
            <div class="modal-body">
              <form role="search" id="googleSearch" class="navbar-form" style="width: 600px; margin: 100px auto auto;" action='https://www.seattle.gov/searchresults'>
				<div class="input-group">
					<input type="text" class="form-control" title="Search" id="searchInput" name="terms" size="18" maxlength="255" value="" placeholder="Search" autocomplete="off" style="width: 500px; height: 55px; border: none; font-size: 28px; border-radius: 0;">
					<button id="searchButton" type="submit" class="btn btn-secondary btn-default" tabindex='0'
						style="border-radius: 0; background-color: #666; color: #fff;border-color: #666; height: 55px; width: 55px;" aria-label="search button">
							<span class="visually-hidden">search</span>
							<i class="bi bi-search" style="font-size: 24px;"></i>
					</button>
				</div>

				<div>
					<fieldset class="searchToggles text-white" aria-label="search-toggles">
						<div class="radio" style="text-align: right; float: right;margin-top: 10px;">
							<label class="pe-1" for="Seattlegov">
								<input type="radio" name="catids" value="" title="Seattlegov" id="Seattlegov" checked="checked">
								<span>Seattle.Gov</span>
							</label>
							<label class="pe-1" for="deptCollection">
								<input type="radio" name="catids" value="1889" title="Current Site" id="deptCollection">
								<span>This Site Only</span>
							</label>
						</div>
					</fieldset>
				</div>
				<script>
					let googleSearch = document.getElementById('googleSearch');
					let seattlegov = document.getElementById('Seattlegov');
					let deptCollection = document.getElementById('deptCollection');
					let searchInput = document.getElementById('searchInput');
					seattlegov.onclick = function(e) {
						let s = searchInput.value;
						googleSearch.action = 'https://www.seattle.gov/searchresults?terms=' + escape(s);
						searchInput.name = 'terms';
					};
					deptCollection.onclick = function(e) {
						googleSearch.action = '/Search/combined';
						searchInput.name = 'search';
					};
				</script>
              </form>
            </div>

          </div>
        </div>
      </div>

			<!-- <button class="btn border-0 desktop-nav-collapse" data-bs-toggle="collapse" data-bs-target="#mySidebar" aria-controls="mySidebar" aria-expanded="false" aria-label="Toggle sidebar">
				<i class="bi bi-list text-white"></i>
			</button>

			<button class="btn border-0 mobile-nav-collapse" data-bs-toggle="collapse" data-bs-target="#seagovMenuMobile" aria-controls="seagovMenuMobile" aria-expanded="false" aria-label="Toggle mobile sidebar">
				<i class="bi bi-list text-white"></i>
			</button> -->

			<button class="btn border-0 desktop-nav-collapse" id="openSlideMenuDesktop" aria-label="Toggle sidebar">
				<i class="bi bi-list text-white"></i>
			</button>

			<button class="btn border-0 mobile-nav-collapse" id="openSlideMenuMobile" aria-label="Toggle mobile sidebar">
				<i class="bi bi-list text-white"></i>
			</button>

    </div>
  </div>
</nav>


	<ul id="seagovMenuDesktop" class="slidemenu-right list-group" style="width: 320px;">
		<li class="list-group-item first">
			<button class="btn text-black float-end" id="closeSlideMenuDesktop" aria-label="Close Sidebar"><i class="bi bi-x" style="font-size: 55px"></i></button>
		</li>
    <li>
      <a href="https://www.seattle.gov/services-and-information" class="list-group-item" title="Main Menu — Services &amp; Information">Services &amp; Information</a>
    </li>
    <li>
      <a href="https://www.seattle.gov/elected-officials" class="list-group-item" title="Main Menu — Elected Officials">Elected Officials</a>
    </li>
    <li>
      <a href="https://www.seattle.gov/city-departments-and-agencies" class="list-group-item" title="Main Menu — Departments">Departments</a>
    </li>
    <li>
      <a href="https://www.seattle.gov/visiting-seattle" class="list-group-item" title="Main Menu — Visiting Seattle">Visiting Seattle</a>
    </li>
    <li>
      <a href="https://news.seattle.gov" class="list-group-item" title="Main Menu — News.Seattle.Gov">News.Seattle.Gov</a>
    </li>
    <li>
      <a href="https://www.seattle.gov/event-calendar" class="list-group-item" title="Main Menu — Event Calendar">Event Calendar</a>
    </li>
		<li class="list-group-item last" style="height: 100px;"></li>
	</ul>




 <!-- Mobile Menu -->


<ul id="seagovMenuMobile" class="list-group slidemenu-right">

  <li class="list-group-item first p-0">

    <button class="float-end" id="closeSlideMenuMobile" aria-label="Close Sidebar">
      <i class="bi bi-x" style="font-size: 30px"></i>
    </button>
    <form role="search" id="googleSearch_M" class="navbar-form p-1" style="background-color: #333;">
      <div class="input-group mb-2">
        <input type="text" class="bg-none" title="Search" id="searchInput_M"
        name="terms" maxlength="255" value="" placeholder="Search">
          <button id="searchButton_M" type="submit" class="btn bg-none text-white" aria-label="search">
						<i class="bi bi-search"></i>
          </button>
      </div>

      <div id="googleSearchToggle_M">
        <fieldset class="searchToggles">
          <div class="radio">
            <label for="Seattlegov_M">
              <input type="radio" name="catids" value="" title="Seattlegov" id="Seattlegov_M" checked="checked">
              <span class="text-white">
                Seattle.Gov
              </span>
            </label>
            <label for="deptCollection_M">
              <input type="radio" name="catids" value="1889" title="Current Site" id="deptCollection_M">
              <span class="text-white">
                This Site Only
              </span>
            </label>
          </div>
        </fieldset>
      </div>

    </form>
  </li>

  <li id="backReturn" class="list-group-item seattleHomeMobile" style="background-color: #003DA5">
    <i class="bi bi-chevron-left text-white"></i>
    <span class="navPretext text-white">Back to </span>
    <span class="text-white" id="backReturnText">CityClerk</span>
  </li>

  <li id="activeMobileHeading" class="list-group-item deptHomeMobile active bg-none">
    <a class="" href="https://www.seattle.gov/cityclerk/legislation-and-research">
      Legislation &amp; Research
    </a>
  </li>

  <li class="list-group-item navItem">
    <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources"
    title="Main Menu Mobile — Home Agendas &amp; Legislative Resources">
      Agendas &amp; Legislative Resources <i class="bi bi-chevron-right"></i>
    </a>
    <ul >
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/city-council-agendas"
        title="Main Menu Mobile — Agendas &amp; Legislative Resources City Council Agendas">
          City Council Agendas
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul >
          <li class="list-group-item navItem">
            <a href="https://seattle.legistar.com/Calendar.aspx" title="Main Menu Mobile — City Council Agendas Current Agendas">
              Current Agendas
            </a>
          </li>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/city-council-agendas/public-comment-guide"
            title="Main Menu Mobile — City Council Agendas Public Comment Guide">
              Public Comment Guide
            </a>
          </li>
          <li class="list-group-item navItem" >
            <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/city-council-agendas/contact-the-city-council"
            title="Main Menu Mobile — City Council Agendas Contact the City Council">
              Contact the City Council
            </a>
          </li>
          <li class="list-group-item navItem" >
            <a href="https://www.seattle.gov/council/committees/agenda-sign-up" title="Main Menu Mobile — City Council Agendas Subscribe to Council Agendas">
              Subscribe to Council Agendas
            </a>
          </li>
        </ul>
      </li>

      <li class="list-group-item navItem">
        <a href="/cityclerk/agendas-and-legislative-resources/legislative-process"
        title="Main Menu Mobile — Agendas &amp; Legislative Resources Legislative Process">
          Legislative Process
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/how-a-bill-becomes-a-law"
            title="Main Menu Mobile — Legislative Process How a Bill Becomes a Law">
              How a Bill Becomes a Law
            </a>
          </li>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/how-to-read-a-bill"
            title="Main Menu Mobile — Legislative Process How to Read a Bill">
              How to Read a Bill
            </a>
          </li>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/city-budget-process"
            title="Main Menu Mobile — Legislative Process City Budget Process">
              City Budget Process
            </a>
          </li>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/legislative-glossary"
            title="Main Menu Mobile — Legislative Process Legislative Glossary">
              Legislative Glossary
            </a>
          </li>
        </ul>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/public-notices"
        title="Main Menu Mobile — Agendas &amp; Legislative Resources Public Notices">
          Public Notices
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/terms-of-office-for-elected-officials"
        title="Main Menu Mobile — Agendas &amp; Legislative Resources Terms of Office for Elected Officials">
          Terms of Office for Elected Officials
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/seattles-form-of-government"
        title="Main Menu Mobile — Agendas &amp; Legislative Resources Seattle's Form of Government">
          Seattle's Form of Government
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources/find-your-council-district"
        title="Main Menu Mobile — Agendas &amp; Legislative Resources Find Your Council District">
          Find Your Council District
        </a>
      </li>
    </ul>
  </li>

  <li class="list-group-item navItem">
    <a href="https://www.seattle.gov/cityclerk/legislation-and-research" title="Main Menu Mobile — Home Legislation &amp; Research">
      Legislation &amp; Research <i class="bi bi-chevron-right"></i>
    </a>
    <ul>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/legislation-and-research/legislative-research-guide"
        title="Main Menu Mobile — Legislation &amp; Research Legislative Research Guide">
          Legislative Research Guide
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/legislation-and-research/research-assistance"
        title="Main Menu Mobile — Legislation &amp; Research Research Assistance">
          Research Assistance
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/legislation-and-research/request-public-records"
        title="Main Menu Mobile — Legislation &amp; Research Legislative Department Public Records Requests">
          Legislative Department Public Records Requests
        </a>
      </li>
      <li class="list-group-item navItem ">
        <a href="https://www.seattle.gov/cityclerk/legislation-and-research/seattle-municipal-code-and-city-charter"
        title="Main Menu Mobile — Legislation &amp; Research Seattle Municipal Code &amp; City Charter">
          Seattle Municipal Code &amp; City Charter
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul>
          <li class="list-group-item navItem">
            <a href="https://www.municode.com/library/wa/seattle/codes/municipal_code?nodeId=THCH_CHSE"
            title="Main Menu Mobile — Seattle Municipal Code &amp; City Charter Seattle City Charter">
              Seattle City Charter
            </a>
          </li>
          <li class="list-group-item navItem">
            <a href="https://www.municode.com/library/wa/seattle/codes/municipal_code"
            title="Main Menu Mobile — Seattle Municipal Code &amp; City Charter Seattle Municipal Code">
              Seattle Municipal Code
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </li>

  <li class="list-group-item navItem">
    <a href="https://www.seattle.gov/cityclerk/city-clerk-services" title="Main Menu Mobile — Home City Clerk Services">
      City Clerk Services <i class="bi bi-chevron-right"></i>
    </a>
    <ul>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/city-clerk-services/accessibility-and-requests-for-accommodations"
        title="Main Menu Mobile — City Clerk Services Accessibility and Requests for Accommodations">
          Accessibility and Requests for Accommodations
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/boards-and-commissions" title="Main Menu Mobile — City Clerk Services Boards and Commissions">
          Boards and Commissions
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/city-clerk-services/city-hall-visitor-information"
        title="Main Menu Mobile — City Clerk Services City Hall Visitor Information">
          City Hall Visitor Information
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/city-clerk-services/city-hall-visitor-information/city-hall-public-meeting-locations"
            title="Main Menu Mobile — City Hall Visitor Information City Hall Public Meeting Locations">
              City Hall Public Meeting Locations
            </a>
          </li>
        </ul>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/city-clerk-services/domestic-partnership-registration"
        title="Main Menu Mobile — City Clerk Services City of Seattle’s Domestic Partnership Registration Program">
          City of Seattle’s Domestic Partnership Registration Program
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services"
        title="Main Menu Mobile — City Clerk Services Office of the City Clerk &amp; Seattle Municipal Archives Fee Schedule">
          Office of the City Clerk &amp; Seattle Municipal Archives Fee Schedule
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/city-clerk-services/initiative-referendum-and-charter-amendment-guides"
        title="Main Menu Mobile — City Clerk Services Initiatives, Referenda, &amp; Charter Amendments Guides">
          Initiatives, Referenda, &amp; Charter Amendments Guides
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/city-clerk-services/initiative-referendum-and-charter-amendment-guides/initiative-petition-guide"
            title="Main Menu Mobile — Initiatives, Referenda, &amp; Charter Amendments Guides Initiative Petition Guide">
              Initiative Petition Guide
            </a>
          </li>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/city-clerk-services/initiative-referendum-and-charter-amendment-guides/referendum-guide"
            title="Main Menu Mobile — Initiatives, Referenda, &amp; Charter Amendments Guides Guide for Referendum Process">
              Guide for Referendum Process
            </a>
          </li>
          <li class="list-group-item navItem">
            <a href="https://www.seattle.gov/cityclerk/city-clerk-services/initiative-referendum-and-charter-amendment-guides/city-charter-amendment-petition-guide"
            title="Main Menu Mobile — Initiatives, Referenda, &amp; Charter Amendments Guides City Charter Amendment Petition Guide">
              City Charter Amendment Petition Guide
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </li>

  <li class="list-group-item navItem">
    <a href="https://www.seattle.gov/cityclerk/about" title="Main Menu Mobile — Home About the Office of the City Clerk">
      About the Office of the City Clerk <i class="bi bi-chevron-right"></i>
    </a>
    <ul>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/about/contact-us" title="Main Menu Mobile — About the Office of the City Clerk Contact Us">
          Contact Us
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/about/historical-perspective"
        title="Main Menu Mobile — About the Office of the City Clerk Historical Perspective of the Office of the City Clerk">
          Historical Perspective of the Office of the City Clerk
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/about/meet-the-city-clerk"
        title="Main Menu Mobile — About the Office of the City Clerk Meet the City Clerk">
          Meet the City Clerk
        </a>
      </li>
      <li class="list-group-item navItem">
        <a href="https://www.seattle.gov/cityclerk/about/vision-mission-and-values"
        title="Main Menu Mobile — About the Office of the City Clerk Vision, Mission, and Values">
          Vision, Mission, and Values
        </a>
      </li>
    </ul>
  </li>

  <li class="seagovHeaderLinksMobile list-group-item navItem">
    <a href="https://www.seattle.gov/services-and-information" title="Main Menu Mobile — Seattle.gov Services &amp; Information">
      Services &amp; Information
    </a>
  </li>
  <li class="seagovHeaderLinksMobile list-group-item navItem">
    <a href="https://www.seattle.gov/elected-officials" title="Main Menu Mobile — Seattle.gov Elected Officials">
      Elected Officials
    </a>
  </li>
  <li class="seagovHeaderLinksMobile list-group-item navItem">
    <a href="https://www.seattle.gov/city-departments-and-agencies" title="Main Menu Mobile — Seattle.gov Departments">
      Departments
    </a>
  </li>
  <li class="seagovHeaderLinksMobile list-group-item navItem">
    <a href="https://www.seattle.gov/visiting-seattle" title="Main Menu Mobile — Seattle.gov Visiting Seattle">
      Visiting Seattle
    </a>
  </li>
  <li class="seagovHeaderLinksMobile list-group-item navItem">
    <a href="https://news.seattle.gov" title="Main Menu Mobile — Seattle.gov News.Seattle.Gov">
      News.Seattle.Gov
    </a>
  </li>
  <li class="seagovHeaderLinksMobile list-group-item navItem">
    <a href="https://www.seattle.gov/event-calendar" title="Main Menu Mobile — Seattle.gov Event Calendar">
      Event Calendar
    </a>
  </li>
  <li class="list-group-item last"></li>
</ul>



<div class="titleTopNavBreadcrumbWrapper border-bottom border-black">
	<div class="container">

		<div class="deptTitle">
			<a href="https://www.seattle.gov/cityclerk" class="active">Office of the City Clerk</a>
			<span class="director">Scheereen Dedman, City Clerk</span>
		</div>

		<div id="deptTopNav" class="row justify-content-lg-between">

			<div class="left col-md-12 col-lg-auto deptBreadcrumbs d-none d-md-block">
				<br>
				<a href="https://www.seattle.gov" aria-label="home"><i class="bi bi-house-door-fill text-black"></i></a> /
				<a href="https://www.seattle.gov/cityclerk" class="text-black">Home</a>
				/ <a id="headerBreadcrumbLink" href="/" class="text-black">Online Information Resources</a>
			</div>

			<div class="right col-md-12 col-lg-auto deptBreadcrumbs d-none d-lg-block" style="margin-top: -33px !important; margin-right: -15px !important;">

				<ul class="list-inline list-unstyled mb-0 float-end">
					<li class="list-inline-item">
						<a href="https://www.seattle.gov/cityclerk/agendas-and-legislative-resources">City Council Agendas</a>
					</li>
					<li class="list-inline-item">
						<a href="https://www.seattle.gov/cityclerk/legislation-and-research" class="activePage">Legislation &amp; Research</a>
					</li>
					<li class="list-inline-item">
						<a href="https://www.seattle.gov/cityclerk/city-clerk-services">City Clerk Services</a>
					</li>
					<li class="list-inline-item">
						<a href="https://www.seattle.gov/cityclerk/about">About</a>
					</li>
					<li class="list-inline-item">
						<a href="https://www.seattle.gov/cityarchives" class="last">Seattle Municipal Archives</a>
					</li>
				</ul>
			</div>

		</div>

	</div>
</div>

<script>
  document.getElementById('openSlideMenuDesktop').addEventListener('click', function() {
    document.getElementById('seagovMenuDesktop').classList.toggle('slidemenu-open');
  });
  document.getElementById('closeSlideMenuDesktop').addEventListener('click', function() {
    document.getElementById('seagovMenuDesktop').classList.toggle('slidemenu-open');
  });
  document.getElementById('openSlideMenuMobile').addEventListener('click', function() {
    document.getElementById('seagovMenuMobile').classList.toggle('slidemenu-open');
  });
  document.getElementById('closeSlideMenuMobile').addEventListener('click', function() {
    document.getElementById('seagovMenuMobile').classList.toggle('slidemenu-open');
  });
</script>

<main <?= caGetPageCSSClasses(); ?>>

<?php
	if(strToLower($this->request->getController()) != "front"){
		print "<div class='container'>";
	}
	
