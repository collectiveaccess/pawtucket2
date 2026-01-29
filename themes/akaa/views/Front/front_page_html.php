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
		#print $this->render("Front/featured_set_slideshow_html.php");
	$hero = $this->request->getParameter("hero", pString);
	if(!$hero){
 		$hero = rand(1, 3);
	}

?>
<div class="frontHero">
	<?php print caGetThemeGraphic($this->request, 'hero_'.$hero.'.jpg'); ?>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
			<H1>{{{hp_intro}}}</H1>
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->
</div> <!--end container-->
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">
		
			<div class="bgLightGray frontContentBlock">
				<div class="row vertAlignRow">
					<div class="col-sm-12 col-md-6">
						<div class="frontContentBlockText">
							<H2>Lorem ipsum</H2>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
					</div>
					<div class="col-sm-12 col-md-6 fullWidth">
						<?php print caGetThemeGraphic($this->request, 'hero_1.jpg'); ?>
					</div>
				</div>
			</div>
			<div class="bgLightGray frontContentBlock">
				<div class="row vertAlignRow">
					<div class="col-sm-12 col-md-6 fullWidth">
						<?php print caGetThemeGraphic($this->request, 'hero_2.jpg'); ?>
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="frontContentBlockText">
							<H2>Lorem ipsum</H2>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
					</div>
				</div>
			</div>
			<div class="bgLightGray frontContentBlock">
				<div class="row vertAlignRow">
					<div class="col-sm-12 col-md-6">
						<div class="frontContentBlockText">
							<H2>Lorem ipsum</H2>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
					</div>
					<div class="col-sm-12 col-md-6 fullWidth">
						<?php print caGetThemeGraphic($this->request, 'hero_3.jpg'); ?>
					</div>
				</div>
			</div>		
		</div>
	</div>
</div>