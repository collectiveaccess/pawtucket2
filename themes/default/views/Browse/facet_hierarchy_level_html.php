<?php
/* ----------------------------------------------------------------------
 * Browse/facet_hierarchy_level_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2026 Whirl-i-Gig
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
$facet_list = 		$this->getVar('facet_list');
$facet_name = 		$this->getVar("facet_name");
$key = 				$this->getVar("key");
$browse_type = 		$this->getVar("browse_type");
$link_to = 			$this->request->getParameter('linkTo', pString);
$is_nav = 			(bool)$this->getVar('isNav');

$links = [];

foreach($facet_list as $key => $facet){
	foreach($facet as $id => $children){
		if (!is_array($children)) { continue; }
		
		$content_count = (isset($children['content_count']) && ($children['content_count'] > 0)) ? " (".$children['content_count'].")" : "";
		$name = caTruncateStringWithEllipsis($children["name"], 75);
		
		if(isset($name)){
			$buf = "<div ".($is_nav ? "class='browseFacetItem browseFacetHierarchyItem col-sm-6 col-md-4'" : "").">";
			if($link_to == "morePanel"){
				if((int)$children["children"] > 0){
					$buf .= "<a href='#' data-item_id='{$id}' class='caSubItems caSubItem{$facet_name}' title='".addslashes(_t('View sub-items'))."'>{$name}</a>";
				} else {
					$buf .= caNavLink($this->request, $name.$content_count, '', '*', '*', $browse_type, array('key' => $key, 'facet' => $facet_name, 'id' => $id, 'isNav' => $is_nav ? 1 : 0));
				}
			} else {
				$buf .= caNavLink($this->request, $name.$content_count, '', '*', '*', $browse_type, array('key' => $key, 'facet' => $facet_name, 'id' => $id, 'isNav' => $is_nav ? 1 : 0));
				if((int)$children["children"] > 0){
					$buf .= ' <a href="#" title="'._t('View sub-items').'" onClick=\'jQuery("#bHierarchyList'.(($link_to) ? '' : 'MorePanel').'_'.$facet_name.(($is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $facet_name, 'key' => $key, 'browseType' => $browse_type, 'id' => $id, 'isNav' => $is_nav ? 1 : 0)).'"); jQuery(".bAncestorList_'.$facet_name.(($is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $facet_name, 'browseType' => $browse_type, 'key' => $key, 'id' => $id, 'isNav' => $is_nav ? 1 : 0)).'"); return false;\'><span class="glyphicon glyphicon-chevron-down"></span></a>';
				}
			}
			$buf .= "</div>";
			$links[mb_strtolower($children["name"])] = $buf;
		}
	}
}

if ($is_nav) { print "<div class='row'>"; }
if(sizeof($links)){
	ksort($links);
	print join("\n", $links);
}
if ($is_nav) { print "</div>\n"; }
if($link_to == "morePanel"){
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery(".caSubItem<?php print $facet_name; ?>").on('click', function(e) {
		jQuery('#bMorePanel').load('<?php print caNavUrl($this->request, '*', '*', $browse_type); ?>', { getFacet: 1, facet: '<?php print $facet_name; ?>', view: '<?php print $view; ?>', key: '<?php print $key; ?>', browseType: '<?php print $browse_type; ?>', id: jQuery(this).data('item_id'), isNav: <?php print $is_nav ? 1 : 0; ?>}, 
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
