<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
	if ($va_result_count > 0) {
?>
		<div id="multisearchResultsContainer">
			<h1><?php print caUcFirstUTF8Safe($this->getVar('searchForDisplay')); ?></h1>
		
<?php
		// 
		// Print out block content (results for each type of search)
		//
		foreach($this->getVar('blockNames') as $vs_block) {
?>
			<div id="<?php print $vs_block; ?>Block">
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
		}
?>
		</div>
<?php 
	} else {
		print "<H1>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H1>";
	}
?>