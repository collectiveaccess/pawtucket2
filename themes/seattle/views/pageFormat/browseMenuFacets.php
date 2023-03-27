<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/browseMenuFacets.php : 
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
 <a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/objects/facet/type_facet/id/28/view/list'>Audio</a>
 <a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/Objects/facet/type_facet/id/24/view/list'>Moving Images</a>
 */
 
	$vs_target = $this->getVar("target");
	$vs_name = $this->getVar("browse_name");
	$vs_facet_list = caGetFacetForMenuBar($this->request, $vs_target);
	
if($vs_facet_list) {
?>			
	<div style="padding:25px;">
		
		<ul>
			<?php print "<h1><a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/Objects'> All Objects</a>

			<a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/Objects/facet/type_facet/id/23/view/images'>Images</a>
			<a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/Objects/facet/type_facet/id/26/view/images'>Maps</a>
			
			<a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/Objects/facet/type_facet/id/25/view/list'>Textual Records</a>
			<a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/People'>People/Organizations</a>
			<a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/Collections/facet/type_facet/id/116/view/images'>Series</a>
			
			<a style='padding-right:15px;' href='".__CA_URL_ROOT__."/index.php/Browse/Collections/facet/type_facet/id/112/view/images'>Virtual Collections</a></h1>"; ?> 
		</ul>
	</div>
<?php
	} else {
		print _t('No facets available');
	}
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#browseMenuFacetSearchInput").on("keyup", function(e) {
			var s = jQuery(this).val().toLowerCase();
			jQuery(".browseMenuFacet div.browseFacetItem").each(function(k, v) {
				var item = jQuery(v).find("a").text().toLowerCase();
				(item.indexOf(s) == -1) ? jQuery(v).hide() : jQuery(v).show();
			});
		}).on("focus click", function(e) { jQuery(this).val("").trigger("keyup"); });
	});
</script>
