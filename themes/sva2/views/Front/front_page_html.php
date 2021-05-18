<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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

	<div class="container-fluid front-page-container">

		<div class="hero-image-container">
			<img class="hero-image">
			<h1 class="hero-image-caption">SVA Exhibitions Archive</h1>
		</div>

		<div class="featured-exhibitions-heading">
			<h1 class="heading">Featured Exhibitions</h1>
			<div class="line-border"></div>
			<p class="info">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>

		<div class="row justify-content-start row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 exhibitions-list">

			<?php
				$qr = $this->getVar('featured_set_items_as_search_result');
				if($qr && $qr->numHits()){
					while($qr->nextHit()){
						// $media = $qr->getWithTemplate('<l>^ca_object_representations.media.medium</l>', ["checkAccess" => $this->getVar("access_values")]);
						$media = $qr->getWithTemplate('<unit relativeTo="ca_objects" start="0" length="1"><l>^ca_object_representations.media.medium</l></unit>', ["checkAccess" => $this->getVar("access_values")]);
						$caption = $qr->getWithTemplate("<unit relativeTo='ca_occurrences' start='0' length='1'><l>^ca_occurrences.preferred_labels.name</l></unit>");	
			?>
						<div class="col card exhibition-item">
							<div class='featured-exhibits-image'><?= $media; ?></div>
							<div class='featured-exhibits-caption'><?= $caption; ?></div>
						</div>
					<?php
					}
				}?>

		</div> <!--end row-->	
	</div> <!--end container-fluid-->	