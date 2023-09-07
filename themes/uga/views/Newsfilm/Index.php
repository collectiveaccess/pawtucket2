<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Newsfilm");
?>
<H1><?php print _t("Newsfilm"); ?></H1>
<div class="row">
	<div class="col-sm-8">
	<p>Newsfilm was used in broadcast for television newscasts from 1948 until the 1970s. Television from this time period is very different from the television
	news we know and count on today. During the early history of newsfilm local stations relied heavily on their cameramen to capture local news stories -
	there were no feeds between stations because the technology to do so was not yet in place. Cameramen would go out and capture the stories on 100 foot reels,
	return to the studio and process this reversal film stock (film stock that passed through the camera and was broadcast ready after a one-step development process),
	the film would then be viewed and edited, and put on a film chain (device that included one or more film projectors aligned to TV pick-up camera ) ready for the
	news broadcast. These 16mm reels were filmed in black & white and then color with sound and without sound in the era before videotape was widely used.
	Unlike videotape or digital capture which can be easily erased for re-use, film can only be used one time. Film is also the most long-lived of the moving image formats and
	therefore newsfilm from collections like these are unique filled with one-of-kind images and interviews.</p>

	<h3>Newsfilm Collections</h3>
	<p>
		<ul>
		<li><a href="telenews">Telenews Collection</a></li>
		<li><a href="walb">WALB-TV Newsfilm Collection</a></li>
		<li><a href="wrdw">WRDW-TV Newsfilm Collection</a></li>
		<li><a href="wsb">WSB-TV Newsfilm Collection</a></li>
		</ul>
	</p>
	<H3>LICENSING</H3>	
		<ul>
			<li><a href="../Licensing/Index">Licensing Fee Schedule</a>
			</li>
		</ul>
	<H3>RELATED LINKS</H3>
	<p>
			<ul>
			<li><a href="http://www.georgiaencyclopedia.org/articles/arts-culture/television-broadcasting">Television Broadcasting in Georgia</a> (New Georgia Encyclopedia)</li>
			</ul>
	</p>
	</div>
	<div class="col-sm-3">
		<H1>Newsfilm Search</H1>
		<div>
			<form method="post" action="http://dbsmaint.galib.uga.edu/cgi/news">
				<input type="hidden" name="action" value="query">
				<input type="text" name="term_a" value="" size="28">
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
			<div style="height:10px"></div>
			<p>For more search options, go directly to the <a href="http://dbsmaint.galib.uga.edu/cgi/news">Newsfilm Database</a></p>			
			<br/>
			<p><strong>Note:</strong> The WALB-TV Newsfilm Collection is not included in the Newsfilm Database.</p>
		</div>		
	</div>
</div>
