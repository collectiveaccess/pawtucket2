<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
?>
<div id="multiSearch">
<?php
	if ($va_result_count > 0) {
?>
		<small class='pull-right'>
<?php
		$i = 0;
		foreach($this->getVar('blockNames') as $vs_block) {
			$i++;
			if ($va_results[$vs_block]['count'] == 0) { continue; }
			if($i > 1){
				print " | ";
			}
			print "<a href='#{$vs_block}'>".$va_results[$vs_block]['displayName']." (".$va_results[$vs_block]['count'].")</a>";
		}
?>
		</small>
		<h1><?php print _t("Search results for %1", caUcFirstUTF8Safe($this->getVar('search'))); ?></h1>
<?php
		// 
		// Print out block content (results for each type of search)
		//
		foreach($this->getVar('blockNames') as $vs_block) {
?>
			<a name='<?php print $vs_block; ?>'></a>
			<div id="<?php print $vs_block; ?>Block" >
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
		} 
	} else {
		print "<H1>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H1>";
	}
?>
</div>