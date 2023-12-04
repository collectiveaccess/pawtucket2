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
 
 $t_set = ca_sets::findAsInstance(['set_code' => 'performances'], ['checkAccess' => caGetUserAccessValues($this->request)]);
 $set_items = $t_set ? $t_set->getItems(['thumbnailVersion' => 'thumbnail']) : [];
 ?>
<main data-barba="container" data-barba-namespace="performances" class="barba-main-container performances-section">
	<div class="general-page">
		<div class="container">
			<div class="row justify-content-center">
				<h1 class="page-heading heading-size-2 ps-0">Performances</h1>
				<div class="col-auto">
					<p class="page-content content-size-2">
						<?= $t_set->get('ca_sets.set_description'); ?>
					</p>
<?php
	foreach($set_items as $item) {	
		$item = array_shift($item);
		// print_R($item);
?>			
					<div class="performances-links mt-4">
						<?= $item['representation_tag']; ?>
						<?= caDetailLink($this->request, '<svg xmlns="http://www.w3.org/2000/svg" width="34" height="33" viewBox="0 0 34 33" fill="none">
								<path d="M33.0163 16.5C33.0163 25.3173 25.7498 32.4794 16.7684 32.4794C7.78704 32.4794 0.520588 25.3173 0.520588 16.5C0.520588 7.6827 7.78704 0.520588 16.7684 0.520588C25.7498 0.520588 33.0163 7.6827 33.0163 16.5Z" stroke="#E2D49F" stroke-width="1.04118"></path>
								<path d="M24.728 16.3281L12.5267 23.2597L12.5267 9.39643L24.728 16.3281Z" fill="#E2D49F"></path>
							</svg>', 'me-3', 'ca_objects', $item['row_id']); ?>
						<?= caDetailLink($this->request, $item['name'], 'link-text', 'ca_objects', $item['row_id']); ?>
					</div>
<?php
	}
?>
				</div> 
			</div>
		</div>
	</div>
</main>