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
$vs_sort_control_type = caGetOption('sortControlType', $va_browse_info, 'dropdown');
$o_config = $this->getVar("config");
$vs_result_col_class = $o_config->get('result_col_class');
$vs_refine_col_class = $o_config->get('refine_col_class');
$va_export_formats = $this->getVar('export_formats');
$va_browse_type_info = $o_config->get($va_browse_info["table"]);
$va_all_facets = $va_browse_type_info["facets"];	
$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
if (!$vb_ajax) {	// !ajax
?>

<div class="row mx-2" style="clear:both;">

	<div class="container">

		<!-- <div class="row" style="margin: 10px 5px;">< All watch topics</div> -->

		<div class="row justify-content-center" style="margin: 30px 5px;">
			<h1 class="text-center">Browse Collections</h1>
		</div>

		<div class="row " style="margin: 10px 5px;">
			<div class="col text-center">
				<form id="form" role="search">
					<input type="search" placeholder="Search Collections by keyword..." aria-label="Search collections" 
						style="border: 1px solid lightgray; border-radius: 30px; padding: 10px 10px 10px 20px; width: 400px; height: 40px">
					<button type="submit" title="Submit Search" aria-label="Submit Search" 
						style="background-color: transparent; border: none">
						<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="7.07143" cy="6.57143" r="6.07143" stroke="black"></circle>
							<path d="M11.4618 10.9618L15.9359 15.4359" stroke="black" stroke-linecap="square"></path>
						</svg>
					</button>
				</form>
			</div>
			<div class="text-end">
				<button class="btn ml-auto browse-collapse-btn" id="btn-coll" type="button" data-bs-toggle="collapse" data-bs-target="#advSearchFormCollapse" aria-expanded="false" aria-controls="advSearchFormCollapse">
					+ More Search Options
				</button>
			</div>
		</div>
		
		<div class="collapse" id="advSearchFormCollapse">
			<form class="g-3 mt-3">
				<div class="row mb-3 justify-content-center">
					<div class="col-auto">
						<input type="text" class="form-control" id="keyword" placeholder="Keyword"
							style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 400px; height: 40px">
					</div>
					<div class="col-auto">
						<input type="text" class="form-control" id="title" placeholder="Title"
							style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 400px; height: 40px">
					</div>
				</div>
				<div class="row mb-3 justify-content-center">
					<div class="col-auto">
						<input type="text" class="form-control" id="identifier" placeholder="Identifier #"
							style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 200px; height: 40px">
					</div>
					<div class="col-auto">
						<input type="text" class="form-control" id="date" placeholder="Date of Production"
							style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 200px; height: 40px">
					</div>
					<div class="col-auto">.
						<select class="adv-search-select" name="type" id="type-select"
							style="border: 1px solid lightgray; border-radius: 10px; padding: 10px; width: 200px; height: 40px">
							<option value="">Type</option>
						</select>
					</div>
				</div>
				<div class="row mb-3 justify-content-end">
					<div class="col-auto">
						<button type="submit" class="btn btn-warning mb-3">Search <i class="bi bi-arrow-right-short"></i></button>
					</div>
				</div>
			</form>
		</div>

		<div class="row" style="margin: 10px 5px;">
			<div class='col-sm-6 d-flex align-items-center' style="padding-left:0px !important;">
				<?php
					print _t('%1 %2 %3', $vn_result_size, ($va_browse_info["labelSingular"]) ? $va_browse_info["labelSingular"] : $t_instance->getProperty('NAME_SINGULAR'), ($vn_result_size == 1) ? _t("result") : _t("results"));	
				?>	
			</div>

			<div class="col-sm-6 d-flex justify-content-end align-items-center">
				<div>View Mode: </div>

				<?php
					if(is_array($va_views) && (sizeof($va_views) > 1)){
						foreach($va_views as $vs_view => $va_view_info) {
							if ($vs_current_view === $vs_view) {
								print '<a href="#" class="browse-view-button active"><i class="bi bi-grid-3x3-gap-fill" '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" role="button" style="font-size:16px;"></i></a> ';
							} else {
								print caNavLink($this->request, '<i class="bi bi-list-task" '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" role="button" style="font-size:16px;"></i>', 'browse-view-button disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
							}
						}
					}
				?>
			</div>
		</div>

		<div class="browse-border"></div>
	</div><!-- End Container -->

	<div class="row justify-content-between">

		<div class='<?= ($vs_result_col_class) ? $vs_result_col_class : "col-9"; ?>'>

			<!-- If in list view -->
			<?php 
						if($vs_sort_control_type == 'list'){
							if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts)) {
								print "<div id='bSortByList'><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
								$i = 0;
								foreach($va_sorts as $vs_sort => $vs_sort_flds) {
									$i++;
									if ($vs_current_sort === $vs_sort) {
										print "<li class='selectedSort'>{$vs_sort}</li>\n";
									} else {
										print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort, '_advanced' => $vn_is_advanced ? 1 : 0))."</li>\n";
									}
									if($i < sizeof($va_sorts)){
										print "<li class='divide'>&nbsp;</li>";
									}
								}
								print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'" aria-label="direction" role="button"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc")), '_advanced' => $vn_is_advanced ? 1 : 0))."</li>";
								print "</ul></div>\n";
							}
						}
			?>


					<?php
							if($vs_facet_description){
								print "<div class='bFacetDescription'>".$vs_facet_description."</div>";
							}

							if($vb_showLetterBar){
								print "<div id='bLetterBar'>";
								foreach(array_keys($va_letter_bar) as $vs_l){
									if(trim($vs_l)){
										print caNavLink($this->request, $vs_l, ($vs_letter == $vs_l) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => $vs_l))." ";
									}
								}
								print " | ".caNavLink($this->request, _t("All"), (!$vs_letter) ? 'selectedLetter' : '', '*', '*', '*', array('key' => $vs_browse_key, 'l' => 'all')); 
								print "</div>";
							}
					?>

			<div id="browseResultsContainer">
					<?php
					} // !ajax

					# --- check if this result page has been cached
					# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
					$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id.$vs_letter);
					if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
						print ExternalCache::fetch($vs_cache_key, 'browse_results');
					}else{
						$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
						ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
						switch (strval($vs_current_view)) {
							case "images":
								print  "<div class='browseResults row row-cols-1 row-cols-xs-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4'> $vs_result_page </div>" ;
								break;
							case "list":
								print  "<div class='browseResults row row-cols-2 row-cols-xs-1 row-cols-sm-1 row-cols-md-2'> $vs_result_page </div>" ;
								break;
							default:
								print  "<div class='browseResults row row-cols-1 row-cols-xs-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4'> $vs_result_page </div>" ;
						}
					}		

					if (!$vb_ajax) {	// !ajax
					?>
			</div>

		</div><!-- end col-9 -->

		<div class="<?= ($vs_refine_col_class) ? $vs_refine_col_class : "col-3 "; ?>">

			<div id="bViewButtons">
				<?php
						if(is_array($va_views) && (sizeof($va_views) > 1)){
							foreach($va_views as $vs_view => $va_view_info) {
								if ($vs_current_view === $vs_view) {
									print '<a href="#" class="active"><span class="glyphicon  '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" role="button"></span></a> ';
								} else {
									print caNavLink($this->request, '<span class="glyphicon '.$va_view_icons[$vs_view]['icon'].'" aria-label="'.$vs_view.'" role="button"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'key' => $vs_browse_key)).' ';
								}
							}
						}
				?>
			</div>

			<?php
					print $this->render("Browse/browse_refine_subview_html.php");
			?>			
		</div><!-- end col-3 -->

	</div>
	
</div><!-- end row -->


<script type="text/javascript">
	jQuery(document).ready(function() {
				// jQuery('#browseResultsContainer').jscroll({
		// 			autoTrigger: true,
		// 			loadingHtml: <?= json_encode(caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...'))); ?>,
		// 			padding: 800,
		// 			nextSelector: 'a.jscroll-next'
		// 		});
		<?php
				if($vn_row_id){
		?>
					window.setTimeout(function() {
						$("window,body,html").scrollTop( $("#row<?= $vn_row_id; ?>").offset().top);
					}, 0);
		<?php
				}
				if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
		?>
				jQuery('#setsSelectMultiple').on('submit', function(e){		
					objIDs = [];
					jQuery('#setsSelectMultiple input:checkbox:checked').each(function() {
					objIDs.push($(this).val());
					});
					objIDsAsString = objIDs.join(';');
					caMediaPanel.showPanel('<?= caNavUrl($this->request, '', $va_add_to_set_link_info['controller'], 'addItemForm', array("saveSelectedResults" => 1)); ?>/object_ids/' + objIDsAsString);
					e.preventDefault();
					return false;
				});
		<?php
				}
		?>

		46

		$('.browse-collapse-btn').click(function(){
			var $this = $(this);
			$this.toggleClass('browse-collapse-btn');
			setTimeout(function() { 
				if($this.hasClass('browse-collapse-btn')){
					$this.text('+ More Search Options');         
				} else {
					$this.text('- Less Search Options');
				}
    		}, 250);
		});
	});


</script>
<?php
		print $this->render('Browse/browse_panel_subview_html.php');
} //!ajax
?>
