<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
 
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_key 			= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vs_view			= $this->getVar('view');
	$vs_browse_type		= $this->getVar('browse_type');
	$o_browse			= $this->getVar('browse');
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$vs_current_view	= $this->getVar('view');
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	
	$vn_facet_display_length_initial = 5;
	$vn_facet_display_length_maximum = 200;
	$vs_criteria = "";
	if (sizeof($va_criteria) > 0) {
		$i = 0;
		$vb_start_over = false;
		foreach($va_criteria as $va_criterion) {
			$vs_criteria .= caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm"><span class="filter-val">'.$va_criterion['value'].'</span><span class="filter-icon" aria-label="Remove filter" role="button"><i class="bi bi-x"></i></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key));
			$vb_start_over = true;
			$i++;
		}
		if($vb_start_over){
			$vs_criteria .= caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'._t("Start Over").'</button>', 'browseRemoveFacet', '', 'Browse', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1, '_advanced' => $vn_is_advanced ? 1 : 0));
		}
	}
	
	if((is_array($va_facets) && sizeof($va_facets)) || ($vs_criteria) || ($qr_res->numHits() > 1)){
		print "<div id='bMorePanel'><!-- long lists of facets are loaded here --></div>";
		print "<div id='bRefine'>";
		if($qr_res->numHits() > 1){
?>

<?php
		}
		if((is_array($va_facets) && sizeof($va_facets)) || ($vs_criteria)){
			print "<a href='#' class='pull-right' id='bRefineClose' onclick='jQuery(\"#bRefine\").toggle(); return false;'><span class='glyphicon glyphicon-remove-circle'></span></a>";
			print "<H6 class='my-2 filter-name'>"._t("Filter by")."</H6>";



				if(array_key_exists('has_media', $va_facets)){
					print "<div class='filter-viewable-media'>";
					print "<h6 class='filter-name my-2'>Viewable media</h6>"; 
					$va_facet_info = $va_facets['has_media'];
					foreach($va_facet_info['content'] as $va_item) {
						$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
						print "<div class='filter-value'>".caNavLink($this->request, $va_item['label'].'<span>'.$vs_content_count.'</span>', '', '*', '*','*', array('key' => $vs_key, 'facet' => 'has_media', 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
					}
					print "</div>";
				}

			 //accordion start
			print "<div class='accordion' id='accordionExample'>";

			// if($vs_criteria){
			// 	print "<div class='bCriteria'>".$vs_criteria."</div>";
			// }
			
			foreach($va_facets as $vs_facet_name => $va_facet_info) {

				if($vs_facet_name == 'has_media'){
					continue;
				}
			
				if ((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name))) {
					print "<h6>".$va_facet_info['label_singular']."</h6>";
					print "<p>".$va_facet_info['description']."</p>";
	?>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#bHierarchyList_<?php print $vs_facet_name; ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'linkTo' => 'morePanel')); ?>");
							});
						</script>
						<div id='bHierarchyList_<?php print $vs_facet_name; ?>'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
	<?php
				} else {	
					if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
	?>

	<?php 
					print "<div class='accordion-item'>";

						// print "<div class='filter-border'></div>";

						print "<h2 class='accordion-header'>";
							print "<button class='accordion-button p-1 collapsed' id='control_{$vs_facet_name}' type='button' data-bs-toggle='collapse' data-bs-target='#facet_{$vs_facet_name}' aria-expanded='false' aria-controls='facet_{$vs_facet_name}'>";
									print "<h6 class='filter-name my-2'>".$va_facet_info['label_singular']."</h6>"; 
							print "</button>";
						print "</h2>";

						print "<div id='facet_{$vs_facet_name}' class='accordion-collapse collapse' aria-labelledby='control_{$vs_facet_name}' data-bs-parent='#accordionExample'>";
							print "<div class='accordion-body'>";

								switch($va_facet_info["group_mode"]){
									case "alphabetical":
									case "list":
									default:
										$vn_facet_size = sizeof($va_facet_info['content']);
										$vn_c = 0;
										foreach($va_facet_info['content'] as $va_item) {
											$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
											print "<div class='filter-value'>".caNavLink($this->request, $va_item['label'].'<span>'.$vs_content_count.'</span>', '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
											$vn_c++;
									
											if (($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
												print "<span id='{$vs_facet_name}_more' style='display: none;'>";
											} else {
												if(($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum))  {
													break;
												}
											}
										}
										if (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
											print "</span>\n";
									
											// $vs_link_open_text = _t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial);
											$vs_link_open_text = _t("View More", $vn_facet_size - $vn_facet_display_length_initial);
											$vs_link_close_text = _t("close", $vn_facet_size - $vn_facet_display_length_initial);
											print "<div ><a href='#' class='filter-more' id='{$vs_facet_name}_more_link' onclick='jQuery(\"#{$vs_facet_name}_more\").slideToggle(250, function() { jQuery(this).is(\":visible\") ? jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_close_text)."\") : jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_open_text)."\")}); return false;'><em>{$vs_link_open_text}</em></a></div>";
										} elseif (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum)) {
											print "<div><a href='#' class='filter-more' onclick='jQuery(\"#bMorePanel\").load(\"".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."\", function(){jQuery(\"#bMorePanel\").show(); jQuery(\"#bMorePanel\").mouseleave(function(){jQuery(\"#bMorePanel\").hide();});}); return false;'><em>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial)."</em></a></div>";
										}
									break;
									# ---------------------------------------------
								}

							print "</div><!-- end accordion-body -->\n";
						print "</div><!-- end accordion-collapse -->\n";
					print "</div><!-- end accordion-item -->\n";
				}
			}
		}
				print "</div><!-- end accordion -->\n";

		print "</div><!-- end bRefine -->\n";
?>
	<!-- <script type="text/javascript">
		jQuery(document).ready(function() {
            if(jQuery('#browseResultsContainer').height() > jQuery(window).height()){
				var offset = jQuery('#bRefine').height(jQuery(window).height() - 30).offset();   // 0px top + (2 * 15px padding) = 30px
				var panelWidth = jQuery('#bRefine').width();
				jQuery(window).scroll(function () {
					var scrollTop = $(window).scrollTop();
					// check the visible top of the browser
					if (offset.top<scrollTop && ((offset.top + jQuery('#pageArea').height() - jQuery('#bRefine').height()) > scrollTop)) {
						jQuery('#bRefine').addClass('fixed');
						jQuery('#bRefine').width(panelWidth);
					} else {
						jQuery('#bRefine').removeClass('fixed');
					}
				});
            }
		});
	</script> -->
<?php	
	}
?>
