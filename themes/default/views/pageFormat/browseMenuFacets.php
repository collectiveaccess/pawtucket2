<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/browseMenuFacets.php : 
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
 
	$vs_target = $this->getVar("target");
	$vs_facet_list = caGetFacetForMenuBar($this->request, $vs_target);
	
	if($vs_facet_list) {
?>
		<ul class="nav nav-pills browseMenuFacetList">
			<li><div><?php print _t("Browse by:"); ?></div></li>
			<?php print $vs_facet_list; ?>
		</ul>
	
		<div class='browseMenuFacet'> </div>
		
		<div class='browseMenuBrowseSearch'><form><input type="text" size="20" id="browseMenuFacetSearchInput" class="browseMenuFacetSearchInput form-control" placeholder="Search facet"/></form></div>
		<div class='browseMenuBrowseAll'><button class="btn btn-default"><?php print caNavLink($this->request, _t('Browse all'), 'browseMenuBrowseAll', '', 'Browse', $vs_target, ''); ?></button></div>
<?php
	} else {
?>
		No facets available
<?php
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
