<?php
/* ----------------------------------------------------------------------
 * Browse/facet_hierarchy_level_html.php : 
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
	$va_facet_list = 		$this->getVar('facet_list');
	$vs_facet_name = 		$this->getVar("facet_name");
	$vs_key = 				$this->getVar("key");
	$vs_browse_type = 		$this->getVar("browse_type");
	$vs_link_to = 			$this->request->getParameter('linkTo', pString);
	$vb_is_nav = 			(bool)$this->getVar('isNav');
	
	$va_links = array();
	
	foreach($va_facet_list as $vn_key => $va_facet){
		foreach($va_facet as $vn_id => $va_children){
			if (!is_array($va_children)) { continue; }
			
			$vs_content_count = (isset($va_children['content_count']) && ($va_children['content_count'] > 0)) ? " (".$va_children['content_count'].")" : "";
			$vs_name = caTruncateStringWithEllipsis($va_children["name"], 75);
			
			if(isset($vs_name)){
				$vs_buf = "<div ".($vb_is_nav ? "class='browseFacetItem browseFacetHierarchyItem col-sm-6 col-md-4'" : "").">";
				if($vs_link_to == "morePanel"){
					if((int)$va_children["children"] > 0){
						$vs_buf .= "<a href='#' data-item_id='{$vn_id}' class='caSubItems caSubItem{$vs_facet_name}' title='".addslashes(_t('View sub-items'))."'>{$vs_name}</a>";
					}else{
						$vs_buf .= caNavLink($this->request, $vs_name.$vs_content_count, '', '*', '*', $vs_browse_type, array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $vn_id, 'isNav' => $vb_is_nav ? 1 : 0));
					}
				}else{
					$vs_buf .= caNavLink($this->request, $vs_name.$vs_content_count, '', '*', '*', $vs_browse_type, array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $vn_id, 'isNav' => $vb_is_nav ? 1 : 0));
					if((int)$va_children["children"] > 0){
						$vs_buf .= ' <a href="#" title="'._t('View sub-items').'" onClick=\'jQuery("#bHierarchyList'.(($vs_link_to) ? '' : 'MorePanel').'_'.$vs_facet_name.(($vb_is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'key' => $vs_key, 'browseType' => $vs_browse_type, 'id' => $vn_id, 'isNav' => $vb_is_nav ? 1 : 0)).'"); jQuery(".bAncestorList_'.$vs_facet_name.(($vb_is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'id' => $vn_id, 'isNav' => $vb_is_nav ? 1 : 0)).'"); return false;\'><span class="glyphicon glyphicon-chevron-down"></span></a>';
					}
				}
				$vs_buf .= "</div>";
				$va_links[mb_strtolower($va_children["name"])] = $vs_buf;
			}
		}
	}

	if ($vb_is_nav) { print "<div class='row'>"; }
	if(sizeof($va_links)){
		ksort($va_links);
		print join($va_links, "\n");
	}
	if ($vb_is_nav) { print "</div>\n"; }
	if($vs_link_to == "morePanel"){
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".caSubItem<?php print $vs_facet_name; ?>").on('click', function(e) {
			jQuery('#bMorePanel').load('<?php print caNavUrl($this->request, '*', '*', $vs_browse_type); ?>', { getFacet: 1, facet: '<?php print $vs_facet_name; ?>', view: '<?php print $vs_view; ?>', key: '<?php print $vs_key; ?>', browseType: '<?php print $vs_browse_type; ?>', id: jQuery(this).data('item_id'), isNav: <?php print $vb_is_nav ? 1 : 0; ?>}, 
				function(){jQuery("#bMorePanel").show(); 
				jQuery("#bMorePanel").mouseleave(function(){
					jQuery("#bMorePanel").hide();
				});
			}); 
			return false;
		});
	});
</script>
<?php
	}
?>
