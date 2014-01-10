<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
?>
<div id='pageArea' style='min-height:300px;' class='results'>
<?php
	if ($va_result_count > 0) {
?>
	<div id='searchHeader'>
		<h2>Search results for <?php print ucfirst($this->getVar('search')); ?></h2>
		
		<div class='resultCounts'>
<?php
		foreach($this->getVar('blockNames') as $vs_block) {
			print "<div class='count'><a href='#{$vs_block}'>".$va_results[$vs_block]['displayName']."</a> (".$va_results[$vs_block]['count'].") </div>"; 
		}
?>
<!--			<div id='sortMenu'>
				<span>Sort by: <a href='#'>has media</a> / <a href='#'>date</a> / <a href='#'>title</a></span>
			</div>-->
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
<?php

?>
			</div>
<?php
		} 
	} else {
		print "<div class='searchMessage'>Your Search for ".ucfirst($this->getVar('search'))." Returned No Results</div>";
	}
?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
<?php
	foreach($this->getVar('blockNames') as $vs_block) {
?>
		jQuery('#<?php print $vs_block; ?>Result').jscroll({
			debug: true,
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 20,
			nextSelector: 'a.jscroll-next'
		});
<?php
	}
?>
	});
</script>