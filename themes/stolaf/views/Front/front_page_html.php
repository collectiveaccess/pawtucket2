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
	<div class="row hpTiles">
		<div class="col-sm-4">
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp1.jpg'), "", "", "Browse","Collections")."<br/>";
				print caNavLink($this->request, "Browse Collections", "btn btn-default", "", "Browse","Collections")
?>
		</div>
		<div class="col-sm-4">
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp3.jpg'), "", "", "Browse","objects")."<br/>";
				print caNavLink($this->request, "Browse Archival Items", "btn btn-default", "", "Browse","objects")
?>
		</div>
		<div class="col-sm-4">
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'hp2.jpg'), "", "", "Contact","form")."<br/>";
				print caNavLink($this->request, "Contact Us", "btn btn-default", "", "Contact","form")
?>
		</div>

	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="hpCallout">{{{FrontWelcome}}}</div>
		</div><!--end col-sm-8-->
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			{{{FrontAbout}}}
		</div><!--end col-sm-8-->
	</div>
	<div class="row">
		<div class="col-sm-12">
<?php
		print $this->render("Front/gallery_slideshow_html.php");
?>
		</div>
	</div>