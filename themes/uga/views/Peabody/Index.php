<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Peabody");
?>
<H1><?php print _t("PEABODY AWARDS COLLECTION"); ?></H1>
<div class="row">
	<div class="col-lg-8 col-md-7">
	<p>1940-present</p>
	<p>The Peabody Awards Collection consists of over 90,000 titles, with radio programs dating from 1940 and television from 1948. The collection consists of almost all the entries to the awards program since its beginning in 1941. It contains American, local, and more currently, international, electronic media programs, with content from news, documentary, entertainment, educational, children's, and public service programming. There are radio transcription discs, audiotape, audiocassettes, 16mm kinescopes and prints, 2" videoreels, videocassettes, websites, and objects associated with the collection. Many of the programs in the collection may be only surviving copies of the work, especially in the case of local radio and television broadcasting. These are all original archival materials. Reference, or "user" copies, are available for much of the collection for use in the University of Georgia Libraries Media Department or at the <a href="http://libs.uga.edu/scl" target="_blank">Special Collections Library</a>. <br>
	  <br>
	  Press kits, scripts, and correspondence submitted with the entries are housed in the <a href="http://www.libs.uga.edu/hargrett/" target="_blank">Hargrett Rare Book and Manuscript Library.<br>
	</a> <br>The collection continues to grow, as every year's entries are deposited with the Library after the awards process is completed.</p>
	
	<H3>FINDING AIDS</H3>
	<p>
			<ul>
			<li><a href="https://galileo-usg-uga-primo.hosted.exlibrisgroup.com/permalink/f/v7b6bh/01GALI_USG_ALMA71127462620002931">GIL Catalog Record</a></li>
			</ul>
	</p>

	<H3>RESEARCHING THE COLLECTION</H3>
	<p>There is a separate database that indexes this collection. Please see the search form on the right.</p>	
	<div id="aeon">
		<div id="aeoncaption"><a href="https://uga.aeon.atlas-sys.com/logon/">Special Collections <br />Research Account</a></div>
		<a href="https://uga.aeon.atlas-sys.com/logon/">
		<img src="../../themes/uga/assets/pawtucket/graphics/aeonra3.jpg" /></a>
		<p>All patrons are asked to register with the Special Collections Libraries, helping us provide better and faster service.
		To register and create a research account, click on the link to the right:</p>
		<p>For more information about this collection, please contact Peabody Awards Collection Archivist <a href=mailto:mlmiller@uga.edu>Mary Miller</a>.</p>
	</div>
	
	<H3>LICENSING</H3>
	<p>This collection consists almost entirely of copyrighted material. If you are interested in something from this collection, please check to see if is available directly from the copyright holder.</p>
	<p>For licensing information, please see the <a href="../Licensing/Index">Licensing Fee Schedule</a>.</p>
	<p>For more information about use of this collection, please contact the Director of the Media Archives, Ruta Abolins, via email: <a href=mailto:abolins@uga.edu>abolins@uga.edu</a>,
	or phone: 706-542-4757.

	<H3>RELATED LINKS</H3>
	<p>
		<ul>
			<li><a href="http://www.georgiaencyclopedia.org/articles/arts-culture/george-foster-peabody-awards">George Foster Peabody Awards (New Georgia Encyclopedia)</a></li>
			<li><a href="http://www.peabodyawards.com/">Peabody Awards Web Site</a></li>
		</ul> 
	</p>
	</div>
	<div class="col-lg-4 col-md-5">
		<h1>Search Peabody Collection</h1>
		<div>
			<form method="post" action="https://peabody.libs.uga.edu/cgi-bin/parc.cgi">

						<input type="hidden" name="userid" value="galileo">
						<input type="hidden" name="action" value="query"> 
						<input class="form-control query width100" name="term_a" placeholder="Enter Keywords" type="text">
						<div style="height:10px"></div>
						<div class="search-in">
							<h5>Search In: </h5>
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
						</div>
						<div style="height:10px"></div>
						
						<button class="btn btn-primary space-above" id="searchButton" name="rows" type="submit" value="20">Search</button>
			</form>
			<div style="height:10px"></div>
			<p>See: <a href="http://dbs.galib.uga.edu/cgi-bin/ultimate.cgi?dbs=parc&userid=galileo&action=search&_cc=1"><strong>More Search Options in Peabody Database</strong></a>
			</p>
		</div>		
	</div>
</div>
