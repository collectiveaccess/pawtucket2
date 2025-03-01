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
	
	$vn_facet_display_length_initial = 120;
	$vn_facet_display_length_maximum = 120;
	$va_multiple_selection_facet_list = [];
	$vb_show_filter_panel = $this->request->getParameter("showFilterPanel", pInteger);		
	$vn_acquisition_movement_id = (int)$this->request->getParameter("acquisition_movement_id", pInteger);
	$vs_detail_type = $this->request->getParameter("detailType", pString);

	$vs_criteria = "";
	$vn_num_criteria = 0;
	if (sizeof($va_criteria) > 0) {
		foreach($va_criteria as $va_criterion) {
			if(!$vb_show_filter_panel || ($vb_show_filter_panel && !in_array($va_criterion['facet_name'], array("movement_facet", "loan_facet", "archival_facet", "entity_facet")))){
				#print "<strong>".$va_criterion['facet'].':</strong>';
				if($va_criterion['value']){
					$vs_label = $va_criterion['value'];
					if(mb_strlen($va_criterion['value']) > 20){
						$vs_label = mb_substr($va_criterion['value'], 0, 20)."...";
					}
					$vs_criteria .= caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$vs_label.' <span class="glyphicon glyphicon-remove-circle" aria-label="Remove filter"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => urlencode($va_criterion['id']), 'view' => $vs_view, 'key' => $vs_key, 'is_advanced' => $vn_is_advanced));
					$vn_num_criteria++;
				}
			}
		}
	}

	
	if((($vs_table == "ca_entities") && strToLower($this->request->getAction()) != "other_entities") || (($vs_table != "ca_entities") && is_array($va_facets) && (sizeof($va_facets) > 0)) || ($vs_criteria)){
		print "<div id='bMorePanel'><!-- long lists of facets are loaded here --></div>";
		print "<div id='bRefine'>";
		print "<a href='#' class='pull-right' id='bRefineClose' onclick='jQuery(\"#bRefine\").toggle(); return false;'><span class='glyphicon glyphicon-remove-circle'></span></a>";
		print "<H2>"._t("Filter by")."</H2>";
		if ($vs_criteria) {
			print "<div class='bCriteria".(($vb_show_filter_panel) ? " catchLinks" : "")."'>";
			print $vs_criteria;
			if($vn_num_criteria > 1){
				print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">Clear All Filters <span class="glyphicon glyphicon-remove-circle" aria-label="Remove all filters"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('clear' => 1, 'view' => $vs_view, 'key' => $vs_key, '_advanced' => $vn_is_advanced ? 1 : 0));
			}
			print "</div>";
		}
		$vn_facets_with_content = 0;
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			if(is_array($va_facet_info['content']) && sizeof($va_facet_info['content'])){
				$vn_facets_with_content++;
			}
		}
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			$va_multiple_selection_facet_list[$vs_facet_name] = caGetOption('multiple', $va_facet_info, false, ['castTo' => 'boolean']);
			
			if ((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name))) {
				print "<H3>".$va_facet_info['label_singular']."</H3>";
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
				$vn_facet_size = sizeof($va_facet_info['content']);
				print "<h3 type='button' onClick='jQuery(\".facetGroupShowHide\").hide(); jQuery(\"#facetGroup{$vs_facet_name}\").show(); return false;'>".$va_facet_info['label_singular']."</H3><div id='facetGroup{$vs_facet_name}' class='facetGroupShowHide' ".(($vn_facets_with_content > 1) ? "style='display:none;'" : "").">"; 
				print "<div class='container facetContainer' id='{$vs_facet_name}_facet_container'><div class='row'>";

				$vn_c = 0;
				$vn_col = 0;
				foreach($va_facet_info['content'] as $va_item) {
					$va_facet_popover = array();
					$vs_facet_desc = "";
					if(($vs_browse_type == 'archival') && ($vs_facet_name == 'type_facet')){
						$t_list_item = new ca_list_items($va_item['id']);
						if($tmp = $t_list_item->get("ca_list_item_labels.description")){
							$va_facet_popover = array("data-toggle" => "popover", "title" => $va_item['label'], "data-content" => $tmp);
							$vs_facet_desc = "<a href='#' class='facetDescButton' onClick='jQuery(\".facetDesc".$va_item['id']."\").slideToggle(); return false;'><i class='fa fa-question-circle' aria-hidden='true' aria-label='More Information'></i><blockquote class='facetDesc".$va_item['id']."'>".$tmp."</blockquote>";
						}
						
					}
					$vs_label = $va_item['label'];
					#$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
					print "<div class='".(($va_facet_info["columns"]) ? "col-md-12 col-lg-4" : "col-sm-12")." facetItem' data-facet='{$vs_facet_name}' data-facet_item_id='{$va_item['id']}'>".caNavLink($this->request, $vs_label.$vs_content_count, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view)).$vs_facet_desc."</div>";
					$vn_c++;
					$vn_col++;
					if ($va_facet_info["columns"] && ($vn_col == 3)) {
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
					print "<div><a href='#' class='more' id='{$vs_facet_name}_more_link' onclick='jQuery(\"#{$vs_facet_name}_more\").slideToggle(250, function() { jQuery(this).is(\":visible\") ? jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_close_text)."\") : jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_open_text)."\")}); return false;'><em>{$vs_link_open_text}</em></a></div>";
				} elseif (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum)) {
					print "<div><a href='#' class='more' onclick='jQuery(\"#bMorePanel\").load(\"".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."\", function(){jQuery(\"#bMorePanel\").show(); jQuery(\"#bMorePanel\").mouseleave(function(){jQuery(\"#bMorePanel\").hide();});}); return false;'><em>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial)."</em></a></div>";
				}
				if ($va_multiple_selection_facet_list[$vs_facet_name]) {
?>
					<a href="#" id="<?php print $vs_facet_name; ?>_facet_apply" data-facet="<?php print $vs_facet_name; ?>" class="facetApply">Apply</a>
<?php
				}

				print "</div><!-- end row --></div><!-- end container --></div><!-- end facetGroup -->";
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
					if (offset.top<scrollTop && ((offset.top + jQuery('#pageArea').height() - jQuery('#bRefine').height()) > scrollTop)) {
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
<?php
	if($vb_show_filter_panel){
?>
				var url = '<?php print caNavUrl($this->request, '*', '*','*', array('key' => $vs_key, 'view' => $vs_view)); ?>/facet/' + facet + '/id/' + ids.join('|') + '/dontSetFind/1/showFilterPanel/1<?php print ($vn_acquisition_movement_id) ? "/acquisition_movement_id/".$vn_acquisition_movement_id : ""; ?><?php print ($vs_detail_type) ? "/detailType/".$vs_detail_type : ""; ?>';
 				$('#browseResultsDetailContainer').load(url);
<?php
	}else{
?>            	
            	window.location = '<?php print caNavUrl($this->request, '*', '*','*', array('key' => $vs_key, 'view' => $vs_view)); ?>/facet/' + facet + '/id/' + ids.join('|');
<?php
	}
?>            	
            	e.preventDefault();
            });
 <?php
	if($vb_show_filter_panel){
?>
          
            $(".catchLinks").on("click", "a", function(event){
				if(!$(this).hasClass('dontCatch') && $(this).attr('href') != "#"){
					event.preventDefault();
					var url = $(this).attr('href') + "/showFilterPanel/1";
					$('#browseResultsDetailContainer').load(url);
				}
								
			});
<?php
	}
	if($vs_browse_type == "archival"){
?>            	
			var options = {
				placement: function () {
					return "auto left";
				},
				trigger: "hover",
				html: "true"
			};

			$('[data-toggle="popover"]').each(function() {
				if($(this).attr('data-content')){
					$(this).popover(options).click(function(e) {
						$(this).popover('toggle');
					});
				}
			});
<?php
	}
?>		
		});
	</script>
<?php	
	}
?>
