<?php
$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
$browse_key 		= $this->getVar('key');					// cache key for current browse
$hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
$start		 		= (int)$this->getVar('start');			// offset to seek to before outputting results
$is_advanced		= (int)$this->getVar('is_advanced');

$table 				= $this->getVar('table');
$t_instance			= $this->getVar('t_instance');
$is_search			= ($this->request->getController() == 'Search');
$result_size 		= $qr_res->numHits();

$options			= $this->getVar('options');
$is_ajax			= (bool)$this->request->isAjax();

$num_pages 			= ceil($result_size/$hits_per_block);
?>

<div class="row justify-content-center my-5">
	<div class="col-auto paging">

		<span class="arrow-link" style="transform: scaleX(-1); margin-right: 7px;">
			<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
			</svg>
		</span>

		<?php
			$page_links = [];
			$current_page = 1;
			for($p=1; $p <= $num_pages; $p++) {
				$page_start = ($p-1) * $hits_per_block;
				if($page_start === $start) {
					$page_links[] = "<strong>{$p}</strong>"; //will bold the current page number and add it to links array
					$current_page = $p;
				} else {
					$page_links[] = caNavLink($this->request, "{$p}", "pageLink", '*', '*', '*', ['s' => $page_start, 'key' => $browse_key, '_advanced' => $is_advanced]);
				}
			}
			
			function paginateNumbers($page_array, $currentPage) {
				$totalPages = count($page_array);
				$pages_shown = 8;
				
				$startIndex = 0;
				$endIndex = $totalPages - 1;

				if ($totalPages > $pages_shown) {
					if ($currentPage >= $pages_shown) {
						$startIndex = $currentPage - 2;
						$endIndex = $totalPages - 1;
					} else {
						$endIndex = min($pages_shown - 1, $totalPages - 1);
					}
				}

				$paginatedNumbers = array_slice($page_array, $startIndex, $endIndex - $startIndex + 1);

				if ($startIndex > 0) {
					array_unshift($paginatedNumbers, '...');
				}

				if ($endIndex < $totalPages - 1) {
					$paginatedNumbers[] = '...';
				}

				return $paginatedNumbers;
			}

			$paginatedNumbers = paginateNumbers($page_links, $current_page);

			print join(' ', $paginatedNumbers);

			// $startIndex = max($currentPage - 2, 0);
			// $endIndex = min($currentPage + 3, $totalPages - 1);

			// // Number of links to display initially
			// $initialLinks = 4;

			// // Check if there are more than 6 numbers
			// if (count($page_links) > 6) {

			// 	// if the current page is 4 or greater, start displaying the current page first, then the following 3 pages, then an ellipsis, then the final page number
			// 	if ($current_page >= 4) {

			// 		for ($i = 4; $i >= $initialLinks; $i++) {
			// 			echo $page_links[$i] . " ";
			// 		}
					
			// 		// Display ellipsis
			// 		echo "... ";
					
			// 		// Display the last number
			// 		echo $page_links[count($page_links) - 1];

			// 	}else{

			// 		// Display the first 4 numbers
			// 		for ($i = 0; $i < $initialLinks; $i++) {
			// 			echo $page_links[$i] . " ";
			// 		}
					
			// 		// Display ellipsis
			// 		echo "... ";
					
			// 		// Display the last number
			// 		echo $page_links[count($page_links) - 1];
				
			// 	}

			// } else {
			// 	// Display all numbers if there are 6 or fewer
			// 	foreach ($page_links as $page) {
			// 		echo $page . " ";
			// 	}
			// }

			// print join(' ', $page_links);

		?>

		<span class="arrow-link">
			<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
			</svg>
		</span>

	</div>	
</div>