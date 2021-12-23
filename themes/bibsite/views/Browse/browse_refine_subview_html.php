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
	
	$vn_facet_display_length_initial = 7;
	$vn_facet_display_length_maximum = 60;
	$va_multiple_selection_facet_list = [];
	
	if(is_array($va_facets) && sizeof($va_facets)){
		print "<div id='bRefine'>";
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			$va_multiple_selection_facet_list[$vs_facet_name] = caGetOption('multiple', $va_facet_info, false, ['castTo' => 'boolean']);
			
				
			if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
			$vn_facet_size = sizeof($va_facet_info['content']);
			print "<div class='facetGroupContainer'><h3 type='button' onClick='jQuery(\"#facetGroup{$vs_facet_name}\").toggle(); jQuery(this).find(\".arrow\").toggleClass(\"rotate\"); return false; '><span class='arrow'>→</span> ".$va_facet_info['label_singular']."</H3><div id='facetGroup{$vs_facet_name}' class='facetGroupShowHide' ".(($vn_facets_with_content > 1) ? "style='display:none;'" : "").">"; 
			print "<div class='facetContainer container' id='{$vs_facet_name}_facet_container'><div class='row'>";

			$vn_c = 0;
			$vn_col = 0;
			foreach($va_facet_info['content'] as $va_item) {
				$vs_label = $va_item['label'];
				#$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
				print "<div class='".(($va_facet_info["columns"]) ? "col-md-12 col-lg-3" : "col-sm-12")." facetItem' data-facet='{$vs_facet_name}' data-facet_item_id='{$va_item['id']}'><input type='checkbox' name='".$vs_facet_name."' id='".$vs_facet_name."_".$va_item['id']."'> <label for='".$vs_facet_name."_".$va_item['id']."'>".$vs_label."</label></div>";
				$vn_c++;
				$vn_col++;
				if ($va_facet_info["columns"] && ($vn_col == 4)) {
					print "<div style='clear:both;width:100%;'></div>";
					$vn_col = 0;
				}
			}

			print "</div><!-- end row -->";
			
			if ($va_multiple_selection_facet_list[$vs_facet_name]) {
?>
				<div class="row"><div class="col-sm-12"><a href="#" id="<?php print $vs_facet_name; ?>_facet_apply" data-facet="<?php print $vs_facet_name; ?>" class="facetApply"><span class='arrow'>→</span> Apply</a></div></div>
<?php
			}
			print "</div><!-- end container --></div><!-- end facetGroup --></div><!-- end facetGroupContainer -->";
		}
		print "</div><!-- end bRefine -->\n";
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
            var multiple_selection_facet_list = <?php print json_encode($va_multiple_selection_facet_list); ?>;
            
            jQuery(".facetItem").on('click', function(e) { 
            	if (!multiple_selection_facet_list[jQuery(this).data('facet')]) { return; }
            	if (jQuery(this).attr('facet_item_selected') == '1') {
            		jQuery(this).attr('facet_item_selected', '');
            		jQuery(this).find('input').attr('checked', false);
            	} else {
            		jQuery(this).attr('facet_item_selected', '1');
            		jQuery(this).find('input').attr('checked', true);
            	}
            	
            	return false;
            });
            
            jQuery(".facetApply").on('click', function(e) { 
            	var facet = jQuery(this).data('facet');
            	
            	var ids = [];
            	jQuery.each(jQuery("#" + facet + "_facet_container").find("[facet_item_selected=1]"), function(k,v) {
            		ids.push(jQuery(v).data('facet_item_id'));
            	});
            	if(ids.length > 0){
            		window.location = '<?php print caNavUrl($this->request, '*', '*','*', array('key' => $vs_key, 'view' => $vs_view)); ?>/facet/' + facet + '/id/' + ids.join('|');
            	}
            	e.preventDefault();
            });
		});
	</script>
<?php	
	}
?>
