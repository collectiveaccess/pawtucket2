<?php
/* ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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
$vs_search = (string)$this->getVar('search');
$action = "http://sva.whirl-i-gig.com:8085/index.php/Browse/exhibitions/search/${vs_search}";

$vs_full_link = caNavLink('', '', '', 'Browse', '', array('search' => str_replace("/", "", $vs_search)));

// echo $vs_full_link;

?><!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width , initial-scale=1" />
    <script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <title><?= MetaTagManager::getWindowTitle(); ?></title>
  </head>

<body id="pawtucketApp">
    <script type="text/javascript">
        let pawtucketUIApps = {};
    </script>
    
    <!-- BEGIN Modal for mobile use -->
	<div class="modal fade tablet-mobile-menu" id="modalContent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document" >
		  <div class="modal-content" >
			<div class="modal-header" >
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>

			<div class="modal-body">
			  <ul class="p-0">
				<div class="dropdown-divider"></div>
				<li><a class="dropdown-item" href="/index.php/DirectoryBrowse/People" > Browse All By People</a></li>
				<div class="dropdown-divider"></div>
				<li><a class="dropdown-item" href="/index.php/DirectoryBrowse/Exhibitions" > Browse All By Exhibitions</a></li>
				<div class="dropdown-divider"></div>
				<li><a class="dropdown-item" href="/index.php/DirectoryBrowse/Dates" >Browse All By Dates</a></li>
				<div class="dropdown-divider"></div>
			  </ul>
  
			  <form class="d-flex" action="http://sva.whirl-i-gig.com:8085/index.php/MultiSearch/Index" method="get">
					<input class="form-control search-input rounded-0" type="search" name="search" placeholder="Enter Your Query" aria-label="Search" >
					<button class="btn btn-sm rounded-0 d-flex search-button " type="submit">
						<p class='mb-1 pt-1 ml-1 desktop-menu'>SEARCH</p>
						<span class="material-icons search-icon ml-1 mb-1 pt-1 ">search</span>
					</button>
			  </form>
			</div><!-- modal-body -->

		  </div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div> <!-- modal -->
	
    <!-- END Model --> 
    
    <!-- BEGIN Navbar --> 
	<div class="container-fluid header-container">
		<div class="row header-row">
			<div id="mediaDisplayFullscreen" class="mediaDisplayFullscreen">
				<!-- Used by MediaViewer.js React app -->
			</div>

			<nav class="navbar navbar-expand-lg navbar-light main-nav">

			  <a class="navbar-brand main-logo" href="/index.php/">SVA Exhibitions Archive</a>

			  <button class="navbar-toggler mb-1 mt-1" type="button" data-toggle="modal" data-target="#modalContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
			  </button>

			  <fieldset class="collapse navbar-collapse justify-content-end" id='navbarSupportedContent'>
						<label class='mb-0 mr-1 desktop-menu dropdown-label' for="browseAllBy">BROWSE ALL BY</label>
						<ul class="navbar-nav browse-dropdown desktop-menu mr-2" id="browseAllBy">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">	Select an Option</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="/index.php/DirectoryBrowse/People" role="button" aria-labelledby="browseByPeople">People</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="/index.php/DirectoryBrowse/Exhibitions" role="button" aria-labelledby="browseByExhibitions">Exhibitions</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="/index.php/DirectoryBrowse/Dates" role="button" aria-labelledby="browseByDates">Dates</a>
								</div>
							</li>
						</ul>

						<form class="form-inline d-flex desktop-menu" method="get" action="/index.php/Browse/Exhibitions" >
							<input class="form-control search-input rounded-0 desktop-menu" type="search" name="search" placeholder="Enter Your Query" aria-label="Enter Your Query">
							<button class="btn btn-sm rounded-0 d-flex search-button desktop-menu" type="submit">
								<p class='mb-0 ml-1 desktop-menu'>SEARCH</p>
								<span class="material-icons search-icon ml-1 mb-1 pt-1 desktop-menu">search</span>
							</button>
						</form>
			  </fieldset>

			</nav>
		</div><!-- row -->
	</div><!-- container-fluid -->
    <!-- END Navbar --> 

