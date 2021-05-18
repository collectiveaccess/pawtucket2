<?php
/* ----------------------------------------------------------------------
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
?><!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width , initial-scale=1" />
    <script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <title>SVA 2</title>
  </head>

<body id="pawtucketApp" >
    <script type="text/javascript">
        let pawtucketUIApps = {};
    </script>
    
  <div class="container-fluid header-container">
    <div class="row header-row">
    <div id="mediaDisplayFullscreen" class="mediaDisplayFullscreen">
		<!-- Used by MediaViewer.js React app -->
	</div>

    <nav class="navbar navbar-expand-lg navbar-light main-nav">
      <a class="navbar-brand main-logo" href="/index.php/">SVA Exhibitions Archive</a>

      <button class="navbar-toggler mb-1" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">

        <ul class="navbar-nav browse-dropdown">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Browse All By
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/index.php/DirectoryBrowse/People">People</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/index.php/DirectoryBrowse/Exhibitions">Exhibitions</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/index.php/DirectoryBrowse/Dates">Dates</a>
            </div>
          </li>
        </ul>

        <!-- action="http://sva.whirl-i-gig.com:8085/index.php/MultiSearch/Index?search=" -->

        <form class="form-inline" action="http://sva.whirl-i-gig.com:8085/index.php/MultiSearch/Index" method="get">
          <input class="form-control search-input rounded-0" type="search" name="search" id="search" placeholder="Search Artists and Exhibitions" aria-label="Search">
          <button class="btn btn-sm rounded-0" type="submit"><span class="material-icons search-icon">search</span></button>
        </form>
      </div>
    </nav>

    </div>
  </div>

