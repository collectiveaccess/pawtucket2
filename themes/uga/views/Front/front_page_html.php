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
	<div class="row contenttab">
		<div class="col-md-8">
			<H1 class="slogan">The only public archive in Georgia devoted solely to the preservation of audiovisual materials</H1>
			
			<div class="row">
				<div class="col-md-7">
					
				<div class="nwidget layout block title-box clearfix " data-additional-classes="" data-title="Search Brown Media Archives">				
					<h2>Search Brown Media Archives</h2>	
					 <form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'Objects'); ?>" class="form-inline">
							<input class="form-control query width100" id="brownSearch" name="search" placeholder="Enter Keywords" type="text">
							<button class="btn btn-primary space-above" id="searchButton" name="rows" type="submit" value="20">Search</button>
					</form>				
				</div>
					
					
				</div>
				<div class="col-md-5">
					<div class="headerbox">
						<div class="headertab middletab">
							<H2 class="colheader"><a href="http://www.libs.uga.edu/blog/?cat=33">NEWS</a></H2>
						</div>
					</div>
					<script src="https://feeds.feedburner.com/uga/dodO?format=sigpro" type="text/javascript" >
					</script>
					<noscript><p>Subscribe to RSS headline updates from: <a href="https://feeds.feedburner.com/uga/dodO"> </noscript>
				</div>		
			</div>
		</div><!--end col-sm-8 for left Columns-->
		
		<div class="col-md-4">
			<div class="headerbox">
						<div class="headertab middletab">
							<H2 class="colheader"><a href="http://www.libs.uga.edu/blog/?event-categories=mediaarchivespeabodyevents">UPCOMING EVENTS</a></H2>
						</div>
			</div>
			<script src="https://feeds.feedburner.com/EventsMediaArchivesUGALibs?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="https://feeds.feedburner.com/EventsMediaArchivesUGALibs">
			</a><br/>Powered by FeedBurner</p> </noscript>

			<div id="aeon">
				<div id="aeoncaption">
					<a href="https://uga.aeon.atlas-sys.com/logon/">Special Collections <br />Research Account</a>
					<a href="https://uga.aeon.atlas-sys.com/logon/"><img src="themes/uga/assets/pawtucket/graphics/aeonra3.jpg" /></a>
				</div>
			</div><!-- end aeon-->
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->
