<div class="multisearch">
<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
?>
<div class="page_title">
	<h1>Search Results</h1>
    <div class="ornament">
<?php
        $ornaments = array(
            'head_ornament-10.svg',
            'head_ornament-11.svg',
            'head_ornament-12.svg',
        );
        $rand_ornament = array_rand($ornaments, 1);
		print caGetThemeGraphic($this->request, $ornaments[$rand_ornament], array("class" => "page_title_ornament", "alt" => "Header Ornament"));
?>
    </div>
</div>
<div class="multisearch text_content">
<?php
	

	if ($va_result_count > 0) {
		print "<h2 class='searchFor'>Showing results for: <i>".caUcFirstUTF8Safe($this->getVar('searchForDisplay'))."</i></h2>";
		// 
		// Print out block content (results for each type of search)
		//
		foreach($this->getVar('blockNames') as $vs_block) {
?>
			<a name='<?php print $vs_block; ?>'></a>
			<div id="<?php print $vs_block; ?>Block" class='resultBlock'>
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
		} 
	}else{
		print "<H2>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H2>";
	}
?>
<?php
	TooltipManager::add('#Block', 'Type of record');
?>
</div>
</div>