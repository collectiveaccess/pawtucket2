<?php
	$va_results = $this->getVar('results');
	$vn_result_count = (int)$va_results['_info_']['totalCount'];
?>
<div class="multiSearch">

<?php
	if ($vn_result_count > 0) {
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

	
<?php
	} 
?>
	<a name='Site'></a>

	<div class='blockTitle siteSearchDisplay'>Site</div>
	<div class='blockResults siteSearchDisplay' style='height:auto;'>
		<div id="siteSearchResults">
	
		</div>
	</div>
<?php	
	if ($vn_result_count == 0) {
		print "<div id='noResultsMsg'><H2>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H2></div>";
	}
?>
</div>

<script type="text/javascript">
	jQuery("#noResultsMsg").css( "display", "none");
	jQuery(".siteSearchDisplay").css( "display", "none");
	jQuery(document).ready(function() {
		// grab search results
		jQuery.getJSON("http://<?php print $_SERVER['HTTP_HOST']; ?>/services/search/search_node/retrieve.json", <?php print json_encode(array('keys' => $this->getVar('search'))); ?>, function(d) {
			
			var hits = [];
			var numHits = 0;
			if (d && (d.length > 0)) {
				jQuery(d).each(function(k, v) {
					if (v['type'] != 'Basic page') { return; }
					hits.push("<a href='" + v['link'] + "' class='siteResult'>" + v['title'] + "</a>");
					numHits++;
				});
			}
			if (numHits === 0){
				jQuery(".siteSearchDisplay").css( "display", "none");
				jQuery("#noResultsMsg").css( "display", "block");
			} else {
				jQuery(".siteSearchDisplay").css( "display", "block");
				jQuery("#noResultsMsg").css( "display", "none");
			}
			
			jQuery("#siteSearchResults").html(hits.join("<br/>"));
		}).fail(function() {
			jQuery(".siteSearchDisplay").css( "display", "none");
			jQuery("#noResultsMsg").css( "display", "block");
		});
	});
</script>