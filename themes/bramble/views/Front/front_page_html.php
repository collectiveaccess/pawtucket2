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
					Collaborate with plants.
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center">
			<br/><br/><H1><b>Bramble is a design and presentation tool that helps landscape professionals put the right plants in the right place.</b> By clarifying the complexities of plants, Bramble helps people create beautiful gardens and ecosystems that can thrive.</H1>
			<p class="text-center">
				<a href="#features" class="btn btn-default">Learn More</a>
			</p><br/><br/>
		</div><!--end col-sm-8-->
	</div><!-- end row -->
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<?php print $this->render("Front/featured_set_slideshow_html.php"); ?>
		</div>
	</div>
</div>

<div class="container tealBg">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center">
			<br/>
			Bramble offers plant professionals logical search mechanisms in an uncluttered interface to assist in finding the right plant for a particular place. We want your individual creativity to flourish. With Bramble, you can easily select plants to combine into palettes, which in turn can be used as design tools and to create custom presentation pages for your clients.
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
				<H1 class="teal">Save time</H1>
				<H2>Reports created as you add plants to your list</H2>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-cloud ochre" aria-hidden="true"></i>

				<H1 class="teal">Focus</H1>
				<H2>A clean and quiet interface supports creativity</H2>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-scissors ochre" aria-hidden="true"></i>
				<H1 class="teal">Stay organized</H1>
				<H2>Store multiple lists for each of your projects</H2>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-briefcase ochre" aria-hidden="true"></i>
				<H1 class="teal">Design efficiently</H1>
				<H2>Reports double as design tools</H2>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-files-o ochre" aria-hidden="true"></i>

				<H1 class="teal">Stop cutting and pasting</H1>
				<H2>Plant information is organized for you as you add plants to your lists</H2>
			</div>
		</div>
		<div class="col-md-4 text-center">
			<div class="hpFeature">
				<i class="fa fa-paint-brush ochre" aria-hidden="true"></i>
				<H1 class="teal">Collaborate</H1>
				<H2>An easy interface for sharing plant lists and plant information</H2>
			</div>
		</div>
	</div>
</div>
