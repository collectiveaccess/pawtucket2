<?php
	require_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");
	require_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
	JavascriptLoadManager::register('tabUI');
	
	# --- get the access values for checking permissions
	if($this->request->config->get("dont_enforce_access_settings")){
		$va_access_values = array();
	}else{
		$va_access_values = caGetUserAccessValues($this->request);
	}
	$t_object = new ca_objects();
	# --- most viewed
	$va_most_viewed_ids = $t_object->getMostViewedItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
	if(is_array($va_most_viewed_ids) && sizeof($va_most_viewed_ids) > 0){
		$va_most_viewed = array();
		foreach($va_most_viewed_ids as $va_item_info){
			$va_temp = array();
			$vn_r_object_id = $va_item_info['object_id'];
			$t_object->load($vn_r_object_id);
			$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'widepreview'), null, array('return_with_access' => $va_access_values));
			$va_temp["widepreview"] = $va_reps["tags"]["widepreview"];
			$va_temp["label"] = $t_object->get("ca_objects.preferred_labels");
			$va_most_viewed[$vn_r_object_id] = $va_temp;
		}
	}
	# --- recently added
	# -- get object type of fond and subfonds
	$o_lists = new ca_lists;
	$vn_fond_id = $o_lists->getItemIDFromList('object_types', 'fonds');
	$vn_sub_fond_id = $o_lists->getItemIDFromList('object_types', 'sub_fonds');
	$va_recently_added_ids = $t_object->getRecentlyAddedItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1, 'restrictToTypes' => array($vn_fond_id, $vn_sub_fond_id)));
	if(is_array($va_recently_added_ids) && sizeof($va_recently_added_ids) > 0){
		$va_recently_added = array();
		foreach($va_recently_added_ids as $va_item_info){
			$va_temp = array();
			$vn_r_object_id = $va_item_info['object_id'];
			$t_object->load($vn_r_object_id);
			$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'widepreview'), null, array('return_with_access' => $va_access_values));
			$va_temp["widepreview"] = $va_reps["tags"]["widepreview"];
			$va_temp["label"] = $t_object->get("ca_objects.preferred_labels");
			$va_recently_added[$vn_r_object_id] = $va_temp;
		}
	}
?>

<script type="text/javascript">
  	$(document).ready(function() {
    	$("#tabs").tabs({
    		cookie: {
    			expires: 30
    		}
    	});
  	});
</script>
<div style="float:left;">
			<div class="maincolimage" style="margin-top:16px;">
				<img class="showcase" src="<?php print $this->request->getThemeUrlPath()?>/graphics/city/city-archives.jpg" alt="Limerick City Archives" title="" />
			</div>
			<div class="maincol">	
				<h1 style="margin-top:10px;">City Archives</h1>
				

			
<div id="tabs" style="margin-top:20px;">
    <ul>

       	<li class="tabThree" style="height:34px; "><a href="#fragment-3"><span style="float:left;">Most Viewed</span><!--<img style="margin: -3px -5px 0px 7px; float:right;" src="<?php print $this->request->getThemeUrlPath(true)?>/graphics/city/viewed.png" border="0" width="27" height="27"/>--></a></li>
        <li class="tabFour" style="height:34px; "><a href="#fragment-4"><span style="float:left;">What's New</span><!--<img style="margin:-3px 0px 0px 10px; float:right;" src="<?php print $this->request->getThemeUrlPath(true)?>/graphics/city/clip.png" border="0" width="24" height="24"/>--></a></li>
    	<li class="tabTwo" style="height:34px; "><a href="#fragment-2"><span style="float:left;">Browse</span><!--<img style="margin:-5px 0px 0px 10px; float:right;" src="<?php print $this->request->getThemeUrlPath(true)?>/graphics/city/book.png" border="0" width="30" height="30"/>--></a></li>
    	<li class="tabFive" style="height:34px; "><a href="#fragment-5"><span style="float:left;">Showcase</span><!--<img style="margin:-5px 0px 0px 10px; float:right;" src="<?php print $this->request->getThemeUrlPath(true)?>/graphics/city/book.png" border="0" width="30" height="30"/>--></a></li>
    	<li class="tabOne" style="height:34px; "><a href="#fragment-1"><span style="float:left;">Search</span><!--<img style="margin-left:15px; float:right;" src="<?php print $this->request->getThemeUrlPath(true)?>/graphics/city/search1.png" border="0" width="23" height="23"/>--></a></li>
    </ul>
    <div id="fragment-3">
    	<div class="contentstyle">

<?php
	$vn_most_viewed_count = 0;
	if(is_array($va_most_viewed) && sizeof($va_most_viewed) > 0){
		foreach($va_most_viewed as $vn_object_id => $va_info){
			$vs_thumb = $va_info["widepreview"];
			$vs_label = $va_info["label"];
?>
			<div class="mostviewed"><div class="mostviewedcontainer"><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)).caNavLink($this->request, $vs_label, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));?></div></div>
<?php
			$vn_most_viewed_count++;
		}
	}
