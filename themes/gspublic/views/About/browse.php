<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
	$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/discover/";
	$vn_filecount = 0;
	$va_files = glob($vs_directory . "*");
	if ($va_files){
	 $vn_filecount = count($va_files);
	}
?>
	<!--<H1 class='discover'><?php print _t("Discover"); ?></H1>-->
<?php
	print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'discover/'.rand(1,$vn_filecount).'.jpg')."</div>";
?>
<div class="row">
	<div class="col-sm-12 ">
		<div class="band">
			<div>Explore the Collection</div>
		</div>
	</div>
</div>

<?php
	$o_config = caGetBrowseConfig();
	
	print '<div class="row">';
	$vs_landing_facets = $o_config->get("landing");
	foreach ($vs_landing_facets as $va_facet_type => $vs_landing_facet) {
		$t_list = new ca_lists();
		$vn_list_item_id = $t_list->getItemID('object_types', $vs_landing_facet['list_code']);
		print '<div class="col-sm-6 col-md-6">';
		print "<div class='browseTile' style='background-color:#".$vs_landing_facet['color']."'>";
		print "<div class='browseImg'>".caNavLink($this->request, caGetThemeGraphic($this->request, $vs_landing_facet['image']), '', '', 'Browse', $vs_landing_facet['table'], array('facet' => $vs_landing_facet['facet'], 'id' => $vn_list_item_id))."</div>";
		print "<div class='browseText'><h3>".caNavLink($this->request, $vs_landing_facet['label'], '', '', 'Browse', $vs_landing_facet['table'], array('facet' => $vs_landing_facet['facet'], 'id' => $vn_list_item_id))."</h3>";
		print $vs_landing_facet['description']."</div>";
		print "<div style='width:100%;clear:both;'></div>";
		print "</div><!-- end browseTile -->";
		print '</div>';
	}
	print "</div>";
	print '<div class="row">
			<div class="col-sm-12 ">
				<div class="band">
					<div>Explore Topics</div>
				</div>
			</div>
		   </div>';
	print "<div class='row'>";
	$vs_topic_facets = $o_config->get("topics");
	foreach ($vs_topic_facets as $va_facet_type => $va_topic_facet) {
		$vn_topic_id = "";
		$vs_search = "";
		if($va_topic_facet['list_code']){
			$t_topic_list = new ca_lists();
			$vn_topic_id = $t_topic_list->getItemID('local', $va_topic_facet['list_code']);
		}elseif($va_topic_facet['id']){
			$vn_topic_id = $va_topic_facet['id'];
		}elseif($va_topic_facet["search_term"]){
			$vs_search = $va_topic_facet["search_term"];
		}
		if($vn_topic_id || $vs_search){
			print '<div class="col-sm-6">';
			print "<div class='browseTile' style='background-color:#".$va_topic_facet['color']."'>";
			if($vn_topic_id){
				print "<div class='browseImg'>".caNavLink($this->request, caGetThemeGraphic($this->request, $va_topic_facet['image']), '', '', 'Browse', $va_topic_facet['table'], array('facet' => $va_topic_facet['facet'], 'id' => $vn_topic_id))."</div>";
				print "<div class='browseText'><h3>".caNavLink($this->request, $va_topic_facet['label'], '', '', 'Browse', $va_topic_facet['table'], array('facet' => $va_topic_facet['facet'], 'id' => $vn_topic_id))."</h3>";
			}else{
				print "<div class='browseImg'>".caNavLink($this->request, caGetThemeGraphic($this->request, $va_topic_facet['image']), '', '', 'Search', $va_topic_facet['table'], array('search' => $vs_search))."</div>";
				print "<div class='browseText'><h3>".caNavLink($this->request, $va_topic_facet['label'], '', '', 'Search', $va_topic_facet['table'], array('search' => $vs_search))."</h3>";
			}
			print $va_topic_facet['description']."</div>";
			print "<div style='width:100%;clear:both;'></div>";
			print "</div><!-- end browseTile -->";
			print '</div>';
		}
	}	
	print "</div>";
	
?>	


</div>