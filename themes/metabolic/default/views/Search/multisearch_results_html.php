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
			<a name='<?php print $vs_block; ?>'></a>
			<div id="<?php print $vs_block; ?>Block" class='resultBlock'>
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
		} 
	} else {
		print "<H1>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H1>";
		
		$o_search = caGetSearchInstance('ca_objects');
		if (sizeof($va_suggestions = $o_search->suggest($this->getVar('search'), array('returnAsLink' => true, 'request' => $this->request)))) {
			if (sizeof($va_suggestions) > 1) {
				print "<p>"._t("Did you mean one of these: %1?", join(', ', $va_suggestions))."</p>";
			} else {
				print "<p>"._t("Did you mean %1?", join(', ', $va_suggestions))."</p>";
			}
		}
	}
?>
<?php
	TooltipManager::add('#Block', 'Type of record');
?>