<div id="subnav">
<?php
	$va_facets = $this->getVar('available_facets');
	if(is_array($va_facets) && sizeof($va_facets)){
?>
	<span class="listhead"><?php print _t("Filter by"); ?></span>
	<ul>
<?php
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
			<li><a href="#" class="abFacetList" id="abFacetList<?php print $vs_facet_name; ?>" onclick='jQuery(".abFacetList").removeClass("selected"); jQuery("#abFacetList<?php print $vs_facet_name; ?>").addClass("selected"); jQuery("#facetBox").load("<?php print caNavUrl($this->request, 'eastend', 'ArtistBrowser', 'getFacet', array('target' => 'ca_entities', 'facet' => $vs_facet_name, 'view' => 'simple_list')); ?>"); return false;'><?php print $va_facet_info['label_singular']; ?></a></li>				
<?php
		}
?>
	</ul>
<?php
	}
?>	
	<div id="facetBox">
		
	</div>
</div><!--end subnav-->

<div id='contentBox' style='float:left; width:830px;'></div>
	
<?php
	$t_list_item = new ca_lists();
	$vn_individual = $t_list_item->getItemIDFromList("entity_types", "individual");
?>
<script type="text/javascript">
$(document).ready(function() {	
	//load a browse by type = individual to populate page on load
	jQuery("#contentBox").load("<?php print caNavUrl($this->request, '', 'Browse', 'clearAndAddCriteria', array('facet' => 'type_facet', 'id' => $vn_individual)); ?>");
});
</script>

