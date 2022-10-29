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
 	<div class="row">
		<div class="col-sm-12">
			<div class="hpHero">
				<?php print caGetThemeGraphic($this->request, 'home.jpg'); ?>
				<form class="hpSearch" role="search" action="/index.php/MultiSearch/Index">
					<H1>Welcome to the<br/>Hampstead Garden Suburb Heritage<br/>Virtual Museum</H1>
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="hpSearchbtn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
	    
		<div class="col-xs-6 col-sm-3">
			<div class="hpButton">
				<?php print caNavLink($this->request, "Main entrance <i class='fa fa-hand-o-right' aria-hidden='true'></i>", "", "", "Front", "intro"); ?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-3">
			<div class="hpButton">
				<?php print caNavLink($this->request, "<i class='fa fa-clock-o' aria-hidden='true'></i> Timelines", "", "", "Browse", "events"); ?>
			</div>
		</div>	
		<div class="col-xs-6 col-sm-3">
			<div class="hpButton">
				<?php print caNavLink($this->request, "<i class='fa fa-map-marker' aria-hidden='true'></i> Maps", "", "", "Browse", "places"); ?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-3">
            <div class="hpButton">
            	<a href="https://twitter.com/HGSheritage1" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a>
            </div>
        </div>
	</div><!-- end row -->
