<div class="container-fluid">
	<div class="row">
        <div class='col-sm-12'>
			<ul class="breadcrumbs--nav" id="breadcrumbs">
				<li><a href="/index.php/">SVA Exhibitions Archives</a></li>
				<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?></li>
				<li>Search Results</li>
			</ul>
		</div>  	
	</div>
<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
	if ($va_result_count > 0) {
?>
		<div class="row">
			<div class="col-sm-12 col-md-12 search">
				<h2><?php print _t("Search Results: %1", caUcFirstUTF8Safe($this->getVar('searchForDisplay'))); ?></h2><hr>
			</div>			
		</div>
		<div class="row">
			<div class="col-sm-2"><div class="position-sticky">
				<div class="jump pb-5">Showing results from:<br><br>
<?php
					$i = 0;
					foreach($this->getVar('blockNames') as $vs_block) {
						if ($va_results[$vs_block]['count'] == 0) { continue; }
						$i++;
						if($i > 1){
							print " <br>";
						}
						print "<div class='space'><a href='#{$vs_block}'>".$va_results[$vs_block]['displayName']." (".$va_results[$vs_block]['count'].")</a></div>";
					}
?>
				</div></div>
			</div>
			<div class="col-sm-10">
		
<?php
		// 
		// Print out block content (results for each type of search)
		//
		foreach($this->getVar('blockNames') as $vs_block) {
?>

			<a name='<?php print $vs_block; ?>'></a><div></div>
			<div id="<?php print $vs_block; ?>Block" class=' resultBlock mb-4'>
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
	
<?php
		} 
	} else {
		print "<div class='search'><H2>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H2></div>";
	}
?>
</div>
</div>
