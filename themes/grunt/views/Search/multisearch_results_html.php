<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
	if ($va_result_count > 0) {
?>
		<small class='pull-right jumpLinks'>
<?php
		$i = 0;
		foreach($this->getVar('blockNames') as $vs_block) {
			if ($va_results[$vs_block]['count'] == 0) { continue; }
			$i++;
			if($i > 1){
				print " | ";
			}
			print "<a href='#{$vs_block}'>".$va_results[$vs_block]['displayName']." (".$va_results[$vs_block]['count'].")</a>";
		}
?>
		</small>
		<h1><?php print _t("Search results for %1", caUcFirstUTF8Safe($this->getVar('searchForDisplay'))); ?></h1>
<?php
		// 
		// Print out block content (results for each type of search)
		//
		foreach($this->getVar('blockNames') as $vs_block) {
?>
			<a href='#' name='<?php print $vs_block; ?>' aria-label='<?php print $vs_block; ?>'></a>
			<div id="<?php print $vs_block; ?>Block" class='resultBlock'>
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
		} 
	} else {
		print "<H1 class='noSearchResults'>Sorry, your search for \"".caUcFirstUTF8Safe($this->getVar('search'))."\" returned no results. Please check your spelling, try the ".caNavLink($this->request, "advanced search", "", "Search", "advanced", "objects").", or ".caNavLink($this->request, "contact us", "", "", "Contact", "form")." for assistance.</H1>";
	}
?>
<?php
	TooltipManager::add('#Block', 'Type of record');
?>