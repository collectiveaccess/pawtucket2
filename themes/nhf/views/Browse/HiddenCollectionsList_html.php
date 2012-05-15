<?php
	require_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");
	require_once(__CA_MODELS_DIR__."/ca_collections.php");
	require_once(__CA_MODELS_DIR__.'/ca_sets.php');
 	
	# --- get all collections
	
 	$o_search = new CollectionSearch();
	$qr_collections = $o_search->search("ca_collections.access:1 and ca_collections_curatorial_collections:1644", array("sort" => "ca_collection_labels.name", 'checkAccess' => array(1)));
	
?>
<div id="browseListBody">
	<div id="title">Moving Images of Work Life, 1916-1960</div>
	<div id="introText">
		These collections were selected as records of work by men and women in northern New England agricultural environments, traditional and modernizing industries, and early twentieth century urban situations. 
		<br/><br/>What is the purpose of describing these moving images and what is our relationship to the works? 
			<ul>
				<li>Our purpose is to raise public and scholarly awareness of moving images as important primary source materials for enjoyment and use.</li>
				<li>We have a custodial relationship, striving to treat the donors and materials with respect and attention--in perpetuity.</li>
				<li>The benefit of online descriptive records with image surrogates is that many more people will know the collections exist.</li>
				<li>An important shortcoming of online access is that the small screen diminishes the experience by skipping the clarity and thoughtfulness of discussion during research. This is a largely unrecognized downside to instant search/return/next.</li>
				<li>Our true goal is to support and encourage a much closer relationship between you and the collections. Interaction with the moving images in their larger context at the archives  has enormous benefits.</li>
			</ul>

Funding from the Council on Library and Information Services, <a href="http://www.clir.org/hiddencollections/index.html" target="_blank">Cataloging Hidden Special Collections and Archives program</a>.

<br/><br/>Katrina Dixon was the project media cataloger.
<br/>Karan Sheldon was the project director. <a href="mailto:karan@oldfilm.org">karan@oldfilm.org</a>

<br/><br/><br/>	
<div class="subTitle">Featured Collections</div>
	<div id="featuredCollections">
	
<?php
	$t_featured_set = new ca_sets();
 			
	$va_access_values = caGetUserAccessValues($this->request);
		
	# --- featured collections - set_code hiddenCollections
	$t_featured_set->load(array('set_code' => "hiddenCollections"));
	#$va_featured_ids = array_keys(is_array($va_tmp = $t_featured_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());	// These are the collection ids in the set
	$va_items = caExtractValuesByUserLocale($t_featured_set->getItems(array('returnItemAttributes' => array('caption'))));
	if(is_array($va_items) && (sizeof($va_items) > 0)){
		$t_collection = new ca_collections();
		foreach($va_items as $vn_i => $va_set_item_info){
			print "<div class='featuredCollection'>";
			$vn_collection_id = $va_set_item_info["row_id"];
			$t_collection->load($vn_collection_id);
			print caNavLink($this->request, $t_collection->getAttributesForDisplay("collection_still", null, array('version' => 'thumbnail', 'showMediaInfo' => false)), '', 'Detail', 'Collection', 'Show', array('collection_id' => $vn_collection_id));
			print caNavLink($this->request, $t_collection->getLabelForDisplay(), '', 'Detail', 'Collection', 'Show', array('collection_id' => $vn_collection_id))."<br/>\n";
			print "<div>".$va_set_item_info["ca_attribute_caption"]."</div>";
			print "</div>";
		}
	}			
?>	
		</div>

		</div><!-- end introText -->
<?php
	
	if($qr_collections->numHits() > 0){
		$colLength = ceil($qr_collections->numHits() / 3);
		$c = 0;
		print "<br/><div class='subTitle'>"._t("Work Life Collections")."</div>";
		print "<div id='hiddenCollectionList'><div class='col'>";
		while($qr_collections->nextHit()) {
			print "<div class='item'>".caNavLink($this->request, join('; ', $qr_collections->getDisplayLabels($this->request)), '', 'Detail', 'Collection', 'Show', array('collection_id' => $qr_collections->get("collection_id")))."</div>\n";
			$c++;
			if($c == $colLength){
				print "</div><div class='col'>";
				$c = 0;
			}
		}
		print "</div><!-- end col --></div><!-- end list -->";
	}
?>
<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end browseListBody -->