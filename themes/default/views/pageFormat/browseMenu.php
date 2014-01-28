<?php
	$va_browse_types = caGetBrowseTypes();
	if(sizeof($va_browse_types)){
?>
 <li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print _t("Browse"); ?></a>
	<ul class="dropdown-menu dropdown-browse-menu yamm-fw">
		<li class="browseNavFacet">
			<div class="browseMenuContent">
<?php
		if(sizeof($va_browse_types) > 1){
			# --- only show browse targets if there are more than one
?>
		<ul class="nav nav-pills browseMenuFacetList">
			<li><div><?php print _t("Browse for:"); ?></div></li>
<?php
			foreach($va_browse_types as $vs_browse_name => $va_browse_type){
				#print "<li><a href='#'>".$vs_browse_name."</a></li>";
				print "<li ".((!$vs_first_browse_name) ? "class='active'" : "")."><a href='#' onclick='jQuery(\"#browseMenuTypeFacet\").load(\"".caNavUrl($this->request, '*', 'Browse', 'getBrowseNavBarByTarget', array('target' => $vs_browse_name))."\"); jQuery(this).parent().siblings().removeClass(\"active\"); jQuery(this).parent().addClass(\"active\"); return false;'>".caUcFirstUTF8Safe($vs_browse_name)."</a></li>";
				if(!$vs_first_browse_name){
					$vs_first_browse_name = $vs_browse_name;
				}
			}
?>
		</ul>
<?php
		}
?>
			<div id="browseMenuTypeFacet"></div>
			</div><!-- end browseMenuContent -->
		</li><!-- end browseNavFacet -->
	</ul> <!--end dropdown-browse-menu -->
 </li><!-- end dropdown -->

	<script type="text/javascript">
		jQuery(document).ready(function() {		
			jQuery("#browseMenuTypeFacet").load("<?php print caNavUrl($this->request, '*', 'Browse', 'getBrowseNavBarByTarget', array('target' => $vs_first_browse_name)); ?>");
		});
	</script>
<?php	
	}
?>