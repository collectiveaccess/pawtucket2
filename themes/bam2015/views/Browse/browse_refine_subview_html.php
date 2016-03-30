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
	$va_export_formats = $this->getVar('export_formats');
	$qr_res 			= $this->getVar('result');
	
	$vn_facet_display_length_initial = 12;
	$vn_facet_display_length_maximum = 60;
if((is_array($va_criteria) && sizeof($va_criteria)) || (is_array($va_facets) && sizeof($va_facets))){	
		print "<div id='bMorePanel'><!-- long lists of facets are loaded here --></div>";
		print "<div id='bRefine'>";
		print "<H3>"._t("Filter");
			
		if($qr_res->numHits()){
			print caNavLink($this->request, "<i class='icon-folder-download' style='float:right'></i>", "", "*", "*", "*", array("view" => "xlsx", "download" => true, "export_format" => "basic_excel", "key" => $vs_key), array("title" => _t("Export results as spreadsheet")));	
		}	
		print "</H3>";	
		if (sizeof($va_criteria) > 0) {
			$i = 0;
			foreach($va_criteria as $va_criterion) {
				#if ($va_criterion['facet_name'] != '_search') {
					print caNavLink($this->request, '<button type="button" class="btn-default bCriteria"><span class="icon-cross pull-right"></span>'.$va_criterion['facet'].": ".$va_criterion['value'].'</button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_view, 'key' => $vs_key));
				#}
				$i++;
				if($i < sizeof($va_criteria)){
					print "<br/>";
				}
			}
		}
	if(is_array($va_facets) && sizeof($va_facets)){		
		foreach($va_facets as $vs_facet_name => $va_facet_info) {	
			if ((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name))) {
				print "<div class='refineFilterBlock'><H5>".$va_facet_info['label_singular']."</H5>"; 
?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#bHierarchyList_<?php print $vs_facet_name; ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'linkTo' => 'morePanel')); ?>");
						});
					</script>
					<div id='bHierarchyList_<?php print $vs_facet_name; ?>'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
				</div>
<?php
			} else {				
				if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
				print "<div class='refineFilterBlock'><H5>".$va_facet_info['label_singular']."</H5>"; 
				switch($va_facet_info["group_mode"]){
					case "alphabetical":
					case "list":
					default:
						$vn_facet_size = sizeof($va_facet_info['content']);
						$vn_c = 0;
						if($va_facet_info['type'] == "normalizedDates"){
							foreach($va_facet_info['content'] as $va_item) {
								print caNavLink($this->request, $va_item['label'], '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."&nbsp;&nbsp; ";
							}
						}else{
							foreach($va_facet_info['content'] as $va_item) {
								print "<div>".caNavLink($this->request, $va_item['label'], '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
								$vn_c++;
						
								if (($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
									print "<div id='{$vs_facet_name}_more' style='display: none;'>";
								} else {
									if(($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum))  {
										break;
									}
								}
							}
							if (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
								print "</div>\n";
						
								$vs_link_open_text = _t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial);
								$vs_link_close_text = _t("close", $vn_facet_size - $vn_facet_display_length_initial);
								print "<div><a href='#' class='more' id='{$vs_facet_name}_more_link' onclick='jQuery(\"#{$vs_facet_name}_more\").slideToggle(250, function() { jQuery(this).is(\":visible\") ? jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_close_text)."\") : jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_open_text)."\")}); return false;'><em>{$vs_link_open_text}</em></a></div>";
							} elseif (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum)) {
								print "<div><a href='#' class='more' onclick='jQuery(\"#bMorePanel\").load(\"".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."\", function(){jQuery(\"#bMorePanel\").show(); jQuery(\"#bMorePanel\").mouseleave(function(){jQuery(\"#bMorePanel\").hide();});}); return false;'><em>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial)."</em></a></div>";
							}
						}
					break;
					# ---------------------------------------------
				}
				print "</div>";
			}
		}
	}
		print "</div><!-- end bRefine -->\n";
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
            if(jQuery('#browseResultsContainer').height() > jQuery(window).height()){
				var offset = jQuery('#bRefine').height(jQuery(window).height() - 30).offset();   // 0px top + (2 * 15px padding) = 30px
				var panelWidth = jQuery('#bRefine').width();
				jQuery(window).resize(function () {
					jQuery('#bRefine').width(jQuery('#bRefine').parent().width() -30);
				});
				jQuery(window).scroll(function() {
					var scrollTop = $(window).scrollTop();
					// check the visible top of the browser
					if (offset.top<scrollTop) {
						jQuery('#bRefine').addClass('fixed');
						jQuery('#bRefine').width(jQuery('#bRefine').parent().width() -30);
					} else {
						jQuery('#bRefine').removeClass('fixed');
					}
				});
            }
		});
	</script>
<?php
}
?>