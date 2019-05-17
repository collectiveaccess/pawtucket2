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
<div class="parallax">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-1">
				<div class="hpIntro">
					Bramble is a design and presentation tool for garden and landscape professionals. Let Bramble help you put more right plants in the right place.
					<p class="text-center">
						<a href="#features" class="btn btn-default">Learn More</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center">
			<br/><br/><H1><b>Bramble</b> streamlines the design process of creating presentation pages for clients, so you can dedicate your energy toward choosing <b>more right plants for the right place</b>.</H1><br/><br/>
		</div><!--end col-sm-8-->
	</div><!-- end row -->
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<H1 class="text-center">Featured Plants</H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php print $this->render("Front/featured_set_slideshow_html.php"); ?>
		</div>
	</div>
</div>

<div class="container tealBg">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center">
			<br/><H1>The Bramble Solution</H1>
			Bramble offers plant professionals logical search mechanisms in an uncluttered interface to assist in finding the right plant for a particular place. We want your individual creativity to flourish: our aim is to provide you with a clean interface, letting you navigate the design process without unnecessary suggestions or interruption in workflow. With Bramble, you can easily select plants to combine into palettes, which in turn can be used as design tools and to create custom presentation pages allowing effective communication with your clients.
			<br/><br/><br/>
			<a name="features"></a>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-clock-o ochre" aria-hidden="true"></i>
				<H1 class="teal">Save Time</H1>
				<H2>Plant pages in minutes.</H2>
				<p>
					Build plant palettes for a project, then easily generate a suite of reports: palette color chart, plant order page, plant image page and project plant list with notes for use in the field. Bramble saves you time making tedious reports to give you more time to choose the right plants for your project.
				</p>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-cloud ochre" aria-hidden="true"></i>

				<H1 class="teal">A Quiet Place for Focus</H1>
				<H2>Simple clean design environment</H2>
				<p>
					Bramble is keeping it simple. We know designing gardens and accounting for light, water, soil, habitat, aesthetics, pollinators, clients, personal taste and plant combinations (to name a few) can be a complex process. By keeping the interface clean and simple we hope to be a quiet place of focus which will allow your creative process to flourish. No social media here - just your own space to be one with the plants!
				</p>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-scissors ochre" aria-hidden="true"></i>
				<H1 class="teal">No More Cutting and Pasting</H1>
				<H2>Plant lists in a minute</H2>
				<p>
					Currently the only way to gather data for your professional use is to painstakingly cut and paste info from separate databases into your document. No longer is that necessary. Bramble does the work for you. Simply select your plants, add them to your palette and your plant lists are made!
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-briefcase ochre" aria-hidden="true"></i>
				<H1 class="teal">Stay Organized</H1>
				<H2>Store your plant palettes for all of your projects</H2>
				<p>
					Within Bramble you can organize your many palettes associated with each project. Store your favorite plant combinations in palettes - no need to start from scratch. Copy palettes you loved from past projects to use as a place to begin.
				</p>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-files-o ochre" aria-hidden="true"></i>

				<H1 class="teal">Design Efficiently</H1>
				<H2>Plant Pages Double as Design Tools</H2>
				<p>
					When building your palettes you can drag and drop plant images to compare how combinations look, and review how your garden is shaping up. 
					<br/><br/>The palette color chart builds as you build your palette, showing the colors of your garden in every month. Refer to it as you choose your plants. You can easily see which colors are dominating in each season and which seasons need a bit more or a bit less!
				</p>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-paint-brush ochre" aria-hidden="true"></i>
				<H1 class="teal">Build Your Palette, No Interruption</H1>
				<H2>Create plant palettes with the click of a button</H2>
				<p>
					Creating palettes allows you to organize your plants within a project. When you find a plant you would like to use you simply click the “add to palette” button and it's done. You can continue the creative process of picking other plants to add to that palette with no interruption.
				</p>
			</div>
		</div>
	</div>
</div>
