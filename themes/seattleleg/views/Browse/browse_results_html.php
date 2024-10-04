<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
$va_facets 			= $this->getVar('facets');				// array of available browse facets
$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
$vn_is_advanced		= (int)$this->getVar('is_advanced');
$vb_showLetterBar	= (int)$this->getVar('showLetterBar');	
$va_letter_bar		= $this->getVar('letterBar');	
$vs_letter			= $this->getVar('letter');
$vn_row_id 			= $this->request->getParameter('row_id', pInteger);

$va_views			= $this->getVar('views');
$vs_current_view	= $this->getVar('view');
$va_view_icons		= $this->getVar('viewIcons');

$vs_current_sort	= $this->getVar('sort');
$vs_sort_dir		= $this->getVar('sort_direction');

$vs_table 			= $this->getVar('table');
$t_instance			= $this->getVar('t_instance');

$vb_is_search		= ($this->request->getController() == 'Search');

$vn_result_size 	= (sizeof($va_criteria) > 0) ? $qr_res->numHits() : $this->getVar('totalRecordsAvailable');

$results_per_page = 200;
$total_pages = ceil($total_records / $results_per_page);

$va_options			= $this->getVar('options');
$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);
$vb_ajax			= (bool)$this->request->isAjax();
$va_browse_info = $this->getVar("browseInfo");
$o_config = $this->getVar("config");
$vs_result_col_class = $o_config->get('result_col_class');
$vs_refine_col_class = $o_config->get('refine_col_class');
$va_export_formats = $this->getVar('export_formats');
$va_browse_type_info = $o_config->get($va_browse_info["table"]);
$va_all_facets = $va_browse_type_info["facets"];	
$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
			
$action = $this->request->getAction();	// form type (Eg. "combined")

