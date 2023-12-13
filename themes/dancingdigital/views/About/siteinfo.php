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
<main data-barba="container" data-barba-namespace="siteinfo" class="barba-main-container ourstory-section">
	<div class="general-page">
		<div class="container">
			<div class="row justify-content-center">
				<h1 class="page-heading heading-size-2 ps-0">Site Information</h1>
				<div class="col-auto">
					<p class="page-content content-size-2">
						{{{funders}}}
						<br><br>
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'ut_austin_logo.png', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner")), "funder-logo", "", "",""); ?>
						<br><br>
						{{{accessibility_statement}}}
					</p>					
				</div> 
			</div>
		</div>
	</div>
</main>