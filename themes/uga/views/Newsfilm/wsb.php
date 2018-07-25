<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Newsfilm");
?>
<H1><?php print _t("NEWSFILM: WSB-TV NEWSFILM COLLECTION"); ?></H1>
<div class="row">
	<div class="col-sm-8">
	<p>The WSB Newsfilm Collection at the University of Georgia's Walter. J. Brown Media Archive & Peabody Awards Collection at the University of Georgia Libraries is a remarkable
	treasure of moving image history focusing on Atlanta, Georgia and the surrounding region. On September 29, 1948 WSB-TV became the first television station in the South.
	It is partnered with WSB radio, which began broadcasting in 1922. No other Atlanta area television stations saved their newsfilm, making this collection a unique historical resource. Additionally, WSB was the largest television station in the region and routinely was able to provide more reporters, taking more newsfilm than the other television stations based in Atlanta. </p>
	<p>The collection contains over 5 million feet of newsfilm dating from 1949 to 1981. The collection covers the Civil Rights Movement, the legacy of Dr, Martin Luther King, Jr.,
	the political careers of Jimmy Carter, Julian Bond, Andrew Young, Maynard Jackson, Herman Talmadge, Lester Maddox, Carl Sanders, George Wallace, Richard Russell, William Hartsfield,
	and many others. If it happened in Atlanta from the 1950s to 1981, it is most likely in this collection.</p>
	<p>The richness of the collection lies in the fact that the footage is raw. It is not the televised newscast, but is the unedited and additional "B-roll" footage. Newsfilm is a
	sweet irony in the fast-paced world of television news, and was in use for approximately 30 years. Prior to television, news was captured on 35mm film and shown in movie theaters as
	newsreels. Newsfilm is 16mm film. It started out as black & white, then moved to color film. Using small portable cameras, it became the standard for recording events and was shown
	during news broadcasts to augment the story being read by the television anchor. Later, videotape became the medium of choice. It was more portable, did not require chemical processing,
	and was re-recordable, thereby making it more attractive in terms of getting a story out quickly.</p>

	<H3>RESEARCHING THE COLLECTION</H3>
	<p>There is a separate database that indexes this collection. Please see the search form on the right.</p>	
	<div id="aeon">
		<div id="aeoncaption"><a href="https://uga.aeon.atlas-sys.com/aeon/">Special Collections <br />Research Account</a></div>
		<a href="https://uga.aeon.atlas-sys.com/aeon/">
		<img src="../../themes/uga/assets/pawtucket/graphics/aeonra3.jpg" /></a>
		<p>All patrons are asked to register with the Special Collections Libraries, helping us provide better and faster service.
		To register and create a research account, click on the link to the right:</p>
	</div>
	<p>For more information about how to request materials from our collections, please visit <a href="http://www.libs.uga.edu/scl/research/using.html">http://www.libs.uga.edu/scl/research/using.html</a></p>


	<H3>LICENSING</H3>
	<p>This collection is available for reuse and does not require a separate copyright permissions request.</p>
	<p>For licensing information, please see the <a href="../Licensing/Index">Licensing Fee Schedule</a></p>
	<p>For more information about use of this collection, please contact the Director of the Media Archives, Ruta Abolins, via email: <a href=mailto:abolins@uga.edu>abolins@uga.edu</a>,
	or phone: 706-542-4757.

	<H3>RELATED LINKS</H3>
	<p>
		<ul>
			<li><a href="http://wsbtv.com" >WSB-TV Atlanta</a></li>
			<li><a href="http://www.georgiaencyclopedia.org/articles/arts-culture/wsb-tv-newsfilm-collection">WSB-TV Newsfilm Collection </a> (New Georgia Encyclopedia)</li>
			<li><a href="http://crdl.usg.edu">Civil Rights Digital Library</a></li>
			<li><a href="http://www.civilrights.uga.edu/bibliographies/athens/index.htm">Freedom on Film</a></li>
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
