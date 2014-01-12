<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
?>
<div id='pageArea' style='min-height:300px;' class='results'>
<?php
	if ($va_result_count > 0) {
?>
	<div id='searchHeader'>
		<h2><?php print _t("Search results for %1", caUcFirstUTF8Safe($this->getVar('search'))); ?></h2>
		
		<div class='resultCounts'>
<?php
		foreach($this->getVar('blockNames') as $vs_block) {
			if ($va_results[$vs_block]['count'] == 0) { continue; }
			print "<div class='count'><a href='#{$vs_block}'>".$va_results[$vs_block]['displayName']."</a> (".$va_results[$vs_block]['count'].") </div>"; 
		}
?>
		</div>
	</div>	
<?php
		// 
		// Print out block content (results for each type of search)
		//
		foreach($this->getVar('blockNames') as $vs_block) {
?>
			<a name='<?php print $vs_block; ?>'/>
			<div id="<?php print $vs_block; ?>Block" >
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
		} 
	} else {
		print "<div class='searchMessage'>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</div>";
	}
?>
</div>