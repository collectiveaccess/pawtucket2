<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
	if ($va_result_count > 0) {
?>
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<h4 style='margin-bottom:10px; letter-spacing:1px;float:left;'><?php print _t("Search results for %1", caUcFirstUTF8Safe($this->getVar('searchForDisplay'))); ?></h4>
	
		<small class='pull-right' style='margin-top:20px;margin-bottom:10px;'>
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
		print "<H3>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H3>";
	}
?>
	</div>
	<div class="col-sm-1"></div>
<?php
	TooltipManager::add('#Block', 'Type of record');
?>