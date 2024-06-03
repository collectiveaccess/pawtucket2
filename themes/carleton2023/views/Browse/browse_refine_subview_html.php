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
	$vs_table = $this->getVar("table");	
	$vn_is_advanced		= (int)$this->getVar('is_advanced');
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$vs_current_view	= $this->getVar('view');
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)

	
	$vn_facet_display_length_initial = 12;
	$vn_facet_display_length_maximum = 60;
	$va_multiple_selection_facet_list = [];
	
	$vs_criteria = "";
	if (sizeof($va_criteria) > 0) {
		$i = 0;
		$vb_start_over = false;
		foreach($va_criteria as $va_criterion) {
			$vs_criteria .= caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.(strlen($va_criterion['value']) ? $va_criterion['value'] : $va_criterion['id']).' <span class="glyphicon glyphicon-remove-circle" aria-label="Remove filter" role="button"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_current_view, 'key' => $vs_browse_key));
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
		print "<a href='#' class='pull-right' id='bRefineClose' onclick='jQuery(\"#bRefine\").toggle(); return false;'><span class='glyphicon glyphicon-remove-circle'></span></a>";
		if($qr_res->numHits() > 1){
?>
			<div class="bSearchWithinContainer">
				<form role="search" id="searchWithin" action="<?php print caNavUrl($this->request, '*', 'Search', '*'); ?>">
					<input type="text" class="form-control bSearchWithin" placeholder="Search within..." name="search_refine" id="searchWithinSearchRefine" aria-label="Search Within"><button type="submit" class="btn-search-refine"><span class="glyphicon glyphicon-search" aria-label="submit search"></span></button>
					<input type="hidden" name="key" value="<?php print $vs_browse_key; ?>">
					<input type="hidden" name="view" value="<?php print $vs_current_view; ?>">
				</form>
				<div style="clear:both"></div>
			</div>	
<?php
		}
		if((is_array($va_facets) && sizeof($va_facets)) || ($vs_criteria)){
			print "<H2>"._t("Filter by")."</H2>";
			if($vs_criteria){
				print "<div class='bCriteria'>".$vs_criteria."</div>";
			}
			$vn_facets_with_content = 0;
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				if(is_array($va_facet_info['content']) && sizeof($va_facet_info['content'])){
					$vn_facets_with_content++;
				}
			}
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				$va_multiple_selection_facet_list[$vs_facet_name] = caGetOption('multiple', $va_facet_info, false, ['castTo' => 'boolean']);
			
				if (((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name)))) {
					print "<h3 type='button' onClick='jQuery(\"#facetGroup{$vs_facet_name}\").toggle(); return false;'>".$va_facet_info['label_singular']."</H3><div id='facetGroup{$vs_facet_name}' class='facetGroupShowHide' ".(($vn_facets_with_content > 1) ? "style='display:none;'" : "").">"; 
					print "<div class='container facetContainer' id='{$vs_facet_name}_facet_container'><div class='row'>";
					
	?>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#bHierarchyList_<?php print $vs_facet_name; ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'linkTo' => 'morePanel')); ?>");
							});
						</script>
						<div id='bHierarchyList_<?php print $vs_facet_name; ?>'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
	<?php
					print "</div></div></div>";
				} else {				
					if($va_facet_info["columns"]){
						$vn_facet_display_length_initial = 33;
						$vn_facet_display_length_maximum = 99;
					}elseif($va_multiple_selection_facet_list[$vs_facet_name]){
						$vn_facet_display_length_initial = 12;
						$vn_facet_display_length_maximum = 60;
					}
					if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
					$vn_facet_size = sizeof($va_facet_info['content']);
					print "<h3 type='button' onClick='jQuery(\"#facetGroup{$vs_facet_name}\").toggle(); return false;'>".$va_facet_info['label_singular']."</H3><div id='facetGroup{$vs_facet_name}' class='facetGroupShowHide' ".(($vn_facets_with_content > 1) ? "style='display:none;'" : "").">"; 
					print "<div class='container facetContainer' id='{$vs_facet_name}_facet_container'><div class='row'>";
					$vn_c = 0;
					$vn_col = 0;
					foreach($va_facet_info['content'] as $va_item) {
						$vs_label = $va_item['label'];
						$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
						print "<div class='".(($va_facet_info["columns"]) ? "col-md-12 col-lg-6" : "col-sm-12")." facetItem ' data-facet='{$vs_facet_name}' data-facet_item_id='{$va_item['id']}'>".caNavLink($this->request, $vs_label.$vs_content_count, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
						
						$vn_c++;
						$vn_col++;
						if ($va_facet_info["columns"] && ($vn_col == 2)) {
							print "<div style='clear:both;width:100%;'></div>";
							$vn_col = 0;
						}
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
				
						$vs_link_open_text = _t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial);
						$vs_link_close_text = _t("close", $vn_facet_size - $vn_facet_display_length_initial);
						print "<div class='col-sm-12'><a href='#' class='more' id='{$vs_facet_name}_more_link' onclick='jQuery(\"#{$vs_facet_name}_more\").slideToggle(250, function() { jQuery(this).is(\":visible\") ? jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_close_text)."\") : jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_open_text)."\")}); return false;'><em>{$vs_link_open_text}</em></a></div>";
					} elseif (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum)) {
						print "<div class='col-sm-12'><a href='#' class='more' onclick='jQuery(\"#bMorePanel\").load(\"".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."\", function(){jQuery(\"#bMorePanel\").show(); jQuery(\"#bMorePanel\").mouseleave(function(){jQuery(\"#bMorePanel\").hide();});}); return false;'><em>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial)."</em></a></div>";
					}
					if ($va_multiple_selection_facet_list[$vs_facet_name]) {
	?>
						<a href="#" id="<?php print $vs_facet_name; ?>_facet_apply" data-facet="<?php print $vs_facet_name; ?>" class="facetApply">Apply</a>
	<?php

					}
					print "</div><!-- end facet group --></div><!-- end row --></div><!-- end container -->";

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
				jQuery(window).scroll(function () {
					var scrollTop = $(window).scrollTop();
					// check the visible top of the browser
					//if (offset.top<scrollTop && ((offset.top + jQuery('#pageArea').height() - jQuery('#bRefine').height()) > scrollTop)) {
					if (offset.top<scrollTop && ((offset.top + jQuery('#pageArea').height()) > scrollTop)) {
						jQuery('#bRefine').addClass('fixed');
						jQuery('#bRefine').width(jQuery('#browseLeftCol').width() - 20);
					} else {
						jQuery('#bRefine').removeClass('fixed');
						jQuery('#bRefine').css('width', '100%');
					}
				});
            }
            
            var multiple_selection_facet_list = <?php print json_encode($va_multiple_selection_facet_list); ?>;
            
            jQuery(".facetApply").hide();
            
            jQuery(".facetItem").on('click', function(e) { 
            	if (!multiple_selection_facet_list[jQuery(this).data('facet')]) { return; }
            	if (jQuery(this).attr('facet_item_selected') == '1') {
            		jQuery(this).attr('facet_item_selected', '');
            	} else {
            		jQuery(this).attr('facet_item_selected', '1');
            	}
            	
            	if (jQuery("div.facetItem[facet_item_selected='1']").length > 0) {
            		jQuery("#" + jQuery(this).data('facet') + "_facet_apply").show();
            	} else {
            		jQuery("#" + jQuery(this).data('facet') + "_facet_apply").hide();
            	}
            	
            	e.preventDefault();
            	return false;
            });
            
            jQuery(".facetApply").on('click', function(e) { 
            	var facet = jQuery(this).data('facet');
            	
            	var ids = [];
            	jQuery.each(jQuery("#" + facet + "_facet_container").find("[facet_item_selected=1]"), function(k,v) {
            		ids.push(jQuery(v).data('facet_item_id'));
            	});
            	window.location = '<?php print caNavUrl($this->request, '*', '*','*', array('key' => $vs_key, 'view' => $vs_view)); ?>/facet/' + facet + '/id/' + ids.join('|');
            	e.preventDefault();
            });
		});
	</script>
<?php	
	}
?>
