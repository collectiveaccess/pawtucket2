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
	$va_access_values = $this->getVar("access_values");
?>

<?php
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro_title || $vs_hp_intro){
?>
	<div class="hpIntro">
<?php
		if($vs_hp_intro){
			print $vs_hp_intro;
		}
?>
	</div>
<?php
	}
?>
		<H1>Explore the Collection</H1>
		<div class="frontList">
			<div class="row">
				<div class="col-sm-4"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'placeholder.png'), "", "", "Browse", "creators"); ?></div>
				<div class='col-sm-8'><label><?php print caNavLink($this->request, "Browse Creators", "", "", "Browse", "objects"); ?></label><span class='trimText'>{{{hp_creators_intro}}}</span></div>
			</div>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
			<div class="row">
				<div class="col-sm-4"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'placeholder.png'), "", "", "Browse", "objects"); ?></div>
				<div class='col-sm-8'><label><?php print caNavLink($this->request, "Browse Collection Items", "", "", "Browse", "objects"); ?></label><span class='trimText'>{{{hp_items_intro}}}</span></div>
			</div>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
		</div>
		