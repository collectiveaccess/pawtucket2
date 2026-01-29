<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2018 Whirl-i-Gig
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
$va_browse_info 	= $this->getVar("browseInfo");

$vn_facet_display_length_initial = 60;
$vn_facet_display_length_maximum = 600;
$va_browse_types = caGetBrowseTypes();

$va_multiple_selection_facet_list = [];

#if(is_array($va_facets) && sizeof($va_facets)){
	print "<div id='bMorePanel'><!-- long lists of facets are loaded here --></div>";
	print "<div id='bRefine'>";
	print "<a href='#' class='pull-right' id='bRefineClose' onclick='jQuery(\"#bRefine\").toggle(); return false;'><span class='glyphicon glyphicon-remove-circle'></span></a>";
	
	foreach ($va_browse_types as $vs_browse_id => $va_browse_type) {
		//if(strtolower($vs_browse_id) == 'worksincollection') { continue; }    // Never show "works in collection", which is a browse type uses only to filter objects on collection details
		$vs_menu_item_width = $va_browse_type['menuWidth'];
		// When browse type is "worksInCollection" we don't want to show the browse title but we DO want to show the facet
		// so we force the browse type to "artworks", which will have the same facets but be labelled as NGA requests
		if (($vs_browse_type == 'worksInCollection') && ($vs_browse_id == 'artworks')) {
			$vs_browse_type = 'artworks';
		}
		#print "<div class='browseTarget'>".caNavLink($this->request, $va_browse_type['displayName'], ($vs_browse_type == $vs_browse_id ? 'activeBrowse' : ''), '', 'Browse', $vs_browse_id)."</div>";
		if (strtolower($vs_browse_type) == strtolower($vs_browse_id)) {
			if(is_array($va_facets) && sizeof($va_facets)) {
				print "<H5 >"._t("Filter by")."</H5>";
			}
			
			$va_show_only_facets = [];
			$va_show_only_open_close_map = array_values(array_map(function($v) { return (bool)$v['show_only']; }, $va_facets));
			
			$fc = 0;
			$vb_show_only_is_open = false;
			
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
				if(in_array($vs_facet_name, ['collection', 'past_collection', 'current_collection'], true)) {  continue; }
				$va_multiple_selection_facet_list[$vs_facet_name] = caGetOption('multiple', $va_facet_info, false, ['castTo' => 'boolean']);
				$vs_menu_width = $va_facet_info['width'];
				
			
				if ((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name))) {
					print '<div class="dropdown button" style="width:'.$vs_menu_item_width.'%;">';
					print "<h5  class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>".$va_facet_info['label_singular']."<span class='caret'></span></H5><ul class='facetGroup panel dropdown-menu' id='facetGroup{$vs_facet_name}' style='width:".$vs_menu_width."%;'>"; 

					print "<li><div class='container'><div class='row hierarchicalList'>"; 
?>
					
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#bHierarchyList_<?php print $vs_facet_name; ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'linkTo' => 'morePanel')); ?>");
							});
						</script>
						<div id='bHierarchyList_<?php print $vs_facet_name; ?>'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
