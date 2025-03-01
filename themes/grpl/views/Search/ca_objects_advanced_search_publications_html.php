<?php
	$searchInfo = $this->getVar("searchInfo");
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Search newspapers and magazines</h1>

<?php
print "<p>Enter your search terms in the fields below</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields">Full Text</span>
			{{{metsalto%height=1}}}
		</div>
	</div>
		<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Exclude results with text">Exclude Words</span>
			{{{metsalto_exclude%height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit search to a single date or date range">Date range <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.date.date_value%useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search file identifiers">File ID</span>
			{{{ca_objects.idno}}}
		</div>
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
	</div>
</div>

{{{/form}}}

	</div>
	<div class="col-sm-4" >
		<p><?php print caNavLink($this->request, _t("Learn tips for searching"), "btn btn-default", "", "about", "newspaperhelp"); ?></p>
		<h2>Other searches</h2>
		<p><?php print caNavLink($this->request, "Search entire collection", "", "", "Search", "advanced/objects"); ?></p>
		<p><?php print caNavLink($this->request, "Search for images", "", "", "Search", "advanced/all_images"); ?></p>
		<p><i class="fas fa-caret-right"></i> <?php print caNavLink($this->request, "Search newspapers and magazines", "", "", "Search", "advanced/publications"); ?></p>
		<p><?php print caNavLink($this->request, "Search WWI registration cards", "", "", "Search", "advanced/regcard"); ?></p>
		<hr></hr>
<?php
#	if($set_code = $searchInfo["featuredCollectionsSetCode"]){
#		$t_set = new ca_sets(array("set_code" => $set_code));
#		if($t_set->get("ca_sets.set_id")){
#			$va_collection_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
#			if(is_array($va_collection_ids) && sizeof($va_collection_ids)){
#				$r_collections = caMakeSearchResult('ca_collections', $va_collection_ids);
#				if($r_collections->numHits()){
#					print "<h2>Newspaper and magazine titles</h2>";
#					while($r_collections->nextHit()){
#						print "<p>".$r_collections->getWithTemplate("<l>^ca_collections.preferred_labels.name<ifdef code='ca_collections.date.date_value'>, ^ca_collections.date.date_value</ifdef></l>")."</p>";	
#					}
#				}
#			}
#		}
#	}
	$t_collection = new ca_collections(array("idno" => "newspaper_collection"));
	print $t_collection->getWithTemplate("<l class='btn btn-default'>All Newspaper & Magazine Titles</l>");
?>
<!--		
		<h2>Newspaper and magazine titles</h2>
		<p><?php print caNavLink($this->request, "Furniture periodicals, 1906-1910, 1937-1937", "", "", "Detail", "collections/13"); ?></p>
		<p><?php print caNavLink($this->request, "Grand Rapids Herald, 1893-1917", "", "", "Detail", "collections/24"); ?></p>
		<p><?php print caNavLink($this->request, "New River Free Press, 1973-1977", "", "", "Detail", "collections/6"); ?></p>
		<p><?php print caNavLink($this->request, "Peninsular Club News, 1934-1943", "", "", "Detail", "collections/7"); ?></p>
		<p><?php print caNavLink($this->request, "Woman magazine, 1908", "", "", "Detail", "collections/11"); ?></p>
-->

	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover();
	});
</script>
