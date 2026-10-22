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
				<div class="col-sm-8">
					<h3>Search the Utensil Collection</h3>
				</div>
				
			</div>
			<div class="row">
				<div class="col-sm-12">
					<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'utensils/view/list'); ?>">
						<div class="formOutline">
							<div class="row">
								<div class="col-sm-9">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Utensil Search" name="search">
									</div>
								</div>
								<div class="col-sm-3 text-right">
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
					<h2><?php print caNavLink($this->request, _t("Browse the Utensil Collection"), '', '', 'Browse', 'utensils', array('view' => 'images')); ?></h2>
				</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-6 text-center popoverWide">
					
					<div id="jeffersonInventory" class="carousel slide" data-ride="carousel">
					  <div class="carousel-inner" role="listbox">
						<div class="item active">
						  <?php print caGetThemeGraphic($this->request, 'jefferson_inventory_0.jpg', array('class' => 'd-block img-fluid')); ?>
						</div>
						<div class="item">
						  <?php print caGetThemeGraphic($this->request, 'jefferson_inventory_1.jpg', array('class' => 'd-block img-fluid')); ?>
						</div>
					  </div>
					</div>
					<h6 id="citePopover">Citation</h6>
					<script>
						$(document).ready(function(){
							$('#jeffersonInventory').carousel({
								interval: 5000,
								cycle: true
							});
							$('#citePopover').popover({
								container: '.popoverWide',
								trigger: 'hover',
								content: "“James Hemings’s Inventory of Kitchen Utensils at Monticello, [20 February 1796],” Founders Online, National Archives, last modified December 28, 2016, founders.archives.gov/documents /Jefferson/01-28-02-0473. [Original source: The Papers of Thomas Jefferson, vol. 28, 1 January 1794 – 29 February 1796, ed. John Catanzariti. Princeton: Princeton University Press, 2000, pp. 610–611.]",
								placement: 'top',
								title: 'Citation'
							})
						});
					</script>
				</div>
				<div class="col-sm-6">
					<h3>Inventory of Utensils from Monticello<br/><a href="http://founders.archives.gov/documents/Jefferson/01-28-02-0473" target="_blank">Transcript Here</a></h3>
					<p>In February 1796 James Hemings, a slave at Thomas Jefferson's estate at Monticello, wrote up an inventory of the "Kitchen Utensils" in the kitchen. The document provides a glimpse into daily life at the estate and gives us a place to start understanding what it was like to cook -- and eat -- in the late 18th Century.</p>
				</div>
			</div>
		</div>
	</div>
</div> <!--end container-->
