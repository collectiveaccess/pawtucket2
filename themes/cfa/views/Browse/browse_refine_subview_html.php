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
	$vn_facet_display_length_maximum = 100;
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
					print "<h6 class='filter-name my-2'>Viewable media"; 
					print "<span class='ms-2 info-icon collections-info' data-toggle='tooltip' title='The vast majority of the material in CFA&apos;s collections has not yet been digitized. This option allows you to filter for collections that contain media that has been digitized and made available for online viewing.'>
								<div class='trigger-icon color-icon-orange'>
									<svg width='15' height='16' viewBox='0 0 15 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
										<path d='M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z' fill='#767676' class='color-fill'></path>
										<path d='M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z' fill='#767676' class='color-fill'></path>
										<path d='M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621' fill='#767676' class='color-fill'></path>
									</svg>
								</div>
							</span></h6>";
					$va_facet_info = $va_facets['has_media'];
					foreach($va_facet_info['content'] as $va_item) {
						$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
						print "<div class='filter-value'>".caNavLink($this->request, $va_item['label'].'<span>'.$vs_content_count.'</span>', '', '*', '*','*', array('key' => $vs_key, 'facet' => 'has_media', 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
					}
					print "</div>";
				}

			 //accordion start
			print "<div class='accordion' id='accordionExample'>";
			
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
					$title = '';
					switch ($vs_facet_name) {
						case 'access':
							$title = 'Items that have not yet been fully described by CFA&apos;s cataloging staff are published with &quot;restricted&quot; status.';
							break;
						case 'subject':
							$title = 'Subjects describe the content of an object, and are derived from Library of Congress Subject Headings.';
							break;
						case 'genre':
							$title = 'Genres describe the style, conventions, and structure of an object, and are derived from the Library of Congress Moving Image Genre List.';
							break;
						case 'form':
							$title = 'Form describes an object&apos;s original exhibition or distribution parameters, distinct from any attributes of the object&apos;s content or style. These terms are derived from the Library of Congress&apos;s Archival Moving Image Materials: A Cataloging Manual (2nd Edition).';
							break;
						case 'has_been_digitized':
							$title = 'Note that many items have been digitized, but are not yet available online. Please contact the archive to inquire about these items.';
							break;
					}

					print "<div class='accordion-item'>";

						print "<h2 class='accordion-header'>";
							print "<button class='accordion-button p-1 collapsed' id='control_{$vs_facet_name}' type='button' data-bs-toggle='collapse' data-bs-target='#facet_{$vs_facet_name}' aria-expanded='false' aria-controls='facet_{$vs_facet_name}'>";
									print "<h6 class='filter-name my-2'>".$va_facet_info['label_singular']."</h6>" ; 

									if($vs_facet_name == 'access' || $vs_facet_name == 'subject'|| $vs_facet_name == 'genre'|| $vs_facet_name == 'form' || $vs_facet_name == 'has_been_digitized'){
										print "<span class='ms-2 info-icon collections-info' data-toggle='tooltip' title='$title'>
													<div class='trigger-icon color-icon-orange'>
														<svg width='15' height='16' viewBox='0 0 15 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
															<path d='M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z' fill='#767676' class='color-fill'></path>
															<path d='M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z' fill='#767676' class='color-fill'></path>
															<path d='M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621' fill='#767676' class='color-fill'></path>
														</svg>
													</div>
												</span>";
									}
									
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

<script type='text/javascript'>
	$(document).ready(function(){
    	$('[data-toggle="tooltip"]').tooltip();
	});
</script>

<?php	
	}
?>
