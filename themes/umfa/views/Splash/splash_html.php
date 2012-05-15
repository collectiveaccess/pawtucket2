<?php
	if($this->getVar("featured_set_id") && $this->getVar("featured_content_id")){
		# --- get the set item caption
		$t_set_item = new ca_set_items();
		$t_set_item->load(array("row_id" => $this->getVar("featured_content_id"), "set_id" => $this->getVar("featured_set_id")));
		$vs_featured_item_caption = $t_set_item->get("ca_set_items.preferred_labels");
	}
?>
		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel(); return false;" class="browseSelectPanelButton"><!-- empty --></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ 
				facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>',
				addCriteriaUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'addCriteria'); ?>',
				singleFacetValues: <?php print json_encode($this->getVar('single_facet_values')); ?>
			});
		</script>
		<div id="hpTopBox">
			<div id="hpFeatured"><?php print caNavLink($this->request, $this->getVar("featured_content_medium"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></div><!-- end hpFeatured -->
			<div id="hpText">
				<div class="title">Welcome to the UMFA's Collection Database</div>
				The Utah Museum of Fine Arts engages visitors in discovering meaningful connections with the artistic expressions of the world's cultures. Our collection of over 18,000 objects includes paintings, works on paper, photography, sculpture, and mixed media objects from artists around the world.
				
				<form name="search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
					<div id="hpSearch">
						search the collection: <input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onfocus='jQuery("#quickSearch").val("");' id="quickSearch"  autocomplete="off" size="100"/><a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;">GO</a>
					</div>
				</form>
				<div id="hpSearchCaption">Enter a keyword or artist name and suggested search terms will drop-down.</div>
<?php
				if($vs_featured_item_caption){
?>
				<div id="featuredCaption">Left: <i><?php print $vs_featured_item_caption; ?></i></div><!-- end featuredCaption -->
<?php
				}
?>
			</div><!-- end hpText -->
			<div style="clear:both;"><!-- empty --></div>
		</div><!-- end hpTopBox -->
		

		<div id="quickLinkItems">
			<div id="hpBrowse">
				<div class="title"><?php print _t("Quickly browse by"); ?>:</div>
				<div class="links">
<?php
					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>"); return false;'><?php print $va_facet_info['label_singular']; ?></a><br/>
<?php
					}
?>
					<div style="margin-top:10px;" class="caption">
					<?php print _t("Or click ").caNavLink($this->request, _t("here"), "", "", "Browse", "clearCriteria")._t(" to conduct a refined browse"); ?>
				</div>
				</div>
			</div><!-- end hpBrowse-->
			<div class="quickLinkItem">
				<div class="title"><?php print _t("User favorites"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("user_favorites_preview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("user_favorites_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("Go to user favorites &gt;"), "more", "", "Favorites", "index"); ?></div>
			</div>
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Most viewed"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("most_viewed_preview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("most_viewed_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("Go to most viewed &gt;"), "more", "", "Favorites", "index"); ?></div>
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<div class="title"><?php print _t("New acquisitions"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_added_preview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("recently_added_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("Go to new aquisitions &gt;"), "more", "", "Favorites", "index"); ?></div>
			</div>
		</div><!-- end quickLinkItems -->