if (!$vb_ajax) {	// !ajax
?>

<div class="row" style="clear:both;">
	<div class="col-sm-12">


<div id="search_results">

  <a name="h0"></a>

  <h2><?= $va_browse_info['displayName'] ?? '???'; ?></h2>

	<?php
			switch($action) {
				case 'combined':
	?>
						<p>
							<strong style="color: maroon;">This database contains legislation that has already been acted on by Council (passed, retired, etc.).
							Legislation currently in process can be found here: <a class="text-decoration-underline" href="https://seattle.legistar.com/Legislation.aspx" target="_blank">Current Legislation</a>.</strong>
							Please visit our <a class="text-decoration-underline" href="http://www.seattle.gov/cityclerk/legislation-rules-records-and-resources/a-new-way-to-view-legislation-and-agendas" target="_blank">FAQ</a> page for additional information.
						</p>
						<p>
							To narrow your results or for advanced searching, you may wish to search on each database separately. Refer to the list of
							<a class="text-decoration-underline" href="/">all Clerk and Municipal Archives records indexes</a> to navigate.
						</p>
	<?php
					break;
				case 'bills':
	?>
						<p>
							<strong style="color: maroon">This database contains legislation that has already been acted on by Council (passed, retired, etc.). Legislation currently in process can be found here: <a href="https://seattle.legistar.com/Legislation.aspx" target="_blank">Current Legislation</a>.</strong>
						</p>
	<?php
					break;
				case 'resolutions':
	?>
						<p>
							<strong style="color: maroon">This database contains legislation that has already been acted on by Council (passed, retired, etc.).
							Legislation currently in process can be found here: <a href="https://seattle.legistar.com/Legislation.aspx" target="_blank">Current Legislation</a>.</strong>
							Please visit our <a href="http://www.seattle.gov/cityclerk/legislation-rules-records-and-resources/a-new-way-to-view-legislation-and-agendas" target="_blank">FAQ</a> page for additional information.
						</p>
	<?php
					break;
				case 'clerk':
	?>
						<p>
							<strong style="color: maroon">This database contains legislation that has already been acted on by Council (passed, retired, etc.).
							Legislation currently in process can be found here: <a href="https://seattle.legistar.com/Legislation.aspx" target="_blank">Current Legislation</a>.</strong>
							Please visit our <a href="http://www.seattle.gov/cityclerk/legislation-rules-records-and-resources/a-new-way-to-view-legislation-and-agendas" target="_blank">FAQ</a> page for additional information.
						</p>
	<?php
		}
	?>

  <hr>
	<a name="h0" role="button" aria-label="anchor"></a>		
  <div id="top-search-nav" class="d-flex justify-content-between">
		<nav class="nav-icons mb-2 mb-md-0" aria-label="top search results">
			<ul class="nav">
				<li>
<?php
				print caNavLink($this->request, "<i class='bi bi-house-door-fill' aria-label='Home' title='Home'></i>", "", "", "", "");
?>
				</li>
				<li>
<?php
				print caNavLink($this->request, "<i class='bi bi-search' aria-label='Back to Search Form'></i>", "", "Search", "advanced", $action, null, array("title" => "Back to Search Form", "aria-label" => "Back to Search Form"));
?>
				</li>
<?php
				$pagebar = $this->render("Browse/paging_bar_html.php"); 
				print $pagebar;
?>

				<li>
					<a href="#hb" aria-label="page down" title="Jump to bottom">
						<i class="bi bi-chevron-double-down" aria-label="Jump to bottom"></i>
					</a>
				</li>
				<li>
					<a href="https://clerk.seattle.gov/search/help/" title="Help">
						<i class="bi bi-question-lg" aria-label="Help" ></i>
					</a>
				</li>
			</ul>
		</nav>

		<div id="export-controls">
			<button onclick="document.location='<?= caNavUrl($this->request, '*', '*', '*', ['view' => 'xlsx', 'export_format' => 'excel']); ?>'; return false;" class="btn btn-sm btn-primary">
				<i class="bi bi-download"></i> Export
			</button>
			<br />

				<button class="modalButtonLink" data-bs-toggle="modal" data-bs-target="#ExportingResults">What's this?</button>
				<div class="modal fade" id="ExportingResults" aria-labelledby="ExportModalTitle">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<div id="ExportModalTitle" class="centered fw-bold fs-3 pb-1">Exporting Search Results</div>
								<p>Clicking the button will download your results to a CSV (comma-separated values) file, which can be opened in Microsoft Excel or most other spreadsheet software.</p>
								<ul>
									<li>Data is continually added and revised for accuracy. Your results will not be automatically updated after you export, until you do a new search and export again.</li>
									<li>This feature is only enabled for legislation at the present time.</li>
									<li>Exporting includes all public data fields except for full text.</li>
									<li>Even if your search spans multiple pages, your export will contain everything.</li>
									<li>Exports are currently limited to a maximum of 25,000 records per download.</li>
								</ul>
							</div>
						<button class="btn btn-primary" data-bs-dismiss="modal">Close</button></div>
					</div>
				</div>

		</div>
  </div>
<?php
	$s = $vn_start + 1;
	$e = $vn_start + $vn_hits_per_block;
	if($e > $vn_result_size) { $e = $vn_result_size; }
	
	$search_str = $va_criteria[0]['value'];
?>
  <strong>Documents:</strong> <?= $s; ?> - <?= $e; ?> of <?= $vn_result_size ?> &nbsp; <strong>Search String</strong> <span class="queries"> : <?= $search_str; ?> </span>
  <br>
	<hr>

		<div class="row">
			<div class="col-md-12">
			<!-- <div class="col-md-12 col-lg-5"> -->
				<H3 class="text-capitalize fs-1">
					<?php
							print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("Result") : _t("Results"));	
					?>		
				</H3>
			</div>
		</div>
		<div id="browseResultsContainer">
					<table style="width: 100%;" class="table table-striped overflow-x-auto">
						<tbody>

						<!-- TODO: For each type alter columns
						 	Combined
						 	Agendas
							Council bills and ordinances
							Resolution
							Comptroller / Clerk file 
							Minutes
							Committee history
							Meeting
						-->
						 

						<?php
								switch($action) {
									case 'combined':
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "File Type".(($vs_current_sort == "Type") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Type") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Type', 'direction' => (($vs_current_sort == "Type") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap">Number</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Filed / Meeting Date".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Title".(($vs_current_sort == "Title") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Title") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Title', 'direction' => (($vs_current_sort == "Title") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>
						<?php
								break;
								case 'agenda':
									// Agendas search results: 
									// 1) Remove "File Type"
									// 2) Remove "Number"  
									// 3) Remove "Filed"
									// 5) Remove Title
									// 4) Add "Meeting Date" (ca_objects.DATE)
									// 6) Add "Committee" (ca_objects.COMM)
									// 7) Sort on "Meeting Date" (ca_objects.DATE)
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Meeting Date".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Committee".(($vs_current_sort == "Committee") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Committee") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Committee', 'direction' => (($vs_current_sort == "Committee") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>
						<?php
								break;
								case 'bills':
								// 1) Remove "File Type"
								// 2) Change label "Number" to "Ordinance Number" 
								// 3) Add "Council Bill Number" (ca_objects.CBN)
								// 4) Add "Passed" (ca_objects.DTSI)
								// 5) Truncate title field
								// 6) Sort on "Passed" (ca_objects.DTSI — descending
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Ordinance Number".(($vs_current_sort == "Ordinance_Number") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Ordinance_Number") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Ordinance_Number', 'direction' => (($vs_current_sort == "Ordinance_Number") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Council Bill Number".(($vs_current_sort == "Council_Bill_Number") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Council_Bill_Number") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Council_Bill_Number', 'direction' => (($vs_current_sort == "Council_Bill_Number") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Filed".(($vs_current_sort == "Filed") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Filed") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Filed', 'direction' => (($vs_current_sort == "Filed") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Passed".(($vs_current_sort == "Passed") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Passed") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Passed', 'direction' => (($vs_current_sort == "Passed") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Title".(($vs_current_sort == "Title") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Title") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Title', 'direction' => (($vs_current_sort == "Title") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>
						<?php
								break;
								case 'resolutions':
								// Resolution search results: 
								// 1) Remove "File Type"
								// 2) Truncate title field
								// 3) Sort by date filed (ca_objects.DTF — descending)
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap">Number</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Filed".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Title".(($vs_current_sort == "Title") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Title") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Title', 'direction' => (($vs_current_sort == "Title") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>
						<?php
								break;
								case 'clerk':
								// Comptroller / Clerk file search results: 
								// 1) Truncate title field
								// 2) Sort by date filed (ca_objects.DTF — descending)
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "File Type".(($vs_current_sort == "Type") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Type") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Type', 'direction' => (($vs_current_sort == "Type") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap">Number</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Filed".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Title".(($vs_current_sort == "Title") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Title") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Title', 'direction' => (($vs_current_sort == "Title") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>	
						<?php
								break;
								case 'minutes':
								// Minutes search results: 
								// 1) Remove "File Type" 
								// 2) Remove "Number" 
								// 3) Remove "Filed" 
								// 4) Add "Meeting Date" (ca_objects.DATE) 
								// 5) Remove Title 
								// 6) Add "Committee" (ca_objects.COMM) 
								// 7) Sort on "Meeting Date" (ca_objects.DATE)
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Meeting Date".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Committee".(($vs_current_sort == "Committee") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Committee") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Committee', 'direction' => (($vs_current_sort == "Committee") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>
						<?php
								break;
								case 'meetings':
								// Meeting search results:
								// 1) Remove "File Type"
								// 2) Remove "Number"
								// 3) Remove "Filed"
								// 4) Add "Meeting Date" (ca_occurrences.DATE)
								// 5) Sory on "Meeting Date" (ca_occurrences.DATE)
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Meeting Date".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Title".(($vs_current_sort == "Title") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'asc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Title") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Title', 'direction' => (($vs_current_sort == "Title") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>
						<?php
								break;
								case 'committees':
								// Committee history search results:
								// 1) Remove "File Type"
								// 2) Remove "Number"
								// 3) Remove "Filed"
								// 4) Add "Dates" (ca_entities.comm_date)
								// 5) Change label "Title" to "Committee Name"
								// 6) Sort on "Dates" (ca_entities.comm_date)
						?>
								<tr>
									<th class="text-nowrap">Result</th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Dates".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
									<th class="text-nowrap"><?php print caNavLink($this->request, "Committee Name".(($vs_current_sort == "Title") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Title") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Title', 'direction' => (($vs_current_sort == "Title") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								</tr>
						<?php
							}
						?>


							<!-- <tr>
								<th class="text-nowrap">Result</th>
								<th class="text-nowrap"><?php print caNavLink($this->request, "File Type".(($vs_current_sort == "Type") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Type") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Type', 'direction' => (($vs_current_sort == "Type") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								<th class="text-nowrap">Number</th>
								<th class="text-nowrap"><?php print caNavLink($this->request, "Filed".(($vs_current_sort == "Date") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Date") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Date', 'direction' => (($vs_current_sort == "Date") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "desc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
								<th class="text-nowrap"><?php print caNavLink($this->request, "Title".(($vs_current_sort == "Title") ? ' <i class="bi bi-sort-down'.(($vs_sort_dir == 'desc') ? '' : '-alt').'" aria-label="direction"></i>' : ''), (($vs_current_sort == "Title") ? "link-secondary" : ""), '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => 'Title', 'direction' => (($vs_current_sort == "Title") ? (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")) : "asc"), '_advanced' => $vn_is_advanced ? 1 : 0)); ?></th>
							</tr> -->

					
							<?php
								} // !ajax
								# --- check if this result page has been cached
								# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
								$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id.$vs_letter);
								if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
									print ExternalCache::fetch($vs_cache_key, 'browse_results');
								}else{
									$vs_result_page = $this->render("Browse/browse_results_list_html.php");
									ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
									print $vs_result_page;
								}		
							
							?>
						</tbody>
					</table>
			</div><!-- end browseResultsContainer -->

	<hr>

  <strong>Documents:</strong> <?= $s; ?> - <?= $e; ?> of <?= $vn_result_size ?> &nbsp; <strong>Search String</strong><span class="queries">: <?= $search_str; ?> </span>
	<br>

  <hr>

  <div id="bottom-search-nav">
	<nav class="nav-icons mb-2 mb-md-0" aria-label="bottom search results">
		<ul class="nav">
			<li>
<?php 
				print caNavLink($this->request, "<i class='bi bi-house-door-fill' aria-label='Home' title='Home'></i>", "", "", "", "");
?>
			</li>
			<li>
<?php
				print caNavLink($this->request, "<i class='bi bi-search' aria-label='Back to Search Form'></i>", "", "Search", "advanced", $action, null, array("title" => "Back to Search Form", "aria-label" => "Back to Search Form"));
?>
			</li>
<?php		
		print $pagebar;
?>
			<li>
				<a href="#h0" aria-label="page up" title="Back to Top">
				  <i class="bi bi-chevron-double-up" aria-label="Back to Top"></i>
				</a>
			</li>
			<li>
				<a href="https://clerk.seattle.gov/search/help/" aria-label="help" title="Help">
				  <i class="bi bi-question-lg" aria-label="Help"></i>
				</a>
			</li>
		</ul>
	</nav>
  </div>

  <a id="hb" role="button" aria-label="anchor"></a>

</div>


	</div><!-- end col -->
</div><!-- end row -->
