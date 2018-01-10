<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");

	print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'discover/'.rand(1,1).'.jpg')."</div>";
?>

<H1><?php print _t("Discover"); ?></H1>
<div class="row">
	<div class="col-sm-12">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent augue nunc, gravida a augue non, tincidunt sagittis justo. Phasellus euismod, elit ac condimentum elementum, ante nisl blandit lorem, sit amet malesuada odio enim id urna. Fusce egestas lacus at pellentesque tristique. In id purus eget metus pellentesque mattis ut ac ligula. Phasellus eu luctus neque. Fusce sagittis condimentum condimentum. Donec ut nunc porttitor, volutpat ligula ut, fermentum nisi. Quisque at hendrerit tortor.</p>
	</div>
</div>
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
		print '<div class="col-sm-6">';
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
	foreach ($vs_topic_facets as $va_facet_type => $vs_topic_facet) {
		$t_topic_list = new ca_lists();
		$vn_topic_list_item_id = $t_topic_list->getItemID('local', $vs_topic_facet['list_code']);
		print '<div class="col-sm-6">';
		print "<div class='browseTile' style='background-color:#".$vs_topic_facet['color']."'>";
		print "<div class='browseImg'>".caNavLink($this->request, caGetThemeGraphic($this->request, $vs_topic_facet['image']), '', '', 'Browse', $vs_topic_facet['table'], array('facet' => $vs_topic_facet['facet'], 'id' => $vn_topic_list_item_id))."</div>";
		print "<div class='browseText'><h3>".caNavLink($this->request, $vs_topic_facet['label'], '', '', 'Browse', $vs_topic_facet['table'], array('facet' => $vs_topic_facet['facet'], 'id' => $vn_topic_list_item_id))."</h3>";
		print $vs_topic_facet['description']."</div>";
		print "<div style='width:100%;clear:both;'></div>";
		print "</div><!-- end browseTile -->";
		print '</div>';
	}	
	print "</div>";
	
?>	


</div>