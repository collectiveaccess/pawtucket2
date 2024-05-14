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
	
if (!$vb_ajax) {	// !ajax
?>

<div class="row" style="clear:both;">


<div id="search_results">

  <a name="h0"></a>

  <h2>Combined Legislative Records Search</h2>
  <p>
    <strong style="color: maroon;">
      This database contains legislation that has already been acted on by Council (passed, retired, etc.). Legislation currently in process can be found here:
      <a href="https://seattle.legistar.com/Legislation.aspx" target="_blank">Current Legislation</a>.
    </strong>
    Please visit our <a href="http://www.seattle.gov/cityclerk/legislation-rules-records-and-resources/a-new-way-to-view-legislation-and-agendas" target="_blank">FAQ</a> page for additional information.
  </p>
  <p>
    To narrow your results or for advanced searching, you may wish to search on each database separately. Refer to the list of
    <a href="/search/">all Clerk and Municipal Archives records indexes</a> to navigate.
  </p>
  <hr />

  <div id="top-search-nav" class="d-flex inline-block justify-content-between">

		<div class="nav-icons">
			<a name="h0"></a>

			<a href="/">
				<i class="bi bi-house-door-fill"></i>
			</a>

			<a href="/Search/advanced/combined">
				<i class="bi bi-search"></i>
			</a>

			<!-- TODO: Add pagination here -->
			<a href="">
				<i class="bi bi-chevron-double-left"></i>
			</a>
			<a href="">
				<i class="bi bi-chevron-double-right"></i>
			</a>

			<a href="#hb">
				<i class="bi bi-chevron-double-down"></i>
			</a>

			<a href="https://clerk.seattle.gov/search/help/">
				<i class="bi bi-question-lg"></i>
			</a>
		</div>

		<div id="export-controls">
			<button onclick="" class="btn btn-sm btn-primary">
				<i class="bi bi-download"></i>
				EXPORT
			</button>
			<br />
			<small><a href="#" class="fs-6" data-toggle="modal" data-target="#ExportingSearchResults">What's this?</a></small>
		</div>
  </div>


  <strong>Documents:</strong> 1 - 200 of 27602 &nbsp; <strong>Search String</strong> <span class="queries"> : 2=1 : 1=PARKS </span><br />
  <hr />


	<div class='col-sm-12 col-md-8 col-lg-9 col-xl-8'>
		<div class="row">
			<div class="col-md-12 col-lg-5">
				<H1 class="text-capitalize">
					<?php
							print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("Result") : _t("Results"));	
					?>		
				</H1>
			</div>

			<div id="browseResultsContainer">
				<div class="row">

					<table style="width: 100%;" class="table table-striped table-responsive">
						<tbody>
							<tr>
								<th>Result</th>
								<th>File Type</th>
								<th>Number</th>
								<th>Filed</th>
								<th>Title</th>
							</tr>

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


				</div><!-- end row -->
			</div><!-- end browseResultsContainer -->
	</div><!-- end col-8 -->





	<hr />
  <strong>Documents:</strong> 1 - 200 of 27602 &nbsp; <strong>Search String</strong> <span class="queries"> : 2=1 : 1=PARKS </span><br />
  <br />
  <hr />

  <p id="bottom-search-nav">
    <a href="/">
      <i class="bi bi-house-door-fill"></i>
    </a>
    <a href="/Search/advanced/combined">
      <i class="bi bi-search"></i>
    </a>
		
		<!-- TODO: Add pagination here -->
		<a href="">
			<i class="bi bi-chevron-double-left"></i>
		</a>
    <a href="">
      <i class="bi bi-chevron-double-right"></i>
    </a>

    <a href="#h0">
      <i class="bi bi-chevron-double-up"></i>
    </a>

    <a href="https://clerk.seattle.gov/search/help/">
      <i class="bi bi-question-lg"></i>
    </a>
  </p>
  <a name="hb"></a>
</div>



		
</div><!-- end row -->
