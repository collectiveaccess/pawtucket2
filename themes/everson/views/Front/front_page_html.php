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
		print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="page-title-container clearfix">
    <h1 class="page-title">American Ceramics & Ceramic National Archive</h1>
</div>
			<nav class="navbar navbar-default yamm">
			<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" name="search">
					</div>
					<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>	
			<ul class="nav navbar-nav navbar-right">
				<?php print $this->render("pageFormat/browseMenu.php"); ?>	
				<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
				<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
			</ul>
			</nav>
<div class="container ">

	<div class="row">
		<div class="col-sm-12 pageContent">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ultrices at felis posuere imperdiet. Mauris tincidunt risus viverra, consectetur mi sit amet, gravida lectus. Curabitur non vehicula eros, nec malesuada risus. Vestibulum rhoncus metus nec blandit sodales. Morbi molestie leo id urna pharetra mollis. Aenean nec consequat tortor. Pellentesque sed ipsum viverra, ullamcorper urna in, cursus dolor. Nam arcu est, tincidunt in sollicitudin in, sollicitudin vel orci. Ut cursus quis urna eget porta. Aenean feugiat malesuada lorem eleifend lacinia. Nullam vitae tortor vel purus imperdiet egestas nec quis neque. Cras porta posuere lacus, a auctor velit fermentum sit amet.</p>

			<p>Nunc dictum augue eu maximus ultrices. Aenean turpis sapien, suscipit ultrices consectetur nec, vehicula nec mi. Nunc elit sapien, varius lacinia blandit sed, ornare eget nunc. Pellentesque interdum ligula sit amet lectus sagittis, vitae viverra massa dictum. Ut euismod eros est, nec tempus purus aliquam non. Donec eget metus quis mi consequat sodales ac sed erat. Curabitur odio mauris, condimentum et neque convallis, hendrerit ultricies leo. Aenean pellentesque magna quam, sit amet sagittis risus pulvinar vel. Maecenas lacinia mauris dolor, quis pharetra sem consectetur a. Cras ac nisi diam. Morbi accumsan nisi magna, sit amet blandit libero pharetra non. Sed et porttitor erat, dignissim condimentum neque.</p>

			<p>Pellentesque mattis, arcu non vestibulum pretium, lorem enim ornare justo, sed lacinia est erat sit amet ipsum. Nam nec sem ac erat tempor cursus quis ut mauris. Pellentesque at volutpat massa. Phasellus metus felis, placerat tristique semper ut, vestibulum nec magna. Sed sagittis, justo in luctus aliquet, dolor tortor pulvinar magna, ut convallis lectus eros et leo. Duis nisi lacus, efficitur eu scelerisque et, lacinia a elit. Phasellus ipsum velit, tincidunt in commodo et, pellentesque eu nibh.</p>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->