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
?>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="row">
				<div class="col-sm-12">
					<h3>Search the Manuscript Collection</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'manuscripts/view/list'); ?>">
						<div class="formOutline">
							<div class="row">
								<div class="col-xs-12 col-sm-9">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Manuscript Search" name="search">
									</div>
								</div>
								<div class="col-xs-12 col-sm-3 text-right">
									<button type="submit" class="btn-landing btn-lg">SEARCH</button>
									<?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<hr/>
			<div class="row homeSubRow">
				<div class="col-sm-12 text-center">
					<h2><?php print caNavLink($this->request, _t("Browse the Manuscript Collection"), '', '', 'Browse', 'manuscripts', array('view' => 'list')); ?></h2>
					<h2>OR</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 text-center">
					<h3>Browse by Map</h3>
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'mcs_map_browse.jpg', array('class' => 'img-responsive')), '', '', 'Browse', 'manuscripts/view/map'); ?>
				</div>
				<div class="col-sm-6 text-center">
					<h3>Browse by Timeline</h3> 
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'mcs_timeline_browse.jpg', array('class' => 'img-responsive')), '', '', 'Browse', 'manuscripts/view/timeline'); ?>
				</div>
			</div>
		</div>
	</div>
</div> <!--end container-->
