<?php
	$va_results = $this->getVar('results');
?>
<div id='searchHeader'>
	<h2>Search results for <?php print $this->getVar('search'); ?></h2>
	<div class='resultCounts'>
<?php
	foreach($this->getVar('blockNames') as $vs_block) {
		print "<div class='count'>".$va_results[$vs_block]['displayName']." (".$va_results[$vs_block]['count'].") </div>"; 
	}
?>
	<div id='sortMenu'>
		<span>Sort by: <a href='#'>has media</a> / <a href='#'>date</a> / <a href='#'>title</a></span>
	</div>
	</div>
</div>	
<?php
	// 
	// Print out block content (results for each type of search)
	//
	foreach($this->getVar('blockNames') as $vs_block) {
?>
	<div id="<?php print $vs_block; ?>Block" >
		<?php print $va_results[$vs_block]['html']; ?>
	</div>
<?php
	}
	
?>