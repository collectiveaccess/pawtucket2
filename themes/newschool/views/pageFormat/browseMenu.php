 <li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse</a>
	<ul class="dropdown-menu dropdown-browse-menu yamm-fw">
		<li class="browseNavFacet">
<?php
	$vs_facet_list = caGetFacetForMenuBar($this->request);
	
	if($vs_facet_list) {
?>
	<div class="browseMenuContent">
		<ul class="nav nav-pills browseMenuFacetList">
			<?php print $vs_facet_list; ?>
		</ul>
	
		<div class='browseMenuFacet'> </div>
		
		<div class='browseMenuBrowseSearch'><form><input type="text" size="20" id="browseMenuFacetSearchInput" class="browseMenuFacetSearchInput form-control" placeholder="Search facet"/></form></div>
		<div class='browseMenuBrowseAll'><?php print caNavLink($this->request, _t('Browse all'), 'browseMenuBrowseAll', '', 'Browse', 'Objects', ''); ?> &gt; </div>
	</div>
<?php
	} else {
?>
		No facets available
<?php
	}
?>
		</li>
	</ul> <!--end dropdown browse menu -->
 </li>

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
