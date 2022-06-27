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
 
	require_once(__CA_MODELS_DIR__."/ca_item_comments.php");
	$t_item_comments = new ca_item_comments();
	$va_comments = $t_item_comments->getCommentsList("moderated");
	$va_access_values = $this->getVar("access_values");
?>
<div role="main" id="main">
	<div class="row">
		<div class="col-sm-12">
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
		</div> <!--end col-sm-6-->	
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12">
			<HR/>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3 twitterCol">
			<h2>Tweets <small>by <a href="https://twitter.com/PaleoDigAtlas" target="blank">@PaleoDigAtlas</a></small></h2>
			<a class="twitter-timeline" data-height="500" data-dnt="true" data-link-color="#2a6496" href="https://twitter.com/PaleoDigAtlas" data-chrome="noheader nofooter">Tweets by PaleoDigAtlas</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
		<div class="col-sm-9">
			<H2>Participating Institutions</H2>
			<div class="row">
				<div class="col-sm-3 text-center">
					<?php print caGetThemeGraphic($this->request, 'cw_amnh_logo.png', array("alt" => "Smithsonian Institution Logo"), ['class' => 'inst_img']) ?>
					<p>American Museum of Natural History</p>
				</div>
				<div class="col-sm-3 text-center">
					<?php print caGetThemeGraphic($this->request, 'cw_ku_logo.png', array("alt" => "University of Kansas Logo"), ['class' => 'inst_img']) ?>
					<p>University of Kansas Natural History Museum</p>
				</div>
				<div class="col-sm-3 text-center">
					<?php print caGetThemeGraphic($this->request, 'cw_sdsm_logo.png', array("alt" => "South Dakota School of Mines Logo"), ['class' => 'inst_img']) ?>
					<p>South Dakota School of Mines</p>
				</div>
				<div class="col-sm-3 text-center">
					<?php print caGetThemeGraphic($this->request, 'cw_ut_logo.png', array("alt" => "University of Texas Logo"), ['class' => 'inst_img']) ?>
					<p>University of Texas - Austin</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3 text-center">
					<?php print caGetThemeGraphic($this->request, 'hp_yale_logo.jpg', array("alt" => "Yale University Logo"), ['class' => 'inst_img']) ?>
					<p>Yale Peabody Museum of Natural History</p>
				</div>
			</div>
			<div class="row">
				
				<div class="col-sm-3 text-center">
				
				</div>
				<div class="col-sm-3 text-center">
				
				</div>
			</div>
		</div>
	</div>
	</div>
