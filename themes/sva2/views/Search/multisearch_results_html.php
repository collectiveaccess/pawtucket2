<div class="container-fluid search-results-container">

	<!-- <div class="row breadcrumb-nav justify-content-start">
			<ul class="breadcrumb">
				<li><a href="/index.php/">Featured Exhibitions</a></li>
				<li><span class="material-icons">keyboard_arrow_right</span></li>
				<li>Search Results</li>
			</ul>
	</div> -->

	<div class="row filter-search-heading justify-content-start">
		<h2>Filter Search Results</h2>
		<div class="line-border"></div>
	</div>

	<?php
		$va_results = $this->getVar('results');
		$va_result_count = $va_results['_info_']['totalCount'];
		if ($va_result_count > 0) {
	?>
		<?php
			// Print out block content (results for each type of search)
			foreach($this->getVar('blockNames') as $vs_block) {
		?>
				<div class="row <?php print $vs_block; ?>Block">
					<?php print $va_results[$vs_block]['html']; ?>
				</div>
		<?php
			} 
		} else {
			print "<div class='row no-results mt-5 justify-content-center'><h2>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</h2></div>";
		}
		?>

</div> <!--container end-->