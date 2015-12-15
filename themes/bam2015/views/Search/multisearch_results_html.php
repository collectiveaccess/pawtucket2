<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
	if ($va_result_count > 0) {
?>
		<small class='pull-right'>
<?php
		print caNavLink($this->request, 'Advanced Search', 'btn-default', '', 'Search', 'advanced/objects');
?>
		</small>
		<div class="leader text-center">Search Results</div>
		<h2 class="text-center"><?php print $this->getVar('search'); ?></h2>
<?php
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
	} else {
		print "<H1>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H1>";
	}
?>
<?php
	
	
	
	TooltipManager::add('#Block', 'Type of record');
?>