<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php : 
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

# --- process applied filters so can display collection description at top of page if there is a collection facet set
		$va_formatted_criteria = array();
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			foreach($va_criteria as $va_criterion) {
				$va_formatted_criteria[] = caNavLink($va_criterion['value'].' <span>&times;</span>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key));
				
				# --- is there a description to show at top of page
				$va_current_facet = $va_all_facets[$va_criterion['facet_name']];
				if($va_current_facet["show_description_when_first_facet"] && ($va_current_facet["type"] == "authority")){
					$t_authority_table = new $va_current_facet["table"];
					$t_authority_table->load($va_criterion['id']);
					$vs_facet_description = $t_authority_table->get($va_current_facet["show_description_when_first_facet"]);
					$vs_facet_title = $t_authority_table->get($va_current_facet["table"].".preferred_labels.name");
				}
			}
		}
	switch(strToLower($this->request->getAction())){
		case "archive":
			print '<main class="ca archive archive_landing '.((!$vs_facet_title && !$vs_facet_description) ? "nomargin" : "").'">';

			if($vs_facet_description || $vs_facet_title){
?>
			<section class="intro">
				<div class="wrap block-large">
					<div class="wrap-max-content">
						<div class="block-half subheadline-bold text-align-center"><?php print $vs_facet_title; ?></div>
						<div class="block-half body-text-l"><?php print $vs_facet_description; ?></div>
					</div>
				</div>
			</section>
<?php
			}	

		break;
		# -------------------------------------------------
		case "cr":
			print '<main class="ca cr cr_browse nomargin">';
		break;
		# -------------------------------------------------
		case "bibliography":
			print '<main class="ca bibliography bibliography_landing">';
?>
			<section class="intro">
				<div class="wrap block-large">
					<div class="wrap-max-content">
						<div class="block-half body-text-l">{{{bibliographyIntro}}}</div>
					</div>
				</div>
			</section>
<?php
		break;
		# -------------------------------------------------
	}
?>		
		




	<section class="ca_filters">
		<div class="wrap">
<?php
	switch(strToLower($this->request->getAction())){
		case "archive":
			print $this->render("pageFormat/archive_nav.php");
		break;
		# -------------------------------------------------
		case "cr":
			print $this->render("pageFormat/cr_nav.php");
		break;
		# -------------------------------------------------
	}

	# --- process facets for display twice: mobile and desktop	
	if(is_array($va_facets) && sizeof($va_facets)){
		$va_facet_links = array();
		$va_facets_processed = array();
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
				
				if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
				$va_facet_links["desktop"][] = "<a href='#' data-option='".$vs_facet_name."'>".$va_facet_info['label_singular']."</a>"; 
				$va_facets_processed['mobile'][$vs_facet_name]['facet_label'] = $va_facet_info['label_singular'];
				switch($va_facet_info["group_mode"]){
					case "alphabetical":
					case "list":
					default:
						foreach($va_facet_info['content'] as $va_item) {
						    $vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? $va_item['content_count'] : "";
							$vs_tmp = "";
						    $vs_tmp = '<li>
                                            <div class="checkbox">
                                                <input id="artwork" data-category="" class="option-input" type="checkbox">
                                                <label for="artwork">
                                                    <span class="title">'.caNavLink($va_item['label'].' &nbsp;<span class="number">('.$vs_content_count.')</span>', '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view)).'</span>
                                                </label>
                                            </div>
                                        </li>';
						    $va_facets_processed['desktop'][$vs_facet_name][] = $vs_tmp;
							$va_facets_processed['mobile'][$vs_facet_name]['facet_terms'][] = "<option value=".$va_item['id'].">".$va_item['label']." &nbsp;<span class='number'>(".$vs_content_count.")</span></option>";
						    #print "<div>".caNavLink($va_item['label'].' &nbsp;<span class="number">('.$vs_content_count.')</span>', '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";

						}
					break;
					# ---------------------------------------------
				}
			
		}
	}

		if(is_array($va_facets_processed['mobile']) && sizeof($va_facets_processed['mobile'])){
?>
				<!-- Mobile Filters -->
				<nav class="show-for-mobile filters_bar_mobile">
<?php
						foreach($va_facets_processed['mobile'] as $vs_facet_name => $va_facet_info){
							if($vs_facet_name == "type_facet"){
								print '<select name="'.$vs_facet_name.'" multiple="multiple" placeholder="Filter by" class="optgroup_test SumoUnder sumo-select-skinned" tabindex="-1">';
								print '<option disabled selected>Filter By</option>';

								print "<optgroup label='".$va_facet_info["facet_label"]."'>";
								print join($va_facet_info["facet_terms"], " ");
								print "</optgroup></select>";
							}else{
								print "<select name='".$vs_facet_name."'>";
								print "<option disabled selected>".$va_facet_info["facet_label"]."</option>";
								print join($va_facet_info["facet_terms"], "");
								print "</select>";
							}
						}
?>
                </nav>
<?php
		}
?>
                <div class="filters_bar">

                    <!-- Stats & Current Tags -->

                    <div class="current">
                        <div class="body-sans"><?php print _t('Showing %1 %2', number_format($vn_result_size), ($vn_result_size == 1) ? _t("Result") : _t("Results")); ?>.</div>

<?php
						if(is_array($va_formatted_criteria) && sizeof($va_formatted_criteria)){
							print '<div class="tags">'.join($va_formatted_criteria, "").'</div>';
						}
?>


                    </div>
<?php
		if(is_array($va_facet_links["desktop"]) && sizeof($va_facet_links["desktop"])){
?>


                    <!-- Desktop Filters -->
                    <div class="options-filter-widget">
                        <div class="options text-gray">
                            <span class="caption-text">Filter By:</span>
                            <?php print join($va_facet_links["desktop"], ""); ?>
                        </div>
                        <div class="option_values wrap-negative" >
                            <div class="arrow"></div>
                            <div class="inner"><div class="inner-crop">
                                <div class="wrap">
<?php
									foreach($va_facets_processed["desktop"] as $vs_facet_name => $va_facet_items){
?>
										<ul class="ul-options" data-values="<?php print $vs_facet_name; ?>">
											<?php print join($va_facet_items, ""); ?>
										</ul>
<?php									
									}
?>
                                </div>
                            </div></div><!-- inner, inner-crop -->
                        </div><!-- option_values -->
                    </div><!-- options-filter-widget -->
<?php	
		}

?>


                </div>
			</div>
        </section>

<!-- end filters -->
<?php
	switch(strToLower($this->request->getAction())){
		case "archive":
		default:
?>
			<section class="block block-quarter-top">
				<div class="wrap">
					<div class="grid-flexbox-layout grid-ca-archive">
<?php
		break;
		# ----------------------------------------
		case "bibliography"
?>
	        <section class="block block-top">
            <div class="wrap results">

                <div class="block-half-top">
<?php		
		break;
		# ----------------------------------------

	}

				# --- check if this result page has been cached
				# --- key is MD5 of browse key, sort, sort direction, view, page/start, items per page, row_id
				$vs_cache_key = md5($vs_browse_key.$vs_current_sort.$vs_sort_dir.$vs_current_view.$vn_start.$vn_hits_per_block.$vn_row_id);
				if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_results')){
					print ExternalCache::fetch($vs_cache_key, 'browse_results');
				}else{
					$vs_result_page = $this->render("Browse/browse_results_{$vs_current_view}_html.php");
					ExternalCache::save($vs_cache_key, $vs_result_page, 'browse_results', $o_config->get("cache_timeout"));
					print $vs_result_page;
				}		

?>

				</div>
			</div>
		</section>
</main>