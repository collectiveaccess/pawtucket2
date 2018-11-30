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
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 text-center">
		<h1>Manuscript Cookbook Survey</h1>
		<p>The Manuscript Cookbook Survey is the first ever search portal for unpublished cookbooks and recipes as well as kitchen utensil collections from institutions across the United States. By providing access to these historical documents and artifacts here, we can trace the development of techniques, recipes, ideas, ingredients and more all at once, instead of piecemeal across dozens of individual collections.</p>
		<div class="row frontSpacingBox">
			<div class="col-sm-6 frontPageBorder text-center">
				<h2>Kitchen Artifacts<br/><?php print caNavLink($this->request, _t("Search Kitchen Artifacts"), '', 'Search', 'advanced', 'utensils'); ?></h2>
			</div><!--end col-sm-6-->
			<div class="col-sm-6 text-center">
				<h2>Manuscripts<br/><?php print caNavLink($this->request, _t("Search Manuscripts"), '', 'Search', 'advanced', 'manuscripts'); ?></h2>
			</div> <!--end col-sm-4-->	
		</div>
		</div>
	</div><!-- end row -->
</div> <!--end container-->
