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
 		$t_set->load(array('set_code' => $vs_set_code));
		print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
<?php
		if ($va_set_introduction = $t_set->get('ca_sets.set_description')){
			print "<div style='margin-top:30px;'><p>".$va_set_introduction."</p></div>";
		}
?>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class='homeDiv'>
			<h3><?php print caNavLink($this->request, 'Artist', '', '', 'About', 'Index'); ?></h3>
<?php
			print caNavLink($this->request, caGetThemeGraphic($this->request, 'artist.jpg'), '', '', 'About', 'Index');
?>
			</div>			
		</div><!--end col-sm-8-->
		<div class="col-sm-6">
			<div class='homeDiv'>
			<h3><?php print caNavLink($this->request, 'Commentary', '', '', 'About', 'Index'); ?></h3>
<?php
			print caNavLink($this->request, caGetThemeGraphic($this->request, 'commentary.jpg'), '', '', 'About', 'Index');
?>
			</div>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->