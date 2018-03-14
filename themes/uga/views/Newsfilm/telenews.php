<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Newsfilm");
?>
<H1><?php print _t("NEWSFILM: TELENEWS COLLECTION"); ?></H1>
<div class="row">
	<div class="col-sm-8">
	<p>Our Telenews collection contains only those individual stories that came to us as part of the holdings of Georgia television stations WSB-TV and WALB-TV dating from 1960-1962 and
	many undated stories. We do not hold rights to or copyright information for Telenews. Telenews was a syndicated newsreel service that Hearst used from the late 1940's to the early
	1960s to compete with network TV news operations. Daily, Hearst sent via Railway Express or airmail, the day's news on little spools of 16mm film, resembling a box of chocolates. Some had sound while others, especially foreign news, were silent. These were sent to subscriber stations. A script was provided for the local station news reader. Hearst also provided a Weekly Telenews summation program, a weekly sports edition and a bi-weekly newsreel for US news theatres. This setup was geared to the era when most TV stations were not connected by wire or other relay systems. As the national connections were built up in the 1950s and the networks built news departments, Telenews became obsolete and faded away, as did the commercial newsreel companies. </p>
    <p>Please contact Ruta Abolins at <a href="mailto:abolins@uga.edu">abolins@uga.edu</a> or Margie Compton at <a href="mailto:margie@uga.edu"">margie@uga.edu</a> for more information.</p>

	<H3>LICENSING</H3>	
		<ul>
			<li><a href="../Licensing/Index">Licensing Fee Schedule</a>
			</li>
		</ul>
	<H3>Finding Aids</H3>
	<p>
			<ul>
			<li><a href="http://gilfind.uga.edu/vufind/Record/3843090">GIL Catalog Record</a></li>
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
