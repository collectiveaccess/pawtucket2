<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 ?>

<main data-barba="container" data-barba-namespace="about" class="barba-main-container about-section">
	<div class="general-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-auto">
					<h1 class="page-heading heading-size-1 ps-0">The No Boundaries Archive Project</h1>
					<p class="page-content mb-5">
						<span style="font-size: 30px; font-weight: 700;">Dancing the Visions of Contemporary Black Choreographers</span>
					</p>
					<p class="page-content">
						{{{about_page_text}}}
					</p>
				</div>
			</div>
 		</div>
	</div>
<?php
if(!$this->request->isLoggedIn() && (!Session::getVar('visited_time') || (Session::getVar('visited_time') < (time() - 86400)))){
	# --- display lightbox alert
	if(!CookieOptionsManager::showBanner()){
		Session::setVar('visited_time', time());
	}

?>
	<div class="frontAlert" onclick="$('.frontAlert').remove(); return false;">
		<div class="frontAlertBox">
			<div class="pull-right pointer frontAlertClose" onclick="$('.frontAlert').remove(); return false;">
				<span class="glyphicon glyphicon-remove-circle"></span>
			</div>
			<div class="frontAlertMessage">
				{{{entry_popup_message}}}

				<div class="btn-group enterButton" role="group" aria-label="buttons">
					<a href="#" class="btn btn-default" style="background-color: rgba(42, 10, 66, 1); color: #fff;">ENTER THE SPACE</a>
					<a href="#" class="btn btn-default" style="background-color: #fff ; color: #000 !important; border: 1px solid rgba(42, 10, 66, 1);">I'll come back later</a>
				</div>

			</div>	
		</div>
	</div>
<?php
 }
?>
</main>

