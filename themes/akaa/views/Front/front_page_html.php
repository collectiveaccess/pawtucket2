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
	# --- display galleries as a grid?
	print $this->render("Front/featured_set_slideshow_html.php");

?>
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
							<H2><?php print caNavLink($this->request, $this->getVar("hp_block1_title"), "", "", "About", ""); ?></H2>
							{{{hp_block1_text}}}
						</div>
					</div>
					<div class="col-sm-12 col-md-6 fullWidth">
						<?php print caGetThemeGraphic($this->request, '1Intro.jpg'); ?>
					</div>
				</div>
			</div>
			<div class="bgLightGray frontContentBlock">
				<div class="row vertAlignRow">
					<div class="col-sm-12 col-md-6 fullWidth">
						<?php print caGetThemeGraphic($this->request, '2BrowseOur-Collection.jpg'); ?>
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="frontContentBlockText">
							<H2><?php print caNavLink($this->request, $this->getVar("hp_block2_title"), "", "", "Browse", "akaa_collection"); ?></H2>
							{{{hp_block2_text}}}
						</div>
					</div>
				</div>
			</div>
			<div class="bgLightGray frontContentBlock">
				<div class="row vertAlignRow">
					<div class="col-sm-12 col-md-6">
						<div class="frontContentBlockText">
							<H2><?php print caNavLink($this->request, $this->getVar("hp_block3_title"), "", "", "Listing", "interviews"); ?></H2>
							{{{hp_block3_text}}}
						</div>
					</div>
					<div class="col-sm-12 col-md-6 fullWidth">
						<?php print caGetThemeGraphic($this->request, '3Interview.jpg'); ?>
					</div>
				</div>
			</div>		
		</div>
	</div>
</div>