<?php
					print "</div><!-- end row --></div><!-- end container --></li></ul><!-- end facetGroup -->";
					print "</div><!-- end dropdown -->";
				} else {				
					if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { $fc++; continue; }
					
					$vb_show_only_open = $vb_show_only_close = false;
					if (!$vb_show_only_is_open && $va_facet_info['show_only']) { $vb_show_only_open = $vb_show_only_is_open = true; }
					if ($vb_show_only_is_open && (($va_show_only_open_close_map[$fc + 1] == false) || ($fc >= (sizeof($va_show_only_open_close_map)-1)))) { $vb_show_only_close = true;  }
			
					
					if (!$vb_show_only_is_open) {
						print '<div class="dropdown button" style="width:'.$vs_menu_item_width.'%;">';
						$w = (int)caGetOption('width', $va_facet_info, 100);
						$l = (int)caGetOption('left', $va_facet_info, 0);
						print "<h5  class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>".$va_facet_info['label_singular']."<span class='caret'></span></H5><ul class='facetGroup panel dropdown-menu ' id='facetGroup{$vs_facet_name}' style='width:".$w."%;".(($l == 1) ? 'left:-'.($w - 100).'%;' : '')."'>"; 
						print "<li><div class='container' id='{$vs_facet_name}_facet_container'><div class='row'>";
					} elseif ($vb_show_only_open) {
						print '<div class="dropdown button showOnly" style="width:'.$vs_menu_item_width.'%;">'; 
						print "<h5  class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>Show Only<span class='caret'></span></H5><ul class='facetGroup panel dropdown-menu dropdown-menu-right' id='facetGroupShowOnly' style='right:-21px;left:inherit;'>"; 
						print "<li><div class='container' id='ShowOnly_facet_container'><div class='row'>";
		
					}
					if ($vb_show_only_is_open && !$vb_show_only_open) {
						print "<hr/>";
					}
					
					if ($vb_show_only_is_open) {
						print "<span id='{$vs_facet_name}_facet_container'>";
					}
					switch($va_facet_info["group_mode"]){
						case "alphabetical":
						case "list":
						default:
							$vn_facet_size = sizeof($va_facet_info['content']);
							$vn_c = 0;
							$vs_show_only = "";
							foreach($va_facet_info['content'] as $va_item) {
								$vs_facet_label = $va_item['label'];
								
								$vs_show_only .= "<div class='col-sm-".$va_facet_info['column']." facetItem facetItem{$vs_facet_name}' data-facet='{$vs_facet_name}' data-facet_item_id='{$va_item['id']}'><div class='checkArea'></div>".caNavLink($this->request, ucfirst($vs_facet_label), '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
								
								if ($vb_show_only_is_open) {  $va_show_only_facets[$vs_facet_name] = true; }
							}
						break;	
						# ---------------------------------------------
					}
					
					print "{$vs_show_only}</span>";
				
					if ($va_multiple_selection_facet_list[$vs_facet_name]) {
						if ($vs_show_only && sizeof($va_show_only_facets)) {
?>
	<a href="#" id="ShowOnly_facet_apply" data-facet="<?php print join('|', array_keys($va_show_only_facets)); ?>" class="facetApply">Apply</a>
<?php						    
						 } else {
?>
	<a href="#" id="<?php print $vs_facet_name; ?>_facet_apply" data-facet="<?php print $vs_facet_name; ?>" class="facetApply">Apply</a>
<?php
                            }
					}
					if (($va_facet_info['show_only'] == 0) || $vb_show_only_close) {
						print "</div><!-- end row --></div><!-- end container --></li></ul><!-- end facetGroup -->";
						print "</div><!-- end dropdown -->";
					}
				}
				$fc++;
			}
			if(is_array($va_facets) && sizeof($va_facets)) {
				#print "<div style='height:10px;width:100%;'></div>";
			}
		}
	}
	print "</div><!-- end bRefine -->\n";
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
            
            var multiple_selection_facet_list = <?php print json_encode($va_multiple_selection_facet_list); ?>;
            
            jQuery(".facetItem").on('click', function(e) { 
                var f = jQuery(this).data('facet');
            	if (!multiple_selection_facet_list[f]) { return; }
            	if (jQuery(this).attr('facet_item_selected') == '1') {
            		jQuery(this).attr('facet_item_selected', '');
            	} else {
            	    if ((f == 'exhibited_facet') || (f == 'published_facet') || (f == 'double_facet')) {
            	        jQuery(".facetItem" + f).attr('facet_item_selected', '');
            	    }
            		jQuery(this).attr('facet_item_selected', '1');
            	}
            	
            	e.preventDefault();
            	return false;
            });
            
            jQuery(".facetApply").on('click', function(e) { 
            	var facets = jQuery(this).data('facet').split("|");
            	var facet_criteria = [];
            	
            	jQuery.each(facets, function(k, facet) { 
                    var ids = [];
                    jQuery.each(jQuery("#" + facet + "_facet_container").find("[facet_item_selected=1]"), function(k,v) {
                        ids.push(jQuery(v).data('facet_item_id'));
                    });
                    if (ids.join("|")) {
                        facet_criteria.push(facet + ":" + ids.join("|"));
                    }
            	});
            	
            	window.location = '<?php print caNavUrl($this->request, '*', '*','*', array('key' => $vs_key, 'view' => $vs_view)); ?>/facets/' + facet_criteria.join(";");
            	
            	e.preventDefault();
            });
		});
	</script>
<?php	
	#}
