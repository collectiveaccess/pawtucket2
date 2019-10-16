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
 * hsftp://seth:@c//data/noguchi/themes/noguchi/views/pageFormat/pageHeader.phpttp://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
?><!DOCTYPE html>
<html lang="en-US" class="collective-access is-development" id="cahtmlWrapper"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <title><?php print MetaTagManager::getWindowTitle(); ?></title>
	    
	    <?php print MetaTagManager::getHTML(); ?>

        <!-- <link rel='stylesheet' id='style-all-0-css'  href='assets/css/style.css?ver=<?= rand(); ?>' type='text/css' media='all' />-->
        <script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/jquery-3.4.0.min.js?ver=<?= rand(); ?>'></script>
        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/libs-head-min.js?ver=<?= rand(); ?>'></script>
    </head>
    <body class="collective-access is-development" id="pawtucketApp" itemscope itemtype="http://schema.org/WebPage">
		<script type="text/javascript">
			let pawtucketUIApps = {};
		</script>
        <header class="placeholder">
            <div class="wrap">
                <div class="subheadline-bold-s">HEADER PLACEHOLDER <span style="display: inline-block; margin-left: 10px; font-weight: normal;">(<a class="no-barba" href="index.php" style="text-decoration: underline;">View Index</a>)</span></div>
            </div>
        </header>

        <div id="barba-wrapper">
            <div class="barba-container">
<!-- START From FOUO "logged in/out archive header" template -->
 <?php
 		# --- no header on CR landing
 		if((strToLower($this->request->getController()) != "cr") || ((strToLower($this->request->getController()) == "cr") && (strToLower($this->request->getAction()) != "index"))){
 ?>
                <section class="module_pageheader">

                    <div class="wrap text-align-center">
                        <h3 class="subheadline">
<?php
						switch(strToLower($this->request->getController())){
							case "archive":
							case "loginreg":
							case "archiveinfo":
								print caNavLink("Isamu Noguchi Archive", "", "", "Archive", "Index");
							break;
							# ---------------------------------------
							case "cr":
									print caNavLink("Isamu Noguchi Catalogue Raisonné", "", "", "CR", "Index");
							break;
							# ---------------------------------------
							case "detail":
								switch(strToLower($this->request->getAction())){
									case "archival":
										print caNavLink("Isamu Noguchi Archive", "", "", "Archive", "Index");
									break;
									# ---------------------------------------
									case "artwork":
										print caNavLink("Isamu Noguchi Catalogue Raisonné", "", "", "CR", "Index");
									break;
									# ---------------------------------------
									case "exhibition":
										print caNavLink("Exhibitions", "", "", "Browse", "exhibitions");
									break;
									# ---------------------------------------
									case "bibliography":
										print caNavLink("Bibliography", "", "", "Browse", "bibliography");
									break;
									# ---------------------------------------
								}
							break;
							# ---------------------------------------
							case "browse":
								switch(strToLower($this->request->getAction())){
									case "archive":
										print caNavLink("Isamu Noguchi Archive", "", "", "Archive", "Index");
									break;
									# ---------------------------------------
									case "cr":
										print caNavLink("Isamu Noguchi Catalogue Raisonné", "", "", "CR", "Index");
									break;
									# ---------------------------------------
									case "exhibitions":
											print caNavLink("Exhibitions", "", "", "Browse", "exhibitions");
									break;
									# ---------------------------------------
									case "bibliography":
											print caNavLink("Bibliography", "", "", "Browse", "bibliography");
									break;
									# ---------------------------------------
								}
							break;
							# ---------------------------------------
						}
?>
                        </h3>
<?php
		$vb_show_user_menu = false;
		switch(strToLower($this->request->getController())){
			case "archive":
			case "loginreg":
			case "archiveinfo":
				$vb_show_user_menu = true;
			break;
			# -----------------------------------------
			case "browse":
				if(strToLower($this->request->getAction()) == 'archive'){
					$vb_show_user_menu = true;
				}
			break;
			# -----------------------------------------
			case "detail":
				if(strToLower($this->request->getAction()) == 'archival'){
					$vb_show_user_menu = true;
				}
			break;
			# -----------------------------------------
		}
		if($vb_show_user_menu){
			if($this->request->isLoggedIn()) { 
?>
					<div class="utility utility_menu hide-for-mobile">
						<a href="#" class="trigger"><?php print $this->request->user->get("fname")." ".$this->request->user->get("lname"); ?></a>
						<div class="options">
<?php
							print caNavLink("Profile", "", "", "LoginReg", "profileForm");
							print "<a href='#'>My Documents</a>";
							#print caNavLink("My Documents", "", "", "Lightbox", "Index");
							print caNavLink("Logout", "", "", "LoginReg", "logout");
?>
						</div>
					</div>
<?php
			} else {
?>
					 <div class="utility hide-for-mobile">
<?php
						print caNavLink("Researcher Login", "trigger", "", "LoginReg", "loginForm");
?>
					</div>
<?php
			}

		}
?>                     
                    </div>
                </section>
<?php
		}
?>  
<!-- END -->