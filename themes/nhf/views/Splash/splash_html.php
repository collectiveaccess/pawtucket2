<div id="browseListBody">
	<div id="title">Explore Our Moving Image Collections</div>
	<div id="introText">
		Our online catalog holds newly described and heritage database descriptions of film and video including local television news, amateur film, industrials, and many other genres.  Many holdings are not yet described.  To explore our catalog, enter a search term in the box below, or browse by <?php print caNavLink($this->request, _t('collection names'), '', '', 'Browse', 'CollectionsList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('places'), '', '', 'Browse', 'PlaceList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('genres'), '', '', 'Browse', 'GenreList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('subjects'), '', '', 'Browse', 'SubjectList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('decades'), '', '', 'Browse', 'DecadeList', array('target' => 'ca_collections'))." or ".caNavLink($this->request, _t('people and organizations'), '', '', 'Browse', 'PeopleList', array('target' => 'ca_collections')); ?>.

	<div id="hpSearch"><form name="hp_search2" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
			Search: <input type="text" name="search" value="" autocomplete="off" size="100"/><input type="submit" name="op" id="edit-submit" value="GO"  class="form-submit" /><input type="hidden" name="target"  value="ca_objects" />
	</form></div><!-- end hpSearch -->


	<br/><br/><div class="subTitle">Projects</div>
	<div id="featuredCollections">
		<div class='featuredCollection'>
<?php
			print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/hidden_coll_nywf.jpg' border='0'>";
			print "<a href='http://www.fairfilm.org'>Moving Images 1938-1940, Amateur Filmmakers Record the New York World's Fair and Its Period</a><br/>\n";
?>
			<div>
				New York World's Fair (1939-1940) and amateur filmmaking during that era described by Northeast Historic Film, the Queens Museum of Art, and the L. Jeffrey Selznick School of Film Preservation at George Eastman House International Museum of Photography and Film.
			</div>
		</div><!-- end featuredCollection -->
		<div class='featuredCollection'>
<?php
			print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/hidden_coll_boston.jpg' border='0'>";
?>
			<a href="http://bostonlocaltv.org/">Boston Local TV News 1959-2000</a><br/>
			<div>
				WCVB-TV Boston, a collection at Northeast Historic Film, with archival TV collections at WGBH, the Boston Public Library, and Cambridge Community Television. A shared catalog of 40 years of local television reflecting broadcast practices and issues of the day. 
			</div>
		</div><!-- end featuredCollection -->
		<div class='featuredCollection'>
<?php
			print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/hidden_coll_work_life.jpg' border='0'>";
			print caNavLink($this->request, "Moving Images of Work Life, 1916-1960", "", "", "Browse", "HiddenCollectionsList")."<br/>\n";
?>
			<div>
				Records of work by men and women in northern New England agricultural environments, traditional and modernizing industries, and early twentieth century urban situations.
			</div>
		</div><!-- end featuredCollection -->
	</div><!-- end featuredCollections -->
	<div style="clear:both;">&nbsp;</div>
	<div>
		<i>Thanks to the generous support of the Council on Library and Information Resources/Andrew W. Mellon Foundation <a href="http://www.clir.org/hiddencollections/index.html" target="_blank">Cataloging Hidden Special Collections and Archives grant program</a>.</i>
	</div>
</div><!-- end introText -->

<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end browseListBody -->