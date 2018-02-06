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
<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<H1>The only public archive in Georgia devoted solely to the preservation of audiovisual materials</H1>
		<H2><a href="http://www.libs.uga.edu/blog/?cat=33">News</a></H2>
		<script src="http://feeds.feedburner.com/uga/dodO?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/uga/dodO"> </noscript>
		<H2><a href="http://www.libs.uga.edu/blog/?event-categories=mediaarchivespeabodyevents">Upcoming Events</a></H2>
		<script src="http://feeds.feedburner.com/EventsMediaArchivesUGALibs?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/EventsMediaArchivesUGALibs"></a><br/>Powered by FeedBurner</p> </noscript>

		</div><!--end col-sm-8-->
		<div class="col-sm-4">
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		<p style="font:'Courier New', Courier, monospace; font-style:italic; font-size:28px; color:#96b0ba; margin:0; padding-top:10px">Did you know?</p>
<p><a href="http://www.libs.uga.edu/blog/?p=3636">The Walter J. Brown Media Archives & Peabody Awards Collection won an Emmy....!</a></p>
		

		<div id="aeon">
		<div id="aeoncaption"><a href="https://uga.aeon.atlas-sys.com/aeon/">Special Collections <br />Research Account</a></div>
		<a href="https://uga.aeon.atlas-sys.com/aeon/"><img src="themes/uga/assets/pawtucket/graphics/aeonra3.jpg" /></a>
		</div><!-- end aeon-->

		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->
