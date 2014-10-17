<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
?>
<div class="multiSearch">

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
?>
	<a name='Site'></a>
	<small class="pull-right sortMenu">
		<a href="http://<?php print $_SERVER['HTTP_HOST']; ?>/search/content/<?php print rawurlencode($this->getVar('search')); ?>" class="fullResults">Full results</a>
	</small>
	<div class='blockTitle'>Site</div>
	<div class='blockResults'>
		<div id="SiteBlock">
	
		</div>
	</div>
	
<?php
	} else {
		print "<H2>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H2>";
	}
?>

</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		// grab search results
		jQuery.getJSON("http://<?php print $_SERVER['HTTP_HOST']; ?>/services/search/search_node/retrieve.json", <?php print json_encode(array('keys' => $this->getVar('search'))); ?>, function(d) {
			
			var hits = [];
			
			if (d && (d.length > 0)) {
				jQuery(d).each(function(k, v) {
					hits.push("<a href='" + v['link'] + "'>" + v['title'] + "</a>");
				});
			} else {
				hits.push("No results found");
			}
			
			jQuery("#SiteBlock").html(hits.join("<br/>"));
		});
	});
</script>