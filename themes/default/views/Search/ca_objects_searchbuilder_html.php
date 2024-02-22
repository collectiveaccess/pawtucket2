<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_objects_searchbuilder_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */ 
$vo_result 				= $this->getVar('result');
$vo_result_context 		= $this->getVar('result_context');
 	
 if(!$this->request->isAjax()) {
 ?>
<div class="row">
	<div class="col-sm-8">
		<h1><?php _p('Search Builder') ?></h1>
		<div class="searchBuilderContainer">
			<?= $this->render('Search/search_builder_controls_html.php'); ?>
			<div id="searchBuilder"></div>
			<div class="searchBuilderSubmit text-center">
				<?= caFormSearchButton($this->request, __CA_NAV_ICON_SEARCH__, _t("Search"), 'SearchBuilderForm'); ?>
			</div>
		</div>
	</div>
</div>
<?php	
}
