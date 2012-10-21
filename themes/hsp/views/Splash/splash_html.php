<?php
	$t_object = new ca_objects();
	
	$va_item_ids = $this->getVar('featured_content_slideshow_id_list');
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge"));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
?>
		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>

		<div id="hpFeatured">
<?php
		foreach ($va_item_media as $vn_object_id => $va_media) {
			$vs_image_tag = $va_media["tags"]["mediumlarge"];
			$vn_padding_top = 0;
			$vn_padding_top = ((450 - $va_media["info"]["mediumlarge"]["HEIGHT"]) / 2);
			print "<div><div id='featuredScroll' style='margin-top:".$vn_padding_top."px; margin-bottom:".$vn_padding_top."px;'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			print "<div id='featuredScrollCaption'>".caNavLink($this->request, $va_item_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
		}
?>
		</div>
		<div id="hpTextContainer">
			<H2>Welcome to The Historical Society of Pennsylvania's Digital Library</H2>
			<div id="hpPurchaseLink">
				<?php print caNavLink($this->request, _t("You can now purchase images in the Digital Library!"), "button", "", "About", "faq#purchase"); ?>
			</div><!-- end hpPurchaseLink -->
			<div id="hpText">
				<a href="index.php/About/faq#purchase">Please click here to learn how to purchase images</a><p>
				We invite you to explore the origins and diversity of Pennsylvania and the United States, from the colonial period and the nation's founding to the experience of contemporary life. Conduct research in the online catalogs, browse our exhibits and publications, and join us in preserving and understanding our heritage as a diverse and dynamic people.			
			</div><!-- end hpText -->
			<div id="hpBrowse">
				<div id="browseTitle"><?php print _t("Browse the collection by"); ?>:</div>
<?php
					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a>
<?php
					}
?>
			</div><!-- end hpBrowse-->
		</div><!-- end hpTextContainer -->

<script type="text/javascript">
$(document).ready(function() {
   $('#hpFeatured').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>



<?php
	if($oldHome){
?>
		<div id="hpBgBox">
			<div id="hpFeatured">
				<?php print caNavLink($this->request, $this->getVar("featured_content_mediumlarge"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?>
			</div><!-- end hpFeatured -->
			<div id="hpText">
				<div id="title">Welcome to The Historical Society of Pennsylvania's Collection Search</div><!-- end title -->
				<a href="index.php/About/faq#purchase">Please click here to learn how to purchase images</a><p>
				We invite you to explore the origins and diversity of Pennsylvania and the United States, from the colonial period and the nation's founding to the experience of contemporary life. Conduct research in the online catalogs, browse our exhibits and publications, and join us in preserving and understanding our heritage as a diverse and dynamic people.

				<div id="hpBrowse">
					<div id="browseTitle"><?php print _t("Browse the collection by"); ?>:</div>
<?php
						$va_facets = $this->getVar('available_facets');
						foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
							<a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a>
<?php
						}
?>
				</div><!-- end hpBrowse-->
			</div><!-- end hpText -->
			<div style="clear:both"><!-- empty --></div>	
		</div><!-- end hpBgBox -->
<?php
	}
?>