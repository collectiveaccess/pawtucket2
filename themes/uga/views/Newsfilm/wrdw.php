<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Newsfilm");
?>
<H1><?php print _t("NEWSFILM: WRDW-TV NEWS FILM COLLECTION"); ?></H1>
<div class="row">
	<div class="col-sm-8">
	<p>WRDW-TV commenced operations on February 14, 1954; it is the second-oldest television station in Augusta. It was originally owned by the Morris family (whose holdings eventually
	became Morris Communications) along with the Augusta Chronicle and the original WRDW radio (1480 AM). It has been Augusta's CBS affiliate for its entire history, owing to its radio
	sister's long affiliation with CBS radio. However, it shared ABC with then-NBC affiliate WJBF (channel 6). On October 1, 1966, WJBF switched its primary affiliation to ABC, and began
	splitting NBC with WRDW-TV. This was unusual, but WJBF's namesake owner J.B. Fuqua wanted to get that station in line with two ABC affiliates he had just purchased, located in
	Evansville, Indiana and Fargo, North Dakota.</p>

	<p>When WATU (channel 26, now WAGT) appeared as the market's third station in late 1968, NBC allowed WRDW-TV and WJBF to keep their secondary NBC affiliations. This situation mostly
	shut WATU out of access to network programming, thereby forcing it to go dark in 1970. Channel 12 continued to split NBC with WJBF until WATU resumed broadcasting in 1974 with a
	primary NBC affiliation. At that time, channel 12 finally became a full-time CBS station.</p>

	<p>In the mid-1960s, the Morris family sold WRDW-AM-TV to Rust Craft Broadcasting. WRDW radio was acquired by entertainer and Augusta native James Brown in 1969 (it is now WGUS);
	both stations were allowed to retain the WRDW call sign. Rust Craft's station group was acquired by Ziff Davis in 1979. Channel 12 was sold along with then sister stations in Saginaw,
	Michigan, Rochester, New York, Chattanooga, Tennessee and Steubenville, Ohio to Television Station Partners in 1983. Television Station Partners sold off all of its stations in early
	January 1996, with WRDW going to Gray Communications Systems (now Gray Television).</p>

	<H3>LICENSING</H3>	
		<ul>
			<li><a href="../Licensing/Index">Licensing Fee Schedule</a>
			</li>
		</ul>
	<H3>Finding Aids</H3>
	<p>
			<ul>
			<li><a href="http://gilfind.uga.edu/vufind/Record/3761226">GIL Catalog Record</a></li>
			</ul>
	</p>
	<H3>RELATED LINKS</H3>
	<p>
		<ul>
			<li><a href="http://www.walb.com/">WALB-TV Web Site</a></li>
			<li><a href="http://www.georgiaencyclopedia.org/articles/arts-culture/television-broadcasting">Television Broadcasting (New Georgia Encyclopedia)</a></li>
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
