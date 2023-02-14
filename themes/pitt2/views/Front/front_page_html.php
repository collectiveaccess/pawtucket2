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
	<div class="row">
		<div class="col-sm-12"><div class="hpIntro">
<?php
		if($vs_hp_intro){
			print $vs_hp_intro;
		}
?>
	</div></div></div>
<?php
	}
?>
		<div class="heroSearch">
			<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" id="heroSearchInput" placeholder="<?php print _t("Search the Collection"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
					</div>
					<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
				</div>
			</form>
			<div class="hpAdvancedSearch"><?php print caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>
		</div>

		<H1>Explore the Collection</H1>
		<div class="frontList">
			<div class="row">
				<div class='col-sm-12'><label><?php print caNavLink($this->request, "Creators", "", "", "Browse", "creators"); ?></label><p>{{{hp_creators_intro}}}</p>
					<div><?php print caNavLink($this->request, "Browse Creators", "btn btn-default", "", "Browse", "creators"); ?></div>
				</div>
			</div>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
			<div class="row">
				<div class='col-sm-12'><label><?php print caNavLink($this->request, "Objects", "", "", "Browse", "objects"); ?></label><p>{{{hp_items_intro}}}</p>
					<div><?php print caNavLink($this->request, "Browse Objects", "btn btn-default", "", "Browse", "objects"); ?></div>
				</div>
			</div>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
		</div>
		