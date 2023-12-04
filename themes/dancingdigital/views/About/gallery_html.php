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
 $t_set = ca_sets::findAsInstance(['set_code' => 'gallery'], ['checkAccess' => caGetUserAccessValues($this->request)]);
 $set_items = $t_set ? $t_set->getItems(['thumbnailVersion' => 'small']) : [];
 ?>
 <main data-barba="container" data-barba-namespace="gallery" class="barba-main-container gallery-section">
	<div class="general-page">
		<div class="container">
			<div class="row justify-content-center">
				<h1 class="page-heading heading-size-2 ps-0">Gallery</h1>
				<div class="col-auto">
					<p class="page-content content-size-2">
						<?= $t_set->get('ca_sets.set_description'); ?>
					</p>

					<div class="gallery-grid">
						<?php
							foreach($set_items as $item) {	
								$item = array_shift($item);
								//print_R($item);
						?>
							<div class="gallery-item">
								<!-- <?= $item['representation_tag']; ?> -->
								<?= caDetailLink($this->request, $item['representation_tag'], 'link-text', 'ca_objects', $item['row_id']); ?>
								<!-- <?= caDetailLink($this->request, $item['name'], 'link-text', 'ca_objects', $item['row_id']); ?> -->
							</div>
						<?php
							}
						?>
					</div>

				</div> 
			</div>
		</div>
	</div>
</main>