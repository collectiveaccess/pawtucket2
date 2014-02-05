<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
?>
<div id="multiSearch">

<?php
	if ($va_result_count > 0) {
?>
	<div id="searchHeader">
		<h2><?php print _t("Search results for %1", caUcFirstUTF8Safe($this->getVar('search'))); ?></h2>
		<div class='resultCounts'>
<?php

		foreach($this->getVar('blockNames') as $vs_block) {
			$i++;
			if ($va_results[$vs_block]['count'] == 0) { continue; }
			print "<a href='#{$vs_block}' class='count'>".$va_results[$vs_block]['displayName']." (".$va_results[$vs_block]['count'].")</a>";
		}
?>
		</div><!-- resultCounts -->
	</div><!-- searchHeader -->

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
		print "<H2>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H2>";
	}
?>

</div>
<script type="text/javascript">
	function scrollNext(block){
		var currentPosition = $('#' + block + 'Results').scrollLeft();
		var scrollAmount = $('#' + block + 'Results').width() - ($('#' + block + 'Results').width()/5);
		$('#' + block + 'Results').scrollLeft(currentPosition + scrollAmount);
	}
	function scrollPrevious(block){
		var currentPosition = $('#' + block + 'Results').scrollLeft();
		var scrollAmount = $('#' + block + 'Results').width() - ($('#' + block + 'Results').width()/5);
		$('#' + block + 'Results').scrollLeft(currentPosition - scrollAmount);
	}
</script>