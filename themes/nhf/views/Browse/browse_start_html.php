<?php
	require_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");
 	
	# --- get all collections
	
 	$o_search = new CollectionSearch();
	$qr_collections = $o_search->search("ca_collections.access:1", array("sort" => "ca_collection_labels.name"));
	
?>
<div id="content"><div id="content-inner">        
	<div id="content-area">
		<div id="node-19" class="node node-type-page"><div class="node-inner">

		
		<div id="hpTitle">Moving Images</div>
		<div id="hpText">
			We care for approximately 800 moving image collections, which would take more than a year to watch. Of these, 300+ are described online at the collection level. To read about each collection, click on the collection name. <b>Search</b> by entering a word in the Search box. <b>Browse</b> by clicking on one of the terms above: <?php print caNavLink($this->request, _t('Places'), '', '', 'Browse', 'PlaceList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('Genres'), '', '', 'Browse', 'GenreList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('Subjects'), '', '', 'Browse', 'SubjectList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('Decades'), '', '', 'Browse', 'DecadeList', array('target' => 'ca_collections')).", ".caNavLink($this->request, _t('People'), '', '', 'Browse', 'PeopleList', array('target' => 'ca_collections')); ?>
	
			<br/><br/>Fifty new collections are being described in 2010, thanks to a generous grant from the Council on Library and Information Resources/Andrew W. Mellon Foundation Cataloging Hidden Collections and Archives program. For more information about this project please visit <?php print caNavLink($this->request, _t('here'), '', '', 'Browse', 'HiddenCollectionsList'); ?>.
	
			<br/><br/>Item Description:  More than 20,000 individual items (film reels and videotapes) are described in our research database, which we are converting to share here.  Please check back, or contact the archives for more information.
		</div>
		<!--<div id="hpSearch"><form name="hp_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
				Search: <input type="text" name="search" value="" autocomplete="off" size="100"/><input type="submit" name="op" id="edit-submit" value="GO"  class="form-submit" /><input type="hidden" name="target"  value="ca_collections" />
		</form></div>-->
		<div id="hpSearch"><form name="hp_search2" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
				Search: <input type="text" name="search" value="" autocomplete="off" size="100"/><input type="submit" name="op" id="edit-submit" value="GO"  class="form-submit" /><input type="hidden" name="target"  value="ca_objects" />
		</form></div><!-- end hpSearch -->

		</div></div> <!-- /node-inner, /node -->
    </div><!-- /content-area -->
</div></div> <!-- /#content-inner, /#content -->
     
</div></div> <!-- /#main-inner, /#main -->