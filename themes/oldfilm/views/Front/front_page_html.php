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
<!-- <link rel="stylesheet" href="home/data/oldfilm/collection/themes/oldfilm/assets/pawtucket/css/theme.css" media='all' /> -->

	<div class="row">
		<div class="col-sm-offset-2 col-sm-8 text-center" style='margin-bottom: 40px;'>

			<p>
				We care for approximately 800 moving image collections, which would take more than a year to watch. Of these, 300+ are described online at the collection level.
			</p>

			<div style='margin-top: 20px;'>
				<a href="/Browse/collections" class="elementor-button-link elementor-button elementor-size-sm" role="button">
					<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">View Collections</span>
					</span>
				</a>

				<a href="/Browse/works" class="elementor-button-link elementor-button elementor-size-sm" role="button">
					<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">View Works</span>
					</span>
				</a>
 			</div>

			<!-- <li class="coll-menu-item">
				<?php print caNavLink($this->request, 'Browse Collections', '', '', 'Browse', 'collections', ''); ?>
			</li> -->

			<!-- <nav class="collection-nav" aria-label="Primary" itemtype="https://schema.org/SiteNavigationElement" itemscope="">
				<ul class="collection-menu">
					
					<li  class="coll-menu-item">
						<?php print caNavLink($this->request, 'Overview', '', '', '', '', ''); ?>
					</li>
					
					<li class="coll-menu-item">
						<?php print caNavLink($this->request, 'Browse Collections', '', '', 'Browse', 'collections', ''); ?>
					</li>
					
				</ul>
			</nav> -->
			
		</div>
	</div>        
	<!-- end row -->