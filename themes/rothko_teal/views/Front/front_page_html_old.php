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
 		$o_config = $this->getVar("config");
		$vs_set_code = $o_config->get("front_page_set_code");
		$t_set = new ca_sets();
 		$t_set->load(array('set_code' => 'homepage'));
 		$va_access_values = caGetUserAccessValues($this->request);
 		$vn_homepage_ids = array_keys($t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1)));
		$t_home_object = new ca_objects($vn_homepage_ids[0]);
?>
<div class="frontBanner">
<?php
	if ($t_home_object) {
		print $t_home_object->get('ca_objects.homepage_media', array('version' => 'original'));
		print "<div class='pageTitle'><div class='lineOne'>Mark Rothko</div>";
		print "<div class='lineTwo'>Works on Paper</div>";
		print "<div class='lineThree'>National Gallery of Art, Washington</div></div>";
		print "<div class='workCaption'>Detail, ".caNavLink($this->request, $t_home_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$t_home_object->get('ca_objects.object_id'))."<br/>".$t_home_object->get('ca_objects.display_date')."</div>";
		print "<div class='moreInfo'><a href='#' onclick='$(\".expandedFrontBanner\").slideDown(300);$(\"html, body\").animate({ scrollTop: $(document).height() }, \"slow\"); return false;'>".caGetThemeGraphic($this->request, 'arrow-bottom.png')."</a></div>";
	}
?>
</div> <!--end frontBanner-->
<div class="expandedFrontBanner">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<?php print caGetThemeGraphic($this->request, 'canvas.jpg'); ?>
			</div>
			<div class="col-sm-6">
				The National Gallery of Art maintains the largest public collection of work by the American artist Mark Rothko (1903-1970).  Beginning with the nation's collection, Mark Rothko: Works on Paper will document some 2,600 drawings, watercolors, and paintings on paper in public and private collections worldwide.
			</div>
			<div class="col-sm-3">
				<div class='homeTitle'>National Gallery of Art</div>
				<div class='copyright'>© 2018 National Gallery of Art, Washington</div>
				<div class="homeLinks">
					<div class="footerLink"><?php print caNavLink($this->request, 'About', '', '', 'About', 'project');?></div> | 
					<div class="footerLink space"><?php print caNavLink($this->request, ' Credits', '', '', 'About', 'credits'); ?></div> | 
					<div class="footerLink space"><?php print caNavLink($this->request, ' Notices', '', '', 'About', 'notices'); ?></div> | 
					<div class="footerLink space"><?php print caNavLink($this->request, ' Contact', '', '', 'About', 'contact'); ?></div><br/>
					<!--<div class="socialLink"><a href="http://www.facebook.com"><i class="fab fa-facebook-f"></i></a></div>
					<div class="socialLink"><a href="http://www.twitter.com"><i class="fab fa-twitter"></i></a></div>-->
				</div>				
			</div>
		</div>
	</div>
</div>