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
	<div class="row"><span class="skip"><a href="#contentinfo">Skip to contentinfo</a></span>
		<div class="col-sm-12">
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
		</div> <!--end col-sm-6-->	
	</div><!-- end row -->
	
<HR/>
	<div class="row goldbg">
		<div class=col-sm-12 col-md-11 col-md-offset-1 col-lg-11 col-lg-offset-1">
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
			incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
			ullamco laboris nisi ut aliquip ex ea commodo consequat.  </h2>
		</div>
	</div>
	</div>
<HR/>
	<div class="row" role="contentinfo" id="contentinfo">
		<div class="col-sm-12">
			<H2>Participating Institutions</H2>
<?php
		$va_institutions = array(
			array("name" => "Colorado Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_cu_logo2.jpg', array("alt" => "Colorado University Logo"))),
			array("name" => "National Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_nmnh_logo.jpg', array("alt" => "Smithsonian Institution Logo"))),
			array("name" => "Museum of Comparative Zoology, Harvard University", "graphic" => caGetThemeGraphic($this->request, 'hp_harvard_logo.jpg', array("alt" => "Harvard University Logo"))),
			array("name" => "Yale Peabody Museum of Natural History", "graphic" => caGetThemeGraphic($this->request, 'hp_yale_logo.jpg', array("alt" => "Yale University Logo"))),
			array("name" => "Institution Name Placeholder", "graphic" => caGetThemeGraphic($this->request, 'placeholder-square.jpg', array("alt" => "Placeholder Logo"))),
			array("name" => "Institution Name Placeholder", "graphic" => caGetThemeGraphic($this->request, 'placeholder-square.jpg', array("alt" => "Placeholder Logo"))),
			array("name" => "Institution Name Placeholder", "graphic" => caGetThemeGraphic($this->request, 'placeholder-square.jpg', array("alt" => "Placeholder Logo")))

		);
?>		
<?php foreach ($va_institutions as $item) {
                echo '<div class="col-md-3 col-lg-3">';
                echo '<p class="text-center">';
				echo $item["graphic"] ."<br />";
				echo $item["name"] ."<br />";
				echo '</p>';
				echo '</div>';
}
?>
		</div>
	</div>
</div>
