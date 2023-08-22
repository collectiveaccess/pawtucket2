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
					
				<div class="nwidget layout block title-box clearfix " data-additional-classes="" data-title="Search Peabody Collection">				
					<h2>Search Peabody Awards Collection</h2>	
					<form method="post" action="https://peabody.libs.uga.edu/cgi-bin/parc.cgi">

						<input type="hidden" name="userid" value="galileo">
						<input type="hidden" name="action" value="query"> 
						<input class="form-control query width100" name="term_a" placeholder="Enter Keywords" type="text">
						<div style="height:10px"></div>
						<select name="index_a">
						 <option value="kw" selected>Keyword Anywhere</option>
						
						<option value="wi">Winner</option>
						<option value="ti">Title</option>
						<option value="yr">Year</option>
						<option value="cl">Call Number</option>
						
						<option value="ec">Entry Category</option>
						<option value="bs">Broadcasting Station</option>
						<option value="pp">Producer of Syndicated/Non-Broadcast Program</option>
						<option value="bl">Broadcast Station Location</option>
						<option value="bd">Broadcast Date</option>
						
						<option value="rt">Run Time</option>
						<option value="sj">Subject Headings </option>
						<option value="st">Type of Entry</option>
						
						<option value="su">Program Description</option>
						<option value="wc">Winner Citation</option>
						<option value="oe">Collection Has Other Episodes</option>
						<option value="rm">Related Material</option>
						<option value="gi">Grant Information</option>
						<option value="pn">Notes</option>
						
						<option value="po">Persons Appearing</option>
						<option value="cp">Producers, Corporate</option>
						
						<option value="pc">All Production Credits</option>
						<option value="ge">Genre(s)</option>
						<option value="tr">TV, Radio, and/or Web</option>
						<option value="dc">Digitized Copy Available</option>
						<option value="uc">User Copy Available</option>
						<option value="ar">Collection Has Archival Master</option>
						</select>
						<div style="height:10px"></div>
						
						<button class="btn btn-primary space-above" id="searchButton" name="rows" type="submit" value="20">Search</button>
					</form>		
				</div>
					
				<div class="nwidget layout block title-box clearfix " data-additional-classes="" data-title="Search the News Film Collections">				
					<h2>Search Newsfilm Collection</h2>	
					 <form method="post" action="http://dbsmaint.galib.uga.edu/cgi/news">
						<input type="hidden" name="action" value="query">
						<input type="text" name="term_a" value="" size="30">
						<div style="height:10px"></div>
						<select name="index_a">
							<option value="keyword">Keywords</option>
							<option value="subject">Subject(s) of Clip</option>
							
							<option value="person">Persons</option>
							<option value="place">Place</option>
							<option value="date">Date</option>
							
							<option value="year">Year</option>
							<option value="id">Item ID</option>
							<option value="rl">Reel#</option>
							<option value="ln">Length</option>
							<option value="tm">Time In</option>
							
							<option value="br">B-Roll</option>
							<option value="sc">Script</option>
							<option value="ti">Title</option>
							<option value="_ti">Title phrase</option>
							
							<option value="sp">Spatial Coverage</option>
							<option value="_sp">Spatial Coverage phrase</option>
							<option value="sm">Summary</option>
							<option value="_sm">Summary phrase</option>
							
							<option value="sl">Slug Title</option>
							<option value="_sl">Slug Title phrase</option>
							<option value="pp">Persons</option>
							<option value="_pp">Persons phrase</option>
							<option value="ps">Person(s) in Clip</option>
							
							<option value="_ps">Person(s) in Clip phrase</option>
							<option value="de">Subject(s) of Clip</option>
							<option value="_de">Subject(s) of Clip phrase</option>
							
							<option value="dp">Subject, Persons</option>
							<option value="_dp">Subject, Persons phrase</option>
							<option value="do">Subject, Topics</option>
							<option value="_do">Subject, Topics phrase</option>
							<option value="dg">Subject, Locations</option>
							<option value="_dg">Subject, Locations phrase</option>
							
							<option value="dr">Subject, Corporate</option>
							<option value="_dr">Subject, Corporate phrase</option>
							
							<option value="rp">Reporter</option>
							<option value="_rp">Reporter phrase</option>
							<option value="tp">Type</option>
							<option value="pn">Public Notes</option>
							<option value="cn">Condition Notes</option>
							<option value="gr">Grant</option>
							<option value="so">Newsfilm Source</option>
							
							<option value="vc">Viewing Copy</option>
							
							<option value="dc">Digitized Copy</option>
							<option value="ge">Genre</option>
							<option value="_ge">Genre phrase</option>
							<option value="up">Update Date</option>
						</select>
						<div style="height:10px"></div>
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
