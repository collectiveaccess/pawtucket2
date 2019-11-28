<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link rel="apple-touch-icon" sizes="180x180" href="https://ansm.ns.ca/_img/ansm/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="https://ansm.ns.ca/_img/ansm/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="https://ansm.ns.ca/_img/ansm/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="https://ansm.ns.ca/_img/ansm/favicons/manifest.json">
        <link rel="mask-icon" href="https://ansm.ns.ca/_img/ansm/favicons/safari-pinned-tab.svg" color="#0099d8">
        <link rel="shortcut icon" href="https://ansm.ns.ca/_img/ansm/favicons/favicon.ico">
        <meta name="msapplication-config" content="https://ansm.ns.ca/_img/ansm/favicons/browserconfig.xml">
        <meta name="apple-mobile-web-app-title" content="Association of Nova Scotia Museums (ANSM)">
        <meta name="application-name" content="Association of Nova Scotia Museums (ANSM)">
        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" href="https://ansm.ns.ca/_css/main-v3.css">
        <link rel="stylesheet" href="/">
</head>
<body id="body-reference-library" class="web">

    <header class="container-fluid bg-branding">
        <div class="container">
          <div class="hidden-lg-up">
          <!-- <img src="_img/ansm-logo.svg" class="img-fluid" style="width:200px;background-color: white;"> -->
        <!--<button type="button" class="btn btn-secondary" data-toggle="offcanvas"> <span class="fa fa-bars fa-lg"></span></button>-->
        </div>
        <div class="float-xs-right hidden-md-down">
        <ul class="social list-inline">
        <li class="facebook list-inline-item"><a href="https://www.facebook.com/AssociationNSMuseums/" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Association of Nova Scotia Museums on Facebook"><img alt="Facebook link" title="Association of Nova Scotia Museums on Facebook" src="https://ansm.ns.ca/_img/icons/facebook-white.svg"></a></li>
        <li class="blogger list-inline-item"><a href="http://passagemuseums.blogspot.ca" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Museums Nova Scotia Blog"><img alt="Blogspot link" title="Museums Nova Scotia Blog" src="https://ansm.ns.ca/_img/icons/blogger2-white.svg"></a></li>
        </ul>
         <form class="form-inline" id="search_form" action="https://ansm.ns.ca/search-results.html" method="get">
          <fieldset>
            <div class="input-group input-group-sm">
              <input type="text" class="form-control" id="search" placeholder="Search" name="search" value="">
              <span class="input-group-btn">
                <button class="btn btn-outline-secondary" type="submit"><span class="fa fa-search"></span></button>
              </span>
              <input type="hidden" name="id" value="25" /> 
            </div>
          </fieldset>
        </form>
        </div>
        </div>
    </header>
    <main><div class="container"><div class="row">
        <div class="sidebar sidebar-left col-12 col-xs-12 col-lg-4">
        <div class="row components">

        <div class="contentblock sidebar-main component col-xs-12">
        <div class="row component-items">
        <div class="contentblock logo col-xs-12">
        <div class="block-content"><a href="https://ansm.ns.ca" title="The Association of Nova Scotia Museums">
        <img src="https://ansm.ns.ca/_img/ansm-logo.svg" class="img-fluid" alt="ANSM Homepage">
        </a></div> <!-- /.block-content -->
        </div> <!-- /.contentblock.logo -->

        <div class="contentblock main-menu col-xs-12">
        <div class="block-content">
            <ul class="nav outer"><li class="nav-item outer first"><a class="nav-link first" href="https://ansm.ns.ca/programs.html" >Programs</a><ul class="nav inner"><li class="nav-item first"><a class="nav-link first" href="https://ansm.ns.ca/advisory-services.html" >Advisory Services</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/novamuse.html" >NovaMuse</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/museum-evaluation-program.html" >Museum Evaluation Program</a></li><li class="nav-item last"><a class="nav-link last" href="https://ansm.ns.ca/awards.html" >Awards</a></li></ul></li><li class="nav-item outer "><a class="nav-link " href="https://ansm.ns.ca/members.html" >Members</a><ul class="nav inner"><li class="nav-item first"><a class="nav-link first" href="https://ansm.ns.ca/member-museums.html" >Member Museums</a></li><li class="nav-item last"><a class="nav-link last" href="https://ansm.ns.ca/become-a-member.html" >Become a Member</a></li></ul></li><li class="nav-item outer active"><a class="nav-link active" href="https://ansm.ns.ca/learning.html" >Learning</a><ul class="nav inner"><li class="nav-item first"><a class="nav-link first" href="https://ansm.ns.ca/museum-studies.html" >Museum Studies Program</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/workshops.html" >Workshops</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/symposiums-and-conferences.html" >Symposiums & Conferences</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/registration.html" >Registration Information</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/resources.html" >Resources</a></li><li class="nav-item last active"><a class="nav-link last active" href="#" >Reference Library</a></li></ul></li><li class="nav-item outer "><a class="nav-link " href="https://ansm.ns.ca/beacon.html" >The Beacon</a></li><li class="nav-item outer "><a class="nav-link " href="https://ansm.ns.ca/news-and-events.html" >News & Events</a><ul class="nav inner"><li class="nav-item first"><a class="nav-link first" href="https://ansm.ns.ca/news.html" >News</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/events.html" >Upcoming Events</a></li><li class="nav-item last"><a class="nav-link last" href="https://ansm.ns.ca/previous-events.html" >Previous Events</a></li></ul></li><li class="nav-item outer "><a class="nav-link " href="https://ansm.ns.ca/about.html" >About Us</a><ul class="nav inner"><li class="nav-item first"><a class="nav-link first" href="https://ansm.ns.ca/governance.html" >Governance</a></li><li class="nav-item "><a class="nav-link " href="https://ansm.ns.ca/who.html" >Staff</a></li><li class="nav-item last"><a class="nav-link last" href="https://ansm.ns.ca/advocacy.html" >Advocacy</a></li></ul></li><li class="nav-item outer last"><a class="nav-link last" href="https://ansm.ns.ca/contact.html" >Contact</a></li></ul></div> <!-- /.block-content -->
        </div> <!-- /.contentblock.main-menu -->

        <div class="contentblock news-and-events-sidebar hidden-xs hidden-sm hidden-md col-lg-12">
        <div class="row component-items">
        <!-- .catalog.news-catalog -->
        <div class="component news-catalog col-xs-12">
        </div>  <!-- /.catalog. --></div> <!-- /.row.component-items -->
        </div> <!-- /.contentblock.news-and-events-sidebar -->

        <div class="contentblock sidebar-logos col-xs-12" style="padding-top: 20px; width: 90%;">
        <div class="block-content"><a href="http://novamuse.ca" target="_blank"><img alt="NovaMuse website" class="img-fluid" height="130" src="https://ansm.ns.ca/Documents/Design/Logos/novamuse_logo.png" width="199" /></a>

        <hr />
        <p>ANSM services and programs are made possible with support from the Department of Communities, Culture &amp; Heritage.</p>
        <a href="https://cch.novascotia.ca/"><img alt="Nova Scotia Communities, Culture and Heritage" class="img-fluid" height="108" src="https://ansm.ns.ca/Documents/Design/Logos/CommCulHerit_Fulcol.jpg" style="float:left" width="422" /></a></div> <!-- /.block-content -->
        </div> <!-- /.contentblock.sidebar-logos -->
        </div> <!-- /.row.component-items -->
        </div> <!-- /.contentblock.sidebar-main -->

        </div> <!-- /.row.components -->
        </div>  <!-- /.sidebar.sidebar-left -->
        <div class="primary-content col-12 col-xs-12 col-lg-8">
        <div id="components-top" class="row components">

        <!-- .catalog.reference-library -->
        <div class="component reference-libraryimageblock-current-page col-xs-12">
        <div class="row catalog">
        <div class="catalog-item reference-library col-xs-12">
        <div class="card" style="padding-top:0; border-top:0;"><div class="imageblock reference-library" style="padding-bottom:52.053712480253%">