?>
    	</div>
    <div style="clear:both; height:1px;"><!-- empty --></div>
    </div>
    <div id="fragment-4">
    	<div class="contentstyle">

<?php
	$vn_recently_added_count = 0;
	if(is_array($va_recently_added) && sizeof($va_recently_added) > 0){
		foreach($va_recently_added as $vn_object_id => $va_info){
			$vs_thumb = $va_info["widepreview"];
			$vs_label = $va_info["label"];
?>
			<div class="mostviewed"><div class="mostviewedcontainer"><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)).caNavLink($this->request, $vs_label, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));?></div></div>
<?php
			$vn_recently_added_count++;
		}
	}
?>
			<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" title="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>
        </div>
    <div style="clear:both; height:1px;"><!-- empty --></div>
    </div>
    <div id="fragment-2">
    	<div class="contentstyle">
        	<div id="hpBrowse">
<?php
				$va_facets = $this->getVar('available_facets');
# --- comment out facet list
if($xxx){
				print "<div id='hpBrowsetitle'>"._t("Begin browsing by:")."</div>";
				print "<div id='hpBrowseLinks'>";
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" onclick="$('#splashBrowseTabPanel').show(); jQuery('#splashBrowseTabPanel').load('<?php print caNavUrl($this->request, '', 'Browse', 'getFacet', array('facet' => $vs_facet_name, 'view' => 'for_splash')); ?>'); return false;"><?php print ucwords($va_facet_info['label_plural']); ?></a>
<?php
					}
?>
				</div><!-- end hpBrowseLinks -->
<?php
}
?>
				<div id="splashBrowseTabPanel" class="browseTabPanel2"></div>
				<script type="text/javascript">
					$(document).ready(function() {
						jQuery('#splashBrowseTabPanel').load('<?php print caNavUrl($this->request, '', 'Browse', 'getFacet', array('facet' => 'title_facet', 'view' => 'for_splash')); ?>');
						return false;
						
					});
				</script>
			</div><!-- end hpBrowse -->
    	</div><!-- end contentstyle -->
    	<div style="clear:both; height:1px;"><!-- empty --></div>
    </div><!-- end fragment-2 -->    
        <div id="fragment-1">
    	<div class="contentstyle">
    		<div class="tabsearch" >
    			<?php print "<h2>"._t("Search the Archive")."</h2>";?>
					<form action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get" id="searchform1">
						<fieldset style="border:0px">
							<p><label for="keyword">by keyword</label><input type="text" name="search" size="20" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" /><input type="hidden" name="searchtype" value="keyword" /><input class="button" type="image" src="<?php print $this->request->getThemeUrlPath()?>/graphics/city/search-button.png" alt="search" /></p>
						</fieldset>
					</form>
			</div>
    	</div>
    	<div style="clear:both; height:1px;"><!-- empty --></div>
    </div>
    <div id="fragment-5">
    	<div class="contentstyle">

<?php
	# -- get archival showcase collections
	# -- get the collection type
	$o_lists = new ca_lists;
	$vn_showcase_collection_type_id = $o_lists->getItemIDFromList('collection_types', 'archival_showcase');
	$o_collectionSearch = new CollectionSearch();
	$o_collectionSearch->addResultFilter("ca_collections.access", "IN", join($va_access_values, ", "));	
	$o_collectionSearch->addResultFilter("ca_collections.type_id", "=", $vn_showcase_collection_type_id);	
	
	$o_showcase_collection_results = $o_collectionSearch->search("*");

	$vn_collection_count = 0;
	if($o_showcase_collection_results->numHits() > 0){
		while($o_showcase_collection_results->nextHit()){
			$vs_thumb = "";
			# --- get an item from the collection to use it's media as the thumbnail
			$o_collectionItemSearch = new ObjectSearch();
			$o_collectionItemSearch->addResultFilter("ca_collections.collection_id", "=", $o_showcase_collection_results->get("collection_id"));	
			$o_collectionItemSearch->addResultFilter("ca_objects.access", "IN", join($va_access_values, ", "));
			$o_collectionItemSearchResults = $o_collectionItemSearch->search("*");
			if($o_collectionItemSearchResults->numHits()){
				while($o_collectionItemSearchResults->nextHit()){
					if($vs_thumb = $o_collectionItemSearchResults->getMediaTag('ca_object_representations.media', 'widepreview', array('checkAccess' => $va_access_values))){
						break;
					}
				}
			}
			
			$va_labels = $o_showcase_collection_results->getDisplayLabels($this->request);
			$vs_label = join($va_labels, "; ");
?>
			<div class="mostviewed"><div class="mostviewedcontainer"><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Collection', 'Show', array('collection_id' => $o_showcase_collection_results->get("ca_collections.collection_id"))).caNavLink($this->request, $vs_label, '', 'Detail', 'Collection', 'Show', array('collection_id' => $o_showcase_collection_results->get("ca_collections.collection_id")));?></div></div>
<?php
			$vn_collection_count++;
		}
	}
?>
		</div>
    <div style="clear:both; height:1px;"><!-- empty --></div>
    </div><!-- end fragment 5 -->
</div>		
</div>
</div>
