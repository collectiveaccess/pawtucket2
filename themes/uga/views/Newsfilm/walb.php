<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Newsfilm");
?>
<H1><?php print _t("NEWSFILM: WALB-TV NEWS FILM COLLECTION"); ?></H1>
<div class="row">
	<div class="col-sm-8">
	<p>1961-1978</p>

	<H3>About the Collection </H3>
	<p>WALB television, the NBC affiliate in Albany, Georgia, donated its archives of news footage to the University of Georgia Media Archives in June 2002. The WALB Collection consists of over 1600 cans of black and white, color, silent, and sound clips of footage shot in the field circa 1961-1978. Both national and Georgia news clips are represented. Topics covered include: footage of Martin Luther King, Jr. in Albany in 1962, as well as demonstrations surrounding his visit to Albany; politicians Jimmy Carter, Sam Nunn, Herman Talmadge, Lester Maddox, Carl Sanders, George Wallace, Richard Russell, and Richard Nixon; Vietnam; Civil Rights issues (including the Albany Movement); integration and segregation; coverage of the Georgia State Legislature; 1970s gasoline rationing and meat price hikes; tobacco farming and farm-related topics; various local celebrations for the United States Bicentennial; pageants and festivals around Georgia; voter registration; local sports; birth control; as well as many topics of local concern, such as high school sporting events, floods, fires, car accidents, homicides, holiday celebrations, education, health care, taxes, factory strikes, employment issues, and housing, among others. </p>
	  <p><em>This collection has been inventoried but access to the materials is limited as only a portion of the footage has been transferred
		to viewing copies.  For further information on the collection or to request specific transfers, contact <a href="mailto:margie@uga.edu">Margaret Compton</a> (706) 542-1971. </em></p>
	
	<H3>About WALB</H3>
	<p>The station signed-on April 7, 1954 as WALB-TV and was sister to WALB-AM 1590 as well as <em>The Albany Herald</em>. Later, in 1960, the radio station was sold to Allen Woodall Senior and became known as WALG to distinguish itself from the television station.</p>
	<p>As the first television outlet in Albany, it was primarily a NBC affiliate with secondary relations with ABC and DuMont. The latter network was dropped in 1955 when it shut down and ABC remained on WALB until 1980 when WVGA (now WSWG) signed-on. The station's first tower near Doerun was built in 1957. Until 1983, WALB was the default NBC affiliate for Tallahassee, Florida. Although WTWC-TV has been that area's affiliate since then, WALB still provides city-grade coverage to much of the Georgia side of the Tallahassee market and Grade B coverage to the city itself. In January 1992 when a plane crashed into WVGA's transmission tower and knocked the station off-air, Southwestern Georgia became one of the only areas on the East Coast without an ABC affiliate. As a result, cable systems in the area piped in either WSB-TV from Atlanta, current sister station WTVM from Columbus, WCJB-TV from Gainesville, Florida, or WTXL-TV from Tallahassee (which technically served as the de-facto affiliate due to being the closest). </p>
	<p>In 1993, WALB dropped the -TV suffix, and has operated as the flagship of the Gray Communications Corporation (now Gray Television) until Cosmos Broadcasting bought the station in 1998. This later became known as the Liberty Broadcasting Corporation. Although Gray no longer operates WALB, the company still has administrative offices in Albany today and operates WSWG in Moultrie that serves as a semi-satellite of co-owned WCTV in Tallahassee. Its digital signal on UHF channel 17 signed-on from the Doerun site in 2001.</p>

	<H3>LICENSING</H3>	
		<ul>
			<li><a href="../Licensing/Index">Licensing Fee Schedule</a>
			</li>
		</ul>
	<H3>FINDING AIDS</H3>
	<p>
			<ul>
			<li><a href="http://gilfind.uga.edu/vufind/Record/3220054">GIL Catalog Record</a></li>
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
